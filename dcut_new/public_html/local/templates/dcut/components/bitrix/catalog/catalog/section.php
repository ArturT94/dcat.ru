<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
$this->setFrameMode(true);
if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');
if ($isFilter) {
	$arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"],"ACTIVE" => "Y","GLOBAL_ACTIVE" => "Y",);
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
		$arCurSection = $obCache->GetVars();
	}elseif ($obCache->StartDataCache()) {
		$arCurSection = array();
		if (Loader::includeModule("iblock")) {
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));
			if(defined("BX_COMP_MANAGED_CACHE")) {
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");
				if ($arCurSection = $dbRes->Fetch())
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
				$CACHE_MANAGER->EndTagCache();
			}else{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
		$arCurSection = array();
}
$APPLICATION->IncludeComponent("bitrix:breadcrumb","prymery", array("START_FROM" => "0","PATH" => "","SITE_ID" => SITE_ID,"COMPONENT_TEMPLATE" => "prymery"),false);
?>

<section class="shop">
    <div class="section-flex-container">
        <div class="sidebar">
            <?/*div class="filter-all filter-all-up">
                <svg width="22" height="14" class="icon filter-all-svg-up"><use xlink:href="#double-angle-down"></use></svg>
            </div*/?>

            <?$APPLICATION->IncludeComponent("bitrix:menu","catalog",Array(
                    "ROOT_MENU_TYPE" => "catalog",
                    "MAX_LEVEL" => "2",
                    "CHILD_MENU_TYPE" => "left",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "Y",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => ""
                )
            );?>
            <nav class="filters filters-content">
                <?/*div class="filter">
                    <div class="filter-name">
                        <h3>выберите категорию</h3> <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <ul class="filter-block">
                        <li><a href="#">По брендам<span>7</span></a></li>
                        <li><a href="#">Аккумуляторный инструмент <span>14</span></a></li>
                        <li><a href="#">Электроинструмент<span>14</span></a></li>
                    </ul>
                </div>

                <div class="filter">
                    <div class="filter-name">
                        <h3>Диапазон цен</h3>  <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <div class="filter-block range-slider">
                        <div class="filter__slider">
                            <div class="range__zero"></div>
                            <div id="filter__range"></div>
                        </div>
                        <div class="wrap">
                            <input id="priceMin" type="text" value="200000" class="input-range">
                            <input id="priceMax" type="text" value="800000" class="input-range">
                            <button>ок</button>
                        </div>
                    </div>
                </div>

                <div class="filter">
                    <div class="filter-name">
                        Производитель <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <div class="filter-block filter-checkbox">
                        <div class="filter-item">
                            <input type="checkbox" id="one" name="todo" value="todo" data-content="DeWalt">
                            <label for="one"> DeWalt <span>18</span></label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="two" name="todo" value="todo">
                            <label for="two"> Facom <span>38</span></label>
                        </div>

                    </div>
                </div>

                <div class="filter">
                    <div class="filter-name">
                        страна производитель <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <div class="filter-block filter-checkbox">
                        <div class="filter-item">
                            <input type="checkbox" id="russian" name="todo" value="todo">
                            <label for="russian"> Россия <span>18</span></label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="china" name="todo" value="todo">
                            <label for="china"> Китай <span>38</span></label>
                        </div>

                    </div>
                </div>

                <div class="filter">
                    <div class="filter-name">
                        <h3>макс. количество оборотов <i data-toggle="tooltip" data-placement="top" title="Здесь можно получить более подробную информацию о данном параметре" class="fas fa-question-circle prompt"></i></h3> </span> <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <div class="filter-block">
                        <div class="filter-form">
                            <input type="text" name="" value="" placeholder="от">
                            <input type="text" name="" value="" placeholder="до">
                            <button>ок</button>
                        </div>
                    </div>
                </div>

                <div class="filter">
                    <div class="filter-name">
                        <h3>Конструкция перфоратора</h3> <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <div class="filter-block filter-checkbox">
                        <div class="filter-item">
                            <input type="checkbox" id="straight" name="todo" value="todo">
                            <label for="straight"> Прямой <span>43</span></label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="barrel" name="todo" value="todo">
                            <label for="barrel"> Бочковой <span>64</span></label>
                        </div>
                    </div>
                </div>

                <div class="filter">
                    <div class="filter-name">
                        <h3>Режимы работы</h3> <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <div class="filter-block filter-checkbox">
                        <div class="filter-item">
                            <input type="checkbox" id="work01" name="todo" value="todo">
                            <label for="work01"> Сверление с ударом <span>43</span></label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="work02" name="todo" value="todo">
                            <label for="work02"> Сверление <span>64</span></label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="work03" name="todo" value="todo">
                            <label for="work03"> Дробление (удар) <span>23</span></label>
                        </div>
                    </div>
                </div>

                <div class="filter">
                    <div class="filter-name">
                        <h3>Ограничитель глубины сверления <i data-toggle="tooltip" data-placement="top" title="Здесь можно получить более подробную информацию о данном параметре" class="fas fa-question-circle prompt"></i></h3> </span> <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <div class="filter-block filter-checkbox">
                        <div class="filter-item">
                            <input type="checkbox" id="limiter01" name="todo" value="todo">
                            <label for="limiter01"> Да <span>43</span></label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="limiter02" name="todo" value="todo">
                            <label for="limiter02"> Нет <span>64</span></label>
                        </div>
                    </div>
                </div>

                <div class="filter">
                    <div class="filter-name">
                        <h3>Поиск по тегам</h3> <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                    </div>
                    <div class="filter-block filter-tags">
                        <div class="tags-block">
                            <a href="#" class="tags-block_item active">Сервис</a>
                            <a href="#" class="tags-block_item">Dcut</a>
                        </div>
                    </div>
                </div*/?>
            </nav>

            <?/*div class="filter-all">
                <svg width="22" height="14" class="icon filter-all-svg"><use xlink:href="#double-angle-down"></use></svg>
            </div*/?>
            <?$APPLICATION->IncludeComponent("bitrix:main.include","",array("AREA_FILE_SHOW" => "file","AREA_FILE_SUFFIX" => "inc","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => "","COMPONENT_TEMPLATE" => ".default","PATH" => "/local/templates/dcut/include_areas/left_sidebar.php"),false);?>

            <?/*div class="feedback">
                <div class="feedback-title">Расширенная гарантия</div>
                <div class="feedback-block">
                    <div class="feedback-img feedback-img-dark-overflow">
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/category/feedback-1.jpg" alt="img">
                        <a class="last-news-hover-link" href="/services/polnaya-bezuslovnaya-garantiya/">
                            <svg width="27" height="27" class="icon"><use xlink:href="#zoom-in"></use></svg>
                        </a>
                    </div>
                    <div class="feedback-info">
                        <div class="feedback-info_text">Расширенная гарантия “всё включено” на период до 3-х лет</div>
                        <a href="/services/polnaya-bezuslovnaya-garantiya/" class="feedback-info_link">Подробнее <svg width="10" height="8" class="icon"><use xlink:href="#double-angle-right"></use></svg></a>
                    </div>
                </div>
            </div*/?>

            <?/*div class="feedback">
                <div class="feedback-title">Эксклюзив B2B</div>
                <div class="feedback-block">
                    <div class="feedback-img feedback-img-dark-overflow">
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/category/feedback-1.jpg" alt="img">
                        <a class="last-news-hover-link" href="#">
                            <svg width="27" height="27" class="icon"><use xlink:href="#zoom-in"></use></svg>
                        </a>
                    </div>
                    <div class="feedback-info">
                        <div class="feedback-info_text">Эксклюзивные товары от производителя StanleyBlack&Decker</div>
                        <a href="contacts.html" class="feedback-info_link">Подробнее <svg width="10" height="8" class="icon"><use xlink:href="#double-angle-right"></use></svg></a>
                    </div>
                </div>
            </div*/?>

            <?/*div class="feedback feedback-block-callback">
                <div class="feedback-title">Обратная связь</div>
                <div class="feedback-block">
                    <div class="feedback-img feedback-img-dark-overflow">
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/communication.webp" alt="img">
                        <a href="/local/ajax/form/consult.php?ajax=y" data-type="ajax" data-fancybox="" data-src="/local/ajax/form/consult.php?ajax=y" class="last-news-hover-link">
                            <svg width="27" height="27" class="icon"><use xlink:href="#zoom-in"></use></svg>
                        </a>
                    </div>
                    <div class="feedback-info">
                        <div class="feedback-info_text">Задайте вопрос, оставьте заявку или закажите обратный звонок</div>
                        <a href="/local/ajax/form/consult.php?ajax=y" data-type="ajax" data-fancybox="" data-src="/local/ajax/form/consult.php?ajax=y" class="feedback-info_link">
                            Задать вопрос <svg width="10" height="8" class="icon"><use xlink:href="#double-angle-right"></use></svg>
                        </a>
                    </div>
                </div>
            </div*/?>
        </div>

        <div class="content">
            <div class="section-title"><?=$APPLICATION->ShowTitle(false);?></div>
            <?if(!$_REQUEST['count']){$_REQUEST['count']=21;}?>
            <div class="selection">
                <div class="dropdown">
                    <div class="select-block">
                        <div class="dropdown-title">Показать по: </div>
                        <div class="product-sorting">
                            <div class="product-sorting__current">
                                <span><?=$_REQUEST['count']?></span>
                                <svg width="10" height="5" class="icon"><use xlink:href="#triangle-down"></use></svg>
                            </div>
                            <div class="product-sorting__body">
                                <ul class="product-sorting__list">
                                    <li<?if($_REQUEST['count'] == 21 || !$_REQUEST['count']):?> class="current"<?endif;?>>
                                        <a class="options-item" href="<?= $APPLICATION->GetCurPageParam("count=21", array("count")); ?>">21</a>
                                    </li>
                                    <li<?if($_REQUEST['count'] == 33):?> class="current"<?endif;?>>
                                        <a class="options-item" href="<?= $APPLICATION->GetCurPageParam("count=33", array("count")); ?>">33</a>
                                    </li>
                                    <li<?if($_REQUEST['count'] == 45):?> class="current"<?endif;?>>
                                        <a class="options-item" href="<?= $APPLICATION->GetCurPageParam("count=45", array("count")); ?>">45</a>
                                    </li>
                                    <li<?if($_REQUEST['count'] == 90):?> class="current"<?endif;?>>
                                        <a class="options-item" href="<?= $APPLICATION->GetCurPageParam("count=90", array("count")); ?>">90</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="shop-select-buttons">
                        <button class="filters-btn dark-button-sm"><span>Фильтры</span></button>
                        <button class="cansel-filters"><span>Очистить</span></button>
                    </div>
                </div>
                <div class="options">
                    <?
                    $sort_shows = "shows";
                    $sort_price = "CATALOG_PRICE_1";
                    $sort_name = "id";
                    ?>
                    <a class="options-item <?= CatalogSort($_REQUEST['order']) . CatalogSortActive($_REQUEST['sort'], $sort_shows) ?>"
                       href="<?= $APPLICATION->GetCurPageParam("sort=" . $sort_shows . "&order=" . CatalogSort($_REQUEST['order']), array("sort", "order")); ?>">
                        По популярности
                        <svg width="10" height="5" class="icon"><use xlink:href="#triangle-down"></use></svg><span>|</span>
                    </a>
                    <a class="options-item <?= CatalogSort($_REQUEST['order']) . CatalogSortActive($_REQUEST['sort'], $sort_price) ?>"
                       href="<?= $APPLICATION->GetCurPageParam("sort=" . $sort_price . "&order=" . CatalogSort($_REQUEST['order']), array("sort", "order")); ?>">
                        По цене
                        <svg width="10" height="5" class="icon"><use xlink:href="#triangle-down"></use></svg><span>|</span>
                    </a>
                    <a class="options-item <?= CatalogSort($_REQUEST['order']) . CatalogSortActive($_REQUEST['sort'], $sort_name) ?>"
                       href="<?= $APPLICATION->GetCurPageParam("sort=" . $sort_name . "&order=" . CatalogSort($_REQUEST['order']), array("sort", "order")); ?>">
                        По дате
                        <svg width="10" height="5" class="icon"><use xlink:href="#triangle-down"></use></svg>
                    </a>
                </div>
            </div>
            <?$intSectionID = $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "catalog",
                array(
                    "AJAX_MODE" => "Y",
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "ELEMENT_SORT_FIELD2" => $sort,
                    "ELEMENT_SORT_ORDER2" => $_REQUEST['order'],
                    "ELEMENT_SORT_FIELD" => $_REQUEST['sort'],
                    "ELEMENT_SORT_ORDER" => $_REQUEST['order'],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "MESSAGE_404" => $arParams["~MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                    "PAGE_ELEMENT_COUNT" => $_REQUEST["count"],
                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                    "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                    "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

                    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                    "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                    'LABEL_PROP' => $arParams['LABEL_PROP'],
                    'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                    'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                    'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                    'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                    'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                    'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                    'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                    'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                    'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                    'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                    'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                    'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                    'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                    'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                    'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                    'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                    'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                    'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                    'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                    'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                    'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                    'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                    'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                    "ADD_SECTIONS_CHAIN" => "N",
                    'ADD_TO_BASKET_ACTION' => $basketAction,
                    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                    'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                    'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                    'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                    'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                ),
                $component
            );
            ?>
        </div>
    </div>
</section>

<div class="burger-filter-nav">
    <div class="burger-filter-nav-title">
        <h4>Фильтры</h4>
        <div class="close-burger-filters">
            <svg width="14" height="14" class="icon"><use xlink:href="#times"></use></svg>
        </div>
    </div>

    <div class="filter-all filter-all-up filter-all-burger-up">
        <svg width="22" height="14" class="icon filter-all-svg-burger-up"><use xlink:href="#double-angle-down"></use></svg>
    </div>

    <nav class="filters">
        <div class="filter">
            <div class="filter-name">
                выберите категорию <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
            <ul class="filter-block filter-block-bg">
                <li><a href="#">По брендам<span>7</span></a></li>
                <li><a href="#">Аккумуляторный инструмент <span>14</span></a></li>
                <li><a href="#">Электроинструмент<span>14</span></a></li>
            </ul>
        </div>

        <div class="filter">
            <div class="filter-name">
                Диапазон цен <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
            <div class="filter-block range-slider filter-block-bg">
                <div class="filter__slider">
                    <div class="range__zero"></div>
                    <div id="filter__range-bg"></div>
                </div>
                <div class="wrap">
                    <input id="priceMin-bg" type="text" value="200000" class="input-range">
                    <input id="priceMax-bg" type="text" value="800000" class="input-range">
                    <button>ок</button>
                </div>
            </div>
        </div>

        <div class="filter">
            <div class="filter-name">
                Производитель <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
            <div class="filter-block filter-checkbox filter-block-bg">
                <div class="filter-item">
                    <input type="checkbox" id="one-bg" name="todo" value="todo" data-content="DeWalt">
                    <label for="one-bg"> DeWalt <span>18</span></label>
                </div>

                <div class="filter-item">
                    <input type="checkbox" id="seven-bg" name="todo" value="todo">
                    <label for="seven-bg"> DeWalt <span></span>846</span></label>
                </div>
            </div>
        </div>

        <div class="filter">
            <div class="filter-name">
                страна производитель <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
            <div class="filter-block filter-checkbox filter-block-bg">
                <div class="filter-item">
                    <input type="checkbox" id="russian-bg" name="todo" value="todo">
                    <label for="russian-bg"> Россия <span>18</span></label>
                </div>

                <div class="filter-item">
                    <input type="checkbox" id="china-bg" name="todo" value="todo">
                    <label for="china-bg"> Китай <span>38</span></label>
                </div>

            </div>
        </div>

        <div class="filter">
            <div class="filter-name">
                Параметры <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
            <div class="filter-block filter-checkbox filter-block-bg">
                <div class="filter-item">
                    <input type="checkbox" id="param-one-bg" name="todo" value="todo">
                    <label for="param-one-bg"> Сверление с ударом <span>43</span></label>
                </div>


            </div>
        </div>

        <div class="filter">
            <div class="filter-name">
                Поиск по тегам <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
            <div class="filter-block filter-tags filter-block-bg">
                <div class="tags-block">
                    <a href="#" class="tags-block_item active">Сервис</a>
                    <a href="#" class="tags-block_item">Гарантия</a>

                </div>
            </div>
        </div>
    </nav>

    <div class="filter-all filter-all-burger">
        <svg width="22" height="14" class="icon filter-all-svg-burger"><use xlink:href="#double-angle-down"></use></svg>
    </div>
</div>
<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/local/templates/dcut/include_areas/tabsProduct.php",
        "AREA_FILE_SUFFIX" => "",
        "AREA_FILE_RECURSIVE" => "Y",
        "EDIT_TEMPLATE" => ""
    )
);?>


<?/* if ($isFilter): ?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter",
        "catalog",
        array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" => $arCurSection['ID'],
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "SAVE_IN_SESSION" => "N",
            "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
            "XML_EXPORT" => "N",
            "SECTION_TITLE" => "NAME",
            "SECTION_DESCRIPTION" => "DESCRIPTION",
            'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
            "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            "SEF_MODE" => $arParams["SEF_MODE"],
            "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
            "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
            "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
            "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
        ),
        $component,
        array('HIDE_ICONS' => 'Y')
    );
    ?>
<? endif*/ ?>