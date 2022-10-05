<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); ?>
<div id="slider" class="sl-slider-wrapper">
    <div class="sl-slider">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
            <div class="sl-slide bg-1" id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                <div class="sl-slide-inner"<?if($arItem['PROPERTIES']['BG']['VALUE']):?> style="background: url(<?=CFile::GetPath($arItem['PROPERTIES']['BG']['VALUE']);?>) no-repeat center right 60%;background-size: cover;"<?endif;?>>
                    <div class="head-container">
                        <div class="header-descr">
                            <div class="header-descr__title"><?=$arItem['NAME']?></div>
                            <div class="header-descr__p"><?=$arItem['~PREVIEW_TEXT']?></div>
                            <?if($arItem['PROPERTIES']['BTN_1_TITLE']['VALUE'] || $arItem['PROPERTIES']['BTN_2_TITLE']['VALUE']):?>
                                <div class="header-descr__buttons">
                                    <?if($arItem['PROPERTIES']['BTN_1_TITLE']['VALUE']):?>
                                        <a href="<?=$arItem['PROPERTIES']['BTN_1_LINK']['VALUE']?>"<?if($arItem['PROPERTIES']['BTN_1_MODAL']['VALUE']):?> data-type="ajax" data-fancybox="" data-src="<?=$arItem['PROPERTIES']['BTN_1_LINK']['VALUE']?>"<?endif;?> class="new-more dcut-button"><?=$arItem['PROPERTIES']['BTN_1_TITLE']['VALUE']?></a>
                                    <?endif;?>
                                    <?if($arItem['PROPERTIES']['BTN_2_TITLE']['VALUE']):?>
                                        <a href="<?=$arItem['PROPERTIES']['BTN_2_LINK']['VALUE']?>"<?if($arItem['PROPERTIES']['BTN_2_MODAL']['VALUE']):?> data-type="ajax" data-fancybox="" data-src="<?=$arItem['PROPERTIES']['BTN_2_LINK']['VALUE']?>"<?endif;?> class="call-to-action dark-button dcut-button"><span><?=$arItem['PROPERTIES']['BTN_2_TITLE']['VALUE']?></span></a>
                                    <?endif;?>
                                </div>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            </div>
        <?endforeach;?>
    </div>
    <nav id="nav-dots" class="nav-dots header-tabs">
        <div class="header-container">
            <?foreach($arResult["ITEMS"] as $key=>$arItem):?>
                <button autofocus class="<?if($key == 0):?>nav-dot-current active <?endif;?>tab"><?=$arItem['PROPERTIES']['NAV_TITLE']['~VALUE']?></button>
            <?endforeach;?>
            <span class="active-slide"></span>
        </div>
    </nav>
</div>