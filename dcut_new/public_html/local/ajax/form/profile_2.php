<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
}?>

<?
if($_REQUEST['id']){
    $email = 'zs@dcut.ru';
    $INDICATOR_IBLOCK_ID = 15;
    $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), array('ID'=>$_REQUEST['id']),array('SELECT'=>array('UF_*')));
    while($arUser = $rsUsers->Fetch()){
        $arCurUser = $arUser;
    }
    if($arCurUser['UF_GUID']){
        $arSelect = Array("ID", "NAME", "PROPERTY_*","PROPERTY_INDICATOR","PROPERTY_MANAGER_MAIL");
        $arFilter = Array("IBLOCK_ID"=>13, "PROPERTY_GUID"=>$arCurUser['UF_GUID'], "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()) {
            $arCurLk = $ob;
        }
        if($arCurLk){
            $email = $arCurLink['PROPERTY_MANAGER_MAIL_VALUE'];
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
            "EMAIL_TO" => $email,
            "SUCCESS_MESSAGE_TITLE" => "Сообщение отправлено",
            "SUCCESS_MESSAGE" => "Мы свяжемся с вами в ближайшее время",
            "GOAL_METRIKA" => "",
            "GOAL_ANALITICS" => "",
            "USE_CAPTCHA" => "N",
            "SAVE" => "Y",
            "BUTTON" => "Отправить",
            "TITLE" => "Получить анализ в PDF",
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
}
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}?>
