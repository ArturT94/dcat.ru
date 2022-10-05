<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
//global $USER;
//$res = CCatalogProduct::setUseDiscount(true);
//$user_group = CUser::GetUserGroup($USER->GetId());
//$arPrice = CCatalogProduct::GetOptimalPrice($arResult['ID'], 1, $user_group, "N");
//if (!$arPrice || count($arPrice) <= 0){
//    if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($arResult['ID'], 1, $user_group)){
//        $quantity = $nearestQuantity;
//        $arPrice = CCatalogProduct::GetOptimalPrice($arResult['ID'], 1, $user_group, "N");
//    }
//}
//$arResult['PRICE'] = number_format(round($arPrice["RESULT_PRICE"]['DISCOUNT_PRICE']), 0, '', ' ');
//if($arPrice['RESULT_PRICE']['DISCOUNT']>0){
//    $arResult['OLD_PRICE'] = number_format(round($arPrice["RESULT_PRICE"]['BASE_PRICE']), 0, '', ' ');
//}
//pre($arResult['PRICE']);

unset($arResult["MORE_PHOTO"]);
if(!$arResult['MIN_PRICE']){
	$arResult['MIN_PRICE'] = $arResult['ITEM_PRICES'][0];
}
if($arResult['DETAIL_PICTURE']){
	$arResult["DETAIL_PICTURE"]['BIG'] = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>555, 'height'=>555), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	$arResult["DETAIL_PICTURE"]['SMALL'] = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>88, 'height'=>88), BX_RESIZE_IMAGE_PROPORTIONAL, true);
}elseif($arResult['PREVIEW_PICTURE']){
	$arResult["DETAIL_PICTURE"]['BIG'] = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE'], array('width'=>555, 'height'=>555), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	$arResult["DETAIL_PICTURE"]['SMALL'] = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE'], array('width'=>88, 'height'=>88), BX_RESIZE_IMAGE_PROPORTIONAL, true);
}else{
	$arResult["DETAIL_PICTURE"]['BIG']['src'] = '/local/templates/freevape/assets/img/no-photo.png';
}

if($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']){
    foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $key => $value)
    {
		if($key>0){
			$arResult["MORE_PHOTO"][$key]['REAL'] = CFile::GetPath($value);
			$arResult["MORE_PHOTO"][$key]['BIG'] = CFile::ResizeImageGet($value, array('width'=>555, 'height'=>555), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$arResult["MORE_PHOTO"][$key]['SMALL'] = CFile::ResizeImageGet($value, array('width'=>88, 'height'=>88), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$arResult["MORE_PHOTO"][$key]['DESCRIPTION'] = $arResult["PROPERTIES"]["MORE_PHOTO"]["DESCRIPTION"][$key];
		}
    }
}


$arSelect = Array("ID", 'IBLOCK_ID', "NAME", "PROPERTY_NAME",'PROPERTY_PLUS','PROPERTY_ELEMENT_ID','PROPERTY_MINUS','PROPERTY_COMMENT','CREATED_DATE','PROPERTY_LIKE','PROPERTY_DISLIKE');
$arFilter = Array("IBLOCK_ID"=>COMMENTS_IBLOCK_ID, "PROPERTY_ELEMENT_ID"=>$arResult['ID'], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('created_date'=>'DESC'), $arFilter, false, Array(), $arSelect);
while($ob = $res->Fetch()){
	$arResult['COMMENTS'][] = $ob;
}

if($arResult['PROPERTIES']){
	$hideProp = array('NOVINKA_1','STARAYA_TSENA','HIDDEN','CML2_ARTICLE','SOOTNOSHENIE_VG_PG','KONTSENTRATSIYA_NIKOTINA','TIP_AKTIVATSII','KOLICHESTVO_AKKUMULYATOROV',
	'TIP_OBDUVA','TIP_AKKUMULYATORA','SMENNYE_ISPARITELI','OBSLUZHIVAEMAYA_BAZA','KOLICHESTVO_SPIRALEY','KOLICHESTVO_SLOTOV','TIP_KNOPKI');
	foreach($arResult['PROPERTIES'] as $prop){
		if(!in_array($prop['CODE'],$hideProp)){
			if($prop['VALUE'] && !is_array($prop['VALUE'])){
				$prop['NAME'] = str_replace(array('Справочник - ',' - справочник2',' - справочник'),'',$prop['NAME']);
				$arResult['SHOW_PROPS'][$prop['NAME']] = $prop;
			}
		}
	}
}


$avg = 0;
$arSelect = Array("ID", 'IBLOCK_ID', "NAME", "PREVIEW_TEXT", "PROPERTY_NAME", "PROPERTY_RATING",'PROPERTY_PLUS','PROPERTY_ELEMENT_ID','PROPERTY_MINUS','PROPERTY_COMMENT','CREATED_DATE','PROPERTY_LIKE','PROPERTY_DISLIKE');
$arFilter = Array("IBLOCK_ID"=>7, "PROPERTY_ELEMENT_ID"=>$arResult['ID'], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('created_date'=>'DESC'), $arFilter, false, Array(), $arSelect);
while($ob = $res->Fetch()){
    $avg += $ob['PROPERTY_RATING_VALUE'];
    $arResult['REVIEWS'][] = $ob;
}
$arResult['AVG_REVIEWS'] = $avg/count($arResult['REVIEWS']);
global $APPLICATION;
$arResult['STORE_ID'] = $APPLICATION->get_cookie('SELECT_SHOP');
	
//pre($arResult['OFFERS'][0]['PROPERTIES']['CML2_ATTRIBUTES']['VALUE']);	
$cp = $this->__component;
if (is_object($cp))
{
  $cp->arResult["ID"] = $arResult["ID"];
  $cp->SetResultCacheKeys(array("ID"));
}


