<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <ul class="profile-dropdown">
        <?foreach($arResult as $arItem):
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)  continue; ?>
            <li class="dropdown-item<?if($arItem["SELECTED"]):?> selected<?endif?>">
                <?=$arItem["PARAMS"]['ICON']?>
                <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                <svg width="6" height="10" class="icon hidden-arrow"><use xlink:href="#angle-right-alt"></use></svg>
            </li>
        <?endforeach?>
    </ul>
<?endif?>