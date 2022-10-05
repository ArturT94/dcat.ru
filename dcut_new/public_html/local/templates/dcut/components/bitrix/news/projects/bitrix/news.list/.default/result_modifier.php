<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*TODO:Саня надо переделать на картинку для анонса PREVIEW_PICTURE, а не webp */
if($arResult['ITEMS']){
    /*foreach($arResult['ITEMS'] as $key=>$arItem){
        $arResult['ITEMS'][$key]['WEBP'] = CFile::GetPath($arItem["PROPERTIES"]["WEBP"]["VALUE"]);
    }*/
    $all_count = 0;
    $arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'GLOBAL_ACTIVE'=>'Y', 'CNT_ACTIVE'=>'Y');
    $db_list = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, true,array('ID','NAME','IBLOCK_ID','CODE','SECTION_PAGE_URL'));
    while($ar_result = $db_list->GetNext()) {
        $all_count = $all_count + $ar_result['ELEMENT_CNT'];
        $arResult['SECTIONS'][] = $ar_result;
    }
    $arResult['ALL_SECTION_CNT'] = $all_count;
}
?>
