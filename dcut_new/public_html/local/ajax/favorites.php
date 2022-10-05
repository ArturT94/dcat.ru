<? if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;

if($_GET['ID'])
{
  if(!$USER->IsAuthorized()) 
  {
	$arElements = unserialize($APPLICATION->get_cookie('favorites'));
	if(!in_array($_GET['ID'], $arElements))
	{
		   $arElements[] = $_GET['ID'];
		   $result = 1; 
	}
	else {
		$key = array_search($_GET['ID'], $arElements);
		unset($arElements[$key]);
		$result = 2; 
	}
	$APPLICATION->set_cookie("favorites", serialize($arElements));
  }
  else { 
	 $idUser = $USER->GetID();
	 $rsUser = CUser::GetByID($idUser);
	 $arUser = $rsUser->Fetch();
	 $arElements = $arUser['UF_FAVORITES'];
	 if(!in_array($_GET['ID'], $arElements))
	 {
		$arElements[] = $_GET['ID'];
		$result = count($arElements);
	 }
	 else {
		$key = array_search($_GET['ID'], $arElements);
		unset($arElements[$key]);
		$result = count($arElements);
	 }
	 $USER->Update($idUser, Array("UF_FAVORITES"=>$arElements ));
  }
}
echo json_encode($result);


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>