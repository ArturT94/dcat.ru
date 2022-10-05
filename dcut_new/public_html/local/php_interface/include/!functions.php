<?
if(!function_exists("pre")) {
    function pre($var, $die = false, $all = false)
    {
        global $USER;
        if ($USER->IsAdmin() || $all == true) {
            ?><?mb_internal_encoding('utf-8');?>

            <font style="text-align: left; font-size: 12px">
                <pre><? print_r($var) ?></pre>
            </font><br>
            <?
        }
        if ($die) {
            die;
        }
    }
}
function endingsForm($n, $form1, $form2, $form5) {
    $n = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) return $form5;
    if ($n1 > 1 && $n1 < 5) return $form2;
    if ($n1 == 1) return $form1;
    return $form5;
}

function cut_string($string, $length)
{
    if ($length && mb_strlen($string, 'UTF-8') > $length)
    {
        $str = strip_tags($string);
        $str = mb_substr($str, 0, $length, 'UTF-8');
        $pos = mb_strrpos($str, ' ', 'UTF-8');
        return mb_substr($str, 0, $pos, 'UTF-8').'…';
    }
    return $string;
}
function CatalogSort($order){
    if($order=='asc'){$result = 'desc';}else{$result = 'asc';}
    return $result;
}
function CatalogSortActive($sort_url,$cur_sort){
    if($sort_url==$cur_sort){$result = ' active';}
    return $result;
}
function guid_generate(){
    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function prymeryAddDiscount($dicount,$user){
    \Bitrix\Main\Loader::includeModule('sale');

    if($dicount){
        $count = 0;
        if($dicount['TYPE']){
            foreach($dicount['TYPE'] as $disc){
                unset($children2);
                $children[] = [
                    "CLASS_ID" => "ActSaleBsktGrp",
                    "DATA" => [
                        "Type" => "Discount",
                        "Value" => $disc['VALUE'],
                        "Unit" => "Perc",
                        "Max" => 0,
                        "All" => "OR",
                        "True" => "True",
                    ]
                ];
                $children2[] = [
                    "CLASS_ID" => "CondIBProp:11:76",
                    "DATA" => [
                        "logic" => "Equal",
                        "value" => $disc['TYPE'],
                    ],
                ];
                $children[$count]['CHILDREN'] = $children2;
                $count++;
            }
        }
        if($dicount['PRODUCTS']){
            foreach($dicount['PRODUCTS'] as $disc){
                unset($children2);
                unset($productId);
                $arSelect = Array("ID");
                $arFilter = Array("IBLOCK_ID"=>11, "PROPERTY_GUID"=>$disc['PRODUCT']);
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                while($ob = $res->Fetch()) {
                    $productId = $ob;
                }

                $children[] = [
                    "CLASS_ID" => "ActSaleBsktGrp",
                    "DATA" => [
                        "Type" => "Discount",
                        "Value" => $disc['VALUE'],
                        "Unit" => "Perc",
                        "Max" => 0,
                        "All" => "OR",
                        "True" => "True",
                    ]
                ];
                $children2[] = [
                    "CLASS_ID" => "ActSaleSubGrp",
                    "DATA" => [
                        "All" => "AND",
                        "True" => "True",
                    ],
                    "CHILDREN" => [
                        [
                            "CLASS_ID" => "CondIBElement",
                            "DATA" => [
                                "logic" => "Equal",
                                "value" => $productId,
                            ]
                        ]
                    ]
                ];
                $children[$count]['CHILDREN'] = $children2;
                $count++;
            }
        }
    }

    $arDiscountFields = [
        "LID" => SITE_ID,
        "SITE_ID" => SITE_ID,
        "NAME"=> "Скидки ".$user['NAME'],
        "DISCOUNT_VALUE" => 0,
        "DISCOUNT_TYPE" => "P",
        "LAST_LEVEL_DISCOUNT" => "Y",
        "LAST_DISCOUNT" => "Y",
        "ACTIVE" => "Y",
        "CURRENCY" => "RUB",
        "USER_GROUPS" => [$user['UF_PERSONAL_GROUP']],
        'ACTIONS' => [
            "CLASS_ID" => "CondGroup",
            "DATA" => [
                "All" => "AND"
            ],
            "CHILDREN" => $children,
        ],
        "CONDITIONS" =>  [
            'CLASS_ID' => 'CondGroup',
            'DATA' => [
                'All' => 'AND',
                'True' => 'True',
            ],
            'CHILDREN' => $children,
        ]
    ];

    $db_res = CSaleDiscount::GetList(array(),array("LID" => SITE_ID,"ACTIVE" => "Y","USER_GROUPS" => array(8)),false,false,array());
    if ($ar_res = $db_res->Fetch()) {
        $arCurDiscount = $ar_res;
    }
    if($arCurDiscount['ID']){
        $iDiscountNumber = $arCurDiscount['ID'];
        \CSaleDiscount::Update($arCurDiscount['ID'],$arDiscountFields);
    }else{
        $iDiscountNumber = \CSaleDiscount::Add($arDiscountFields);
    }
    if(IntVal($iDiscountNumber) > 0){
        \Bitrix\Sale\Internals\DiscountGroupTable::updateByDiscount($iDiscountNumber, [$user['UF_PERSONAL_GROUP']], "Y", true);
    }
    return $iDiscountNumber;
}


