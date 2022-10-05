<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>" />
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
    <input type="hidden" name="LOGIN" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
    <table>
        <tr>
            <td><?=GetMessage('NAME')?></td>
            <td><input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" /></td>
        </tr>
        <tr>
            <td><?=GetMessage('PERSONAL_PHONE')?></td>
            <td><input type="text" name="PERSONAL_PHONE" maxlength="50" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" /></td>
        </tr>
        <tr>
            <td><?=GetMessage('EMAIL')?><span class="starrequired">*</span></td>
            <td><input type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" /></td>
        </tr>
        <tr>
            <td><?=GetMessage('LOGIN')?><span class="starrequired">*</span></td>
            <td><input type="text" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" /></td>
        </tr>
    </table>
    <input type="text" name="PERSONAL_BIRTHDAY" value="<?=$arResult["arUser"]["PERSONAL_BIRTHDAY"]?>">

    <input  type="submit" name="save" value="Сохранить">
</form>
