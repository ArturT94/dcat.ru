<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["CATEGORIES"][0]["ITEMS"] as $i => $arItem){
	if($arItem["NAME"] != 'остальные'){
		if($arItem['ITEM_ID']){
			$res = CIBlockElement::GetByID($arItem['ITEM_ID']);
			if($ar_res = $res->Fetch()){
				$allProduct[$arItem['ITEM_ID']] = $ar_res;
				$nav = CIBlockSection::GetNavChain(false, $ar_res['IBLOCK_SECTION_ID']);
				while($section = $nav->ExtractFields("nav_")){
					if($section['DEPTH_LEVEL'] == 1){
						$arFilter = Array('IBLOCK_ID'=>CATALOG_IBLOCK_ID, 'GLOBAL_ACTIVE'=>'Y', 'ID'=>$section['ID']);
						$db_list = CIBlockSection::GetList(Array(), $arFilter, true);
						while($ar_result = $db_list->GetNext()){
							unset($iblock_section_id);
							$iblock_section_id = $ar_result['SECTION_PAGE_URL'];
						}
						$arResult['CUSTOM_SECTIONS'][$section['NAME']] = $iblock_section_id;
						//$arResult['CUSTOM_SECTIONS'][$section['NAME']] = $APPLICATION->GetCurPageParam().'&section='.$ar_res['ID'];
					}
				}
			}
		}
	}
}
$explode_url = explode('q=',urldecode($arResult['CATEGORIES']['all']['ITEMS'][0]['URL']));
if($explode_url[1]){
	$arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID");
	$arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "NAME"=>'%'.$explode_url[1].'%', "ACTIVE"=>"Y", 'PROPERTY_HIDDEN' => false);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->Fetch()){
		if($ob['IBLOCK_SECTION_ID']){
			$nav = CIBlockSection::GetNavChain(false, $ob['IBLOCK_SECTION_ID']);
			while($section = $nav->ExtractFields("nav_")){
				if($section['DEPTH_LEVEL'] == 1){
					if(!$allSearchSection[$section['NAME']]){
						$allSearchSection[$section['NAME']] = 0;
					}
					$allSearchSection[$section['NAME']]++;
				}
			}
		}
		$allIDsCustom[] = $ob['ID'];
	}
}
$result_count=0;
foreach($arResult["CATEGORIES"][0]["ITEMS"] as $i => $arItem):
	if($arItem["NAME"] != 'остальные'):
		unset($arParentSectionName);
		$res_el = CIBlockElement::GetByID($arItem['ITEM_ID']);
		if($ar_el = $res_el->Fetch()){
			if($ar_el['IBLOCK_SECTION_ID']){
				$nav = CIBlockSection::GetNavChain(false, $ar_el['IBLOCK_SECTION_ID']);
				while($section = $nav->ExtractFields("nav_")){
					if($section['DEPTH_LEVEL'] == 1){
						$arParentSectionName = $section['NAME'];
					}
				}
			}
		}
		if(in_array($arParentSectionName,array('Хозтовары','Вода','Отчёт','Услуги'))){
			continue;
		}
		$result_count++;
	endif;
endforeach;
?>
<?if(!empty($arResult["CATEGORIES"]) && $arResult['CATEGORIES_ITEMS_EXISTS'] && $result_count>0):?>
	<div class="quick-search">
		<?if($arResult['CUSTOM_SECTIONS']):?>
		<div class="quick-search__categories">
			<div class="quick-search__title">Категории</div>
			<ul>
				<?$count = 1;foreach($allSearchSection as $name=>$count_section):
					if($name != 'Хозтовары' && $name != 'Вода' && $name != 'Отчёт' && $name != 'Услуги'):?>
						<li><a href="<?=$arResult['CUSTOM_SECTIONS'][$name]?>"><?=$name?></a><span class="count"><?=$count_section;?></span></li>
						<?if(round(count($allSearchSection)/2) == $count):?></ul><ul><?endif;?>
						<?$count++;
					endif;
				endforeach;?>
			</ul>
		</div>
		<?endif;?>
		<?if($arResult["CATEGORIES"][0]['ITEMS']):?>
			<div class="quick-search__products">
				<div class="quick-search__title">Товары</div>
				<div class="product-search__list">
					<?//foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
						<?//if($category_id != 'all'):?>
							<?foreach($arResult["CATEGORIES"][0]["ITEMS"] as $i => $arItem):
								if($arItem["NAME"] != 'остальные'):
									unset($arParentSectionName);
									unset($arActiveEl);
									unset($arcurHidden);
									$arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID",'PROPERTY_HIDDEN');
									$arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, 'ID'=>$arItem['ITEM_ID']);
									$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
									while($ob = $res->Fetch()){
										$arcurHidden = $ob['PROPERTY_HIDDEN_VALUE'];
									}
									if($arcurHidden){continue;}
									
									$res_el = CIBlockElement::GetByID($arItem['ITEM_ID']);
									if($ar_el = $res_el->Fetch()){
										$arActiveEl = $ar_el['ACTIVE'];
										if($ar_el['IBLOCK_SECTION_ID']){
											$nav = CIBlockSection::GetNavChain(false, $ar_el['IBLOCK_SECTION_ID']);
											while($section = $nav->ExtractFields("nav_")){
												if($section['DEPTH_LEVEL'] == 1){
													$arParentSectionName = $section['NAME'];
												}
											}
										}
									}
									if($arActiveEl == 'Y' && $arItem['PARAM2'] == CATALOG_IBLOCK_ID):
										if(in_array($arParentSectionName,array('Хозтовары','Вода','Отчёт','Услуги'))){
											continue;
										}
										$result_count++;
										
										unset($picture);
										unset($arPrice);
										if($arItem['ITEM_ID']){
											$picture = $allProduct[$arItem['ITEM_ID']]['PREVIEW_PICTURE'];
											$arPrice = CPrice::GetByID($arItem['ITEM_ID']);
											$arItem['CUSTOM_QUANTITY'] = Prymery\Regionality::CatalogQuantityInCurLocation($arItem['ITEM_ID']);
											if(!$arPrice){
												$res_offer = CCatalogSKU::getOffersList($arItem['ITEM_ID'],CATALOG_IBLOCK_ID,array(),array(), array());
												if($res_offer[$arItem['ITEM_ID']]){
													//Если есть торг.преды, то выводим минимальную цену и получаем количество
													if(is_array($res_offer[$arItem['ITEM_ID']])){
														foreach($res_offer[$arItem['ITEM_ID']] as $offer){
															unset($arPrice);
															$arPrice = CPrice::GetBasePrice($offer['ID']);
															$arItem['CUSTOM_QUANTITY'] = Prymery\Regionality::CatalogQuantityInCurLocation($offer['ID']);
														}
													}
												}
											}
										}
										?>
										<div class="product-search__item">
											
											<div class="product-search__thumb">
												<a href="<?= $arItem["URL"]?>">
													<?if($picture):?>
														<img src="<?=CFile::GetPath($picture);?>" alt="<?= $arItem["NAME"]?>">
													<?else:?>
														<img src="/local/templates/freevape/assets/img/no-photo.png" alt="<?= $arItem["NAME"]?>">
													<?endif;?>
												</a>
											</div>
											
											<div class="product-search__content">
												<a href="<?= $arItem["URL"]?>" class="product-search__title"><?= $arItem["NAME"]?></a>
												<?if($arItem['CUSTOM_QUANTITY'] == 'otherShop' && $arItem['CUSTOM_QUANTITY'] != 0):?>
													<div class="product__stock product__stock--unaviable product-search__stock">
														<div class="caption">есть в других<br> магазинах</div>
													</div>
												<?elseif($arItem['CUSTOM_QUANTITY'] == 'empty'):?>
													<div class="product__stock product__stock--unaviable product-search__stock">
														<div class="prodduct__stock__bar"><i></i><i></i><i></i><i></i><i></i><i></i></div>
													</div>
												<?else:?>
													<div class="product-search__stock product__stock<?= Prymery\Regionality::ProductQuantityClass($arItem['CUSTOM_QUANTITY']);?>">
														<?= Prymery\Regionality::ProductQuantityBar($arItem['CUSTOM_QUANTITY']);?>
													</div>
												<?endif;?>
												
												<div class="product-search__price">
													<?if($arPrice):?>
														<?=round($arPrice["PRICE"])?> <span class="currency">₽</span>
													<?endif;?>
												</div>
												<div class="product-search__action">
													<a href="#" class="adp-btn adp-btn--primary to_basket" data-id="<?=$arItem['ITEM_ID']?>">
														<svg class="icon"><use xlink:href="#cart"></use></svg>
													</a>
												</div>
											</div>
										</div>
									<?endif;?>
								<?endif;?>
							<?endforeach;?>
						<?//endif;?>
					<?//endforeach;?>
					<div class="product-search__all">
						<a href="<?=$arResult["CATEGORIES"]['all']['ITEMS'][0]['URL']?>" class="btn-link--primary">Все результаты</a>
					</div>
				</div>
			</div>
		<?endif;?>
	</div>
<?else:?>
	<div class="quick-search emptyResultSearch">
		К сожалению, мы не смогли найти подходящие товары по вашему запросу.<br />
		Попробуйте изменить поисковый запрос
	</div>
<?endif;?>
<script>
$('.to_basket:not(.init)').on('click', function () {
	var id = $(this).attr('data-id');
	var pack;
	var name;
	$(this).addClass('added');
	var quantity = $(this).parent().parent().find('.quantity__value').val();
	if(!quantity){
		quantity = 1;
	}
	//$(this).html('В корзине');
	$('.product-item__packaging').find('.addPack').each(function(){
		if($(this).find('input:checked').val()){
			pack = $(this).data('id');
			name = $(this).parent().parent().data('name');
		}
	});
	$.getJSON('/local/ajax/to_basket.php',
		{
			ID: id,
			PACK: pack,
			NAME: name,
			QUANTITY: quantity,
		},
		function (data) {
			$(".cart-link").html(data.BASKET_HTML);
		}
	);
});
$('.to_basket').addClass('init');
</script>