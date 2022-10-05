<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);?>
<?if($arResult['ITEMS']):?>
<!--RestartBuffer-->
<div class="ajaxRow">
<div class="product-list<?if(!$arParams['CUSTOM_COL']):?> filter-open<?endif;?>">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$arItem['MIN_PRICE'] = $arItem['ITEM_PRICES'][0];
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="product" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if($arItem['MIN_PRICE']['PERCENT'] || $arItem['PROPERTIES']['NOVINKA_1']['VALUE']):?>
				<div class="product__labels">
					<?if($arItem['PROPERTIES']['NOVINKA_1']['VALUE']):?>
						<div class="product-label product-label--new">Новинка</div>
					<?endif;?>
					<?if($arItem['MIN_PRICE']['PERCENT']):?>
						<div class="product-label product-label--discount">-<?=$arItem['MIN_PRICE']['PERCENT']?>%</div>
					<?endif;?>
				</div>
			<?endif;?>
			<div class="product__quick product__quick--catalog">
				<a href="javascript:void(0)" class="add-compare to_compare" data-url="https://<?=$GLOBALS['_SERVER']['SERVER_NAME']?><?=$APPLICATION->GetCurPage()?>" data-id="<?=$arItem['ID']?>">
					<svg class="icon"><use xlink:href="#compare-product"></use></svg>
				</a>
				<a href="javascript:void(0)" class="add-favorite to_favorites" data-id="<?=$arItem['ID']?>">
					<svg class="icon"><use xlink:href="#heart-outline-product"></use></svg>
					<svg class="icon"><use xlink:href="#heart-product"></use></svg>
				</a>		
			</div>
			<?if($arItem['PREVIEW_PICTURE']['SRC']):?>
				<div class="product__thumb">
					<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
					</a>
				</div>
			<?endif;?>
			<div class="product__content">
				<div class="d-flex align-items-center">
					<?if($arItem['CUSTOM_QUANTITY'] == 'otherShop'/* && $arItem['CUSTOM_QUANTITY'] != 0*/):?>
						<div class="product__stock product__stock--unaviable">
							<div class="caption">есть в других<br> магазинах</div>
						</div>
					<?elseif($arItem['CUSTOM_QUANTITY'] == 'empty'):?>
						<div class="product__stock product__stock--unaviable">
							<div class="prodduct__stock__bar"><i></i><i></i><i></i><i></i><i></i><i></i></div>
						</div>
					<?else:?>
						<div class="product__stock<?= Prymery\Regionality::ProductQuantityClass($arItem['CUSTOM_QUANTITY']);?>">
							<?= Prymery\Regionality::ProductQuantityBar($arItem['CUSTOM_QUANTITY']);?>
						</div>
					<?endif;?>
				</div>
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="product__title"><?=$arItem['NAME']?></a>
				<div class="product__footer">
					<div class="product__prices">
						<?if($arItem['OFFERS']):
							if(!$arItem['OFFERS'][0]['MIN_PRICE']){$arItem['OFFERS'][0]['MIN_PRICE'] = $arItem['OFFERS'][0]['ITEM_PRICES'][0];}?>
							<?if($arItem['OFFERS'][0]['MIN_PRICE']['RATIO_BASE_PRICE']>$arItem['OFFERS'][0]['MIN_PRICE']['PRICE']):?>
								<div class="product__price--old"><?=$arItem['OFFERS'][0]['MIN_PRICE']['RATIO_BASE_PRICE']?> <span class="currency">₽</span></div>
							<?endif;?>
							<?if($arItem['PROPERTIES']['STARAYA_TSENA']['VALUE']):?>
								<div class="product__price--old"><?=$arItem['PROPERTIES']['STARAYA_TSENA']['VALUE']?> <span class="currency">₽</span></div>
							<?endif;?>
							<div class="product__price--current"><?=$arItem['OFFERS'][0]['MIN_PRICE']['PRICE']?> <span class="currency">₽</span></div>
						<?else:?>
							<?if($arItem['MIN_PRICE']['RATIO_BASE_PRICE']>$arItem['MIN_PRICE']['PRICE']):?>
								<div class="product__price--old"><?=$arItem['MIN_PRICE']['RATIO_BASE_PRICE']?> <span class="currency">₽</span></div>
							<?endif;?>
							<?if($arItem['PROPERTIES']['STARAYA_TSENA']['VALUE']):?>
								<div class="product__price--old"><?=$arItem['PROPERTIES']['STARAYA_TSENA']['VALUE']?> <span class="currency">₽</span></div>
							<?endif;?>
							<div class="product__price--current"><?=$arItem['MIN_PRICE']['PRICE']?> <span class="currency">₽</span></div>
						<?endif;?>
					</div>
					<div class="product__action">
						<?if($arItem['CUSTOM_QUANTITY'] == 'empty'):?>
							<a data-fancybox data-type="ajax" data-touch="false" data-src="/local/ajax/form/aviable.php?ajax=y&id=<?=$arItem['ID']?>" class="notifyBtn adp-btn adp-btn--light has-icon-left">
								<svg class="icon"><use xlink:href="#bell"></use></svg>
								<span class="product__action-mobile">Узнать</span>
								<span class="product__action-desktop">Узнать о поступлении</span>
							</a>
						<?else:?>
							<?if($arItem['OFFERS']){
								$element_id = $arItem['OFFERS'][0]['ID'];
							}else{
								$element_id = $arItem['ID'];
							}?>
							<a href="javascript:void(0)" class="adp-btn adp-btn--primary adp-btn--sm to_basket" data-id="<?=$element_id?>">
								<?if($arItem['CUSTOM_QUANTITY'] == 'otherShop'):?>
								Под заказ
								<?else:?>
								В корзину
								<?endif;?>
								<svg class="icon"><use xlink:href="#cart"></use></svg>
							</a>
						<?endif;?>
					</div>
				</div>
			</div>
		</div>
	<?endforeach;?>
	<script>
        $('.ajaxElementCnt').html('Найдено <?=$arResult["NAV_RESULT"]->NavRecordCount?> <?=endingsForm($arResult["NAV_RESULT"]->NavRecordCount,'товар','товара','товаров');?>');
    </script>
</div>
<?if ($arParams['DISPLAY_BOTTOM_PAGER']):?>
	<?$bxajaxid = CAjax::GetComponentID($component->__name, $component->__template->__name, $component->arParams['AJAX_OPTION_ADDITIONAL']);?>
	<?
	if($arResult["NAV_RESULT"]->NavPageCount > 1 && $arResult["NAV_RESULT"]->NavPageNomer<$arResult["NAV_RESULT"]->NavPageCount):?>
		<?  $showed = $arParams['PAGE_ELEMENT_COUNT'] * $arResult["NAV_RESULT"]->NavPageNomer;
			$all = $arResult["NAV_RESULT"]->NavRecordCount;
		?>
		<div class="product__loader" id="btn_<?=$bxajaxid?>">
			<div class="counter">Вы посмотрели <?=$showed;?> <?=endingsForm($showed,'товар','товара','товаров');?> из <?=$all;?></div>
			<div class="bar">
				<div class="bar-loaded" style="width: <?=$showed/$all*100?>%"></div>
			</div>
			<a data-ajax-id="<?=$bxajaxid?>" href="javascript:void(0)" data-show-more="<?=$arResult["NAV_RESULT"]->NavNum?>" data-next-page="<?=($arResult["NAV_RESULT"]->NavPageNomer + 1)?>" data-max-page="<?=$arResult["NAV_RESULT"]->NavPageCount?>" class="load-more btn-link--primary">Загрузить ещё</a>
		</div>
	<?endif?>
<?endif?>
</div>
	
<!--RestartBuffer-->
<?else:?>
	<div class="search-result-empty">
		К сожалению, мы не смогли найти подходящие товары по вашему запросу.<br>
		Попробуйте изменить поисковый запрос
	</div>
<?endif;?>