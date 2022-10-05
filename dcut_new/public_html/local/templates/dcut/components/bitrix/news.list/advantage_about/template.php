<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="sidebar-accordion one">
    <?foreach($arResult["ITEMS"] as $key => $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="sidebar-accordion_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="sidebar-accordion_item__title <?if ($key == 0): ?> first-child <?endif;?>">
                <span><?= $arItem["NAME"] ?></span>
                <svg class="svg-plus" width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M11.36 6.99018H6.992V11.2862H4.976V6.99018H0.608V5.09418H4.976V0.774176H6.992V5.09418H11.36V6.99018Z" /></svg>
                <svg class="svg-minus" width="8" height="3" viewBox="0 0 8 3" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M0.758625 0.846175H7.21463V2.83818H0.758625V0.846175Z" /></svg>
            </div>
            <div class="sidebar-accordion_item__text"><?= $arItem["PREVIEW_TEXT"] ?></div>
        </div>
    <?endforeach;?>
</div>