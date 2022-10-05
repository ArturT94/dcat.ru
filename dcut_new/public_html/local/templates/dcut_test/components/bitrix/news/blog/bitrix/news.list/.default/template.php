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

<? if ($arResult["ITEMS"]): ?>
<div class="blog-content">
    <form action="#" class="search-form">
        <input type="text" name="search" placeholder="Поиск в новостях">
        <button>
            <svg width="19" height="19" class="icon"><use xlink:href="#search"></use></svg>
        </button>
    </form>

    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="content-news">
            <a href="<?= $arItem["DETAIL_PAGE_URL"]?>" class="content-news-img">
                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>">
                <svg width="42" height="42" class="icon content-news-hover-link"><use xlink:href="#zoom-in-light"></use></svg>
            </a>
            <div class="content-news_info">
                <h2 class="content-news_info__title"><a href="<?= $arItem["DETAIL_PAGE_URL"]?>"><?= $arItem["NAME"]?></a></h2>

                <div class="content-news_info__share">
                    <div class="info-share__date">
                        <div class="img">
                            <svg width="13" height="13" class="icon"><use xlink:href="#calendar"></use></svg>
                        </div>
                        <strong><?=$arItem["DISPLAY_ACTIVE_FROM"]?></strong>
                    </div>
                    <span>|</span>
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

                <div class="content-news_info__descr">
                    <?=$arItem["PREVIEW_TEXT"]?>
                </div>
                <a href="<?= $arItem["DETAIL_PAGE_URL"]?>" class="content-news_info__link">Показать полностью <svg width="10" height="9" class="icon insta-link-arrows"><use xlink:href="#double-angle-right"></use></svg></a>
            </div>
        </div>
    <?endforeach;?>

    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif;?>

    <?/*<ul class="pagination justify-content-start">
        <li class="page-item disabled"><span class="page-link left" tabindex="-1" aria-disabled="true">Назад</span></li>
        <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
        <li class="page-item"><span class="page-link">2 <span class="sr-only">(current)</span></span></li>
        <li class="page-item"><span class="page-link">3</span></li>
        <li class="page-item"><span class="page-link">4</span></li>
        <li class="page-item"><span class="page-link right">Вперед</span></li>
    </ul>*/?>
</div>
<? endif; ?>
