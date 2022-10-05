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
}
if ($normalCount > 0): ?>
    <div id="basket_items_list">
        <div class="bx_ordercart_order_table_container">
            <div id="basket_items" class="cart-list">
                <?
                $skipHeaders = array('PROPS', 'DELAY', 'DELETE', 'TYPE');

                foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
                if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
                ?>
                <div id="<?= $arItem["ID"] ?>" class="table-row table-body"
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
                                endif; ?>
								<div class="cell cell-delete">
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"
										onclick="return deleteProductRow(this)" data-id="<?= $arItem["ID"] ?>" class="delPage">
										<svg class="icon"><use xlink:href="#delete"></use></svg>
									</a>
								</div>
								<div class="cell cell-thumb">
									<a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="thumb-link">
										<img src="<?= $url ?>">
									</a>
									<a href="javascript:void(0)" data-id="<?= $arItem["ID"] ?>" class="delPage add-favorites--mobile">
										<svg class="icon"><use xlink:href="#star-alt"></use></svg>
									</a>
								</div>
								<div class="cell cell-title">
									<a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="title-link"><?= $arItem["NAME"] ?></a>
									<div class="price price--mobile">
										<div class="price-current">
											<?= $arItem["PRICE"] ?>
											<svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
										</div>
										<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0): ?>
											<div class="price-old">
												<?= $arItem["FULL_PRICE"] ?>
												<svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
											</div>
										<?endif;?>
										
									</div>
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"
										onclick="return deleteProductRow(this)" data-id="<?= $arItem["ID"] ?>" class="delPage delete--mobile">Удалить</a>
								</div>
								<div class="cell cell-price">
									<div class="price">
										<div class="price-current" id="current_price_<?= $arItem["ID"] ?>">
											<?= $arItem["PRICE"] ?>
											<svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
										</div>
										<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0): ?>
											<div class="price-old" id="old_price_<?= $arItem["ID"] ?>">
												<?= $arItem["FULL_PRICE"] ?>
												<svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
											</div>
										<?endif;?>
									</div>
								</div>
							<? elseif ($arHeader["id"] == "QUANTITY"): ?>
								<div class="cell cell-quantity">
									<div class="caption">Количество</div>
									<div class="quantity" id="basket_quantity_control" data-value="<?= $arItem["QUANTITY"] ?>">
										<span onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"
										 class="quantity__controller">
											<svg class="icon"><use xlink:href="#minus"></use></svg>
										</span>
										<?
										$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
										$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
										$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
										
										if (!isset($arItem["MEASURE_RATIO"])){
											$arItem["MEASURE_RATIO"] = 1;
										}
										?>
										<input class="quantity__value"
											   type="text"
											   size="3"
											   id="QUANTITY_INPUT_<?= $arItem["ID"] ?>"
											   name="QUANTITY_INPUT_<?= $arItem["ID"] ?>"
											   maxlength="18"
											   value="<?= $arItem["QUANTITY"] ?>"
											   onchange="updateQuantity('QUANTITY_INPUT_<?= $arItem["ID"] ?>', '<?= $arItem["ID"] ?>', <?= $ratio ?>, <?= $useFloatQuantityJS ?>)"
										>
	
										<span onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);" class="quantity__controller">
											<svg class="icon"><use xlink:href="#plus"></use></svg>
										</span>
							
										<input type="hidden" id="QUANTITY_<?= $arItem['ID'] ?>" name="QUANTITY_<?= $arItem['ID'] ?>" value="<?= $arItem["QUANTITY"] ?>"/>
									</div>
								</div>
							<? elseif ($arHeader["id"] == "SUM"): ?>
								<div class="cell cell-total" id="sum_<?=$arItem["ID"]?>">
									<?=$arItem[$arHeader["id"]] ?>
									<svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
								</div>
                            <?
                            elseif ($arHeader["id"] == "WEIGHT"):
             
							endif;
                        endforeach;

                        if ($bDelayColumn || $bDeleteColumn):
                            if ($bDeleteColumn):
                                ?>

                            <?
                            endif;
                            if ($bDelayColumn):

                            endif;
                            ?>
                        <? endif; ?>
                    <?  endif;?>
                    </li>
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
		
		
		
		<div class="cart-additional">
			<div class="cart-additional__item" data-fancybox data-src="#modal-postcard">
				<label class="custom-checkbox checkbox--primary">
					<input type="checkbox" class="checkbox-value" name="add-postcard">
					<span class="checkbox-icon"></span>
					<span class="checkbox-text">Добавить открытку</span>
				</label>
				<div class="values">
					<span class="price">
						100 <svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
					</span>
					<a href="#" class="link-remove">Удалить</a>
				</div>
			</div>
			<div class="cart-additional__item added" data-fancybox data-src="#modal-postcard">
				<label class="custom-checkbox checkbox--primary">
					<input type="checkbox" class="checkbox-value" name="add-postcard-2" checked="checked">
					<span class="checkbox-icon"></span>
					<span class="checkbox-text">Добавить открытку</span>
				</label>
				<div class="values">
					<span class="price">
						150 <svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
					</span>
					<a href="#" class="link-remove">Удалить</a>
				</div>
			</div>
			<div class="cart-additional__item">
				<label class="custom-checkbox checkbox--primary">
					<input type="checkbox" class="checkbox-value" name="add-balloon">
					<span class="checkbox-icon"></span>
					<span class="checkbox-text">Добавить воздушный шар</span>
				</label>
				<div class="values">
					<span class="price">
						200 <svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
					</span>
					<a href="#" class="link-remove">Удалить</a>
				</div>
			</div>
		</div>
		<div class="cart-footer">
			<div class="form-promocode" id="coupons_block">
				<div class="form-group">
					<?
                    unset($coupon_class);
                    unset($coupon);
                    if (!empty($arResult['COUPON_LIST'])){
                        foreach ($arResult['COUPON_LIST'] as $oneCoupon):
                            $couponClass = 'disabled';
                            switch ($oneCoupon['STATUS']) {
                                case DiscountCouponsManager::STATUS_NOT_FOUND:
                                case DiscountCouponsManager::STATUS_FREEZE:
                                    $coupon = $oneCoupon['COUPON'];
                                    $coupon_class = 'bad';
                                    break;
                                case DiscountCouponsManager::STATUS_APPLYED:
                                    $coupon = $oneCoupon['COUPON'];
                                    $coupon_class = 'good';
                                    break;
                            }
                        endforeach;
                    }
                    ?>
					<label class="form-label">Есть промокод?</label>
					<input type="text" id="coupon" class="couponBasket form-control <?=$coupon_class?>" name="COUPON" placeholder="Введите промокод" value="<?=$coupon?>" onchange="enterCoupon();">
					<? if (!empty($arResult['COUPON_LIST'])):
						foreach ($arResult['COUPON_LIST'] as $oneCoupon):
							$couponClass = 'disabled';
							switch ($oneCoupon['STATUS']) {
								case DiscountCouponsManager::STATUS_NOT_FOUND:
								case DiscountCouponsManager::STATUS_FREEZE:
									$couponClass = 'bad';
									break;
								case DiscountCouponsManager::STATUS_APPLYED:
									$couponClass = 'good';
									break;
							}
							?>
							<div class="bx_ordercart_coupon" style="display: none;">
								<input disabled readonly type="text" name="OLD_COUPON[]" value="<?= htmlspecialcharsbx($oneCoupon['COUPON']); ?>" class="<? echo $couponClass; ?>">
								<span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span>
								<div class="bx_ordercart_coupon_notes"><?
									if (isset($oneCoupon['CHECK_CODE_TEXT'])) {
										echo(is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
									}
									?>
								</div>
							</div>
						<? endforeach;
						unset($couponClass, $oneCoupon);
					endif;?>
				</div>
				<div class="form-group">
					<a class="adp-btn adp-btn--primary-outline btn--block" href="javascript:void(0)" onclick="enterCoupon();location.reload();"
                        title="Применить">Применить</a>
				</div>
			</div>
			<div class="cart-total-price">
				<div class="caption">Общая стоимость (без доставки)</div>
				<div class="value">
					<span class="price">
						<?= str_replace(" ", "&nbsp;", round($arResult["allSum"])) ?> <svg class="icon icon-currency"><use xlink:href="#ruble-sign"></use></svg>
					</span>
				</div>
			</div>
			<div class="cart-finish">
				<a href="/personal/order/" class="adp-btn adp-btn--primary adp-btn--wide">Перейти к оформлению</a>
			</div>
		</div>

    </div>
<? else: ?>
    <div id="basket_items_list">
        <table>
            <tbody>
            <tr>
                <td style="text-align:center">
                    <div class=""><?= GetMessage("SALE_NO_ITEMS"); ?></div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<? endif;