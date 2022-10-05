<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <ul>
        <?foreach($arResult as $arItem):
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)  continue; ?>
            <li class="<?if($arItem["SELECTED"]):?> selected<?endif?>">

                <img src="<?=$arItem["PARAMS"]['ICON2']?>" alt="img">
                <a class="profile-hidden-link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 9.11594L5 5.05797L1 1" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </li>
        <?endforeach?>
        <li><img src="/local/templates/dcut/assets/img/roof/profile-5.svg" alt="img"><a class="profile-hidden-link" href="<?echo $APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), ["login",  "logout",  "register",  "forgot_password",  "change_password"]);?>">Выйти</a></li>
    </ul>
<?endif?>