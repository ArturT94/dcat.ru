<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


if(!$arResult["arUser"]["PERSONAL_PHONE"]){
    $user = new CUser;
    $fields = Array(
        "PERSONAL_PHONE"  => $arResult["arUser"]["UF_BXMAKER_AUPHONE"],
    );
    $user->Update($arResult["arUser"]["ID"], $fields);
    $arResult["arUser"]["PERSONAL_PHONE"] = $arResult["arUser"]["UF_BXMAKER_AUPHONE"];
//    $arResult["PERSONAL_BIRTHDAY"] = $arResult["PERSONAL_BIRTHDAY"]["UF_BXMAKER_AUPHONE"];
}