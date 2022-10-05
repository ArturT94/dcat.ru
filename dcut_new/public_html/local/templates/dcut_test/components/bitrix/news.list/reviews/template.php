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

<section class="reviews">
    <div class="reviews-container">
        <div class="section-title">Что говорят о нас клиенты</div>

        <div class="reviews-slider">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>

                <div class="reviews-slider_column" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="reviews-slider_wrap">
                        <div class="reviews-slider_item ">
                            <div class="reviews-client">
                                <div class="reviews-client_img">
                                    <? if ($arItem["PREVIEW_PICTURE"]["SRC"]): ?>
                                        <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"]; ?>" alt="img">
                                    <? else: ?>
                                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/about-us/incognito.svg" alt="img">
                                    <?endif;?>
                                </div>
                                <div class="reviews-client_info">
                                    <div class="reviews-client_info__name"><?= $arItem["NAME"]; ?></div>
                                    <div class="reviews-client_info__prof"><? $arItem["PROPERTIES"]["POSITION"]["VALUE"] ?></div>
                                    <div class="reviews-client_info__date"><?= $arItem["PROPERTIES"]["REVIEWS_DATE"]["VALUE"] ?> <span>|</span> <?= $arItem["PROPERTIES"]["REVIEWS_TIME"]["VALUE"] ?></div>
                                </div>
                            </div>
                            <div class="reviews-say"><?= $arItem["PREVIEW_TEXT"]; ?></div>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>

    </div>
</section>