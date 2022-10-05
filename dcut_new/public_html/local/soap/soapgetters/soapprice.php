<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(dirname(__FILE__)));
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_CRONTAB", true);
define('BX_WITH_ON_AFTER_EPILOG', true);
define('BX_NO_ACCELERATOR_RESET', true);
define('STOP_STATISTICS', true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Main\Loader::includeModule('catalog');

$soap =  new SoapProxy(soap_url, ['connection_timeout' => 60000,'trace' => true, 'exceptions' => true, 'login' => soap_login, 'password' =>  soap_pass]);

foreach(sunc_branch as $branch)
{

	$date = new DateTime();
	$date->modify("-1 year");
	$parameters = [
		'Deny'=>false,
		'Message'=>'',
		'PackageXDTO'=>[
			'Date'=> '0001-01-01',
			'Status'=>'',
			'Number'=>'',
			'Branch' => $branch
		]
	];
	global $DB;
	$priceCount = 0;
	try {
		$result = $soap->GetRetailPrices($parameters);
		$priceArray = $result['return']['Prices'];
		foreach($priceArray as $onePriceObject)
		{
			$sqlProduct = "SELECT `ID` FROM `b_iblock_element` WHERE `XML_ID`='{$onePriceObject['NumberInTheAccountingSystem']}'";
			$rsProduct = $DB->Query($sqlProduct);
			if($arProduct = $rsProduct->Fetch())
			{
				$ELEMENT_ID = $arProduct['ID'];
				$price = $onePriceObject['Price'];

				if($branch == 'M0') {
					$arPrice = array("PRODUCT_ID" => $ELEMENT_ID, "PRICE" => trim($price), "CURRENCY" => "RUB", "CATALOG_GROUP_ID" => "1");
					$prices = CPrice::GetList(array(), array("PRODUCT_ID" => $ELEMENT_ID, "CATALOG_GROUP_ID" => "1"));
					if ($priceOne = $prices->Fetch()) {
						$cprice_add = CPrice::Update($priceOne['ID'], $arPrice);
						// \Bitrix\Catalog\Model\Price::update.
					} else {
						// \Bitrix\Catalog\Model\Price::add
						$cprice_add = CPrice::Add($arPrice);
					} 
				}

				// цены для филиала который наш, нужный!
				$arPrice1 = array("PRODUCT_ID" => $ELEMENT_ID, "PRICE" => trim($price), "CURRENCY" => "RUB", "CATALOG_GROUP_ID" => getPriceTypeForBranch($branch));
				$prices1 = CPrice::GetList(array(), array("PRODUCT_ID" => $ELEMENT_ID, "CATALOG_GROUP_ID" => getPriceTypeForBranch($branch)));
				if ($priceOne1 = $prices1->Fetch())
				{
					$cprice_add1 = CPrice::Update($priceOne1['ID'], $arPrice1);
				}
				else
				{
					$cprice_add1 = CPrice::Add($arPrice1);
				}


				$arCatalogProductParams = array("ID" => $ELEMENT_ID, "QUANTITY" => 0);
				$CCatalogProduct = new CCatalogProduct();
				$cproduct_add = $CCatalogProduct->Add($arCatalogProductParams);
				$priceCount++;
			}
		}
		//global $DB;
		//$DB->Query("UPDATE `b_iblock_element` SET `ACTIVE`='N' WHERE `ID` NOT IN (SELECT `PRODUCT_ID` FROM `b_catalog_price` WHERE `PRICE`>'0')");
		//$DB->Query("UPDATE `b_catalog_product` SET `AVAILABLE`='N' WHERE `ID` NOT IN (SELECT `PRODUCT_ID` FROM `b_catalog_price` WHERE `PRICE`>'0')");
		echo 'Add or update '.$priceCount.' prices. Branch: '.$branch.'.'."\r\n";
	}catch(Exception $e) {
		echo $e->getMessage();
	}
}