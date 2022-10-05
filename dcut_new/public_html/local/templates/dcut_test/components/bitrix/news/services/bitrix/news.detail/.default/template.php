<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="content">
    <div class="content-row services-content-row">
        <div class="content-titles">
            <div class="title"><?=$arResult["NAME"]?></div>
            <button class="content-titles__button consult-modal">Заказать консультацию</button>
        </div>
        <div class="content-info"><?= $arResult["DETAIL_TEXT"];?></div>
    </div>
    <?if ($arResult['SERVICES_PHOTO']): ?>
        <div class="services-row">
            <?foreach($arResult['SERVICES_PHOTO'] as $photo):?>
                <div class="services-column">
                    <div class="services-item services-item-content">
                        <a data-fancybox="services-gallery" href="<?=$photo['BIG']['src'];?>"><img src="<?=$photo['SMALL']['src'];?>" alt="+"></a>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    <?endif ?>
</div>