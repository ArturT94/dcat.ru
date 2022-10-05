<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['ITEMS']){
    foreach($arResult['ITEMS'] as $i=>$arItem){
        if($arItem['PREVIEW_PICTURE']){
            $resize = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width' => 236, 'height' => 236), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            $arResult["ITEMS"][$i]["PREVIEW_PICTURE"]['SRC'] = $resize['src'];
        }
        $arIds[] = $arItem['ID'];
        $arSectionId[$arItem['IBLOCK_SECTION_ID']] = $arItem['IBLOCK_SECTION_ID'];
    }
}
$cp = $this->__component;
if (is_object($cp))
{
    $cp->arResult["IDS"] = $arIds;
    $cp->SetResultCacheKeys(array("IDS"));
}

if($_REQUEST['q']){
    if($arSectionId){
        $arFilter = Array('IBLOCK_ID'=>CATALOG_IBLOCK_ID, 'GLOBAL_ACTIVE'=>'Y', 'ID'=>$arSectionId);
        $db_list = CIBlockSection::GetList(Array(), $arFilter, false,array('ID','CODE'));
        while($ar_result = $db_list->Fetch()){
            $arSection[$ar_result['ID']] = $ar_result['CODE'];
        }

        foreach($arResult['ITEMS'] as $key=>$arItem){
            if($arSection[$arItem['IBLOCK_SECTION_ID']]){
                $arResult['ITEMS'][$key]['DETAIL_PAGE_URL'] = '/catalog/'.$arSection[$arItem['IBLOCK_SECTION_ID']].'/'.$arItem['CODE'].'/';
            }
        }
    }
}