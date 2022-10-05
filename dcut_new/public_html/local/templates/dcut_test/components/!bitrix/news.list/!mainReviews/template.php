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

<section class="s-reviews">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title text-center">Отзывы</h2>
                <div class="rating-val">
                    <div class="rating-val--average"><?=round($arResult['ALL_RATING']/$arResult['COUNT'],1)?></div>
                    <div class="rating-val--max">/5</div>
                </div>
                <div class="rating-val__description">Средняя оценка на основании <?=$arResult['COUNT']?> <?=endingsForm($arResult['COUNT'],'отзыв','отзыва','отзывов');?></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="slider-container">
                    <div class="flower-slider review-slider">
                        <?foreach($arResult["ITEMS"] as $arItem):?>
                            <?
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                            <div class="slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                <div class="review__item">
                                    <div class="review__header">
                                        <?if($arItem['PROPERTIES']['RATING']['VALUE']):?>
                                            <ul class="rating-star rating-review">
                                                <li<?if($arItem['PROPERTIES']['RATING']['VALUE']>1):?> class="active"<?endif;?>><svg class="icon"><use xlink:href="#star"></use></svg></li>
                                                <li<?if($arItem['PROPERTIES']['RATING']['VALUE']>2):?> class="active"<?endif;?>><svg class="icon"><use xlink:href="#star"></use></svg></li>
                                                <li<?if($arItem['PROPERTIES']['RATING']['VALUE']>3):?> class="active"<?endif;?>><svg class="icon"><use xlink:href="#star"></use></svg></li>
                                                <li<?if($arItem['PROPERTIES']['RATING']['VALUE']>4):?> class="active"<?endif;?>><svg class="icon"><use xlink:href="#star"></use></svg></li>
                                                <li<?if($arItem['PROPERTIES']['RATING']['VALUE']>5):?> class="active"<?endif;?>><svg class="icon"><use xlink:href="#star"></use></svg></li>
                                            </ul>
                                        <?endif;?>
                                        <?if($arItem['PROPERTIES']['DATE']['VALUE']):?>
                                            <div class="review__date"><?=$arItem['PROPERTIES']['DATE']['VALUE']?></div>
                                        <?endif;?>
                                    </div>
                                    <div class="review__author"><?=$arItem['NAME']?></div>
                                    <div class="review__content"><?=$arItem['PREVIEW_TEXT']?></div>
                                    <div class="review__action">
                                        <?if($arItem['PROPERTIES']['FILE']['VALUE']):?>
                                            <a href="javascript:void(0)" class="review-photo" data-review-target="review-modal-<?=$arItem['ID']?>1">Фотография</a>
                                        <?endif;?>
                                        <?if($arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]):?>
                                            <a href="#" class="review-bouquet" data-review-target="review-modal-<?=$arItem['ID']?>">Букет</a>
                                        <?endif;?>
                                        <?if($arItem['PROPERTIES']['FILE']['VALUE']):?>
                                            <div class="review-modal" id="review-modal-<?=$arItem['ID']?>1">
                                                <div class="review-modal__close"><svg class="icon"><use xlink:href="#times"></use></svg></div>
                                                <div class="review-modal__thumb">
                                                    <a href="javascript:void(0)"><img src="<?=CFile::GetPath($arItem['PROPERTIES']['FILE']['VALUE']);?>"></a>
                                                </div>
                                                <?if($arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['CODE']):?>
                                                    <div class="review-modal__action">
                                                        <a href="/catalog/<?=$arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['CODE']?>/" class="adp-btn adp-btn--primary-outline adp-btn--rounded">Перейти на страницу товара</a>
                                                    </div>
                                                <?endif;?>
                                            </div>
                                        <?endif;?>
                                        <?if($arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]):?>
                                            <div class="review-modal" id="review-modal-<?=$arItem['ID']?>">
                                                <div class="review-modal__close"><svg class="icon"><use xlink:href="#times"></use></svg></div>
                                                <div class="review-modal__thumb">
                                                    <a href="#"><img src="<?=$arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['PREVIEW_PICTURE']?>" alt="<?=$arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['NAME']?>"></a>
                                                </div>
                                                <a href="#" class="review-modal__title"><?=$arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['NAME']?></a>
                                                <div class="review-modal__description">
                                                    <?=$arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['PREVIEW_TEXT']?>
                                                </div>
                                                <div class="product__prices review-modal__prices">
                                                    <?if($arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['PRICE']):?>
                                                        <div class="product__price product__price--current">
                                                            <span><?=round($arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['PRICE'])?></span>
                                                            <span class="product-currency"><svg class="icon"><use xlink:href="#ruble-sign"></use></svg></span>
                                                        </div>
                                                    <?endif;?>
                                                    <?if($arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['OLD_PRICE']):?>
                                                        <div class="product__price product__price--old">
                                                            <span><?=$arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['OLD_PRICE']?></span>
                                                            <span class="product-currency"><svg class="icon"><use xlink:href="#ruble-sign"></use></svg></span>
                                                        </div>
                                                    <?endif;?>
                                                </div>
                                                <?if($arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['CODE']):?>
                                                    <div class="review-modal__action">
                                                        <a href="/catalog/<?=$arResult['PRODUCTS'][$arItem['PROPERTIES']['PRODUCT']['VALUE']]['CODE']?>/" class="adp-btn adp-btn--primary-outline adp-btn--rounded">Перейти на страницу товара</a>
                                                    </div>
                                                <?endif;?>
                                            </div>
                                        <?endif;?>
                                    </div>
                                </div>
                            </div>
                        <?endforeach;?>
                    </div>
                    <div class="slider-navigation review-navigation">
                        <div class="slider-arrow review-prev"><svg class="icon"><use xlink:href="#long-arrow-left"></use></svg></div>
                        <div class="ms-slider-counters"><i>01</i>/<span>03</span></div>
                        <div class="slider-arrow review-next"><svg class="icon"><use xlink:href="#long-arrow-right"></use></svg></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="section-action text-center">
                    <a href="/reviews/" class="adp-btn adp-btn--primary-outline adp-btn--wide">Смотреть все отзывы</a>
                </div>
            </div>
        </div>
    </div>
</section>
