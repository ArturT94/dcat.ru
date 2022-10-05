<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(\Bitrix\Main\Loader::includeModule('prymery.genesis'))
{
	$arParams['POPUP'] = (isset($arParams['POPUP']) ? $arParams['POPUP'] : 'N');
	$arResult['POPUP'] = ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&  $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || $arParams['POPUP'] == 'Y');

	if(!$arResult['POPUP']  || ($arResult['POPUP'] && \Bitrix\Main\Config\Option::get('prymery.genesis', 'REGIONALITY_SEARCH_ROW', 'N') != 'Y')) {
		$arResult['REGIONS'] = PRgenesisRegions::getRegions();
		$arResult['CURRENT_REGION'] = PRgenesisRegions::getCurrentRegion();
		$arResult['REAL_REGION'] = PRgenesisRegions::getRealRegionByIP();
		$arResult['REGION_SELECTED'] = isset($_COOKIE['current_region']) && $_COOKIE['current_region'];
		$arResult['REGION_GEOIP_ERROR'] = !isset($_SESSION['GEOIP']) || isset($_SESSION['GEOIP']['message']);
		$arResult['SHOW_REGION_CONFIRM'] = !$arResult['REGION_GEOIP_ERROR'] && $arResult['REAL_REGION'] && $arResult['REAL_REGION']['ID'] != $arResult['CURRENT_REGION']['ID'] && !($arResult['REGION_SELECTED'] && $arResult['CURRENT_REGION']['ID'] == $_COOKIE['current_region']);
	}
	if($arResult['REGIONS']) {
		$arSectionsID = array();
		if($arResult['POPUP']) {
			$arResult['FAVORITS'] = array();
			foreach($arResult['REGIONS'] as $arItem) {
                $arSectionsID[] = $arItem['IBLOCK_SECTION_ID'];
				if($arItem['PROPERTY_FAVORIT_LOCATION_VALUE'] == 'Y')
					$arResult['FAVORITS'][] = $arItem;
			}
			$arResult['SECTION_REGION_FIRST'] = $arResult['SECTION_REGION_SECOND'] = array();
			$arSectionsName = array();
            if($arSectionsID) {
				$arSections = CIBlockSection::GetList(array('SORT' => 'ASC', 'NAME' => 'ASC'),
                    array('ACTIVE' => 'Y', 'IBLOCK_ID' => PRgenesis::CIBlock_Id('prymery_genesis_content','prymery_genesis_regions')),
                    false, array('ID', 'IBLOCK_ID', 'NAME', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID'));

                while($arSection=$arSections->Fetch()){
                    $arSectionsName[$arSection['ID']] = $arSection['NAME'];

                    if($arSection['DEPTH_LEVEL'] == 1) {
                        $arResult['SECTION_REGION_FIRST'][$arSection['ID']] = $arSection;
                    }elseif($arSection['DEPTH_LEVEL'] == 2){
                        $arResult['SECTION_REGION_SECOND'][$arSection['IBLOCK_SECTION_ID']][$arSection['ID']] = $arSection;
                    }
                }
			}
			foreach($arResult['REGIONS'] as $id => $arRegionItem) {
				$arResult['JS_REGIONS'][] = array(
					'label' => $arRegionItem['NAME'],
					'HREF' => $arRegionItem['LINK'],
					'REGION' => (($arSectionsName && ($arRegionItem['IBLOCK_SECTION_ID'] && isset($arSectionsName[$arRegionItem['IBLOCK_SECTION_ID']]))) ? $arSectionsName[$arRegionItem['IBLOCK_SECTION_ID']] : ''),
					'ID' => $arRegionItem['ID'],
				);
			}
		}
//        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/assets/js/jquery-ui.min.js');
		$this->IncludeComponentTemplate();
	}
	elseif($arResult['POPUP'] && \Bitrix\Main\Config\Option::get('prymery.genesis', 'REGIONALITY_SEARCH_ROW', 'N') == 'Y')
	{
//        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/assets/js/jquery-ui.min.js');
		$this->IncludeComponentTemplate();
	}
	else
		return;
}
else
	return;

?>