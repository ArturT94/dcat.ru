<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)  die();
IncludeTemplateLangFile(__FILE__);
global $APPLICATION;
use Bitrix\Main\Page\Asset;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
<head>
    <title><? $APPLICATION->ShowTitle(); ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <? Asset::getInstance()->addCss("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
    Asset::getInstance()->addCss("https://fonts.googleapis.com/css?family=Montserrat:400,500&display=swap");
    Asset::getInstance()->addCss("https://fonts.googleapis.com/css?family=Roboto:300&display=swap");

    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/bootstrap.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/font-awesome-5.12.0-all.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/jquery-ui-themes-base.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/slick.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/slick-theme.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/reset.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/baguette.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/demo.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/custom.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/style-correct.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/jquery.fancybox.min.css");
    Asset::getInstance()->addCss("https://fonts.googleapis.com/css?family=Montserrat:400,500&display=swap");
    Asset::getInstance()->addCss("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap");

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/modernizr.custom.79639.js");

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery-1.12.4.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.form.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.maskedinput.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/prForm.js');

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery-ui.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/popper.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/bootstrap.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/slick.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/radial-progress-bar.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/zoomsl-3.0.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/baguette.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/rating-stars.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/range-slider.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/select-customize.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery.scrollbar.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery.slitslider.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/counter.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery.spincrement.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/headhesive.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery.ba-cond.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery.fancybox.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/main.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/form_script.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/ajax/ajaxForm.js");

    //Asset::getInstance()->addJs( "https://spikmi.com/Widget?id=3124");
    $APPLICATION->ShowHead();
    ?>
    <?$GLOBALS["PAGE"] = explode("/", $APPLICATION->GetCurPage());
	foreach($GLOBALS["PAGE"] as $k=>$page){if($page == 'index.php'){unset($GLOBALS['PAGE'][$k]);}}?>
</head>
<body>
	<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
    <header class="<?if($GLOBALS['PAGE'][1] != '' && $GLOBALS['PAGE'][1] != 'dealer'):?>static-page <?
    elseif($GLOBALS['PAGE'][1] == 'catalog'):?>header-category <?
    elseif($GLOBALS['PAGE'][1] == 'about'):?>header-about-us <?
    elseif($GLOBALS['PAGE'][1] == 'conditions'):?>header-conditions <?
    elseif($GLOBALS['PAGE'][1] == 'services'):?>header-services <?
    elseif($GLOBALS['PAGE'][1] == 'contacts'):?>header-contacts <?
    elseif($GLOBALS['PAGE'][1] == 'blog'):?>header-blog <?
    elseif($GLOBALS['PAGE'][1] == 'projects'):?>header-projects<?
    elseif($GLOBALS['PAGE'][1] == 'dealer'):?>profile-page
    <?endif;?>
        <?if($GLOBALS['PAGE'][1] != ''):?><?=$APPLICATION->GetProperty('CLASS');?> <?=$APPLICATION->GetPageProperty('CLASS');?><?endif;?>">
        <div class="<?if($GLOBALS['PAGE'][1] == ''):?>container-slit demo-1<?endif;?>">
            <div class="codrops-top clearfix">
                <div class="roof">
                    <div class="roof-container">
                        <div class="roof-flex">
                            <div class="flex-item">
                                <?/*div class="item-lang"><a href="#" class="ru active">RU</a> | <a href="#" class="en">EN</a></div*/?>
                                <a href="/contacts/" class="item-address hvr-pulse-shrink">Наш адрес - г. Москва м.Савеловская</a>
                                <div class="item-workHours">
                                    <div class="item-workHours__img"><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/roof/roof-clock.svg" alt="clock"><img></div>
                                    <div class="item-workHours__time">Пн-Пт: 8:00 - 18:00</div>
                                </div>
                            </div>
                            <div class="flex-item">
                                <div class="item-requestACall">
                                    <div class="item-requestACall__img"><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/roof/roof-phone.svg" alt="call"></div>
                                    <div class="item-requestACall__tel">
                                        <a class="hvr-pulse-shrink" href="tel: +7 (499) 444-32-88">+7 (499) 444-32-88</a> |
                                        <a href="/local/ajax/form/callback.php?ajax=y" data-type="ajax" data-fancybox="" data-src="/local/ajax/form/callback.php?ajax=y" class="hvr-underline-from-left-roof">Заказать звонок</a>
                                    </div>
                                </div>
                                <?
                                if($GLOBALS['PAGE'][1] == 'dealer'){
                                    global $USER;
                                    $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), array('ID'=>$USER->GetId()),array('SELECT'=>array('UF_*')));
                                    while($arUser = $rsUsers->Fetch()){
                                        $arCurUser = $arUser;
                                    }
                                    if($arCurUser['UF_GUID']){
                                        $arSelect = Array("ID", "NAME", "PROPERTY_*","PROPERTY_PROP11");
                                        $arFilter = Array("IBLOCK_ID"=>13, "PROPERTY_GUID"=>$arCurUser['UF_GUID'], "ACTIVE"=>"Y");
                                        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                                        while($ob = $res->Fetch()) {
                                            $arCurLk = $ob;
                                        }
                                    }
                                }
                                ?>
                                <div class="item-personalArea">
                                    <div class="item-personalArea__img"><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/roof/roof-man.svg" alt="man"></div>
                                    <a class="hvr-underline-from-left-roof item-personalArea__link" href="/personal/">
                                        <?if($arCurLk):?><?=$arCurLk['NAME']?><?else:?>Личный кабинет<?endif;?>
                                    </a>
                                    <svg  width="10" height="6" class="icon arrow"><use xlink:href="#angle-right"></use></svg>
                                    <div class="hidden">
                                        <ul>
                                            <?global $USER;
                                            if($USER->IsAuthorized()):
                                                CModule::IncludeModule('iblock');
                                                $rsUsers = CUser::GetList(($by="id"), ($order="desc"), array('ID'=>$USER->GetId()),array('SELECT'=>array('UF_*')));
                                                while($arUser = $rsUsers->Fetch()){
                                                    $arCurUser = $arUser;
                                                }
                                                ?>
                                                <?if($arCurUser['UF_GUID']):?>
                                                    <?$APPLICATION->IncludeComponent("bitrix:menu","dealer_head",Array(
                                                            "ROOT_MENU_TYPE" => "dealer",
                                                            "MAX_LEVEL" => "1",
                                                            "CHILD_MENU_TYPE" => "top",
                                                            "USE_EXT" => "Y",
                                                            "DELAY" => "N",
                                                            "ALLOW_MULTI_SELECT" => "Y",
                                                            "MENU_CACHE_TYPE" => "N",
                                                            "MENU_CACHE_TIME" => "3600",
                                                            "MENU_CACHE_USE_GROUPS" => "Y",
                                                            "MENU_CACHE_GET_VARS" => ""
                                                        )
                                                    );?>
                                                <?endif;?>
                                            <?else:?>
                                                <li><a class="!enter-modal" href="/auth/">Войти</a></li>
                                                <li><a class="!register-modal" href="/auth/?register=yes">Регистрация</a></li>
                                            <?endif;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="head-container">
                    <div class="headerLogoSearch">
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/header_logo.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                        <?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"pc", 
	array(
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "title-search",
		"PRICE_CODE" => array(
			0 => "BASE",
			1 => "RETAIL",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "150",
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"PAGE" => "#SITE_DIR#catalog/",
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "3",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "N",
		"CHECK_DATES" => "Y",
		"SHOW_OTHERS" => "Y",
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_iblock_news" => array(
			0 => "all",
		),
		"CATEGORY_1_TITLE" => "Блог",
		"CATEGORY_1" => array(
			0 => "iblock_blog",
		),
		"CATEGORY_1_forum" => array(
			0 => "all",
		),
		"CATEGORY_2_TITLE" => "Категории",
		"CATEGORY_2" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_2_iblock_books" => "all",
		"CATEGORY_OTHERS_TITLE" => "Прочее",
		"COMPONENT_TEMPLATE" => "pc",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "11",
		),
		"CATEGORY_1_iblock_blog" => array(
			0 => "5",
		),
		"CATEGORY_2_iblock_catalog" => array(
			0 => "15",
		),
		"CATEGORY_0_iblock_1c_catalog" => array(
			0 => "all",
		)
	),
	false
);?>

                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/header_btn.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                    </div>
                </div>
                <div class="header">
                    <div class="header-menu">
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/header_logo.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                        <div class="catalog-btn">
                            <a href="/catalog/eksklyuziv-do-2kh-let-bez-zatrat/" class="headerCatalogLink">Перейти в магазин</a>
                        </div>
                        <?/*$APPLICATION->IncludeComponent("bitrix:menu","catalog",Array(
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
                        );*/?>
                        <?$APPLICATION->IncludeComponent("bitrix:menu","header",Array(
                                "ROOT_MENU_TYPE" => "top",
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
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/social.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/header_btn.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                        <div class="burger"><span></span></div>
                    </div>
                </div>
                <div class="clr"></div>
                <?if($GLOBALS['PAGE'][1] != ''):?>
                    <?if($GLOBALS['PAGE'][1] == 'dealer'):
                        if($arCurLk):?>
                            <div class="profile-head-container">
                                <div class="headline" style="padding-bottom: 30px;">
                                    <div class="profile-block-titles">
                                        <div class="profile-title"><h1>Личный кабинет клиента</h1></div>
                                        <div class="profile-subtitle"><h3><?=$arCurLk['NAME']?></h3></div>
                                    </div>
                                    <div class="headline-descr">ИНН <?=$arCurLk['PROPERTY_PROP11_VALUE']?></div>
                                </div>
                            </div>
                        <?else:?>
                            <div class="static-page-title"><h1><?$APPLICATION->ShowTitle()?></h1></div>
                        <?endif;?>
                    <?else:?>
                        <div class="static-page-title"><h1><?$APPLICATION->ShowTitle()?></h1></div>
                    <?endif;?>
                <?endif;?>
            </div>
            <?if(!$GLOBALS['PAGE'][1]):?>
                <?$APPLICATION->IncludeComponent("bitrix:news.list", "mainSlider", Array(
                    "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                        "DISPLAY_NAME" => "Y",	// Выводить название элемента
                        "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                        "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
                        "AJAX_MODE" => "Y",	// Включить режим AJAX
                        "IBLOCK_TYPE" => "dcut_content",	// Тип информационного блока (используется только для проверки)
                        "IBLOCK_ID" => "10",	// Код информационного блока
                        "NEWS_COUNT" => "4",	// Количество новостей на странице
                        "SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
                        "SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
                        "SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
                        "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
                        "FILTER_NAME" => "",	// Фильтр
                        "FIELD_CODE" => array(	// Поля
                            0 => "",
                        ),
                        "PROPERTY_CODE" => array(	// Свойства
                            0 => "NAV_TITLE",
                        ),
                        "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
                        "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                        "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
                        "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
                        "SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
                        "SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
                        "SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
                        "SET_LAST_MODIFIED" => "Y",	// Устанавливать в заголовках ответа время модификации страницы
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// Включать инфоблок в цепочку навигации
                        "ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
                        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",	// Скрывать ссылку, если нет детального описания
                        "PARENT_SECTION" => "",	// ID раздела
                        "PARENT_SECTION_CODE" => "",	// Код раздела
                        "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
                        "CACHE_TYPE" => "A",	// Тип кеширования
                        "CACHE_TIME" => "3600",	// Время кеширования (сек.)
                        "CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
                        "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                        "DISPLAY_TOP_PAGER" => "Y",	// Выводить над списком
                        "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
                        "PAGER_TITLE" => "Новости",	// Название категорий
                        "PAGER_SHOW_ALWAYS" => "Y",	// Выводить всегда
                        "PAGER_TEMPLATE" => "",	// Шаблон постраничной навигации
                        "PAGER_DESC_NUMBERING" => "Y",	// Использовать обратную навигацию
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                        "PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
                        "PAGER_BASE_LINK_ENABLE" => "Y",	// Включить обработку ссылок
                        "SET_STATUS_404" => "",	// Устанавливать статус 404
                        "SHOW_404" => "",	// Показ специальной страницы
                        "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
                        "PAGER_BASE_LINK" => "",	// Url для построения ссылок (по умолчанию - автоматически)
                        "PAGER_PARAMS_NAME" => "arrPager",	// Имя массива с переменными для построения ссылок
                        "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
                        "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
                        "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
                        "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
                    ),
                    false
                );?>
            <?endif;?>
        </div>
        <?if(!$GLOBALS['PAGE'][1]):?>
        <!-- СЛАЙДЕР ДЛЯ МАЛЕНЬКИХ ЭКРАНОВ (700px) -->
        <div class="header-mob">
            <div class="codrops-absolute">
                <div class="hat-container">
                    <div class="headerLogoSearch">
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/header_logo.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/header_btn.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                    </div>
                    <div class="header">
                        <div class="header-menu">
                            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/header_logo.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/social.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/header_btn.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                            <div class="burger"><span></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <?$APPLICATION->IncludeComponent("bitrix:news.list", "mainSlider_mob", Array(
                "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                "DISPLAY_NAME" => "Y",	// Выводить название элемента
                "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
                "AJAX_MODE" => "Y",	// Включить режим AJAX
                "IBLOCK_TYPE" => "dcut_content",	// Тип информационного блока (используется только для проверки)
                "IBLOCK_ID" => "10",	// Код информационного блока
                "NEWS_COUNT" => "4",	// Количество новостей на странице
                "SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
                "SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
                "SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
                "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
                "FILTER_NAME" => "",	// Фильтр
                "FIELD_CODE" => array(	// Поля
                    0 => "",
                ),
                "PROPERTY_CODE" => array(	// Свойства
                    0 => "NAV_TITLE",
                ),
                "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
                "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
                "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
                "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
                "SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
                "SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
                "SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
                "SET_LAST_MODIFIED" => "Y",	// Устанавливать в заголовках ответа время модификации страницы
                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// Включать инфоблок в цепочку навигации
                "ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
                "HIDE_LINK_WHEN_NO_DETAIL" => "Y",	// Скрывать ссылку, если нет детального описания
                "PARENT_SECTION" => "",	// ID раздела
                "PARENT_SECTION_CODE" => "",	// Код раздела
                "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
                "CACHE_TYPE" => "A",	// Тип кеширования
                "CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
                "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                "DISPLAY_TOP_PAGER" => "Y",	// Выводить над списком
                "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
                "PAGER_TITLE" => "Новости",	// Название категорий
                "PAGER_SHOW_ALWAYS" => "Y",	// Выводить всегда
                "PAGER_TEMPLATE" => "",	// Шаблон постраничной навигации
                "PAGER_DESC_NUMBERING" => "Y",	// Использовать обратную навигацию
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                "PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
                "PAGER_BASE_LINK_ENABLE" => "Y",	// Включить обработку ссылок
                "SET_STATUS_404" => "",	// Устанавливать статус 404
                "SHOW_404" => "",	// Показ специальной страницы
                "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
                "PAGER_BASE_LINK" => "",	// Url для построения ссылок (по умолчанию - автоматически)
                "PAGER_PARAMS_NAME" => "arrPager",	// Имя массива с переменными для построения ссылок
                "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
                "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
                "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
                "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
            ),
                false
            );?>
        </div>
        <?endif;?>
    </header>
    <nav class="mobile-nav">
        <div class="mobile-nav__info">
            <div class="logIn">
                <div class="login-icon"><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/mobile-nav/login-icon.svg" alt="img"> </div>
                <?global $USER;
                if($USER->IsAuthorized()):?>
                    <div class="logIn-info">
                        <a href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), [
                              "login",
                              "logout",
                              "register",
                              "forgot_password",
                              "change_password"]
                            );?>">Выход</a>
                    </div>
                <?else:?>
                    <div class="logIn-info">
                        <a class="enter-modal" href="/auth/">Вход</a>
                        <a class="register-modal" href="/auth/?register=yes">Регистрация</a>
                    </div>
                <?endif;?>
            </div>
            <div class="close-burger"><svg width="14" height="14" class="icon"><use xlink:href="#times"></use></svg></div>
        </div>
        <div class="mobile-menu-tabs"><div class="tab active">меню</div><div class="tab">каталог</div></div>
        <?$APPLICATION->IncludeComponent("bitrix:menu","burger_menu",Array(
                "ROOT_MENU_TYPE" => "top",
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
        <div class="mobile-catalog one element mobileMenuCatalog">
            <?$APPLICATION->IncludeComponent("bitrix:menu","catalog_mobile",Array(
                    "ROOT_MENU_TYPE" => "catalog",
                    "MAX_LEVEL" => "3",
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
        </div>
    </nav>
    <div style="display: none">
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.compare.list",
            ".default",
            array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => CATALOG_IBLOCK_ID,
                "NAME" => "CATALOG_COMPARE_LIST",
                "DETAIL_URL" => "",
                "COMPARE_URL" => "/catalog/compare.php",
                "ACTION_VARIABLE" => "",
                "PRODUCT_ID_VARIABLE" => "",
                "POSITION_FIXED" => "N",
                "POSITION" => isset($arParams["COMPARE_POSITION"])?$arParams["COMPARE_POSITION"]:"",
                "COMPONENT_TEMPLATE" => ".default",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => ""
            ),
            false
        );?>
    </div>