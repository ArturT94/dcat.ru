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
    $INDICATOR_IBLOCK_ID = 16;
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
//        $host = 'https://s.dcut.ru/UCS_DIKAT/hs/PersAcc/priceconditions';
        $host = 'https://s2.dcut.ru:3310/UCS/hs/PersAcc/priceconditions';

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
                        'GUIDPersonalAccount' => [$user['UF_GUID']],
                        'Period' => date('Y-m-d').'T'.date('H:m:s'),
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
                    $PROP = array("DATE" => date("d.m.Y h:m:s"),"HOST" => 'get',"GUID" => $guid_transaction);
                    $arLoadProductArray = Array(
                        "IBLOCK_ID"      => 14,
                        "PROPERTY_VALUES"=> $PROP,
                        "NAME"           => 'get '.date("d.m.Y h:m:s"),
                        "ACTIVE"         => "Y",
                        "PREVIEW_TEXT"   => $postData,
                        "DETAIL_TEXT"    => cut_string($result,65530),
                    );
                    $ID_journal = $el->Add($arLoadProductArray);

                    if($arResult->response->PersonalAccountsData){
                        foreach($arResult->response->PersonalAccountsData as $indicator){
                            if($indicator->Discounts){
                                foreach ($indicator->Discounts as $key=>$item){
                                    if($item->DiscountType == 'Номенклатура'){
                                        $arrVal = array(
                                            "VALUE" => $item->DiscountSubject,
                                            "DESCRIPTION" => $item->Value,
                                        );
                                        $arPropVal[$key] = $arrVal;
                                    }elseif($item->DiscountType == 'ЦеноваяГруппа'){
                                        $arrVal2 = array(
                                            "VALUE" => $item->DiscountSubject,
                                            "DESCRIPTION" => $item->Value,
                                        );
                                        $arPropVal2[$key] = $arrVal2;
                                    }
                                }
                            }

                            $arLoadProductArray = Array(
                                "IBLOCK_ID"      => $INDICATOR_IBLOCK_ID,
                                "PROPERTY_VALUES"=> array('GUID'=>$indicator->GUIDPersonalAccount, 'DISCOUNT_PRODUCT' => $arPropVal, 'PRICE_GROUP' => $arPropVal2, 'USER'=>$user['ID']),
                                "NAME"           => $indicator->GUIDPersonalAccount,
                                "ACTIVE"         => "Y",
                            );
                            if($userIndicator[$indicator->GUIDPersonalAccount]){
//                                $el->Update($userIndicator[$indicator->GUIDPersonalAccount],$arLoadProductArray);
                            }else{
                                $ID_journal = $el->Add($arLoadProductArray);
                            }
                            unset($arDiscount);
                            //начали создавать скидки в битриксе
                            //соберем все скидки, которые прилетели из 1С
                            $arSelect = Array("ID", "NAME", "PROPERTY_DISCOUNT_PRODUCT", "PROPERTY_GUID", "PROPERTY_PRICE_GROUP");
                            $arFilter = Array("IBLOCK_ID"=>$INDICATOR_IBLOCK_ID, "PROPERTY_USER"=>$user['ID'], "ACTIVE"=>"Y");
                            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                            while($ob = $res->Fetch()) {
                                $userDiscount = $ob;
                                if($ob['PROPERTY_PRICE_GROUP_VALUE']){
                                    foreach($ob['PROPERTY_PRICE_GROUP_VALUE'] as $key=>$val){
                                        $arDiscount['TYPE'][$val] = ['TYPE'=>$val,'VALUE'=>$ob['PROPERTY_PRICE_GROUP_DESCRIPTION'][$key]];
                                    }
                                }
                                if($ob['PROPERTY_DISCOUNT_PRODUCT_VALUE']){
                                    foreach($ob['PROPERTY_DISCOUNT_PRODUCT_VALUE'] as $key=>$val){
                                        $arDiscount['PRODUCTS'][$val] = ['PRODUCT'=>$val,'VALUE'=>$ob['PROPERTY_DISCOUNT_PRODUCT_DESCRIPTION'][$key]];
                                    }
                                }
                            }
                            if(!$user['UF_PERSONAL_GROUP']){
                                $group = new CGroup;
                                $arFields = Array(
                                    "ACTIVE"       => "Y",
                                    "C_SORT"       => 100,
                                    "NAME"         => "Контрагент ".$user['NAME'],
                                    "USER_ID"      => array($user['ID']),
                                    "STRING_ID"      => "GROUP_".$user['ID']
                                );
                                $groupId = $user['UF_PERSONAL_GROUP'] = $group->Add($arFields);
                                if (strlen($group->LAST_ERROR)>0) ShowError($group->LAST_ERROR);
                                $userObj = new CUser;
                                $userObj->Update($user['ID'], array('UF_PERSONAL_GROUP'=>$groupId));
                            }else{
                                $groupId = $user['UF_PERSONAL_GROUP'];
                            }

                            //TODO: CSaleDiscount::GetList при любых входных параметрах получает только 1 скидку, поэтоу сделали такой костыль небольшой
                            $old_id = 1;
                            for($i=0;$i<1000;$i++){
                                if($old_id){
                                    unset($old_id);
                                    $db_res = CSaleDiscount::GetList(array(),array("ACTIVE" => "Y","USER_GROUPS" => $groupId),false,false,array());
                                    if ($ar_res = $db_res->Fetch()) {
                                        if($ar_res['ID']){
                                            CSaleDiscount::Delete($ar_res['ID']);
                                            $old_id = $ar_res['ID'];
                                        }
                                    }
                                }else{
                                    break;
                                }
                            }

                            if($arDiscount['TYPE']){
                                foreach($arDiscount['TYPE'] as $disc){
                                    prymeryAddDiscount($disc,$user,'TYPE',$groupId);
                                }
                            }
                            if($arDiscount['PRODUCTS']){
                                foreach($arDiscount['PRODUCTS'] as $disc){
                                    prymeryAddDiscount($disc,$user,'PRODUCT',$groupId);
                                }
                            }
                        }
                    }
                }
            }
        }
        //закончили запрос в 1с
    }
}

