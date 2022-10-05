                                                                                                                                                                                                                                                                                                                                                                                                        <?
 if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


if (!CModule::IncludeModule("sale")) {
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}

if($_REQUEST['VAL'] && $_REQUEST['TYPE']):
    CModule::includeModule('iblock');
    global $USER;
    $rsUsers = CUser::GetList(($by="id"), ($order="desc"), array('ID'=>$USER->GetId()),array('SELECT'=>array('UF_*')));
    while($arUser = $rsUsers->Fetch()){
        $arCurUser = $arUser;
    }
    if($arCurUser['UF_GUID']){
        if($_REQUEST['TYPE'] == 1){
            $arSelect = Array("ID", "NAME", "PROPERTY_COMMENT", "PROPERTY_THECONTACTPERSON", "PROPERTY_DATEOFRECEIVING", "PROPERTY_DELIVERYADDRESS", "PROPERTY_DOCUMENTAMOUNT", "PROPERTY_ORDERSTATUS", "PROPERTY_ORDERDATE", "PROPERTY_ORDERNUMBERWEBSITE", "PROPERTY_ORDERNUMBER", "PROPERTY_GUIDCUSTOMER", "PROPERTY_GUIDDOCUMENT");
            $arFilter = Array("IBLOCK_ID"=>18, "PROPERTY_GUIDCUSTOMER"=>$arCurUser['UF_GUID'], 'PROPERTY_ORDERNUMBER'=>'%'.$_REQUEST['VAL'].'%', "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array('PROPERTY_ORDERDATE'=>'DESC'), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                $orders[] = $ob;
            }
        }
        if($_REQUEST['TYPE'] == 2){
            $arSelect = Array("ID", "NAME", "PROPERTY_COMMENT", "PROPERTY_DATEOFRECEIVING", "PROPERTY_DELIVERYADDRESS", "PROPERTY_DOCUMENTAMOUNT", "PROPERTY_ORDERDATE", "PROPERTY_ORDERNUMBER", "PROPERTY_GUIDORDERS", "PROPERTY_GUIDCUSTOMER", "PROPERTY_GUIDDOCUMENT");
            $arFilter = Array("IBLOCK_ID"=>19, "PROPERTY_GUIDCUSTOMER"=>$arCurUser['UF_GUID'], 'PROPERTY_ORDERNUMBER'=>'%'.$_REQUEST['VAL'].'%', "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array('PROPERTY_ORDERDATE'=>'DESC'), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                $sales[] = $ob;
            }
        }
        if($_REQUEST['TYPE'] == 3){
            $arSelect = Array("ID", "NAME", "PROPERTY_COMMENT",  "PROPERTY_DELIVERYADDRESS", "PROPERTY_DOCUMENTAMOUNT", "PROPERTY_SERIALNUMBER", "PROPERTY_DAYSINREPAIR", "PROPERTY_SHIPPED", "PROPERTY_PRODUCTSKU", "PROPERTY_PRODUCT", "PROPERTY_TYPEOFWORK", "PROPERTY_ORDERSTATUS", "PROPERTY_ORDERDATE", "PROPERTY_ORDERNUMBER", "PROPERTY_GUIDPRODUCT", "PROPERTY_GUIDCUSTOMER", "PROPERTY_GUIDDOCUMENT");
            $arFilter = Array("IBLOCK_ID"=>20, "PROPERTY_GUIDCUSTOMER"=>$arCurUser['UF_GUID'], 'PROPERTY_ORDERNUMBER'=>'%'.$_REQUEST['VAL'].'%', "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array('PROPERTY_ORDERDATE'=>'DESC'), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                $repairs[$ob['ID']] = $ob;
            }
            $arSelect = Array("ID", "NAME", "PROPERTY_COMMENT",  "PROPERTY_DELIVERYADDRESS", "PROPERTY_DOCUMENTAMOUNT", "PROPERTY_SERIALNUMBER", "PROPERTY_DAYSINREPAIR", "PROPERTY_SHIPPED", "PROPERTY_PRODUCTSKU", "PROPERTY_PRODUCT", "PROPERTY_TYPEOFWORK", "PROPERTY_ORDERSTATUS", "PROPERTY_ORDERDATE", "PROPERTY_ORDERNUMBER", "PROPERTY_GUIDPRODUCT", "PROPERTY_GUIDCUSTOMER", "PROPERTY_GUIDDOCUMENT");
            $arFilter = Array("IBLOCK_ID"=>20, "PROPERTY_GUIDCUSTOMER"=>$arCurUser['UF_GUID'], 'PROPERTY_PRODUCTSKU'=>'%'.$_REQUEST['VAL'].'%', "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array('PROPERTY_ORDERDATE'=>'DESC'), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                $repairs[$ob['ID']] = $ob;
            }
            $arSelect = Array("ID", "NAME", "PROPERTY_COMMENT",  "PROPERTY_DELIVERYADDRESS", "PROPERTY_DOCUMENTAMOUNT", "PROPERTY_SERIALNUMBER", "PROPERTY_DAYSINREPAIR", "PROPERTY_SHIPPED", "PROPERTY_PRODUCTSKU", "PROPERTY_PRODUCT", "PROPERTY_TYPEOFWORK", "PROPERTY_ORDERSTATUS", "PROPERTY_ORDERDATE", "PROPERTY_ORDERNUMBER", "PROPERTY_GUIDPRODUCT", "PROPERTY_GUIDCUSTOMER", "PROPERTY_GUIDDOCUMENT");
            $arFilter = Array("IBLOCK_ID"=>20, "PROPERTY_GUIDCUSTOMER"=>$arCurUser['UF_GUID'], 'PROPERTY_SERIALNUMBER'=>'%'.$_REQUEST['VAL'].'%', "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array('PROPERTY_ORDERDATE'=>'DESC'), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                $repairs[$ob['ID']] = $ob;
            }
        }
    }
    $status_colors = ['В работе' => ' green', 'Завершен' => ' brown', 'К обеспечению' => ' green', 'На согласовании' => ' yellow'];
    ob_start();?>
        <?if($_REQUEST['TYPE'] == 1):?>
            <?if($orders):?>
                <?foreach($orders as $item):?>
                    <div class="content-block">
                        <div class="section-row profile-content-row">
                            <div class="section-column col-8_custom">
                                <div class="content-block_order">
                                    <div class="order-head">
                                        <div class="order-number">Заказ №<?=$item['PROPERTY_ORDERNUMBER_VALUE']?></div>
                                        <span>|</span>
                                        <div class="order-date"><?= FormatDate('<\s\p\a\n>j F Y г.</\s\p\a\n> H:i', strtotime($item['PROPERTY_ORDERDATE_VALUE']))?></div>
                                        <?if($item['PROPERTY_ORDERSTATUS_VALUE']):?>
                                            <span>|</span>
                                            <div class="order-date<?=$status_colors[$item['PROPERTY_ORDERSTATUS_VALUE']]?>"><?=$item['PROPERTY_ORDERSTATUS_VALUE']?></div>
                                        <?endif;?>
                                    </div>
                                    <?if($item['PROPERTY_DELIVERYADDRESS_VALUE']):?>
                                        <div class="order-amount"><b>Адрес доставки</b>: <?=$item['PROPERTY_DELIVERYADDRESS_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_THECONTACTPERSON_VALUE']):?>
                                        <div class="order-amount"><b>Контактное лицо</b>: <?=$item['PROPERTY_THECONTACTPERSON_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_COMMENT_VALUE']['TEXT']):?>
                                        <div class="order-amount"><b>Комментарий</b>: <?=$item['PROPERTY_COMMENT_VALUE']['TEXT']?></div>
                                    <?endif;?>
                                </div>
                            </div>
                            <div class="section-column col-3_custom">
                                <?if($item['PROPERTY_DOCUMENTAMOUNT_VALUE']):?>
                                    <?=number_format($item['PROPERTY_DOCUMENTAMOUNT_VALUE'], 0, '', ' '); ?> руб.
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            <?else:?>
                Ничего не найдено. Изменените условия поиска или свяжитесь с менеджером.
            <?endif;?>
        <?endif;?>
        <?if($_REQUEST['TYPE'] == 2):?>
            <?if($sales):?>
                <?foreach($sales as $item):?>
                    <div class="content-block">
                        <div class="section-row profile-content-row">
                            <div class="section-column col-8_custom">
                                <div class="content-block_order">
                                    <div class="order-head">
                                        <div class="order-number">Заказ №<?=$item['PROPERTY_ORDERNUMBER_VALUE']?></div>
                                        <span>|</span>
                                        <div class="order-date"><?= FormatDate('<\s\p\a\n>j F Y г.</\s\p\a\n> H:i', strtotime($item['PROPERTY_ORDERDATE_VALUE']))?></div>
                                    </div>
                                    <?if($item['PROPERTY_DELIVERYADDRESS_VALUE']):?>
                                        <div class="order-amount"><b>Адрес доставки</b>: <?=$item['PROPERTY_DELIVERYADDRESS_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_COMMENT_VALUE']['TEXT']):?>
                                        <div class="order-amount"><b>Комментарий</b>: <?=$item['PROPERTY_COMMENT_VALUE']['TEXT']?></div>
                                    <?endif;?>
                                </div>
                            </div>
                            <div class="section-column col-3_custom">
                                <?if($item['PROPERTY_DOCUMENTAMOUNT_VALUE']):?>
                                    <?=number_format($item['PROPERTY_DOCUMENTAMOUNT_VALUE'], 0, '', ' '); ?> руб.
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            <?else:?>
                Ничего не найдено. Изменените условия поиска или свяжитесь с менеджером.
            <?endif;?>
        <?endif;?>
        <?if($_REQUEST['TYPE'] == 3):?>
            <?if($repairs):?>
                <?foreach($repairs as $item):?>
                    <div class="content-block">
                        <div class="section-row profile-content-row">
                            <div class="section-column col-8_custom">
                                <div class="content-block_order">
                                    <div class="order-head">
                                        <div class="order-number">Заказ №<?=$item['PROPERTY_ORDERNUMBER_VALUE']?></div>
                                        <?if($item['PROPERTY_ORDERDATE_VALUE']):?>
                                            <span>|</span>
                                            <div class="order-date"><?= FormatDate('<\s\p\a\n>j F Y г.</\s\p\a\n> H:i', strtotime($item['PROPERTY_ORDERDATE_VALUE']))?></div>
                                        <?endif;?>
                                        <?if($item['PROPERTY_ORDERSTATUS_VALUE']):?>
                                            <span>|</span>
                                            <div class="order-date<?=$status_colors[$item['PROPERTY_ORDERSTATUS_VALUE']]?>"><?=$item['PROPERTY_ORDERSTATUS_VALUE']?></div>
                                        <?endif;?>
                                    </div>
                                    <?if($item['PROPERTY_TYPEOFWORK_VALUE']):?>
                                        <div class="order-amount"><b>Вид работ</b>: <?=$item['PROPERTY_TYPEOFWORK_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_SERIALNUMBER_VALUE']):?>
                                        <div class="order-amount"><b>Серийный номер</b>: <?=$item['PROPERTY_SERIALNUMBER_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_DAYSINREPAIR_VALUE']):?>
                                        <div class="order-amount"><b>Дней в ремонте</b>: <?=$item['PROPERTY_DAYSINREPAIR_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_PRODUCTSKU_VALUE']):?>
                                        <div class="order-amount"><b>Артикул товара</b>: <?=$item['PROPERTY_PRODUCTSKU_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_PRODUCT_VALUE']):?>
                                        <div class="order-amount"><b>Товар</b>: <?=$item['PROPERTY_PRODUCT_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_DELIVERYADDRESS_VALUE']):?>
                                        <div class="order-amount"><b>Адрес доставки</b>: <?=$item['PROPERTY_DELIVERYADDRESS_VALUE']?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_SHIPPED_VALUE']):?>
                                        <div class="order-amount"><b>Отгружен</b>: <?=$item['PROPERTY_SHIPPED_VALUE'] ? 'да' : 'нет';?></div>
                                    <?endif;?>
                                    <?if($item['PROPERTY_COMMENT_VALUE']['TEXT']):?>
                                        <div class="order-amount"><b>Комментарий</b>: <?=$item['PROPERTY_COMMENT_VALUE']['TEXT']?></div>
                                    <?endif;?>
                                </div>
                            </div>
                            <div class="section-column col-3_custom">
                                <?if($item['PROPERTY_DOCUMENTAMOUNT_VALUE']):?>
                                    <?=number_format($item['PROPERTY_DOCUMENTAMOUNT_VALUE'], 0, '', ' '); ?> руб.
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            <?else:?>
                Ничего не найдено. Изменените условия поиска или свяжитесь с менеджером.
            <?endif;?>
        <?endif;?>

    <?$arJSON = ob_get_contents();
    ob_end_clean();
    echo json_encode($arJSON);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>