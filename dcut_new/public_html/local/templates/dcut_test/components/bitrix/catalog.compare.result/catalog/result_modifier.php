<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult['ITEMS'] as $i=>$arItem){
	foreach($arItem['PROPERTIES'] as $arProp){
        if($arProp['VALUE'] && !$arResult['ALL_PROPS_VALUE'][$arProp['CODE']]){
            $arResult['ALL_PROPS_VALUE'][$arProp['CODE']] = $arProp['CODE'];
        }
	}
	$arIds[] = $arItem['ID'];

}
$cp = $this->__component;
if (is_object($cp))
{
  $cp->arResult["IDS"] = $arIds;
  $cp->SetResultCacheKeys(array("IDS"));
}
