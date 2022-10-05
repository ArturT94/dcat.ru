<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

?>
<div class="col-custom col-12 col-xl-5">
	<form method="post" name="form1" class="form form-personal" action="/personal/personal-data/<?//=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
		<input type="hidden" name="LOGIN" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
			
		<div class="personal__container personal__container--main">
			<div class="errorPersonal">
				<?ShowError($arResult["strProfileError"]);?>
				<?if( $arResult['DATA_SAVED'] == 'Y' ) {?><?ShowNote(GetMessage('PROFILE_DATA_SAVED'))?><?; }?>
			</div>
		
			<div class="personal__group">
				<h4 class="title">Персональные данные</h4>
				<div class="form-row">
					<div class="form-group">
						<input type="text" class="form-control" name="NAME" placeholder="Имя *" value="<?=$arResult["arUser"]["NAME"]?>" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="LAST_NAME" placeholder="Фамилия *" value="<?=$arResult["arUser"]["LAST_NAME"]?>" required>
					</div>
					<div class="w-100"></div>
					<div class="form-group">
						<input type="text" class="form-control phoneMask" name="PERSONAL_PHONE" placeholder="Телефон *" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="EMAIL" placeholder="E-mail *" value="<?=$arResult["arUser"]["EMAIL"]?>">
					</div>
					<div class="w-100"></div>
					<div class="form-group form-group--subscribe">
						<label class="custom-checkbox custom-checkbox--silver align-items-start">
							<input type="hidden" value="<?=$arResult['arUser']['UF_SUBSCRIBE']?>" name="UF_SUBSCRIBE">
							<input type="checkbox" class="custom-checkobox__value" name="UF_SUBSCRIBE"<?/*if($arResult['arUser']['UF_SUBSCRIBE'] == 1):*/?> checked<?/*endif;*/?>>
							<span class="custom-checkobox__icon"><svg class="icon"><use xlink:href="#check"></use></svg></span>
							<span class="custom-checkobox__text">Хочу получать уведомления<br> о скидках и акциях</span>
						</label>
					</div>
				</div>
			</div>

			<div class="personal__group">
				<h4 class="title">Адрес доставки</h4>

				<div class="form-row">
					<div class="form-group form-group--lg">
						<input type="text" name="UF_CITY" class="form-control" placeholder="Город" value="<?=$arResult['arUser']['UF_CITY']?>">
					</div>
					<div class="form-group form-group--sm">
						<input type="text" name="UF_ZIP" class="form-control" placeholder="Индекс" value="<?=$arResult['arUser']['UF_ZIP']?>">
					</div>
                    <div class="separator-md-down"></div>
					<div class="form-group form-group--lg">
						<input type="text" name="UF_STREET" class="form-control" placeholder="Улица" value="<?=$arResult['arUser']['UF_STREET']?>">
					</div>
					<div class="form-group form-group--sm form-group--house">
						<input type="text" name="UF_HOUSE" class="form-control" placeholder="Дом" value="<?=$arResult['arUser']['UF_HOUSE']?>">
					</div>
                    <div class="separator-md-down"></div>
					<div class="form-group form-group--md form-group--flat">
						<input type="text" name="UF_APPARTAMENT" class="form-control" placeholder="Квартира / офис" value="<?=$arResult['arUser']['UF_APPARTAMENT']?>">
					</div>
					<div class="w-100"></div>
					<div class="form-group form-footer">
						<input class="adp-btn adp-btn--md adp-btn--block adp-btn--primary" type="submit" name="save" value="Сохранить изменения">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="col-custom col-12 col-xl-4">
	<div class="personal__container">
		<h4 class="title">Пароль</h4>
		<p>Если вы забыли пароль или старый вам просто надоел, вы можете <a href="javascript:void(0)" class="btn-link--primary passRepeatLink">сменить пароль</a></p>
		<div class="passReset">
			<form method="post" name="form1" class="form form-personal" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
				<?=$arResult["BX_SESSION_CHECK"]?>
				<input type="hidden" name="lang" value="<?=LANG?>" />
				<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
				<input type="hidden" name="LOGIN" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
				<div class="formItem">
                    <div class="password-switching">
                        <input type="password" class="form-control" name="NEW_PASSWORD" placeholder="Пароль*">
                        <div class="password-switch">
                            <svg class="icon icon-md pass-hidden"><use xlink:href="#eye-close"></use></svg>
                            <svg class="icon icon-md pass-visible"><use xlink:href="#eye-open"></use></svg>
                        </div>
                    </div>
				</div>
				<div class="formItem">
                    <div class="password-switching">
                        <input type="password" class="form-control" name="NEW_PASSWORD_CONFIRM" placeholder="Подтверждение*">
                        <div class="password-switch">
                            <svg class="icon icon-md pass-hidden"><use xlink:href="#eye-close"></use></svg>
                            <svg class="icon icon-md pass-visible"><use xlink:href="#eye-open"></use></svg>
                        </div>
                    </div>
				</div>
				<div class="form-group passRepeatBtn">
					<input class="adp-btn adp-btn--md adp-btn--primary" type="submit" name="save" value="Изменить пароль">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="col-12">
	<div class="personal-review personal-review--mobile">
		<a data-fancybox data-type="ajax" data-touch="false" data-src="/local/ajax/form/review.php?ajax=y" href="javascript:void(0)" class="btn-link--primary"><svg class="icon"><use xlink:href="#speech-bubble"></use></svg>Оставить отзыв<br> о работе сервиса</a>
	</div>
</div>