<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<!--noindex-->
<div>
	<form enctype="multipart/form-data" class="prForm form form-modal form-callback comment-form contacts-form" autocomplete="off" method="post" action="<?= $arResult['JS_OBJECT']['AJAX_PATH'] ?>">
        <?if($arParams['~TITLE']):?><div class="form-title contacts-form-title"><?=$arParams['~TITLE']?></div><?endif;?>
        <?if($arParams['~SUBTITLE']):?><div class="modal-description"><?=$arParams['~SUBTITLE']?></div><?endif;?>
        <?if($arResult['ERROR_COUNTERS_ID']):?>
            <div class="prForm__error"><?=$arResult['ERROR_COUNTERS_ID']?></div>
        <?endif;?>

		<?if($arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']):?>
			<input value="<?=$arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']?>" name="ELEMENT_NAME" type="hidden">
			<input value="<?=$arParams['ELEMENT_ID']?>" name="ELEMENT_ID" type="hidden">
		<?endif;?>
		<?if(!empty($arResult['FIELDS'])){?>
            <div class="form-contact contacts-form-contact">
                <?foreach ($arResult['FIELDS'] as $field) {
                    if($field['CODE'] != 'ELEMENT_ID' && $field['CODE'] != 'MESSAGE'):?>
                            <input class="contacts-form-contact-input form-control<?= ($field['REQUIRED'] == 'Y') ? ' required' : '' ?>"
                                placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"	name="<?= $field['CODE'] ?>" type="text">
                    <?endif;
                }?>
            </div>
			<?foreach ($arResult['FIELDS'] as $field) {
				if ($field['CODE'] == 'MESSAGE'):?>
						<textarea rows="5" name="<?= $field['CODE'] ?>" placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"
								  class="contacts-form-contact-textarea form-control <?=($field['REQUIRED'] == 'Y') ? ' required' : '' ?>"></textarea>
				<?endif;
			}?>
		<?}?>
        <div class="comment-form-control contacts-form-control">
            <button type="submit" class="control_button contacts-control_button dark-button"><span><?=$arParams['~BUTTON']?></span></button>
            <div class="control_label contacts_label">
                <?/*label class="checkbox path">
                    <input type="checkbox">
                    <svg viewBox="0 0 21 21">
                        <path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186">
                        </path>
                    </svg>
                </label*/?>
                <div class="contacts_label-div">Нажимая на кнопку "отправить" вы соглашаетесь с <a href="/policy/" target="_blank">Политикой обработки конфиденциальных данных</a>, а также <a href="/uslovia/" target="_blank">Условиями сотрудничества с компанией DCUT</a></div>
            </div>
        </div>
		<?/* if($arParams['PERSONAL_DATA'] == 'Y') :?>
			<div class="confirm-text">
				<?=GetMessage('PRYMERY_FF_PERSONAL_DATA');?>
				<?if($arParams['PERSONAL_DATA_PAGE']):?>
					<a href="<?=$arParams['PERSONAL_DATA_PAGE']?>">
				<?endif;?>
				<?=GetMessage('PRYMERY_FF_PERSONAL_DATA_2');?>
				<?if($arParams['PERSONAL_DATA_PAGE']):?>
					</a>
				<?endif;?>
			</div>
		<?endif;*/?>
	</form>
	<div class="true-message" style="display: none;">
		<?=$arParams['TRUE_MESSAGE']?>
	</div>
	<script>$(document).ready(function(){initprForm(<?= CUtil::PhpToJSObject($arResult['JS_OBJECT']) ?>);});$('input[name=PHONE]').mask("+7 (999) 999-99-99");</script>
    <style>
        .modal {display: block;}
    </style>
</div>
<!--/noindex-->