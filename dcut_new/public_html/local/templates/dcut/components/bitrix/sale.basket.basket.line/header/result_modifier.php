<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (\Bitrix\Main\Loader::includeModule('sale') && $arResult['NUM_PRODUCTS']>0) {
    global $USER;
    if($USER->IsAuthorized()) {
        $arOrder['USER_ID'] = $USER->GetID();
    }
    CSaleDiscount::DoProcessOrder($arOrder, array(), $arErrors);

    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
        \CSaleBasket::GetBasketUserID(), "s1")->getOrderableItems();
    $discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
    $discounts->calculate();
    $arBasketDiscounts = $discounts->getApplyResult(true);
    $sum = 0;
    $basketItems = $basket->getBasketItems();
    foreach ($basketItems  as $basketItem ) {
        $basketCode = $basketItem->getBasketCode();
        if (isset($arBasketDiscounts["PRICES"]['BASKET'][$basketCode])){
            $sum += $arBasketDiscounts["PRICES"]['BASKET'][$basketCode]["PRICE"]*$basketItem->getQuantity();
        } else {
            $sum += $basketItem->getFinalPrice();
        }
    }
    $arResult['SUM_CUSTOM'] = $sum;
}