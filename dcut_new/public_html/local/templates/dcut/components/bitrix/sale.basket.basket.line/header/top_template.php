<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>

<a href="/cart/" title="Корзина">
    <svg width="24" height="23" class="icon"><use xlink:href="#product-cart"></use></svg>
    <div class="circle"><span><?=$arResult['NUM_PRODUCTS']?></span></div>
</a>
<div class="all-price">₽<?=str_replace('руб.','',$arResult['TOTAL_PRICE'])?></div>