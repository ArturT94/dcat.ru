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
                $arSelect = Array("ID", "NAME", "CODE");
                $arFilter = Array("IBLOCK_ID" => SERVICES_IBLOCK_ID, "ACTIVE" => "Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                while ($ob = $res->Fetch()) {
                    $arServicesList[] = $ob;
                }
            }
            ?>
            <?php if($arServicesList):?>
                <nav>
                    <ul>
                        <?foreach($arServicesList as $key=>$servicesItem):?>
                            <li id="serv0<?=($key+1)?>" class="other-tab">
                                <a href="/services/<?=$servicesItem["CODE"]?>/">
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

        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "",
            Array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "NEWS_COUNT" => $arParams["NEWS_COUNT"],
                "SORT_BY1" => $arParams["SORT_BY1"],
                "SORT_ORDER1" => $arParams["SORT_ORDER1"],
                "SORT_BY2" => $arParams["SORT_BY2"],
                "SORT_ORDER2" => $arParams["SORT_ORDER2"],
                "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                "SET_TITLE" => $arParams["SET_TITLE"],
                "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                "MESSAGE_404" => $arParams["MESSAGE_404"],
                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                "SHOW_404" => $arParams["SHOW_404"],
                "FILE_404" => $arParams["FILE_404"],
                "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                "CHECK_DATES" => $arParams["CHECK_DATES"],
            ),
            $component
        );?>
</section>
<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/local/templates/dcut/include_areas/tabsProduct.php",
        "AREA_FILE_SUFFIX" => "",
        "AREA_FILE_RECURSIVE" => "Y",
        "EDIT_TEMPLATE" => ""
    )
);?>