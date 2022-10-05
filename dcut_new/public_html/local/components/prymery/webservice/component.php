<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("webservice") || !CModule::IncludeModule("iblock"))
   return;
   
// наш новый класс наследуется от базового IWebService
class CAddWS extends IWebService
{
   // метод GetWebServiceDesc возвращает описание сервиса и его методов
   function GetWebServiceDesc() 
   {
      $wsdesc = new CWebServiceDesc();
      $wsdesc->wsname = "ds.webservice"; // название сервиса
      $wsdesc->wsclassname = "CAddWS"; // название класса
      $wsdesc->wsdlauto = true;
      $wsdesc->wsendpoint = CWebService::GetDefaultEndpoint();
      $wsdesc->wstargetns = CWebService::GetDefaultTargetNS();

      $wsdesc->classTypes = array();
	  $wsdesc->structTypes = array(
			"TUser" => array(
				"name" => array("varType" => "string", "strict" => "no"),
				"guid" => array("varType" => "string", "strict" => "no"),
			),
		);
      //$wsdesc->structTypes = Array();
	  $wsdesc->classes = array(
		   "CAddWS"=> array(
			  "Add" => array(
				 "type"      => "public",
				 "input"      => array(
					"LOGIN" => array("varType" => "string"),
					"NUMBER_CART" => array("varType" => "string"),
					"DESCRIPTION" => array("varType" => "string"),
					"PDF" => array("varType" => "string"),
					"MD_TYPE" => array("varType" => "string"),
					"DATE" => array("varType" => "string"),
					"MD_GUID" => array("varType" => "string"),
					),
				 "output"   => array(
					"id" => array("varType" => "boolean")
				 ),
				 "httpauth" => "Y"
			  ),
			  "Delete" => array(
				 "type"      => "public",
				 "input"      => array(
					"MD_GUID" => array("varType" => "string"),
					),
				 "output"   => array(
					"id" => array("varType" => "boolean")
				 ),
				 "httpauth" => "Y"
			  ),
			  "GetUser" => array(
				 "type"      => "public",
				 "input"      => array(
					"GROUP" => array("varType" => "string"),
					),
				 "output"   => array(
					"items" => array("varType" => "ArrayOfTUser",
                        "arrType" => "TUser")
				 ),
				 "httpauth" => "Y"
			  ),
		   )
		);

      return $wsdesc;
   }
   
   function Add($LOGIN, $NUMBER_CART, $DESCRIPTION, $PDF, $MD_TYPE, $DATE, $MD_GUID)
	{
	   $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
		$arFilter = Array("IBLOCK_ID"=>31, "PROPERTY_MD_GUID"=> $MD_GUID, "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
		while($ob = $res->Fetch()){
			$arCurFile = $ob;
		}
		$pdf_decoded = base64_decode ($PDF);
		$pdf = fopen ('/var/www/tatneft/site/test.pdf','w');
		fwrite ($pdf,$pdf_decoded);
		fclose ($pdf);
		
		$file = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].'/test.pdf');
		$fid = CFile::SaveFile($file,'custom');
		unlink('/var/www/tatneft/site/test.pdf');

	   $arFields = Array(
			 "IBLOCK_ID"=>31,
			 "NAME"=>$DESCRIPTION,
			 "PROPERTY_VALUES" => Array(
				'LOGIN' => $LOGIN,
				"NUMBER_CART"=>$NUMBER_CART,
				"DATE"=>$DATE,
				"PDF_FILE"=>$fid,
				'MD_TYPE' => $MD_TYPE,
				'MD_GUID' => $MD_GUID,
			)
		  );
	   $ib_element = new CIBlockElement();
	   if($arCurFile){
		   $bx_photo = CIBlockElement::GetProperty(
			   31, 
			   $arCurFile['ID'], 
			   'sort', 
			   'asc', 
			   array('CODE' => 'PDF_FILE')
			);
			$ar_photo = $bx_photo->Fetch();

		   CIBlockElement::SetPropertyValueCode($arCurFile['ID'], 'PDF_FILE', array(
			   $ar_photo['PROPERTY_VALUE_ID'] => array('del' => 'Y', 'tmp_name' => '')
			));
		   $result = $ib_element->Update($arCurFile['ID'],$arFields);
		   if($result>0)
			  return Array("id"=>$result);

	   }else{
		   $result = $ib_element->Add($arFields);
		   if($result>0){
			   return true;
		   }else{
			   return false;
		   }
			  
	   }
	}
	function Delete($MD_GUID)
	{
	   $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
		$arFilter = Array("IBLOCK_ID"=>31, "PROPERTY_MD_GUID"=> $MD_GUID, "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
		while($ob = $res->Fetch()){
			$arCurFile = $ob;
		}
		if($arCurFile){
			
		   $ib_element = new CIBlockElement();
		   $result = $ib_element->Delete($arCurFile['ID']);
		  return true;

		}else{
			return false;
		}
	  
	}
	function GetUser($GROUP)
	{
		if($GROUP == 6){
			$filter = Array ("GROUPS_ID" => $GROUP);
			$rsUsers = CUser::GetList(($by="ID"), ($order="asc"), $filter);
			while($user = $rsUsers->Fetch()){
				if($user['XML_ID']){
					$res['items'][$user['ID'].":TUser"] = array('name' => $user['LAST_NAME'].' '.$user['NAME'].' '.$user['SECOND_NAME'], 'guid' => $user['XML_ID']);
				}
			}

			return $res;
			//return "Иванов Иван Иванович.213123dsfdfsdfsdfsdsdf,Иванов2 Иван2 Иванович.324dsfdsfsdfsd";
		}else{
			return false;
		}
	}
}

$arParams["WEBSERVICE_NAME"] = "ds.webservice";
$arParams["WEBSERVICE_CLASS"] = "CAddWS";
$arParams["WEBSERVICE_MODULE"] = "";

// передаем в компонент описание веб-сервиса
$APPLICATION->IncludeComponent(
   "bitrix:webservice.server",
   "",
   $arParams
   );

die();
?>