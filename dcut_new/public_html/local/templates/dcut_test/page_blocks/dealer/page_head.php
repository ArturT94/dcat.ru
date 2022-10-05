<?global $USER;
$APPLICATION->IncludeComponent("bitrix:breadcrumb","dealer",array("START_FROM" => "0","PATH" => "","SITE_ID" => SITE_ID,"COMPONENT_TEMPLATE" => "prymery"),false);?>
<div class="container-large">
    <div class="content-titles profile-main-title">
        <div class="title">
            <h3>
                <?=$APPLICATION->ShowTitle(false);?>
                <?$APPLICATION->IncludeComponent("bitrix:menu","dealer",Array(
                        "ROOT_MENU_TYPE" => "dealer",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "top",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => ""
                    )
                );?>
                <svg width="14" height="7" class="icon"><use xlink:href="#triangle-down"></use></svg>
            </h3>
        </div>
        <button type="button" data-type="ajax" data-fancybox="" data-src="/local/ajax/form/dealer_consult.php?ajax=y&id=<?=$USER->GetId();?>" class="content-titles__button">Заказать консультацию</button>
    </div>
</div>
