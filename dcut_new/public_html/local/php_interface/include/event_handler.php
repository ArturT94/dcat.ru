<?

//AddEventHandler("iblock", "OnAfterIBlockSectionUpdate", "OnAfterIBlockSectionUpdateHandler");
AddEventHandler("iblock", "OnAfterIBlockSectionAdd", "OnAfterIBlockSectionUpdateHandler");
AddEventHandler("catalog", "OnSuccessCatalogImport1C", "OnAfterIBlockSectionUpdateHandler");

function OnAfterIBlockSectionUpdateHandler(&$arFields){
	\Bitrix\Main\Loader::includeModule('iblock'); 	
	
	$arFilter = Array('IBLOCK_ID'=>CATALOG_IBLOCK_ID, 'GLOBAL_ACTIVE'=>'Y', 'ID'=>$arFields['ID']);
	$db_list = CIBlockSection::GetList(Array(), $arFilter, false,array('ID','NAME','CODE'));
	while($ar_result = $db_list->Fetch()){
		$arCurSection = $ar_result;
	}
	unset($arSection2);
	if($arCurSection){
		$arParams = array("replace_space"=>"-","replace_other"=>"-");
		$trans = Cutil::translit($arCurSection['NAME'],"ru",$arParams);
	
		$arFilter = Array('IBLOCK_ID'=>CATALOG_IBLOCK_ID, 'CODE'=>$arCurSection['CODE']);
		$db_list = CIBlockSection::GetList(Array(), $arFilter, true);
		while($ar_result = $db_list->Fetch()){
			$arSection2[] = $ar_result;
		}
	}
	
	$bs = new CIBlockSection;
	if(count($arSection2)>1){
		$arFields2 = Array(
			"CODE" => $trans.'2',
			"IBLOCK_ID" => CATALOG_IBLOCK_ID,
		);
	}else{
		$arFields2 = Array(
			"CODE" => $trans,
			"IBLOCK_ID" => CATALOG_IBLOCK_ID,
		);
	}
	$res = $bs->Update($arFields['ID'], $arFields2);
}

AddEventHandler("main", "OnBeforeUserAdd", "OnBeforeUserUpdateHandler");
function OnBeforeUserUpdateHandler(&$arFields){
       $arFields["LOGIN"] = $arFields["EMAIL"];
       return $arFields;
}


AddEventHandler('sale', 'OnOrderNewSendEmail', array('CSendOrderPass', 'OnOrderNewSendEmailHandler'));
AddEventHandler('sale', 'OnOrderStatusSendEmail', array('CSendOrderPass', 'OnOrderNewSendEmailHandler'));
AddEventHandler('main', 'OnBeforeUserAdd', array('CSendOrderPass', 'OnBeforeUserAddHandler'));
class CSendOrderPass {

    private static $newUserLogin = false;
    private static $newUserPass = false;

    public static function OnBeforeUserAddHandler(&$arFields) {
        self::$newUserLogin = $arFields['LOGIN'];
        self::$newUserPass = $arFields['PASSWORD'];
    }

    public static function OnOrderNewSendEmailHandler($ID, $eventName, &$arFields) {
        if (self::$newUserPass == false) {
            $arFields['PASSWORD'] = '';
        } else {
            $arFields['PASSWORD'] = "\n".'Ваш логин: '.self::$newUserLogin;
            $arFields['PASSWORD'] .= "\n".'Ваш пароль: '.self::$newUserPass;
        }
    }
}

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");
function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
    $additional_information = '';
    $arOrder = CSaleOrder::GetByID($orderID);
    $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
    while ($arProps = $order_props->Fetch()){
    
        if ($arProps['ORDER_PROPS_ID']==1 && $arProps['VALUE']){
            $additional_information.='<b>Имя</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==2 && $arProps['VALUE']){
            $additional_information.='<b>E-mail</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==3 && $arProps['VALUE']){
            $additional_information.='<b>Телефон</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==6 && $arProps['VALUE']){
			$arLocs = CSaleLocation::GetByID($arProps['VALUE'], LANGUAGE_ID);
            $additional_information.='<b>Город</b>: '.$arLocs["CITY_NAME"].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==4 && $arProps['VALUE']){
            $additional_information.='<b>Индекс</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==7 && $arProps['VALUE']){
            $additional_information.='<b>Улица</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==8 && $arProps['VALUE']){
            $additional_information.='<b>Фамилия</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==9 && $arProps['VALUE']){
            $additional_information.='<b>Дом</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==10 && $arProps['VALUE']){
            $additional_information.='<b>Квартира</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==14 && $arProps['VALUE']){
            $additional_information.='<b>Подъезд</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==13 && $arProps['VALUE']){
            $additional_information.='<b>Магазин откуда хотят забрать заказ</b>: '.$arProps['VALUE'].'<br />';
        }
        if ($arProps['ORDER_PROPS_ID']==12 && $arProps['VALUE']){
            $additional_information.='<b>Адрес ПВЗ СДЭК</b>: '.$arProps['VALUE'].'<br />';
        }

    }
	//AddMessage2Log('$arOrder = '.print_r($arOrder, true),'');
	if($arOrder['DELIVERY_ID'] == 'sdek:courier'){
		$additional_information.='<b>Доставка</b>: Курьерская доставка СДЭК<br />';
	}
	if($arOrder['DELIVERY_ID'] == 'sdek:pickup'){
		$additional_information.='<b>Доставка</b>: ПВЗ СДЭК<br />';
	}
	$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
	if ($arDeliv){
		$additional_information.='<b>Доставка</b>: '.$arDeliv["NAME"].'<br />';
	}
	$arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
	if ($arPaySystem){
		$additional_information.='<b>Способ оплаты</b>: '.$arPaySystem["DESCRIPTION"].'<br />';
	}
	$additional_information.='<b>Комментарий к заказу</b>: '.$arOrder["USER_DESCRIPTION"].'<br />';
	 
	//AddMessage2Log('$arOrder = '.print_r($arOrder, true),'');
	//AddMessage2Log('$arDeliv = '.print_r($arDeliv, true),'');
		 
    $arFields["ADD_INFORMATION"] = $additional_information;




    \Bitrix\Main\Loader::includeModule('iblock');
    \Bitrix\Main\Loader::includeModule('sale');
    $el = new \CIBlockElement;
    //TODO: ping method
    $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/ping/';
    $login = 'USERHTTP';
    $pass = '123';
    $USERS_IBLOCK_ID = 13;
    $INDICATOR_IBLOCK_ID = 15;
    $GUID_SOURCE = '90802caa-5c8d-4e9a-8147-b8f0a806093c';

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

        $orderId = $orderID;
        $db_sales = CSaleOrder::GetList(array(), Array("ID" => $orderId));
        while ($ar_sales = $db_sales->Fetch()) {
            $arOrder = $ar_sales;
        }

        $filter = Array();
        $rsUsers = CUser::GetList(($by="id"), ($order="desc"), array('ID'=>$arOrder['USER_ID']),array('SELECT'=>array('UF_*')));
        while($arUser = $rsUsers->Fetch()){
            $arCurUser = $arUser;
        }

        if($arCurUser['UF_GUID']){
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

            $arSelect = Array("ID", "NAME", "PROPERTY_GUID");
            $arFilter = Array("IBLOCK_ID"=>17, "PROPERTY_GUID_PARENT"=>$arCurUser['UF_GUID'], "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                $contragentGUID = $ob['PROPERTY_GUID_VALUE'];
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
            $postData = array(
                'TransactionID' => $guid_transaction,
                'SourceID' => $GUID_SOURCE,
                'GUIDPersonalAccount' => $arCurUser['UF_GUID'],
                'GUIDCustomer' => $contragentGUID,
                'Order' => [
                    'DateOrder'=>$explode_date2[2].'-'.$explode_date2[1].'-'.$explode_date2[0].'T'.$explode_date[1].'+03:00',
                    'NumberOrder'=>$arOrder['ID'].'BX',
                    'Comment'=>$arOrder['USER_DESCRIPTION'],
    //                'Comment'=>'TEST ORDER',
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
            }

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $PROP = array("DATE" => date("d.m.Y h:m:s"),"HOST" => 'set_order',"GUID" => $guid_transaction);
            $arLoadProductArray = Array(
                "IBLOCK_ID"      => 14,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => 'get '.date("d.m.Y h:m:s"),
                "ACTIVE"         => "Y",
                "PREVIEW_TEXT"   => $postData,
                "DETAIL_TEXT"    => cut_string($result,65530),
            );
            $ID_journal = $el->Add($arLoadProductArray);
        }
    }

}

AddEventHandler("search", "BeforeIndex", "BeforeIndexHandler");
function BeforeIndexHandler($arFields)
{
    if(!CModule::IncludeModule("iblock")) // подключаем модуль
        return $arFields;
    if($arFields["MODULE_ID"] == "iblock")
    {
        $db_props = CIBlockElement::GetProperty(                        // Запросим свойства индексируемого элемента
            $arFields["PARAM2"],         // BLOCK_ID индексируемого свойства
            $arFields["ITEM_ID"],          // ID индексируемого свойства
            array("sort" => "asc"),       // Сортировка (можно упустить)
            Array("CODE"=>"CML2_ARTICLE")); // CODE свойства (в данном случае артикул)
        if($ar_props = $db_props->Fetch())
            $arFields["TITLE"] = $ar_props["VALUE"]. " ".$arFields["TITLE"];   // Добавим свойство в конец заголовка индексируемого элемента
    }
    return $arFields; // вернём изменения
}