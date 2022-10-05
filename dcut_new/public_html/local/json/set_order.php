<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Main\Loader::includeModule('sale');
$el = new \CIBlockElement;

if($_REQUEST['START_IMPORT_DCUT'] == 'YES') {
    //TODO: ping method
//    $host = 'https://s.dcut.ru/UCS_DIKAT/hs/PersAcc/ping/';
    $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/ping/';
    $login = 'USERHTTP';
    $pass = '123';
    $USERS_IBLOCK_ID = 13;
    $INDICATOR_IBLOCK_ID = 15;
    $GUID_SOURCE = '90802caa-5c8d-4e9a-8147-b8f0a806093c';
    $GUID_FIZ = '00000000-000-0000-0000-defaultPP';

    $credentials = base64_encode("$login:$pass");
    $headers[] = "Authorization: Basic {$credentials}";
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'Cache-Control: no-cache';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $PROP = array("DATE" => date("d.m.Y h:m:s"),"HOST" => 'ping');
    $arLoadProductArray = Array(
        "IBLOCK_ID"      => 14,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => 'ping '.date("d.m.Y h:m:s"),
        "ACTIVE"         => "Y",
        "PREVIEW_TEXT"   => $postData,
        "DETAIL_TEXT"    => cut_string($result,65530),
    );
    //$ID_journal = $el->Add($arLoadProductArray);

    if($result == 'ok'){
//        $host = 'https://s.dcut.ru/UCS_DIKAT/hs/PersAcc/customerorders';
        $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/customerorders/';

        $orderId = 22;
        $db_sales = CSaleOrder::GetList(array(), Array("ID" => $orderId));
        while ($ar_sales = $db_sales->Fetch()) {
            $arOrder = $ar_sales;
        }

        $order_props = CSaleOrderPropsValue::GetOrderProps($arOrder['ID']);
        while ($arProps = $order_props->Fetch()){
            $allProps[$arProps['CODE']] = $arProps['VALUE'];
        }
        $filter = Array();
        $rsUsers = CUser::GetList(($by="id"), ($order="desc"), array('ID'=>$arOrder['USER_ID']),array('SELECT'=>array('UF_*')));
        while($arUser = $rsUsers->Fetch()){
            $arCurUser = $arUser;
        }

        $dbBasketItems = CSaleBasket::GetList(array(),array("LID" => SITE_ID,"ORDER_ID" => $arOrder['ID']),false,false,array("ID","PRODUCT_ID", "QUANTITY","PRICE"));
        while ($arItems = $dbBasketItems->Fetch()){
            $allBasket[] = $arItems;
            $allIds[$arItems['PRODUCT_ID']] = $arItems['PRODUCT_ID'];
        }

        if($allIds){
            $arSelect = Array("ID", "NAME", "PROPERTY_GUID", "PROPERTY_CML2_ARTICLE");
            $arFilter = Array("IBLOCK_ID"=>11, "ID"=>$allIds, "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                $allProducts[$ob['ID']] = $ob;
            }
        }

        foreach($allBasket as $item){
            $orderProducts[] = [
                'GUID' => $allProducts[$item['PRODUCT_ID']]['PROPERTY_GUID_VALUE'],
                'Article' => $allProducts[$item['PRODUCT_ID']]['PROPERTY_CML2_ARTICLE_VALUE'],
                'Quantity' => $item['QUANTITY'],
                'Price' => $item['PRICE'],
                'Sum' => ($item['QUANTITY']*$item['PRICE']),
            ];
        }

        unset($postData);
        $guid_transaction = guid_generate();
        $explode_date = explode(' ',$arOrder['DATE_INSERT']);
        $explode_date2 = explode('.',$explode_date[0]);

        if($allProps['GUID']){
            $GUID_FIZ = $allProps['GUID'];
        }elseif($arCurUser['UF_GUID']){
            $GUID_FIZ = $arCurUser['UF_GUID'];
        }

        $postData = array(
            'TransactionID' => $guid_transaction,
            'SourceID' => $GUID_SOURCE,
            'GUIDPersonalAccount' => $arCurUser['UF_GUID'],
            'GUIDCustomer' => $GUID_FIZ,
            'Order' => [
                'DateOrder'=>$explode_date2[2].'-'.$explode_date2[1].'-'.$explode_date2[0].'T'.$explode_date[1].'+03:00',
                'NumberOrder'=>$arOrder['ID'].'BX',
//                'Comment'=>$arOrder['USER_DESCRIPTION'],
                'Comment'=>'TEST ORDER',
                'Sum'=>$arOrder['PRICE'],
                'VAT'=>1,
                'SizeVAT'=>20,
                'Products'=>$orderProducts,
            ],
        );

        $postData = json_encode($postData);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $result = curl_exec($ch);
        $arResult = json_decode($result);
        pre($arResult->response->Number1C);

        if($arResult->response->Number1C){
            CSaleOrderPropsValue::Add(array(
                'NAME' => 'Номер заказа в 1С',
                'ORDER_PROPS_ID' => 13,
                'ORDER_ID' => $arOrder['ID'],
                'VALUE' => $arResult->response->Number1C,
            ));

            $db_vals = CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $arOrder['ID'], 'ORDER_PROPS_ID' => 13));
            if ($arVals = $db_vals->Fetch()) {
                CSaleOrderPropsValue::Update($arVals['ID'], array(
                    'NAME' => $arVals['NAME'],
                    'CODE' => $arVals['CODE'],
                    'ORDER_PROPS_ID' => $arVals['ORDER_PROPS_ID'],
                    'ORDER_ID' => $arOrder['ID'],
                    'VALUE' => $arResult->response->Number1C,
                ));
            }
//            if($ex = $APPLICATION->GetException()) echo $ex->GetString().'<br>';
        }

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $PROP = array("DATE" => date("d.m.Y h:m:s"),"HOST" => 'set_order',"GUID" => $guid_transaction);
        $arLoadProductArray = Array(
            "IBLOCK_ID"      => 14,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => 'set_order '.date("d.m.Y h:m:s"),
            "ACTIVE"         => "Y",
            "PREVIEW_TEXT"   => $postData,
            "DETAIL_TEXT"    => cut_string($result,65530),
        );
        $ID_journal = $el->Add($arLoadProductArray);
    }
}