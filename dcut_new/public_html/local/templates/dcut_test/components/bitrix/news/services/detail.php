<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<section class="services">
    <div class="services-container">
        <div class="services-one">
            <?
                if(CModule::IncludeModule('iblock')) {
                    $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
                    $arFilter = Array("IBLOCK_ID" => SERVICES_IBLOCK_ID, "ACTIVE" => "Y");
                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                    while ($ob = $res->GetNext()) {
                        $arServicesList[] = $ob;
                    }
                }
            ?>
            <?php if($arServicesList):?>
                <nav>
                    <ul>
                        <?foreach($arServicesList as $key=>$servicesItem):?>
                            <li id="serv0<?=($key+1)?>" class="other-tab">
                                <a href="<?=$servicesItem["DETAIL_PAGE_URL"]?>">
                                    <span><?=$servicesItem["NAME"]?></span>
                                    <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                                </a>
                            </li>
                        <?endforeach;?>
                    </ul>
                </nav>
            <? endif; ?>

            <?$APPLICATION->IncludeComponent("bitrix:main.include","",array("AREA_FILE_SHOW" => "file","AREA_FILE_SUFFIX" => "inc","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => "","COMPONENT_TEMPLATE" => ".default","PATH" => "/local/templates/dcut/include_areas/left_sidebar.php"),false);?>

        </div>

        <!-- Content -->
        <div class="services-tabs">
            <?$ElementID = $APPLICATION->IncludeComponent(
                "bitrix:news.detail",
                "",
                Array(
                    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                    "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
                    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
                    "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "META_KEYWORDS" => $arParams["META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
                    "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
                    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                    "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
                    "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                    "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
                    "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                    "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
                    "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                    "USE_SHARE" => $arParams["USE_SHARE"],
                    "SHARE_HIDE" => $arParams["SHARE_HIDE"],
                    "SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
                    "SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
                    "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                    "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                    "ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
                    'STRICT_SECTION_CHECK' => (isset($arParams['STRICT_SECTION_CHECK']) ? $arParams['STRICT_SECTION_CHECK'] : ''),
                ),
                $component
            );?>

            <!-- Обратная связь -->
            <div class="feedback screen-sm">
                <div class="feedback-title">Обратная связь</div>
                <div class="feedback-block">
                    <div class="feedback-img feedback-img-dark-overflow">
                        <img src="img/blog/communication.jpg" alt="img">
                        <a class="last-news-hover-link" href="#">
                            <svg width="27" height="27" class="icon"><use xlink:href="#zoom-in"></use></svg>
                        </a>
                    </div>
                    <div class="feedback-info">
                        <div class="feedback-info_text">Задайте вопрос, оставьте заявку или закажите обратный звонок</div>
                        <a href="contacts.html" class="feedback-info_link">
                            Задать вопрос
                            <svg width="10" height="8" class="icon"><use xlink:href="#angle-right"></use></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="descr">
    <div class="counter counter-services">
        <!-- Счетчик -->
        <div class="counter_container">
            <div class="counter-row">
                <div class="counter-column">
                    <div class="counter_item">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH" => "/local/templates/dcut/include_areas/company_achievement_1.php"
                            ),
                            false
                        );?>
                    </div>
                </div>
                <div class="counter-column">
                    <div class="counter_item">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH" => "/local/templates/dcut/include_areas/company_achievement_2.php"
                            ),
                            false
                        );?>
                    </div>
                </div>
                <div class="counter-column">
                    <div class="counter_item">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH" => "/local/templates/dcut/include_areas/company_achievement_3.php"
                            ),
                            false
                        );?>
                    </div>
                </div>
                <div class="counter-column">
                    <div class="counter_item">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH" => "/local/templates/dcut/include_areas/company_achievement_4.php"
                            ),
                            false
                        );?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="descr-more">
        <!-- Узнать больше -->
        <div class="descr-more-container">
            <div class="descr-more_item">
                <div class="descr-more-polygon"></div>
                <div class="descr-more_item__text">Чтобы узнать больше, обратитесь к нам за
                    <span>бесплатной</span> консультацией</div>
            </div>
            <div class="descr-more_item">
                <button class="descr-more_item__button consult-modal">Заказать консультацию</button>
            </div>
        </div>
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