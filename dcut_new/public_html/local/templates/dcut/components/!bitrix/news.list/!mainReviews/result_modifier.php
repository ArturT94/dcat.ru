<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


if($arResult['ITEMS']){
    $arResult['COUNT'] = $arResult['ALL_RATING'] = 0;
    $arSelect = Array("ID", "NAME", "CODE", "PREVIEW_TEXT",'PREVIEW_PICTURE','PROPERTY_RATING');
    $arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->Fetch()) {
        $arResult['ALL_RATING'] = $arResult['ALL_RATING']+$ob['PROPERTY_RATING_VALUE'];
        $arResult['COUNT']++;
    }

    foreach($arResult['ITEMS'] as $arItem){
        if($arItem['PROPERTIES']['PRODUCT']['VALUE']){
            $arResult['PRODUCTS_ID'][$arItem['PROPERTIES']['PRODUCT']['VALUE']] = $arItem['PROPERTIES']['PRODUCT']['VALUE'];
        }
    }

    if($arResult['PRODUCTS_ID']){
        $arSelect = Array("ID", "NAME", "CODE", "PREVIEW_TEXT",'PREVIEW_PICTURE');
        $arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$arResult['PRODUCTS_ID'], "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()) {
            if($ob['PREVIEW_PICTURE']){
                $ob['PREVIEW_PICTURE'] = CFile::GetPath($ob['PREVIEW_PICTURE']);
            }
            $ar_res = CPrice::GetBasePrice($ob['ID']);
            $ob['PRICE'] = $ar_res["PRICE"];
            $arResult['PRODUCTS'][$ob['ID']] = $ob;
        }
    }
}