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

<div class="team-container">
    <div class="section-title">Наша команда</div>
    <div class="section-subtitle">Наша команда обладает многолетним опытом в строительной отрасли и всегда готова оказать профессиональную поддержку на вашем объекте.</div>

    <div class="team-slider">
        <?foreach($arResult["ITEMS"] as $key => $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>

            <div class="team-slider_column" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <a data-fancybox href="#team-slider-modal" class="team-slider_item fancybox-trigger" data-slider-index="<?=$key?>">
                    <div class="hover-border"></div>
                    <div class="team-slider_img">
                        <span class="team-icon-hidden">
                            <svg width="42" height="42" class="icon"><use xlink:href="#zoom-in-light"></use></svg>
                        </span>
                        <img src="<?= $arItem["DISPLAY_PROPERTIES"]["PHOTO"]["FILE_VALUE"]["SRC"]; ?>" alt="<?= $arItem["NAME"]; ?>">
                    </div>
                    <div class="team-slider_info">
                        <div class="team-slider_info__name"><?= $arItem["NAME"]; ?></div>
                        <div class="team-slider_info__profession"><?= $arItem["DISPLAY_PROPERTIES"]["POSITION"]["DISPLAY_VALUE"]; ?></div>
                    </div>
                </a>
            </div>
        <?endforeach;?>
    </div>
</div>
