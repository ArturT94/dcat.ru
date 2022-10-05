<? if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;

if($_GET['ID']){
	CModule::IncludeModule('sale');
	$arLocs = CSaleLocation::GetByID($_GET['ID'], LANGUAGE_ID);
	$result['CODE'] = $arLocs['CODE'];
	$result['NAME'] = $arLocs['CITY_NAME'];
}
echo json_encode($result);


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>