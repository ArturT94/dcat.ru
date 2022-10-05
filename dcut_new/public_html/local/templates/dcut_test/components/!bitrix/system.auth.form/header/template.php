<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CJSCore::Init();
?>
<?if($arResult["FORM_TYPE"] == "login"):?>
	<form name="system_auth_form<?=$arResult["RND"]?>" method="post" autocomplete="off" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<?if($arResult["BACKURL"] <> ''):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):
			if($key != 'USER_PHONE'):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endif;
		endforeach?>
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		
		<div class="ajaxContent">
			<?if($arResult['ERROR_MESSAGE']['ERROR_TYPE'] != 'LOGIN'):?>
				<?if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']) ShowMessage($arResult['ERROR_MESSAGE']);?>
			<?endif;?>
			<div class="modal-group">
				<input type="<?if($_REQUEST['USER_PHONE']):?>text<?else:?>hidden<?endif;?>" value="<?=$_REQUEST['USER_PHONE']?>" name="USER_PHONE" class="phoneMask form-control" placeholder="Номер телефона">
				<input type="<?if($_REQUEST['USER_PHONE']):?>hidden<?else:?>text<?endif;?>" name="USER_LOGIN" class="form-control<?if($arResult['ERROR_MESSAGE']['ERROR_TYPE'] == 'LOGIN'):?> novalid<?endif;?>" placeholder="E-mail">
			</div>
			<div class="modal-group">
                <div class="password-switching">
                    <input type="password" name="USER_PASSWORD" class="form-control<?if($arResult['ERROR_MESSAGE']['ERROR_TYPE'] == 'LOGIN'):?> novalid<?endif;?>" placeholder="Пароль">
                    <div class="password-switch">
                        <svg class="icon icon-md pass-hidden"><use xlink:href="#eye-close"></use></svg>
                        <svg class="icon icon-md pass-visible"><use xlink:href="#eye-open"></use></svg>
                    </div>
                </div>
				<div class="pass-remind"><a href="javascript:void(0)" data-fancybox data-touch="false" data-src="#forgot-pass">Забыли пароль?</a></div>
			</div>
			<div class="modal-group text-center">
				<input type="submit" name="Login" class="adp-btn adp-btn--md adp-btn--primary" value="Войти" placeholder="Войти">
			</div>
			<div class="modal-group text-center">
				<a href="javascript:void(0)" class="jsAuthPhone btn-link--primary">Войти по номеру телефона</a>
			</div>
			<div class="modal-group text-center">
                <div class="modal-text-separator">или</div>
            </div>
			<span></span>
			<script>
				$(document).ready(function(){
					$('.jsAuthPhone').on('click',function(){
						if($(this).hasClass('active')){
							$(this).removeClass('active');
							$('input[name=USER_LOGIN]').attr('type','text');
							$('input[name=USER_PHONE]').attr('type','hidden');
							$('input[name=USER_LOGIN]').focus();
							$('input[name=USER_LOGIN]').val("");
							$(this).html('Войти по номеру телефона');
						}else{
							$(this).addClass('active');
							$('input[name=USER_LOGIN]').attr('type','hidden');
							$('input[name=USER_PHONE]').attr('type','text');
							$('.phoneMask').mask('+7 (999)999-99-99');
							$('input[name=USER_PHONE]').focus();
							$(this).html('Войти по e-mail');
						}
					});
					$('input[name=USER_PHONE]').on('change',function(){
						$.getJSON('/local/ajax/phoneAuth.php',
							{
								VAL: $(this).val(),
							},
							function (data) {
								$('input[name=USER_LOGIN]').val(data);
							}
						);
					});
					
				});
				BX.ready(function() {
					var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
					if (loginCookie){
						var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
						var loginInput = form.elements["USER_LOGIN"];
						loginInput.value = loginCookie;
					}
				});
			</script>
		</div>
		<div class="modal-group text-center socialAuthModal">
			<div class="modal-social__title">Войти через соцсеть</div>
			<? $APPLICATION->IncludeComponent(
				"ulogin:auth",
				"",
				Array(
					"SEND_MAIL" => "N",
					"SOCIAL_LINK" => "Y",
					"GROUP_ID" => array("5"),
					"ULOGINID1" => "",
					"ULOGINID2" => ""
				)
			);
			?>
			<script>
				$('.ulogin-button-vkontakte').html('<svg class="icon"><use xlink:href="#vk"></use></svg>');
				$('.ulogin-button-facebook').html('<svg class="icon"><use xlink:href="#facebook"></use></svg>');
				$('.ulogin-button-google').html('<svg class="icon"><use xlink:href="#google-plus"></use></svg>');
			</script>
		</div>
	</form>
<?endif?>
