<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_CRONTAB", true);
define('BX_WITH_ON_AFTER_EPILOG', true);
define('BX_NO_ACCELERATOR_RESET', true);
define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

class SoapServiceMetaloprofil
{
    private $ouser = null;
    private $subevent = '';
    /**
     * Adds tree numbers.
     * @soap
     * @param int $p1
     * @param int $p2
     * @param int $p3
     * @return string
     */
    public function summTwoNumber($p1, $p2 = '', $p3='')
    {
        return $p1.'+'.$p2.'+'.$p3.'='.($p1 + $p2 + $p3);
    }

    /**
     * Run SOAP service's method remotely.
     * @soap
     * @param base64Binary $parameters
     * @return base64Binary
     */
    public function runSoapMethodRemote($parameters)
    {
        $xml = simplexml_load_string($parameters);
        $result = json_decode(json_encode($xml),1);
        elDiabloLog(dirname(__FILE__).'/logs/soap_zinich.log', "[".date("Y-m-d H:i:s",time())."] "."<pre>".var_export($parameters,1)."</pre>\r\n", FILE_APPEND);
        $functionName = $result['Function']['@attributes']['Name'];
        $fileLog = dirname(__FILE__).'/logs/soap_'.strtolower($functionName).'.log';
        elDiabloLog($fileLog, "[".date("Y-m-d H:i:s",time())."] "."<pre>".var_export($xml,1)."</pre>\r\n", FILE_APPEND);
        $arParams = $this->IncomeFromParameters($result);
        $fileLog1 = dirname(__FILE__).'/logs/soap_asarrayparams_'.strtolower($functionName).'.log';
        elDiabloLog($fileLog1, "[".date("Y-m-d H:i:s",time())."] "."<pre>".var_export($arParams,1)."</pre>\r\n", FILE_APPEND);

        switch($functionName)
        {
			case 'JustReturnParams':
				return print_r(['arParams' => $arParams, 'xml' => $xml],1);
				break;
            case 'GetBuyerOrderStatus':
                    $branch = $arParams['parameters']['PackageXDTO']['ParametersForRedirection']['Branch'];
                    $number =  $arParams['parameters']['PackageXDTO']['ParametersForRedirection']['Number'];
                    if(ZQFlag::set($branch.'_'.$number)==false)
                        return "Оповещение не принято";//print_r(['mesage' => "Данный заказ УЖЕ обрабатывается! Отправьте уведомление позже."],1);

                    $res = $this->GetBuyerOrderStatus($branch, $number);
                    $user_id = 0;
                    if($res['order_id'] > 0)
                    {
                        $user_id = $this->getOrderUserId();
                        elDiabloLog(dirname(__FILE__).'/logs/orders_id.log',"[".date("Y-m-d H:i:s",time())."] {$user_id} - {$number} - {$res}\r\n",FILE_APPEND);
                        if($user_id > 0)
                            $this->eventedUser($functionName, $user_id, ['event_text'=>'Из 1С пришел новый статус по заказу <a href="/order/element/'.$res['order_id'].'/">'.$number.'</a>. <br/>Новый статус: '.$res['order_status_ru'].'.', 'MODE' => 'order', 'ORDER_ID' => $res, 'ORDER_KEY' => $number, 'BRANCH' => $branch]);
                    }
                ZQFlag::delete($branch.'_'.$number);
                return print_r(['number' => $number, 'branch' => $branch, 'order_id' => $res['order_id'], 'user_id' => $user_id],1);
                break;
            case 'GetBuyerOrder':
                $key = $result['Function']['Arguments']['Argument']['2']['Value']['Object']['Arguments']['Argument']['1']['@attributes']['Value'];
                $key1 = $result['Function']['Arguments']['Argument']['2']['Value']['Object']['Arguments']['Argument']['0']['@attributes']['Value'];
                if(ZQFlag::set($key.'_'.$key1)==false)
                    return "Оповещение не принято";//print_r(['mesage' => "Данный заказ УЖЕ обрабатывается! Отправьте уведомление позже."],1);
                $res = $this->updateOrder($key, $key1);
				if($res > 0)
				{
					$user_id = $this->getOrderUserId();
                    elDiabloLog(dirname(__FILE__).'/logs/orders_id.log',"[".date("Y-m-d H:i:s",time())."] {$user_id} - {$key} - {$res}\r\n",FILE_APPEND);
					$this->eventedUser($functionName, $user_id, ['event_text'=>'Данные по заказу <a href="/order/element/'.$res.'/">'.$key.'</a> обновлены.', 'MODE' => 'order', 'ORDER_ID' => $res, 'ORDER_KEY' => $key, 'BRANCH' => $key1]);
                }
                if(!empty($this->subevent))
                {
                    savePermanentMesage($res, $this->subevent, $user_id);
                    $this->eventedUser($functionName.'_const', $user_id, ['event_text'=>$this->subevent, 'MODE' => 'order', 'ORDER_ID' => $res, 'ORDER_KEY' => $key, 'BRANCH' => $key1]);
                }
                ZQFlag::delete($key.'_'.$key1);
				return print_r(['number' => $key, 'branch' => $key1, 'shipment_result' => $res, 'user_id' => $user_id],1);
                break;
            case 'GetOrderForShipment':
                $key = $result['Function']['Arguments']['Argument']['2']['Value']['Object']['Arguments']['Argument']['1']['@attributes']['Value'];
                $key1 = $result['Function']['Arguments']['Argument']['2']['Value']['Object']['Arguments']['Argument']['0']['@attributes']['Value'];
                if(ZQFlag::set($key.'_'.$key1)==false)
                    return "Оповещение не принято";//print_r(['mesage' => "Данная отгрузка УЖЕ обрабатывается! Отправьте уведомление позже."],1);
                $res = $this->updateShipment($key, $key1);
                if($res > 0 && $res['shipment_id'] > 0)
				{
					$user_id = $this->getOrderUserId();
                    recalcShipment($res['shipment_id']);
                    elDiabloLog(dirname(__FILE__).'/logs/shipment_id.log',"[".date("Y-m-d H:i:s",time())."] {$user_id} - {$key} - {$res['shipment_id']}\r\n",FILE_APPEND);
					$this->eventedUser($functionName, $user_id, ['event_text'=>'Данные по отгрузке <a href="/shipment/show/'.$res['shipment_id'].'/">'.$key.'</a> обновлены.', 'MODE' => 'shipment', 'SHIPMENT_ID' => $res, 'ORDER_KEY' => $key, 'BRANCH' => $key1]);
                }
                ZQFlag::delete($key.'_'.$key1);
				return print_r(['number' => $key, 'branch' => $key1, 'shipment_id' => $res['shipment_id'], 'shipment_result' => implode(' ',$res['shipment_itams']), 'user_id' => $user_id],1);
                break;
            case 'GetDirectoryPartner':
				$this->getPartner($arParams['parameters']['PackageXDTO']['ParametersForRedirection']['Branch']);
				return print_r(['branch' => $arParams],1);
                break;
            case 'GetDirectoryContract':
				$re = $this->getContract($arParams['parameters']['PackageXDTO']['ParametersForRedirection']['Branch']);
				return print_r(['branch' => $arParams, 'result' => $re],1);	
                break;
            case 'GetOrderForShipmentStatus':
                $key = $result['Function']['Arguments']['Argument']['2']['Value']['Object']['Arguments']['Argument']['1']['@attributes']['Value'];
                $key1 = $result['Function']['Arguments']['Argument']['2']['Value']['Object']['Arguments']['Argument']['0']['@attributes']['Value'];
                if(ZQFlag::set($key.'_'.$key1)==false)
                    return "Оповещение не принято";//print_r(['mesage' => "Данная отгрузка УЖЕ обрабатывается! Отправьте уведомление позже."],1);
                $res = $this->updateShipmentStatus($key, $key1);
				if(is_int($res['shipment_id'])){
					$user_id = $this->getOrderUserId();
                    elDiabloLog(dirname(__FILE__).'/logs/shipment_status_update.log',"[".date("Y-m-d H:i:s",time())."] {$user_id} - {$key} - {$res['shipment_id']}\r\n",FILE_APPEND);
					$this->eventedUser($functionName, $user_id, ['event_text'=>'У отгрузки <a href="/shipment/show/'.$res['shipment_id'].'/">'.$key.'</a> изменился статус на '.$res['new_status'].'.', 'MODE' => 'shipment', 'SHIPMENT_ID' => $res['shipment_id'], 'ORDER_KEY' => $key, 'BRANCH' => $key1]);
				}
                ZQFlag::delete($key.'_'.$key1);
				return print_r(['number' => $key, 'branch' => $key1, 'shipment_result' => implode(' ',$res), 'user_id' => $user_id],1);
                break;
            case 'GetStatusBuyerClaim':
                $key = $arParams['parameters']['PackageXDTO']['ParametersForRedirection']['Number'];
                $key1 = $arParams['parameters']['PackageXDTO']['ParametersForRedirection']['Branch'];
                $res = $this->updateClimStatus($key1, $key);
                if($res!==false) {
                    $user_id = $this->getOrderUserId();
                    $this->eventedUser($functionName, $user_id, ['event_text' => 'Пришел новый статус по претензии <a href="/clime/'.$res['clime_id'].'.php">'.$key.'</a>.<br/>Новый статус: <b>'.$res['clime_status'].'</b>.', 'MODE' => 'clime', 'CLIME_ID' => $res['clime_id'], 'CLIME_KEY' => $key, 'BRANCH' => $key1]);
                }
                return print_r(['number' => $key, 'branch' => $key1, 'result' => implode(' ',$res), 'user_id' => $user_id],1);
                break;
            case 'GetPrintedDocument':
                $key = $arParams['parameters']['PackageXDTO']['ParametersPrintedDocument']['Branch'];
                $key1 = $arParams['parameters']['PackageXDTO']['ParametersPrintedDocument']['NumberInTheAccountingSystem'];
                $arIds = getRTUFromOrder($key, $key1);
                $user_id = $arIds['user_ids'];
                elDiabloLog(dirname(__FILE__).'/logs/gpd.log',"[".date("Y-m-d H:i:s",time())."] {$user_id} - {$key} - ".implode(' ',$arIds['ids'])."\r\n",FILE_APPEND);
                return print_r(['number' => $key, 'branch' => $key1, 'result' => implode(' ',$arIds['ids']), 'user_id' => $user_id],1);
                break;
            default:
                elDiabloLog(dirname(__FILE__).'/logs/unknown.method.log',"[".date("Y-m-d H:i:s",time())."] {$_SERVER['REMOTE_ADDR']} \r\n".var_export($result,1)."\r\n",FILE_APPEND);
                break;
        }
        elDiabloLog(dirname(__FILE__).'/logs/soap.call_xml.log',"[".date("Y-m-d H:i:s",time())."] {$_SERVER['REMOTE_ADDR']} \r\n".var_export($xml,1)."\r\n",FILE_APPEND);
        elDiabloLog(dirname(__FILE__).'/logs/soap.call_array.log',"[".date("Y-m-d H:i:s",time())."] {$_SERVER['REMOTE_ADDR']} \r\n".var_export($result,1)."\r\n",FILE_APPEND);
        return print_r($result,1);
    }

    private function GetBuyerOrderStatus($branch, $number)
    {

        $soap =  new SoapProxy(soap_url, ['connection_timeout' => 60000,'trace' => true, 'exceptions' => true, 'login' => soap_login, 'password' =>  soap_pass]);
        $result = $soap->GetBuyerOrderStatus(array (
            'Deny' => 'false',
            'Message' => '',
            'PackageXDTO' =>
                array (
                    'Branch' => $branch,
                    'Number' => $number,
                ),
        ));
        $newStatusCode = $result['return'];
        if($newStatusCode=='Отменен') $newStatusCode = 'ОтмененМенеджером';
        $sql = "SELECT `STATUS_ID`,`NAME` FROM `b_sale_status_lang` WHERE `DESCRIPTION`='{$newStatusCode}' AND `LID`='ru'";
        global $DB;
        $arSt = $DB->Query($sql)->Fetch();
        $sql1 = "SELECT `ORDER_ID` from `b_sale_order_props_value` WHERE `VALUE`='{$number}' AND `CODE`='NOMBER_FROM_1C'";
        $arOrder = $DB->Query($sql1)->Fetch();
        if(isset($arOrder['ORDER_ID'])) {
            changeStatus($arSt['STATUS_ID'], $arOrder['ORDER_ID']);
            $arOrderData = $DB->Query("SELECT * FROM `b_sale_order` WHERE `ID`='{$arOrder['ORDER_ID']}'")->Fetch();
            $this->ouser = $arOrderData['USER_ID'];
            return ['order_id' => $arOrder['ORDER_ID'], 'order_status_code' => $newStatusCode, 'order_status_ru' => $arSt['NAME'], 'order_status' => $arSt['STATUS_ID']];
        }
        else
        {
            $this->ouser = 0;
            return ['order_id' => '', 'order_status_code' => '', 'order_status_ru' => '', 'order_status' => ''];
        }
    }

    private function updateClimStatus($branch, $number)
    {
        $arClime = ClimeEntityTable::getList(
            array(
                'order' => array('ID' =>'ASC'),
                'filter'=>array(
                    '=UF_NITAS'=> $number,
                ),
            )
        )->fetch();

        if(empty($arClime))
            return false;

        $soap =  new SoapProxy(soap_url, ['connection_timeout' => 60000,'trace' => true, 'exceptions' => true, 'login' => soap_login, 'password' =>  soap_pass]);
        $result = $soap->GetStatusBuyerClaim(array (
            'Deny' => 'false',
            'Message' => '',
            'PackageXDTO' =>
                array (
                    'Branch' => $branch,
                    'Number' => $number,
                ),
        ));
        ClimeEntityTable::update($arClime['ID'], ['STATUS' => $result['return']['Status']]);
        $this->ouser = $arClime['UF_USER_ID'];
        $res['clime_id'] = $arClime['ID'];
        $res['clime_status'] = $result['return']['Status'];

        if($result['return']['Status']=='Закрыта')
        {
            // закрыть
            CModule::IncludeModule("support");
            CTicket::SetTicket(['CLOSE' => 'Y'], $arClime['UF_NIPO'], "Y", "N", "N");
        }

        return $res;
    }

	private function getContract($branch)
	{
		$date = new DateTime();
		$date->modify("-1 year");
		$parameters = [
			'Deny' => false,
			'Message'=>'',
			'OnlyChanges' => true,
			'PackageXDTO'=>[
				'Date'=> '0001-01-01',
				'Status'=>'',
				'Number'=>'',
				'Branch' => $branch
			]
		];
		
		$soap =  new SoapProxy(soap_url, ['connection_timeout' => 60000,'trace' => true, 'exceptions' => true, 'login' => soap_login, 'password' =>  soap_pass]);
		$aRrET = [];
		try {
			$className = 'ContractEntityTable';
			if (!$className::getEntity()->getConnection()->isTableExists($className::getTableName()))
			{
				$className::createHLblock('Contracts', ['ru' => 'Договора', 'en' => 'Contracts']);
			}
			$result = $soap->GetDirectoryContract($parameters);
			$result = $result['return'];
			if(isset($result['Contract']['Name']))
            {
                $tmp = $result['Contract'];
                $result['Contract'] = [];
                $result['Contract'] = [$tmp];
            }
			foreach($result['Contract'] as $elementObject)
			{
				$arNewArray = json_decode(json_encode($elementObject),1);

				$currentListObject = ContractEntityTable::getList(array(
					'select' =>array('ID'),
					'order' => array('ID' =>'ASC'),
					'filter'=>array(
						'=UF_NITAS' => $arNewArray['NumberInTheAccountingSystem']
					),
				));
				$currentItem = $currentListObject->Fetch();

				if(!empty($currentItem))
				{
					$ID = $currentItem['ID'];
					$result = ContractEntityTable::update($ID, $arNewArray);
				}
				else
				{
					$result = ContractEntityTable::add($arNewArray);
					$ID = $result->getId();
				}
				$aRrET[$ID] = $ID;
			}
		}catch(Exception $e) {
			$aRrET['error'] = $e->getMessage();
		}
		return $aRrET;
	}
	
	private function getPartner($branch)
	{
		$date = new DateTime();
		$date->modify("-1 year");
		$parameters = [
			'Deny' => false,
			'Message'=>'',
			'OnlyChanges' => true,
			'PackageXDTO'=>[
				'Date'=> $date->format('c'),
				'Status'=>'',
				'Number'=>'',
				'Branch' => $branch
			]
		];
		$soap =  new SoapProxy(soap_url, ['connection_timeout' => 60000, 'trace' => true, 'exceptions' => true, 'login' => soap_login, 'password' =>  soap_pass]);
        try {
			$result = $soap->GetDirectoryPartner($parameters);
			if(!isset($result['return']['Partner'][0]))
			{
				$tmp = $result['return']['Partner'];
				$result['return']['Partner'] = [$tmp];
			}
			foreach($result['return']['Partner'] as $item)
			{
				$ar = $item;
				$addit = $ar['ContactInformation'];
				unset($ar['ContactInformation']);
				$currentListObject = ContragencyEntityTable::getList(array(
					'select' =>array('ID'),
					'order' => array('ID' =>'ASC'),
					'filter'=>array(
						'=UF_NITAS' => $ar['NumberInTheAccountingSystem']
					),
				));
				$currentItem = $currentListObject->Fetch();

				if(!empty($currentItem))
				{
					$ID = $currentItem['ID'];
					$result = ContragencyEntityTable::update($ID, $ar);
				}
				else
				{
					$result = ContragencyEntityTable::add($ar);
					$ID = $result->getId();
				}

				foreach($addit as $infoad)
				{
					ContragencyAdditEntityTable::addorupdate([
						'UF_ENTITY_ID' => $ID,
						'UF_KIND' => $infoad['Kind'],
						'UF_VALUE' => $infoad['Value'],
						'UF_TYPE' => $infoad['Type'],
					]);
				}

			}
		}catch(Exception $e) {
            $resultMess['shipment_id'] = $e->getMessage();
        }
		return true;
		
	}
	
    private function IncomeFromParameters($arIn)
    {
        $arOut = [];
        if(isset($arIn['Function']['@attributes']['Name']))
            $arOut['method'] = $arIn['Function']['@attributes']['Name'];

        $arOut['parameters'] = [];
        foreach($arIn['Function']['Arguments']['Argument'] as $arArg)
        {
            if(isset($arArg['@attributes']['Value']))
                $arOut['parameters'][$arArg['@attributes']['Name']] = $arArg['@attributes']['Value'];
            elseif(isset($arArg['Value']))
            {
                $arOut['parameters'][$arArg['@attributes']['Name']] = [];
                $arOut['parameters'][$arArg['@attributes']['Name']][$arArg['Value']['Object']['@attributes']['Name']] = $this->parceArg1($arArg['Value']['Object']['Arguments']);
            }
        }

        file_put_contents(dirname(__FILE__).'/logs/soap.paramerters_array.log',"[".date("Y-m-d H:i:s",time())."] {$_SERVER['REMOTE_ADDR']} \r\n".var_export($arOut,1)."\r\n",FILE_APPEND);
        return $arOut;
    }

    private function parceArg1($arD)
    {
        if(isset($arD['Argument'][0]))
        {
            $arRet = [];
            foreach($arD['Argument'] as $key => $value)
                $arRet[$value['@attributes']['Name']] = $value['@attributes']['Value'];
            return $arRet;
        }
        else
        {
            return [$arD['Argument']['@attributes']['Name'] => $arD['Argument']['@attributes']['Value']];
        }
    }

    private function eventedUser($function, $user_id, $arParams)
    {
        $arParams['TIME'] = time();
        CModule::IncludeModule("pull");
        CPullWatch::AddToStack('PULL_TEST_'.$user_id,
            Array(
                'module_id' => 'event_emitter',
                'command' => $function,
                'params' => $arParams
            )
        );
        CMain::FinalActions();
    }

    private function updateShipmentStatus($key, $key1 = null)
    {
        $this->ouser = 0;
        $resultMess = [];
        $arparams = [
            'Deny' => false,
            'Message' => '',
            'OnlyChanges' => false,
            'PackageXDTO' => [
                'Date' => '0001-01-01',
                'Status' => '',
                'Number' => $key,
                'Branch' => $key1
            ]
        ];
        $soap =  new SoapProxy(soap_url, ['connection_timeout' => 60000, 'trace' => true, 'exceptions' => true, 'login' => soap_login, 'password' =>  soap_pass]);
        try {
            $result = $soap->GetOrderForShipmentStatus($arparams);
            if(isset($result['return']) && !empty($result['return']))
            {
                $newStatus = $result['return'];
                $rsShipment = ShipmentEntityTable::getList(
                    array(
                        'select' =>array('ID'),
                        'order' => array('ID' =>'ASC'),
                        'filter'=>array(
                            '=UF_NITAS'=> $key,
                        ),
                    )
                );
                if($arShipemnt = $rsShipment->fetch())
                {
                    $resultMess['shipment_id'] = $arShipemnt['ID'];
                    $resultMess['new_status'] = $newStatus;
                    $this->ouser = $arShipemnt['UF_USER_ID'];
                    ShipmentEntityTable::update($arShipemnt['ID'], ['STATUS' => $newStatus]);
                }
                else
                {
                    $resultMess['shipment_id'] = 'Отгрузка не найдена В ЛК.';
                }
            }
        } catch(Exception $e) {
            $resultMess['shipment_id'] = $e->getMessage();
        }
        return $resultMess;
    }

    private function createOrder($arPrder, $branch)
    {
        $test = new orderUpdaterFull($arPrder, 1, null, true);
        $test->BranchSet = $branch;
        $order_id = $test->createNewOrder(true);
        $this->ouser = $test->getOUser();
        if(!empty($test->getStatusCode()) && $order_id > 0)
        {
            $statusCode = $test->getStatusCode();
            if($statusCode=='TS'){
                $tPrice = 0;
                if(isset($arPrder['Products']['Nomenclature']))
                {
                    $tPrice = $arPrder['Products']['CostWithDiscount'];
                }
                else
                {
                    foreach($arPrder['Products'] as $product) $tPrice+=$product['CostWithDiscount'];
                }
                //$tPrice+=$result['PriceDeliveryForClient'];
                $deliveryStr = ($arPrder['DeliveryDate']!=='0001-01-01') ? '
                             <div class="property-item">
                                            <span class="property-therm">Дата доставки: </span>
                                            <span class="property-text">
                                                <time datetime="2018-06-05">'.FormatDate("d.m.Y",MakeTimeStamp($result['DeliveryDate'], 'YYYY-MM-DD')).'</time>
                                            </span>
                                        </div>
                                        ':'';

                $this->subevent = '
                                
                                      <div class="alert-title">Заказ согласован менеджером КМП</div>
                                      <div class="property-list alert-property-list">
                                        <div class="property-item"><span class="property-therm">Стоимость товаров в заказе: </span>
                                            <span class="property-text">'.formatPriceGlobal($tPrice).'</span>
                                        </div>
                                        <div class="property-item"><span class="property-therm">Сумма заказа с учетом доставки: </span>
                                            <span class="property-text">'.formatPriceGlobal($tPrice+$arPrder['PriceDeliveryForClient']).'</span>
                                        </div>
                                        '.$deliveryStr.'
                                      </div>
                                      <button class="btn btn-primary btn-block" onclick="setOrderStatusWS1CEvT(\'SO\',\''.$order_id.'\')" type="button">Отправить в производство</button>
                                      <div class="small alert-agree-small">Я согласен со стоимостью, планируемой датой отгрузки</div>
                                  
                            ';
            }
            changeStatus($test->getStatusCode(), $order_id);
        }
        return $order_id;
    }

    private function getOrderUserId()
    {
        return (!empty($this->ouser)) ? $this->ouser : 1;
    }

    private function updateShipment($key, $key1 = null)
    {
        $test = new getShipmentAndCreateFull($key, $key1);
        try {
            $arR = $test->process();
        }catch(Exception $e) {
            $arR['shipment_id'] = 'File: '.$e->getFile().' Line: '.$e->getLine().' Mesage: '.$e->getMessage().'<br/><pre>'.$e->getTraceAsString().'</pre>';
        }
        $this->ouser = $test->getSUser();
        return $arR;
    }

    private function updateOrder($key, $key1 = null)
    {
        global $DB;
        $orderG = $DB->Query("SELECT * FROM `b_sale_order_props_value` WHERE `CODE`='NOMBER_FROM_1C' AND `VALUE`='{$key}'")->Fetch();
        if(!empty($orderG))
        {
            $arOrderData = $DB->Query("SELECT * FROM b_sale_order WHERE `ID`='{$orderG['ORDER_ID']}'")->Fetch();
            $this->ouser = $arOrderData['USER_ID'];
            $soap =  new SoapProxy(soap_url, ['connection_timeout' => 60000,'trace' => true, 'exceptions' => true, 'login' => soap_login, 'password' =>  soap_pass]);
            $date = new DateTime();
            $date->modify("-1 year");
            $parameters = [
                'Deny' => false,
                'Message'=>'',
                'OnlyChanges' => false,
                'PackageXDTO'=>[
                    'Date'=> $date->format('c'),
                    'Status'=>'',
                    'Number' => $orderG['VALUE'],
                    'Branch' => (!empty($key1)) ? $key1 : 'TS'
                ]
            ];
            try {
                $result = $soap->GetBuyerOrder($parameters);
                $result = $result['return'];
                $textPre = date("Y-m-d H:i:s", time() )."\r\n";
                elDiabloLog($_SERVER['DOCUMENT_ROOT'].'/soaplog/g_service_order_response_'.$arOrderData['ID'].'.php', $textPre.$soap->getResponse());
                elDiabloLog($_SERVER['DOCUMENT_ROOT'].'/soaplog/g_service_order_request_'.$arOrderData['ID'].'.php', $textPre.$soap->getRequest());
                elDiabloLog($_SERVER['DOCUMENT_ROOT'].'/soaplog/g_service_order_result_'.$arOrderData['ID'].'.php', "<?php return ".var_export($result,1)."; ?>");
                if(!empty($result))
                {
                    $test = new orderUpdaterFull($result, 1, $arOrderData['ID'],true);
                    $test->BranchSet = $key1;
                    $test->processItems();
                    if(!empty($test->getStatusCode()) && $orderG['ORDER_ID'] > 0)
                    {
                        $statusCode = $test->getStatusCode();
                        if($statusCode=='TS'){
                            $tPrice = 0;
                            if(isset($result['Products']['Nomenclature']))
                            {
                                $tPrice = $result['Products']['CostWithDiscount'];
                            }
                            else
                            {
                                foreach($result['Products'] as $product) $tPrice+=$product['CostWithDiscount'];
                            }
                            //$tPrice+=$result['PriceDeliveryForClient'];
                            $deliveryStr = ($result['DeliveryDate']!=='0001-01-01') ? '
                             <div class="property-item">
                                            <span class="property-therm">Дата доставки: </span>
                                            <span class="property-text">
                                                <time datetime="2018-06-05">'.FormatDate("d.m.Y",MakeTimeStamp($result['DeliveryDate'], 'YYYY-MM-DD')).'</time>
                                            </span>
                                        </div>
                                        ':'';


                            $this->subevent = '
                                
                                      <div class="alert-title">Заказ согласован менеджером КМП</div>
                                      <div class="property-list alert-property-list">
                                        <div class="property-item"><span class="property-therm">Стоимость товаров в заказе: </span><span class="property-text">'.formatPriceGlobal($tPrice).'</span></div>
                                        <div class="property-item"><span class="property-therm">Сумма заказа с учетом доставки: </span><span class="property-text">'.formatPriceGlobal($tPrice+$result['PriceDeliveryForClient']).'</span></div>
                                       '.$deliveryStr.'
                                      </div>
                                      <button class="btn btn-primary btn-block" onclick="setOrderStatusWS1CEvT(\'SO\',\''.$orderG['ORDER_ID'].'\')" type="button">Отправить в производство</button>
                                      <div class="small alert-agree-small">Я согласен со стоимостью, планируемой датой отгрузки</div>
                                    
                            ';
                        }
                        changeStatus($test->getStatusCode(), $orderG['ORDER_ID']);
                    }
                    return $orderG['ORDER_ID'];
                }
                else
                {
                    return 'error';
                }
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }
        else
        {
            ini_set('soap.wsdl_cache_enabled', '0');
            ini_set('soap.wsdl_cache_ttl', '0');
            ini_set('default_socket_timeout', 60000);
            $soap =  new SoapProxy(soap_url, ['connection_timeout' => 60000,'trace' => true, 'exceptions' => true, 'login' => soap_login, 'password' =>  soap_pass]);
            $date = new DateTime();
            $date->modify("-10 year");
            $parameters = [
                'Deny' => false,
                'Message'=>'',
                'OnlyChanges' => false,
                'PackageXDTO'=>[
                    'Date'=> $date->format('c'),
                    'Status'=>'',
                    'Number' => $key,
                    'Branch' => $key1
                ]
            ];
            try {
                $result = $soap->GetBuyerOrder($parameters);
                $result = $result['return'];
				$textPre = date("Y-m-d H:i:s", time() )."\r\n";
                elDiabloLog($_SERVER['DOCUMENT_ROOT'].'/soaplog/ng_service_order_response_'.$key.'.php', $textPre.$soap->getResponse());
                elDiabloLog($_SERVER['DOCUMENT_ROOT'].'/soaplog/ng_service_order_request_'.$key.'.php', $textPre.$soap->getRequest());
                elDiabloLog($_SERVER['DOCUMENT_ROOT'].'/soaplog/ng_service_order_result_'.$key.'.php', "<?php return ".var_export($result,1)."; ?>");
                if(!empty($result))
                    $id = $this->createOrder($result,$key1);
                else
                    $id = 'no order';
            }catch(Exception $e) {
                return $e->getMessage();
            }
            return $id;
        }


    }
}
?>