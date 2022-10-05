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
<section class="single-project">
    <div class="single-project-container">
        <div class="single-project_title"><?=$arResult["NAME"]?></div>
        <div class="single-project_info">
            <div class="single-project_info__img">
                <? if ($arResult['DETAIL_PICTURE']['SRC']): ?>
                <a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" data-fancybox="images">
                    <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['DETAIL_PICTURE']['ALT']?>">
                    <svg width="42" height="42" class="icon single-project-loop"><use xlink:href="#zoom-in-light"></use></svg>
                </a>
                <? else: ?>
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/project-default.jpg" alt="Project Default">
                <? endif; ?>
            </div>
            <div class="single-project_info__descr">
                <div class="info-descr_item">
                    <div class="descr-item_title">
                        <svg width="15" height="21" class="icon"><use xlink:href="#project-name"></use></svg>
                        Название проекта
                    </div>
                    <div class="descr-item_subtitle"><?=$arResult["NAME"]?></div>
                </div>

                <? if ($arResult["DISPLAY_PROPERTIES"]["CLIENT"]["VALUE"]): ?>
                <div class="info-descr_item">
                    <div class="descr-item_title">
                        <svg width="21" height="18" class="icon"><use xlink:href="#project-client"></use></svg>
                        Название клиента
                    </div>
                    <div class="descr-item_subtitle"><?=$arResult["DISPLAY_PROPERTIES"]["CLIENT"]["VALUE"]?></div>
                </div>
                <? endif;?>

                <? if ($arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["VALUE"]): ?>
                <div class="info-descr_item">
                    <div class="descr-item_title">
                        <svg width="14" height="18" class="icon"><use xlink:href="#project-category"></use></svg>
                        Категория
                    </div>
                    <div class="descr-item_subtitle"><?=$arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["VALUE"]?></div>
                </div>
                <? endif;?>

                <? if ($arResult["DISPLAY_PROPERTIES"]["TERMS"]["VALUE"]): ?>
                <div class="info-descr_item">
                    <div class="descr-item_title">
                        <svg width="20" height="20" class="icon"><use xlink:href="#project-timing"></use></svg>
                        Сроки реализации
                    </div>
                    <div class="descr-item_subtitle"><?=$arResult["DISPLAY_PROPERTIES"]["TERMS"]["VALUE"]?></div>
                </div>
                <? endif; ?>

                <? if ($arResult["DISPLAY_PROPERTIES"]["LOCATION"]["VALUE"]): ?>
                <div class="info-descr_item">
                    <div class="descr-item_title">
                        <svg width="18" height="23" class="icon"><use xlink:href="#project-location"></use></svg>
                        Место проведения
                    </div>
                    <div class="descr-item_subtitle"><?=$arResult["DISPLAY_PROPERTIES"]["LOCATION"]["VALUE"]?></div>
                </div>
                <? endif ?>
            </div>
        </div>

        <? if ($arResult['DETAIL_TEXT']): ?>
        <div class="project__detail">
            <?= $arResult['DETAIL_TEXT'] ?>
        </div>
        <? endif; ?>

        <div class="single-project_nav">
            <div class="single-project_share">
                <div class="single-project_share__title">Поделиться этим проектом:</div>
                <div class="single-project_share__lihks">
                    <script src="https://yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-curtain data-services="vkontakte,facebook,odnoklassniki,telegram,whatsapp"></div>
                    <?/*a href="https://vk.com/id32079140" target="blank">
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
                    </a*/?>
                </div>
            </div>

            <ul class="pagination single-project-pagination">
                <li class="page-item single-project-page-item <?if(!is_array($arResult["TOLEFT"])):?>disabled<?endif?>">
                    <a class="page-link" href="<?=$arResult["TOLEFT"]["URL"]?>">
                        <span aria-hidden="true"><svg width="13" height="12" class="icon svg-pagination left"><use xlink:href="#double-angle-right-alt"></use></svg></span>Предыдущий
                    </a>
                </li>
                <li class="page-item single-project-page-item <?if(!is_array($arResult["TORIGHT"])):?>disabled<?endif?>">
                    <a class="page-link" href="<?=$arResult["TORIGHT"]["URL"]?>">Следующий<span aria-hidden="true"><svg width="13" height="12" class="icon svg-pagination right"><use xlink:href="#double-angle-right-alt"></use></svg></span></a>
                </li>
            </ul>
        </div>
    </div>
</section>
