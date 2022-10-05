<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
use \Prymery\Regionality;
\Bitrix\Main\Loader::includeModule('sale');

global $APPLICATION;
$urlback = htmlspecialchars($_GET['url']);
$quickCity = Prymery\Regionality::getRegions();
$count_in_col = round(count($quickCity)/3);
$count=0;

$res = \Bitrix\Sale\Location\LocationTable::getList(array(
	'order' => array('NAME_RU' => 'asc'),
	'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'CITY'),
	'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
));
while($item = $res->fetch()){
	if($item['REGION_ID']){
		$regionsIds[$item['REGION_ID']] = $item['REGION_ID'];
	}
	$arall[] = $item;
	$arNames[] = $item['NAME_RU'];
	$arRegionsJs[] = array(
		'label' => $item['NAME_RU'],
		'region' => $item['REGION_ID'],
		'ID' => $item['ID'],
	);
}
if($regionsIds){
	$res2 = \Bitrix\Sale\Location\LocationTable::getList(array(
		'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, '=ID' => $regionsIds),
		'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
	));
	while($item2 = $res2->fetch()){
		$regionParents[$item2['ID']] = $item2;
	}
}

$arSelect = Array("ID", "NAME", "PROPERTY_LINK");
$arFilter = Array("IBLOCK_ID"=>REGIONS_IBLOCK_ID, "NAME"=>$arNames, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->Fetch()){
	$links[$ob['NAME']] = $ob['PROPERTY_LINK_VALUE'];
}
?>
<div class="modalRegions modal-city-select">
	<div class="modal-close" data-fancybox-close>
		<svg class="icon"><use xlink:href="#times"></use></svg>
	</div>
	<div class="modal-title text-left">Выберите город</div>

	<div class="form-group-inline">
		<input type="text" name="city-search" id="searchCity" class="autocomplete form-control" placeholder="Название населенного пункта">
		<button type="submit"><svg class="icon"><use xlink:href="#search"></use></svg></button>
		<div class="chooseCity__container">
		
		</div>
	</div>
	<?if($quickCity):?>
		<div class="city-recommend__list">
			<ul class="city-recommend__group">
				<?foreach($quickCity as $key=>$city):
					if($count==$count_in_col):$count=0;?></ul><ul class="city-recommend__group"><?endif;?>
					<li<?/*if($city['CURRENT'] == 'Y'):?> class="current"<?endif;*/?>>
						<a class="cityChooseLink" href="javascript:void(0)" data-link="<?=$links[$city['NAME']]?>" data-id="<?=$city['ID']?>">
							<?=$city['NAME']?>
						</a>
					</li>
				<?$count++;endforeach;?>
			</ul>
		</div>
	<?endif;?>
    <script type="text/javascript">
		var arRegions = <?=CUtil::PhpToJsObject($arRegionsJs);?>;
		var regionParents = <?=CUtil::PhpToJsObject($regionParents);?>;
		var links = <?=CUtil::PhpToJsObject($links);?>;
		var HTTP_HTTPS = '<?=$isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);?>';
		if(!HTTP_HTTPS){
			var pre_link = 'http://';
		}else{
			var pre_link = 'https://';
		}
		
        $("#searchCity").autocomplete({
            minLength: 2,
            source: arRegions,
            appendTo : $(".chooseCity__container"),
            select: function(event, ui) {
                $.removeCookie('FV_CURRENT_REGION');
                $.cookie('FV_CURRENT_REGION', ui.item.ID, {path: '/',domain: '.freevape.ru',expires:365});
				/*$.getJSON('/local/ajax/set_cookie_city.php',
					{ID:ui.item.ID},
					function (data) {
						if(links[ui.item.label]){
							location.href = pre_link+links[ui.item.label]+'<?=$urlback?>';
						}else{
							location.href = pre_link+'freevape.ru<?=$urlback?>';
						}
					}
				);*/
                $("#search").val(ui.item.label);
              
            },
			close: function(event, ui){
				$(".chooseCity__container").removeClass('open');
			},
			open: function(event, ui){
				$(".chooseCity__container").addClass('open');
			}
        })
		.data("ui-autocomplete")._renderItem = function(ul, item){

			if(regionParents[item.region]){
				var region = " ("+regionParents[item.region]['NAME_RU'] +")";
			}
            
			if(region){
				return $("<li>")
					.append("<a href='javascript:void(0)' class='cityChooseLink' data-link='"+ links[item.label] +"' data-id='"+item.id+"'>" + item.label +region +"</a>")
					.appendTo(ul);
			}else{
				return $("<li>")
					.append("<a href='javascript:void(0)' class='cityChooseLink' data-link='"+ links[item.label] +"' data-id='"+item.id+"'>" + item.label+"</a>")
					.appendTo(ul);
			}
        }

        

        $('.cityChooseLink').on('click', function(e){
            e.preventDefault();
			
            var _this = $(this);
			$.cookie('FV_CURRENT_REGION', _this.data('id'), {path: '/',domain: 'freevape.ru',expires:365});
			/*if($(_this).data('link')){
				location.href = pre_link+$(_this).data('link')+'<?=$urlback?>';
			}else{
				location.href = pre_link+'freevape.ru<?=$urlback?>';
			}*/
					
					
			$.getJSON('/local/ajax/set_cookie_city.php',
				{ID:_this.data('id')}, 
				function (data) {
					
					if($(_this).data('link')){
						location.href = pre_link+$(_this).data('link')+'<?=$urlback?>';
					}else{
						location.href = pre_link+'freevape.ru<?=$urlback?>';
					}
				}
			);
			
            //$.removeCookie('FV_CURRENT_REGION');
            //$.cookie('FV_CURRENT_REGION', _this.data('id'), {path: '/',domain: '<?=$GLOBALS['_SERVER']['SERVER_NAME']?>'});
           // location.href = '<?=$urlback?>';
        })
        $('.h-search .wrapper .search_btn').on('click', function(){
            var block = $(this).closest('.wrapper').find('#search');
            if(block.length){
                block.trigger('focus');
                block.data('ui-autocomplete').search(block.val());
            }
        })
    </script>
</div>
