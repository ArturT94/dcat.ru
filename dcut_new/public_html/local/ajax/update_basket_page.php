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

if($_REQUEST['ID'] && $_REQUEST['TYPE'] || $_REQUEST['VAL'] == 'UPDATE'):
    if($_REQUEST['VAL'] != 'UPDATE'){
		$Allprice = 0;
        $request = Application::getInstance()->getContext()->getRequest();
        $response = [];
        $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), SITE_ID);
        if (!$basket) {
            echo Json::encode(['error' => 1], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if ($productId = (int)$request->get('ID')) {
            $productCount = (int)$request->get('TYPE');
            if ($productCount < -1) {
                $productCount = -1;
            } elseif ($productCount > 1) {
                $productCount = 1;
            }
			/** @var Sale\Basket $basket */
			$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), SITE_ID);
			if ($basket) {
				/** @var Sale\BasketItem $basketItem */
				$basketItem = $basket->getItemById($productId);
				$quantity = $basketItem->getQuantity() + $productCount;
				if ($quantity > 0) {
					$res = $basketItem->setField('QUANTITY', $quantity);
					$basketItem->save();
				}
			}
        }
    }
	
	CSaleBasket::UpdateBasketPrices(CSaleBasket::GetBasketUserID(), "s1");
	$dbBasketItems = CSaleBasket::GetList(array(), array(
		"FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => "s1",
		"ORDER_ID" => "NULL"
	), false, false, array());

	while ($arItem = $dbBasketItems->Fetch()) {
	  $arOrder["BASKET_ITEMS"][] = $arItem;
	}
	$arOrder['SITE_ID'] = "s1";
	CSaleDiscount::DoProcessOrder($arOrder, array(), $arErrors);
	foreach ($arOrder["BASKET_ITEMS"] as $basketItem) { 
		$Allprice = $Allprice + $basketItem['PRICE']*$basketItem['QUANTITY'];
	} 
	$Allprice = round($Allprice);
    ob_start(); ?>
    <?
	$APPLICATION->IncludeComponent(
		"bitrix:sale.basket.basket", 
		"new",
		array(
			"COLUMNS_LIST" => array(
				0 => "NAME",
				1 => "DISCOUNT",
				2 => "PROPS",
				3 => "DELETE",
				4 => "DELAY",
				5 => "TYPE",
				6 => "PRICE",
				7 => "QUANTITY",
				8 => "SUM",
			),
			"OFFERS_PROPS" => array(
			),
			"PATH_TO_ORDER" => "/order/",
			"HIDE_COUPON" => "N",
			"PRICE_VAT_SHOW_VALUE" => "Y",
			"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
			"USE_PREPAYMENT" => "N",
			"SET_TITLE" => "N",
			"AJAX_MODE_CUSTOM" => "Y",
			"SHOW_MEASURE" => "Y",
			"PICTURE_WIDTH" => "100",
			"PICTURE_HEIGHT" => "100",
			"SHOW_FULL_ORDER_BUTTON" => "Y",
			"SHOW_FAST_ORDER_BUTTON" => "Y",
			"COMPONENT_TEMPLATE" => "prymery",
			"QUANTITY_FLOAT" => "N",
			"ACTION_VARIABLE" => "action",
			"TEMPLATE_THEME" => "blue",
			"AUTO_CALCULATION" => "Y",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO",
			"USE_GIFTS" => "N",
			"GIFTS_PLACE" => "BOTTOM",
			"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
			"GIFTS_HIDE_BLOCK_TITLE" => "N",
			"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
			"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
			"GIFTS_SHOW_OLD_PRICE" => "Y",
			"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
			"GIFTS_SHOW_NAME" => "Y",
			"GIFTS_SHOW_IMAGE" => "Y",
			"GIFTS_MESS_BTN_BUY" => "Выбрать",
			"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
			"GIFTS_PAGE_ELEMENT_COUNT" => "4",
			"GIFTS_CONVERT_CURRENCY" => "N",
			"GIFTS_HIDE_NOT_AVAILABLE" => "N",
			"DEFERRED_REFRESH" => "N",
			"USE_DYNAMIC_SCROLL" => "Y",
			"SHOW_FILTER" => "Y",
			"SHOW_RESTORE" => "N",
			"COLUMNS_LIST_EXT" => array(
				0 => "PREVIEW_PICTURE",
				1 => "DELETE",
				2 => "DELAY",
				3 => "SUM",
				4 => "PROPERTY_COLOR",
				5 => "PROPERTY_ARTICLE",
				6 => "PROPERTY_SIZE",
			),
			"COLUMNS_LIST_MOBILE" => array(
				0 => "PREVIEW_PICTURE",
				1 => "DELETE",
				2 => "DELAY",
				3 => "SUM",
			),
			"TOTAL_BLOCK_DISPLAY" => array(
				0 => "top",
			),
			"DISPLAY_MODE" => "extended",
			"PRICE_DISPLAY_MODE" => "Y",
			"SHOW_DISCOUNT_PERCENT" => "Y",
			"DISCOUNT_PERCENT_POSITION" => "bottom-right",
			"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
			"USE_PRICE_ANIMATION" => "Y",
			"LABEL_PROP" => array(
			),
			"CORRECT_RATIO" => "Y",
			"COMPATIBLE_MODE" => "Y",
			"EMPTY_BASKET_HINT_PATH" => "/",
			"ADDITIONAL_PICT_PROP_2" => "-",
			"BASKET_IMAGES_SCALING" => "adaptive",
			"USE_ENHANCED_ECOMMERCE" => "N",
			"ADDITIONAL_PICT_PROP_7" => "-",
			"ADDITIONAL_PICT_PROP_8" => "-"
		),
		false
	);
	?>
    <? $arJSON["BASKET_HTML"] = ob_get_contents(); 
	$arJSON["PRICE"] = $Allprice;
	$arJSON['QUANTITY'] = count($arOrder["BASKET_ITEMS"])." ".endingsForm(count($arOrder["BASKET_ITEMS"]),'товар','товара','товаров').' на сумму';
	ob_end_clean();
    echo json_encode($arJSON);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>