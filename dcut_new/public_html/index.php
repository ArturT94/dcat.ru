<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("DCUT");
CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME", "PROPERTY_ICON", "PROPERTY_HOVER", "PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID"=>12, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->Fetch()) {
    $arUnique[] = $ob;
}
?>
<?if($arUnique):?>
    <section class="coin">
        <div class="container-title">
            <div class="coin-title section-title"><span>Уникальные сервисы DCUT</span></div>
        </div>
        <div class="coin-container container-fluid">
            <div class="row coin-row">
                <?foreach($arUnique as $unique):?>
                    <div class="coin-col">
                        <div class="coin-item">
                            <div class="img">
                                <?if($unique['PROPERTY_ICON_VALUE']):?>
                                    <img class="coin-img" src="<?=CFile::GetPath($unique['PROPERTY_ICON_VALUE']);?>">
                                <?endif;?>
                                <?if($unique['PROPERTY_HOVER_VALUE']):?>
                                    <img class="coin-img-hover" src="<?=CFile::GetPath($unique['PROPERTY_HOVER_VALUE']);?>">
                                <?endif;?>
                            </div>
                            <p class="coin-text"><?=$unique['PREVIEW_TEXT']?></p>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>

        <!-- 1200px -->
        <div class="coin-container-two container-fluid">
            <div class="row coin-row-two">
                <?foreach($arUnique as $i=>$unique):?>
                    <div class="coin-col-two">
                        <div class="coin-item">
                            <div class="img">
                                <?if($unique['PROPERTY_ICON_VALUE']):?>
                                    <img class="coin-img" src="<?=CFile::GetPath($unique['PROPERTY_ICON_VALUE']);?>">
                                <?endif;?>
                                <?if($unique['PROPERTY_HOVER_VALUE']):?>
                                    <img class="coin-img-hover" src="<?=CFile::GetPath($unique['PROPERTY_HOVER_VALUE']);?>">
                                <?endif;?>
                            </div>
                            <p class="coin-text"><?=$unique['PREVIEW_TEXT']?></p>
                        </div>
                    </div>
                    <?if($i==3):?></div><div class="row coin-row-two"><?endif;?>
                <?endforeach;?>
            </div>
        </div>
    </section>
<?endif;?>
<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/local/templates/dcut/include_areas/tabsProduct.php",
        "AREA_FILE_SUFFIX" => "",
        "AREA_FILE_RECURSIVE" => "Y",
        "EDIT_TEMPLATE" => ""
    )
);?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "projects_slider",
        array(
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "AJAX_MODE" => "N",
            "IBLOCK_TYPE" => "dcut_content",
            "IBLOCK_ID" => "1",
            "NEWS_COUNT" => "20",
            "SORT_BY1" => "ID",
            "SORT_ORDER1" => "ASC",
            "SORT_BY2" => "SORT",
            "SORT_ORDER2" => "ASC",
            "FILTER_NAME" => "",
            "FIELD_CODE" => array(
                0 => "ID",
                1 => "",
            ),
            "PROPERTY_CODE" => array(
                0 => "",
                1 => "WEBP",
                2 => "",
            ),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "SET_TITLE" => "N",
            "SET_BROWSER_TITLE" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_LAST_MODIFIED" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "INCLUDE_SUBSECTIONS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "SET_STATUS_404" => "N",
            "SHOW_404" => "N",
            "MESSAGE_404" => "",
            "PAGER_BASE_LINK" => "",
            "PAGER_PARAMS_NAME" => "arrPager",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "COMPONENT_TEMPLATE" => "projects_slider",
            "STRICT_SECTION_CHECK" => "N"
        ),
        false
    );?>

<?
if(CModule::IncludeModule('iblock')) {
    $arSelect = Array("ID", "NAME", "PROPERTY_SVG");
    $arFilter = Array("IBLOCK_ID" => PARTNERS_IBLOCK_ID, "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->Fetch()) {
        $arPartners[] = $ob;
    }
}
?>

<?php if($arPartners):?>
    <section class="partners">
        <div class="partners-container">
            <div class="partners-title">
                <div class="ourPartners">Наши партнеры</div>
                <a href="/about/" class="seeAll">Смотреть все</a>
            </div>

            <div class="partners-slider">
                <?foreach($arPartners as $key=>$slide):?>
                    <div class="partners-slide">
                        <div class="partners-slides_img">
                            <?if($slide['PROPERTY_SVG_VALUE']):?>
                                <img src="<?=CFile::GetPath($slide['PROPERTY_SVG_VALUE']);?>" alt="<?=$slide['NAME']?>">
                            <?endif;?>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </section>
<?endif;?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>