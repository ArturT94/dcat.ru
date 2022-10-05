<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;

$APPLICATION->SetTitle("Заказ №".$arResult['ID']);

?>

<div class="col-custom col-12 col-xl-9">
	<div class="order-detail order-detail--repeat">
		<div class="order-detail__products">
			<?if($arResult['BASKET']):?>
				<?foreach($arResult['BASKET'] as $product):
					$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE");
					$arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", 'ID'=>$product['PRODUCT_ID']);
					$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
					while($ob = $res->Fetch()){
						$preview_picture = $ob;
					}
					if(!$preview_picture){
						$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE",'PROPERTY_CML2_LINK');
						$arFilter = Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", 'ID'=>$product['PRODUCT_ID']);
						$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
						while($ob = $res->Fetch()){
							$parent_id = $ob['PROPERTY_CML2_LINK_VALUE'];
						}
						if($parent_id){
							$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE");
							$arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", 'ID'=>$parent_id);
							$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
							while($ob = $res->Fetch()){
								$preview_picture = $ob;
							}
						}
					}
					?>
					<div class="order-detail__product">
						<div class="order-detail__thumb">
							<?if($preview_picture['PREVIEW_PICTURE']):?>
								<a href="<?=$product['DETAIL_PAGE_URL']?>">
									<img src="<?=CFile::GetPath($preview_picture['PREVIEW_PICTURE']);?>" alt="<?=$product['NAME']?>">
								</a>
							<?endif;?>
						</div>
						<div class="order-detail__content">
							<a href="<?=$product['DETAIL_PAGE_URL']?>" class="order-detail__title"><?=$product['NAME']?></a>
						</div>
						<div class="order-detail__footer">
							<div class="order-detail__price">
								<div class="order-detail__multiplier"><?=$product['QUANTITY']?> ×</div>
								<div class="order-detail__price"><?=number_format(round($product['PRICE']), 0, '', ' ');?> <span class="currency">₽</span></div>
							</div>
						</div>
					</div>
				<?endforeach;?>
			<?endif;?>
		</div>
		<div class="order-detail__speciality">
			<div class="order-detail__info">
				<div class="order-detail__info__group">
					<div class="title">Дата заказа</div>
					<div class="value"><?=$arResult['DATE_INSERT_FORMATED']?></div>
				</div>

				<div class="order-detail__info__group">
					<div class="title">Статус заказа</div>
					<div class="value"><?=$arResult['STATUS_INFO'][$arResult['STATUS_ID']]['NAME']?></div>
				</div>

				<div class="order-detail__info__group">
					<div class="title">Получатель</div>
					<div class="value">
						<?=$arResult['CUSTOM_PROPS']['NAME']['VALUE']?> <?=$arResult['CUSTOM_PROPS']['LAST_NAME']['VALUE']?><br>
						<?=$arResult['CUSTOM_PROPS']['EMAIL']['VALUE']?><br>
						<?=$arResult['CUSTOM_PROPS']['PHONE']['VALUE']?>
						
						<?if($arResult['CUSTOM_PROPS']['ADDRESS']['VALUE']):?>
							<br />Адрес доставки: <?=$arResult['CUSTOM_PROPS']['ADDRESS']['VALUE']?>
						<?endif;?>
						<?if($arResult['CUSTOM_PROPS']['SELECT_SHOP']['VALUE']):?>
							<br />Выбранный магазин: <?=$arResult['CUSTOM_PROPS']['SELECT_SHOP']['VALUE']?>
						<?endif;?>
					</div>
				</div>
				
				<?if($arResult['CUSTOM_DELIVERY']):?>
					<div class="order-detail__info__group">
						<div class="title"><?=$arResult['CUSTOM_DELIVERY']['NAME']?></div>
						<div class="value"><?=$arResult['CUSTOM_PROPS']['ADDRESS']['VALUE']?></div>
					</div>
				<?endif;?>
				<?if($arResult['CUSTOM_PAY_SYSTEM']):?>
					<div class="order-detail__info__group">
						<div class="title">
							<?if($arResult['CUSTOM_PAY_SYSTEM']['NAME'] == 'Наличными или картой при получении'):?>
								Наличными или картой при&nbsp;получении
							<?else:?>
								<?=$arResult['CUSTOM_PAY_SYSTEM']['NAME']?>
							<?endif;?>
						</div>
					</div>
				<?endif;?>
			</div>
			<?/*if($arResult['PAY_SYSTEM']['PSA_NEW_WINDOW'] != 'N'):?>
				<div class="order__submit order__submit--mobile">
					<a href="<?=$arResult['PAY_SYSTEM']['PSA_ACTION_FILE']?>" class="adp-btn adp-btn--primary adp-btn--md">Оплатить</a>
				</div>
			<?endif;*/?>

			<div class="order-total">
				<div class="order-total__item">
					<div class="char"><?=count($arResult['BASKET']);?> <?=endingsForm(count($arResult['BASKET']),'товар','товара','товаров');?> на сумму</div>
					<div class="val"><?=number_format(round($arResult['PRODUCT_SUM']), 0, '', ' ')?> <span class="currency">₽</span></div>
				</div>

				<div class="order-total__item order-total__item--delivery">
					<div class="char">Доставка</div>
					<div class="val"><?=number_format($arResult['PRICE_DELIVERY'], 0, '', ' ')?> <span class="currency">₽</span></div>
				</div>

				<div class="order-total__item order-total__item--summ">
					<div class="char">Итого</div>
					<div class="val"><?=number_format(round($arResult['SUM_REST']), 0, '', ' ')?> <span class="currency">₽</span></div>
				</div>
			</div>
		</div>
		<div class="order__submit">
			<a href="<?=$arResult['URL_TO_COPY']?>" class="adp-btn adp-btn--primary adp-btn--md">Повторить заказ</a>
		</div>
		<?/*if($arResult['PAY_SYSTEM']['PSA_NEW_WINDOW'] != 'N'):?>
			<div class="order__submit order__submit--desktop">
				<a href="<?=$arResult['PAY_SYSTEM']['PSA_ACTION_FILE']?>" class="adp-btn adp-btn--primary adp-btn--md">Оплатить</a>
			</div>
		<?endif;*/?>
	</div>
</div>