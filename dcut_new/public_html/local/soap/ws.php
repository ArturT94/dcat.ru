<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Главная страница");
?>
<?$APPLICATION->IncludeComponent(
	"prymery:webservice",
	"",
	array(
	),
	false
);?>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>