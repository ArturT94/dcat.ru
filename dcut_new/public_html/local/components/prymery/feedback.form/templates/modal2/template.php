<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<!--noindex-->
<div id="callback" class="modal-fancy modalShow<?if($arParams['~CUSTOM_CLASS']):?> <?=$arParams['~CUSTOM_CLASS']?><?endif;?>">
    <div class="section-popup call-popup">
        <?if($arParams['~TITLE']):?><div class="section-popup_title"><h3><?=$arParams['~TITLE']?></h3></div><?endif;?>
        <?if($arParams['~SUBTITLE']):?><div class="modal-description"><?=$arParams['~SUBTITLE']?></div><?endif;?>
        <?if($arResult['ERROR_COUNTERS_ID']):?>
            <div class="prForm__error"><?=$arResult['ERROR_COUNTERS_ID']?></div>
        <?endif;?>
        <form enctype="multipart/form-data" class="prForm form form-modal form-callback popup-form" autocomplete="off" method="post" action="<?= $arResult['JS_OBJECT']['AJAX_PATH'] ?>">
            <?if($arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']):?>
                <input value="<?=$arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']?>" name="ELEMENT_NAME" type="hidden">
                <input value="<?=$arParams['ELEMENT_ID']?>" name="ELEMENT_ID" type="hidden">
            <?endif;?>
            <?if($arParams['USER_NAME']):?>
                <input value="<?=$arParams['USER_NAME']?>" name="USER_NAME" type="hidden">
                <input value="<?=$arParams['USER_ID']?>" name="USER_ID" type="hidden">
                <input value="<?=$arParams['USER_GUID']?>" name="USER_GUID" type="hidden">
            <?endif;?>
            <?if(!empty($arResult['FIELDS'])){?>
                <?foreach ($arResult['FIELDS'] as $field) {
                    if ($field['CODE'] == 'MESSAGE'):?>
                            <textarea rows="5" name="<?= $field['CODE'] ?>" placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"
                                      class="form-control <?=($field['REQUIRED'] == 'Y') ? ' required' : '' ?>"></textarea>
                    <?elseif($field['CODE'] != 'ELEMENT_ID' && $field['CODE'] != 'USER_NAME' && $field['CODE'] != 'USER_ID' && $field['CODE'] != 'USER_GUID'):?>
                            <input class="popup-form_input form-control<?= ($field['REQUIRED'] == 'Y') ? ' required' : '' ?>"
                                placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"	name="<?= $field['CODE'] ?>" type="text">
                    <?endif;
                }?>
            <?}?>
            <? if($arParams['PERSONAL_DATA'] == 'Y') :?>
                <div class="privacyPolicy register-privacyPolicy">
                    <label for="one" class="privacyPolicy-popup_label"><input class="privacyPolicy-popup_input" type="checkbox" id="one" name="todo" value="todo">
                        <span></span>
                    </label>
                    <div class="privacyPolicy-link privacyPolicy-popup_link">С <a href="<?=$arParams['PERSONAL_DATA_PAGE']?>">Политикой обработки конфиденциальных данных</a>, а также <a href="<?=$arParams['PERSONAL_DATA_PAGE2']?>">Условиями сотрудничества с компанией DCUT</a> ознакомлен и согласен.</div>
                </div>
            <?endif;?>
            <button type="submit" class="popup-button dark-button"><span><?=$arParams['~BUTTON']?></span></button>
        </form>
        <div class="popup-footer_title"><h5>Конфиденциальность ваших данных гарантируется</h5></div>
        <div class="popup-close register-popup-close" data-fancybox-close="">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
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
</div>
<!--/noindex-->