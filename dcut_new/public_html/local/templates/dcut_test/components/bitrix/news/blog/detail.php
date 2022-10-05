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
        <div class="blog-container">
            <div class="flex">
                <div class="blog-sidebar">
                    <form action="">
                        <input type="text" name="search" placeholder="Поиск в новостях">
                        <button>
                            <svg class="icon"><use xlink:href="#search"></use></svg>
                        </button>
                    </form>

                    <div class="insta">
                        <div class="insta-title">Мы в Instagram</div>
                        <div class="insta-grid row insta-row">
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-1.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-2.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-3.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-4.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-5.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-6.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-7.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-8.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                            <div class="insta-grid-item col-4 insta-col">
                                <a href="https://www.instagram.com" target="blank">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/insta-9.webp" alt="img">
                                    <svg class="icon insta-grid-item-hover-img"><use xlink:href="#zoom-in"></use></svg>
                                </a>
                            </div>
                        </div>

                        <a href="https://www.instagram.com/rudovanata/?hl=ru" target="blank" class="insta-link">
                            <svg width="12" height="12" class="icon"><use xlink:href="#instagram"></use></svg> Смотреть профиль <svg width="10" height="9" class="icon insta-link-arrows"><use xlink:href="#double-angle-right"></use></svg>
                        </a>
                    </div>

                    <div class="facebook">
                        <div class="facebook-title">Мы в Facebook</div>
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fsensusco%2F&tabs=timeline%2C%20events%2C%20messages&width=300&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="300" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                    </div>

                    <div class="lastNews">
                        <div class="lastNews-title">Последние новости</div>

                        <div class="lastNews-block">
                            <a href="/blog/" class="news-img">
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
                            <a href="/blog/" class="news-img">
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
                            <a href="/blog/" class="news-img">
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

                        <a href="/blog/" class="lastNews-link">Все новости <svg width="10" height="9" class="icon insta-link-arrows"><use xlink:href="#double-angle-right"></use></svg></a>
                    </div>

                    <div class="tags">
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
                    </div>

                    <div class="feedback">
                        <div class="feedback-title">Обратная связь</div>
                        <div class="feedback-block">
                            <a href="/contacts/" class="feedback-img feedback-img-dark-overflow">
                                <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/blog/communication.webp" alt="img">
                                <svg width="27" height="27" class="icon last-news-hover-link"><use xlink:href="#zoom-in"></use></svg>
                            </a>
                            <div class="feedback-info">
                                <a href="/contacts/" class="feedback-info_text">Задайте вопрос, оставьте заявку или закажите обратный звонок</a>
                                <a href="/contacts/" class="feedback-info_link">Задать вопрос <svg width="10" height="9" class="icon"><use xlink:href="#double-angle-right"></use></svg></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blog-content">
                    <form action="#" class="search-form">
                        <input type="text" name="search" placeholder="Поиск в новостях">
                        <button>
                            <svg width="19" height="19" class="icon"><use xlink:href="#search"></use></svg>
                        </button>
                    </form>

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

                    <div class="blog-content_social">
                        <div class="content-news_info__share">
                            <div class="info-share__comment">
                                <div class="img">
                                    <svg width="13" height="13" class="icon"><use xlink:href="#comment"></use></svg>
                                </div>
                                <strong>50674</strong>
                            </div>

                            <span>|</span>

                            <div class="info-share__likes">
                                <div class="img">
                                    <svg width="13" height="13" class="icon"><use xlink:href="#share-liked"></use></svg>
                                </div>
                                <strong>21062</strong>
                            </div>
                            <span>|</span>

                            <div class="info-share__links">
                                <div class="img">
                                    <svg width="13" height="13" class="icon"><use xlink:href="#share-link"></use></svg>
                                </div>
                                <strong>99053</strong>
                                <!-- Tooltip -->
                                <div class="tooltip-blog">
                                    <a href="https://vk.com/id32079140" target="blank">
                                        <svg width="19" height="19" class="icon"><use xlink:href="#vk-square"></use></svg>
                                    </a>
                                    <a href="https://www.youtube.com/channel/UCnlsBWvqXj4jVgXYODOkWXQ" target="blank">
                                        <svg width="20" height="19" class="icon"><use xlink:href="#youtube-square"></use></svg>
                                    </a>
                                    <a href="https://www.facebook.com/rudovaa" target="blank">
                                        <svg width="20" height="19" class="icon"><use xlink:href="#facebook-square"></use></svg>
                                    </a>
                                    <a href="https://www.instagram.com/rudovanata/?hl=ru" target="blank">
                                        <svg width="20" height="19" class="icon"><use xlink:href="#instagram-square"></use></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="blog-content_social__links">
                            <a href="https://www.instagram.com/rudovanata/?hl=ru" target="blank">
                                <svg width="13" height="13" class="icon"><use xlink:href="#instagram-alt"></use></svg>
                            </a>
                            <a href="https://www.facebook.com/rudovaa" target="blank">
                                <svg width="13" height="13" class="icon"><use xlink:href="#facebook"></use></svg>
                            </a>
                            <a href="https://vk.com/id32079140" target="blank">
                                <svg width="13" height="13" class="icon"><use xlink:href="#vk"></use></svg>
                            </a>
                            <a href="https://telegram.org/" target="blank">
                                <svg width="13" height="13" class="icon"><use xlink:href="#telegram"></use></svg>
                            </a>
                            <a href="mailto:info@dcut.ru" target="blank">
                                <svg width="13" height="13" class="icon"><use xlink:href="#envelope"></use></svg>
                            </a>
                        </div>
                    </div>

                    <div class="comments-all">
                        <div class="comment">
                            <div class="who">
                                <div class="who-img"> <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/about-us/incognito.svg" alt="img"></div>
                                <div class="who-info">
                                    <div class="who-user">
                                        <div class="who-user_name">
                                            <a class="who-user_name__icon" target="blank" href="https://vk.com/id32079140">
                                                <svg width="17" height="17" class="icon"><use xlink:href="#vk"></use></svg>
                                            </a>
                                            <a class="who-user_name__name" target="blank" href="https://vk.com/id32079140">Александра Гандрабура</a>
                                        </div>
                                        <div class="who-user_date">18 Июня 2019 <span>|</span> 09:26</div>
                                    </div>
                                    <a href="#link1" class="who-user_link" data-toggle="tooltip" data-placement="bottom" title="ответить Александре">
                                        <svg width="24" height="24" class="icon"><use xlink:href="#telegram-alt"></use></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="what">Идейные соображения высшего порядка, а также постоянное
                                информационно-пропагандистское обеспечение нашей деятельности требуют определения и
                                уточнения соответствующий условий активизации. Таким образом постоянный
                                количественный рост иной работы по формированию позиции играет важную роль в
                                формировании дальнейших направлений развития.</div>
                        </div>

                        <div class="comment">
                            <div class="who">
                                <div class="who-img"> <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/about-us/incognito.svg" alt="img"></div>
                                <div class="who-info">
                                    <div class="who-user">
                                        <div class="who-user_name">
                                            <a class="who-user_name__icon" target="blank" href="https://vk.com/id32079140">
                                                <svg width="17" height="17" class="icon"><use xlink:href="#vk"></use></svg>
                                            </a>
                                            <a class="who-user_name__name" target="blank" href="https://vk.com/id32079140">Александра Гандрабура</a>
                                        </div>
                                        <div class="who-user_date">18 Июня 2019 <span>|</span> 09:26</div>
                                    </div>
                                    <a href="#link1" class="who-user_link" data-toggle="tooltip" data-placement="bottom" title="ответить Александре">
                                        <svg width="24" height="24" class="icon"><use xlink:href="#telegram-alt"></use></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="what">Идейные соображения высшего порядка, а также постоянное
                                информационно-пропагандистское обеспечение нашей деятельности требуют определения и
                                уточнения соответствующий условий активизации. Таким образом постоянный
                                количественный рост иной работы по формированию позиции играет важную роль в
                                формировании дальнейших направлений развития.</div>
                        </div>

                        <div class="comment">
                            <div class="who">
                                <div class="who-img"> <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/about-us/incognito.svg" alt="img"></div>
                                <div class="who-info">
                                    <div class="who-user">
                                        <div class="who-user_name">
                                            <a class="who-user_name__icon" target="blank" href="https://vk.com/id32079140">
                                                <svg width="17" height="17" class="icon"><use xlink:href="#vk"></use></svg>
                                            </a>
                                            <a class="who-user_name__name" target="blank" href="https://vk.com/id32079140">Александра Гандрабура</a>
                                        </div>
                                        <div class="who-user_date">18 Июня 2019 <span>|</span> 09:26</div>
                                    </div>
                                    <a href="#link1" class="who-user_link" data-toggle="tooltip" data-placement="bottom" title="ответить Александре">
                                        <svg width="24" height="24" class="icon"><use xlink:href="#telegram-alt"></use></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="what">Идейные соображения высшего порядка, а также постоянное
                                информационно-пропагандистское обеспечение нашей деятельности требуют определения и
                                уточнения соответствующий условий активизации. Таким образом постоянный
                                количественный рост иной работы по формированию позиции играет важную роль в
                                формировании дальнейших направлений развития.</div>
                        </div>

                        <div class="comment">
                            <div class="who">
                                <div class="who-img"> <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/about-us/incognito.svg" alt="img"></div>
                                <div class="who-info">
                                    <div class="who-user">
                                        <div class="who-user_name">
                                            <a class="who-user_name__icon" target="blank" href="https://vk.com/id32079140">
                                                <svg width="17" height="17" class="icon"><use xlink:href="#vk"></use></svg>
                                            </a>
                                            <a class="who-user_name__name" target="blank" href="https://vk.com/id32079140">Александра Гандрабура</a>
                                        </div>
                                        <div class="who-user_date">18 Июня 2019 <span>|</span> 09:26</div>
                                    </div>
                                    <a href="#link1" class="who-user_link" data-toggle="tooltip" data-placement="bottom" title="ответить Александре">
                                        <svg width="24" height="24" class="icon"><use xlink:href="#telegram-alt"></use></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="what">Идейные соображения высшего порядка, а также постоянное
                                информационно-пропагандистское обеспечение нашей деятельности требуют определения и
                                уточнения соответствующий условий активизации. Таким образом постоянный
                                количественный рост иной работы по формированию позиции играет важную роль в
                                формировании дальнейших направлений развития.</div>
                        </div>
                    </div>

                    <form action="" class="comment-form" id="link1">
                        <div class="form-title">Оставьте комментарий</div>
                        <div class="form-subtitle">Конфиденциальность ваших контактных данных гарантируется</div>
                        <div class="form-contact">
                            <input type="text" placeholder="Ваше имя*">
                            <input type="text" placeholder="Ваш телефон или E-mail*">
                        </div>
                        <textarea rows="" cols="" placeholder="Текст сообщения"></textarea>
                        <div class="comment-form-control">
                            <button class="control_button dark-button"><span>Опубликовать</span></button>
                            <div class="control_label">
                                <label class="checkbox path">
                                    <input type="checkbox">
                                    <svg viewBox="0 0 21 21"><path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186"></path></svg>
                                </label>
                                <div>Я не робот</div>
                            </div>
                        </div>
                    </form>
                </div>
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