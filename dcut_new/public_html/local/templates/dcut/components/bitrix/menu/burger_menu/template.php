<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <div class="mobile-menu one element">
        <?$previousLevel = 0;
        foreach($arResult as $arItem):?>
            <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?><?=str_repeat("</div></div>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?><?endif?>
            <?if ($arItem["IS_PARENT"]):?>
                <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                    <div class="menu-element<?if ($arItem["SELECTED"]):?> selected<?endif?>">
                        <div class="menu-element__title dropdown"><?=$arItem["TEXT"]?></div>
                        <div class="menu-element__info">
                <?else:?>
                    <div class="menu-element<?if ($arItem["SELECTED"]):?> selected<?endif?>">
                        <div class="menu-element__title dropdown"><?=$arItem["TEXT"]?></div>
                        <div class="menu-element__info">
                <?endif?>
            <?else:?>
                <?if ($arItem["PERMISSION"] > "D"):?>
                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <div class="menu-element">
                            <div class="menu-element__title<?if ($arItem["SELECTED"]):?> selected<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
                        </div>
                    <?else:?>
                        <div class="menu-element">
                            <div class="menu-element__title<?if ($arItem["SELECTED"]):?> selected<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
                        </div>
                    <?endif?>
                <?endif?>
            <?endif?>
            <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
        <?endforeach?>
        <?if ($previousLevel > 1)://close last item tags?>
            <?=str_repeat("</div></div>", ($previousLevel-1) );?>
        <?endif?>
        <div class="mobile-nav__languages">
            <a href="/en/" class="languages-item">English</a>
            <a href="/" class="languages-item">Русский</a>
        </div>
    </div>
<?endif?>