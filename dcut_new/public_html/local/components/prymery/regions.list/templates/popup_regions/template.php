<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;?>
<div class="modalRegions__title"><?=GetMessage('MODAL_REGIONS_TITLE');?></div>
<div class="modalRegions__form">
    <div class="">
        <div class="modalRegions__search">
            <input id="searchCity" class="autocomplete" type="text" placeholder="<?=Loc::getMessage('CITY_PLACEHOLDER');?>">
            <div class="search_btn"></div>
        </div>
        <?if($arResult['FAVORITS']):?>
            <div class="modalRegions__favorits">
                <span class="modalRegions__head"><?=GetMessage('EXAMPLE_CITY');?></span>
                <div class="modalRegions__cities">
                    <?foreach($arResult['FAVORITS'] as $arItem):?>
                        <div class="modalRegions__item">
                            <a href="<?=$arItem['URL'];?>" data-id="<?=$arItem['ID'];?>"><?=$arItem['NAME'];?></a>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        <?endif;?>
    </div>
    <div class="modalRegions__items">
        <?if($arResult['SECTION_REGION_FIRST']):?>
            <div class="modalRegions__col">
                <div class="modalRegions__subtitle"><?=($arResult['SECTION_REGION_SECOND'] ? Loc::getMessage('OKRUG') : Loc::getMessage('REGION'));?></div>
                <div class="modalRegions__block modalRegions__region">
                    <?foreach($arResult['SECTION_REGION_FIRST'] as $key => $arSection):?>
                        <div class="item btnLink" data-id="<?=$key;?>"><?=$arSection['NAME'];?></div>
                    <?endforeach;?>
                </div>
            </div>
        <?endif;?>
        <?if($arResult['SECTION_REGION_SECOND']):?>
            <div class="modalRegions__col">
                <div class="modalRegions__subtitle"><?=Loc::getMessage('REGION');?></div>
                <div class="modalRegions__block modalRegions__region">
                    <?foreach($arResult['SECTION_REGION_SECOND'] as $key => $arSections):?>
                        <div class="parent_block" data-id="<?=$key;?>">
                            <?foreach($arSections as $key2 => $arSection):?>
                                <div class="item btnLink" data-id="<?=$key2;?>"><?=$arSection['NAME'];?></div>
                            <?endforeach;?>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        <?endif;?>
        <?if($arResult['REGIONS']):?>
            <div class="modalRegions__col modalRegions__cities">
                <div class="modalRegions__subtitle"><?=Loc::getMessage('CITY');?></div>
                <div class="modalRegions__block">
                    <?foreach($arResult['REGIONS'] as $key => $arItem):?>
                        <?$bCurrent = ($arResult['CURRENT_REGION']['ID'] == $arItem['ID']); ?>
                        <div class="item <?=($bCurrent ? 'current show' : '');?> <?=((!$arResult['SECTION_REGION_FIRST'] && !$arResult['SECTION_REGION_SECOND']) ? 'show' : '');?>" data-id="<?=((isset($arItem['IBLOCK_SECTION_ID']) && $arItem['IBLOCK_SECTION_ID']) ? $arItem['IBLOCK_SECTION_ID'] : 0);?>">
                            <?if(\Bitrix\Main\Config\Option::get('prymery.genesis', 'REGIONALITY_METHOD', 'N') == 'Y'):?>
                                <a href="<?=$arItem['HTTP_TYPE'];?><?=$arItem['URL'];?>" class="defLink<?if($bCurrent):?> active<?endif;?>" data-id="<?=$arItem['ID'];?>"><?=$arItem['NAME'];?></a>
                            <?else:?>
                                <a href="" class="defLink<?if($bCurrent):?> active<?endif;?>" data-id="<?=$arItem['ID'];?>"><?=$arItem['NAME'];?></a>
                            <?endif;?>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        <?endif;?>
    </div>
    <script>
        var arRegions = <?=CUtil::PhpToJsObject($arResult['JS_REGIONS']);?>
    </script>
</div>
