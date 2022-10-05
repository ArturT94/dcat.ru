<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

$defaultParams = array(
	'TEMPLATE_THEME' => 'blue'
);
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$templateId = (string)Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
		$arParams['TEMPLATE_THEME'] = (string)Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';

foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader){
    if($arHeader["id"] == "SUM"){
        $sum = $arResult["GRID"]["HEADERS"][$id];
        unset($arResult["GRID"]["HEADERS"][$id]);
        $arResult["GRID"]["HEADERS"][] = $sum;
    }
}

foreach ($arResult["GRID"]["ROWS"] as $k => $arItem){
    $res = CIBlockElement::GetProperty(1, $arItem['PRODUCT_ID'], "sort", "asc", array("CODE" => "ARTICLE"));
    if ($ob = $res->GetNext())
    {
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["CODE"] = $ob['CODE'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["VALUE"] = $ob['VALUE'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["NAME"] = $ob['NAME'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["ID"] = $ob['ID'];
    }
    $res = CIBlockElement::GetProperty(1, $arItem['PRODUCT_ID'], "sort", "asc", array("CODE" => "COLOR"));
    if ($ob = $res->GetNext())
    {
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["CODE"] = $ob['CODE'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["VALUE"] = $ob['VALUE_ENUM'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["NAME"] = $ob['NAME'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["ID"] = $ob['ID'];
    }
    $res = CIBlockElement::GetProperty(1, $arItem['PRODUCT_ID'], "sort", "asc", array("CODE" => "SIZE"));
    if ($ob = $res->GetNext())
    {
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["CODE"] = $ob['CODE'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["VALUE"] = $ob['VALUE'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["NAME"] = $ob['NAME'];
        $arResult["GRID"]["ROWS"][$k]["PROPS"][$ob['CODE']]["ID"] = $ob['ID'];
    }

    $arIds[$arItem['PRODUCT_ID']] = $arItem['PRODUCT_ID'];
    $arOfferIds[$arItem['PRODUCT_ID']] = $arItem['PRODUCT_ID'];
}
if($arIds){
    $arSelect = Array("ID", "NAME", "PROPERTY_WEIGHT");
    $arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", 'ID' => $arIds);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->Fetch()){
        $arResult['WEIGHT'][$ob['ID']] = $ob['PROPERTY_WEIGHT_VALUE'];
        $arResult['IDS'][$ob['ID']] = $ob['ID'];
        unset($arOfferIds[$ob['ID']]);
    }

    if($arOfferIds){
        $arSelect = Array("ID", "NAME", "PROPERTY_WEIGHT");
        $arFilter = Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", 'ID' => $arOfferIds);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()){
            $arResult['WEIGHT'][$ob['ID']] = $ob['PROPERTY_WEIGHT_VALUE'];
        }
    }
}

$arResult["COUNT"] = count($arResult["GRID"]["ROWS"]);


