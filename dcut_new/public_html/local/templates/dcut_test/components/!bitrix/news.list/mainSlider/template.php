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
<section class="s-main-slider">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="hero-slider">
					<?foreach($arResult["ITEMS"] as $arItem):?>
						<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						unset($btn_color_custom);
						unset($btn_bg);
						if($arItem['PROPERTIES']['BUTTON_COLOR']['VALUE']){
							$btn_bg = $arItem['PROPERTIES']['BUTTON_COLOR']['VALUE_XML_ID'];
						}
						if($arItem['PROPERTIES']['TEXT_COLOR']['VALUE']){
							$text_color = $arItem['PROPERTIES']['TEXT_COLOR']['VALUE_XML_ID'];
						}	
						if($arItem['PROPERTIES']['CUSTOM_BUTTON_COLOR']['VALUE'] || $arItem['PROPERTIES']['CUSTOM_TEXT_COLOR']['VALUE']){
							$btn_color_custom=' style="';
							if($arItem['PROPERTIES']['CUSTOM_BUTTON_COLOR']['VALUE']){
								$btn_color_custom=$btn_color_custom.'background: '.$arItem['PROPERTIES']['CUSTOM_BUTTON_COLOR']['VALUE'].'!important;';
							}
							if($arItem['PROPERTIES']['CUSTOM_TEXT_COLOR']['VALUE']){
								$btn_color_custom=$btn_color_custom.'color: '.$arItem['PROPERTIES']['CUSTOM_TEXT_COLOR']['VALUE'].'!important;';
							}
							$btn_color_custom=$btn_color_custom.'"';
						}
						?>
						<div class="slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
							<a href="<?=$arItem['PROPERTIES']['BUTTON_LINK']['VALUE']?>" class="hero-banner hero-banner--corner<?if($text_color){echo ' hero-banner--'.$text_color;}?>" style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>);">
								<span class="hero-banner__content">
									<?if($arParams['PR_CITY_NAME'] == 'России' && $arItem['PROPERTIES']['TITLE_RUSSIA']['VALUE']):?>
										<span class="hero-banner__title">
											<?=str_replace('#PR_CITY_NAME#',$arParams['PR_CITY_NAME'],$arItem['PROPERTIES']['TITLE_RUSSIA']['~VALUE'])?>
										</span>
									<?else:?>
										<?if($arItem['PROPERTIES']['TITLE']['VALUE']):?>
											<span class="hero-banner__title">
												<?=str_replace('#PR_CITY_NAME#',$arParams['PR_CITY_NAME'],$arItem['PROPERTIES']['TITLE']['~VALUE'])?>
											</span>
										<?else:?>
											<span class="hero-banner__title"><?=$arItem['~NAME']?></span>
										<?endif;?>
									<?endif;?>
									<?if($arItem['PROPERTIES']['PRICE']['VALUE']):?>
										<span class="hero-banner__price"><?=$arItem['PROPERTIES']['PRICE']['VALUE']?></span>
									<?endif;?>
									<?if($arItem['PROPERTIES']['BUTTON_TEXT']['VALUE']):?>
										<span class="hero-banner__action">
											<span class="adp-btn<?if($btn_bg){echo ' adp-btn--'.$btn_bg;}?>"<?if($btn_color_custom){echo $btn_color_custom;}?>>
												<?=$arItem['PROPERTIES']['BUTTON_TEXT']['VALUE']?> <svg class="icon"><use xlink:href="#arrow-right"></use></svg>
											</span>
										</span>
									<?endif;?>
									<?if($arParams['PR_CITY_NAME'] == 'России' && $arItem['PROPERTIES']['TITLE_RUSSIA']['VALUE']):?>
										<?if($arItem['PROPERTIES']['TEXT_BOTTOM_RUSSIA']['VALUE']):?>
											<span class="hero-banner__tips"><?=$arItem['PROPERTIES']['TEXT_BOTTOM_RUSSIA']['VALUE']?></span>
										<?endif;?>
									<?else:?>
										<?if($arItem['PROPERTIES']['TEXT_BOTTOM']['VALUE']):?>
											<span class="hero-banner__tips"><?=$arItem['PROPERTIES']['TEXT_BOTTOM']['VALUE']?></span>
										<?endif;?>
									<?endif;?>
									<?if($arItem['DETAIL_PICTURE']):?>
										<span class="hero-banner__thumb">
											<img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$arItem['~NAME']?>">
										</span>
									<?endif;?>
									<?if($arItem['PROPERTIES']['LOGO']['VALUE']):?>
										<span class="banner-logo">
											<img src="<?=CFile::GetPath($arItem['PROPERTIES']['LOGO']['VALUE']);?>">
										</span>
									<?endif;?>
								</span>
							</a>
						</div>
					<?endforeach;?>
                </div>
            </div>
        </div>
    </div>
</section>