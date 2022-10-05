<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
__IncludeLang(dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/'.basename(__FILE__));

$curPage = $GLOBALS['APPLICATION']->GetCurPage($get_index_page=false);

if ($curPage != SITE_DIR)
{
    if (empty($arResult) || (!empty($arResult[count($arResult)-1]['LINK']) && $curPage != urldecode($arResult[count($arResult)-1]['LINK'])))
        $arResult[] = array('TITLE' =>  htmlspecialcharsback($GLOBALS['APPLICATION']->GetTitle(false, true)), 'LINK' => $curPage);
}

if(empty($arResult))
    return "";

$strReturn = '<div class="nav-links"><div class="nav-links__container">';
$strReturn .= '<a href="/"><span class="nav-links-link">DCUT</span> <svg width="8" height="4" class="icon"><use xlink:href="#angle-right"></use></svg></a>';

$num_items = count($arResult);
for($index = 0, $itemSize = $num_items; $index < $itemSize; $index++)
{
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
        $strReturn .= '<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'"><span class="nav-links-link">'.$title.'</span> <svg width="8" height="4" class="icon"><use xlink:href="#angle-right"></use></svg></a>';
    else
        $strReturn .= '<span>'.$title.'</span>';
}

$strReturn .= '</div></div>';
return $strReturn;?>
