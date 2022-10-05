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

<? if ($arResult["SECTIONS"]): ?>
    <section class="projects-all_tabs">
        <div class="all-tabs_container">
            <a href="/projects/" class="projects-tab active">Смотреть все проекты <div class="tab-after"><span>14</span></div></a>

            <? foreach($arResult["SECTIONS"] as $key=>$arItem): ?>
                <a href="/projects/<?= $arItem['CODE'] ?>" class="projects-tab"><?= $arItem['NAME'] ?> <div class="tab-after"><span><?= $arItem['ELEMENT_CNT'] ?></span></div></a>
            <? endforeach; ?>
        </div>
    </section>
<? endif; ?>
