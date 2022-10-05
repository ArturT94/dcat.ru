<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);
if($arResult["ITEMS"]):?>
    <div class="content-row">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            if(!$arItem['MIN_PRICE']){
                $arItem['MIN_PRICE'] = $arItem['ITEM_PRICES'][0];
            }
            ?>
            <div class="content-column" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="item category-item">
                    <div class="item-like">
                        <?if($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
                            <div class="item-like__vendor"><a href="<?=$arItem['DETAIL_PAGE_URL']?>">Артикул - <?=$arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']?></a></div>
                        <?endif;?>
                        <div class="item-icons">
                            <div class="item-like__heart add-favorites" data-id="<?=$arItem['ID']?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="Добавить в избранное">
                                <svg width="23" height="21" class="icon"><use xlink:href="#product-like"></use></svg>
                            </div>
                            <?/*div class="item-like__arrows add-compare" data-url="<?=$APPLICATION->GetCurPage();?>" data-id="<?=$arItem['ID']?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="Сравнить">
                                <svg width="19" height="20" class="icon"><use xlink:href="#product-compare"></use></svg>
                            </div*/?>
                        </div>
                    </div>
                    <div class="item-img">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                            <?if($arItem['PREVIEW_PICTURE']):?>
                                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?= $arItem['NAME']; ?>">
                            <?else:?>
                                <img src="/local/templates/dcut/assets/img/no-photo.png" alt="<?= $arItem['NAME']; ?>">
                            <?endif;?>
                        </a>
                        <?global $USER;
                        if($USER->IsAuthorized()):?>
                            <div class="quickview" data-id="<?=$arItem['ID']?>">
                                <?/*svg class="icon wish buy-modal" data-toggle="tooltip" data-placement="top" title="" width="22" height="20" data-original-title="Купить в 1 клик">
                                    <use xlink:href="#buy-inclick"></use>
                                </svg*/?>
                                <?if($arItem['CATALOG_QUANTITY'] > 0):?>
                                    <span class="quickview-basket-link to_basket" data-id="<?=$arItem['ID']?>">в корзину</span>
                                    <svg width="24" height="23" class="icon quickview-basket-svg"><use xlink:href="#quick-basket"></use></svg>
                                <?else:?>
                                    <div class="noAviablity" style="color: #fff;">Нет в наличии</div>
                                <?endif;?>
                                <?/*svg width="20" height="20" class="icon card-loop" data-toggle="tooltip" data-placement="top" title="" data-original-title="Быстрый просмотр">
                                    <use xlink:href="#product-zoom"></use>
                                </svg*/?>
                            </div>
                        <?endif;?>
                    </div>
                    <div class="item-info">
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
							<div class="item-info__price">
                                <?/*if($arItem['MIN_PRICE']['DISCOUNT'] == 0){
                                    echo $arItem['MIN_PRICE']['PRINT_BASE_PRICE'];
                                }else{
                                    echo $arItem['MIN_PRICE']['PRINT_PRICE'];
                                }*/?>
								<?/*if($arItem['MIN_PRICE']['VALUE']>$arItem['MIN_PRICE']['DISCOUNT_VALUE']):?>
									<span><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span>
                                <?elseif($arItem['PROPERTIES']['OLD_PRICE']['VALUE']):?>
                                    <span><?=$arItem['PROPERTIES']['OLD_PRICE']['VALUE']?> руб.</span>
								<?endif;*/?>

                                <?global $USER;
                                if($USER->IsAuthorized()):?>
                                    <?=$arItem['MIN_PRICE']['PRINT_PRICE']?>
                                    <?if($arItem['MIN_PRICE']['VALUE']>$arItem['MIN_PRICE']['DISCOUNT_VALUE']):?>
                                        <span style="font-size:13px;"><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span>
                                    <?elseif($arItem['MIN_PRICE']['PERCENT']>0):?>
                                        <span style="font-size:13px;"><?=$arItem['MIN_PRICE']['PRINT_BASE_PRICE']?></span>
                                    <?elseif($arItem['PROPERTIES']['OLD_PRICE']['VALUE'] && $arItem['MIN_PRICE']['BASE_PRICE'] != $arItem['PROPERTIES']['OLD_PRICE']['VALUE']):?>
                                        <span style="font-size:13px;"><?=$arItem['PROPERTIES']['OLD_PRICE']['VALUE']?> руб.</span>
                                    <?endif;?>
                                <?endif;?>
							</div>
							<div class="item-info__descr"><?= $arItem['PREVIEW_TEXT']; ?></div>
						</a>
                    </div>
                </div>
            </div>
        <?endforeach;?>
    </div>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif;?>
<?else:?>
    Товары не найдены.
<?endif;?>


