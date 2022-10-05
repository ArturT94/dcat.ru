<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*$showProps = array('BREND','GARANTIYA','LIST_1','LIST_2','LIST_3',
	'LIST_4','LIST_5','LIST_6','LIST_7','LIST_8','LIST_9','LIST_10','LIST_11','LIST_12','LIST_13','LIST_14','LIST_15','LIST_16','LIST_17');
*/
if($arResult['ITEMS']){
	$hideProp = array();
	foreach($arResult['ITEMS'] as $arItem){
		foreach($arItem['PROPERTIES'] as $prop){
			if(!in_array($prop['CODE'],$hideProp)){
				if($prop['VALUE'] && !is_array($prop['VALUE'])){
					$prop['NAME'] = str_replace(array('Справочник - ',' - справочник2'),'',$prop['NAME']);
					//$arResult['SHOW_PROPS'][$prop['NAME']] = $prop;
					$showProps[$prop['CODE']] = $prop['CODE'];
				}
			}
		}
	}
}


if ($_REQUEST['diff']){
	foreach($showProps as $code){
		$showRow = true;
		$arCompare = array();
		foreach($arResult["ITEMS"] as $arElement){
			$arPropertyValue = $arElement["PROPERTIES"][$code]["VALUE"];
			if (is_array($arPropertyValue))
			{
				sort($arPropertyValue);
				$arPropertyValue = implode(" / ", $arPropertyValue);
			}
			$arCompare[] = $arPropertyValue;
		}
		unset($arElement);
		$showRow = (count(array_unique($arCompare)) > 1);
		$arShowDiff[$code] = $showRow;
	}
}else{
	foreach($showProps as $code){
		$arShowDiff[$code] = true;
	}
}
if($_REQUEST['section']){
	foreach($arResult["ITEMS"] as $k=>$arElement){
		if($arElement['FIRST_PARENT'] != $_REQUEST['section']){
			unset($arResult['ITEMS'][$k]);
		}
	}
}
//Перемещаем закрепленные товары вперед
foreach($arParams["arComparePinned"] as $arPin){
	foreach($arResult["ITEMS"] as $i=>$arItem){
		if($arItem['ID'] == $arPin){
			unset($arResult["ITEMS"][$i]);
			array_unshift($arResult["ITEMS"],$arItem);
		}
	}
}
	
?>

<section class="profile-compare">
    <div class="container-large container-scroll scrollbar-inner">
        <!-- part1 - top -->
        <div class="first-column-sm">
            <div class="settings-form_title">Показать характеристики:</div>
            <div class="settings-form-flex">
                <label class="settings-form-radio-label" for="all">
                    <input class="settings-form-radio-input" id="all" type="radio" name="framework">
                    <span class="settings-form-radio-title">Все</span>
                </label>
                <label class="settings-form-radio-label" for="differents">
                    <input class="settings-form-radio-input" id="differents" type="radio" name="framework">
                    <span class="settings-form-radio-title">Различающиеся</span>
                </label>
            </div>
        </div>

        <div class="compare-row-part1">
            <div class="compare-column-part1 first-column-lg">
                <div class="settings-form_title">Показать характеристики:</div>
                <div class="settings-form-flex">
                    <label class="settings-form-radio-label" for="man">
                        <input class="settings-form-radio-input" id="man" type="radio" name="framework">
                        <span class="settings-form-radio-title">Все</span>
                    </label>
                    <label class="settings-form-radio-label" for="woman">
                        <input class="settings-form-radio-input" id="woman" type="radio" name="framework">
                        <span class="settings-form-radio-title">Различающиеся</span>
                    </label>
                </div>
            </div>
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <div class="compare-column-part1">
                    <div class="compare-delete" onclick="CatalogCompareObj.delete('<?=CUtil::JSEscape($arItem['~DELETE_URL'])?>');location.reload();">
                        <svg width="18" height="19" class="icon"><use xlink:href="#product-delete"></use></svg>
                        <div class="compare-delete-label">Убрать из сравнения</div>
                    </div>
                    <div class="item compare-item">
                        <div class="item-like">
                            <?if($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
                                <div class="item-like__vendor"><a href="<?=$arItem['DETAIL_PAGE_URL']?>">Артикул - <?=$arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']?></a></div>
                            <?endif;?>
                            <div class="item-icons">
                                <div class="add-favorites item-like__heart" data-toggle="tooltip" data-placement="left" title="Добавить в избранное" data-id="<?=$arItem['ID']?>">
                                    <svg width="23" height="21" class="icon"><use xlink:href="#product-like"></use></svg>
                                </div>
                                <div class="item-like__arrows" data-toggle="tooltip" data-placement="left" title="Сравнить" data-id="<?=$arItem['ID']?>" data-url="<?=$APPLICATION->GetCurPage();?>">
                                    <svg width="19" height="20" class="icon"><use xlink:href="#product-compare"></use></svg>
                                </div>
                            </div>
                        </div>
                        <div class="item-img compare-item-img">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <?if($arItem["FIELDS"]['PREVIEW_PICTURE']["SRC"]):?>
                                    <img src="<?=$arItem["FIELDS"]['PREVIEW_PICTURE']["SRC"]?>" alt="<?=$arItem['NAME']?>">
                                <?else:?>
                                    <img src="/local/templates/dcut/assets/img/no-photo.png" alt="<?=$arItem['NAME']?>">
                                <?endif;?>
                            </a>
                            <div class="quickview">
                                <svg class="icon wish buy-modal" data-toggle="tooltip" data-placement="top" title="Купить в 1 клик" width="22" height="20"><use xlink:href="#buy-inclick"></use></svg>
                                <span class="quickview-basket-link to_basket" data-id="<?=$arItem['ID']?>">в корзину</span>
                                <svg width="24" height="23" class="icon quickview-basket-svg"><use xlink:href="#quick-basket"></use></svg>
                                <?/*svg width="20" height="20" class="icon card-loop" data-toggle="tooltip" data-placement="top" title="Быстрый просмотр"><use xlink:href="#product-zoom"></use></svg*/?>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-info__price"><?=number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE_VAT'], 0, '', ' '); ?> руб.<?/*span>14 349 руб.</span*/?></div>
                            <div class="item-info__descr"><?= $arItem['PREVIEW_TEXT']; ?></div>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>

        <div class="compare-row-part2">
            <div class="compare-column-part2">
                <div class="compare-descr-key">Артикул</div>
            </div>
            <div class="compare-column-part2">
                <div class="compare-mob-descr"><div class="compare-descr-value">DCS 1-12-717</div></div>
            </div>

        </div>

        <div class="compare-row-part2">
            <div class="compare-column-part2">
                <div class="compare-descr-key">Страна разработчик</div>
            </div>
            <div class="compare-column-part2">
                <div class="compare-mob-descr"><div class="compare-descr-value">США</div></div>
            </div>

        </div>

        <div class="compare-row-part2">
            <div class="compare-column-part2">
                <div class="compare-descr-key">Страна производитель</div>
            </div>
            <div class="compare-column-part2">
                <div class="compare-mob-descr"><div class="compare-descr-value">Китай</div></div>
            </div>

        </div>

        <div class="compare-row-part2">
            <div class="compare-column-part2">
                <div class="compare-descr-key">Производитель</div>
            </div>
            <div class="compare-column-part2">
                <div class="compare-mob-descr">
                    <div class="compare-descr-value">Dewalt</div>
                </div>
            </div>

        </div>

        <div class="compare-row-part2">
            <div class="compare-column-part2">
                <div class="compare-descr-key">Базовая единица</div>
            </div>
            <div class="compare-column-part2">
                <div class="compare-mob-descr">
                    <div class="compare-descr-value">шт.</div>
                </div>
            </div>

        </div>

        <div class="compare-row-part2">
            <div class="compare-column-part2">
                <div class="compare-descr-key">Наличие на складе </div>
            </div>
            <div class="compare-column-part2">
                <div class="compare-mob-descr">
                    <div class="compare-descr-value">В наличии</div>
                </div>
            </div>

        </div>
    </div>
</section>












<div class="compare__controls--mobile" style="display:none;">
	<form action="#" class="f-compare">
		<label class="custom-checkbox" href="<? echo $arResult['COMPARE_URL_TEMPLATE'].'DIFFERENT=Y'; ?>">
			<input type="checkbox" class="custom-checkobox__value" name="differences" checked>
			<span class="custom-checkobox__text">Только отличия</span>
		</label>
	</form>
	<div class="slider-navigation compare-navigation">
		<div class="slider-arrow compare-prev">
		</div>
		<div class="slider-arrow compare-next">
		</div>
	</div>
</div>

<div class="compare__container" style="display:none;">
	<div class="compare__header">
		<div class="compare__top">
			<form action="#" class="f-compare">
				<a href="/catalog/compare.php<?if($_REQUEST['diff'] != 'y'):?>?diff=y<?endif;?>" class="custom-checkbox">
					<input type="checkbox" class="custom-checkobox__value" name="differences"<?if($_REQUEST['diff'] == 'y'):?> checked<?endif;?>>
					<span class="custom-checkobox__text">Только отличия</span>
				</a>
			</form>

			<div class="slider-navigation compare-navigation">
				<div class="slider-arrow compare-prev">
				</div>
				<div class="slider-arrow compare-next">
				</div>
			</div>
		</div>

		<div class="compare__body">
			<div class="compare__chars">Характеристики</div>
			<ul class="compare__titles">
				<? foreach($arResult['ITEMS'][0]['PROPERTIES'] as $code=>$arProp):
					if(in_array($code,$showProps) && $arResult['ALL_PROPS_VALUE'][$code]):
						if($arShowDiff[$code]):?>
							<li data-list-item="prop-<?=$code?>"><?=str_replace(array('Справочник - ',' - справочник2'),'',$arProp['NAME'])?></li>
						<?endif;?>
					<?endif;?>
				<?endforeach;?>
				<li data-list-item="prop-aviable">
					Наличие в магазине
				</li>
			</ul>
		</div>
	</div>

	<div class="compare__goods">
		<div class="compare__slider">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<div class="compare-slider__item">
					<div class="compare-slider__header">
						<div class="product product--compact">
							<a onclick="CatalogCompareObj.delete('<?=CUtil::JSEscape($arItem['~DELETE_URL'])?>');" href="javascript:void(0)" class="quick__remove jsAjaxRemove" title="Удалить из сравнения">
							</a>
							<a href="javascript:void(0)" class="compare__pin<?if($arParams['arComparePinned'][$arItem['ID']]):?> pinned<?endif;?>" title="Закрепить" data-id="<?=$arItem['ID']?>">
								<svg class="icon"><use xlink:href="#pin-alt"></use></svg>
							</a>
							<div class="product__quick product__quick--catalog">
								<a href="javascript:void(0)" class="add-favorites to_favorites" data-id="<?=$arItem['ID']?>">
								</a>
							</div>
							<div class="product__thumb">
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
									<?if($arItem["FIELDS"]['PREVIEW_PICTURE']["SRC"]):?>
										<img src="<?=$arItem["FIELDS"]['PREVIEW_PICTURE']["SRC"]?>" alt="<?=$arItem['NAME']?>">
									<?else:?>
										<img src="/local/templates/dcut/assets/img/no-photo.png" alt="<?=$arItem['NAME']?>">
									<?endif;?>
								</a>
							</div>
							<div class="product__content">
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="product__title"><?=$arItem['NAME']?></a>
								<div class="product__footer">
									<div class="product__prices">
										<div class="product__price--current"><?=number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE_VAT'], 0, '', ' '); ?> <span class="currency">₽</span></div>
									</div>
									<div class="product__action">
										<a href="javascript:void(0)" class="to_basket adp-btn adp-btn--primary adp-btn--sm" data-id="<?=$arItem['ID']?>">
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<ul class="compare-goods__params">
						<?foreach($arItem['PROPERTIES'] as $code=>$arProp):
							if(in_array($code,$showProps) && $arResult['ALL_PROPS_VALUE'][$code]):
								if($arShowDiff[$code]):?>
									<li data-list-item="prop-<?=$code?>"><?=$arProp['VALUE']?></li>
								<?endif;?>
							<?endif;?>
						<?endforeach;?>
					</ul>
				</div>
			<?endforeach;?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var CatalogCompareObj = new BX.Iblock.Catalog.CompareClass("bx_catalog_compare_block", '<?=CUtil::JSEscape($arResult['~COMPARE_URL_TEMPLATE']); ?>');
</script>
