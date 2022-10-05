<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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
<!--noindex-->
<div id="callback" class="modal modalShow<?if($arParams['~CUSTOM_CLASS']):?> <?=$arParams['~CUSTOM_CLASS']?><?endif;?>">
	<div class="modal-close" data-fancybox-close>
		<svg class="icon"><use xlink:href="#times"></use></svg>
	</div>
	<?if($arParams['~TITLE']):?><div class="modal-title text-left"><?=$arParams['~TITLE']?></div><?endif;?>
	<?if($arParams['~SUBTITLE']):?><div class="modal-description text-left"><?=$arParams['~SUBTITLE']?></div><?endif;?>
	<?if($arResult['ERROR_COUNTERS_ID']):?>
		<div class="prForm__error"><?=$arResult['ERROR_COUNTERS_ID']?></div>
	<?endif;?>
	<form enctype="multipart/form-data" class="prForm form form-modal form-callback" autocomplete="off" method="post" action="<?= $arResult['JS_OBJECT']['AJAX_PATH'] ?>">
		<?if($arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']):?>
			<input value="<?=$arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']?>" name="ELEMENT_NAME" type="hidden">
			<input value="<?=$arParams['ELEMENT_ID']?>" name="ELEMENT_ID" type="hidden">
		<?endif;?>
		<?if(!empty($arResult['FIELDS'])){?>
			<?foreach ($arResult['FIELDS'] as $field) {
				if ($field['CODE'] == 'MESSAGE' || $field['CODE'] == 'PLUS' || $field['CODE'] == 'MINUS'):?>
					<div class="modal-group is-empty">
						<textarea name="<?= $field['CODE'] ?>" rows="5" placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"
								  class="form-control <?=($field['REQUIRED'] == 'Y') ? ' required' : '' ?>"></textarea>
					</div>
				<?elseif($field['CODE'] != 'ELEMENT_ID'):?>
					<?if ($field['CODE'] == 'NAME'):?><div class="modal-group--inline"><?endif;?>
					<div class="modal-group is-empty">
						<input class="form-control<?= ($field['REQUIRED'] == 'Y') ? ' required' : '' ?>" 
							placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"	name="<?= $field['CODE'] ?>" type="text">
					</div>
					<?if($field['CODE'] == 'EMAIL'):?></div><?endif;?>
				<?endif;
			}?>
		<?}?>
		<div class="modal-group">
			<label class="custom-checkbox custom-checkbox--silver">
				<input type="checkbox" class="custom-checkobox__value" name="confirm-privacy" checked="">
				<span class="custom-checkobox__icon"><svg class="icon"><use xlink:href="#check"></use></svg></span>
				<span class="custom-checkobox__text">Я принимаю <a href="/privacy/" target="_blank" class="btn-link--primary">условия</a> хранения и обработки данных</span>
			</label>
		</div>
		<div class="modal-group">
			<button type="submit" class="adp-btn adp-btn--md adp-btn--primary"><?=$arParams['~BUTTON']?></button>
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

        .modal {
            display: block;
        }
    </style>
</div>
<!--/noindex-->