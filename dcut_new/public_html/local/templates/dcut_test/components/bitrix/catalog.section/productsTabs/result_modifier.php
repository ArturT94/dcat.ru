<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['ITEMS']){
    foreach($arResult['ITEMS'] as $i=>$arItem){
        if($arItem['PREVIEW_PICTURE']){
            $resize = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width' => 236, 'height' => 236), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            $arResult["ITEMS"][$i]["PREVIEW_PICTURE"]['SRC'] = $resize['src'];
        }

        $arIds[] = $arItem['ID'];
    }
}
$cp = $this->__component;
if (is_object($cp))
{
    $cp->arResult["IDS"] = $arIds;
    $cp->SetResultCacheKeys(array("IDS"));
}