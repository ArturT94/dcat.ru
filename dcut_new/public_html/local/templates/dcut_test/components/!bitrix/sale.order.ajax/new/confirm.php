<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
if ($arParams["SET_TITLE"] == "Y"){
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
if($arResult["ORDER_ID"]){
	$arOrder = CSaleOrder::GetByID($arResult["ORDER_ID"]);
}
?>

<div class="cart__list">
	<div class="cart-success">
		<?if($arResult["ORDER_ID"]):?>
			<div class="cart-success__title">Спасибо за заказ!</div>
			<p>Заказ <a href="/personal/orders/detail/<?= $arResult["ORDER_ID"] ?>/" class="text-primary">№<?= $arResult["ORDER_ID"] ?></a> оформлен.</p>
			<p><?=$arOrder['USER_NAME']?>, уведомления о статусе заказа вы будете получать по электронной почте <b><?=$arOrder['USER_EMAIL']?></b>.</p>
			<p>Проследить за статусом вы всегда можете на сайте и в личном кабинете.</p>

			<div class="cart-success__continue">
				<a href="/catalog/" class="adp-btn adp-btn--primary">Продолжить покупки</a>
			</div>
		<?else:?>
			<div class="cart-success__title">Возникла ошибка, заказ не найден!</div>
			<p>Если вы считаете, что ваш заказ потерян, пожалуйста обратитесь на <b>info@freevape.ru</b>.</p>

			<div class="cart-success__continue">
				<a href="/catalog/" class="adp-btn adp-btn--primary">Продолжить покупки</a>
			</div>
		<?endif;?>
	</div>
</div>
