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

/*$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);*/

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");

?>
<div class="product-filter">
	<div class="filter-toggler">
		<svg class="icon icon-thumb"><use xlink:href="#filter"></use></svg>
		Показать фильтр
		<svg class="icon icon-toggler"><use xlink:href="#angle-right"></use></svg>
	</div>
	<a href="<?=$APPLICATION->GetCurPage();?>" class="filter-reset"><svg class="icon"><use xlink:href="#times"></use></svg> Сбросить фильтр</a>
	<div class="filter-body">
		<div class="bx-filter <?=$templateData["TEMPLATE_CLASS"]?> ">
			<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
				<?foreach($arResult["HIDDEN"] as $arItem):?>
				<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
				<?endforeach;?>
				<?foreach($arResult["ITEMS"] as $key=>$arItem){
					$key = $arItem["ENCODED_ID"];
					if(isset($arItem["PRICE"])):
						if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
							continue;
						$step_num = 4;
						$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
						$prices = array();
						if (Bitrix\Main\Loader::includeModule("currency")){
							for ($i = 0; $i < $step_num; $i++){
								$prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
							}
							$prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
						}else{
							$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
							for ($i = 0; $i < $step_num; $i++){
								$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
							}
							$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
						}
						?>
						<div class="toggle-dropdown open bx-filter-parameters-box bx-active">
							<span style="display: none" class="bx-filter-container-modef"></span>
							<div class="bx-filter-parameters-box-title header">
								Цена
							</div>
							<div class="bx-filter-block" data-role="bx_filter_block">
								<?if(!$arItem["VALUES"]["MIN"]["HTML_VALUE"]){$arItem["VALUES"]["MIN"]["HTML_VALUE"] = str_replace(' ','',$prices[0]);}?>
								<?if(!$arItem["VALUES"]["MAX"]["HTML_VALUE"]){$arItem["VALUES"]["MAX"]["HTML_VALUE"] = str_replace(' ','',$prices[count($prices)-1]);}?>
									
								
								<div class="bx-ui-slider-track-container">
									<div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
										<?for($i = 0; $i <= $step_num; $i++):?>
											<div class="bx-ui-slider-part p<?=$i+1?>"><span><?=round(str_replace(' ','',$prices[$i]))?></span></div>
										<?endfor;?>
										<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
										<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
										<div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
										<div class="bx-ui-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
											<a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>">
											<input
												class="min-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
												size="5" 
												onkeyup="smartFilter.keyup(this)"
											/>
									</a>
											<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>">
												<input
													class="max-price"
													type="text"
													name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
													id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
													value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
													size="5" 
													onkeyup="smartFilter.keyup(this)"
												/>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?
						$arJsParams = array(
							"leftSlider" => 'left_slider_'.$key,
							"rightSlider" => 'right_slider_'.$key,
							"tracker" => "drag_tracker_".$key,
							"trackerWrap" => "drag_track_".$key,
							"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
							"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
							"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
							"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
							"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
							"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
							"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
							"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
							"precision" => $precision,
							"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
							"colorAvailableActive" => 'colorAvailableActive_'.$key,
							"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
						);
						?>
						<script type="text/javascript">
							BX.ready(function(){
								window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
							});
						</script>
					<?endif;
				}
				//not prices
				foreach($arResult["ITEMS"] as $key=>$arItem){
					if($arItem["NAME"] == 'Цена') continue;
					if(empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
						continue;

					if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
						continue;
					?>
					<div class="toggle-dropdown <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>open bx-active<?endif?>">
						<div class="header"><?=$arItem["NAME"]?></div>
						<div class="body" style="display: block;">
							<div data-role="bx_filter_block">
								<?
								$arCur = current($arItem["VALUES"]);
								switch ($arItem["DISPLAY_TYPE"]){
									case "A"://NUMBERS_WITH_SLIDER
										break;
									case "B"://NUMBERS
										
										break;
									case "G"://CHECKBOXES_WITH_PICTURES
										
										break;
									case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
									
										break;
									case "P"://DROPDOWN
										
										break;
									case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
										
										break;
									case "K"://RADIO_BUTTONS
										
										break;
									case "U"://CALENDAR
										
										break;
									default://CHECKBOXES
										?>
										<?foreach($arItem["VALUES"] as $val => $ar):?>
											<label class="custom-checkbox checkbox--fade-primary" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>">
												
												<input
													type="checkbox" class="checkbox-value"
													value="<? echo $ar["HTML_VALUE"] ?>"
													name="<? echo $ar["CONTROL_NAME"] ?>"
													id="<? echo $ar["CONTROL_ID"] ?>"
													<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
													onclick="smartFilter.click(this)"
												/>
														
												<span class="checkbox-icon"></span>
												<span class="checkbox-text"><?=$ar["VALUE"];?></span>
											</label>
							
										<?endforeach;?>
								<? } ?>
							</div>
						</div>
					</div>
				<?}?>
				<div style="display: none">
					<input
						class="btn btn-themes"
						type="submit"
						id="set_filter"
						name="set_filter"
						value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
					/>
					<input
						class="btn btn-link"
						type="submit"
						id="del_filter"
						name="del_filter"
						value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
					/>
					<div class="bx-filter-popup-result" id="modef" style="display:none">
						<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
						<span class="arrow"></span>
						<br/>
						<a href="<?echo $arResult["FILTER_URL"]?>" target=""><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript">
			var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
		</script>
	</div>
</div>