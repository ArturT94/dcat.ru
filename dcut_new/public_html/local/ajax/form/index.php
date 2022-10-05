<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
}?>
<div class="modalForm">
    <?
    $APPLICATION->IncludeComponent(
        "prymery:feedback.form",
        "modal",
        array(
            "ARFIELDS" => array(
                0 => "NAME",
                1 => "PHONE",
            ),
            "REQUEST_ARFIELDS" => array(
                0 => "NAME",
                1 => "PHONE",
            ),
            "COMPONENT_TEMPLATE" => ".default",
            "PRYMERY_MODULE_ID" => 'prymery.genesis',
            "EMAIL_TO" => "zs@dcut.ru",
			"SUCCESS_MESSAGE_TITLE" => "Сообщение отправлено",
            "SUCCESS_MESSAGE" => "Мы перезвоним вам в течение 15 минут",
            "GOAL_METRIKA" => "",
            "GOAL_ANALITICS" => "",
            "USE_CAPTCHA" => "N",
            "SAVE" => "Y",
            "BUTTON" => "Перезвоните мне",
            "TITLE" => "Обратный звонок",
            "SUBTITLE" => "",
            "PERSONAL_DATA" => "Y",
            "PERSONAL_DATA_PAGE" => "/policy/",
            "LEAD_IBLOCK" => ""
        ),
        false
    ); ?>
</div>
<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}?>
