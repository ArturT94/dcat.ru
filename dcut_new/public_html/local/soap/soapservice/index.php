<?php
define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once(__DIR__ . '/service.class.php');
header("Content-Type: text/html; charset=utf-8");
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));
ini_set('soap.wsdl_cache_enabled', '0');
ini_set('soap.wsdl_cache_ttl', '0');
elDiabloLog(dirname(__FILE__).'/logs/service.access.log', "[".date("Y-m-d H:i:s",time())."] {$_SERVER['REMOTE_ADDR']}\r\n",FILE_APPEND);
$server = new SoapServer("http://{$_SERVER['SERVER_NAME']}/soap/soapservice/wsdl.php", ['cache_wsdl' => WSDL_CACHE_NONE]);
$server->setClass("SoapServiceMetaloprofil");
$server->handle();
//$server->fault(403, 'Access denied');
