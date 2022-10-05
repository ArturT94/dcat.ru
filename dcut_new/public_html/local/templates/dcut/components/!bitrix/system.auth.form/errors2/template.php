<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)    die();
if($arResult['ERROR']):?>
	<?if($arResult['ERROR_MESSAGE']['TYPE'] == 'ERROR'):?>
		<script class="reload-on-ajax">
			$('.forgotInput').addClass('novalid');
		</script>
	<?else:?>
		<script class="reload-on-ajax">
			$('.forgotInput').addClass('valid');
			$('.forgotInput').removeClass('novalid');
			//$('.forgotFormAjax .modal-description').remove();
			//$('.forgotFormAjax input[name=send_account_info]').remove();
			$('.forgotFormAjax').html('<div class="modal-description">Сообщение с инструкциями отправлено вам на эл.почту</div>');
			$('.changeFormAjax').html('<div class="modal-description">Пароль успешно изменен</div>');
		</script>
	<?endif;?>
<?endif;?>