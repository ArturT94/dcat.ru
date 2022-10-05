<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form name="bform" method="post" class="forgotFormAjax form form__personal" target="_top" action="<?=$arResult["AUTH_URL"]?>">
	<div class="user-registration ajaxContent">
		<? if (strlen($arResult["BACKURL"]) > 0):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<? endif;?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">
		<div class="form__registration form__forgot">
			<?ShowMessage($arParams["~AUTH_RESULT"]);?>
		</div>
        <div class="modal-description">На ваш e-mail будут отправлены инструкции для восстановления пароля.</div>
		<div class="modal-group">
			<input type="text" name="USER_EMAIL" class="form-control forgotInput" placeholder="E-mail" value="<?= $_REQUEST["USER_EMAIL"] ?>">
		</div>
		<div class="modal-group modal-group-footer text-center">
			<input type="submit" name="send_account_info" class="adp-btn adp-btn--md adp-btn--primary" value="Отправить">
		</div>
	</div>
</form>