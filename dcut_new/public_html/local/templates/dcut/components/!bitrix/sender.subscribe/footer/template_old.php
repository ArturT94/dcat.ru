<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$buttonId = $this->randString();
?>
<div class="bx-subscribe footer__subscribe"  id="sender-subscribe">
	<h4>Узнавайте первым<br> о новинках и акциях</h4>
	<?if(isset($arResult['MESSAGE'])): CJSCore::Init(array("popup"));?>
		<div id="sender-subscribe-response-cont" style="display: none;">
			<div class="bx_subscribe_response_container">
				<table>
					<tr>
						<td style="padding-right: 40px; padding-bottom: 0px;"><img src="<?=($this->GetFolder().'/images/'.($arResult['MESSAGE']['TYPE']=='ERROR' ? 'icon-alert.png' : 'icon-ok.png'))?>" alt=""></td>
						<td>
							<div style="font-size: 22px;"><?=GetMessage('subscr_form_response_'.$arResult['MESSAGE']['TYPE'])?></div>
							<div style="font-size: 16px;"><?=htmlspecialcharsbx($arResult['MESSAGE']['TEXT'])?></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<script>
			BX.ready(function(){
				var oPopup = BX.PopupWindowManager.create('sender_subscribe_component', window.body, {
					autoHide: true,
					offsetTop: 1,
					offsetLeft: 0,
					lightShadow: true,
					closeIcon: true,
					closeByEsc: true,
					overlay: {
						backgroundColor: 'rgba(57,60,67,0.82)', opacity: '80'
					}
				});
				oPopup.setContent(BX('sender-subscribe-response-cont'));
				oPopup.show();
				$('input[name=SENDER_SUBSCRIBE_EMAIL]').focus(function(){
					$(this).removeClass('novalid');
				});
				if($('#sender-subscribe-response-cont tr td:last-child div:first-child').text() == 'Что-то пошло не так'){
					$('input[name=SENDER_SUBSCRIBE_EMAIL]').addClass('novalid');
				}else if($('#sender-subscribe-response-cont tr td:last-child div:first-child').text() != 'Поздравляем!'){
					$('input[name=SENDER_SUBSCRIBE_EMAIL]').addClass('successInput');
				}
			});
		</script>
	<?endif;?>

	<script>
	

		(function () {
			
				
			var btn = BX('bx_subscribe_btn_<?=$buttonId?>');
			var form = BX('bx_subscribe_subform_<?=$buttonId?>');

			if(!btn){
				return;
			}

			function mailSender(){
				setTimeout(function() {
					if(!btn){
						return;
					}
					$('input[name=SENDER_SUBSCRIBE_EMAIL]').addClass('successInput');
					//var btn_span = btn.querySelector("span");
					//var btn_subscribe_width = btn_span.style.width;
					//BX.addClass(btn, "send");
					//btn_span.outterHTML = "<span><i class='fa fa-check'></i> <?=GetMessage("subscr_form_button_sent")?></span>";
			
				}, 400);
			}
			function mailSender2(){
				setTimeout(function() {
					var split_email = $('input[name=SENDER_SUBSCRIBE_EMAIL]').val().split('@');
					if(split_email[1]){
						$('input[name=SENDER_SUBSCRIBE_EMAIL]').addClass('successInput');
					}else{
						$('input[name=SENDER_SUBSCRIBE_EMAIL]').addClass('novalid');
					}
				}, 400);
			}
			BX.ready(function(){
				BX.bind(btn, 'click', function() {
					setTimeout(mailSender, 250);
					return false;
				});
			});

			BX.bind(form, 'submit', function (result) {
				setTimeout(mailSender2, 500);
				
				
				btn.disabled=true;
				setTimeout(function () {
					btn.disabled=false;
				}, 2000);

				return true;
			});
		})();
	</script>
		
	<form id="bx_subscribe_subform_<?=$buttonId?>" class="footer__subscribe__form" role="form" method="post" action="<?=$arResult["FORM_ACTION"]?>">
		<?=bitrix_sessid_post()?>
		<input type="hidden" name="sender_subscription" value="add">
		<input class="form-control" type="email" name="SENDER_SUBSCRIBE_EMAIL" value="<?=$arResult["EMAIL"]?>" placeholder="E-mail">

		<div style="<?=($arParams['HIDE_MAILINGS'] <> 'Y' ? '' : 'display: none;')?>">
			<?if(count($arResult["RUBRICS"])>0):?>
				<div class="bx-subscribe-desc"><?=GetMessage("subscr_form_title_desc")?></div>
			<?endif;?>
			<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<div class="bx_subscribe_checkbox_container">
				<input type="checkbox" name="SENDER_SUBSCRIBE_RUB_ID[]" id="SENDER_SUBSCRIBE_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?>>
				<label for="SENDER_SUBSCRIBE_RUB_ID_<?=$itemValue["ID"]?>"><?=htmlspecialcharsbx($itemValue["NAME"])?></label>
			</div>
			<?endforeach;?>
		</div>

		

		<div class="bx_subscribe_submit_container">
			<button class="sender-btn btn-subscribe" id="bx_subscribe_btn_<?=$buttonId?>"><svg class="icon"><use xlink:href="#arrow-right"></use></svg></button>
		</div>
	</form>

</div>