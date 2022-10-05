<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);
?>
<section class="card">
    <div class="container-large-flex">
        <div class="card-row">
            <div class="card-column">
                <div class="slider">
                    <div class="slider-for">
                        <?if($arResult['PREVIEW_PICTURE']):?>
                            <a href="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"><img class="slider-for-img" src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"></a>
                        <?else:?>
                            <img class="slider-for-img" src="/local/templates/dcut/assets/img/no-photo.png">
                        <?endif;?>
                    </div>
                    <?/*div class="slider-nav">
                        <div class="img"><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/card/nav-1.webp" alt="img"></div>
                    </div*/?>
                    <div class="hidden-icon">
                        <div class="hidden-card-heart add-favorites" data-id="<?=$arResult['ID']?>" data-toggle="tooltip" data-placement="left" title="Добавить в избранное"><svg width="23" height="21" class="icon"><use xlink:href="#product-like"></use></svg></div>
                        <?/*div class="hidden-card-arrows add-compare" data-toggle="tooltip" data-placement="left" title="Сравнить" data-url="<?=$APPLICATION->GetCurPage();?>" data-id="<?=$arResult['ID']?>">
                            <svg width="19" height="20" class="icon"><use xlink:href="#product-compare"></use></svg>
                        </div*/?>
                    </div>
                </div>
            </div>

            <div class="card-column">
                <div class="info">
                    <div class="info-reviews">
                        <?if($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
                            <div class="info-reviews_vendor">Артикул: <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></div>
                        <?endif;?>
                        <?if($arResult['REVIEWS']):?>
                            <div class="rating">
                                <div class="rating-title">Отзывов: <span><?=count($arResult['REVIEWS']);?></span></div>
                                <div class="rating">
                                    <div class="star active">
                                        <svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg>
                                    </div>
                                    <div class="star<?if($arResult['AVG_REVIEWS']>1):?> active<?endif;?>">
                                        <svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg>
                                    </div>
                                    <div class="star<?if($arResult['AVG_REVIEWS']>2):?> active<?endif;?>">
                                        <svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg>
                                    </div>
                                    <div class="star<?if($arResult['AVG_REVIEWS']>3):?> active<?endif;?>">
                                        <svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg>
                                    </div>
                                    <div class="star<?if($arResult['AVG_REVIEWS']>4):?> active<?endif;?>">
                                        <svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg>
                                    </div>
                                </div>
                            </div>
                        <?endif;?>
                    </div>
                    <div class="section-title"><span><?=$arResult['NAME']?></span></div>
                    <div class="info-descr">
                        <div class="characteristics">
                            <?if($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
                                <div class="block">
                                    <div class="key">Модель: </div>
                                    <div class="value"><?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></div>
                                </div>
                            <?endif;?>
                            <?if($arResult['PROPERTIES']['BRAND']['VALUE']):?>
                                <div class="block">
                                    <div class="key">Производитель: </div>
                                    <div class="value"><?=$arResult['PROPERTIES']['BRAND']['VALUE']?></div>
                                </div>
                            <?endif;?>
                            <?/*a href="#" class="section-more-link">
                                Все характеристики <svg width="10" height="8" class="icon"><use xlink:href="#double-angle-right"></use></svg>
                            </a*/?>
                        </div>
                        <div class="links">
                            <div class="link">
                                <svg width="20" height="18" class="icon"><use xlink:href="#document-info"></use></svg>
                                <a href="conditions.html">Информация о доставке</a>
                            </div>
                            <div class="link">
                                <svg width="20" height="20" class="icon"><use xlink:href="#document"></use></svg>
                                <a class="download-docs" href="#">Документы</a>
                            </div>
                        </div>
                    </div>
                    <?global $USER;
                    if($USER->IsAuthorized()):?>
                        <div class="price">
                            <?//print_r($arResult['MIN_PRICE']);?>
                            <?=$arResult['MIN_PRICE']['PRINT_PRICE']?>
                            <?if($arResult['MIN_PRICE']['VALUE']>$arResult['MIN_PRICE']['DISCOUNT_VALUE']):?>
                                <span><?=$arResult['MIN_PRICE']['PRINT_VALUE']?></span>
                            <?elseif($arResult['MIN_PRICE']['PERCENT']>0):?>
                                <span><?=$arResult['MIN_PRICE']['PRINT_BASE_PRICE']?></span>
                            <?elseif($arResult['PROPERTIES']['OLD_PRICE']['VALUE'] && $arResult['MIN_PRICE']['BASE_PRICE'] != $arResult['PROPERTIES']['OLD_PRICE']['VALUE']):?>
                                <span><?=$arResult['PROPERTIES']['OLD_PRICE']['VALUE']?> руб.</span>
                            <?endif;?>
                        </div>
                        <?if($arResult['CATALOG_QUANTITY'] > 0):?>
                            <form action="">
                                <div class="form-title">Количество: </div>
                                <div class="input">
                                    <input class="form-input quantity__value" type="text" pattern="^[0-9]+$" value="1">
                                    <svg width="11" height="6" class="icon top"><use xlink:href="#triangle-up"></use></svg>
                                    <svg width="11" height="6" class="icon bottom"><use xlink:href="#triangle-down"></use></svg>
                                </div>
                            </form>

                            <div class="section-buttons">
                                <button class="basket dark-button to_basket" data-id="<?=$arResult['ID']?>"><span>В корзину</span></button>
                                <?/*button class="buy buy-modal" data-id="<?=$arResult['ID']?>"><span>Купить в 1 клик</span></button*/?>
                            </div>
                        <?else:?>
                            <div class="noAviablity" style="color: #ff0000;">Нет в наличии</div>
                        <?endif;?>
                    <?endif;?>
                </div>
            </div>
            <?if($arResult['CATALOG_QUANTITY'] > 0):?>
                <div class="section-buttons card-buttons">
                    <button class="basket dark-button to_basket" data-id="<?=$arResult['ID']?>"><span>В корзину</span></button>
                    <?/*button class="buy buy-modal" data-id="<?=$arResult['ID']?>"><span>Купить в 1 клик</span></button*/?>
                </div>
            <?endif;?>
        </div>
    </div>
</section>

<section class="product-description">
    <div class="container-large">
        <ul class="section-tabs one section-descr-tabs">
            <li rel="tab3" class="active"><button>Описание</button></li>
            <li rel="tab4"><button>Характеристики</button></li>
            <li rel="tab5" class="social-tab"><button>Отзывы<?if(count($arResult['REVIEWS'])>0):?> <span>(<?=count($arResult['REVIEWS']);?>)</span><?endif;?></button></li>
        </ul>
        <div class="product-description-mob-head active" rel="tab3">
            <div class="product-description-mob-title">
                Описание <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
        </div>
        <div class="content" id="tab3" style="display: block;">
            <?=$arResult['PREVIEW_TEXT']?>
        </div>
        <div class="product-description-mob-head" rel="tab4">
            <div class="product-description-mob-title">
                Характеристики <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
        </div>
        <div class="content" id="tab4" style="display: none;">
            <div class="feature">
                <?if($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
                    <div class="feature-item">
                        <div class="key">Модель: </div>
                        <div class="value"><?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></div>
                    </div>
                <?endif;?>

            </div>
        </div>
        <?/*div class="product-description-mob-head social-tab" rel="tab5">
            <div class="product-description-mob-title">
                Отзывы <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
            </div>
        </div*/?>
        <div class="content" id="tab5" style="display: none;">
            <?if($arResult['REVIEWS']):?>
                <div class="comments-all product-comments-all">
                    <?foreach($arResult['REVIEWS'] as $review):?>
                        <div class="comment">
                            <div class="who">
                                <div class="who-img"> <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/about-us/incognito.svg" alt="img"></div>
                                <div class="who-info">
                                    <div class="who-user">
                                        <div class="who-user_name">
                                            <span class="who-user_name__name"><?=$review['NAME']?></span>
                                        </div>
                                        <div class="who-user_date">18 Июня 2019</div>
                                    </div>
                                    <div class="rating">
                                        <div class="rating-title">Оценка</div>
                                        <div class="rating">
                                            <div class="star active"><svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg></div>
                                            <div class="star<?if($review['PROPERTY_RATING_VALUE']>1):?> active<?endif;?>"><svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg></div>
                                            <div class="star<?if($review['PROPERTY_RATING_VALUE']>2):?> active<?endif;?>"><svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg></div>
                                            <div class="star<?if($review['PROPERTY_RATING_VALUE']>3):?> active<?endif;?>"><svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg></div>
                                            <div class="star<?if($review['PROPERTY_RATING_VALUE']>4):?> active<?endif;?>"><svg width="20" height="19" class="icon"><use xlink:href="#star"></use></svg></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="what"><?=$review['PREVIEW_TEXT']?></div>
                        </div>
                    <?endforeach;?>
                </div>
            <?endif;?>

            <div class="review">
                <?
                $APPLICATION->IncludeComponent(
                    "prymery:feedback.form",
                    "review",
                    array(
                        "ARFIELDS" => array(
                            0 => "NAME",
                            1 => "PHONE",
                            2 => "MESSAGE",
                            3 => "RATING",
                        ),
                        "REQUEST_ARFIELDS" => array(
                            0 => "NAME",
                            1 => "PHONE",
                            2 => "MESSAGE",
                        ),
                        "COMPONENT_TEMPLATE" => ".default",
                        "EMAIL_TO" => "apdnnb@mail.ru",
                        "SUCCESS_MESSAGE_TITLE" => "Ваш отзыв отправлен",
                        "SUCCESS_MESSAGE" => "Он будет опубликован после проверки на спам",
                        "GOAL_METRIKA" => "",
                        "GOAL_ANALITICS" => "",
                        "LINK_ELEMENT_IBLOCK" => $arResult['IBLOCK_ID'],
                        "ELEMENT_ID" => $arResult['ID'],
                        "USE_CAPTCHA" => "N",
                        "SAVE" => "Y",
                        "BUTTON" => "Отправить",
                        "TITLE" => "Оставьте отзыв о товаре",
                        "SUBTITLE" => "Ваш электронный адрес не публикуется. Поля, отмеченные звёздочкой*,обязательны для заполнения",
                        "PERSONAL_DATA" => "Y",
                        "PERSONAL_DATA_PAGE" => "/policy/",
                        "PERSONAL_DATA_PAGE2" => "/uslovia/",
                        "LEAD_IBLOCK" => "7"
                    ),
                    false
                );?>
            </div>
        </div>
    </div>
</section>
























<?/*




<div class="product-item-section">
	<div class="row">
		<div class="col-12">
			<div class="product-detail__inner">
				<div class="product-item__heading product-item__heading--mobile">
					<div class="product-item__title"><?=$arResult['NAME']?></div>
					<?if($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
						<div class="product-item__article">Арт. <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></div>
					<?endif;?>
					
					<?$frame = new \Bitrix\Main\Page\FrameBuffered("COMMENTS_MOBILE"); 
					$frame->begin();?>
						<a href="javascript:void(0)" class="product-item__comments">
							<svg class="icon"><use xlink:href="#speech-bubble"></use></svg>
							<?=count($arResult['COMMENTS']);?> <span><?=endingsForm(count($arResult['COMMENTS']), 'комментарий','комментария','комментариев');?></span>
						</a>
					<?$frame->end();?>	
					<?if($arResult['PROPERTIES']['BRAND_NEW2']['VALUE'] || $arResult['PROPERTIES']['BREND']['VALUE']):?>
						<div class="product-item__brand">
							<div class="caption">Бренд:</div>
							<?if($arResult['PROPERTIES']['BRAND_NEW2']['VALUE']){
									$brand = $arResult['PROPERTIES']['BRAND_NEW2']['VALUE'];
								}else{
									$brand = $arResult['PROPERTIES']['BREND']['VALUE'];
								}?>
							<a href="/brands/<?=$brand?>/">
								<?=$brand?>
							</a>
						</div>
					<?endif;?>
				</div>
				<div class="row">
					<div class="col-12 col-lg-6">
						<div class="product-item__thumb">
							<div class="product__quick product-item__quick">
								<a href="javascript:void(0)" class="add-compare to_compare" data-id="<?=$arResult['ID']?>">
									<svg class="icon"><use xlink:href="#compare-product"></use></svg>
								</a>
								<a href="javascript:void(0)" class="add-favorite to_favorites" data-id="<?=$arResult['ID']?>">
									<svg class="icon"><use xlink:href="#heart-outline-product"></use></svg>
									<svg class="icon"><use xlink:href="#heart-product"></use></svg>
								</a>
							</div>
							<?if($arResult['DETAIL_PICTURE']['SMALL']['src'] && $arResult['MORE_PHOTO']):?>
								<div class="slider-nav">
									<?if($arResult['DETAIL_PICTURE']['SMALL']['src']):?>
										<div class="slide">
											<img src="<?=$arResult['DETAIL_PICTURE']['SMALL']['src']?>" alt="<?=$arResult['NAME']?>">
										</div>
									<?endif;?>
									<?if($arResult['MORE_PHOTO']):?>
										<?foreach($arResult['MORE_PHOTO'] as $photo):?>
											<div class="slide">
												<img src="<?=$photo['SMALL']['src']?>" alt="<?=$arResult['NAME']?>">
											</div>
										<?endforeach;?>
									<?endif;?>
								</div>
							<?endif;?>
							<div class="slider-for">
								<?if($arResult['DETAIL_PICTURE']['BIG']['src']):?>
									<div class="slide">
										<div class="thumb__img">
											<a data-fancybox="gallery" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>"><img src="<?=$arResult['DETAIL_PICTURE']['BIG']['src']?>" alt="<?=$arResult['NAME']?>"></a>
										</div>
									</div>
								<?endif;?>
								<?if($arResult['MORE_PHOTO']):?>
									<?foreach($arResult['MORE_PHOTO'] as $photo):?>
										<div class="slide">
											<div class="thumb__img">
												<a data-fancybox="gallery" href="<?=$photo['REAL']?>"><img src="<?=$photo['BIG']['src']?>" alt="<?=$arResult['NAME']?>"></a>
											</div>
										</div>
									<?endforeach;?>
								<?endif;?>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-6">
						<div class="product-item__content">
							<div class="product-item__heading">
								<div class="product-item__title"><?=$arResult['NAME']?></div>
								<?if($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
									<div class="product-item__article">Арт. <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></div>
								<?endif;?>
								<?$frame = new \Bitrix\Main\Page\FrameBuffered("COMMENTS_MOBILE"); 
								$frame->begin();?>
									<a href="javascript:void(0)" class="product-item__comments">
										<svg class="icon"><use xlink:href="#speech-bubble"></use></svg>
										<?=count($arResult['COMMENTS']);?> <span><?=endingsForm(count($arResult['COMMENTS']), 'комментарий','комментария','комментариев');?></span>
									</a>
								<?$frame->end();?>
								<?if($arResult['PROPERTIES']['BRAND_NEW2']['VALUE'] || $arResult['PROPERTIES']['BREND']['VALUE']):?>
									<div class="product-item__brand">
										<div class="caption">Бренд:</div>
										<?if($arResult['PROPERTIES']['BRAND_NEW2']['VALUE']){
											$brand = $arResult['PROPERTIES']['BRAND_NEW2']['VALUE'];
										}else{
											$brand = $arResult['PROPERTIES']['BREND']['VALUE'];
										}?>
										<a href="/brands/<?=$brand?>/">
											<?=$brand?>
										</a>
									</div>
								<?endif;?>
							</div>

							<div class="product-item__price">
								<?if($arResult['OFFERS']):?>
									<?if($arResult['CUSTOM_OFFERS']):?>
										<?foreach($arResult['CUSTOM_OFFERS'] as $offer):?>
											<?if(!$offer['MIN_PRICE']){$offer['MIN_PRICE'] = $offer['ITEM_PRICES'][0];}?>
											<?if($offer['MIN_PRICE']['PRICE']):?>
												<div class="price-current jsPrice"><?=$offer['MIN_PRICE']['PRICE']?> <span class="currency">₽</span></div>
											<?endif;?>
											<?if($offer['MIN_PRICE']['BASE_PRICE'] > $offer['MIN_PRICE']['RATIO_PRICE']):?>
												<div class="price-old jsOldPrice"><?=$offer['MIN_PRICE']['BASE_PRICE']?> <span class="currency">₽</span></div>
											<?endif;?>
										<?break;
										endforeach;?>
									<?endif;?>
								<?else:?>
									<?if($arResult['MIN_PRICE']['PRICE']):?>
										<div class="price-current"><?=$arResult['MIN_PRICE']['PRICE']?> <span class="currency">₽</span></div>
									<?endif;?>
									<?if($arResult['PROPERTIES']['STARAYA_TSENA']['VALUE']):?>
										<div class="price-old"><?=$arResult['PROPERTIES']['STARAYA_TSENA']['VALUE']?> <span class="currency">₽</span></div>
									<?endif;?>
									<?if($arResult['MIN_PRICE']['BASE_PRICE'] > $arResult['MIN_PRICE']['RATIO_PRICE']):?>
										<div class="price-old"><?=$arResult['MIN_PRICE']['BASE_PRICE']?> <span class="currency">₽</span></div>
									<?endif;?>
								<?endif;?>
							</div>
							
							<?$count_of = 0;if($arResult['CUSTOM_OFFERS']):?>
								<div class="product-item__option product-item__capacity">
									<div class="product-item__option__header">
										<div class="caption">Крепость</div>
									</div>
									<div class="capacity__group">
										<?foreach($arResult['CUSTOM_OFFERS'] as $key=>$offer):?>
											<label class="capacity-checkbox">
												<input type="radio" name="capacity" class="capacity-checkbox__value offerItemProduct" value="<?=$offer['ID']?>"<?if($count_of==0):?> checked<?endif;?>>
												<span class="capacity-checkbox__text"><?=$offer['VALUE']?></span>
											</label>
										<?$count_of++;endforeach;?>
									</div>
								</div>
							<?endif;?>
							<?$frame = new \Bitrix\Main\Page\FrameBuffered("catalogDetailQuantity");
							$frame->begin();?>
								<div class="product-item__count">
									<div class="product-item__stock jsStockBlock">
                                        <?if($arResult['CUSTOM_OFFERS']){
                                            foreach($arResult['CUSTOM_OFFERS'] as $customOffer){
                                                if(!$arResult['CUSTOM_QUANTITY']){
                                                    $arResult['CUSTOM_QUANTITY'] = $customOffer['CUSTOM_QUANTITY'];
                                                    $of_id = $customOffer['ID'];
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
										<?if($arResult['CUSTOM_QUANTITY'] == 'otherShop'):?>
											<div class="product__stock product__stock--unaviable">
												<div class="caption margin0">есть в других магазинах</div>
											</div>
										<?elseif($arResult['CUSTOM_QUANTITY'] == 'empty'):?>
											<div class="product__stock product__stock--unaviable noFound">
												<div class="prodduct__stock__bar"><i></i><i></i><i></i><i></i><i></i><i></i></div>
												<div class="caption">нет в наличии</div>
											</div>
										<?else:?>
											<div class="product__stock<?= Prymery\Regionality::ProductQuantityClass($arResult['CUSTOM_QUANTITY']);?>">
												<?= Prymery\Regionality::ProductQuantityBarDetail($arResult['CUSTOM_QUANTITY']);?>
											</div>
										<?endif;?>
									</div>
									<?if($arResult['CUSTOM_OFFERS']):?>
										<?$other_shop = Prymery\Regionality::QuantityOtherShopOffers($arResult['OFFERS']);?>
									<?else:?>
										<?$other_shop = Prymery\Regionality::QuantityOtherShop($arResult['ID']);?>
									<?endif;?>
									<?if($other_shop>0):?>
										<div class="product-item__availability">
											<a href="javascript:void(0)" class="btn-link--primary">
												<span>Наличие</span><?if($arResult['STORE_ID']):?> еще<?endif;?> в <?=$other_shop?> <?=endingsForm($other_shop,'магазине','магазинах','магазинах');?>
											</a>
										</div>
									<?endif;?>
								</div>
								<div class="product-item__actions">
                                    <?if($arResult['CUSTOM_OFFERS']):?>
                                        <a<?if($arResult['CUSTOM_QUANTITY'] != 'empty'):?> style="display: none;"<?endif;?> data-fancybox data-type="ajax" data-touch="false" data-src="/local/ajax/form/aviable.php?ajax=y&id=<?=$arResult['ID']?>" class="adp-btn adp-btn--light has-icon-left emptyDetailBtn defDetailBtn">
                                            <svg class="icon"><use xlink:href="#bell"></use></svg>
                                            Узнать о поступлении
                                        </a>
                                        <a<?if($arResult['CUSTOM_QUANTITY'] != 'otherShop'):?> style="display: none;"<?endif;?> href="javascript:void(0)" class="add-basket adp-btn--md adp-btn adp-btn--primary to_basketDetail otherDetailBtn defDetailBtn" data-id="<?=$of_id?>">
                                            <span class="btn-text-desktop">Под заказ</span>
                                            <span class="btn-text-mobile">
                                                Под заказ
                                            </span>
                                        </a>
                                        <a<?if($arResult['CUSTOM_QUANTITY'] == 'empty' || $arResult['CUSTOM_QUANTITY'] == 'otherShop'):?> style="display: none;"<?endif;?> href="javascript:void(0)" class="add-basket adp-btn--md adp-btn adp-btn--primary to_basketDetail basketDetailBtn defDetailBtn" data-id="<?=$of_id?>">
                                            <span class="btn-text-desktop">Добавить в корзину</span>
											<?foreach($arResult['CUSTOM_OFFERS'] as $offer):?>
												<span class="btn-text-mobile">
													<?//if($offer['MIN_PRICE']['PRICE']):?>
														Купить за <?=$offer['MIN_PRICE']['PRICE']?> <span class="currency">₽</span>
													<?//endif;?>
												</span>
											<?break;endforeach;?>
                                        </a>
                                    <?else:?>
                                        <?if($arResult['CUSTOM_QUANTITY'] == 'empty'):?>
                                            <a data-fancybox data-type="ajax" data-touch="false" data-src="/local/ajax/form/aviable.php?ajax=y&id=<?=$arResult['ID']?>" class="adp-btn adp-btn--light has-icon-left">
                                                <svg class="icon"><use xlink:href="#bell"></use></svg>
                                                Узнать о поступлении
                                            </a>
                                        <?elseif($arResult['CUSTOM_QUANTITY'] == 'otherShop'):?>
                                            <a href="javascript:void(0)" class="add-basket adp-btn--md adp-btn adp-btn--primary to_basketDetail" data-id="<?=$arResult['ID']?>">
                                                <span class="btn-text-desktop">Под заказ</span>
                                                <span class="btn-text-mobile">
                                                    Под заказ
                                                </span>
                                            </a>
                                        <?else:?>
                                            <a href="javascript:void(0)" class="add-basket adp-btn--md adp-btn adp-btn--primary to_basketDetail" data-id="<?=$arResult['ID']?>">
                                                <span class="btn-text-desktop">Добавить в корзину</span>
                                                <span class="btn-text-mobile">
                                                    <?if($arResult['MIN_PRICE']['PRICE']):?>
                                                        Купить за <span class="jsPrice"><?=$arResult['MIN_PRICE']['PRICE']?> <span class="currency">₽</span></span>
                                                    <?endif;?>
                                                </span>
                                            </a>
                                        <?endif;?>
                                    <?endif;?>
								</div>

							<?$frame->end();?>
						</div>
					</div>
				</div>
			</div>

			<div class="product-detail__tabs">
				<ul class="tabs">
					<?if($arResult['~DETAIL_TEXT']):?>
						<li class="tab-link current" data-tab="tab-1">О товаре</li>
					<?endif;?>
					<li class="tab-link<?if(!$arResult['~DETAIL_TEXT']):?> current<?endif;?>" data-tab="tab-2">Характеристики</li>
					<li class="tab-link tab-link--comments" data-tab="tab-3">
						Комментарии
						<?$frame = new \Bitrix\Main\Page\FrameBuffered("COMMENTS_TAB_COUNT"); 
						$frame->begin();?>
							<span class="counters"><?=count($arResult['COMMENTS']);?></span>
						<?$frame->end();?>
					</li>
					<?$frame = new \Bitrix\Main\Page\FrameBuffered("catalogDetailTab"); 
					$frame->begin();?>
						<?if($other_shop>0):?>
							<li class="tab-link tab-link--shops" data-tab="tab-4">Наличие в магазинах<span class="counters"><?=$other_shop?></span></li>
						<?endif;?>
					<?$frame->end();?>
				</ul>
				<?
				//Кастомно определяем есть ли в описании html теги или нет, т.к. из МС не приходит тип описания
				if(strip_tags($arResult['DETAIL_TEXT']) == $arResult['DETAIL_TEXT']){
					$description_type = 'text';
				}else{
					$description_type = 'html';
				}
				?>
				<div class="tab-content">
					<?if($arResult['~DETAIL_TEXT']):?>
						<div class="product-tab__togglers">
							О товаре
							<div class="toggler"><svg class="icon"><use xlink:href="#angle-down"></use></svg></div>
						</div>
						<div id="tab-1" class="tab-pane current">
							<div class="row">
								<div class="col-12">
									<h3 class="tab-title">О товаре</h3>
									<div class="product-item__descripton">
											<?=$arResult['DETAIL_TEXT']?>
									</div>
								</div>

							</div>
						</div>
					<?endif;?>
					<div class="product-tab__togglers">
						Характеристики
						<div class="toggler"><svg class="icon"><use xlink:href="#angle-down"></use></svg></div>
					</div>
					<div id="tab-2" class="tab-pane<?if(!$arResult['~DETAIL_TEXT']):?> current<?endif;?>">
						<h3 class="tab-title">Характеристики</h3>
						<div class="row">
							<div class="col-12 col-lg-6">
								<ul class="product-item__characteristics">
									<?$i=0;foreach($arResult['SHOW_PROPS'] as $prop):?>
										<li><strong><?= $prop['NAME']?></strong><span><?=$prop['VALUE'];?></span></li>
										<?if(round(count($arResult['SHOW_PROPS'])/2) == $i+1):?></ul></div><div class="col-12 col-lg-6"><ul class="product-item__characteristics characteristics_secondary"><?endif;?>
									<?$i++;endforeach;?>											
								</ul>
							</div>
						</div>
					</div>
					<div class="product-tab__togglers">
						Комментарии 
						<?$frame = new \Bitrix\Main\Page\FrameBuffered("COMMENTS_TAB_COUNT"); 
						$frame->begin();?>
							<span class="counters"><?=count($arResult['COMMENTS']);?></span>
						<?$frame->end();?>
						<div class="toggler"><svg class="icon"><use xlink:href="#angle-down"></use></svg></div>
					</div>
					<div id="tab-3" class="tab-pane tab-pane--comments">
						<h3 class="tab-title">Комментарии</h3>
						<div class="row">
							<div class="col-12 col-lg-8">
								<?$frame = new \Bitrix\Main\Page\FrameBuffered("COMMENTS_TAB_CONTENT"); 
								$frame->begin();?>
									<?if($arResult['COMMENTS']):?>
										<div class="comments__list">
											<?foreach($arResult['COMMENTS'] as $ii => $comment):?>
												<div class="comment__item<?if($ii==4):?> last<?endif;?>"<?if($ii>4):?> style="display:none;"<?endif;?>>
													<div class="comment__header">
														<div class="comment__author"><?=$comment['PROPERTY_NAME_VALUE']?></div>
														<?
														$explode_date = explode('.',$comment['CREATED_DATE']);
														?>
														<div class="comment__date"><?=$explode_date[2].' '.FormatDate("F", MakeTimeStamp($comment['CREATED_DATE'])).' '.$explode_date[0]?></div>
													</div>
													<div class="comment__body">
														<?if($comment['PROPERTY_PLUS_VALUE']['TEXT']):?>
															<div class="comment__group">
																<div class="subtitle">Плюсы</div>
																<p><?=$comment['PROPERTY_PLUS_VALUE']['TEXT']?></p>
															</div>
														<?endif;?>
														<?if($comment['PROPERTY_MINUS_VALUE']['TEXT']):?>
															<div class="comment__group">
																<div class="subtitle">Минусы</div>
																<p><?=$comment['PROPERTY_MINUS_VALUE']['TEXT']?></p>
															</div>
														<?endif;?>
														<?if($comment['PROPERTY_COMMENT_VALUE']['TEXT']):?>
															<div class="comment__group">
																<div class="subtitle">Комментарий</div>
																<p><?=$comment['PROPERTY_COMMENT_VALUE']['TEXT']?></p>
															</div>
														<?endif;?>
													</div>
													<div class="comment__meta">
														<div class="caption">Был ли полезен комментарий?</div>
														<div class="comment__meta__item comment__like jsLike<?if($APPLICATION->get_cookie('LIKE_'.$comment['ID']) == 'Y'):?> active<?endif;?>" data-id="<?=$comment['ID']?>">
															<svg class="icon"><use xlink:href="#like"></use></svg>
															<span<?if(!$comment['PROPERTY_LIKE_VALUE']):?> style="display: none;"<?endif;?>><?=$comment['PROPERTY_LIKE_VALUE']?></span>
														</div>
														<div class="comment__meta__item comment__like jsDisLike<?if($APPLICATION->get_cookie('DISLIKE_'.$comment['ID']) == 'Y'):?> active<?endif;?>" data-id="<?=$comment['ID']?>">
															<svg class="icon"><use xlink:href="#dislike"></use></svg>
															<span<?if(!$comment['PROPERTY_DISLIKE_VALUE']):?> style="display: none;"<?endif;?>><?=$comment['PROPERTY_DISLIKE_VALUE']?></span>
														</div>
													</div>
												</div>
											<?endforeach;?>
										</div>
										<?if(count($arResult['COMMENTS'])>5):?>
											<div class="comment__load comment__load--desktop">
												<a href="javascript:void(0)" class="btn-link--primary ajaxCommentMore">Показать еще 5</a>
											</div>
										<?endif;?>
									<?else:?>	
										<div class="comment-empty-text">
                                            Еще никто не оставил отзыв к этому товару. Будьте первым!
                                        </div>
									<?endif;?>
								<?$frame->end();?>
							</div>
							<div class="col-12 col-lg-4">
								<div class="comment__add">
									<?if(count($arResult['COMMENTS'])>5):?>
										<div class="comment__load--mobile">
											<a href="javascript:void(0)" class="btn-link--primary ajaxCommentMore">Показать еще 5</a>
										</div>
									<?endif;?>
									<a data-fancybox data-type="ajax" data-touch="false" data-src="/local/ajax/form/comment.php?ajax=y&id=<?=$arResult['ID']?>" class="adp-btn adp-btn--md adp-btn--primary">Написать комментарий</a>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<?if($arResult['CUSTOM_OFFERS']):?>
		<script>
			var JS_OFFERS = <?=CUtil::PhpToJSObject($arResult['CUSTOM_OFFERS']);?>;
		</script>
	<?else:?>
		<script>
			var JS_OFFERS = 0;
		</script>
	<?endif;?>
</div>*/?>