<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
use \Prymery\Regionality;
\Bitrix\Main\Loader::includeModule('sale');

global $APPLICATION;
$urlback = htmlspecialchars($_GET['url']);
$arStores = Prymery\Regionality::getAllStores();
$realRegion = Prymery\Regionality::getRealRegionByIP();
$shopInCity = $arStores[$realRegion['NAME']]['SHOPS'];

if($shopInCity){
	//Собираем массив для карты
	foreach($shopInCity as $shop){
		if($shop['UF_COORDS']){
			$arMap[] = array('ID' => $shop['ID'],'COORDS' => $shop['UF_COORDS'],'TITLE' => $shop['TITLE'],'PHONE' => $shop['PHONE'],'SCHEDULE' => $shop['SCHEDULE']);
		}
	}
}
$selectShop = $APPLICATION->get_cookie('SELECT_SHOP');


?>

<div id="modal-select-shop" class="modal modalShow modal-select-shop">
	<div class="modal-close" data-fancybox-close>
		<svg class="icon"><use xlink:href="#times"></use></svg>
	</div>
	<?if($shopInCity):?>
		<div class="modal-title text-left">Выберите магазин</div>

        <div class="shop-view-togglers">
            <div class="shop-view current">Списком</div>
            <div class="shop-view">На карте</div>
        </div>

		<div class="product__availability">
			<div class="shops__container">
                <div class="shops__list-container">
                    <div class="shops__list shop-view-target current">
                        <div class="shops__count">
							Найдено 
							<?if($realRegion['NAME'] == 'Краснодар'):?>
								<?=count($shopInCity)+1;?> <?=endingsForm(count($shopInCity)+1,'магазин','магазина','магазинов');?> 
							<?else:?>
								<?=count($shopInCity);?> <?=endingsForm(count($shopInCity),'магазин','магазина','магазинов');?> 
							<?endif;?>
						</div>
						<?if($realRegion['NAME'] == 'Краснодар'):?>
							 <div class="shops__item" data-id="19">
								<div class="shops__title"><svg class="icon"><use xlink:href="#pin"></use></svg>
									Склад интернет-магазина
									<div class="tooltip">
										<div class="tooltip-head">?</div>
										<div class="tooltip-body">
											Обращаем Ваше внимание, что доставка заказов осуществляется со склада нашего интернет-магазина. На данном складе актуальные остатки, которые доступны к заказу с доставкой.
										</div>
									</div>
								</div>
								
						
								<div class="shops__worktime">с 10:00 до 19:00</div>
								<div class="shops__contact"><a href="tel:88003006908">8 800 300 69 08</a></div>
								<label class="color-checkbox">
									<input type="radio" class="color-checkox__value mapShopLink" data-id="mapshoplink_19" name="shop-value" data-coords="" value="19" <?if(19 == $selectShop || !$selectShop):?> checked<?endif;?>>
									<div class="color-checkbox__icon">
										<svg class="icon"><use xlink:href="#check"></use></svg>
									</div>
								</label>
							</div>
						<?endif;?>
                        <?foreach($shopInCity as $key=>$shop):
                            if($shop['UF_COORDS']):?>
                                <div class="shops__item" data-id="<?=$shop['ID']?>">
                                    <div class="shops__title"><svg class="icon"><use xlink:href="#pin"></use></svg>
                                        <?=str_replace($realRegion['NAME'].',','',$shop['TITLE'])?>
                                    </div>
                                    <?if($shop['SCHEDULE']):?>
                                        <div class="shops__worktime"><?=$shop['SCHEDULE']?></div>
                                    <?endif;?>
                                    <?if($shop['PHONE']):?>
                                        <div class="shops__contact"><a href="callto:<?=$shop['PHONE']?>"><?=$shop['PHONE']?></a></div>
                                    <?endif;?>
                                    <label class="color-checkbox">
                                        <input type="radio" class="color-checkox__value mapShopLink" data-id="mapshoplink_<?=$shop['ID']?>" name="shop-value" data-coords="<?=$shop['UF_COORDS']?>" value="<?=$shop['ID']?>" <?if($shop['ID'] == $selectShop):?> checked<?endif;?>>
                                        <div class="color-checkbox__icon">
                                            <svg class="icon"><use xlink:href="#check"></use></svg>
                                        </div>
                                    </label>
                                </div>
                            <?endif;?>
                        <?endforeach;?>
                    </div>
                    <div class="shops-filter-apply">
                        <a href="javascript:void(0)" class="adp-btn adp-btn--primary shopChooserBtn" data-fancybox-close>Закрыть</a>
                    </div>
                </div>
				<div class="shops-map shop-view-target">
					<div id="mapshopmodal" style="width: 100%; height: 560px"></div>
				</div>
			</div>
		</div>
	<?else:?>
		<div class="modal-title text-left">Магазины в вашем городе не найдены</div>
	<?endif;?>
    <script type="text/javascript">
		ymaps.ready(init);
		function init() {
			var arCoords = <?=CUtil::PhpToJsObject($arMap);?>;

			var centerMap = arCoords[0]['COORDS'].split(',');
			var myMap = new ymaps.Map("mapshopmodal", {
					center: [centerMap[0],centerMap[1]],
					zoom: 10
				}, {
					searchControlProvider: 'yandex#search'
				});

			for(var i=0;i<arCoords.length;i++){
				var map_coords = arCoords[i]['COORDS'].split(',');
				if(map_coords[1]){
					myMap.geoObjects
						.add(new ymaps.Placemark([map_coords[0],map_coords[1]], {
							id: 'mapshoplink_'+arCoords[i].ID,
							balloonContent: '<b>Адрес:</b>'+arCoords[i].TITLE + '<br /> <b>Телефон:</b> '+arCoords[i].PHONE+'<br /> <b>Режим работы:</b> '+arCoords[i].SCHEDULE+''
						}, {
							/*iconLayout: 'default#image',
							iconImageHref: '/local/templates/freevape/assets/img/icons/mapPoint.png',
							iconImageSize: [32, 40],
							iconImageOffset: [-5, -38]*/
							preset: 'islands#blueShoppingCircleIcon',
							iconColor: '#FB611F'
						}));
					var arId;
					myMap.geoObjects.events.add('click', function(e) {
						var target = e.get('target');
						if(arId != target.properties.get('id')){
							arId = target.properties.get('id');
							$('input[data-id='+arId+']').prop('checked',true);
							$('input[data-id='+arId+']').change();
						}
					});
				}
			}
			$('.mapShopLink').on('change', function(){
				var coords = $(this).data('coords');
				coords = coords.split(',');
				var val = $(this).val();
				
				if($(this).val() != 19){
					//Центруем карту и открываем нужный нам баллун
					var indexObj = $(this).parent().parent().index();
					//indexObj = indexObj - 1;
					indexObj = indexObj - 2;
					
					var point = myMap.geoObjects.get(indexObj);

					//var npoint = $.map(point.geometry.getCoordinates(), Number);
					//var npoint = coords[1]+','+coords[0];
					myMap.setCenter(coords, 15, {checkZoomRange: true}).then(function () {point.balloon.open();}, function (err) {}, this);
				}
				//Записываем выбор в куки
				$.removeCookie('FV_SELECT_SHOP');
				
				$.cookie('FV_SELECT_SHOP', val, {path: '/',domain: '<?=$GLOBALS['_SERVER']['SERVER_NAME']?>'});

				//Меняем текст на кнопке
                $('.shopChooserBtn').html('Применить');
				//location.href = '<?=$urlback?>';
			});
		}
		
        
    </script>
	
</div>
