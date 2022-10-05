<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("DCUT");
CModule::IncludeModule('iblock');
//$arDiscount = CSaleDiscount::GetByID(3);
//pre($arDiscount);
//pre(unserialize($arDiscount['CONDITIONS']));
//pre(unserialize($arDiscount['APPLICATION']));
//pre(unserialize($arDiscount['ACTIONS']));


//$db_res = CSaleDiscount::GetList(array(),array(),false,false,array());
//if ($ar_res = $db_res->Fetch()) {
//    print_r($ar_res);
//}
//$obElement = new \CIBlockElement();
//$arSelect = Array("ID", "NAME",'IBLOCK_ID','PROPERTY_GUID');
//$arFilter = Array("IBLOCK_ID"=>13);
//$res = $obElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
//while($ob = $res->Fetch()){
//    $allUsers[$ob['PROPERTY_GUID_VALUE']] = $ob['ID'];
//}
//pre($allUsers);
//$user = new CUser;
//$arFields = array(
//    "NAME" => 'Илгар',
//    "EMAIL" => 'sk.ilgar@mail.ru',
//    "LOGIN" => 'sk.ilgar@mail.ru',
//    "LID" => "s1",
//    "ACTIVE" => "Y",
//    "UF_GUID" => '5537f43e-be1b-4b97-9091-c707c0153a5d',
//    "GROUP_ID" => array(3, 4),
//    "PASSWORD" => '95mBT$N49xXd',
//    "CONFIRM_PASSWORD" => '95mBT$N49xXd',
//);
//$userId = $user->Add($arFields);
//pre($userId);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>