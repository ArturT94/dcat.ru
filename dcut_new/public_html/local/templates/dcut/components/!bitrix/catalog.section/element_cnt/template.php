<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);?>
<div class="search-results__count ajaxElementCnt">
    Найдено <?=$arResult["NAV_RESULT"]->NavRecordCount?> <?=endingsForm($arResult["NAV_RESULT"]->NavRecordCount,'товар','товара','товаров');?>
</div>