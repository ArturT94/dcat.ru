<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? 
//Prymery\Regionality::CatalogQuantityInCurLocation();
if($arParams['SEARCH_FILTER']){
	foreach($arResult["ITEMS"] as $i => $arItem){
		$nav = CIBlockSection::GetNavChain(false, $ar_el['IBLOCK_SECTION_ID']);
		while($section = $nav->ExtractFields("nav_")){
			if($section['DEPTH_LEVEL'] == 1){
				$arParentSectionName = $section['NAME'];
			}
		}
		if(in_array($arParentSectionName,array('Хозтовары','Вода','Отчёт','Услуги'))){
			unset($arResult["ITEMS"][$i]);
		}
	}
}


foreach($arResult["ITEMS"] as $i => $arItem){
	if($arItem["IBLOCK_SECTION_ID"]){
		$res = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);
		if($ar_res = $res->GetNext()){
			if(!strpos($arItem['DETAIL_PAGE_URL'],'/'.$ar_res['CODE'].'/')){
				$arResult["ITEMS"][$i]['DETAIL_PAGE_URL'] = str_replace('/catalog/','/catalog/'.$ar_res['CODE'].'/',$arItem['DETAIL_PAGE_URL']);
			}
		}
	}
	
	if($arItem["PREVIEW_PICTURE"]){
		$resize = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$arResult["ITEMS"][$i]["PREVIEW_PICTURE"]['SRC'] = $resize['src'];
	}else{
		$arResult["ITEMS"][$i]["PREVIEW_PICTURE"]['SRC'] = '/local/templates/freevape/assets/img/no-photo.png';
	}
	if($arItem['OFFERS']){
		$arResult["ITEMS"][$i]['CUSTOM_QUANTITY'] = Prymery\Regionality::CatalogQuantityInCurLocation($arItem['OFFERS'][0]['ID']);
	}else{
		$arResult["ITEMS"][$i]['CUSTOM_QUANTITY'] = Prymery\Regionality::CatalogQuantityInCurLocation($arItem['ID']);
	}
	
	$arIds[] = $arItem['ID'];
	$arResult["ITEMS"][$i]['CUSTOM_QUANTITY_SORT'] = $arResult["ITEMS"][$i]['CUSTOM_QUANTITY'];
	if($arResult["ITEMS"][$i]['CUSTOM_QUANTITY'] == 'otherShop'){
		$arResult["ITEMS"][$i]['CUSTOM_QUANTITY_SORT'] = 0;
	}elseif($arResult["ITEMS"][$i]['CUSTOM_QUANTITY'] == 0){
		$arResult["ITEMS"][$i]['CUSTOM_QUANTITY_SORT'] = -1;
	}
}
usort($arResult["ITEMS"], function($a,$b){
    return ($b['CUSTOM_QUANTITY_SORT']-$a['CUSTOM_QUANTITY_SORT']);
});



$arSelect = Array("ID", 'IBLOCK_ID', "NAME", "PROPERTY_NAME",'PROPERTY_PLUS','PROPERTY_MINUS','PROPERTY_COMMENT','CREATED_DATE');
$arFilter = Array("IBLOCK_ID"=>COMMENTS_IBLOCK_ID, "PROPERTY_ELEMENT_ID"=>$arIds, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->Fetch()){
	$arResult['COMMENTS'][$ob['PROPERTY_ELEMENT_ID_VALUE']][] = $ob;
}


$cp = $this->__component;
if (is_object($cp))
{
  $cp->arResult["IDS"] = $arIds;
  $cp->SetResultCacheKeys(array("IDS"));
}
?>