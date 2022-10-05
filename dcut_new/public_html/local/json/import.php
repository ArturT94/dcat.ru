<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
use Bitrix\Catalog\Product;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = file_get_contents("php://input");

    Bitrix\Main\Loader::IncludeModule('iblock');
    Bitrix\Main\Loader::IncludeModule('catalog');
    $CATALOG_ID = 11;
    $OFFER_ID = 33;
    $arImport = json_decode($data);

    $arProducts = $arImport->Body->Products;
    AddMessage2Log('$data = '.print_r($arProducts, true),'');

    if($arProducts){
        $arAllSections = [];
        $obElement = new \CIBlockElement();
        $obSection = new \CIBlockSection();
        $arCatalogProduct = new \CCatalogProduct();

        $arSelect = Array("ID", "NAME",'IBLOCK_ID','XML_ID','UF_GUID');
        $arFilter = Array("IBLOCK_ID"=>$CATALOG_ID);
        $res = $obSection::GetList(Array(), $arFilter, false, $arSelect);
        while($ob = $res->Fetch()){
            $arAllSections[$ob['UF_GUID']] = $ob['ID'];
        }

        $arSections = $arImport->Body->Products_Section;
        if($arSections){
            foreach($arSections as $section){
                $sectionId = addUpdateSection($section,$arAllSections);
                $arAllSections[$section->GUID] = $sectionId;
            }
        }

        $arSelect = Array("ID", "NAME",'IBLOCK_ID','XML_ID','IBLOCK_SECTION_ID','PROPERTY_GUID');
        $arFilter = Array("IBLOCK_ID"=>$CATALOG_ID);
        $res = $obElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()){
            $arAllProduct[$ob['PROPERTY_GUID_VALUE']] = $ob['ID'];
        }

        foreach($arProducts as $arItem){
            unset($parentSectionAll);
            unset($arFields,$arProps);
            if($arImport->Header->Data_Type == 'Products' || $arImport->Header->Data_Type == 'updatePictures'){
                $arProps = array(
                    'GUID' => $arItem->GUID,
                    'PRICE' => $arItem->Properties->Price,
                    'OLD_PRICE' => $arItem->Properties->SecondPrice,
                    'PRICE_DATE' => $arItem->Properties->PriceDate,
                    'QUANTITY' => $arItem->Properties->QuantityOfStock,
                    'EXCLUSIVE' => $arItem->Properties->ExclusiveB2B,
                    'NEW' => $arItem->Properties->NewProduct,
                    'POPULAR' => $arItem->Properties->Popular,
                    'BRAND' => $arItem->Properties->Brand,
                    'SEASONAL' => $arItem->Properties->Seasonal,
                    'PATH' => $arItem->Properties->PathFTPImageFile,
                    'CML2_ARTICLE' => $arItem->Article_Number,
                    'PRICE_GROUP' => $arItem->Price_Group,
                );
                if($arItem->Section_GUID){
                    foreach($arItem->Section_GUID as $sec){
                        $parentSection = $arAllSections[$sec];
                        $parentSectionAll[] = $arAllSections[$sec];
                    }
                }
            }

            unset($arFile);
            AddMessage2Log('$data = '.print_r('2', true),'');
            if($arItem->Properties->PathFTPImageFile){
                $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/upload/1c/".$arItem->Properties->PathFTPImageFile);
            }
            AddMessage2Log('$data = '.print_r('1', true),'');
            if($arImport->Header->Data_Type == 'Products' || $arImport->Header->Data_Type == 'updatePictures'){
                if($arItem->Properties->PathFTPImageFile){
                    $arFields = array(
                        'IBLOCK_ID' => $CATALOG_ID,
                        'XML_ID' => $arItem->GUID,
                        'IBLOCK_SECTION_ID' => $parentSection,
                        'NAME' => $arItem->Name,
                        'CODE' => \CUtil::translit($arItem->Name, 'ru'),
                        'ACTIVE' => 'Y',
                        'PREVIEW_PICTURE' => $arFile,
                        'PREVIEW_TEXT' => $arItem->Full_Name,
                        'DETAIL_TEXT' => $arItem->Description,
                        'PROPERTY_VALUES' => $arProps,
                    );
                }else{
                    if($arImport->Header->Data_Type == 'Price'){
                        $arFields = array(
                            'IBLOCK_ID' => $CATALOG_ID,
                            'XML_ID' => $arItem->GUID,
                            'NAME' => $arItem->Name,
                            'CODE' => \CUtil::translit($arItem->Name, 'ru'),
                            'ACTIVE' => 'Y',
                        );
                    }else{
                        $arFields = array(
                            'IBLOCK_ID' => $CATALOG_ID,
                            'XML_ID' => $arItem->GUID,
                            'IBLOCK_SECTION_ID' => $parentSection,
                            'NAME' => $arItem->Name,
                            'CODE' => \CUtil::translit($arItem->Name, 'ru'),
                            'ACTIVE' => 'Y',
                            'PREVIEW_TEXT' => $arItem->Full_Name,
                            'DETAIL_TEXT' => $arItem->Description,
                            'PROPERTY_VALUES' => $arProps,
                        );
                    }
                }
            }else{
                $arFields = array(
                    'IBLOCK_ID' => $CATALOG_ID,
                    'XML_ID' => $arItem->GUID,
                    'IBLOCK_SECTION_ID' => $parentSection,
                    'NAME' => $arItem->Name,
                    'CODE' => \CUtil::translit($arItem->Name, 'ru'),
                    'ACTIVE' => 'Y',
                    'PREVIEW_TEXT' => $arItem->Full_Name,
                    'DETAIL_TEXT' => $arItem->Description,
                );
            }

            if($arImport->Header->Data_Type == 'Products'){
                if($arAllProduct[$arItem->GUID]){
                    //обновление товара
                    $obElement->Update($arAllProduct[$arItem->GUID],$arFields);
                    $newId = $arAllProduct[$arItem->GUID];
    //                echo "1. Обновили товар ID = ".$arAllProduct[$arItem->GUID].'<br />';
                    AddMessage2Log('Обновили товар ID '.print_r($newId, true),'');
                }else{
                    //создание товара
                    $newId = $obElement->Add($arFields);
                    if($newId){
                        $arCatalogProduct::Add(array("ID"=>$newId,'QUANTITY' => $arItem->Properties->QuantityOfStock, 'SUBSCRIBE' => 'D'));
                    }
                    AddMessage2Log('Создали товар ID '.print_r($newId, true),'');
                }
            }

            if($arItem->Properties->QuantityOfStock){
                $arCatalogProduct::Update($newId, array('QUANTITY' => $arItem->Properties->QuantityOfStock, 'SUBSCRIBE' => 'D'));
            }
            if($arItem->Properties->Price){
                $arFields = Array("PRODUCT_ID" => $newId,"CATALOG_GROUP_ID" => 1,"PRICE" => $arItem->Properties->Price,"CURRENCY" => "RUB");
                $res = \CPrice::GetList(array(),array("PRODUCT_ID" => $newId,"CATALOG_GROUP_ID" => 1));
                if ($arr = $res->Fetch()){
                    CPrice::Delete($arr['ID']);
//                    \CPrice::Update($arr['ID'], $arFields);
                    AddMessage2Log('Удалили цену '.print_r($arr, true),'');

                    \CPrice::Add($arFields);
                    AddMessage2Log('Создали  цену  '.print_r($arFields, true),'');
                }else{
                    \CPrice::Add($arFields);
                    AddMessage2Log('Создали  цену  '.print_r($arFields, true),'');
                }
            }

            if($arItem->Properties->PathFTPImageFile){
                unlink($_SERVER["DOCUMENT_ROOT"]."/upload/1c/".$arItem->Properties->PathFTPImageFile);
            }
            if(count($parentSectionAll)>1){
                $obElement::SetElementSection($newId, $parentSectionAll);
            }
        }
    }
    echo json_encode('good');
}



function addUpdateSection($arSection,$arAllSections){
    $CATALOG_ID = 11;
    $obSection = new \CIBlockSection();
    $arFields = array(
        'IBLOCK_ID' => $CATALOG_ID,
        'XML_ID' => $arSection->GUID,
        'UF_GUID' => $arSection->GUID,
        'IBLOCK_SECTION_ID' => $arAllSections[$arSection->Parent_GUID],
        'NAME' => $arSection->Name,
        'CODE' => \CUtil::translit($arSection->Name, 'ru'),
//        'CODE' => $arSection->Code,
        'ACTIVE' => 'Y',
    );
    if($arAllSections[$arSection->GUID]){
        //обновление раздела
        $newId = $arAllSections[$arSection->GUID];
        $obSection->Update($arAllSections[$arSection->GUID],$arFields);
//        echo "1. Обновили раздел ID = ".$arAllSections[$arSection->GUID].'<br />';
    }else{
        //создание раздела
        $newId = $obSection->Add($arFields);
        $arAllSections[$arSection->GUID] = $newId;
//        if($newId){echo "2. Создали раздел ID = ".$newId.'<br />';}else{echo "2. Ошибка: ".$obSection->LAST_ERROR.'<br />';}
    }
    return $newId;
}