<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arSort = array(
      $arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"],
      $arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"],
   );
$arSelect = array("ID", "DETAIL_PAGE_URL");
$arFilter = array (
      "IBLOCK_ID" => $arResult["IBLOCK_ID"],
      "ACTIVE" => "Y",
      "CHECK_PERMISSIONS" => "Y",
   );
$arNavParams = array(
      "nPageSize" => 1,
      "nElementID" => $arResult["ID"],
   );
$arItems = Array();
$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);
$rsElement->SetUrlTemplates($arParams["DETAIL_URL"]);
while($obElement = $rsElement->GetNextElement())
      $arItems[] = $obElement->GetFields();
if(count($arItems)==3):
   $arResult["TORIGHT"] = Array("URL"=>$arItems[0]["DETAIL_PAGE_URL"]);
   $arResult["TOLEFT"] = Array("URL"=>$arItems[2]["DETAIL_PAGE_URL"]);
elseif(count($arItems)==2):
   if($arItems[0]["ID"]!=$arResult["ID"])
      $arResult["TORIGHT"] = Array("URL"=>$arItems[0]["DETAIL_PAGE_URL"]);
   else
      $arResult["TOLEFT"] = Array("URL"=>$arItems[1]["DETAIL_PAGE_URL"]);
endif;

