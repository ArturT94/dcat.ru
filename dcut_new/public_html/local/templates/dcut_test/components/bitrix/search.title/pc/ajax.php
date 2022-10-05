<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult["CATEGORIES"]) && $arResult['CATEGORIES_ITEMS_EXISTS']):?>
    <div class="title-search-result2">
        <?//foreach($arResult["CATEGORIES"][0]["ITEMS"] as $category_id => $arCategory):?>
            <?foreach($arResult["CATEGORIES"][0]["ITEMS"] as $i => $arItem):
                if($arItem["NAME"] == 'остальные' || $arItem["NAME"] == 'Все результаты'){
                    continue;
                }
                unset($arActiveEl);
                $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE",'PROPERTY_CML2_ARTICLE');
                $arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, 'ID'=>$arItem['ITEM_ID']);
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                while($ob = $res->Fetch()){
                    $arActiveEl = $ob;
                }
                ?>
                <div>
                    <?if($category_id === "all"):?>
                        <div class="title-search-all"><a href="<?echo $arItem["URL"]?>"><?//=$arActiveEl['PROPERTY_CML2_ARTICLE_VALUE']?> <?echo $arItem["NAME"]?></a></div>
                    <?elseif(isset($arActiveEl["PREVIEW_PICTURE"])):?>
                        <div class="title-search-item"><a href="<?echo $arItem["URL"]?>"><img src="<?=CFile::GetPath($arActiveEl['PREVIEW_PICTURE']);?>"><?//=$arActiveEl['PROPERTY_CML2_ARTICLE_VALUE']?> <?echo $arItem["NAME"]?></a></div>
                    <?else:?>
                        <div class="title-search-more"><a href="<?echo $arItem["URL"]?>"><?//=$arActiveEl['PROPERTY_CML2_ARTICLE_VALUE']?> <?echo $arItem["NAME"]?></a></div>
                    <?endif;?>
                </div>
            <?endforeach;?>
        <?//endforeach;?>
    </div>
<?endif;
?>