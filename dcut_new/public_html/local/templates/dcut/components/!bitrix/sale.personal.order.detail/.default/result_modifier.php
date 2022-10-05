<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arStatus = CSaleStatus::GetList(array(),array(),false,false,array())){
    while($ob = $arStatus->Fetch()) {
        $arResult['STATUS_INFO'][$ob['ID']] = $ob;
    }
}
if ($arStatus = CSaleStatus::GetList(array(),array(),false,false,array())){
    while($ob = $arStatus->Fetch()) {
        $arResult['STATUS_INFO'][$ob['ID']] = $ob;
    }
}

if($arResult['ORDER_PROPS']){
	foreach($arResult['ORDER_PROPS'] as $prop){
		$arResult['CUSTOM_PROPS'][$prop['CODE']] = $prop;
	}
}

if($arResult['DELIVERY_ID']){
	$arResult['CUSTOM_DELIVERY'] = CSaleDelivery::GetByID($arResult['DELIVERY_ID']);
}
if($arResult['PAY_SYSTEM_ID']){
	$arResult['CUSTOM_PAY_SYSTEM'] = CSalePaySystem::GetByID($arResult['PAY_SYSTEM_ID']);
}



?>

