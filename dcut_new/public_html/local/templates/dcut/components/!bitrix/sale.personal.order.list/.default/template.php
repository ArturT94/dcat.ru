<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$count_orders=0;
global $USER;
if($USER->IsAuthorized()):?>
	<?if(!empty($arResult['ERRORS']['FATAL'])):?>
		<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>
	<?else:?>
		<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>
			<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
				<?=ShowError($error)?>
			<?endforeach?>
		<?endif?>
		<?/*=count($arResult['ORDERS']);?> <?=endingsForm(count($arResult['ORDERS']),'заказ','заказа','заказов');*/?>
		<div class="col-custom col-12 col-xl-9">
			<div class="personal__orders">
				<?if(!empty($arResult['ORDERS'])):?>
					<ul class="orders__sorting">
						<li<?if(!$_REQUEST['cur'] && !$_REQUEST['end']):?> class="current"<?endif;?>><a href="/personal/orders/">Все</a></li>
						<li<?if($_REQUEST['cur']=='y'):?> class="current"<?endif;?>><a href="/personal/orders/?cur=y">Активные<i></i></a></li>
						<li<?if($_REQUEST['end']=='y'):?> class="current"<?endif;?>><a href="/personal/orders/?end=y">Выполненные</a></li>
					</ul>
				<?endif;?>
				<div class="orders__list">
					<?if(!empty($arResult['ORDERS'])):?>
						<?if($_REQUEST['cur']):?>
							<?foreach($arResult["ORDERS"] as $key => $order):
								$explode_date = explode('.',$order['ORDER']['DATE_INSERT_FORMATED']);
								if($order['STATUS_ID'] != 'F'):
									$count_orders++;?>
									<div class="order__item">
										<div class="order__number">
											Заказ № <?=$order["ORDER"]["ACCOUNT_NUMBER"]?>
											<div class="order__date"><?=$explode_date[0]?> <?=FormatDate("F", MakeTimeStamp($order['ORDER']['DATE_INSERT_FORMATED']))?> <?=$explode_date[2]?></div>
										</div>
										<?/*div class="order__date"><?=$order['ORDER']['DATE_INSERT_FORMATED']?></div*/?>
										<div class="order__status"><?=$arResult['STATUS_INFO'][$order['ORDER']['STATUS_ID']]['NAME']?></div>
										<div class="order__total">
											<div class="order__price"><?=number_format(round($order['ORDER']['PRICE']), 0, '', ' ');?> <span class="currency"> ₽</span></div>
											<div class="order__detail">
												<a href="<?=$order['ORDER']['URL_TO_DETAIL']?>" class="btn-link--primary">Подробнее</a>
											</div>
										</div>
									</div>
								<?endif;?>
							<?endforeach?>
						<?elseif($_REQUEST['end']):?>
							<?foreach($arResult["ORDERS"] as $key => $order):
								$explode_date = explode('.',$order['ORDER']['DATE_INSERT_FORMATED']);
								if($order['STATUS_ID'] == 'F'):
									$count_orders++;?>
									<div class="order__item">
										<div class="order__number">
											Заказ № <?=$order["ORDER"]["ACCOUNT_NUMBER"]?>
											<div class="order__date"><?=$explode_date[0]?> <?=FormatDate("F", MakeTimeStamp($order['ORDER']['DATE_INSERT_FORMATED']))?> <?=$explode_date[2]?></div>
										</div>
										<?/*div class="order__date"><?=$order['ORDER']['DATE_INSERT_FORMATED']?></div*/?>
										<div class="order__status"><?=$arResult['STATUS_INFO'][$order['ORDER']['STATUS_ID']]['NAME']?></div>
										<div class="order__total">
											<div class="order__price"><?=number_format(round($order['ORDER']['PRICE']), 0, '', ' ');?> <span class="currency"> ₽</span></div>
											<div class="order__detail">
												<a href="<?=$order['ORDER']['URL_TO_DETAIL']?>" class="btn-link--primary">Подробнее</a>
											</div>
										</div>
									</div>
								<?endif;?>
							<?endforeach?>
						<?else:?>
							<?foreach($arResult["ORDERS"] as $key => $order):
								$explode_date = explode('.',$order['ORDER']['DATE_INSERT_FORMATED']);
								$count_orders++;?>
								<div class="order__item">
									<div class="order__number">
										Заказ № <?=$order["ORDER"]["ACCOUNT_NUMBER"]?>
										<div class="order__date"><?=$explode_date[0]?> <?=FormatDate("F", MakeTimeStamp($order['ORDER']['DATE_INSERT_FORMATED']))?> <?=$explode_date[2]?></div>
									</div>
									
									<?/*div class="order__date"><?=$explode_date[0]?> <?=FormatDate("F", MakeTimeStamp($order['ORDER']['DATE_INSERT_FORMATED']))?> <?=$explode_date[2]?></div*/?>
									<div class="order__status"><?=$arResult['STATUS_INFO'][$order['ORDER']['STATUS_ID']]['NAME']?></div>
									<div class="order__total">
										<div class="order__price"><?=number_format(round($order['ORDER']['PRICE']), 0, '', ' ');?> <span class="currency"> ₽</span></div>
										<div class="order__detail">
											<a href="<?=$order['ORDER']['URL_TO_DETAIL']?>" class="btn-link--primary">Подробнее</a>
										</div>
									</div>
								</div>
							<?endforeach?>
						<?endif;?>
						<?if($count_orders==0):?>
							<div class="emptyOrders order__item mh-auto"><?if($_REQUEST['cur']):?>Активные <?else:?>Выполненные <?endif;?>заказы не найдены!</div>
						<?endif;?>
					<?else:?>
						<div class="emptyOrders order__item mh-auto">Пока вы не совершили ни одного заказа, это нужно срочно исправлять!</div>
					<?endif;?>
				</div>
			</div>
			<?/*if(strlen($arResult['NAV_STRING'])):?>
				<?=$arResult['NAV_STRING']?>
			<?endif?*/?>
		</div>
	<?endif?>
<?endif?>

