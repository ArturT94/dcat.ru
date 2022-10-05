<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); ?>
<div class="header-slider-mob">
<?foreach($arResult["ITEMS"] as $arItem):?>
    <?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
    <div class="header-slides one" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="slides-container">
            <div class="header-descr">
                <div class="header-descr__title"><?=$arItem['NAME']?></div>
                <div class="header-descr__p"><?=$arItem['~PREVIEW_TEXT']?></div>
                <?if($arItem['PROPERTIES']['BTN_1_TITLE']['VALUE'] || $arItem['PROPERTIES']['BTN_2_TITLE']['VALUE']):?>
                    <div class="header-descr__buttons">
                        <?if($arItem['PROPERTIES']['BTN_1_TITLE']['VALUE']):?>
                            <a href="<?=$arItem['PROPERTIES']['BTN_1_LINK']['VALUE']?>" class="new-more dcut-button"><?=$arItem['PROPERTIES']['BTN_1_TITLE']['VALUE']?></a>
                        <?endif;?>
                        <?if($arItem['PROPERTIES']['BTN_2_TITLE']['VALUE']):?>
                            <a href="<?=$arItem['PROPERTIES']['BTN_2_LINK']['VALUE']?>" class="callToAction dark-button dcut-button"><span><?=$arItem['PROPERTIES']['BTN_2_TITLE']['VALUE']?></span></a>
                        <?endif;?>
                    </div>
                <?endif;?>
            </div>
        </div>
        <div class="header-slides__button"><?=$arItem['PROPERTIES']['NAV_TITLE']['~VALUE']?></div>
    </div>
<?endforeach;?>
</div>
