<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	// we dont trust input params, so validation is required
	$legalColors = array(
		'green' => true,
		'yellow' => true,
		'red' => true,
		'gray' => true
	);
	// default colors in case parameters unset
	$defaultColors = array(
		'N' => 'green',
		'P' => 'yellow',
		'F' => 'gray',
		'PSEUDO_CANCELLED' => 'red'
	);

//	foreach ($arParams as $key => $val)
//		if(strpos($key, "STATUS_COLOR_") !== false && !$legalColors[$val])
//			unset($arParams[$key]);
//
//	// to make orders follow in right status order
//	foreach($arResult['INFO']['STATUS'] as $id => $stat)
//	{
//		$arResult['INFO']['STATUS'][$id]["COLOR"] = $arParams['STATUS_COLOR_'.$id] ? $arParams['STATUS_COLOR_'.$id] : (isset($defaultColors[$id]) ? $defaultColors[$id] : 'gray');
//		$arResult["ORDER_BY_STATUS"][$id] = array();
//	}
//	$arResult["ORDER_BY_STATUS"]["PSEUDO_CANCELLED"] = array();
//
//	$arResult["INFO"]["STATUS"]["PSEUDO_CANCELLED"] = array(
//		"NAME" => GetMessage('SPOL_PSEUDO_CANCELLED'),
//		"COLOR" => $arParams['STATUS_COLOR_PSEUDO_CANCELLED'] ? $arParams['STATUS_COLOR_PSEUDO_CANCELLED'] : (isset($defaultColors['PSEUDO_CANCELLED']) ? $defaultColors['PSEUDO_CANCELLED'] : 'gray')
//	);
//
//	if(is_array($arResult["ORDERS"]) && !empty($arResult["ORDERS"]))
//		foreach ($arResult["ORDERS"] as $order)
//		{
//
//            foreach($order['BASKET_ITEMS'] as &$bsk) {
//
//                $rr = CIBlockElement::GetByID($bsk['PRODUCT_ID']);
//                if($r = $rr->Fetch())
//                    $bsk['IBLOCK_ID'] = $r['IBLOCK_ID'];
//
//            }
//
//			$order['HAS_DELIVERY'] = intval($order["ORDER"]["DELIVERY_ID"]) || strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false;
//
//			$stat = $order['ORDER']['CANCELED'] == 'Y' ? 'PSEUDO_CANCELLED' : $order["ORDER"]["STATUS_ID"];
//			$color = $arParams['STATUS_COLOR_'.$stat];
//			$order['STATUS_COLOR_CLASS'] = empty($color) ? 'gray' : $color;
//
//			$arResult["ORDER_BY_STATUS"][$stat][] = $order;
//		}
//

if ($arStatus = CSaleStatus::GetList(array(),array(),false,false,array())){
    while($ob = $arStatus->Fetch()) {
        $arResult['STATUS_INFO'][$ob['ID']] = $ob;
    }
}
if($arResult['ORDERS']){
    foreach ($arResult['ORDERS'] as $kk=>$order){
        foreach($order['BASKET_ITEMS'] as $item){
			$arIds[$item['PRODUCT_ID']] = $item['PRODUCT_ID'];
		}
    }
}
if($arIds){
	$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE");
	$arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$arIds, "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->Fetch()){
		$arResult['PICTURES'][$ob['ID']] = CFile::GetPath($ob['PREVIEW_PICTURE']);
	}
}


?>

