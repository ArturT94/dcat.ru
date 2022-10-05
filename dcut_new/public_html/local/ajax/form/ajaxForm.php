<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::includeModule('iblock');
if ($_POST['param']) {
    $param = json_decode($_POST['param']);
$el = new \CIBlockElement;
$workItems = 287;
$productItems = 286;
$arOrder = [];
$result = array();
    $pushToResult = function ($value, $key = NULL) use (&$result) {
        static $defaultKey;
        if (func_num_args() == 1) {
            if (is_scalar($value)) {
                $defaultKey = $value;
            } else {
                $key = $defaultKey;
            }
        }
        if (!is_null($key)) {
            $key .= 'Items';
            if (!array_key_exists($key, $result)) {
                $result[$key] = array();
            }
            array_push($result[$key], $value);
        }
    };
$arFilter = ['IBLOCK_ID' => 21, 'SECTION_ID' => $productItems, 'ACTIVE' => 'Y', 'PROPERTY_GUIDDOCUMENT' => $param->guid];
$arSelect = ['PROPERTY_ITEMGUID', 'PROPERTY_ARTICLENUMBER', 'PROPERTY_CODE', 'PROPERTY_FULLNAME', 'PROPERTY_QUANTITY', 'PROPERTY_PRICE', 'PROPERTY_SUM', 'PROPERTY_SIZEVAT', 'PROPERTY_SUMVAT', 'PROPERTY_USER'];
    $pushToResult('product');
    $res = $el->GetList($arOrder, $arFilter, false, false, $arSelect);
    
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
            $pushToResult($arFields);
    }
$arFilter = ['IBLOCK_ID' => 23, 'ACTIVE' => 'Y', 'PROPERTY_GUIDDOCUMENT' => $param->guid];
$arSelect = ['PROPERTY_ITEMGUID', 'PROPERTY_ARTICLENUMBER', 'PROPERTY_CODE', 'PROPERTY_FULLNAME', 'PROPERTY_QUANTITY', 'PROPERTY_PRICE', 'PROPERTY_SUM', 'PROPERTY_SIZEVAT', 'PROPERTY_SUMVAT', 'PROPERTY_USER'];
    $res = $el->GetList($arOrder, $arFilter, false, false, $arSelect);
    
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
            $pushToResult($arFields);
    }
    $arFilter = ['IBLOCK_ID' => 24, 'ACTIVE' => 'Y', 'PROPERTY_GUIDDOCUMENT' => $param->guid];
$arSelect = ['PROPERTY_ITEMGUID', 'PROPERTY_ARTICLENUMBER', 'PROPERTY_CODE', 'PROPERTY_FULLNAME', 'PROPERTY_QUANTITY', 'PROPERTY_PRICE', 'PROPERTY_SUM', 'PROPERTY_SIZEVAT', 'PROPERTY_SUMVAT', 'PROPERTY_USER'];
    $res = $el->GetList($arOrder, $arFilter, false, false, $arSelect);
    
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
            $pushToResult($arFields);
    }
    
        $pushToResult('order');

$arFilter = ['IBLOCK_ID' => 18, 'ACTIVE' => 'Y', 'PROPERTY_GUIDDOCUMENT' => $param->guid];
$arSelect = ['PROPERTY_ITEMGUID', 'PROPERTY_ARTICLENUMBER', 'PROPERTY_CODE', 'PROPERTY_FULLNAME', 'PROPERTY_QUANTITY', 'PROPERTY_PRICE', 'PROPERTY_SUM', 'PROPERTY_SIZEVAT', 'PROPERTY_SUMVAT', 'PROPERTY_USER'];
    $res = $el->GetList($arOrder, $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $pushToResult($arFields);
    }
   $pushToResult('sale');
$arFilter = ['IBLOCK_ID' => 19, 'ACTIVE' => 'Y', 'PROPERTY_GUIDDOCUMENT' => $param->guid];
$arSelect = ['PROPERTY_ITEMGUID', 'PROPERTY_ARTICLENUMBER', 'PROPERTY_CODE', 'PROPERTY_FULLNAME', 'PROPERTY_QUANTITY', 'PROPERTY_PRICE', 'PROPERTY_SUM', 'PROPERTY_SIZEVAT', 'PROPERTY_SUMVAT', 'PROPERTY_USER'];
    $res = $el->GetList($arOrder, $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $pushToResult($arFields);
    }
        $pushToResult('work');

    $arFilter = ['IBLOCK_ID' => 21, 'SECTION_ID' => $workItems, 'ACTIVE' => 'Y', 'PROPERTY_GUIDDOCUMENT' => $param->guid];
    $arSelect = ['PROPERTY_ITEMGUID', 'PROPERTY_ARTICLENUMBER', 'PROPERTY_CODE', 'PROPERTY_FULLNAME', 'PROPERTY_QUANTITY', 'PROPERTY_PRICE', 'PROPERTY_SUM', 'PROPERTY_SIZEVAT', 'PROPERTY_SUMVAT', 'PROPERTY_USER'];
    $res = $el->GetList($arOrder, $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $pushToResult($arFields);
    }
    $arFilter = ['IBLOCK_ID' => 13, 'PROPERTY_GUID' => $param->guidCastomer];
    $arSelect = ['PROPERTY_PROP2', 'PROPERTY_PROP11', 'PROPERTY_PROP12', 'PROPERTY_PROP8', 'PROPERTY_MANAGER_PHONE'];
    $res = $el->GetList($arOrder, $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        if(empty($arFields['PROPERTY_MANAGER_PHONE'])){
            $arFields['PROPERTY_MANAGER_PHONE'] = 'нет';
        }
        $infoCustomer = $arFields;
    }

    $arFilter = ['IBLOCK_ID' => 17, 'PROPERTY_GUID' => $param->GUIDCustomerReal];
    $arSelect = ['PROPERTY_GUID_PARENT', 'PROPERTY_GUID', 'PROPERTY_NAME', 'PROPERTY_INN', 'PROPERTY_KPP', 'PROPERTY_MAIN', 'PROPERTY_MANAGER_NAME', 'PROPERTY_MANAGER_EMAIL', 'PROPERTY_MANAGER_PHONE'];
    $res = $el->GetList($arOrder, $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        if(empty($arFields['PROPERTY_MANAGER_PHONE'])) {
            $arFields['PROPERTY_MANAGER_PHONE'] = 'нет';
        }
        $infoContr = $arFields;
    }
    $_POST['param'] = [$param, $result, $infoCustomer, $infoContr];
    echo json_encode($_POST['param']);
}
