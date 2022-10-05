<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
\Bitrix\Main\Loader::includeModule('iblock');
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
        //получение информации о категории
//        $host = 'https://s.dcut.ru/UCS_DIKAT/hs/PersAcc/IndicatorsInfo';
        $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/Indicatorsinfo/';

        unset($postData);
        $guid_transaction = guid_generate();
        $postData = array(
            'TransactionID' => $guid_transaction,
            'SourceID' => $GUID_SOURCE,
        );
        $postData = json_encode($postData);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
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
pre($arResult);
        if($arResult->response->Indicators){
            foreach($arResult->response->Indicators as $indicator){
                $arSelect = Array("ID", "NAME", "PROPERTY_GUID");
                $arFilter = Array("IBLOCK_ID"=>$INDICATOR_IBLOCK_ID, "NAME"=>$indicator->GUID);
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                while($ob = $res->Fetch()) {
                    CIBlockElement::SetPropertyValuesEx($ob['ID'], false, array('GROUP' => $indicator->Category));
                }
            }
        }
    }
}

