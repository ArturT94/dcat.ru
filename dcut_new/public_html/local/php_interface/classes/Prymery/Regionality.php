<?php

namespace Prymery;

\Bitrix\Main\Loader::includeModule('catalog');
\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('iblock');

class Regionality
{
	public static function getRegions(){
		static $arRegions;
		
		/*$res = \Bitrix\Sale\Location\LocationTable::getList(array(
			'order' => array('NAME_RU' => 'asc'),
			'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'CITY'),
			'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
		));
		while($item = $res->fetch())
		{
			//pre($item);
		}*/
		
		$res = \Bitrix\Sale\Location\DefaultSiteTable::getList(array(
			'filter' => array(
				'SITE_ID' => SITE_ID,
				'LOCATION.NAME.LANGUAGE_ID' => LANGUAGE_ID
			),
			'order' => array(
				'SORT' => 'asc'
			),
			'select' => array(
				'CODE' => 'LOCATION.CODE',
				'ID' => 'LOCATION.ID',
				'PARENT_ID' => 'LOCATION.PARENT_ID',
				'TYPE_ID' => 'LOCATION.TYPE_ID',
				'LATITUDE' => 'LOCATION.LATITUDE',
				'LONGITUDE' => 'LOCATION.LONGITUDE',

				'NAME' => 'LOCATION.NAME.NAME',
				'SHORT_NAME' => 'LOCATION.NAME.SHORT_NAME',

				'LEFT_MARGIN' => 'LOCATION.LEFT_MARGIN',
				'RIGHT_MARGIN' => 'LOCATION.RIGHT_MARGIN'
			)
		));

		while($item = $res->Fetch()){
			$defaults[$item['ID']] = $item;
		}

		$realRegion = self::getRealRegionByIP();
		$defaults[$realRegion['ID']] = $realRegion;

		$arRegions = self::customMultiSort($defaults,'NAME');

		return $arRegions;
	}
	
	public static function getRealRegionByIP(){
		static $arRegion;

		if(!isset($arRegion)){
			$arRegion = false;

			global $APPLICATION;
			$cookie_city = $APPLICATION->get_cookie('CURRENT_REGION');
			//print_r($cookie_city);
			//pre($_COOKIE);
			/*$arSelect = Array("ID", "NAME", "PROPERTY_LINK");
			$arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "PROPERTY_LINK"=>$GLOBALS['_SERVER']['SERVER_NAME'], "ACTIVE"=>"Y");
			$res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
			while($ob = $res->Fetch()){
				$domainName = $ob['NAME'];
			}
			
			if($domainName && $domainName != 'Россия'){
				$res = \Bitrix\Sale\Location\LocationTable::getList(array(
					'order' => array('NAME_RU' => 'asc'),
					'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'NAME_RU' => $domainName),
					'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
				));
				while($item = $res->fetch()){
					$arRegionId = $item['ID'];
				}
				
				if($arRegionId){
					$cookie_city = $arRegionId;
				}
			}*/

			if($cookie_city){
				$res = \Bitrix\Sale\Location\LocationTable::getList(array(
					'order' => array('NAME_RU' => 'asc'),
					'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'ID' => $cookie_city),
					'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
				));
				while($item = $res->fetch()){
					$arRegion = $item;
				}
				if($arRegion){
					$arRegion['NAME'] = $arRegion['NAME_RU'];
					$arRegion['CURRENT'] = 'Y';
				}
			}else{
				if(!isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
					return false;

				// get ip
				$ip = $_SERVER["REMOTE_ADDR"];
				if(!empty($_SERVER["HTTP_X_REAL_IP"])){
					$ip = $_SERVER["HTTP_X_REAL_IP"];
				}

				// get city
				$city = false;
				if(class_exists('\Bitrix\Main\Service\GeoIp\Manager')){
					if(!isset($_SESSION['GEOIP']['cityName']) || !$_SESSION['GEOIP']['cityName']){
						// by bitrix api
						$obBitrixGeoIPResult = \Bitrix\Main\Service\GeoIp\Manager::getDataResult($ip, 'ru');
						if($obBitrixGeoIPResult !== \Bitrix\Main\Service\GeoIp\Manager::INFO_NOT_AVAILABLE){
							if($obResult = $obBitrixGeoIPResult->getGeoData()){
								$_SESSION['GEOIP'] = get_object_vars($obResult);
								$city = isset($_SESSION['GEOIP']['cityName']) && $_SESSION['GEOIP']['cityName'] ? $_SESSION['GEOIP']['cityName'] : '';
							}
						}
					}
					else
						$city = isset($_SESSION['GEOIP']['cityName']) && $_SESSION['GEOIP']['cityName'] ? $_SESSION['GEOIP']['cityName'] : '';
				}
				// search by city name
				if(!$city){
					$city = 'Москва';
				}
				if($city){
					$res = \Bitrix\Sale\Location\LocationTable::getList(array(
						'order' => array('NAME_RU' => 'asc'),
						'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'NAME_RU' => $city),
						'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
					));
					while($item = $res->fetch()){
						$arRegion = $item;
					}
					if($arRegion){
						$arRegion['NAME'] = $arRegion['NAME_RU'];
						$arRegion['CURRENT'] = 'Y';
					}
				}
			}
		}

		return $arRegion;
	}
	
	public static function getCurrentRegion($type){
		static $arRegion;

		$realRegion = self::getRealRegionByIP();

		if($type == 'TITLE'){
			$arRegion = $realRegion['NAME_RU'];
		}elseif($type == 'ID'){
			$arRegion = $realRegion['ID'];
		}else{
			if(!isset($arRegion)){
				$arRegion = false;

				if($arRegions = self::getRegions()){
					
					
				}
			}
		}
		
		return $arRegion;
	}
	
	public static function getAllStores(){
		static $arStores;
		
		$rsStore = \Bitrix\Catalog\StoreTable::getList(array('filter' => array('ACTIVE'>='Y','!ID'=>10),'select' => array('*','UF_*')));

		while($arStore=$rsStore->fetch()){
			if($arStore['UF_CITY']){
				$city = explode(',',$arStore['UF_CITY']);
				$arItem[trim($city[0])]['SHOPS'][$arStore['ID']] = $arStore;
			}
		}
		
		$arStores = $arItem;
		return $arStores;
	}
	public static function cityHaveShop(){
		static $cityHaveShop;
		$arStores = self::getAllStores();
		$realRegion = self::getRealRegionByIP();
		if($arStores[$realRegion['NAME']]){
			$cityHaveShop = true;
		}else{
			$cityHaveShop = false;
		}
		
		return $cityHaveShop;
	}
	
	public static function getDefStore(){
		static $arStores;
		
		$rsStore = \Bitrix\Catalog\StoreTable::getList(array('filter' => array('ACTIVE'>='Y','=UF_DEF'=>1),'select' => array('*','UF_CITY','UF_DEF')));
		while($arStore=$rsStore->fetch()){
			$defStoreId = $arStore['ID'];
		}

		return $defStoreId;
	}
	public static function getCurStore(){
		static $getCurStore;
		$arStores = self::getAllStores();
		$realRegion = self::getRealRegionByIP();
		
		if($arStores[$realRegion['NAME']]){
			//Если в городе клиента есть магазин(ы)
			$getCurStore = array_keys($arStores[$realRegion['NAME']]['SHOPS']);
		}else{
			//Если в городе клиента нет магазина
			$getCurStore = self::getDefStore();
			//$getCurStore = $arStores[DEF_STORE];
		}

		return $getCurStore;
	}
	public static function getCurCityRedirect(){
		static $getCurStore;
		global $APPLICATION;
		$arStores = self::getAllStores();
		$realRegion = self::getRealRegionByIP();
		$isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
		if($isHttps){
			$pre_link = 'http://';
		}else{
			$pre_link = 'https://';
		}
		$arSelect = Array("ID", "NAME", "PROPERTY_LINK");
		$arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "NAME"=>$realRegion['NAME'], "ACTIVE"=>"Y");
		$res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
		while($ob = $res->Fetch()){
			$link = $ob['PROPERTY_LINK_VALUE'];
		}
		$arSelect = Array("ID", "NAME", "PROPERTY_LINK");
		$arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "PROPERTY_LINK"=>$GLOBALS['_SERVER']['SERVER_NAME'], "ACTIVE"=>"Y");
		$res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
		while($ob = $res->Fetch()){
			$link2 = $ob;
		}
			
		if(!$APPLICATION->get_cookie('CURRENT_REGION')){
			
			
			
			/*if($realRegion['NAME'] == 'Краснодар' && !$APPLICATION->get_cookie('SELECT_SHOP')){
				$APPLICATION->set_cookie('SELECT_SHOP', 19,time()+60*60*24*30*12*2,"",'freevape.ru');
			}*/
			if($realRegion['NAME'] == 'Краснодар' && !$APPLICATION->get_cookie('SELECT_SHOP')/* || $link2['NAME'] == 'Краснодар'*/){
				//$APPLICATION->set_cookie('SELECT_SHOP', 19,time()+60*60*24*30*12*2,"",'freevape.ru');?>
				<script>
					$.cookie("FV_SELECT_SHOP", 19, { path: '/',domain: '<?=$GLOBALS['_SERVER']['SERVER_NAME']?>' ,expires:365});
				</script>
			<?}
			if($link2){
				if($GLOBALS['_SERVER']['SERVER_NAME'] != $link){
					$res = \Bitrix\Sale\Location\LocationTable::getList(array(
						'order' => array('NAME_RU' => 'asc'),
						'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'CITY', 'NAME_RU' => $link2['NAME']),
						'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
					));
				
					//$db_vars = \Bitrix\Sale\Location\LocationTable::getList(array("SORT" => "ASC"), array("LID" => LANGUAGE_ID,'CITY_NAME' =>$link2['NAME']),false,false, array());
					while ($vars = $res->Fetch()){
						//$APPLICATION->set_cookie('CURRENT_REGION', $vars['ID'],time()+60*60*24*30*12*2,"",'freevape.ru');?>
						<script>
							$.cookie("FV_CURRENT_REGION", <?=$vars['ID']?>, { path: '/' ,domain: 'freevape.ru'});
							location.reload();
						</script>
					<?}
				}
			}
			/*if($link){
				if($GLOBALS['_SERVER']['SERVER_NAME'] != $link){
					LocalRedirect($pre_link.$link.$APPLICATION->GetCurPage());
				}
			}else{
				if($GLOBALS['_SERVER']['SERVER_NAME'] != 'freevape.ru'){
					LocalRedirect($pre_link.'freevape.ru'.$APPLICATION->GetCurPage());
				}
			}*/
		}else{
			/*$arSelect = Array("ID", "NAME", "PROPERTY_LINK");
			$arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "NAME"=>$realRegion['NAME'], "ACTIVE"=>"Y");
			$res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
			while($ob = $res->Fetch()){
				$link = $ob['PROPERTY_LINK_VALUE'];
			}
			if($link){
				if($GLOBALS['_SERVER']['SERVER_NAME'] != $link){
					LocalRedirect($pre_link.$link.$APPLICATION->GetCurPage());
				}
			}*/
			if($APPLICATION->get_cookie('CURRENT_REGION') && $link2['PROPERTY_LINK_VALUE'] == 'freevape.ru' && $link){?>
				<script>
					$.cookie("FV_CURRENT_REGION", 216, { path: '/' ,domain: 'freevape.ru',expires:365});
					location.reload();
				</script>
			<?}
		}
	}
	public static function getAllShopsThisCity(){
		static $getAllShopsThisCity;
		$arStores = self::getAllStores();
		$realRegion = self::getRealRegionByIP();
		
		//Если в городе клиента есть магазин(ы)
		$getAllShopsThisCity = array_keys($arStores[$realRegion['NAME']]['SHOPS']);

		return $getAllShopsThisCity;
	}
	public static function CatalogQuantityInCurLocation($productId){
		//Если вы из города, в котором есть магазины, то получаем остатки товара либо на всех складах, если не выбран магазин, либо в конкретном магазине
		//Если вы из города, в котором нет магазинов, то получаем остатки с основного склада

		static $curQuantity;
		$curQuantity = 0;
		global $APPLICATION;
		$storeId = $APPLICATION->get_cookie('SELECT_SHOP');
		
		if($storeId){
			//Если выбран магазин, то показываем остатки этого магазина
			$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
				'filter' => array('=PRODUCT_ID'=>$productId,'=STORE_ID'=>$storeId),
				'limit' => 1,
				'select' => array('AMOUNT','STORE_TITLE' => 'STORE.TITLE', 'PRODUCT_NAME' => 'PRODUCT.IBLOCK_ELEMENT.NAME'),
			));
			if($arStoreProduct=$rsStoreProduct->fetch()){
				$curQuantity = $arStoreProduct['AMOUNT'];
			}
			
			//Проверяем, если остатки в этом магазине 0, то будем искать в других магазинах этого города
			if($curQuantity == 0){
				$defStore = self::getCurStore();
				$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
					'filter' => array('=PRODUCT_ID'=>$productId,'STORE.ACTIVE'=>'Y','=STORE_ID'=>$defStore),
				));
				while($arStoreProduct=$rsStoreProduct->fetch()){
					$curQuantity += $arStoreProduct['AMOUNT'];
				}
				//Если в других магазинах города товар есть, то выводим плашку "есть в других магазинах"
				if($curQuantity>0){
					$curQuantity = 'otherShop';
				}else{
					$curQuantity = 'empty';
				}
				
			}
		}else{
			//Если магазин не выбран, то проверяем есть ли в городе посетителя магазины или нет
			$defStore = self::getCurStore();
			$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
				'filter' => array('=PRODUCT_ID'=>$productId,'STORE.ACTIVE'=>'Y','=STORE_ID'=>$defStore),
			));
			while($arStoreProduct=$rsStoreProduct->fetch()){
				$curQuantity += $arStoreProduct['AMOUNT'];
			}
			if($curQuantity==0){
				$curQuantity = 'empty';
			}
		}

		return $curQuantity;
	}
	public static function ProductQuantityClass($quantity){
		//Если вы из города, в котором есть магазины, то получаем остатки товара либо на всех складах, если не выбран магазин, либо в конкретном магазине
		//Если вы из города, в котором нет магазинов, то получаем остатки с основного склада

		static $class;
		if($quantity>=2 && $quantity<5){
			$class = ' product__stock--warning';
		} 
		if($quantity<2){
			$class = ' product__stock--danger';
		}
		if($quantity>=5){
			$class = '';
		}
		return $class;
	}
	public static function ProductQuantityBar($quantity){
		//Если вы из города, в котором есть магазины, то получаем остатки товара либо на всех складах, если не выбран магазин, либо в конкретном магазине
		//Если вы из города, в котором нет магазинов, то получаем остатки с основного склада

		static $bar;
		$bar = '<div class="prodduct__stock__bar">';
		if($quantity>=2 && $quantity<5){
			$bar.= '<i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i></i><i></i>';
		} 
		if($quantity<2){
			$bar.= '<i class="active"></i><i class="active"></i><i></i><i></i><i></i><i></i>';
		}
		if($quantity>=5){
			$bar.= '<i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i>';
		}
		$bar .= '</div>';
		echo $bar;
	}
	public static function ProductQuantityBarDetail($quantity){
		//Если вы из города, в котором есть магазины, то получаем остатки товара либо на всех складах, если не выбран магазин, либо в конкретном магазине
		//Если вы из города, в котором нет магазинов, то получаем остатки с основного склада

		static $bar;
		$bar = '<div class="prodduct__stock__bar">';
		if($quantity>=2 && $quantity<5){
			$bar.= '<i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i></i><i></i>';
		} 
		if($quantity<2){
			$bar.= '<i class="active"></i><i class="active"></i><i></i><i></i><i></i><i></i>';
		}
		if($quantity>=5){
			$bar.= '<i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i>';
		}
		$bar .= '</div>';
		if($quantity>=2 && $quantity<5){
			$bar.= '<div class="caption">достаточно</div>';
		} 
		if($quantity<2){
			$bar.= '<div class="caption">мало</div>';
		}
		if($quantity>=5){
			$bar.= '<div class="caption">много</div>';
		}
		echo $bar;
	}
	
	public static function QuantityOtherShop($productId){
		//Если вы из города, в котором есть магазины, то получаем остатки товара в каждом магазине
		static $curQuantity;
		$curQuantity = 0;
		global $APPLICATION;
		$storeId = $APPLICATION->get_cookie('SELECT_SHOP');
		
		$defStore = self::getAllShopsThisCity();
		$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
			'filter' => array('=PRODUCT_ID'=>$productId,'STORE.ACTIVE'=>'Y','=STORE_ID'=>$defStore),
		));
		while($arStoreProduct=$rsStoreProduct->fetch()){
			if($arStoreProduct['AMOUNT'] > 0){
				$allStores[$arStoreProduct['ID']] = $arStoreProduct['AMOUNT'];
			}
		}
		$countOtherShop = count($allStores);
		if($allStores[$storeId]){
			$countOtherShop--;
		}
		return $countOtherShop;
	}	
	public static function QuantityOtherShopOffers($offers){
		//Если вы из города, в котором есть магазины, то получаем остатки товара в каждом магазине
		static $curQuantity;
		$curQuantity = 0;
		global $APPLICATION;
		$storeId = $APPLICATION->get_cookie('SELECT_SHOP');
		
		$defStore = self::getAllShopsThisCity();
		foreach($offers as $offer){
			$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
				'filter' => array('=PRODUCT_ID'=>$offer['ID'],'STORE.ACTIVE'=>'Y','=STORE_ID'=>$defStore),
			));
			while($arStoreProduct=$rsStoreProduct->fetch()){
				if($arStoreProduct['AMOUNT'] > 0){
					$allStores[$arStoreProduct['STORE_ID']] = $arStoreProduct['AMOUNT'];
				}
			}
		}

		$countOtherShop = count($allStores);
		if($allStores[$storeId]){
			$countOtherShop--;
		}
		return $countOtherShop;
	}
	public static function getAllStoreFromProduct($productId){
		//Если вы из города, в котором есть магазины, то получаем остатки товара в каждом магазине
		static $curQuantity;
		$curQuantity = 0;
		global $APPLICATION;
		$storeId = $APPLICATION->get_cookie('SELECT_SHOP');
		
		$arStores = self::getAllStores();
		$realRegion = self::getRealRegionByIP();
		$shopInCity = $arStores[$realRegion['NAME']]['SHOPS'];
		
		$defStore = self::getAllShopsThisCity();
		$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
			'filter' => array('=PRODUCT_ID'=>$productId,'STORE.ACTIVE'=>'Y','=STORE_ID'=>$defStore),
		));
		while($arStoreProduct=$rsStoreProduct->fetch()){
			if($arStoreProduct['AMOUNT'] > 0){
				if($shopInCity[$arStoreProduct['STORE_ID']]){
					$returnAr[$arStoreProduct['ID']] = $shopInCity[$arStoreProduct['STORE_ID']];
				}
				$returnAr[$arStoreProduct['ID']]['AMOUNT'] = $arStoreProduct['AMOUNT'];
			}
		}
		return $returnAr;
	}
	public static function getAllStoreFromProductOffers($offers){
		//Если вы из города, в котором есть магазины, то получаем остатки товара в каждом магазине
		static $curQuantity;
		$curQuantity = 0;
		global $APPLICATION;
		$storeId = $APPLICATION->get_cookie('SELECT_SHOP');
		
		$arStores = self::getAllStores();
		$realRegion = self::getRealRegionByIP();
		$shopInCity = $arStores[$realRegion['NAME']]['SHOPS'];
		
		$defStore = self::getAllShopsThisCity();
		foreach($offers as $offer){
			$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
				'filter' => array('=PRODUCT_ID'=>$offer['ID'],'STORE.ACTIVE'=>'Y','=STORE_ID'=>$defStore),
			));
			while($arStoreProduct=$rsStoreProduct->fetch()){
				if($arStoreProduct['AMOUNT'] > 0){
					if($shopInCity[$arStoreProduct['STORE_ID']]){
						$returnAr[$arStoreProduct['STORE_ID']] = $shopInCity[$arStoreProduct['STORE_ID']];
					}
					$returnAr[$arStoreProduct['STORE_ID']]['AMOUNT'] = $arStoreProduct['AMOUNT'];
				}
			}
		}
		return $returnAr;
	}
	public static function getQuantityStore($productId,$storeId){
		//Остаток товара на конкретном складе
		$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
			'filter' => array('=PRODUCT_ID'=>$productId,'STORE.ACTIVE'=>'Y','=STORE_ID'=>$storeId),
		));
		while($arStoreProduct=$rsStoreProduct->fetch()){
			$returnAmount = $arStoreProduct['AMOUNT'];
		}
		$bar = "";
		if($returnAmount>=2 && $returnAmount<5){
			$bar = '<div class="product__stock product__stock--warning"><div class="prodduct__stock__bar">';
			$bar.= '<i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i></i><i></i>';
		} 
		if($returnAmount<2 && $returnAmount != 0){
			$bar = '<div class="product__stock product__stock--danger"><div class="prodduct__stock__bar">';
			$bar.= '<i class="active"></i><i class="active"></i><i></i><i></i><i></i><i></i>';
		}
		if($returnAmount>=5){
			$bar = '<div class="product__stock"><div class="prodduct__stock__bar">';
			$bar.= '<i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i><i class="active"></i>';
		}
		$bar .= '</div></div>';
		if($returnAmount == 0){
			$bar = '';
		}
		
		return $bar;
	}
	
	
	
	
	
	
	
	function customMultiSort($array,$field) {
		$sortArr = array();
		foreach($array as $key=>$val){
			$sortArr[$key] = $val[$field];
		}

		array_multisort($sortArr,$array);

		return $array;
	}
	
	
	
	
	
	
	public static function getCurrentCity(){
		static $arRegion;

		if(!isset($arRegion)){
			$arRegion = false;

			if($arRegions = self::getRegions()){
				//$arVal = PRgenesis::GetFrontParametrsValues(SITE_ID);

				if($arVal['REGIONALITY_METHOD'] !== 'Y'){
					// search by cookie value
					if(isset($_COOKIE['current_region']) && $_COOKIE['current_region']){
						if(isset($arRegions[$_COOKIE['current_region']]) && $arRegions[$_COOKIE['current_region']]){
							$arRegion = $arRegions[$_COOKIE['current_region']];
							return '<span class="text-sm">'.$arRegion["NAME"].'</span>';
						}
					}
				}

				if(!$arRegion){
					if($arVal['REGIONALITY_METHOD'] === 'Y'){
						foreach($arRegions as $arItem){
							if(in_array($_SERVER['SERVER_NAME'], $arItem['LIST_DOMAINS']) || in_array($_SERVER['HTTP_HOST'], $arItem['LIST_DOMAINS'])){
								$arRegion = $arItem;
								break;
							}
						}
					}
				}
				if(!$arRegion){
					foreach($arRegions as $arItem){
						if($arItem['PROPERTY_DEFAULT_VALUE'] === 'Y'){
							$arRegion = $arItem;
							break;
						}
					}
				}
				if(!$arRegion){
					$arRegion = reset($arRegions);
				}
			}

		}
		return '<span class="text-sm">'.$arRegion["NAME"].'</span>';
	}
	public static function getCurrentPhones(){
		static $arRegion;

		if(!isset($arRegion)){
			$arRegion = false;

			if($arRegions = self::getRegions()){
				$arVal = PRgenesis::GetFrontParametrsValues(SITE_ID);
				if($arVal['REGIONALITY_METHOD'] !== 'Y'){
					// search by cookie value
					if(isset($_COOKIE['current_region']) && $_COOKIE['current_region']){
						if(isset($arRegions[$_COOKIE['current_region']]) && $arRegions[$_COOKIE['current_region']]){
							$arRegion = $arRegions[$_COOKIE['current_region']];
							$phone = '';
							foreach($arRegion["PHONES"] as $phone_number){
								$phone = $phone.'<a href="callto:'.$phone_number.'" class="font-bold">'.$phone_number.'</a><br>';
							}
							if($phone){
								$phone_content = '<div class="dropdown-body">'.$phone.'</div>';
							}
//                                return '<span class="city">'.$arRegion["NAME"].',</span>'.$arRegion["PROPERTY_SHOP_ADDRESS_VALUE"];
							return '<div class="dropdown-header">
										<a href="callto:'.$arRegion["PHONES"][0].'" class="font-bold">'.$arRegion["PHONES"][0].'</a>
										<span class="dropdown-toggler">
											<svg><use xlink:href="#caret-down"></use></svg>
										</span>
									</div>'.$phone_content;
						}
					}
				}

				if(!$arRegion){
					if($arVal['REGIONALITY_METHOD'] === 'Y'){
						foreach($arRegions as $arItem){
							if(in_array($_SERVER['SERVER_NAME'], $arItem['LIST_DOMAINS']) || in_array($_SERVER['HTTP_HOST'], $arItem['LIST_DOMAINS'])){
								$arRegion = $arItem;
								break;
							}
						}
					}
				}
				if(!$arRegion){
					foreach($arRegions as $arItem){
						if($arItem['PROPERTY_DEFAULT_VALUE'] === 'Y'){
							$arRegion = $arItem;
							break;
						}
					}
				}
				if(!$arRegion){
					$arRegion = reset($arRegions);
				}
			}
		}
		if($arRegion){
			foreach($arRegion["PHONES"] as $phone_number){
				$phone = $phone.'<a href="callto:'.$phone_number.'" class="font-bold">'.$phone_number.'</a><br>';
			}
			if($phone){
				$phone_content = '<div class="dropdown-body">'.$phone.'</div>';
			}
			return '<div class="dropdown-header">
						<a href="callto:'.$arRegion["PHONES"][0].'" class="font-bold">'.$arRegion["PHONES"][0].'</a>
						<span class="dropdown-toggler">
							<svg><use xlink:href="#caret-down"></use></svg>
						</span>
					</div>'.$phone_content;
		}else{
			return '<div class="dropdown-header">
					<a href="callto:'.$arVal['CONTACT_PHONE'].'" class="font-bold">'.$arVal['CONTACT_PHONE'].'</a>
				</div>';
		}
	}
	public static function CityFilter(){
		global $CityFilter;
		if($arRegions = self::getRegions()){
			//$arVal = PRgenesis::GetFrontParametrsValues(SITE_ID);
			if($arVal['REGIONALITY_METHOD'] === 'Y') {
				foreach ($arRegions as $arItem) {
					if (in_array($_SERVER['SERVER_NAME'], $arItem['LIST_DOMAINS']) || in_array($_SERVER['HTTP_HOST'], $arItem['LIST_DOMAINS'])) {
						$arRegion = $arItem;
						break;
					}
				}
			}
			if($arRegion){
				$current_region = $arRegion['ID'];
			}else{
				$current_region = $_COOKIE['current_region'];
			}
			$CityFilter[] = array(
				"LOGIC" => "OR",
				array("PROPERTY_CITY" => $current_region),
				array("=PROPERTY_CITY" => false)
			);
			return $CityFilter;
		}
	}
	
	
	public static function GetRegionPrice(){
		static $arRegion;
		if(!isset($arRegion)){
			$arRegion = false;
			if($arRegions = self::getRegions()){
				//$arVal = PRgenesis::GetFrontParametrsValues(SITE_ID);
				if($arVal['REGIONALITY_METHOD'] === 'Y') {
					foreach ($arRegions as $arItem) {
						if (in_array($_SERVER['SERVER_NAME'], $arItem['LIST_DOMAINS']) || in_array($_SERVER['HTTP_HOST'], $arItem['LIST_DOMAINS'])) {
							$arRegion = $arItem;
							break;
						}
					}
				}
				if($arRegion){
					$current_region = $arRegion['ID'];
				}else{
					$current_region = $_COOKIE['current_region'];
				}
				if(isset($current_region) && $current_region){
					if(isset($arRegions[$current_region]) && $arRegions[$current_region]){
						$arRegion = $arRegions[$current_region];
						$price = $arRegion['PROPERTY_PRICE_VALUE'][0];
					}
				}
				if(!$price){
					$dbPriceType = CCatalogGroup::GetList(array("SORT" => "ASC"), array("SITE_ID" => SITE_ID));
					while ($arPriceType = $dbPriceType->Fetch()){
						$price = $arPriceType['ID'];
					}
				}
				return $price;
			}

		}
	}
	public static function checkCityDomain(){
		//Если зашли на поддомен, который есть в инфоблоке региональность, то устанавливаем город поддомена в куку
		if($GLOBALS['_SERVER']['SERVER_NAME']){
			global $APPLICATION;
			$arSelect = Array("ID", "NAME", "PROPERTY_LINK");
			$arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "PROPERTY_LINK"=>$GLOBALS['_SERVER']['SERVER_NAME'], "ACTIVE"=>"Y");
			$res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
			while($ob = $res->Fetch()){
				$arDomainRegion = $ob['NAME'];
				$arDomainRegionUrl = $ob['PROPERTY_LINK_VALUE'];
			}
			if($arDomainRegion){
				//Если нашли, то получаем ID местоположения в базе битрикса
				$res = \Bitrix\Sale\Location\LocationTable::getList(array(
					'order' => array('NAME_RU' => 'asc'),
					'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'CITY', 'NAME_RU' => $arDomainRegion),
					'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
				));
				while($item = $res->fetch()){
					$arDomainId = $item['ID'];
				}
				if($arDomainId){
					
					if($APPLICATION->get_cookie('CURRENT_REGION') != $arDomainId){?>
						<script>
							$.cookie("FV_CURRENT_REGION", <?=$arDomainId?>, { path: '/' ,domain: 'freevape.ru'});
							location.reload();
						</script>
					<?
						//$APPLICATION->set_cookie('CURRENT_REGION',$arDomainId,time()+60*60*24*30*12*2,"",'freevape.ru'); 
						 
						
						if($arDomainRegion == 'Краснодар' && !$APPLICATION->get_cookie('SELECT_SHOP')){
							//$APPLICATION->set_cookie('SELECT_SHOP', 19,time()+60*60*24*30*12*2,"",'freevape.ru');?>
							<script>
								$.cookie("FV_SELECT_SHOP", 19, { path: '/' });
							</script>
						<?}

					}
				}
			}
		}
		
	}
    public static function cityNameBanner(){
        //Если зашли на поддомен, который есть в инфоблоке региональность, то устанавливаем город поддомена в куку
        $city = 'Краснодару';
        if($GLOBALS['_SERVER']['SERVER_NAME']){
            global $APPLICATION;
            $arSelect = Array("ID", "NAME", "PROPERTY_LINK","PROPERTY_BANNER_TITLE");
            $arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "PROPERTY_LINK"=>$GLOBALS['_SERVER']['SERVER_NAME'], "ACTIVE"=>"Y");
            $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()){
                $city = $ob['PROPERTY_BANNER_TITLE_VALUE'];
            }
        }
		if(!$city){
			$city = 'России';
		}
        return $city;
    }
    public static function cityNameContacts(){
        //Если зашли на поддомен, который есть в инфоблоке региональность, то устанавливаем город поддомена в куку
        $city = 'Краснодаре';
        if($GLOBALS['_SERVER']['SERVER_NAME']){
            global $APPLICATION;
            $arSelect = Array("ID", "NAME", "PROPERTY_LINK","PROPERTY_CONTACTS_TITLE");
            $arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "PROPERTY_LINK"=>$GLOBALS['_SERVER']['SERVER_NAME'], "ACTIVE"=>"Y");
            $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()){
                $city = $ob['PROPERTY_CONTACTS_TITLE_VALUE'];
            }
        }
        return $city;
    }
    public static function vkLink(){
        $link = '';
        if($GLOBALS['_SERVER']['SERVER_NAME']){
            global $APPLICATION;
            $arSelect = Array("ID", "NAME", "PROPERTY_LINK", 'PROPERTY_VK');
            $arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "PROPERTY_LINK"=>$GLOBALS['_SERVER']['SERVER_NAME'], "ACTIVE"=>"Y");
            $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()){
                $arDomainRegion = $ob;
            }
            if($arDomainRegion){
                //Если нашли, то подставляем ссылку
                $link = $arDomainRegion['PROPERTY_VK_VALUE'];
            }else{
                $link = 'https://vk.com/freevapekrd';
            }
        }
        return $link;
    }
}
