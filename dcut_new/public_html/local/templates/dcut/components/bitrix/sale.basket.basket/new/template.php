<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixBasketComponent $component */
/*$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
);*/
$this->addExternalCss($templateData['TEMPLATE_THEME']);

$curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
	"delete" => $curPage."delete&id=#ID#",
	"delay" => $curPage."delay&id=#ID#",
	"add" => $curPage."add&id=#ID#",
);
unset($curPage);

$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"],
	'EVENT_ONCHANGE_ON_START' => (!empty($arResult['EVENT_ONCHANGE_ON_START']) && $arResult['EVENT_ONCHANGE_ON_START'] === 'Y') ? 'Y' : 'N',
	'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
	'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
	'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
);
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>;
</script>

	<?
	$APPLICATION->AddHeadScript($templateFolder."/script.js");

	if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
	{
		?>
		<div id="warning_message">
			<?
			if (!empty($arResult["WARNING_MESSAGE"]) && is_array($arResult["WARNING_MESSAGE"]))
			{
				foreach ($arResult["WARNING_MESSAGE"] as $v)
					ShowError($v);
			}
			?>
		</div>
		<?

		$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
		$normalHidden = ($normalCount == 0) ? 'style="display:none;"' : '';

		$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
		$delayHidden = ($delayCount == 0) ? 'style="display:none;"' : '';

		$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
		$subscribeHidden = ($subscribeCount == 0) ? 'style="display:none;"' : '';

		$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
		$naHidden = ($naCount == 0) ? 'style="display:none;"' : '';

		foreach (array_keys($arResult['GRID']['HEADERS']) as $id){
			$data = $arResult['GRID']['HEADERS'][$id];
			$headerName = (isset($data['name']) ? (string)$data['name'] : '');
			if ($headerName == '')
				$arResult['GRID']['HEADERS'][$id]['name'] = GetMessage('SALE_'.$data['id']);
			unset($headerName, $data);
		}
		unset($id);
		?>
        <section class="profile-cart">
            <div class="container-large">
                <div class="profile-content_group content-group_cart">
                    <div class="profile-content">
                        <div class="profile-selection">
                            <div class="section-row selection-cart-row">
                                <div class="section-column col-9"><div class="selection-item selection-item-cart">Товар</div></div>
                                <div class="section-column col-10"><div class="selection-item selection-item-cart">Цена</div></div>
                                <div class="section-column col-11"><div class="selection-item selection-item-cart">Количество</div></div>
                                <div class="section-column col-12"><div class="selection-item selection-item-cart">Стоимость</div></div>
                            </div>
                        </div>
                        <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
                            <div id="basket_form_container">
                                <div class="cart__list">
                                    <? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php"); ?>
                                </div>
                            </div>
                            <input type="hidden" name="BasketOrder" value="BasketOrder" />
                        </form>
                    </div>
                    <div class="total">
                        <div class="total-products">Всего товаров: <?=count($arResult['GRID']['ROWS']);?></div>
                        <div class="total-cost-title">Общая стоимость заказа без доставки:</div>
                        <div class="total-cost"><?=$arResult['allSum_FORMATED']?></div>
                        <div class="total-buttons">
                            <a href="/catalog/" class="button-continue">Продолжить покупки</a>
                            <a href="/order/" class="button-order dark-button"><span>Оформить заказ</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?}	else {?>
		<div class="cart__list">
			<div class="cart-empty">
				<div class="cart-empty__title">Корзина пуста. Загляните в каталог, там много интересного</div>
				<a href="/catalog/" class="button-continue">Перейти в каталог</a>
			</div>
		</div>
	<?}?>
