<?if (!defined('PUBLIC_AJAX_MODE')) {
    define('PUBLIC_AJAX_MODE', true);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION, $USER;

switch($_REQUEST['TYPE'])
{
    case "SEND_PWD":
    {
        $APPLICATION->IncludeComponent(
            "bitrix:system.auth.form",
            "errors2",
            Array(
                "REGISTER_URL" => "",
                "FORGOT_PASSWORD_URL" => "",
                "PROFILE_URL" => "/personal/profile/",
                "SHOW_ERRORS" => "Y"
            )
        );
        $APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd","",Array());
    }
        break;
	case "CHANGE_PWD":
    {
        $APPLICATION->IncludeComponent(
            "bitrix:system.auth.form",
            "errors2",
            Array(
                "REGISTER_URL" => "",
                "FORGOT_PASSWORD_URL" => "",
                "PROFILE_URL" => "/personal/profile/",
                "SHOW_ERRORS" => "Y"
            )
        );
        $APPLICATION->IncludeComponent("bitrix:system.auth.changepasswd","",Array());
    }
        break;

    case "REGISTRATION":
    {
        $APPLICATION->IncludeComponent(
            "bitrix:system.auth.form",
            "errors",
            Array(
                "REGISTER_URL" => "",
                "FORGOT_PASSWORD_URL" => "",
                "PROFILE_URL" => "",
                "SHOW_ERRORS" => "Y"
            )
        );
        $APPLICATION->IncludeComponent("bitrix:main.register", "modal", Array(
			"SHOW_FIELDS" => array(	// Поля, которые показывать в форме
					0 => "EMAIL",
					1 => "NAME",
					2 => "PERSONAL_PHONE",
				),
				"REQUIRED_FIELDS" => array(	// Поля, обязательные для заполнения
					0 => "EMAIL",
					1 => "NAME",
					2 => "PERSONAL_PHONE",
				),
				"AUTH" => "Y",	// Автоматически авторизовать пользователей
				"USE_BACKURL" => "Y",	// Отправлять пользователя по обратной ссылке, если она есть
				"SUCCESS_PAGE" => "",	// Страница окончания регистрации
				"SET_TITLE" => "N",	// Устанавливать заголовок страницы
				"USER_PROPERTY" => "",	// Показывать доп. свойства
				"USER_PROPERTY_NAME" => "",	// Название блока пользовательских свойств
				"COMPONENT_TEMPLATE" => ".default"
			),
			false
		);
        if($USER->IsAuthorized()){
            $APPLICATION->RestartBuffer();
            $backurl = $_REQUEST["backurl"] ? $_REQUEST["backurl"] : '/';
            ?>
            <p>Вы успешно зарегистрированы на сайте!</p>
            <p>Сейчас страница автоматически перезагрузится и Вы сможете продолжить покупки</p>
            <script>
                function TSRedirectUser(){
                    //window.location.href = '<?=$backurl;?>';
                    window.location.reload();
                }
				$('.socialAuthModal').hide();
                window.setTimeout('TSRedirectUser()',2000);
            </script>
        <?
        }
    }
        break;

    default:
    {
        $APPLICATION->IncludeComponent(
            "bitrix:system.auth.form",
            "header2",
            Array(
                "REGISTER_URL" => "",
                "FORGOT_PASSWORD_URL" => "",
                "PROFILE_URL" => "/personal/profile/",
                "SHOW_ERRORS" => "Y"
            )
        );
        if($USER->IsAuthorized()){
            $APPLICATION->RestartBuffer();
            $backurl = $_REQUEST["backurl"] ? $_REQUEST["backurl"] : '/';
            ?>
			<p>Вы успешно вошли на сайт!</p>
            <p>Сейчас страница автоматически перезагрузится и Вы сможете продолжить покупки</p>
            <script>
                function TSRedirectUser(){
                    //window.location.href = '<?=$backurl;?>';
                    window.location.reload();
                }
				$('.socialAuthModal').hide();
                window.setTimeout('TSRedirectUser()',2000);
            </script>
        <?
        }
    }
}