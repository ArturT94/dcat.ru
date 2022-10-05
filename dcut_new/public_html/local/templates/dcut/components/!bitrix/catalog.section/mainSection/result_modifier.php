<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? 

//Prymery\Regionality::CatalogQuantityInCurLocation();
foreach($arResult["ITEMS"] as $i => $arItem){
	if($arItem["PREVIEW_PICTURE"]){
		$resize = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$arResult["ITEMS"][$i]["PREVIEW_PICTURE"]['SRC'] = $resize['src'];
	}else{
		$arResult["ITEMS"][$i]["PREVIEW_PICTURE"]['SRC'] = '/local/templates/freevape/assets/img/no-photo.png';
	}

	if($arItem['OFFERS']){
		foreach($arItem['OFFERS'] as $off){
			$custom_quan = Prymery\Regionality::CatalogQuantityInCurLocation($off['ID']);
			if($custom_quan != 'empty'){
				$arResult["ITEMS"][$i]['CUSTOM_QUANTITY'] = Prymery\Regionality::CatalogQuantityInCurLocation($off['ID']);
				break;
			}
		}
		if(!$arResult["ITEMS"][$i]['CUSTOM_QUANTITY']){
			$arResult["ITEMS"][$i]['CUSTOM_QUANTITY'] = Prymery\Regionality::CatalogQuantityInCurLocation($arItem['OFFERS'][0]['ID']);
		}
		
	}else{
		$arResult["ITEMS"][$i]['CUSTOM_QUANTITY'] = Prymery\Regionality::CatalogQuantityInCurLocation($arItem['ID']);
	}
	$arIds[] = $arItem['ID'];
}

$arSelect = Array("ID", 'IBLOCK_ID', "NAME", "PROPERTY_NAME",'PROPERTY_ELEMENT_ID', 'PROPERTY_PLUS','PROPERTY_MINUS','PROPERTY_COMMENT','CREATED_DATE');
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