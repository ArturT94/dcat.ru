<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)  die();
IncludeTemplateLangFile(__FILE__);
?>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-column">
            <div class="footer-item">
                <div class="logo"><a href="/" class="hvr-bob"><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/header/logo.svg" alt="logo"></a></div>
                <div class="logo-text">Строительные решения для профессионалов</div>
            </div>
        </div>
        <div class="footer-block-mob one">
            <div class="footer-item dropdown-footer">
                <div class="title dropdown">
                    <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/footer_menu_title.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                </div>
                <?$APPLICATION->IncludeComponent("bitrix:menu","bottom",Array(
                        "ROOT_MENU_TYPE" => "bottom1",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => ""
                    )
                );?>
            </div>
            <div class="footer-item dropdown-footer">
                <div class="title dropdown">
                    <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/footer_menu_title2.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                </div>
                <?$APPLICATION->IncludeComponent("bitrix:menu","bottom",Array(
                        "ROOT_MENU_TYPE" => "bottom2",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => ""
                    )
                );?>
            </div>
            <div class="footer-item dropdown-footer">
                <div class="title dropdown">Контакты</div>
                <div class="links">
                    <a href="/contacts/" target="blank">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH" => "/local/templates/dcut/include_areas/location.php"
                            ),
                            false
                        );?>
                    </a>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => "/local/templates/dcut/include_areas/main_phone.php"
                        ),
                        false
                    );?>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => "/local/templates/dcut/include_areas/main_email.php"
                        ),
                        false
                    );?>
                </div>
            </div>
        </div>
        <div class="footer-column column-sm-hidden">
            <div class="footer-item">
                <div class="title">
                    <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/footer_menu_title.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                </div>
                <?$APPLICATION->IncludeComponent("bitrix:menu","bottom",Array(
                        "ROOT_MENU_TYPE" => "bottom1",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => ""
                    )
                );?>
            </div>
        </div>
        <div class="footer-column column-sm-hidden">
            <div class="footer-item">
                <div class="title">
                    <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/footer_menu_title2.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                </div>
                <?$APPLICATION->IncludeComponent("bitrix:menu","bottom",Array(
                        "ROOT_MENU_TYPE" => "bottom2",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => ""
                    )
                );?>
            </div>
        </div>
        <div class="footer-column column-sm-hidden">
            <div class="footer-item">
                <div class="title">Контакты</div>
                <div class="links">
                    <a href="/contacts/">
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",array("AREA_FILE_SHOW" => "file","AREA_FILE_SUFFIX" => "inc","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => "","COMPONENT_TEMPLATE" => ".default","PATH" => "/local/templates/dcut/include_areas/location.php"),false);?>
                    </a>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include","",array("AREA_FILE_SHOW" => "file","AREA_FILE_SUFFIX" => "inc","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => "","COMPONENT_TEMPLATE" => ".default","PATH" => "/local/templates/dcut/include_areas/main_phone.php"),false);?>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include","",array("AREA_FILE_SHOW" => "file","AREA_FILE_SUFFIX" => "inc","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => "","COMPONENT_TEMPLATE" => ".default","PATH" => "/local/templates/dcut/include_areas/main_email.php"),false);?>
                </div>
            </div>
        </div>
        <div class="footer-column">
            <div class="footer-item">
                <form class="form" action="/catalog/">
                    <input type="text" name="q" placeholder="Введите запрос">
                    <button><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/header/search.png" alt="search"></button>
                </form>
                <div class="contact">
                    <div class="hours">
                        <div>Режим работы:</div>
                        <div>
                            <?$APPLICATION->IncludeComponent("bitrix:main.include","",array("AREA_FILE_SHOW" => "file","AREA_FILE_SUFFIX" => "inc","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => "","COMPONENT_TEMPLATE" => ".default","PATH" => "/local/templates/dcut/include_areas/working_time_footer.php"),false);?>
                        </div>
                    </div>
                    <div class="social">
                        <div>Мы в соцсетях:</div>
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array("AREA_FILE_SHOW" => "file","PATH" => "/local/templates/dcut/include_areas/social.php","AREA_FILE_SUFFIX" => "","AREA_FILE_RECURSIVE" => "Y","EDIT_TEMPLATE" => ""));?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright">
    <div class="copyright-container">
        <div>Copyright &copy; LLC "DCUT”, <?=date('Y');?></div> <span>|</span> <div>Все права защищены &copy; LLC "DCUT”, <?=date('Y');?></div>
    </div>
</div>

<div class="container-popup container-register-popup">
    <div class="section-popup register-popup">
        <div class="section-popup_title"><h3>Регистрация</h3></div>
        <form class="popup-form">
            <input type="text" name="name" class="popup-form_input" placeholder="Ваше имя*">
            <input type="text" name="email" class="popup-form_input" placeholder="Ваше E-mail*">
            <input type="password" name="password" class="popup-form_input" placeholder="Пароль*">
            <input type="password" name="password" class="popup-form_input" placeholder="Повторите пароль*">
            <div class="privacyPolicy register-privacyPolicy">
                <label for="one" class="privacyPolicy-popup_label">
                    <input class="privacyPolicy-popup_input" type="checkbox" id="one" name="todo" value="todo">
                    <span></span>
                </label>
                <div class="privacyPolicy-link privacyPolicy-popup_link">С <a href="#">Политикой обработки конфиденциальных данных</a>, а также <a href="#">Условиями сотрудничества с компанией DCUT</a> ознакомлен и согласен.</div>
            </div>
            <button type="submit" class="popup-button dark-button"><span>Зарегистрироваться</span></button>
        </form>
        <div class="popup-footer_title"><h5>Конфиденциальность ваших данных гарантируется</h5></div>
        <div class="popup-close register-popup-close">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>
</div>

<div class="container-popup container-enter-popup">
    <div class="section-popup enter-popup">
        <div class="section-popup_title"><h3>Вход</h3></div>
        <form class="popup-form">
            <input type="text" name="email" class="popup-form_input" placeholder="Ваше E-mail">
            <input type="password" name="password" class="popup-form_input" placeholder="Пароль">

            <a href="#" class="enter-link forget-password">Забыли пароль?</a>
            <a href="#" class="enter-link have-account register-modal">Еще нет аккаунта? Регистрация</a>

            <button type="submit" class="popup-button enter-button dark-button"><span>Вход</span></button>
        </form>
        <div class="popup-footer_title"><h5>Конфиденциальность ваших данных гарантируется</h5></div>
        <div class="popup-close register-popup-close">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>
</div>



<div class="container-popup container-consult-popup">
    <div class="section-popup consult-popup">
        <div class="section-popup_title"><h3>Заказать консультацию</h3></div>
        <form class="popup-form">
            <input type="text" name="name" class="popup-form_input" placeholder="Ваше имя*">
            <input type="text" name="email" class="popup-form_input" placeholder="Контактный телефон*">
            <div class="privacyPolicy register-privacyPolicy">
                <label for="one" class="privacyPolicy-popup_label">
                    <input class="privacyPolicy-popup_input" type="checkbox" id="one" name="todo" value="todo">
                    <span></span>
                </label>
                <div class="privacyPolicy-link privacyPolicy-popup_link">С <a href="#">Политикой обработки конфиденциальных данных</a>, а также <a href="#">Условиями сотрудничества с компанией DCUT</a> ознакомлен и согласен.</div>
            </div>
            <button type="submit" class="popup-button dark-button"><span>Отправить</span></button>
        </form>
        <div class="popup-footer_title"><h5>Конфиденциальность ваших данных гарантируется</h5></div>
        <div class="popup-close register-popup-close">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>
</div>

<div class="container-popup container-docs-popup">
    <div class="section-popup docs-popup">
        <div class="section-popup_title"><h3>Документы</h3></div>
        <div class="container-into-docs-popup">
            <div class="docs-title">Стамеска 'Bailey™' с деревянной рукояткой 1-16-381, 2-16-382, 383, 384, 385, 386, 387, 388, 389, 390</div>
            <div class="docs-row">
                <div class="docs-column">
                    <div class="popup-doc">
                        <div class="popup-doc_img"><img class="hvr-bob" src="img/popup/doc-icon.svg" alt="img"></div>
                        <div class="popup-doc_title">Сертификат соответствия</div>
                        <div class="docs-group-link">
                            <a href="#" class="doc-open">Открыть <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.60645 8L8.89677 4.5L5.60645 1M1 8L4.29032 4.5L1 1" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                            <a href="#" download="" class="doc-download">Скачать <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.60645 8L8.89677 4.5L5.60645 1M1 8L4.29032 4.5L1 1" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        </div>
                    </div>
                </div>
                <div class="docs-column">
                    <div class="popup-doc">
                        <div class="popup-doc_img"><img class="hvr-bob" src="img/popup/doc-icon.svg" alt="img"></div>
                        <div class="popup-doc_title">Технические характеристики</div>
                        <div class="docs-group-link">
                            <a href="#" class="doc-open">Открыть <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.60645 8L8.89677 4.5L5.60645 1M1 8L4.29032 4.5L1 1" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                            <a href="#" download="" class="doc-download">Скачать <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.60645 8L8.89677 4.5L5.60645 1M1 8L4.29032 4.5L1 1" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        </div>
                    </div>
                </div>
                <div class="docs-column">
                    <div class="popup-doc">
                        <div class="popup-doc_img"><img class="" src="img/popup/doc-icon.svg" alt="img"></div>
                        <div class="popup-doc_title">Руководство пользователя</div>
                        <div class="docs-group-link">
                            <a href="#" class="doc-open">Открыть <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.60645 8L8.89677 4.5L5.60645 1M1 8L4.29032 4.5L1 1" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                            <a href="#" download="" class="doc-download">Скачать <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.60645 8L8.89677 4.5L5.60645 1M1 8L4.29032 4.5L1 1" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-close register-popup-close">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>
</div>

<div class="container-popup container-click-popup">
    <div class="section-popup click-popup">
        <div class="section-popup_title"><h3>Купить в 1 клик</h3></div>
        <div class="popup-row click-row">
            <div class="popup-column click-column-one">
                <div class="product-name">Стамеска 'Bailey™' с деревянной рукояткой 1-16-381, 2-16-382, 383, 384, 385, 386, 387, 388, 389, 390</div>
                <div class="slider">
                    <div class="slider-for-popup click-slider-popup">
                        <span><img class=" click-img hover-zoom" src="img/card/for-lg.webp" alt="img" data-large=""></span>
                        <span><img class=" click-img hover-zoom" src="img/card/for-lg.webp" alt="img" data-large=""></span>
                        <span><img class=" click-img hover-zoom" src="img/card/for-lg.webp" alt="img" data-large=""></span>
                        <span><img class=" click-img hover-zoom" src="img/card/for-lg.webp" alt="img" data-large=""></span>
                        <span><img class=" click-img hover-zoom" src="img/card/for-lg.webp" alt="img" data-large=""></span>
                        <span><img class=" click-img hover-zoom" src="img/card/for-lg.webp" alt="img" data-large=""></span>
                    </div>
                </div>
                <div class="product-price">118 000 руб.</div>
            </div>
            <div class="popup-column click-column-two">
                <div class="click-title">Заполните данные для заказа</div>
                <form action="" class="click-form">
                    <input class="input click-input" placeholder="Ваше имя*">
                    <input class="input click-input" placeholder="Ваш телефон или E-mail*">
                    <textarea class="click-textarea" name="" id="" cols="30" rows="10" placeholder="Текст сообщения"></textarea>
                </form>
                <div class="privacyPolicy register-privacyPolicy click-privacyPolicy">
                    <label for="one" class="privacyPolicy-popup_label">
                        <input class="privacyPolicy-popup_input" type="checkbox" id="one" name="todo" value="todo">
                        <span></span>
                    </label>
                    <div class="privacyPolicy-link privacyPolicy-popup_link">С <a href="#">Политикой обработки конфиденциальных данных</a>, а также <a href="#">Условиями сотрудничества с компанией DCUT</a> ознакомлен и согласен.</div>
                </div>
                <button class="click-button dark-button"><span>Купить</span></button>
            </div>
        </div>
        <div class="popup-footer">Конфиденциальность ваших данных гарантируется</div>
        <div class="popup-close register-popup-close">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>
</div>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(53956699, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/53956699" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>