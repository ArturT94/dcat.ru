<?$arTabs = array(
    array(
        'NAME'=>'Эксклюзив B2B',
        'CODE'=>'PROPERTY_EXCLUSIVE'
    ),
    array(
        'NAME'=>'Новинки',
        'CODE'=>'PROPERTY_NEW'
    ),
    array(
        'NAME'=>'Популярные',
        'CODE'=>'PROPERTY_POPULAR'
    ),
    array(
        'NAME'=>'Распродажи',
        'CODE'=>'PROPERTY_SEASONAL'
    ),
);?>
<section class="products">
    <div class="products-container">
        <div class="tabs-container">
            <nav class="products-tabs">
                <ul class="products-ul-nav">
                    <?foreach($arTabs as $key=>$tab):?>
                        <li rel="tab<?=$key?>"<?if($key == 0):?> class="active"<?endif;?>><button><?=$tab['NAME']?></button></li>
                    <?endforeach;?>
                </ul>
            </nav>
            <?/*a href="category.html" class="seeAll">Смотреть все</a*/?>
        </div>
    </div>
    <div class="products-container">
        <?foreach($arTabs as $key=>$tab):?>
            <div class="products-mobile-head<?if($key == 0):?> active<?endif;?>" rel="tab<?=$key?>">
                <div class="products-mobile-title">
                    <?=$tab['NAME']?> <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                </div>
                <?/*a href="category.html" class="seeAll">Смотреть все</a*/?>
            </div>
            <!-- ПЕРВЫЙ СЛАЙЕР -->
            <?
            global $arfilter;
            foreach($arTabs as $tab2){
                if(!$tab2['CODE'] != $tab['CODE']){
                    unset($arfilter[$tab2['CODE']]);
                }
            }
            $arfilter[$tab['CODE']] = '1';
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "productsTabs",
                array(
                    "KEY" => $key,
                    "ACTION_VARIABLE" => "action",
                    "ADD_PICT_PROP" => "-",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
                    "BASKET_URL" => "/personal/basket.php",
                    "BRAND_PROPERTY" => "BRAND_REF",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPATIBLE_MODE" => "Y",
                    "CONVERT_CURRENCY" => "Y",
                    "CURRENCY_ID" => "RUB",
                    "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                    "DATA_LAYER_NAME" => "dataLayer",
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "PROPERTY_SORT",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "ENLARGE_PRODUCT" => "PROP",
                    "ENLARGE_PROP" => "-",
                    "FILTER_NAME" => "arfilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => CATALOG_IBLOCK_ID,
                    "IBLOCK_TYPE" => "catalog",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "LABEL_PROP" => array(
                    ),
                    "LABEL_PROP_MOBILE" => "",
                    "LABEL_PROP_POSITION" => "top-left",
                    "LAZY_LOAD" => "N",
                    "LINE_ELEMENT_COUNT" => "3",
                    "LOAD_ON_SCROLL" => "N",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_CART_PROPERTIES" => array(
                        0 => "ARTNUMBER",
                        1 => "COLOR_REF",
                        2 => "SIZES_SHOES",
                        3 => "SIZES_CLOTHES",
                    ),
                    "OFFERS_FIELD_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "OFFERS_LIMIT" => "5",
                    "OFFERS_PROPERTY_CODE" => array(
                        0 => "COLOR_REF",
                        1 => "SIZES_SHOES",
                        2 => "SIZES_CLOTHES",
                        3 => "",
                    ),
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
                    "OFFER_TREE_PROPS" => array(
                        0 => "COLOR_REF",
                        1 => "SIZES_SHOES",
                        2 => "SIZES_CLOTHES",
                    ),
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "",
                    "PAGE_ELEMENT_COUNT" => "12",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
                    "PRODUCT_DISPLAY_MODE" => "Y",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPERTIES" => array(
                        0 => "NEWPRODUCT",
                        1 => "MATERIAL",
                    ),
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "",
                    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'6','BIG_DATA':false},{'VARIANT':'6','BIG_DATA':false}]",
                    "PRODUCT_SUBSCRIPTION" => "Y",
                    "PROPERTY_CODE" => array(
                        0 => "NEWPRODUCT",
                        1 => "",
                    ),
                    "PROPERTY_CODE_MOBILE" => "",
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                    "RCM_TYPE" => "personal",
                    "SECTION_CODE" => "",
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                        2 => "",
                        3 => "",
                    ),
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "Y",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "Y",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "COMPONENT_TEMPLATE" => "productsTabs",
                    "DISPLAY_COMPARE" => "N"
                ),
                false
            );
            ?>
        <?endforeach;?>
    </div>
</section>