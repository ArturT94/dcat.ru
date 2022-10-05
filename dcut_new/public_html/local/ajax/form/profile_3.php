<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
}?>

<?
if($_REQUEST['id']){
    $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), array('ID'=>$_REQUEST['id']),array('SELECT'=>array('UF_*')));
    while($arUser = $rsUsers->Fetch()){
        $arCurUser = $arUser;
    }
}
$APPLICATION->IncludeComponent(
    "prymery:feedback.form",
    "modal2",
    array(
        "ARFIELDS" => array(
            0 => "NAME",
            1 => "EMAIL",
            2 => "USER_NAME",
            3 => "USER_ID",
            4 => "USER_GUID",
        ),
        "REQUEST_ARFIELDS" => array(
            0 => "NAME",
            1 => "EMAIL",
        ),
        "USER_NAME" => $arCurUser['NAME'],
        "USER_GUID" => $arCurUser['UF_GUID'],
        "USER_ID" => $_REQUEST['id'],
        "COMPONENT_TEMPLATE" => ".default",
        "EMAIL_TO" => "buh@dcut.ru",
        "SUCCESS_MESSAGE_TITLE" => "Сообщение отправлено",
        "SUCCESS_MESSAGE" => "Мы свяжемся с вами в ближайшее время",
        "GOAL_METRIKA" => "",
        "GOAL_ANALITICS" => "",
        "USE_CAPTCHA" => "N",
        "SAVE" => "Y",
        "BUTTON" => "Запросить",
        "TITLE" => "Запросить акт сверки",
        "SUBTITLE" => "",
        "PERSONAL_DATA" => "Y",
        "PERSONAL_DATA_PAGE" => "/policy/",
        "PERSONAL_DATA_PAGE2" => "/uslovia/",
        "LEAD_IBLOCK" => ""
    ),
    false
); ?>
<script>
    $('.prForm input[name=NAME]').val("<?=$arCurUser['NAME']?>");
    $('.prForm input[name=EMAIL]').val("<?=$arCurUser['EMAIL']?>");
    $('.prForm button').click();
</script>
<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}?>
