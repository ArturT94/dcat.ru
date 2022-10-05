<div class="headerLogoSearch-logo">
    <?
    CModule::IncludeModule('iblock');
    $url = '/';
    $INDICATOR_IBLOCK_ID = 15;
    global $USER;
    $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), array('ID'=>$USER->GetId()),array('SELECT'=>array('UF_*')));
    while($arUser = $rsUsers->Fetch()){
        $arCurUser = $arUser;
    }
    if($arCurUser['UF_GUID']){
        $arSelect = Array("ID", "NAME", "PROPERTY_*","PROPERTY_INDICATOR");
        $arFilter = Array("IBLOCK_ID"=>13, "PROPERTY_GUID"=>$arCurUser['UF_GUID'], "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()) {
            $arCurLk = $ob;
        }
        $arSelect = Array("ID", "NAME", "PROPERTY_INDICATOR", "PROPERTY_GUID", "PROPERTY_VALUE");
        $arFilter = Array("IBLOCK_ID"=>$INDICATOR_IBLOCK_ID, "PROPERTY_GUID_USER"=>$arCurUser['UF_GUID'], "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()) {
            $userIndicator[$ob['PROPERTY_GUID_VALUE']] = $ob;
        }
        if($arCurLk){
            $url = '/';
        }
    }
    ?>
    <a href="<?=$url?>"><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/header/header-logo.png" alt="logo"></a>
    <div class="headerLogoSearch-logo__text"><a href="/">Строительные решения для профессионалов</a></div>
</div>