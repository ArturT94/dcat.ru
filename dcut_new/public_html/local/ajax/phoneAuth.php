<?
 if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


if($_REQUEST['VAL']):
    $filter = Array("PERSONAL_PHONE" => $_REQUEST['VAL']);
	$rsUsers = CUser::GetList(($by="ID"), ($order="desc"), $filter);
	while($arUser = $rsUsers->Fetch()){
		$arCurUser = $arUser['LOGIN'];
	}

    $arJSON = $arCurUser;
    echo json_encode($arJSON);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>