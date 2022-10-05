<div class="headerLogoSearch-links">
    <?
    $compareKey = 'CATALOG_COMPARE_LIST';
    $compare = 0;
    if($_SESSION[$compareKey]){
        foreach($_SESSION[$compareKey] as $iblock){
            $compare = $compare + count($iblock['ITEMS']);
        }
    }
    ?>
    <a href="/catalog/compare.php" title="Сравнить">
        <svg width="19" height="20" class="icon"><use xlink:href="#product-compare"></use></svg>
        <div class="circle"><span class="compareCount" data-count="<?=$compare?>"><?=$compare?></span></div>
    </a>
    <?
    if(!$USER->IsAuthorized()){
        global $APPLICATION;
        $favorites = $APPLICATION->get_cookie("favorites");
    }else {
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $arUser = $rsUser->Fetch();
        $favorites = $arUser['UF_FAVORITES'];
    }
    if(!$favorites){
        unset($favorites);
    }
    ?>
    <a href="/favorites/" title="Избранное">
        <svg width="23" height="20" class="icon"><use xlink:href="#product-like"></use></svg>
        <div class="circle"><span class="favoritesCount"><?=count($favorites)?></span></div>
    </a>
    <?global $USER;
    if($USER->IsAuthorized()):?>
    <div class="cart-link">
        <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "header", Array(
            "HIDE_ON_BASKET_PAGES" => "N",	// Не показывать на страницах корзины и оформления заказа
            "PATH_TO_BASKET" => SITE_DIR."basket/",	// Страница корзины
            "PATH_TO_ORDER" => SITE_DIR."order/",	// Страница оформления заказа
            "PATH_TO_PERSONAL" => SITE_DIR."personal/",	// Страница персонального раздела
            "PATH_TO_PROFILE" => SITE_DIR."personal/",	// Страница профиля
            "PATH_TO_REGISTER" => SITE_DIR."login/",	// Страница регистрации
            "POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
            "SHOW_AUTHOR" => "N",	// Добавить возможность авторизации
            "SHOW_DELAY" => "N",	// Показывать отложенные товары
            "SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
            "SHOW_IMAGE" => "Y",	// Выводить картинку товара
            "SHOW_NOTAVAIL" => "N",	// Показывать товары, недоступные для покупки
            "SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
            "SHOW_PERSONAL_LINK" => "N",	// Отображать персональный раздел
            "SHOW_PRICE" => "Y",	// Выводить цену товара
            "SHOW_PRODUCTS" => "Y",	// Показывать список товаров
            "SHOW_SUBSCRIBE" => "N",
            "SHOW_SUMMARY" => "N",	// Выводить подытог по строке
            "SHOW_TOTAL_PRICE" => "Y",	// Показывать общую сумму по товарам
            "COMPONENT_TEMPLATE" => "header_line"
        ),
            false
        );?>
    </div>
    <?endif;?>
</div>


