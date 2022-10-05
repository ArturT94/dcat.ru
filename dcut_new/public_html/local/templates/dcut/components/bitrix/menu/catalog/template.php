<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <nav class="catalogProducts newCatalogAside">
        <ul class="catalog-menu">
            <?$previousLevel = 0;
            foreach($arResult as $arItem):?>
                <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?><?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?><?endif?>
                <?if ($arItem["IS_PARENT"]):?>
                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li class="menu<?if ($arItem["SELECTED"]):?> item-selected<?endif?>">
                            <a href="<?=$arItem["LINK"]?>" class="category-menu-link catalog-menu-link"><?=$arItem["TEXT"]?><svg width="11" height="7" class="icon category-menu-link-arrow"><use xlink:href="#angle-right"></use></svg></a>
                            <ul class="submenu submenu-top">
                    <?else:?>
                        <li class="submenu-item<?if ($arItem["SELECTED"]):?> item-selected<?endif?>">
                            <a class="submenu-item-link<?if ($arItem["SELECTED"]):?> selected<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                            <ul class="sub-submenu">
                    <?endif?>
                <?else:?>
                    <?if ($arItem["PERMISSION"] > "D"):?>
                        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                            <li class="menu">
                                <a class="category-menu-link catalog-menu-link<?if ($arItem["SELECTED"]):?> selected<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                            </li>
                        <?elseif($arItem["DEPTH_LEVEL"] == 2):?>
                            <li class="submenu-item">
                                <a class="submenu-item-link<?if ($arItem["SELECTED"]):?> selected<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                            </li>
                        <?else:?>
                            <li class="sub-submenu-item">
                                <a class="sub-submenu-item-link<?if ($arItem["SELECTED"]):?> selected<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
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
    </nav>
<?endif?>