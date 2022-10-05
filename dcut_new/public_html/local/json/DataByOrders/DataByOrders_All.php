<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
\Bitrix\Main\Loader::includeModule('iblock');
$el = new \CIBlockElement;

if($_REQUEST['START_IMPORT_DCUT'] == 'YES') {
    //TODO: ping method
    $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/ping/';
    $login = 'USERHTTP';
    $pass = '123';
    $USERS_IBLOCK_ID = 13;
    $ORDERS_IBLOCK_ID = 18;
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
    if($result == 'ok'){
        $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/orders/';

        $filter = Array();
        $rsUsers = CUser::GetList(($by="id"), ($order="desc"), array('!UF_GUID'=>false),array('SELECT'=>array('UF_*')));
        while($arUser = $rsUsers->Fetch()){
            $arUsers[] = $arUser;
            $arGuids[] = $arUser['UF_GUID'];
        }

        if($arGuids){
            $arSelect = Array("ID", "NAME", "PROPERTY_INDICATOR", "PROPERTY_GUID");
            $arFilter = Array("IBLOCK_ID"=>$USERS_IBLOCK_ID, "PROPERTY_GUID"=>$arGuids, "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                $arLk[$ob['PROPERTY_GUID_VALUE']] = $ob['ID'];
            }
        }

        if($arUsers && $arLk){
            foreach($arUsers as $user){
                if($arLk[$user['UF_GUID']]){
                    $arSelect = Array("ID", "NAME", "PROPERTY_GUIDDOCUMENT");
                    $arFilter = Array("IBLOCK_ID"=>$ORDERS_IBLOCK_ID, "PROPERTY_USER"=>$user['ID'], "ACTIVE"=>"Y");
                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                    while($ob = $res->Fetch()) {
                        $allItems[$ob['PROPERTY_GUIDDOCUMENT_VALUE']] = $ob['ID'];
                    }

                    unset($postData);
                    $guid_transaction = guid_generate();
                    $postData = array(
                        'TransactionID' => $guid_transaction,
                        'SourceID' => $GUID_SOURCE,
                        'GUIDPersonalAccount' => $user['UF_GUID'],
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

                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);
                    $PROP = array("DATE" => date("d.m.Y h:m:s"),"HOST" => 'ping',"GUID" => $guid_transaction);
                    $arLoadProductArray = Array(
                        "IBLOCK_ID"      => 14,
                        "PROPERTY_VALUES"=> $PROP,
                        "NAME"           => 'get '.date("d.m.Y h:m:s"),
                        "ACTIVE"         => "Y",
                        "PREVIEW_TEXT"   => $postData,
                        "DETAIL_TEXT"    => cut_string($result,65530),
                    );
                    $ID_journal = $el->Add($arLoadProductArray);
                    if($arResult->response->Documents){
                        foreach($arResult->response->Documents->Orders as $item){
                            unset($ID_journal2);
                            $arLoadProductArray = Array(
                                "IBLOCK_ID"      => $ORDERS_IBLOCK_ID,
                                "NAME"           => $item->GUIDDocument,
                                "ACTIVE"         => "Y",
                            );
                            if($allItems[$item->GUIDDocument]){
                                $el->Update($allItems[$item->GUIDDocument],$arLoadProductArray);
                            }else{
                                $ID_journal2 = $el->Add($arLoadProductArray);
                                $allItems[$item->GUIDDocument] = $ID_journal2;
                            }

                            if(!$ID_journal2){
                                $ID_journal2 = $allItems[$item->GUIDDocument];
                            }

                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('GUIDDOCUMENT' => $item->GUIDDocument));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('GUID_CUSTOMER_REAL' => $item->GUIDCustomer));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('GUIDCUSTOMER' => $user['UF_GUID']));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('ORDERNUMBER' => $item->OrderNumber));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('ORDERNUMBERWEBSITE' => $item->OrderNumberWebSite));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('ORDERDATE' => $item->OrderDate));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('ORDERSTATUS' => $item->OrderStatus));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('DOCUMENTAMOUNT' => $item->DocumentAmount));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('DELIVERYADDRESS' => $item->DeliveryAddress));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('DATEOFRECEIVING' => $item->DateOfReceiving));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('THECONTACTPERSON' => $item->TheContactPerson));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('COMMENT' => $item->Comment));

                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('USER' => $user['ID']));
                        }
                    }
                }
            }
        }
    }
  require_once(dirname(__DIR__).'/Repairs/RepairsOrder.php');
}

