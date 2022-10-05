<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
}?>

    <?
    $APPLICATION->IncludeComponent(
        "prymery:feedback.form",
        "modal2",
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
            "EMAIL_TO" => "zs@dcut.ru",
			"SUCCESS_MESSAGE_TITLE" => "Сообщение отправлено",
            "SUCCESS_MESSAGE" => "Мы перезвоним вам в течение 15 минут",
            "GOAL_METRIKA" => "",
            "GOAL_ANALITICS" => "",
            "USE_CAPTCHA" => "N",
            "SAVE" => "Y",
            "BUTTON" => "Отправить",
            "TITLE" => "Запросить предложение",
            "SUBTITLE" => "",
            "PERSONAL_DATA" => "Y",
            "PERSONAL_DATA_PAGE" => "/policy/",
            "PERSONAL_DATA_PAGE2" => "/uslovia/",
            "LEAD_IBLOCK" => ""
        ),
        false
    ); ?>

<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}?>
