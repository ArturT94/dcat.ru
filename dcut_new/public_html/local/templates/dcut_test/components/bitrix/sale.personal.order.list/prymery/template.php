<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);
?>
<div class="profile-content">
    <?/*form action="" class="profile-search">
        <input type="text" name="search" placeholder="Поиск по заказам">
        <button><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.6937 17.4023L12.607 11.3156C13.5516 10.0945 14.0625 8.60156 14.0625 7.03125C14.0625 5.15156 13.3289 3.38906 12.0023 2.06016C10.6758 0.73125 8.90859 0 7.03125 0C5.15391 0 3.38672 0.733594 2.06016 2.06016C0.73125 3.38672 0 5.15156 0 7.03125C0 8.90859 0.733594 10.6758 2.06016 12.0023C3.38672 13.3312 5.15156 14.0625 7.03125 14.0625C8.60156 14.0625 10.0922 13.5516 11.3133 12.6094L17.4 18.6937C17.4178 18.7116 17.439 18.7258 17.4624 18.7354C17.4857 18.7451 17.5107 18.7501 17.5359 18.7501C17.5612 18.7501 17.5862 18.7451 17.6095 18.7354C17.6328 18.7258 17.654 18.7116 17.6719 18.6937L18.6937 17.6742C18.7116 17.6564 18.7258 17.6352 18.7354 17.6119C18.7451 17.5885 18.7501 17.5635 18.7501 17.5383C18.7501 17.513 18.7451 17.488 18.7354 17.4647C18.7258 17.4414 18.7116 17.4202 18.6937 17.4023ZM10.7438 10.7438C9.75 11.7352 8.43281 12.2812 7.03125 12.2812C5.62969 12.2812 4.3125 11.7352 3.31875 10.7438C2.32734 9.75 1.78125 8.43281 1.78125 7.03125C1.78125 5.62969 2.32734 4.31016 3.31875 3.31875C4.3125 2.32734 5.62969 1.78125 7.03125 1.78125C8.43281 1.78125 9.75234 2.325 10.7438 3.31875C11.7352 4.3125 12.2812 5.62969 12.2812 7.03125C12.2812 8.43281 11.7352 9.75234 10.7438 10.7438Z" fill="white"/></svg></button>
    </form*/?>
    <div class="profile-selection">
        <div class="section-row selection-row">
            <div class="section-column col-3">
                <div class="selection-item dropdown-one">Заказ
                    <?/*svg width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L5 5L10 0L0 0Z" /></svg*/?>
                </div>
            </div>
            <div class="section-column col-1">
                <div class="selection-item">Статус</div>
            </div>

            <div class="section-column col-2">
                <div class="selection-item dropdown-two">Цена
                    <?/*svg width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0L5 5L10 0L0 0Z" /></svg*/?>
                </div>
            </div>

            <div class="section-column col-4">
                <div class="selection-item">Действие</div>
            </div>
        </div>
    </div>

    <?if (!empty($arResult['ERRORS']['FATAL']))
    {
        foreach($arResult['ERRORS']['FATAL'] as $error)
        {
            ShowError($error);
        }
        $component = $this->__component;
        if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
        {
            $APPLICATION->AuthForm('', false, false, 'N', false);
        }

    }
    else
    {
        if (!empty($arResult['ERRORS']['NONFATAL']))
        {
            foreach($arResult['ERRORS']['NONFATAL'] as $error)
            {
                ShowError($error);
            }
        }
        if (!count($arResult['ORDERS'])) {?>
            <div class="history-orders-title"><h3>История заказов отсутствует</h3></div>
    <?}
        foreach ($arResult['ORDERS'] as $key => $order) {?>
            <div class="content-block">
                <div class="section-row profile-content-row">
                    <div class="section-column col-3">
                        <div class="content-block_order">
                            <div class="order-head">
                                <div class="order-number">Заказ №<?=$order['ORDER']['ACCOUNT_NUMBER']?></div>
                                <span>|</span>
                                <div class="order-date"><?=$order['ORDER']['DATE_INSERT_FORMATED']?></div>
                            </div>
                            <?foreach($order['BASKET_ITEMS'] as $item):?>
                                <div class="order-name">
                                    <?if($arResult['PRODUCTS'][$item['PRODUCT_ID']]['PROPERTY_CML2_ARTICLE_VALUE']):?>
                                        <a href="<?=$arResult['PRODUCTS'][$item['PRODUCT_ID']]['DETAIL_PAGE_URL']?>">Артикул: <?=$arResult['PRODUCTS'][$item['PRODUCT_ID']]['PROPERTY_CML2_ARTICLE_VALUE']?></a>
                                    <?endif;?>
                                    <a class="order-name-link" href="<?=$arResult['PRODUCTS'][$item['PRODUCT_ID']]['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                                </div>
                                <div class="order-amount"><?=$item['QUANTITY']?> шт.</div>
                            <?endforeach;?>
                        </div>
                    </div>
                    <div class="section-column col-1">
                        <div class="content-block_price">
                            <div class="order-status">Выполнен</div>
                            <div class="order-price_hidden"><?=$order['ORDER']['FORMATED_PRICE']?></div>
                        </div>
                    </div>
                    <div class="section-column col-2">
                        <div class="order-price"><?=$order['ORDER']['FORMATED_PRICE']?></div>
                    </div>
                    <div class="section-column col-4">
                        <div class="section-group_buttons">
                            <button class="section-sm-button">Посмотреть счет <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.60645 8L8.89677 4.5L5.60645 1M1 8L4.29032 4.5L1 1" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <a href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>" class="section-sm-button">Заказать еще <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.60645 8L8.89677 4.5L5.60645 1M1 8L4.29032 4.5L1 1" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        </div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
        <?
    }
    ?>

</div>