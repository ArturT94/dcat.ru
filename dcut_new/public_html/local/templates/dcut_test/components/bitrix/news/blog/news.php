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

<section class="blog">
    <div class="blog-container container-fluid">
        <div class="flex">
            <div class="blog-sidebar">
                <form action="">
                    <input type="text" name="search" placeholder="Поиск в новостях">
                    <button>
                        <svg class="icon"><use xlink:href="#search"></use></svg>
                    </button>
                </form>

                <?/*div class="facebook">
                    <div class="facebook-title">Мы в Facebook</div>
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fsensusco%2F&tabs=timeline%2C%20events%2C%20messages&width=300&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="300" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                </div>

                <div class="lastNews">
                    <div class="lastNews-title">Последние новости</div>

                    <div class="lastNews-block">
                        <a href="blog-single.html" class="news-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/news-1.webp" alt="img">
                            <svg width="27" height="27" class="icon last-news-hover-link"><use xlink:href="#zoom-in"></use></svg>
                        </a>
                        <div class="news-descr">
                            <div class="news-descr_text"><a href="blog-single.html">Dcut заключил прямой эксклюзивный контракт со StanleyBlack&Decker</a></div>
                            <div class="news-descr_info">
                                <div class="news-descr_info_date">
                                    <div class="img">
                                        <svg width="12" height="12" class="icon"><use xlink:href="#calendar"></use></svg>
                                    </div>
                                    <strong> 07.01.2018 </strong>
                                </div>
                                <span>|</span>
                                <div class="news-descr_info_comment">
                                    <div class="img">
                                        <svg width="12" height="12" class="icon"><use xlink:href="#comment"></use></svg>
                                    </div>
                                    <strong>12</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lastNews-block">
                        <a href="blog-single.html" class="news-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/news-2.webp" alt="img">
                            <svg width="27" height="27" class="icon last-news-hover-link"><use xlink:href="#zoom-in"></use></svg>
                        </a>
                        <div class="news-descr">
                            <div class="news-descr_text"><a href="blog-single.html">Преимущества электроинструмента DeWalt</a></div>

                            <div class="news-descr_info">
                                <div class="news-descr_info_date">
                                    <div class="img">
                                        <svg width="12" height="12" class="icon"><use xlink:href="#calendar"></use></svg>
                                    </div>
                                    <strong> 07.01.2018 </strong>
                                </div>
                                <span>|</span>
                                <div class="news-descr_info_comment">
                                    <div class="img">
                                        <svg width="12" height="12" class="icon"><use xlink:href="#comment"></use></svg>
                                    </div>
                                    <strong>12</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lastNews-block">
                        <a href="blog-single.html" class="news-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/news-3.webp" alt="img">
                            <svg width="27" height="27" class="icon last-news-hover-link"><use xlink:href="#zoom-in"></use></svg>
                        </a>
                        <div class="news-descr">
                            <div class="news-descr_text"><a href="blog-single.html">Dcut - новое имя на рынке абразивного инструмента</a></div>

                            <div class="news-descr_info">
                                <div class="news-descr_info_date">
                                    <div class="img">
                                        <svg width="12" height="12" class="icon"><use xlink:href="#calendar"></use></svg>
                                    </div>
                                    <strong> 07.01.2018 </strong>
                                </div>
                                <span>|</span>
                                <div class="news-descr_info_comment">
                                    <div class="img">
                                        <svg width="12" height="12" class="icon"><use xlink:href="#comment"></use></svg>
                                    </div>
                                    <strong>12</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="blog.html" class="lastNews-link">Все новости <svg width="10" height="9" class="icon insta-link-arrows"><use xlink:href="#double-angle-right"></use></svg></a>
                </div*/?>

                <?/*div class="tags">
                    <div class="tags-title">Поиск по тегам</div>
                    <div class="tags-block">
                        <a href="#" class="tags-block_item active">Сервис</a>
                        <a href="#" class="tags-block_item">Гарантия</a>
                        <a href="#" class="tags-block_item">Stanley</a>
                        <a href="#" class="tags-block_item">Инструмент</a>
                        <a href="#" class="tags-block_item active">Эксклюзив B2B</a>
                        <a href="#" class="tags-block_item">Консалтинг</a>
                        <a href="#" class="tags-block_item">Гарантия</a>
                        <a href="#" class="tags-block_item">Dcut</a>
                    </div>
                </div*/?>

                <div class="feedback feedback-block-callback">
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
                </div>
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
        </div>
    </div>
</section>
<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/local/templates/dcut/include_areas/tabsProduct.php",
        "AREA_FILE_SUFFIX" => "",
        "AREA_FILE_RECURSIVE" => "Y",
        "EDIT_TEMPLATE" => ""
    )
);?>