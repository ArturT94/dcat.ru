<?php
define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once(__DIR__ . '/service.class.php');
$APPLICATION->RestartBuffer();
$class = "SoapServiceMetaloprofil";
$serviceURI = "http://".$_SERVER['SERVER_NAME']."/soapservice/";
$wsdlGenerator = new PHP2WSDL\PHPClass2WSDL($class, $serviceURI);
$wsdlGenerator->generateWSDL(true);
$wsdlXML = $wsdlGenerator->save($_SERVER["DOCUMENT_ROOT"] .'/soapservice/SoapServiceBase.wsdl');
$wsdlXML = $wsdlGenerator->dump();
$GLOBALS['APPLICATION']->RestartBuffer();
header("Content-Type: text/xml");
elDiabloLog(dirname(__FILE__).'/logs/wsdl.access.log', "[".date("Y-m-d H:i:s",time())."] {$_SERVER['REMOTE_ADDR']}\r\n",FILE_APPEND);
echo $wsdlXML;
