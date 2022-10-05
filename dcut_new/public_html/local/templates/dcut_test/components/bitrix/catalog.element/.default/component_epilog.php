<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
if($arResult['ID']){
    global $USER;
    if(!$USER->IsAuthorized()) {
        $arFavorites = $APPLICATION->get_cookie('favorites');
    }else{
        global $APPLICATION;
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $arUser = $rsUser->Fetch();
        $arFavorites = $arUser['UF_FAVORITES'];
    }
    $compareKey = 'CATALOG_COMPARE_LIST';
    if($_SESSION[$compareKey]){
        foreach($_SESSION[$compareKey] as $iblock){
            if($iblock['ITEMS'][$arResult['ID']]):?>
                <script>
                    $(document).ready(function(){
                        $('.add-compare[data-id=<?=$arResult['ID']?>]').addClass('active');
                    });
                </script>
            <?endif;
        }
    }
    if(in_array($arResult['ID'],$arFavorites)):?>
        <script>
            $(document).ready(function(){
                $('.add-favorites[data-id=<?=$arResult['ID']?>]').addClass('active');
            });
        </script>
    <?endif;?>
<?}?>