<? if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;

$compareKey = 'CATALOG_COMPARE_LIST';
$result = 0;
if($_SESSION[$compareKey]){
	foreach($_SESSION[$compareKey] as $iblock){
		$result = $result + count($iblock['ITEMS']);
	}
}

echo json_encode($result);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>