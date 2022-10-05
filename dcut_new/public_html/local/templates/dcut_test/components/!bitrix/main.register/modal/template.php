<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?>
<div class="ajaxContent">
	<?if($USER->IsAuthorized()):?>
		<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>
	<?else:?>
		<?if (count($arResult["ERRORS"]) > 0):
			foreach ($arResult["ERRORS"] as $key => $error){
				if (intval($key) == 0 && $key !== 0) {
					$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
					if(in_array($key,array('NAME','PERSONAL_PHONE','EMAIL','LOGIN','PASSWORD','CONFIRM_PASSWORD'))){
						unset($arResult["ERRORS"][$key]);
					}
				}
			}
		elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
			<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
		<?endif?>
		<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
			<input type="hidden" name="TYPE" value="REGISTRATION">
			<input type="hidden" class="ajaxLoginReg" name="REGISTER[LOGIN]" value="<?=$_REQUEST['REGISTER']['EMAIL']?>">

			<?if($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif;?>
			<div class="modal-group">
				<input type="text" class="form-control<?if($_REQUEST['REGISTER']):if(!$_REQUEST['REGISTER']['NAME']):?> novalid<?endif;endif;?>" placeholder="Имя *" name="REGISTER[NAME]" value="<?=$_REQUEST['REGISTER']['NAME']?>">
			</div>
			<div class="modal-group">
				<input type="text" class="phoneMask form-control<?if($_REQUEST['REGISTER']):if(!$_REQUEST['REGISTER']['PERSONAL_PHONE']):?> novalid<?endif;endif;?>" 
					placeholder="Телефон *" name="REGISTER[PERSONAL_PHONE]" value="<?=$_REQUEST['REGISTER']['PERSONAL_PHONE']?>">
			</div>
			<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
				<?switch ($FIELD){
					case "PASSWORD":?>
						<div class="modal-group">
                            <div class="password-switching">
                                <input size="30" type="password" class="registerPswd form-control<?if($_REQUEST['REGISTER']):if(!$_REQUEST['REGISTER'][$FIELD]):?> novalid<?endif;endif;?>" 
									name="REGISTER[<?=$FIELD?>]" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?> <?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>" value="<?=$_REQUEST['REGISTER'][$FIELD]?>" autocomplete="off"  />
                                <div class="password-switch">
                                    <svg class="icon icon-md pass-hidden"><use xlink:href="#eye-close"></use></svg>
                                    <svg class="icon icon-md pass-visible"><use xlink:href="#eye-open"></use></svg>
                                </div>
                            </div>
						</div>
					<? break;
					case "CONFIRM_PASSWORD":?>
						<div class="modal-group">
                            <div class="password-switching">
                                <input size="30" type="password" class="registerCheckPswd form-control<?if($_REQUEST['REGISTER']):if(!$_REQUEST['REGISTER'][$FIELD]):?> novalid<?endif;endif;?>" 
									name="REGISTER[<?=$FIELD?>]" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?> <?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>" value="<?=$_REQUEST['REGISTER'][$FIELD]?>" autocomplete="off" />
                                <div class="password-switch">
                                    <svg class="icon icon-md pass-hidden"><use xlink:href="#eye-close"></use></svg>
                                    <svg class="icon icon-md pass-visible"><use xlink:href="#eye-open"></use></svg>
                                </div>
                            </div>
						</div>
					<? break;
					default: 
						if(!in_array($FIELD,array('LOGIN','NAME','PERSONAL_PHONE'))):?>
							<div class="modal-group">
								<input type="text" class="<?if($FIELD == 'EMAIL'):?>ajaxEmailinReg <?endif;?>form-control<?if($_REQUEST['REGISTER']):if(!$_REQUEST['REGISTER'][$FIELD]):?> novalid<?endif;endif;?>" 
									placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?> <?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>" name="REGISTER[<?=$FIELD?>]" value="<?=$_REQUEST['REGISTER'][$FIELD]?>" />
							</div>
						<?endif;?>
				<?}?>
			<?endforeach?>
			<?if($arResult["ERRORS"] && count($arResult["ERRORS"]) > 0):?>
				<div class="modalRegisterError"><?ShowError(implode("<br />", $arResult["ERRORS"]));?></div>
			<?endif;?>
			<div class="modal-group">
				<label class="custom-checkbox custom-checkbox--silver">
					<input type="checkbox" class="custom-checkobox__value<?if($_REQUEST['REGISTER']):if(!$_REQUEST['privacy']):?> novalid<?endif;endif;?>" name="privacy"<?if($_REQUEST['REGISTER']):if($_REQUEST['privacy'] == 'on'):?> checked<?endif;?><?else:?> checked<?endif;?>>
					<span class="custom-checkobox__icon"><svg class="icon"><use xlink:href="#check"></use></svg></span>
					<span class="custom-checkobox__text registerPrivacy">Я принимаю <a href="#" class="btn-link--primary">условия</a> хранения<br> и обработки данных</span>
				</label>
			</div>
			<div class="modal-group text-center">
				<input type="submit" name="register_submit_button" class="adp-btn adp-btn--md adp-btn--primary" value="Зарегистрироваться" />
			</div>
		</form>
	<?endif;?>
</div>