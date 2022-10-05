<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <ul class="nav-menu">
        <?$previousLevel = 0;
        foreach($arResult as $arItem):?>
            <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?><?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?><?endif?>
            <?if ($arItem["IS_PARENT"]):?>
                <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                    <li class="nav-menu-li<?if ($arItem["SELECTED"]):?> item-selected<?endif?> dropdown"><a href="<?=$arItem["LINK"]?>" class="nav-menu-li-link parent"><?=$arItem["TEXT"]?></a>
                        <svg width="11" height="7" class="icon arrow"><use xlink:href="#angle-right"></use></svg>
                        <ul class="nav-submenu">
                <?else:?>
                    <li class="nav-menu-li<?if ($arItem["SELECTED"]):?> item-selected<?endif?> dropdown"><a href="<?=$arItem["LINK"]?>" class="nav-menu-li-link parent"><?=$arItem["TEXT"]?></a>
                        <svg width="11" height="7" class="icon arrow"><use xlink:href="#angle-right"></use></svg>
                        <ul class="nav-submenu">
                <?endif?>
            <?else:?>
                <?if ($arItem["PERMISSION"] > "D"):?>
                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li class="nav-menu-li">
                            <a class="nav-menu-li-link<?if ($arItem["SELECTED"]):?> selected<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                        </li>
                    <?else:?>
                        <li class="nav-submenu-item">
                            <a class="nav-submenu-item-link<?if ($arItem["SELECTED"]):?> selected<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                        </li>
                    <?endif?>
                <?endif?>
            <?endif?>
            <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
        <?endforeach?>
        <?if ($previousLevel > 1)://close last item tags?>
            <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
        <?endif?>
    </ul>
<?endif?>