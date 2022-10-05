<?
require_once(implode('/', [__DIR__, implode('.', ['include', 'php'])]));
//include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");

if(file_exists($_SERVER['DOCUMENT_ROOT']."/local/php_interface/include/constants.php"))
    require_once($_SERVER['DOCUMENT_ROOT']."/local/php_interface/include/constants.php");

if(file_exists($_SERVER['DOCUMENT_ROOT']."/local/php_interface/include/functions.php"))
	require_once($_SERVER['DOCUMENT_ROOT']."/local/php_interface/include/functions.php");
	
if(file_exists($_SERVER['DOCUMENT_ROOT']."/local/php_interface/include/event_handler.php"))
	require_once($_SERVER['DOCUMENT_ROOT']."/local/php_interface/include/event_handler.php");

CModule::AddAutoloadClasses(
    '', // не указываем имя модуля
    array(
        // ключ - имя класса, значение - путь относительно корня сайта к файлу с классом
        'Prymery\Regionality' => '/local/php_interface/classes/Prymery/Regionality.php',
    )
);


/*if (!function_exists('custom_mail') && COption::GetOptionString("webprostor.smtp", "USE_MODULE") == "Y")
{
   function custom_mail($to, $subject, $message, $additional_headers='', $additional_parameters='')
   {
      if(CModule::IncludeModule("webprostor.smtp"))
      {
         $smtp = new CWebprostorSmtp("s1");
         $result = $smtp->SendMail($to, $subject, $message, $additional_headers, $additional_parameters);

         if($result)
            return true;
         else
            return false;
      }
   }
}*/