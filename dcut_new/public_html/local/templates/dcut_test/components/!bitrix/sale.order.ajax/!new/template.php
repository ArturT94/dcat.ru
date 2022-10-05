<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();
if (empty($arParams['TEMPLATE_THEME'])){
	$arParams['TEMPLATE_THEME'] = Main\ModuleManager::isModuleInstalled('bitrix.eshop') ? 'site' : 'blue';
}
if ($arParams['TEMPLATE_THEME'] === 'site'){
	$templateId = Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', $component->getSiteId());
	$templateId = preg_match('/^eshop_adapt/', $templateId) ? 'eshop_adapt' : $templateId;
	$arParams['TEMPLATE_THEME'] = Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', $component->getSiteId());
}
$arParams['ALLOW_USER_PROFILES'] = $arParams['ALLOW_USER_PROFILES'] === 'Y' ? 'Y' : 'N';
$arParams['SKIP_USELESS_BLOCK'] = $arParams['SKIP_USELESS_BLOCK'] === 'N' ? 'N' : 'Y';
if (!isset($arParams['SHOW_ORDER_BUTTON'])){
	$arParams['SHOW_ORDER_BUTTON'] = 'final_step';
}
$arParams['HIDE_ORDER_DESCRIPTION'] = isset($arParams['HIDE_ORDER_DESCRIPTION']) && $arParams['HIDE_ORDER_DESCRIPTION'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_TOTAL_ORDER_BUTTON'] = $arParams['SHOW_TOTAL_ORDER_BUTTON'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] = $arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_PAY_SYSTEM_INFO_NAME'] = $arParams['SHOW_PAY_SYSTEM_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_LIST_NAMES'] = $arParams['SHOW_DELIVERY_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_INFO_NAME'] = $arParams['SHOW_DELIVERY_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_PARENT_NAMES'] = $arParams['SHOW_DELIVERY_PARENT_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_STORES_IMAGES'] = $arParams['SHOW_STORES_IMAGES'] === 'N' ? 'N' : 'Y';
if (!isset($arParams['BASKET_POSITION']) || !in_array($arParams['BASKET_POSITION'], array('before', 'after'))){
	$arParams['BASKET_POSITION'] = 'after';
}
$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['SHOW_BASKET_HEADERS'] = $arParams['SHOW_BASKET_HEADERS'] === 'Y' ? 'Y' : 'N';
$arParams['HIDE_DETAIL_PAGE_URL'] = isset($arParams['HIDE_DETAIL_PAGE_URL']) && $arParams['HIDE_DETAIL_PAGE_URL'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERY_FADE_EXTRA_SERVICES'] = $arParams['DELIVERY_FADE_EXTRA_SERVICES'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_COUPONS'] = isset($arParams['SHOW_COUPONS']) && $arParams['SHOW_COUPONS'] === 'N' ? 'N' : 'Y';
if ($arParams['SHOW_COUPONS'] === 'N'){
	$arParams['SHOW_COUPONS_BASKET'] = 'N';
	$arParams['SHOW_COUPONS_DELIVERY'] = 'N';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = 'N';
}else{
	$arParams['SHOW_COUPONS_BASKET'] = isset($arParams['SHOW_COUPONS_BASKET']) && $arParams['SHOW_COUPONS_BASKET'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_DELIVERY'] = isset($arParams['SHOW_COUPONS_DELIVERY']) && $arParams['SHOW_COUPONS_DELIVERY'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = isset($arParams['SHOW_COUPONS_PAY_SYSTEM']) && $arParams['SHOW_COUPONS_PAY_SYSTEM'] === 'N' ? 'N' : 'Y';
}
$arParams['SHOW_NEAREST_PICKUP'] = $arParams['SHOW_NEAREST_PICKUP'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERIES_PER_PAGE'] = isset($arParams['DELIVERIES_PER_PAGE']) ? intval($arParams['DELIVERIES_PER_PAGE']) : 9;
$arParams['PAY_SYSTEMS_PER_PAGE'] = isset($arParams['PAY_SYSTEMS_PER_PAGE']) ? intval($arParams['PAY_SYSTEMS_PER_PAGE']) : 9;
$arParams['PICKUPS_PER_PAGE'] = isset($arParams['PICKUPS_PER_PAGE']) ? intval($arParams['PICKUPS_PER_PAGE']) : 5;
$arParams['SHOW_PICKUP_MAP'] = $arParams['SHOW_PICKUP_MAP'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_MAP_IN_PROPS'] = $arParams['SHOW_MAP_IN_PROPS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_YM_GOALS'] = $arParams['USE_YM_GOALS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';
$useDefaultMessages = !isset($arParams['USE_CUSTOM_MAIN_MESSAGES']) || $arParams['USE_CUSTOM_MAIN_MESSAGES'] != 'Y';
if ($useDefaultMessages || !isset($arParams['MESS_AUTH_BLOCK_NAME'])){
	$arParams['MESS_AUTH_BLOCK_NAME'] = Loc::getMessage('AUTH_BLOCK_NAME_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_REG_BLOCK_NAME'])){
	$arParams['MESS_REG_BLOCK_NAME'] = Loc::getMessage('REG_BLOCK_NAME_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_BASKET_BLOCK_NAME'])){
	$arParams['MESS_BASKET_BLOCK_NAME'] = Loc::getMessage('BASKET_BLOCK_NAME_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_REGION_BLOCK_NAME'])){
	$arParams['MESS_REGION_BLOCK_NAME'] = Loc::getMessage('REGION_BLOCK_NAME_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_PAYMENT_BLOCK_NAME'])){
	$arParams['MESS_PAYMENT_BLOCK_NAME'] = Loc::getMessage('PAYMENT_BLOCK_NAME_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_BLOCK_NAME'])){
	$arParams['MESS_DELIVERY_BLOCK_NAME'] = Loc::getMessage('DELIVERY_BLOCK_NAME_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_BUYER_BLOCK_NAME'])){
	$arParams['MESS_BUYER_BLOCK_NAME'] = Loc::getMessage('BUYER_BLOCK_NAME_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_BACK'])){
	$arParams['MESS_BACK'] = Loc::getMessage('BACK_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_FURTHER'])){
	$arParams['MESS_FURTHER'] = Loc::getMessage('FURTHER_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_EDIT'])){
	$arParams['MESS_EDIT'] = Loc::getMessage('EDIT_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_ORDER'])){
	$arParams['MESS_ORDER'] = $arParams['~MESS_ORDER'] = Loc::getMessage('ORDER_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_PRICE'])){
	$arParams['MESS_PRICE'] = Loc::getMessage('PRICE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_PERIOD'])){
	$arParams['MESS_PERIOD'] = Loc::getMessage('PERIOD_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_NAV_BACK'])){
	$arParams['MESS_NAV_BACK'] = Loc::getMessage('NAV_BACK_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_NAV_FORWARD'])){
	$arParams['MESS_NAV_FORWARD'] = Loc::getMessage('NAV_FORWARD_DEFAULT');
}
$useDefaultMessages = !isset($arParams['USE_CUSTOM_ADDITIONAL_MESSAGES']) || $arParams['USE_CUSTOM_ADDITIONAL_MESSAGES'] != 'Y';
if ($useDefaultMessages || !isset($arParams['MESS_PRICE_FREE'])){
	$arParams['MESS_PRICE_FREE'] = Loc::getMessage('PRICE_FREE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_ECONOMY'])){
	$arParams['MESS_ECONOMY'] = Loc::getMessage('ECONOMY_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_REGISTRATION_REFERENCE'])){
	$arParams['MESS_REGISTRATION_REFERENCE'] = Loc::getMessage('REGISTRATION_REFERENCE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_1'])){
	$arParams['MESS_AUTH_REFERENCE_1'] = Loc::getMessage('AUTH_REFERENCE_1_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_2'])){
	$arParams['MESS_AUTH_REFERENCE_2'] = Loc::getMessage('AUTH_REFERENCE_2_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_3'])){
	$arParams['MESS_AUTH_REFERENCE_3'] = Loc::getMessage('AUTH_REFERENCE_3_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_ADDITIONAL_PROPS'])){
	$arParams['MESS_ADDITIONAL_PROPS'] = Loc::getMessage('ADDITIONAL_PROPS_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_USE_COUPON'])){
	$arParams['MESS_USE_COUPON'] = Loc::getMessage('USE_COUPON_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_COUPON'])){
	$arParams['MESS_COUPON'] = Loc::getMessage('COUPON_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_PERSON_TYPE'])){
	$arParams['MESS_PERSON_TYPE'] = Loc::getMessage('PERSON_TYPE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PROFILE'])){
	$arParams['MESS_SELECT_PROFILE'] = Loc::getMessage('SELECT_PROFILE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_REGION_REFERENCE'])){
	$arParams['MESS_REGION_REFERENCE'] = Loc::getMessage('REGION_REFERENCE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_PICKUP_LIST'])){
	$arParams['MESS_PICKUP_LIST'] = Loc::getMessage('PICKUP_LIST_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_NEAREST_PICKUP_LIST'])){
	$arParams['MESS_NEAREST_PICKUP_LIST'] = Loc::getMessage('NEAREST_PICKUP_LIST_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PICKUP'])){
	$arParams['MESS_SELECT_PICKUP'] = Loc::getMessage('SELECT_PICKUP_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_INNER_PS_BALANCE'])){
	$arParams['MESS_INNER_PS_BALANCE'] = Loc::getMessage('INNER_PS_BALANCE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_ORDER_DESC'])){
	$arParams['MESS_ORDER_DESC'] = Loc::getMessage('ORDER_DESC_DEFAULT');
}
$useDefaultMessages = !isset($arParams['USE_CUSTOM_ERROR_MESSAGES']) || $arParams['USE_CUSTOM_ERROR_MESSAGES'] != 'Y';
if ($useDefaultMessages || !isset($arParams['MESS_PRELOAD_ORDER_TITLE'])){
	$arParams['MESS_PRELOAD_ORDER_TITLE'] = Loc::getMessage('PRELOAD_ORDER_TITLE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_SUCCESS_PRELOAD_TEXT'])){
	$arParams['MESS_SUCCESS_PRELOAD_TEXT'] = Loc::getMessage('SUCCESS_PRELOAD_TEXT_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_FAIL_PRELOAD_TEXT'])){
	$arParams['MESS_FAIL_PRELOAD_TEXT'] = Loc::getMessage('FAIL_PRELOAD_TEXT_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TITLE'])){
	$arParams['MESS_DELIVERY_CALC_ERROR_TITLE'] = Loc::getMessage('DELIVERY_CALC_ERROR_TITLE_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TEXT'])){
	$arParams['MESS_DELIVERY_CALC_ERROR_TEXT'] = Loc::getMessage('DELIVERY_CALC_ERROR_TEXT_DEFAULT');
}
if ($useDefaultMessages || !isset($arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'])){
	$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] = Loc::getMessage('PAY_SYSTEM_PAYABLE_ERROR_DEFAULT');
}
$scheme = $request->isHttps() ? 'https' : 'http';
switch (LANGUAGE_ID){
	case 'ru':
		$locale = 'ru-RU'; break;
	case 'ua':
		$locale = 'ru-UA'; break;
	case 'tk':
		$locale = 'tr-TR'; break;
	default:
		$locale = 'en-US'; break;
}

$this->addExternalJs($templateFolder.'/order_ajax.js');
\Bitrix\Sale\PropertyValueCollection::initJs();
$this->addExternalJs($templateFolder.'/script.js');
?>
<NOSCRIPT>
	<div style="color:red"><?=Loc::getMessage('SOA_NO_JS')?></div>
</NOSCRIPT>
<?
if (strlen($request->get('ORDER_ID')) > 0){
	include(Main\Application::getDocumentRoot().$templateFolder.'/confirm.php');
}elseif ($arParams['DISABLE_BASKET_REDIRECT'] === 'Y' && $arResult['SHOW_EMPTY_BASKET']){
	include(Main\Application::getDocumentRoot().$templateFolder.'/empty.php');
}else{
	$hideDelivery = empty($arResult['DELIVERY']);
	
	$value = 0;
	if(is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0){
		foreach($arProperties["VARIANTS"] as $arVariant){
			if($arVariant["SELECTED"] == "Y"){
				$value = $arVariant["ID"];
				break;
			}
			if($_COOKIE['regions_location_id']){
				$value = $_COOKIE['regions_location_id'];
			}
		}
	}
								
	//pre($arResult['ORDER_PROP']['USER_PROPS_Y']);
?>
<form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="form" name="ORDER_FORM" id="bx-soa-order-form" enctype="multipart/form-data">
	<div id="bx-soa-order">
		<?echo bitrix_sessid_post(); if (strlen($arResult['PREPAY_ADIT_FIELDS']) > 0){ echo $arResult['PREPAY_ADIT_FIELDS']; } ?>
		<input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="saveOrderAjax">
		<input type="hidden" name="location_type" value="code">
		<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult['BUYER_STORE']?>">
		<input type="hidden" name="ORDER_PROP_12" id="soa-property-12">
		<input type="hidden" name="ORDER_PROP_13" id="soa-property-13">


		<div class="cart-order">
			<h2>Оформление заказа</h2>
			<div class="cart-order__group step-current">
				<div class="cart-order__header">
					<div class="d-flex align-items-center flex-grow-1">
                        <div class="cart-step__success"><svg class="icon"><use xlink:href="#check"></use></svg></div>
                        <span>1.</span><div class="cart-registration-caption">Доставка</div>

                        <div class="cart-step__change">
                            <a href="#" class="btn-link--primary">Изменить</a>
                        </div>
                    </div>

                    <div class="cart-end-address">Конечный адрес доставки</div>
				</div>
				<div class="cart-order__body">
					<div class="cart-order__tip">От выбранного города зависят доступные виды доставки и стоимость</div>
					
					<div class="form-group-inline form-group--city">
						<?foreach($arResult['ORDER_PROP']['USER_PROPS_Y'] as $arProperties):?>
							<?if($arProperties['IS_LOCATION'] == 'Y'):?>
								<?
								$value = $APPLICATION->get_cookie('CURRENT_REGION');
								CSaleLocation::proxySaleAjaxLocationsComponent(
									array(
										"AJAX_CALL" => "N",
										"COUNTRY_INPUT_NAME" => "COUNTRY",
										"REGION_INPUT_NAME" => "REGION",
										"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
										"CITY_OUT_LOCATION" => "Y",
										"LOCATION_VALUE" => $value,
										"ORDER_PROPS_ID" => $arProperties["ID"],
										"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
										"SIZE1" => $arProperties["SIZE1"],
									),
									array(
										"ID" => $value,
										"CODE" => "",
										"SHOW_DEFAULT_LOCATIONS" => "Y",
										"JS_CALLBACK" => "submitFormProxy",
										//"JS_CONTROL_DEFERRED_INIT" => intval($arProperties["ID"]),
										//"JS_CONTROL_GLOBAL_ID" => intval($arProperties["ID"]),
										"DISABLE_KEYBOARD_INPUT" => "Y",
										"PRECACHE_LAST_LEVEL" => "Y",
										"PRESELECT_TREE_TRUNK" => "Y",
										"SUPPRESS_ERRORS" => "Y"
									),
									'search',
									true
								)?>
							<?endif;?>
						<?endforeach;?>
						<svg class="icon"><use xlink:href="#search"></use></svg>
					</div>

					<div class="cart-order__subtitle">Способ доставки</div>
					<!--	DELIVERY BLOCK	-->

			
			
						
						<div class="cart-checkbox__container deliveryAjaxBlock">
							<?$count=0;
							foreach ($arResult['DELIVERY'] as $id => $delivery):
							$explode_name = explode('(',$delivery['NAME']);
							if($explode_name[1]){
								$explode_name = explode(')',$explode_name[1]);
							}
							?>
								<label class="cart-checkbox">
									<input type="radio"<?if($count==0):$delivery_checked_id = $id;?> checked<?endif;?> class="cart-checkbox__value delivery-method delivery-pickup-val" id="ID_DELIVERY_ID_<?= $id ?>" name="DELIVERY_ID" value="<?= $id ?>">
									<span class="cart-checkbox__icon"><svg class="icon"><use xlink:href="#check"></use></svg></span>
									<span class="cart-checkbox__content">
										<span class="cart-checkbox__title"><?= $explode_name[0] ?></span>
										<span class="cart-checkbox__description"><?= $delivery['DESCRIPTION'] ?></span>
										<?if($delivery['ID'] == 18):?>
											<span class="cart-checkbox__description">
												<div id="sdekmapshow">Показать пункты самовывоза</div>
											</span>
										<?endif;?>
										<span class="cart-checkbox__price" data-price="<?= $delivery['PRICE'] ?>">
											<?if($delivery['PRICE'] == 0):?>Бесплатно<?else:?><? if($delivery['ID'] == 2){echo "от ";}?><?= $delivery['PRICE_FORMATED'] ?><?endif;?>
										</span>
									</span>
								</label>
								<?$count++;?>
							<? endforeach; ?>
						</div>
					
					<div class="cartDeliveryAddress" style="display: none">
						<div class="cart-order__subtitle">Адрес доставки</div>
						<div class="delivery-address__group">
							<div class="form-group f-group--street">
								<input type="text" name="ORDER_PROP_7" class="form-control" id="soa-property-7" placeholder="Улица *">
							</div>
							<div class="form-group f-group--house">
								<input type="text" name="ORDER_PROP_9" class="form-control" id="soa-property-9" placeholder="Дом *">
							</div>
							<div class="f-group-separator"></div>
							<div class="form-group f-group--flat">
								<input type="text" name="ORDER_PROP_10" class="form-control" id="soa-property-10" placeholder="Квартира / офис *">
							</div>
							<div class="form-group f-group--index">
								<input type="text" name="ORDER_PROP_4" class="form-control" id="soa-property-4" placeholder="Индекс *">
							</div>
						</div>
					  </div>
					
					<?$frame = new \Bitrix\Main\Page\FrameBuffered("orderAjaxShop"); 
					$frame->begin();
					foreach($arResult['JS_DATA']['GRID']['ROWS'] as $product){
						//$other_shop = Prymery\Regionality::QuantityOtherShop($product['data']['PRODUCT_ID']);
						unset($allStores);
						$allStores = Prymery\Regionality::getAllStoreFromProduct($product['data']['PRODUCT_ID']);

						if($allStores){
							//Собираем массив для карты
							foreach($allStores as $i=>$shop){
								$allStoresNew[$shop['ID']]['INFO'] = $shop;
								$allStoresNew[$shop['ID']]['PRODUCTS'][$product['data']['PRODUCT_ID']] = $product['data']['PRODUCT_ID'];
								
								if($shop['UF_COORDS']){
									$arMap[$shop['ID']] = array('ID' => $shop['ID'],'COORDS' => $shop['UF_COORDS'],'TITLE' => $shop['TITLE'],'PHONE' => $shop['PHONE'],'SCHEDULE' => $shop['SCHEDULE']);
									//$arMap[$shop['ID']]['PRODUCTS'][] = $product['data']['PRODUCT_ID'];
								}
							}
						}
					}
					if($arMap){
						foreach($arMap as $map){
							$arNewMap[] = $map;
						}
					}
					$realRegion = Prymery\Regionality::getRealRegionByIP();
					?>
						<div class="cart-product__aviability"<?if($delivery_checked_id == 3):?> style="display:block;"<?endif;?>>
							<div class="product__availability">
								<div class="shops__container">
									<div class="shops__list">
										<div class="shops__count">Найдено <?=count($allStoresNew);?> <?=endingsForm(count($allStoresNew),'магазин','магазина','магазинов');?></div>
										
										<?foreach($allStoresNew as $shop):?>
											<div class="shops__item">
												<div class="shops__title">
													<svg class="icon"><use xlink:href="#pin"></use></svg>
													<?=str_replace($realRegion['NAME'].',','',$shop['INFO']['TITLE'])?>
												</div>
												<div class="product-shops__aviable">
													<div class="shops__worktime"><?=$shop['INFO']['SCHEDULE']?></div>
													<?if(count($arResult['JS_DATA']['GRID']['ROWS']) == count($shop['PRODUCTS'])):?>
														<div class="shops__all">Забрать весь заказ</div>
													<?else:?>
														<div class="product-partials">
															<div class="header">
																Забрать <?=count($shop['PRODUCTS']);?> из <?=count($arResult['JS_DATA']['GRID']['ROWS']);?>
																<svg class="icon"><use xlink:href="#angle-down"></use></svg>
															</div>
															<div class="body" style="display: none;">
																<?foreach($arResult['JS_DATA']['GRID']['ROWS'] as $product):?>
																	<div class="product-partials__item<?if(!$shop['PRODUCTS'][$product['data']['PRODUCT_ID']]):?> notavailable<?endif;?>">
																		<div class="product-partials__thumb">
																			<a href="<?=$product['data']['DETAIL_PAGE_URL']?>">
																				<img src="<?=$product['data']['PREVIEW_PICTURE_SRC']?>">
																			</a>
																		</div>
																		<div class="product-partials__content">
																			<a href="<?=$product['data']['DETAIL_PAGE_URL']?>" class="product-partials__title"><?=$product['data']['NAME']?></a>
																			<div class="product-partials__footer">
																				<div class="product-partials__price"><?=$product['data']['SUM_NUM']?> <span class="currency">₽</span></div>
																				<?=Prymery\Regionality::getQuantityStore($product['data']['PRODUCT_ID'],$shop['INFO']['ID']);?>
																			</div>
																		</div>
																	</div>
																<?endforeach;?>
															</div>
														</div>
													<?endif;?>
												</div>

												<label class="color-checkbox">
													<input type="radio" data-id="mapshoplink_<?=$shop['INFO']['ID']?>" data-coords="<?=$shop['INFO']['UF_COORDS']?>" data-name="<?=$shop['INFO']['TITLE']?>" class="color-checkox__value mapShopDetail" name="ORDER_SHOP" value="<?=$shop['INFO']['ID']?>">
													<div class="color-checkbox__icon">
														<svg class="icon"><use xlink:href="#check"></use></svg>
													</div>
												</label>
											</div>
										<?endforeach;?>
										<?if($arNewMap):?>
											<script type="text/javascript">
												ymaps.ready(init);
												function init() {
													var arCoords = <?=CUtil::PhpToJsObject($arNewMap);?>;
													
													var centerMap = arCoords[0]['COORDS'].split(',');
													var myMap = new ymaps.Map("maporder", {
															center: [centerMap[0],centerMap[1]],
															zoom: 10
														}, {
															searchControlProvider: 'yandex#search'
														});

													for(var i=0;i<arCoords.length;i++){
														var map_coords = arCoords[i]['COORDS'].split(',');
														if(map_coords[1]){
															myMap.geoObjects
																.add(new ymaps.Placemark([map_coords[0],map_coords[1]], {
																	id: 'mapshoplink_'+arCoords[i].ID,
																	balloonContent: '<b>Адрес:</b>'+arCoords[i].TITLE + '<br /> <b>Телефон:</b> '+arCoords[i].PHONE+'<br /> <b>Режим работы:</b> '+arCoords[i].SCHEDULE+''
																}, {
																	preset: 'islands#blueShoppingCircleIcon',
																	iconColor: '#FB611F'
																}));
															var arId;
															myMap.geoObjects.events.add('click', function(e) {
																var target = e.get('target');
																if(arId != target.properties.get('id')){
																	arId = target.properties.get('id');
																	$('input[data-id='+arId+']').prop('checked',true);
																	$('input[data-id='+arId+']').change();
																}
															});
														}
													}
													$('.mapShopDetail').on('change', function(){
														var coords = $(this).data('coords');
														coords = coords.split(',');
														var val = $(this).val();
														var name = $(this).data('name');
														$('#soa-property-13').val(name);
														
														//Центруем карту и открываем нужный нам баллун
														var indexObj = $(this).parent().parent().index();
														indexObj = indexObj - 1;
														var point = myMap.geoObjects.get(indexObj);
														var npoint = $.map(point.geometry.getCoordinates(), Number);
														myMap.setCenter(npoint, 15, {checkZoomRange: true}).then(function () {point.balloon.open();}, function (err) {}, this);
													});
												}
												
												
											</script>
										<?endif;?>
									</div>
									<div class="shops-map">
										<div id="maporder" style="width: 100%; height: 560px"></div>
									</div>
								</div>
							</div>
						</div>
					<?$frame->end();?>
					
					<div class="cart-order__continue">
						<div class="adp-btn adp-btn--primary adp-btn--md orderStepDelivery disabled">Продолжить</div>
					</div>
				</div>
			</div>

			<div class="orderGroupPayment cart-order__group notactive">
				<div class="cart-order__header">
					<div class="cart-step__success"><svg class="icon"><use xlink:href="#check"></use></svg></div>
					<span>2.</span><div class="cart-payment-caption">Оплата</div>

                    <div class="cart-step__change">
                        <a href="#" class="btn-link--primary">Изменить</a>
                    </div>
				</div>
				<div class="cart-order__body" style="display: none">
					<div class="cart-order__tip">Выберите, как вам удобнее оплатить заказ</div>
					<div class="cart-checkbox__container">
						<?$count=0;
						foreach ($arResult['PAY_SYSTEM'] as $id => $paysystem):?>
							<label class="cart-checkbox">
								<input type="radio"<?if($count==0):$delivery_checked_id = $id;?> checked<?endif;?> class="paymentMethodVal cart-checkbox__value" value="<?=$paysystem['ID'] ?>" name="PAY_SYSTEM_ID" id="ID_PAY_SYSTEM_ID_<?=$paysystem['ID']?>">
								<span class="cart-checkbox__icon"><svg class="icon"><use xlink:href="#check"></use></svg></span>
								<span class="cart-checkbox__content">
									<?if($paysystem['DESCRIPTION']):?>
										<span class="cart-checkbox__title"><?= $paysystem['DESCRIPTION'] ?></span>
									<?endif;?>
									<span class="cart-checkbox__description"><?= $paysystem['NAME'] ?></span>
									
									<?if($paysystem['ID'] == 10):?>
										<ul class="payments__list">
											<li><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/payment/mir.svg" alt="MIR"></li>
											<li><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/payment/visa.svg" alt="Visa"></li>
											<li><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/payment/master-card.svg" alt="MasterCard"></li>
										</ul>
									<?endif;?>
								</span>
							</label>
							<?$count++;?>
						<? endforeach; ?>
					</div>
					<div class="cart-order__continue">
						<div class="adp-btn adp-btn--primary adp-btn--md orderStepPay">Продолжить</div>
					</div>
				</div>
			</div>

			<div class="cart-order__group notactive">
				<div class="cart-order__header">
					<div class="cart-step__success"><svg class="icon"><use xlink:href="#check"></use></svg></div>
					<span>3.</span>Получатель

                    <div class="cart-step__change">
                        <a href="#" class="btn-link--primary">Изменить</a>
                    </div>
				</div>
				<div class="cart-order__body" style="display: none">
					<div class="cart-order__tip">
						Укажите свои данные, чтобы быть в курсе изменений статуса заказа.<br>
						Персональные данные обрабатываются в соответствии с <a href="/privacy/" class="btn-link--primary">политикой конфиденциальности</a>
					</div>
					<?global $USER;
					$rsUser = CUser::GetByID($USER->GetId());
					$arUser = $rsUser->Fetch();
					?>
					<div class="cart__delivery-info">
						<div class="cart-row">
							<div class="cart-group cart-group--md">
								<input type="text" name="ORDER_PROP_1" id="soa-property-1" placeholder="Имя *" value="<?=$arUser['NAME']?>" class="form-control" required>		
							</div>
							<div class="cart-group cart-group--md">
								<input type="text" name="ORDER_PROP_8" id="soa-property-8" placeholder="Фамилия *" value="<?=$arUser['LAST_NAME']?>" class="form-control" required>
							</div>
						</div>
						<div class="cart-row">
							<div class="cart-group cart-group--md">
								<input type="text" name="ORDER_PROP_3" id="soa-property-3" placeholder="Телефон *" value="<?=$arUser['PERSONAL_PHONE']?>" class="phoneMask form-control" required>
							</div>

							<div class="cart-group cart-group--md">
								<input type="text" name="ORDER_PROP_2" id="soa-property-2" placeholder="E-mail *" value="<?=$arUser['EMAIL']?>" class="form-control" required>
							</div>
						</div>

						<div class="cart-row">
							<div class="cart-group">
								<textarea name="ORDER_DESCRIPTION" id="orderDescription" class="form-control" rows="5" placeholder="Комментарий"></textarea>
							</div>
						</div>

						<label class="custom-checkbox custom-checkbox--silver">
							<input type="checkbox" class="custom-checkobox__value" name="news" checked>
							<span class="custom-checkobox__icon"><svg class="icon"><use xlink:href="#check"></use></svg></span>
							<span class="custom-checkobox__text">Хочу получать уведомления о скидках и акциях</span>
						</label>
					</div>
					
					<div class="cart-order__continue">
						<div class="adp-btn adp-btn--primary adp-btn--md orderStepProps disabled">Продолжить</div>
					</div>
					<script>
						/*Static check step props*/
						var error = false;
						if(!$('input[name=ORDER_PROP_1]').val()){
							error = true;
						}
						if(!$('input[name=ORDER_PROP_8]').val()){
							error = true;
						}
						if(!$('input[name=ORDER_PROP_3]').val()){
							error = true;
						}
						if(!$('input[name=ORDER_PROP_2]').val()){
							error = true;
						}
						if(!error){$(".orderStepProps").removeClass('disabled');}
					</script>
				</div>
			</div>
		</div>
					

		<div style="display: none">
			
		</div>
		<div style="display:none;">
		   <div class="ordering__group bx-soa-section bx-active" id="bx-soa-paysystem" data-visited="false">
			   <div class="bx-soa-section-title-container">
				   <h2 class="bx-soa-section-title col-sm-9"><span class="bx-soa-section-title-count"></span>Оплата</h2>
				   <div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep" style="">изменить</a></div>
			   </div>
			   <div class="bx-soa-section-content container-fluid"></div>
		   </div>
		</div>
		<div class="col-sm-9 bx-soa" style="display: none">
			<!--	BUYER PROPS BLOCK	-->
			<div id="bx-soa-properties" data-visited="false" class="bx-soa-section">
				<div class="bx-soa-section-title-container">
					<h2 class="bx-soa-section-title col-sm-9">
						<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BUYER_BLOCK_NAME']?>
					</h2>
					<div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
				</div>
				<div class="bx-soa-section-content container-fluid"></div>
			</div>
			<div id="bx-soa-main-notifications">
				<div class="alert alert-danger" style="display:none"></div>
				<div data-type="informer" style="display:none"></div>
			</div>
			<!--	AUTH BLOCK	-->
			<div id="bx-soa-auth" class="bx-soa-section bx-soa-auth" style="display:none">
				<div class="bx-soa-section-title-container">
					<h2 class="bx-soa-section-title col-sm-9">
						<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_AUTH_BLOCK_NAME']?>
					</h2>
				</div>
				<div class="bx-soa-section-content container-fluid"></div>
			</div>
			<!--	DUPLICATE MOBILE ORDER SAVE BLOCK	-->
			<div id="bx-soa-total-mobile" style="margin-bottom: 6px;"></div>
			<!--	BASKET ITEMS BLOCK	-->
			<div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
				<div class="bx-soa-section-title-container">
					<h2 class="bx-soa-section-title col-sm-9">
						<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BASKET_BLOCK_NAME']?>
					</h2>
					<div class="col-xs-12 col-sm-3 text-right"><a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
				</div>
				<div class="bx-soa-section-content container-fluid"></div>
			</div>
			<!--	REGION BLOCK	-->
			<div id="bx-soa-region" data-visited="false" class="bx-soa-section bx-active">
				<div class="bx-soa-section-title-container">
					<h2 class="bx-soa-section-title col-sm-9">
						<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_REGION_BLOCK_NAME']?>
					</h2>
					<div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
				</div>
				<div class="bx-soa-section-content container-fluid"></div>
			</div>
			<!--	PICKUP BLOCK	-->
			<div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
				<div class="bx-soa-section-title-container">
					<h2 class="bx-soa-section-title col-sm-9">
						<span class="bx-soa-section-title-count"></span>
					</h2>
					<div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
				</div>
				<div class="bx-soa-section-content container-fluid"></div>
			</div>
			<div style="display: none;">
				<div id='bx-soa-basket-hidden' class="bx-soa-section"></div>
				<div id='bx-soa-region-hidden' class="bx-soa-section"></div>
				<div id='bx-soa-paysystem-hidden' class="bx-soa-section"></div>
				<div id='bx-soa-delivery-hidden' class="bx-soa-section"></div>
				<div id='bx-soa-pickup-hidden' class="bx-soa-section"></div>
				<div id="bx-soa-properties-hidden" class="bx-soa-section"></div>
				<div id="bx-soa-auth-hidden" class="bx-soa-section">
					<div class="bx-soa-section-content container-fluid reg"></div>
				</div>
			</div>
		</div>
		<!--	SIDEBAR BLOCK	-->
		<div id="bx-soa-total" class="col-sm-3 bx-soa-sidebar" style="display: none">
			<div class="bx-soa-cart-total-ghost"></div>
			<div class="bx-soa-cart-total"></div>
		</div>
	</div>
</form>


<div id="bx-soa-saved-files" style="display:none"></div>
<div id="bx-soa-soc-auth-services" style="display:none">
	<?
	$arServices = false;
	$arResult['ALLOW_SOCSERV_AUTHORIZATION'] = Main\Config\Option::get('main', 'allow_socserv_authorization', 'Y') != 'N' ? 'Y' : 'N';
	$arResult['FOR_INTRANET'] = false;

	if (Main\ModuleManager::isModuleInstalled('intranet') || Main\ModuleManager::isModuleInstalled('rest'))
		$arResult['FOR_INTRANET'] = true;

	if (Main\Loader::includeModule('socialservices') && $arResult['ALLOW_SOCSERV_AUTHORIZATION'] === 'Y')
	{
		$oAuthManager = new CSocServAuthManager();
		$arServices = $oAuthManager->GetActiveAuthServices(array(
			'BACKURL' => $this->arParams['~CURRENT_PAGE'],
			'FOR_INTRANET' => $arResult['FOR_INTRANET'],
		));

		if (!empty($arServices))
		{
			$APPLICATION->IncludeComponent(
				'bitrix:socserv.auth.form',
				'flat',
				array(
					'AUTH_SERVICES' => $arServices,
					'AUTH_URL' => $arParams['~CURRENT_PAGE'],
					'POST' => $arResult['POST'],
				),
				$component,
				array('HIDE_ICONS' => 'Y')
			);
		}
	}
	?>
</div>

<div style="display: none">
	<?
	$APPLICATION->IncludeComponent(
		'bitrix:sale.location.selector.steps',
		'.default',
		array(),
		false
	);
	$APPLICATION->IncludeComponent(
		'bitrix:sale.location.selector.search',
		'.default',
		array(),
		false
	);
	?>
</div>
<?
$signer = new Main\Security\Sign\Signer;
$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');
$messages = Loc::loadLanguageFile(__FILE__);
?>
<script>
	BX.message(<?=CUtil::PhpToJSObject($messages)?>);
	BX.Sale.OrderAjaxComponent.init({
		result: <?=CUtil::PhpToJSObject($arResult['JS_DATA'])?>,
		locations: <?=CUtil::PhpToJSObject($arResult['LOCATIONS'])?>,
		params: <?=CUtil::PhpToJSObject($arParams)?>,
		signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
		siteID: '<?=CUtil::JSEscape($component->getSiteId())?>',
		ajaxUrl: '<?=CUtil::JSEscape($component->getPath().'/ajax.php')?>',
		templateFolder: '<?=CUtil::JSEscape($templateFolder)?>',
		propertyValidation: true,
		showWarnings: true,
		pickUpMap: {
			defaultMapPosition: {
				lat: 55.76,
				lon: 37.64,
				zoom: 7
			},
			secureGeoLocation: false,
			geoLocationMaxTime: 5000,
			minToShowNearestBlock: 3,
			nearestPickUpsToShow: 3
		},
		propertyMap: {
			defaultMapPosition: {
				lat: 55.76,
				lon: 37.64,
				zoom: 7
			}
		},
		orderBlockId: 'bx-soa-order',
		authBlockId: 'bx-soa-auth',
		basketBlockId: 'bx-soa-basket',
		regionBlockId: 'bx-soa-region',
		paySystemBlockId: 'bx-soa-paysystem',
		deliveryBlockId: 'bx-soa-delivery',
		pickUpBlockId: 'bx-soa-pickup',
		propsBlockId: 'bx-soa-properties',
		totalBlockId: 'bx-soa-total'
	});
</script>
<script>
	<?$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();?>
	BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
		'source' => $component->getPath().'/get.php',
		'cityTypeId' => intval($city['ID']),
		'messages' => array(
			'otherLocation' => '--- '.Loc::getMessage('SOA_OTHER_LOCATION'),
			'moreInfoLocation' => '--- '.Loc::getMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
			'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.Loc::getMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.Loc::getMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
					'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
					'#ANCHOR_END#' => '</a>'
				)).'</div>'
		)
	))?>);
</script>
<?if ($arParams['SHOW_PICKUP_MAP'] === 'Y' || $arParams['SHOW_MAP_IN_PROPS'] === 'Y'){
	if ($arParams['PICKUP_MAP_TYPE'] === 'yandex'){
		$this->addExternalJs($templateFolder.'/scripts/yandex_maps.js');
		?>
		<?/*script src="<?=$scheme?>://api-maps.yandex.ru/2.1.50/?load=package.full&lang=<?=$locale?>"></script*/?>
		<script>
			(function bx_ymaps_waiter(){
				if (typeof ymaps !== 'undefined' && BX.Sale && BX.Sale.OrderAjaxComponent)
					ymaps.ready(BX.proxy(BX.Sale.OrderAjaxComponent.initMaps, BX.Sale.OrderAjaxComponent));
				else
					setTimeout(bx_ymaps_waiter, 100);
			})();
		</script>
	<? }
	if ($arParams['PICKUP_MAP_TYPE'] === 'google'){
		$this->addExternalJs($templateFolder.'/scripts/google_maps.js');
		$apiKey = htmlspecialcharsbx(Main\Config\Option::get('fileman', 'google_map_api_key', ''));
		?>
		<script async defer
			src="<?=$scheme?>://maps.googleapis.com/maps/api/js?key=<?=$apiKey?>&callback=bx_gmaps_waiter">
		</script>
		<script>
			function bx_gmaps_waiter()
			{
				if (BX.Sale && BX.Sale.OrderAjaxComponent)
					BX.Sale.OrderAjaxComponent.initMaps();
				else
					setTimeout(bx_gmaps_waiter, 100);
			}
		</script>
	<?}
}
if ($arParams['USE_YM_GOALS'] === 'Y'){?>
	<script>
		(function bx_counter_waiter(i){
			i = i || 0;
			if (i > 50)
				return;

			if (typeof window['yaCounter<?=$arParams['YM_GOALS_COUNTER']?>'] !== 'undefined')
				BX.Sale.OrderAjaxComponent.reachGoal('initialization');
			else
				setTimeout(function(){bx_counter_waiter(++i)}, 100);
		})();
	</script>
<?}
}
?>