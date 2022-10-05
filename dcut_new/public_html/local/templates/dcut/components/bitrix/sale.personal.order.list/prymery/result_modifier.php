<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult['ORDERS']){
    foreach ($arResult['ORDERS'] as $key => $order) {
        if($order['BASKET_ITEMS']){
            foreach($order['BASKET_ITEMS'] as $item){
                $allIds[$item['PRODUCT_ID']] = $item['PRODUCT_ID'];
            }
        }
    }

    if($allIds){
        $arSelect = Array("ID", "NAME", "PROPERTY_CML2_ARTICLE", "DETAIL_PAGE_URL");
        $arFilter = Array("IBLOCK_ID"=>11, "ID"=>$allIds, "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->GetNext()) {
            $arResult['PRODUCTS'][$ob['ID']] = $ob;
        }
    }
}
