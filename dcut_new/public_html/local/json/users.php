<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
use Bitrix\Catalog\Product;


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo json_encode('start');
    $data = file_get_contents("php://input");

    Bitrix\Main\Loader::IncludeModule('iblock');
    $CATALOG_ID = 13;
    $arImport = json_decode($data);

    $arUsers = $arImport->Body->PersonalAccounts;
//    AddMessage2Log('$data = '.print_r($arImport, true),'');
    //AddMessage2Log('$data = '.print_r($arUsers, true),'');
    //if($arImport->Header->Data_Type == 'PersonalAccount'){
        if($arUsers){
            $obElement = new \CIBlockElement();

            $arSelect = Array("ID", "NAME",'IBLOCK_ID','PROPERTY_GUID');
            $arFilter = Array("IBLOCK_ID"=>13);
            $res = $obElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()){
                $allUsers[$ob['PROPERTY_GUID_VALUE']] = $ob['ID'];
            }

            $arSelect = Array("ID", "NAME",'IBLOCK_ID','PROPERTY_GUID');
            $arFilter = Array("IBLOCK_ID"=>17);
            $res = $obElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()){
                $allContragents[$ob['PROPERTY_GUID_VALUE']] = $ob['ID'];
            }
            foreach($arUsers as $arItem){
                $name = $arItem->Name;
                if(!$name){
                    $name = $arItem->ContactPerson->Name;
                }
                AddMessage2Log('$data = '.print_r($arItem, true),'');
                unset($arFields,$arProps,$userId);
                AddMessage2Log('$data = '.print_r(1111, true),'');

//                if(!$allUsers[$arItem->GUID]){
                    unset($curUser);
                    $rsUsers = CUser::GetList(($by = "id"), ($order_sort = "desc"), array("UF_GUID" => $arItem->GUID));
                    while ($arUser = $rsUsers->GetNext()) {
                        $curUser = $arUser;
                    }
                AddMessage2Log('$curUser = '.print_r($curUser, true),'');
//                    //$pass = gen_password();
                    $pass = '95mBT$N49xXd';


                    if (!$curUser) {
                        $user = new CUser;
                        $arFields = array(
                            "NAME" => $name,
                            "EMAIL" => trim($arItem->email),
                            "LOGIN" => trim($arItem->email),
                            "LID" => "s1",
                            "ACTIVE" => "Y",
                            "UF_GUID" => $arItem->GUID,
                            "GROUP_ID" => array(3, 4),
                            "PASSWORD" => $pass,
                            "CONFIRM_PASSWORD" => $pass,
                        );
                        $userId = $user->Add($arFields);
                    } else {
                        $arFields = array(
                            "NAME" => $name,
                            "EMAIL" => trim($arItem->email),
                            "LOGIN" => trim($arItem->email),
                            "LID" => "s1",
                            "ACTIVE" => "Y",
                            "UF_GUID" => $arItem->GUID,
                            "GROUP_ID" => array(3, 4),
                        );
                        $userId = $curUser['ID'];
                        AddMessage2Log('user_info = '.print_r($arFields, true),'');
//                        $user->Update($curUser['ID'],$arFields);
                        AddMessage2Log('user_error = '.print_r($user->LAST_ERROR, true),'');
                    }
//                }else{
//                    $userId = $allUsers[$arItem->GUID];
//                }
                AddMessage2Log('$arFields = '.print_r($arFields, true),'');
                AddMessage2Log('11111111 = '.print_r(2222222222, true),'');
                if($arItem->Customers){
                    AddMessage2Log('Customers = '.print_r($arItem->Customers, true),'');
                    foreach($arItem->Customers as $customers){
                        AddMessage2Log('$customers = '.print_r($customers, true),'');
                        $manager = array(
                            'NAME'=>  $customers->Manager->name,
                            'EMAIL'=>  $customers->Manager->email,
                            'PHONE'=>  $customers->Manager->phone
                        );
                        $arProps2 = array(
                            'GUID_PARENT' => $arItem->GUID,
                            'GUID' => $customers->GUID,
                            'NAME' => $customers->Name,
                            'INN' => $customers->INN,
                            'KPP' => $customers->KPP,
                            'MAIN' => $customers->MAIN,
                            'MANAGER_NAME' => $customers->Manager->name,
                            'MANAGER_EMAIL' => $customers->Manager->email,
                            'MANAGER_PHONE' => $customers->Manager->phone,
                            'ADRESS_COMPANY' => $arImport->Body->Adress,
                        );
                        $arFields2 = array(
                            'IBLOCK_ID' => 17,
                            'NAME' => $customers->Name,
                            'ACTIVE' => 'Y',
                            "PROPERTY_VALUES"=> $arProps2,
                        );
                        if($allContragents[$customers->GUID]){
                            $obElement->Update($allContragents[$customers->GUID],$arFields2);
                        }else{
                            $newId = $obElement->Add($arFields2);
                        }
                    }
                }
                if($arItem->Indicators){
                    foreach ($arItem->Indicators as $key=>$item){
                        $arrVal = array(
                            "VALUE" => $item->Name,
                            "DESCRIPTION" => $item->GUID,
                        );
                        $arPropVal[$key] = $arrVal;
                    }
                }

                $arProps = array(
                    'GUID' => $arItem->GUID,
                    'PROP2' => $name,
                    'PROP3' => $arItem->ContactPerson->Name,
                    'PROP4' => $arItem->ContactPerson->Post,
                    'PROP5' => $arItem->ContactPerson->Birthday,
                    'PROP6' => $arItem->FieldOfActivity,
                    'PROP7' => $arItem->CompanySize,
                    'PROP8' => $arItem->Address,
                    'PROP9' => $arItem->PostalCode,
                    'PROP10' => $arItem->Website,
                    'PROP11' => $arItem->INN,
                    'PROP12' => $arItem->KPP,
                    'PROP13' => $arItem->OGRN,
                    'PROP14' => $arItem->BankAccount->BIK,
                    'PROP15' => $arItem->BankAccount->Account,
                    'MANAGER_NAME' => $manager['NAME'],
                    'MANAGER_MAIL' => $manager['EMAIL'],
                    'MANAGER_PHONE' => $manager['PHONE'],
                    'USER' => $userId,
                    'INDICATOR' => $arPropVal,
                );

                $arFields = array(
                    'IBLOCK_ID' => $CATALOG_ID,
                    'XML_ID' => $arItem->GUID,
                    'NAME' => $name,
                    'CODE' => \CUtil::translit($name, 'ru'),
                    'ACTIVE' => 'Y',
                    "PROPERTY_VALUES"=> $arProps,
                );

                if($allUsers[$arItem->GUID]){
                    $obElement->Update($allUsers[$arItem->GUID],$arFields);
                    AddMessage2Log('Обновили лк ID '.print_r($allUsers[$arItem->GUID], true),'');
                    AddMessage2Log('ошибки '.print_r($obElement->LAST_ERROR, true),'');
                }else{
                    $newId = $obElement->Add($arFields);
                    AddMessage2Log('Создали лк ID '.print_r($obElement->LAST_ERROR, true),'');
                    AddMessage2Log('ошибки '.print_r($newId, true),'');
                }
            }
        //}
//        echo json_encode('good');
        echo json_encode('end');
    }else{
        echo json_encode('bad');
    }
}