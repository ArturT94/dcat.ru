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

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);
if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
?>
<div class="bx-filter <?=$templateData["TEMPLATE_CLASS"]?> <?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL") echo "bx-filter-horizontal"?>">
	<div class="bx-filter-section container-fluid">
	
	
	
	
<div class="product-filter">
	<div class="filter-toggler">
		<svg class="icon icon-thumb"><use xlink:href="#filter"></use></svg>
		Показать фильтр
		<svg class="icon icon-toggler"><use xlink:href="#angle-right"></use></svg>
	</div>
	<a href="<?=$APPLICATION->GetCurPage();?>" class="filter-reset"><svg class="icon"><use xlink:href="#times"></use></svg> Сбросить фильтр</a>
	<div class="filter-body">
        <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
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
						for ($i = 0; $i < $step_num; $i++)
						{
							$prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
						}
						$prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
					}else{
						$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
						for ($i = 0; $i < $step_num; $i++)
						{
							$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
						}
						$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
					}
					?>
					<div class="bx-filter-parameters-box bx-active">
						<span class="bx-filter-container-modef"></span>
						<div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)"><span><?=$arItem["NAME"]?> <i data-role="prop_angle" class="fa fa-angle-<?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>up<?else:?>down<?endif?>"></i></span></div>
						<div class="bx-filter-block" data-role="bx_filter_block">
							<div class="row bx-filter-parameters-box-container">
								<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
									<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
									<div class="bx-filter-input-container">
										<input
											class="min-price"
											type="text"
											name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
											id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
											value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
											size="5"
											onkeyup="smartFilter.keyup(this)"
										/>
									</div>
								</div>
								<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
									<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
									<div class="bx-filter-input-container">
										<input
											class="max-price"
											type="text"
											name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
											id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
											value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
											size="5"
											onkeyup="smartFilter.keyup(this)"
										/>
									</div>
								</div>

								<div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
									<div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
										<?for($i = 0; $i <= $step_num; $i++):?>
										<div class="bx-ui-slider-part p<?=$i+1?>"><span><?=$prices[$i]?></span></div>
										<?endfor;?>

										<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
										<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
										<div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
										<div class="bx-ui-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
											<a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
											<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
						
						
						
					<?/*div class="toggle-dropdown open">
						<div class="header">Цена</div>
						<div class="body filter-range" style="display: block;" data-role="bx_filter_block">
							<input type="text" class="js-range" name="time-range" value="" 
								data-from_fixed="false" 
								data-from="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" 
								data-to="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
								data-min="<?=str_replace(' ','',$prices[0])?>"
								data-max="<?=str_replace(' ','',$prices[count($prices)-1])?>" 
								data-postfix="р"/>
							<div style="display: none;">
								<input
									class="min-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									size="5"
									placeholder="<?=$prices[0]?>"
									onkeyup="smartFilter.keyup(this)"
								/>
								<input
									class="max-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
									size="5"
									placeholder="<?=$prices[count($prices)-1]?>"
									onkeyup="smartFilter.keyup(this)"
								/>
							</div>
						</div>
					</div*/?>
				<?endif;
			}
			foreach($arResult["ITEMS"] as $key=>$arItem){
				if(empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
					continue;

				if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
					continue;
				if($arItem["NAME"] == 'Цена') continue;
				?>
				<div class="toggle-dropdown open">
					<div class="header"><?=$arItem["NAME"]?></div>
					<div class="body" style="display: block;">
						<? $arCur = current($arItem["VALUES"]);
						switch ($arItem["DISPLAY_TYPE"])
						{
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
							case "K"://RADIO_BUTTONS
							break;
							default://CHECKBOXES ?>
								<?foreach($arItem["VALUES"] as $val => $ar):?>
									<label class="custom-checkbox checkbox--fade-primary">
										<input type="checkbox" class="checkbox-value" name="color-1"
											value="<? echo $ar["HTML_VALUE"] ?>"
										   name="<? echo $ar["CONTROL_NAME"] ?>"
										   id="<? echo $ar["CONTROL_ID"] ?>"
										<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>>
										<span class="checkbox-icon"></span>
										<span class="checkbox-text"><?=$ar["VALUE"];?></span>
									</label>
								<?endforeach;?>
						<? } ?>
					</div>
				</div>
			<? } ?>
			<input style="!display: none;"
					class="adp-btn adp-btn--outline-primary"
					type="submit"
					id="set_filter"
					name="set_filter"
					value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
			/>
			<input style="display: none;"
					class="adp-btn btn btn-link"
					type="submit"
					id="del_filter"
					name="del_filter"
					value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
			/>
        </form>
    </div>
</div>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>

</div>
</div>