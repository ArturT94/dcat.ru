<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

CModule::IncludeModule('sale');
foreach($arResult['JS_DATA']['ORDER_PROP']['properties'] as $key=>$prop){
	if($prop['CODE'] == 'LOCATION' && $APPLICATION->get_cookie('CURRENT_REGION')){
		$arLocs = CSaleLocation::GetByID($APPLICATION->get_cookie('CURRENT_REGION'), LANGUAGE_ID);
		/*$arResult['JS_DATA']['ORDER_PROP']['properties'][$key]['VALUE'][0] = $arLocs['CODE'];
		$arResult['ORDER_DATA']['DELIVERY_LOCATION_BCODE'] = $arLocs['CODE'];
		$arResult['ORDER_DATA']['ORDER_PROP'][$prop['ID']] = $arLocs['CODE'];
		$arResult['USER_VALS']['DELIVERY_LOCATION_BCODE'] = $arLocs['CODE'];
		$arResult['USER_VALS']['ORDER_PROP'][$prop['ID']] = $arLocs['CODE'];
		$arResult['LOCATIONS'][$prop['ID']]['lastValue'] = $arLocs['CODE'];*/
		$arResult['LOCATIONS'][$prop['ID']]['output'][0] = "";
	}
}

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);


global $USER;
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

if(!$arUser["PERSONAL_PHONE"]){
    $user = new CUser;
    $fields = Array(
        "PERSONAL_PHONE"  => $arUser["UF_BXMAKER_AUPHONE"],
    );
    $user->Update($arUser["ID"], $fields);
    $arResult["arUser"]["PERSONAL_PHONE"] = $arResult["arUser"]["UF_BXMAKER_AUPHONE"];
}
