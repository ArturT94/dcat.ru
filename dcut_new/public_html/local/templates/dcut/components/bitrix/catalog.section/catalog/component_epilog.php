<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if($arResult['IDS']){
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

    foreach($arResult['IDS'] as $id):
        if($_SESSION[$compareKey]){
            foreach($_SESSION[$compareKey] as $iblock){
                if($iblock['ITEMS'][$id]):?>
                    <script>
                        $(document).ready(function(){
                            $('.add-compare[data-id=<?=$id?>]').addClass('active');
                        });
                    </script>
                <?endif;
            }
        }

        if(in_array($id,$arFavorites)):?>
            <script>
                $(document).ready(function(){
                    $('.add-favorites[data-id=<?=$id?>]').addClass('active');
                });
            </script>
        <?endif;?>
    <?endforeach;?>
<?}?>