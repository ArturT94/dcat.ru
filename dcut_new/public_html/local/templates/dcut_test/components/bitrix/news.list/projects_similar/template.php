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

<section class="similar-projects">
    <div class="similar-projects_container">
        <?php/*<div class="similar-projects_title"></div>*/?>
        <div class="similar-projects_slider">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="similar-column">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="similar-item">
                        <div class="similar-item_img">
                            <img src="<?=CFile::GetPath($arItem['PROPERTIES']['WEBP']['VALUE']);?>" alt="<?= $arItem["NAME"] ?>">
                            <div class="block-hidden">
                                <div class="block-hidden_text"><?= $arItem["PREVIEW_TEXT"] ?></div>
                                <span class="block-hidden_link">Подробнее <svg width="10" height="9" class="icon"><use xlink:href="#double-angle-right"></use></svg></span>
                            </div>
                        </div>
                        <div class="similar-item_title"><?= $arItem["NAME"] ?></div>
                    </a>
                </div>
            <?endforeach;?>
        </div>
    </div>
</section>