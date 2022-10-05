<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
    foreach($arResult["ITEMS"] as $i => $arItem){
        if($arItem["PREVIEW_PICTURE"]){
            $resize = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width' => 270, 'height' => 270), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            $arResult["ITEMS"][$i]["PREVIEW_PICTURE"]['SRC'] = $resize['src'];
        }elseif($arItem["DETAIL_PICTURE"]){
            $resize = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array('width' => 270, 'height' => 270), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            $arResult["ITEMS"][$i]["PREVIEW_PICTURE"]['SRC'] = $resize['src'];
        }
    }
?>
