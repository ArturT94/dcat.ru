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

<div class="services-two">
    <div class="services-row">
        <? foreach($arResult["ITEMS"] as $arItem): ?>
            <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="services-column services-column-tab" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="services-item other-tab">
                    <div class="services-item-border"></div>
                    <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>">
                    <div class="services-item__title"><?=$arItem["NAME"]?></div>
                    <span class="services-item__link">Подробнее <svg width="10" height="8" class="icon"><use xlink:href="#double-angle-right"></use></svg></span>
                </a>
            </div>
        <? endforeach; ?>

        <div class="services-text">
            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/local/templates/dcut/include_areas/services_text.php",
                    "AREA_FILE_SUFFIX" => "",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => ""
                )
            );?>
        </div>
    </div>
</div>
