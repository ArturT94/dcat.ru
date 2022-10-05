<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


if($arResult['PROPERTIES']['SERVICES_PHOTO']['VALUE']){
    foreach($arResult['PROPERTIES']['SERVICES_PHOTO']['VALUE'] as $key=>$photo){
        $arResult["SERVICES_PHOTO"][$key]['BIG'] = CFile::ResizeImageGet($photo, array('width'=>1024, 'height'=>1024), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $arResult["SERVICES_PHOTO"][$key]['SMALL'] = CFile::ResizeImageGet($photo, array('width'=>270, 'height'=>270), BX_RESIZE_IMAGE_EXACT, true);
    }
}