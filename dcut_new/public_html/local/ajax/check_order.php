<?
 if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


if (!CModule::IncludeModule("sale")) {
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}

if($_REQUEST['PHONE'] && $_REQUEST['ORDER']):
	unset($phone);
	unset($arOrder);
	if ($arOrder = CSaleOrder::GetByID($_REQUEST['ORDER'])){
		$db_props = CSaleOrderPropsValue::GetOrderProps($_REQUEST['ORDER']);
		while ($arProps = $db_props->Fetch()){
			if($arProps['CODE'] == 'PHONE'){
				$phone = $arProps['VALUE']; 
			}
		}
		if($phone == str_replace(array(' ','(',')','-','+'),'',$_REQUEST['PHONE'])){
			if ($arStatus = CSaleStatus::GetList(array(),array(),false,false,array())){
				while($ob = $arStatus->Fetch()) {
					$arResult['STATUS_INFO'][$ob['ID']] = $ob['NAME'];
				}
			}
			$arJSON['RESPONSE'] = 'ok';
			$arJSON['MESSAGE'] = $arResult['STATUS_INFO'][$arOrder['STATUS_ID']];
		}else{
			$arJSON['RESPONSE'] = 'err';
			$arJSON['MESSAGE'] = 'Номер телефона и номер заказа не совпадают. Повторите попытку.';
		}
	}else{
		$arJSON['RESPONSE'] = 'err';
		$arJSON['MESSAGE'] = 'Номер телефона и номер заказа не совпадают. Повторите попытку.';
	}
    echo json_encode($arJSON);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>