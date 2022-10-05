<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @var array $arUrls */

/** @var array $arHeaders */

use Bitrix\Sale\DiscountCouponsManager;

if (!empty($arResult["ERROR_MESSAGE"]))
    ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn = false;
$bPriceType = false;
if($arResult["GRID"]["HEADERS"]){
    foreach($arResult["GRID"]["HEADERS"] as $k=>$head){
        if($head['id'] == 'PRICE'){
            unset($arResult["GRID"]["HEADERS"][$k]);
            $arResult["GRID"]["HEADERS"][] = $head;
        }
    }
}?>
<?
//81 - шары
//115 - открытки
$arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID",'PREVIEW_PICTURE','PREVIEW_TEXT');
$arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "SECTION_ID"=>array(81,115), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, Array(), $arSelect);
$min_price_balls=0;
while($ob = $res->Fetch()){
	unset($price);
	$price = CPrice::GetBasePrice($ob['ID']);
	$ob['PRICE'] = round($price['PRICE']);
	if($ob['IBLOCK_SECTION_ID'] == 81){
		$arAddBalls[$ob['ID']] = $ob;
		if($min_price_balls == 0){
			$min_price_balls = $ob['PRICE'];
		}
		if($min_price_balls>$ob['PRICE']){
			$min_price_balls = $ob['PRICE'];
		}
		$arAddBallsId[$ob['ID']] = $ob['ID'];
	}else{
		$arPostCards[$ob['PRICE']][$ob['ID']] = $ob;
		$arPostCardsId[$ob['ID']] = $ob['ID'];
	}
}

?>
<?if ($normalCount > 0): ?>
    <div id="basket_items_list">
        <div class="bx_ordercart_order_table_container">
            <div id="basket_items" class="cart-list">
                <?
                $skipHeaders = array('PROPS', 'DELAY', 'DELETE', 'TYPE');
				$ball_have = 0; $postcard_have = 0;
                foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
					if($arAddBallsId[$arItem['PRODUCT_ID']]){
						$ball_have = $arItem['ID'];
					}
					if($arPostCardsId[$arItem['PRODUCT_ID']]){
						$postcard_have = $arItem['ID'];
					}
					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
					?>
					<div id="<?= $arItem["ID"] ?>" class="content-block"
						data-item-name="<?= $arItem["NAME"] ?>"
						data-item-brand="<?= $arItem[$arParams['BRAND_PROPERTY'] . "_VALUE"] ?>"
						data-item-price="<?= $arItem["PRICE"] ?>"
						data-item-currency="<?= $arItem["CURRENCY"] ?>">
							<?
							foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

								if (in_array($arHeader["id"], $skipHeaders)) // some values are not shown in the columns in this template
									continue;

								if ($arHeader["name"] == '')
									$arHeader["name"] = GetMessage("SALE_" . $arHeader["id"]);

								if ($arHeader["id"] == "NAME"): ?>
									<? if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
										$url = $arItem["PREVIEW_PICTURE_SRC"];
									elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
										$url = $arItem["DETAIL_PICTURE_SRC"];
									else:
										$url = $templateFolder . "/images/no_photo.png";
									endif;

									unset($article);
                                    $arSelect = Array("ID", "IBLOCK_ID", "NAME", 'PROPERTY_CML2_ARTICLE');
                                    $arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, 'ID'=>$arItem['PRODUCT_ID']);
                                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                                    while($ob = $res->Fetch()){
                                        if($ob['PROPERTY_CML2_ARTICLE_VALUE']){
                                            $article = $ob['PROPERTY_CML2_ARTICLE_VALUE'];
                                        }
                                    }
									?>
                                    <div class="section-row profile-content-row">
                                        <div class="section-column col-9">
                                            <div class="content-block_tovar">

                                                <div class="tovar">
                                                    <div class="tovar-img">
                                                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                                            <?if($arItem['PREVIEW_PICTURE']):?>
                                                                <img src="<?= CFile::GetPath($arItem['PREVIEW_PICTURE']); ?>">
                                                            <?else:?>
                                                                <img src="/local/templates/dcut/assets/img/no-photo.png">
                                                            <?endif;?>
                                                        </a>
                                                    </div>
                                                    <div class="tovar-descr">
                                                        <?if($article):?>
                                                            <div class="tovar-descr_vendor">Артикул: <?=$article?></div>
                                                        <?endif;?>
                                                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="tovar-descr_name"><?= $arItem["NAME"] ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="section-column col-10">
                                            <div class="content-block_value content-sm-column">
                                                <div class="value-title">Цена: </div>
                                                <div class="price-value"><?=number_format($arItem["SUM_VALUE"]/$arItem["QUANTITY"], 0, '', ' '); ?> руб.</div>
                                            </div>
                                        </div>
                                        <div class="section-column col-11">
                                            <div class="content-block_quantity content-sm-column">
                                                <div class="quantity-title">Количество: </div>
                                                <div class="quantity-block quantity" id="basket_quantity_control" data-value="<?= $arItem["QUANTITY"] ?>">
                                                    <button class="button-minus updateStat quantity__controller" type="button" data-id="<?= $arItem["ID"] ?>" data-type="-1">
                                                        <svg width="16" height="2" class="icon"><use xlink:href="#minus"></use></svg>
                                                    </button>
                                                    <?
                                                    $ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
                                                    $useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
                                                    $useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");

                                                    if (!isset($arItem["MEASURE_RATIO"])){
                                                        $arItem["MEASURE_RATIO"] = 1;
                                                    }
                                                    ?>
                                                    <input class="quantity__value quantity-input"
                                                           type="text"
                                                           size="3"
                                                           id="QUANTITY_INPUT_<?= $arItem["ID"] ?>"
                                                           name="QUANTITY_INPUT_<?= $arItem["ID"] ?>"
                                                           maxlength="18"
                                                           value="<?= $arItem["QUANTITY"] ?>"
                                                           onchange="updateQuantity('QUANTITY_INPUT_<?= $arItem["ID"] ?>', '<?= $arItem["ID"] ?>', <?= $ratio ?>, <?= $useFloatQuantityJS ?>)"
                                                    >
                                                    <button class="button-plus updateStat quantity__controller" type="button" data-id="<?= $arItem["ID"] ?>" data-type="1">
                                                        <svg width="16" height="16" class="icon"><use xlink:href="#plus"></use></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="section-column col-12">
                                            <div class="content-block_cost content-sm-column">
                                                <div class="cost-title">Стоимость: </div>
                                                <div class="cost-delete">
                                                    <div class="cost-value"><?=number_format($arItem["SUM_VALUE"], 0, '', ' '); ?> руб.</div>
                                                    <div class="tovar-delete delPage" data-id="<?= $arItem["ID"] ?>" data-toggle="tooltip" data-placement="top" title="Удалить из корзины">
                                                        <svg width="18" height="19" class="icon"><use xlink:href="#product-delete"></use></svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								<? elseif ($arHeader["id"] == "QUANTITY"): ?>
									
								<? elseif ($arHeader["id"] == "SUM"): ?>
									
								<?
								elseif ($arHeader["id"] == "WEIGHT"):
				 
								endif;
							endforeach;

							if ($bDelayColumn || $bDeleteColumn):
								if ($bDeleteColumn): endif;
								if ($bDelayColumn): endif;
								?>
							<? endif; ?>
						
						</div>
					<?  endif;?>
               <? endforeach; ?>
            </div>
        </div>
		
        <input type="hidden" id="column_headers" value="<?= htmlspecialcharsbx(implode($arHeaders, ",")) ?>"/>
        <input type="hidden" id="offers_props"
               value="<?= htmlspecialcharsbx(implode($arParams["OFFERS_PROPS"], ",")) ?>"/>
        <input type="hidden" id="action_var" value="<?= htmlspecialcharsbx($arParams["ACTION_VARIABLE"]) ?>"/>
        <input type="hidden" id="quantity_float" value="<?= ($arParams["QUANTITY_FLOAT"] == "Y") ? "Y" : "N" ?>"/>
        <input type="hidden" id="price_vat_show_value"
               value="<?= ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N" ?>"/>
        <input type="hidden" id="hide_coupon" value="<?= ($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N" ?>"/>
        <input type="hidden" id="use_prepayment" value="<?= ($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N" ?>"/>
        <input type="hidden" id="auto_calculation" value="<?= ($arParams["AUTO_CALCULATION"] == "N") ? "N" : "Y" ?>"/>
    </div>
<? else: ?>
    <div id="basket_items_list">
		У вас в корзине нет товаров.
    </div>
<? endif;?>
