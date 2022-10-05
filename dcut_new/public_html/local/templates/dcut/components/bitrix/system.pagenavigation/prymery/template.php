<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if(!$arResult["NavShowAlways"]){
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>
<ul class="pagination justify-content-center">
    <? if ($arResult["NavPageNomer"] > 1): ?>
        <? if($arResult["bSavePage"]):?>
            <li class="page-item"><a class="page-link left" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">Назад</a></li>
        <? else:?>
            <? if ($arResult["NavPageNomer"] > 2):?>
                <li class="page-item"><a class="page-link left" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">Назад</a></li>
            <? else:?>
                <li class="page-item"><a class="page-link left" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">Назад</a></li>
            <? endif?>
        <? endif?>
    <? else: ?>
        <li class="page-item disabled"><span class="page-link left">Назад</span></li>
    <? endif; ?>

    <? while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
        <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
            <li class="page-item active"><span class="page-link"><?=$arResult["nStartPage"]?></span></li>
        <? elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
            <li class="page-item"><a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a></li>
        <? else:?>
            <li class="page-item"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
        <? endif?>
        <? $arResult["nStartPage"]++?>
    <? endwhile?>

    <? if($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
        <li class="page-item"><a class="page-link right" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">Вперед</a></li>
    <? else: ?>
        <li class="page-item disabled"><span class="page-link right">Вперед</span></li>
    <? endif; ?>
</ul>