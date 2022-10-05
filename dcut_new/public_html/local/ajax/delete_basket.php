<?
 if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("iblock")) {
	$this->AbortResultCache();
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}
if (!CModule::IncludeModule("catalog")) {
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}
if (!CModule::IncludeModule("sale")) {
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}

if($_REQUEST['ID']):
    CSaleBasket::Delete($_REQUEST['ID']);
    ob_start(); ?>
    
    <? $arJSON["BASKET_HTML"] = ob_get_contents(); ?>
    <? ob_end_clean();
    echo json_encode($arJSON);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>