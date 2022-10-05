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
<div id="team-slider-modal" class="modal-team">
    <div class="member-slider">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <div class="slide">
                <div class="member-item">
                    <div class="member-img"><img src="<?= $arItem["DISPLAY_PROPERTIES"]["PHOTO"]["FILE_VALUE"]["SRC"]; ?>" alt="<?= $arItem["NAME"]; ?>"></div>
                    <div class="member-pers">
                        <div class="member-pers_name"><?= $arItem["NAME"]; ?></div>
                        <div class="member-pers_prof"><?= $arItem["DISPLAY_PROPERTIES"]["POSITION"]["DISPLAY_VALUE"]; ?></div>
                    </div>
                    <div class="member-contact">
                        <div class="member-contact_phone">
                            <span><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.9617 9.17526V10.8449C11.9623 10.9999 11.9305 11.1533 11.8683 11.2953C11.806 11.4373 11.7148 11.5648 11.6003 11.6696C11.4859 11.7744 11.3508 11.8542 11.2037 11.9038C11.0566 11.9535 10.9007 11.9719 10.746 11.958C9.03001 11.7719 7.3817 11.1867 5.93349 10.2494C4.58611 9.39491 3.44378 8.25483 2.5876 6.91013C1.64516 5.45822 1.05866 3.80517 0.87562 2.0849C0.861685 1.931 0.880011 1.77588 0.929433 1.62944C0.978855 1.48299 1.05829 1.34842 1.16268 1.23429C1.26707 1.12016 1.39412 1.02898 1.53576 0.966539C1.67739 0.904102 1.8305 0.871782 1.98534 0.871636H3.65828C3.92891 0.868978 4.19128 0.964622 4.39648 1.14074C4.60167 1.31686 4.7357 1.56144 4.77358 1.82889C4.84419 2.36321 4.97514 2.88784 5.16393 3.39278C5.23896 3.59198 5.2552 3.80847 5.21072 4.01659C5.16625 4.22472 5.06292 4.41576 4.91299 4.56708L4.20478 5.27389C4.99862 6.66722 6.15457 7.82088 7.55066 8.61315L8.25888 7.90634C8.4105 7.75671 8.60192 7.65359 8.81046 7.6092C9.019 7.56481 9.23592 7.58102 9.43551 7.6559C9.94145 7.84431 10.4671 7.975 11.0025 8.04548C11.2734 8.08362 11.5208 8.21979 11.6976 8.4281C11.8745 8.6364 11.9684 8.90232 11.9617 9.17526Z" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                            <a href="tel:<?= $arItem["DISPLAY_PROPERTIES"]["PHONE"]["DISPLAY_VALUE"]; ?>"><?= $arItem["DISPLAY_PROPERTIES"]["PHONE"]["DISPLAY_VALUE"]; ?></a>
                        </div>
                        <div class="member-contact_email">
                            <span><svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.2532 2.18229C12.2532 1.58923 11.7509 1.104 11.1369 1.104H2.20618C1.5922 1.104 1.08984 1.58923 1.08984 2.18229M12.2532 2.18229V8.65198C12.2532 9.24504 11.7509 9.73027 11.1369 9.73027H2.20618C1.5922 9.73027 1.08984 9.24504 1.08984 8.65198V2.18229M12.2532 2.18229L6.67154 5.95628L1.08984 2.18229"  stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                            <a href="mailto:<?= $arItem["DISPLAY_PROPERTIES"]["EMAIL"]["DISPLAY_VALUE"]; ?>"><?= $arItem["DISPLAY_PROPERTIES"]["EMAIL"]["DISPLAY_VALUE"]; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?endforeach;?>
    </div>
    <div data-fancybox-close class="popup-close"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
</div>
