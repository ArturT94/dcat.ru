<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Sale;
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
<form enctype="multipart/form-data" class="prForm comment-form" autocomplete="off" method="post" action="<?= $arResult['JS_OBJECT']['AJAX_PATH'] ?>">
    <?if($arParams['~TITLE']):?><div class="form-title"><?=$arParams['~TITLE']?></div><?endif;?>
    <?if($arParams['~SUBTITLE']):?><div class="form-subtitle"><?=$arParams['~SUBTITLE']?></div><?endif;?>
    <?if($arResult['ERROR_COUNTERS_ID']):?>
        <div class="prForm__error"><?=$arResult['ERROR_COUNTERS_ID']?></div>
    <?endif;?>
    <input value="<?=$arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']?>" name="ELEMENT_NAME" type="hidden">
    <input value="<?=$arParams['ELEMENT_ID']?>" name="ELEMENT_ID" class="reviewPorudctId" type="hidden">
    <div class="form-contact">
        <?if(!empty($arResult['FIELDS'])){?>
            <?foreach ($arResult['FIELDS'] as $field) {
                if ($field['CODE'] == 'MESSAGE'):?>
                    </div>
                        <textarea name="<?= $field['CODE'] ?>" rows="8" placeholder="Отзыв<?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"
                                  class="form-control <?=($field['REQUIRED'] == 'Y') ? ' required' : '' ?>"></textarea>
                <?elseif ($field['CODE'] == 'RATING') :
                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/rating.php"); ?>
                        <script src="<?=$templateFolder?>/script.js?up=3"></script>
                <?elseif($field['CODE'] != 'ELEMENT_ID'):?>
                        <input placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>" class="form-control<?= ($field['REQUIRED'] == 'Y') ? ' required' : '' ?>" name="<?= $field['CODE'] ?>" type="text">
                <?endif;
            }?>
        <?}?>
    <? /*if($arParams['PERSONAL_DATA'] == 'Y') :?>
		<div class="form-group">
			<label class="custom-checkbox checkbox--primary">
				<input type="checkbox" class="checkbox-value" name="confirm-privacy">
				<span class="checkbox-icon"></span>
				<span class="checkbox-text">Я прочитал(а) и принимаю правила <a target="_blank" href="<?=$arParams['PERSONAL_DATA_PAGE']?>">политики конфиденциальности</a></span>
			</label>
		</div>
	<?endif;*/?>
    <div class="comment-form-control">
        <button type="submit" class="control_button dark-button"><span><?=$arParams['~BUTTON']?></span></button>
        <?/*div class="control_label">
            <label class="checkbox path">
                <input type="checkbox">
                <svg viewBox="0 0 21 21">
                    <path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186"></path>
                </svg>
            </label>
            <div>Я не робот</div>
        </div*/?>
    </div>
</form>
<div class="true-message" style="display: none;">
	<?=$arParams['TRUE_MESSAGE']?>
</div>
<script>$(document).ready(function(){initprForm(<?= CUtil::PhpToJSObject($arResult['JS_OBJECT']) ?>);});</script>
<style>
	.modal {
		display: block;
	}
</style>
<!--/noindex-->
