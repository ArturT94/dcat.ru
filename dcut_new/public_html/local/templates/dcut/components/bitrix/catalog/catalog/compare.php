<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$APPLICATION->SetTitle('Сравнение товаров');
$APPLICATION->SetPageProperty('title','Сравнение товаров');
$compareKey = 'CATALOG_COMPARE_LIST';
$compare = 0;
if($_SESSION[$compareKey]){
	foreach($_SESSION[$compareKey] as $iblock){
		$compare = $compare + count($iblock['ITEMS']);
	}
}					
$pinCompare = explode(',',$APPLICATION->get_cookie('PIN_COMPARE'));
if($pinCompare[1]){
	foreach($pinCompare as $it){
		$arComparePinned[$it] = $it;
	}
}
$arComparePinned = array_reverse($arComparePinned,true);
?>
<?if($compare==0):?>
	<section class="section s-compare">
		<div class="container">
			<div class="row">
                <h1 class="page-title"><?=$APPLICATION->ShowTitle()?></h1>
                <div class="compare compare--empty">
                    <div class="compare__container">
                        <div class="compare__goods">
                            <div class="compare__empty__message">
                                <div class="compare__empty__title">Нет товаров, добавленных к сравнению</div>
                                <a href="/catalog/" class="adp-btn adp-btn--md adp-btn--primary">Перейти в каталог</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</section>
<?else:?>
	<section class="section s-compare compareAjax">
		<div class="container">
			<div class="row">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.compare.result",
                    "catalog",
                    array(
                        "arComparePinned" => $arComparePinned,
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "BASKET_URL" => $arParams["BASKET_URL"],
                        "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action"),
                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                        "FIELD_CODE" => $arParams["COMPARE_FIELD_CODE"],
                        "PROPERTY_CODE" => array(
                            0 => "BREND",
                        ),
                        "NAME" => $arParams["COMPARE_NAME"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                        "PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
                        "DISPLAY_ELEMENT_SELECT_BOX" => $arParams["DISPLAY_ELEMENT_SELECT_BOX"],
                        "ELEMENT_SORT_FIELD_BOX" => $arParams["ELEMENT_SORT_FIELD_BOX"],
                        "ELEMENT_SORT_ORDER_BOX" => $arParams["ELEMENT_SORT_ORDER_BOX"],
                        "ELEMENT_SORT_FIELD_BOX2" => $arParams["ELEMENT_SORT_FIELD_BOX2"],
                        "ELEMENT_SORT_ORDER_BOX2" => $arParams["ELEMENT_SORT_ORDER_BOX2"],
                        "ELEMENT_SORT_FIELD" => $arParams["COMPARE_ELEMENT_SORT_FIELD"],
                        "ELEMENT_SORT_ORDER" => $arParams["COMPARE_ELEMENT_SORT_ORDER"],
                        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                        "OFFERS_FIELD_CODE" => $arParams["COMPARE_OFFERS_FIELD_CODE"],
                        "OFFERS_PROPERTY_CODE" => $arParams["COMPARE_OFFERS_PROPERTY_CODE"],
                        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
                        'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : '')
                    ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                );?>
            </div>
		</div>
	</section>

<?endif;?>