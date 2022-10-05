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

if($_REQUEST['ID']):
	

    $arJSON["STORE"] = $_REQUEST["STORE"];
    ob_start(); ?>
    <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "header", Array(
		"HIDE_ON_BASKET_PAGES" => "N",	// Не показывать на страницах корзины и оформления заказа
		"PATH_TO_BASKET" => SITE_DIR."basket/",	// Страница корзины
		"PATH_TO_ORDER" => SITE_DIR."order/",	// Страница оформления заказа
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",	// Страница персонального раздела
		"PATH_TO_PROFILE" => SITE_DIR."personal/",	// Страница профиля
		"PATH_TO_REGISTER" => SITE_DIR."login/",	// Страница регистрации
		"POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
		"SHOW_AUTHOR" => "N",	// Добавить возможность авторизации
		"SHOW_DELAY" => "N",	// Показывать отложенные товары
		"SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
		"SHOW_IMAGE" => "Y",	// Выводить картинку товара
		"SHOW_NOTAVAIL" => "N",	// Показывать товары, недоступные для покупки
		"SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
		"SHOW_PERSONAL_LINK" => "N",	// Отображать персональный раздел
		"SHOW_PRICE" => "Y",	// Выводить цену товара
		"SHOW_PRODUCTS" => "Y",	// Показывать список товаров
		"SHOW_SUBSCRIBE" => "N",
		"SHOW_SUMMARY" => "N",	// Выводить подытог по строке
		"SHOW_TOTAL_PRICE" => "Y",	// Показывать общую сумму по товарам
		"COMPONENT_TEMPLATE" => "header_line"
	),
		false
	);?>
    <? $arJSON["BASKET_HTML"] = ob_get_contents(); ?>
    <? ob_end_clean();
    echo json_encode($arJSON);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>