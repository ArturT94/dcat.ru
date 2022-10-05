<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form method="post" class="form changeFormAjax" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
    <div class="user-registration ajaxContent">
        <? ShowMessage($arParams["~AUTH_RESULT"]); ?>
        <?if (strlen($arResult["BACKURL"]) > 0): ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="CHANGE_PWD">
		<input type="hidden" class="form-control" name="USER_LOGIN" size="25" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
		<input type="hidden" class="form-control" size="25" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" />
        <div class="modal-group">
			<input placeholder="* <?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>" class="form-control forgotInput" type="password" size="25" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" />
        </div>
        <div class="modal-group">
			<input placeholder="* <?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>" class="form-control forgotInput" type="password" size="25" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>"  />
        </div>
        <input type="submit" class="adp-btn adp-btn--md adp-btn--primary" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
    </div>
</form>
