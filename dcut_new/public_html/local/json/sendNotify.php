<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Xzag\Telegram\Container;
use Xzag\Telegram\Service\Notification\TelegramNotification;
use Xzag\Telegram\Service\NotificationService;

if (!CModule::IncludeModule("iblock")) {
    $this->AbortResultCache();
    ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
    return;
}

if($_REQUEST['GUID']){
    $arSelect = Array("ID", "NAME", "PROPERTY_PRODUCT", "PROPERTY_PRODUCTSKU", "PROPERTY_ORDERNUMBER");
    $arFilter = Array("IBLOCK_ID"=>20, "PROPERTY_GUIDDOCUMENT"=>$_REQUEST['GUID'], "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
    while($ob = $res->Fetch()) {
        $curOrder = $ob;
    }

    global $USER;
    CModule::IncludeModule('xzag.telegram');
    $notification = (new TelegramNotification('5541039527:AAFXTAXPdOTE--EYnHfjxAgOgix7YOEM6OM'))->to('-613930227');
    $notificator = Container::get(NotificationService::class);
    $notificator->with($notification)->send('Пользователем '.$USER->GetLogin().' из компании ['.$USER->GetFullName().'] запросил подмену '.$curOrder['PROPERTY_PRODUCT_VALUE'].' ['.$curOrder['PROPERTY_PRODUCTSKU_VALUE'].'] по приему в ремонт '.$curOrder['PROPERTY_ORDERNUMBER_VALUE']);
}
echo 1;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>