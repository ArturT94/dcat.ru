<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);
//pre($arResult['ITEMS'][0]['PROPERTIES']['STARAYA_TSENA']);
?>
<div id="<?=$arParams['CUSTOM_ID']?>" class="product-slider">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		?>
		<div class="slide">
			<div class="product product--compact" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
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
					<a href="javascript:void(0)" class="add-compare to_compare" data-url="<?=$APPLICATION->GetCurPage()?>" data-id="<?=$arItem['ID']?>">
						<svg class="icon"><use xlink:href="#compare-product"></use></svg>
					</a>
					<a href="javascript:void(0)" class="add-favorite to_favorites" data-id="<?=$arItem['ID']?>">
						<svg class="icon"><use xlink:href="#heart-outline-product"></use></svg>
						<svg class="icon"><use xlink:href="#heart-product"></use></svg>
					</a>	
				</div>
				<div class="product__thumb">
					<?if($arItem['PREVIEW_PICTURE']['SRC']):?>
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
							<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
						</a>
					<?endif;?>
				</div>
				<div class="product__content">
					<div class="d-flex align-items-center">
						<?$frame = new \Bitrix\Main\Page\FrameBuffered("COMMENTS_INFO_LIST_".$arItem['ID']); 
						$frame->begin();?>
							<?if($arResult['COMMENTS'][$arItem['ID']]):?>
								<a href="javascript:void(0)" class="product__comment">
									<svg class="icon"><use xlink:href="#speech-bubble"></use></svg>
									<?=count($arResult['COMMENTS'][$arItem['ID']]);?>
								</a>
							<?endif;?>
						<?$frame->end();?>
						<?if($arItem['CUSTOM_QUANTITY'] == 'otherShop' && $arItem['CUSTOM_QUANTITY'] != 0):?>
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
							<?if($arItem['OFFERS']):?>
								<?if($arItem['OFFERS'][0]['MIN_PRICE']['VALUE']>$arItem['OFFERS'][0]['MIN_PRICE']['DISCOUNT_VALUE']):?>
									<div class="product__price--old"><?=$arItem['OFFERS'][0]['MIN_PRICE']['VALUE']?> <span class="currency">₽</span></div>
								<?endif;?>
								<?if($arItem['PROPERTIES']['STARAYA_TSENA']['VALUE']):?>
									<div class="product__price--old"><?=$arItem['PROPERTIES']['STARAYA_TSENA']['VALUE']?> <span class="currency">₽</span></div>
								<?endif;?>
								<div class="product__price--current"><?=$arItem['OFFERS'][0]['MIN_PRICE']['DISCOUNT_VALUE']?> <span class="currency">₽</span></div>
							<?else:?>
								<?if($arItem['MIN_PRICE']['VALUE']>$arItem['MIN_PRICE']['DISCOUNT_VALUE']):?>
									<div class="product__price--old"><?=$arItem['MIN_PRICE']['VALUE']?> <span class="currency">₽</span></div>
								<?endif;?>
								<?if($arItem['PROPERTIES']['STARAYA_TSENA']['VALUE']):?>
									<div class="product__price--old"><?=$arItem['PROPERTIES']['STARAYA_TSENA']['VALUE']?> <span class="currency">₽</span></div>
								<?endif;?>
								<div class="product__price--current"><?=$arItem['MIN_PRICE']['DISCOUNT_VALUE']?> <span class="currency">₽</span></div>
							<?endif;?>
						</div>
						<?if($arItem['CUSTOM_QUANTITY'] != 'empty'):?>
							<?if($arItem['OFFERS']){
								$element_id = $arItem['OFFERS'][0]['ID'];
							}else{
								$element_id = $arItem['ID'];
							}?>
							<div class="product__action">
								<a href="javascript:void(0)" class="adp-btn adp-btn--primary adp-btn--sm to_basket" data-id="<?=$element_id?>">
									<svg class="icon"><use xlink:href="#cart"></use></svg>
								</a>
							</div>
						<?else:?>
							<div class="product__action">
								<a data-fancybox data-type="ajax" data-touch="false" data-src="/local/ajax/form/aviable.php?ajax=y&id=<?=$arItem['ID']?>" class="adp-btn adp-btn--light adp-btn--sm miniBtnLignt has-icon-left">
									<svg class="icon"><use xlink:href="#bell"></use></svg>
								</a>
							</div>
						<?endif;?>
					</div>
				</div>
			</div>
		</div>
	<?endforeach;?>
</div>