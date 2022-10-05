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
//        $host = 'https://s.dcut.ru/UCS_DIKAT/hs/PersAcc/indicators/';
        $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/indicators/';

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
                $arLk[$ob['PROPERTY_GUID_VALUE']] = $ob['PROPERTY_INDICATOR_DESCRIPTION'];
            }
        }

        if($arUsers && $arLk){
            foreach($arUsers as $user){
                if($arLk[$user['UF_GUID']]){
                    $arSelect = Array("ID", "NAME", "PROPERTY_INDICATOR", "PROPERTY_GUID");
                    $arFilter = Array("IBLOCK_ID"=>$INDICATOR_IBLOCK_ID, "PROPERTY_USER"=>$user['ID'], "ACTIVE"=>"Y");
                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                    while($ob = $res->Fetch()) {
                        $userIndicator[$ob['PROPERTY_GUID_VALUE']] = $ob['ID'];
                    }


                    unset($postData);
                    $guid_transaction = guid_generate();
                    $postData = array(
                        'TransactionID' => $guid_transaction,
                        'SourceID' => $GUID_SOURCE,
                        'ИдентификаторЛичногоКабинета' => $user['UF_GUID'],
                        'Indicators' => $arLk[$user['UF_GUID']],
                    );
                    $postData = json_encode($postData);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $host.$user['UF_GUID']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);


                    $result = curl_exec($ch);
                    $arResult = json_decode($result);
//                    if($user['UF_GUID'] == '08429182-66b4-4cd3-b551-617b7a11b8d4'){
//                        pre($arResult);
//                    }
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

                    if($arResult->response->IndicatorsValues){
                        foreach($arResult->response->IndicatorsValues as $indicator){
                            unset($ID_journal2);
                            $arLoadProductArray = Array(
                                "IBLOCK_ID"      => $INDICATOR_IBLOCK_ID,
//                                "PROPERTY_VALUES"=> array('GUID'=>$indicator->GUIDIndicator,'VALUE'=>$indicator->Value,'GUID_USER'=>$user['UF_GUID'],'USER'=>$user['ID']),
                                "NAME"           => $indicator->GUIDIndicator,
                                "ACTIVE"         => "Y",
                            );
                            if($userIndicator[$indicator->GUIDIndicator]){
                                $el->Update($userIndicator[$indicator->GUIDIndicator],$arLoadProductArray);
                            }else{
                                $ID_journal2 = $el->Add($arLoadProductArray);
                                $userIndicator[$indicator->GUIDIndicator] = $ID_journal2;
                            }

                            if(!$ID_journal2){
                                $ID_journal2 = $userIndicator[$indicator->GUIDIndicator];
                            }

                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('GUID' => $indicator->GUIDIndicator));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('VALUE' => $indicator->Value));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('GUID_USER' => $user['UF_GUID']));
                            CIBlockElement::SetPropertyValuesEx($ID_journal2, false, array('USER' => $user['ID']));
                        }
                    }
                }
            }
        }
    }
}

