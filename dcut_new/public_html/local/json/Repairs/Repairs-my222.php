<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('iblock');
$el = new \CIBlockElement;
set_time_limit(0);
//\__Debug::showErrors();
if ($_REQUEST['START_IMPORT_DCUT'] == 'YES') {
//TODO: ping method
define('TYPE', 'repairorder');
switch (TYPE) {
    case 'repairorder':
        $MAIN_IBLOCK_ID = 20;
        $ORDERS_IBLOCK_ID = 21;
        $PART_OF_THE_REQUEST_TO_THE_1C_API = 'repairssales';
        break;
    case 'order':
        $MAIN_IBLOCK_ID = 18;
        $ORDERS_IBLOCK_ID = 23;
        $PART_OF_THE_REQUEST_TO_THE_1C_API = 'orders';
        break;
    case 'sale':
        $MAIN_IBLOCK_ID = 19;
        $ORDERS_IBLOCK_ID = 24;
        $PART_OF_THE_REQUEST_TO_THE_1C_API = 'sales';
        break;
    default:
        $MAIN_IBLOCK_ID = 19;
        $ORDERS_IBLOCK_ID = 24;
        $PART_OF_THE_REQUEST_TO_THE_1C_API = 'sales';
}
//if($_REQUEST['START_IMPORT_DCUT'] == 'YES') {
$host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/ping/';
$login = 'USERHTTP';
$pass = '123';
$USERS_IBLOCK_ID = 13;
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
if ($result == 'ok') {
    $resGetDocumentGuid = $el->GetList([], ['IBLOCK_ID' => $MAIN_IBLOCK_ID, 'ACTIVE' => 'Y'], false, false, ['PROPERTY_GUIDDOCUMENT']);
    while ($ob = $resGetDocumentGuid->GetNextElement()) {
        $getGUID = $ob->GetFields();
        $getDocumentGUID[] = $getGUID['PROPERTY_GUIDDOCUMENT_VALUE'];
    }
    $allItems = array();
    $arSelect = array("ID", "NAME", "PROPERTY_GUIDDOCUMENT", "PROPERTY_ITEMGUID");
    $arFilter = array("IBLOCK_ID" => $ORDERS_IBLOCK_ID, "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
    while ($ob = $res->Fetch()) {
        if (!array_key_exists($documentId = $ob['PROPERTY_GUIDDOCUMENT_VALUE'], $allItems)) {
            $allItems[$documentId] = array();
        }
        /*if (!array_key_exists($documentId = $ob['PROPERTY_GUIDDOCUMENT_VALUE'], $allOtherItems)) {
            $allOtherItems[$documentId] = array();
        }
        */
        if (array_key_exists($ob['PROPERTY_ITEMGUID_VALUE'], $allItems[$documentId])) {
            CIBlockElement::Delete($allItems[$documentId][$ob['PROPERTY_ITEMGUID_VALUE']]);
        }
        $allItems[$documentId][$ob['PROPERTY_ITEMGUID_VALUE']] = $ob['ID'];
    }
    $count = count($getDocumentGUID);
    foreach ($getDocumentGUID as $index => $getDocumentValue) {
        \__Debug::log("Document " . ($index + 1) . " of $count");
        $getDocumentValues = $getDocumentValue;
        if (!array_key_exists($getDocumentValue, $allItems)) {
            $allItems[$getDocumentValue] = array();
        }
        $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/' . $PART_OF_THE_REQUEST_TO_THE_1C_API . '/details/'.$getDocumentValues;
        unset($postData);
        $guid_transaction = guid_generate();
        $postData = array(
            'TransactionID' => $guid_transaction,
            'SourceID' => $GUID_SOURCE,
        );
        $postData = json_encode($postData);

        $ch = curl_init();
        curl_setopt_array($ch, [CURLOPT_URL => $host, CURLOPT_RETURNTRANSFER => 1, 
        CURLOPT_CUSTOMREQUEST => 'GET', CURLOPT_HTTPHEADER => $headers, CURLOPT_POSTFIELDS => $postData]);

        $result = curl_exec($ch);
        $arResult = json_decode($result);
        echo '<pre>' . print_r($arResult, true) . '</pre>';
       
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $PROP = array("DATE" => date("d.m.Y h:m:s"), "HOST" => 'ping', "GUID" => $guid_transaction);
        $arLoadProductArray = array(
            "IBLOCK_ID" => 14,
            "PROPERTY_VALUES" => $PROP,
            "NAME" => 'get ' . date("d.m.Y h:m:s"),
            "ACTIVE" => "Y",
            "PREVIEW_TEXT" => $postData,
            "DETAIL_TEXT" => cut_string($result, 65530),
        );
        $ID_journal = $el->Add($arLoadProductArray);
        \__Debug::log(['Items from 1c' => (array)$arResult->response]);
        \__Debug::log("Work items count: " . count($arResult->response->WorkItems) . ', product items count: ' . count($arResult->response->ProductItems));
        \__Debug::log('Processing work items');
        if ($arResult->response->WorkItems) {
            foreach ($arResult->response->WorkItems as $item) {
                unset($ID_journal2);
                $arLoadProductArray = array(
                    "IBLOCK_ID" => $ORDERS_IBLOCK_ID,
                    "IBLOCK_SECTION_ID" => 287,
                    "NAME" => $getDocumentValues,
                    "ACTIVE" => "Y",
                );
                if (array_key_exists($item->ItemGUID, $allItems[$getDocumentValue])) {
                    $el->Update($ID_journal2 = $allItems[$getDocumentValue][$item->ItemGUID], $arLoadProductArray);
                    \__Debug::log(array_replace(['operation' => 'update', 'ItemGUID' => $item->ItemGUID, 'id' => $ID_journal2], compact(['arLoadProductArray'])));
                } else {
                    $ID_journal2 = $allItems[$getDocumentValue][$item->ItemGUID] = $el->Add($arLoadProductArray);
                    \__Debug::log(array_replace(['operation' => 'insetion', 'ItemGUID' => $item->ItemGUID, 'id' => $ID_journal2], compact(['arLoadProductArray'])));
                }

                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('GUIDDOCUMENT' => $getDocumentValues));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('ITEMGUID' => $item->ItemGUID));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('ARTICLENUMBER' => $item->Article_Number));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('CODE' => $item->Code));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('FULLNAME' => $item->Full_Name));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('QUANTITY' => $item->Quantity));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('PRICE' => $item->Price));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('SUM' => $item->Sum));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('SIZEVAT' => $item->SizeVAT));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('SUMVAT' => $item->SumVAT));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('USER' => $user['ID']));
            }
        }
        \__Debug::log('Processing product items');
        if ($arResult->response->ProductItems) {

            foreach ($arResult->response->ProductItems as $item) {
                unset($ID_journal2);
                $arLoadProductArray = array(
                    "IBLOCK_ID" => $ORDERS_IBLOCK_ID,
                    "IBLOCK_SECTION_ID" => 286,
                    "NAME" => $getDocumentValues,
                    "ACTIVE" => "Y",
                );

                if (array_key_exists($item->ItemGUID, $allItems[$getDocumentValue])) {
                    $el->Update($ID_journal2 = $allItems[$getDocumentValue][$item->ItemGUID], $arLoadProductArray);
                    \__Debug::log(array_replace(['operation' => 'update', 'ItemGUID' => $item->ItemGUID, 'id' => $ID_journal2], compact(['arLoadProductArray'])));

                } else {
                    $ID_journal2 = $allItems[$getDocumentValue][$item->ItemGUID] = $el->Add($arLoadProductArray);
                    \__Debug::log(array_replace(['operation' => 'insert', 'ItemGUID' => $item->ItemGUID, 'id' => $ID_journal2], compact(['arLoadProductArray'])));

                }

                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('GUIDDOCUMENT' => $getDocumentValues));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('ITEMGUID' => $item->ItemGUID));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('ARTICLENUMBER' => $item->Article_Number));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('CODE' => $item->Code));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('FULLNAME' => $item->Full_Name));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('QUANTITY' => $item->Quantity));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('PRICE' => $item->Price));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('SUM' => $item->Sum));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('SIZEVAT' => $item->SizeVAT));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('SUMVAT' => $item->SumVAT));
                CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('USER' => $user['ID']));

            }
        }

        }
    }
}

