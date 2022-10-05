<? if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if($_REQUEST['ID']){	
	CModule::IncludeModule('iblock');
	$arSelect = Array("ID", "NAME", "PROPERTY_LIKE",'PROPERTY_DISLIKE');
	$arFilter = Array("IBLOCK_ID"=>COMMENTS_IBLOCK_ID, "ID"=>$_REQUEST['ID'], "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->Fetch()){
		$like = $ob['PROPERTY_LIKE_VALUE'];
		$dislike = $ob['PROPERTY_DISLIKE_VALUE'];
	}
	
	if(!$like){$like=0;}
	if(!$dislike){$dislike=0;}

	if($_REQUEST['TYPE'] == 'LIKE'){
		if($_REQUEST['COUNT'] == 0){
			if($like != 0){$like--;}
		}else{
			$like++;
		}
		CIBlockElement::SetPropertyValuesEx($_REQUEST['ID'], false, array('LIKE' => $like));
	}
	if($_REQUEST['TYPE'] == 'DISLIKE'){
		if($_REQUEST['COUNT'] == 0){
			if($dislike != 0){$dislike--;}
		}else{
			$dislike++;
		}
		CIBlockElement::SetPropertyValuesEx($_REQUEST['ID'], false, array('DISLIKE' => $dislike));
	}
	
	$result['LIKE'] = $like;
	$result['DISLIKE'] = $dislike;
	echo json_encode($result);
}else{
	echo 0;
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>