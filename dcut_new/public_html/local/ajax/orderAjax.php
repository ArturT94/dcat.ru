<?
 if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("iblock")) {
	$this->AbortResultCache();
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}
if (!CModule::IncludeModule("catalog")) {
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}
if (!CModule::IncludeModule("sale")) {
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Bitrix\Sale;


ob_start(); ?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:sale.order.ajax", 
		"new", 
		array(
			"ADDITIONAL_PICT_PROP_8" => "-",
			"ALLOW_AUTO_REGISTER" => "Y",
			"ALLOW_NEW_PROFILE" => "N",
			"ALLOW_USER_PROFILES" => "N",
			"BASKET_IMAGES_SCALING" => "standard",
			"BASKET_POSITION" => "after",
			"COMPATIBLE_MODE" => "Y",
			"DELIVERIES_PER_PAGE" => "8",
			"DELIVERY_FADE_EXTRA_SERVICES" => "Y",
			"DELIVERY_NO_AJAX" => "Y",
			"DELIVERY_NO_SESSION" => "Y",
			"DELIVERY_TO_PAYSYSTEM" => "d2p",
			"DISABLE_BASKET_REDIRECT" => "N",
			"MESS_DELIVERY_CALC_ERROR_TEXT" => "Вы можете продолжить оформление заказа, а чуть позже менеджер магазина  свяжется с вами и уточнит информацию по доставке.",
			"MESS_DELIVERY_CALC_ERROR_TITLE" => "Не удалось рассчитать стоимость доставки.",
			"MESS_FAIL_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически. Обратите внимание на развернутый блок с информацией о заказе. Здесь вы можете внести необходимые изменения или оставить как есть и нажать кнопку \"#ORDER_BUTTON#\".",
			"MESS_SUCCESS_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически. Если все заполнено верно, нажмите кнопку \"#ORDER_BUTTON#\".",
			"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
			"PATH_TO_AUTH" => "/auth/",
			"PATH_TO_BASKET" => "/",
			"PATH_TO_PAYMENT" => "payment.php",
			"PATH_TO_PERSONAL" => "index.php",
			"PAY_FROM_ACCOUNT" => "Y",
			"PAY_SYSTEMS_PER_PAGE" => "8",
			"PICKUPS_PER_PAGE" => "5",
			"PRODUCT_COLUMNS_HIDDEN" => array(
			),
			"PRODUCT_COLUMNS_VISIBLE" => array(
				0 => "PREVIEW_PICTURE",
				1 => "PROPS",
			),
			"PROPS_FADE_LIST_1" => array(
				0 => "17",
			),
			"SEND_NEW_USER_NOTIFY" => "Y",
			"SERVICES_IMAGES_SCALING" => "standard",
			"SET_TITLE" => "Y",
			"SHOW_BASKET_HEADERS" => "N",
			"SHOW_COUPONS_BASKET" => "Y",
			"SHOW_COUPONS_DELIVERY" => "Y",
			"SHOW_COUPONS_PAY_SYSTEM" => "Y",
			"SHOW_DELIVERY_INFO_NAME" => "Y",
			"SHOW_DELIVERY_LIST_NAMES" => "Y",
			"SHOW_DELIVERY_PARENT_NAMES" => "Y",
			"SHOW_MAP_IN_PROPS" => "N",
			"SHOW_NEAREST_PICKUP" => "N",
			"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
			"SHOW_ORDER_BUTTON" => "final_step",
			"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
			"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
			"SHOW_STORES_IMAGES" => "Y",
			"SHOW_TOTAL_ORDER_BUTTON" => "Y",
			"SHOW_VAT_PRICE" => "Y",
			"SKIP_USELESS_BLOCK" => "Y",
			"TEMPLATE_LOCATION" => "popup",
			"TEMPLATE_THEME" => "site",
			"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
			"USE_CUSTOM_ERROR_MESSAGES" => "Y",
			"USE_CUSTOM_MAIN_MESSAGES" => "N",
			"USE_PREPAYMENT" => "N",
			"USE_YM_GOALS" => "N",
			"USER_CONSENT" => "Y",
			"USER_CONSENT_ID" => "0",
			"USER_CONSENT_IS_CHECKED" => "Y",
			"USER_CONSENT_IS_LOADED" => "N",
			"COMPONENT_TEMPLATE" => "new",
			"ALLOW_APPEND_ORDER" => "Y",
			"SPOT_LOCATION_BY_GEOIP" => "Y",
			"USE_PRELOAD" => "Y",
			"SHOW_PICKUP_MAP" => "N",
			"PICKUP_MAP_TYPE" => "yandex",
			"SHOW_COUPONS" => "Y",
			"ACTION_VARIABLE" => "soa-action",
			"EMPTY_BASKET_HINT_PATH" => "/",
			"USE_PHONE_NORMALIZATION" => "Y",
			"ADDITIONAL_PICT_PROP_2" => "-",
			"ADDITIONAL_PICT_PROP_4" => "-",
			"HIDE_ORDER_DESCRIPTION" => "N",
			"USE_ENHANCED_ECOMMERCE" => "N",
			"MESS_PAY_SYSTEM_PAYABLE_ERROR" => "Вы сможете оплатить заказ после того, как менеджер проверит наличие полного комплекта товаров на складе. Сразу после проверки вы получите письмо с инструкциями по оплате. Оплатить заказ можно будет в персональном разделе сайта.",
			"ADDITIONAL_PICT_PROP_25" => "-"
		),
		false
	);?>
<? $arJSON["HTML"] = ob_get_contents(); 
ob_end_clean();
echo json_encode($arJSON);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>