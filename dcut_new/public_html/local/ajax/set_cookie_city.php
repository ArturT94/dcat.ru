<? if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_REQUEST['ID']){
	global $APPLICATION;
	/*\Bitrix\Main\Loader::includeModule('sale');
	$res = \Bitrix\Sale\Location\LocationTable::getList(array(
		'order' => array('NAME_RU' => 'asc'), 
		'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'ID' => $_REQUEST['ID']),
		'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
	));
	while($item = $res->fetch()){
		$arRegionName = $item['NAME_RU'];
	}
	
	$arSelect = Array("ID", "NAME", "PROPERTY_LINK");
	$arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "NAME"=>$arRegionName, "ACTIVE"=>"Y");
	$res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->Fetch()){
		$domainUrl = $ob['PROPERTY_LINK_VALUE'];
	}*/
	
	$APPLICATION->set_cookie('CURRENT_REGION',$_REQUEST['ID'],time()+60*60*24*30*12*2,"/",'freevape.ru');
	$APPLICATION->set_cookie('SELECT_SHOP',"",time()+60*60*24*30*12*2,"/",'freevape.ru');
	echo json_encode('good');
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>