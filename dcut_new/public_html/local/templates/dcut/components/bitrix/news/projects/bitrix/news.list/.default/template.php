<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if ($arResult["ITEMS"]): ?>
    <? if ($arResult["SECTIONS"]): ?>
        <section class="projects-all_tabs">
            <div class="all-tabs_container">
                <a href="/projects/" class="projects-tab <? if ($GLOBALS['PAGE'][2] == ''): ?>active<? endif; ?>">Смотреть все проекты <div class="tab-after"><span><?=$arResult['ALL_SECTION_CNT']?></span></div></a>
                <? foreach($arResult["SECTIONS"] as $key=>$section): ?>
                    <a href="<?= $section['SECTION_PAGE_URL'] ?>" class="projects-tab <? if ($GLOBALS['PAGE'][2] == $section['CODE']): ?>active<? endif; ?>">
                        <?= $section['NAME'] ?>
                        <div class="tab-after"><span><?= $section['ELEMENT_CNT'] ?></span></div>
                    </a>
                <? endforeach; ?>
            </div>
        </section>
    <? endif; ?>
    <div class="projects-all">
        <div class="projects-all-container">
            <? foreach($arResult["ITEMS"] as $arItem):
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="all-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="projects-all_info">
                        <div class="projects-all_info__title"><?=$arItem["NAME"]?></div>
                        <div class="projects-all_info__text"><?=$arItem["PREVIEW_TEXT"]?></div>
                        <span class="projects-all_info__link">
                            Подробнее <svg width="10" height="9" class="icon"><use xlink:href="#double-angle-right"></use></svg>
                        </span>
                    </a>
                </div>
            <? endforeach; ?>
        </div>

        <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
            <?=$arResult["NAV_STRING"]?>
        <?endif;?>
    </div>
<? endif; ?>