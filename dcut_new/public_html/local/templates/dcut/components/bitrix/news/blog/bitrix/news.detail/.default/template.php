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

<div class="content-head">
    <div class="content-head_title"><?=$arResult["NAME"]?></div>
    <div class="content-news_info__share">
        <div class="info-share__date">
            <div class="img">
                <svg width="13" height="13" class="icon"><use xlink:href="#calendar"></use></svg>
            </div>
            <strong> 07.01.2018 </strong>
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
</div>
<div class="content-info">
    <div class="content-info_img" title="Увеличить">
        <a href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="img"></a>
    </div>

    <?= $arResult["DETAIL_TEXT"];?>

    <div class="hashtag">
        <a href="#">#Энергоэффективность</a>
        <a href="#">#DeWalt</a>
        <a href="#">#Дикат</a>
        <a href="#">#Административное здание</a>
        <a href="#">#Технологии строительства</a>
        <a href="#">#Клиентоориентированность</a>
        <a href="#">#Stanley</a>
        <a href="#">#Миссия</a>
        <a href="#">#Инновации</a>
    </div>
</div>
