function doStuff(){
    $('#soa-property-14').val($('.selectUser').val());
    $('#soa-property-15').val($('.selectUser').val());
}
$(document).ajaxComplete(doStuff);
$(document).ready(function () {
    $('.jsConfirmRepars').on('click', function (event) {
        var el = $(this);

        $.getJSON('/local/json/approvalOfRepars.php',
            {
                VAL: $(this).data('val'),
                GUID: $(this).data('guid'),
            },
            function (data) {
                alert('Ваше решение получено. Статус заказ-наряда обновится в течение часа');
            }
        );
    });
    $('.jsSendNotify').on('click', function (event) {
        var el = $(this);

        $.getJSON('/local/json/sendNotify.php',
            {
                GUID: $(this).data('guid'),
            },
            function (data) {
                alert('Ваша заявка успешно отправлена!');
            }
        );
    });
    $('.profile-search button').on('click', function (event) {
        var el = $(this);

        $.getJSON('/local/ajax/search_order.php',
            {
                VAL: $(this).prev().val(),
                TYPE: $(this).data('type'),
            },
            function (data) {
                $(el).closest('.profile-content').find('.profile-ajax').html(data);
            }
        );
    });

    $('.selectUser').on('change',function(){
        $('#soa-property-14').val($(this).val());
        $('#soa-property-15').val($(this).val());
    });

	$('.team-slider_item').fancybox({
		arrows: false,
		infobar: false,
		touch: false,
		baseClass: "team-slider-open",
		afterLoad: function(instance, current){
			var sliderIndex = $.fancybox.getInstance().current.opts.$orig.data('slider-index');
			$('.member-slider').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: true,
				prevArrow: '<button class="member-slider-arrow prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
				nextArrow: '<button class="member-slider-arrow next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="next"></button>',
			});
			$('.member-slider').slick('slickGoTo', sliderIndex);
		},
		afterClose: function() {
			$('.member-slider').slick('unslick');
		}
	});
    $('.add-compare').on('click', function (event) {
        var ID = $(this).data("id");
        var URL = $(this).data('url');
        var ACTION;
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            ACTION = 'DELETE_FROM_COMPARE_LIST';
            $('.compareCount').attr('data-count',Number($('.compareCount').attr('data-count'))-1);
            $('.compareCount').html(Number($('.compareCount').attr('data-count')));
        }else{
            $(this).addClass('active');
            ACTION = 'ADD_TO_COMPARE_LIST';
            $('.compareCount').attr('data-count',Number($('.compareCount').attr('data-count'))+1);
            $('.compareCount').html(Number($('.compareCount').attr('data-count')));
        }
        $.ajax({
            url: URL+'?action='+ACTION+'&id='+ID,
            type: 'POST',
            data: "",
            success: function(data){
            }
        });
    });

    $('.add-favorites').on('click', function (event) {
        var ID = $(this).data("id");
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('.icon-heart').removeClass('icon-heart').addClass('icon-heart-outline');
        }else{
            $(this).addClass('active');
            $(this).find('.icon-heart-outline').removeClass('icon-heart-outline').addClass('icon-heart');
        }
        $.getJSON('/local/ajax/favorites.php',
            {
                ACTION: 'DELAY',
                ID: ID,
            },
            function (data) {
                $('.favoritesCount').html(data);
            }
        );
    });

    $('.to_basket').addClass('init');
    $('.to_basket').on('click', function () {
        var id = $(this).attr('data-id');

        $(this).addClass('added');
        var quantity = $(this).closest('.card').find('.quantity__value').val();
        if(!quantity){
            quantity = 1;
        }
        $.getJSON('/local/ajax/to_basket.php',
            {
                ID: id,
                NAME: name,
                QUANTITY: quantity,
            },
            function (data) {
                $(".cart-link").html(data.BASKET_HTML);
            }
        );
    });

    $('.headerLogoSearch-links').prepend('<span class="js-search-toggle"><svg width="24" height="24" class="icon"><use xlink:href="#search"></use></svg></span>');
    $('.header-search').clone().appendTo('body').addClass('search-overlay').prepend('<span class="js-search-close"><svg width="14" height="14" class="icon"><use xlink:href="#times"></use></svg></span>');
    $('body').on('click', '.js-search-toggle, .js-search-close', function(){
    	$('.search-overlay').toggleClass('open');
    });

    $('.newCatalogAside .category-menu-link-arrow').on('click', function(e){
    	if ( $(window).width() <= 1100 ) {
    		e.preventDefault();
    		$(this).closest('.category-menu-link').toggleClass('open').next().stop().slideToggle();
    	}
    });

    /* анимация добавления в корзину */
    $('.to_basket').on('click', function () {
		event.preventDefault();

    	$(this).append('<i class="fly-icon"><svg width="24" height="23" class="icon"><use xlink:href="#product-cart"></use></svg></i>');
    	if ( $('.header.fixed').length ) {
	        var cart = $('.header.fixed .cart-link');
    	} else {
    		var cart = $('.head-container .cart-link');
    	}

        var imgtodrag = $(this).find(".fly-icon").eq(0);

        if (imgtodrag) {
            var imgclone = imgtodrag.clone().offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            }).css({
                'position': 'absolute', 'z-index': '1000'
            }).appendTo($('body')).animate({
                'top': cart.offset().top + 20,
                'left': cart.offset().left + 10,
            }, 1500);

            imgclone.animate({ 'opacity': '0.5', 'width': 0, 'height': 0 }, function(){ $(this).detach(); });
        }
    });

	/* переключение табов в карточке товара */
	$('.section-descr-tabs li').on('click', function(){
		$('.section-descr-tabs li').each(function(){ $(this).removeClass('active'); });
		$('.product-description .content:visible').css('display', 'none');

		var destTab = $(this).attr('rel');
		$('#'+destTab).fadeIn();
		$(this).addClass('active');
	});

	$('.product-description-mob-head').on('click', function(){
		$(this).toggleClass('active').next().slideToggle();
	});

	$('.mobile-catalog .catalog-menu a .arrow').on('click', function(){
		event.preventDefault();
		$(this).closest('a').toggleClass('open').next().slideToggle();
	});

	$('.sidebar-accordion_item__title').on('click', function(){
		$('.sidebar-accordion_item').each(function(){
			$(this).find('.sidebar-accordion_item__title').removeClass('active').next().stop().slideUp();
		});

		$(this).toggleClass('active').next().stop().slideToggle();
	});

	// переключение языков
	$('.en').click(function () {
		$('.ru').removeClass('active');
		$(this).addClass('active');

	});
	$('.ru').click(function () {
		$(this).addClass('active');
		$('.en').removeClass('active');
	});

	// появление синего сердца в карточке товара в products
	$('.hidden-card-heart').click(function () {
		$('.hidden-card-heart').eq($(this).index('.hidden-card-heart')).toggleClass('active');
	});
	$('.hidden-card-arrows').click(function () {
		$('.hidden-card-arrows').eq($(this).index('.hidden-card-arrows')).toggleClass('active');
	});


	//  замена текста "В корзине"
	$('.quickview span').click(function () {
		$('.quickview span').eq($(this).index('.quickview span')).toggleClass('active');
	});
	$('.quickview-basket-link').click(function () {
		if (!$(this).data('status')) {
			$(this).html('В КОРЗИНЕ');
			$(this).data('status', true);
		} else {
			$(this).html('В КОРЗИНУ');
			$(this).data('status', false);
		}
	});
	
	//  Появление социальных сетей при клике на вкладку отзывы на странице card.html
	$('.section-tabs li').click(function () {
		if ($(this).hasClass('social-tab')) {
			$('.hidden-social').addClass('active');
		} else {
			$('.hidden-social').removeClass('active');
		}
	});

	//  Появление социальных сетей при клике на вкладку отзывы на странице card.html (мобильная версия)
	$('.product-description-mob-head').click(function () {
		if ($(this).hasClass('social-tab')) {
			$('.hidden-social-mob').toggleClass('active');
		} else {
			$('.hidden-social-mob').removeClass('active');
		}
	});

	var productsSliderDefaults = {
		dots: true,
		arrows: true,
		prevArrow: '<button class="products-slider-arrow prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="products-slider-arrow next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
		slidesToShow: 4,
		slidesToScroll: 4,
		infinite: true,
		touchThreshold: 30,
		responsive: [
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				dots: true,
				arrows: false,
				variableWidth: true,
			}
		},
		{
			breakpoint: 768,
			settings: {
				arrows: false,
				slidesToShow: 2,
				slidesToScroll: 1,
				infinite: true,
				dots: true,
				variableWidth: true,
			}
		},
		{
			breakpoint: 576,
			settings: {
				arrows: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				dots: true,
				variableWidth: true,
			}
		},
		]
	};
	$('.products-slider').slick(productsSliderDefaults);

	/* секция products вкладки, переходящие в аккордеон */
	$(".products-slider:not(:first)").hide();
	// $(".products-slider:first").show();
	/* в режиме вкладок */
	$(".products-ul-nav li").click(function () {
		$(".products-slider").hide();
		var activeTab = $(this).attr("rel");
		$("#" + activeTab).fadeIn('slow', function(){
			$("#" + activeTab).slick('unslick');
			$("#" + activeTab).slick(productsSliderDefaults);
		});
		$(".products-ul-nav li").removeClass("active");
		$(this).addClass("active");
		$(".products-mobile-head").removeClass("active");
		$(".products-mobile-head[rel^='" + activeTab + "']").addClass("active");
	});

	/* в режиме аккордеона */
	$(".products-mobile-head").click(function () {
		$(".products-slider").hide();
		var d_activeTab = $(this).attr("rel");
		$("#" + d_activeTab).fadeIn('slow', function(){
			$("#" + d_activeTab).slick('unslick');
			$("#" + d_activeTab).slick(productsSliderDefaults);
		});
		$(".products-mobile-head").removeClass("active");
		$(this).addClass("active");
		$(".products-ul-nav li").removeClass("active");
		$(".products-ul-nav li[rel^='" + d_activeTab + "']").addClass("active");
	});

	// СЛАЙДЕР В PRODUCTS FOR SMALL SCREEN
	$('.products-slider-mobile').slick({
		dots: true,
		arrows: true,
		prevArrow: '<button class="products-slider-arrow prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="products-slider-arrow next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
		slidesToShow: 4,
		slidesToScroll: 1,
		infinite: true,
		centerMode: true,
		variableWidth: true
	});

	$('.products-slider-static').slick({
		dots: true,
		arrows: true,
		prevArrow: '<button class="prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
		slidesToShow: 4,
		slidesToScroll: 4,
		infinite: true,
		// centerMode: true,
		variableWidth: true,
		responsive: [
			{
				breakpoint: 1240,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true,
					arrows: false,
					centerMode: true,
				},

		  
			}] 
	});
	$('.products-slider-static').slick('setPosition');

	
	$('.products-slider-mobile-static').slick({
		dots: false,
		arrows: true,
		prevArrow: '<button class="prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
		slidesToShow: 4,
		slidesToScroll: 1,
		infinite: true,
		centerMode: true,
		variableWidth: true
	});

	// слайдер в projects
	$('.projects-slider').slick({
		dots: true,
		arrows: true,
		prevArrow: '<button class="prev projects-slider-prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="next projects-slider-next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
		slidesToShow: 4,
		slidesToScroll: 1,
		infinite: true,
		variableWidth: true,
	});
	$('.projects-slider').slick('setPosition');
	
	// слайдер в partners
	$('.partners-slider').slick({
		dots: true,
		arrows: true,
		prevArrow: '<button class="prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
		slidesToShow: 5,
		slidesToScroll: 2,
		swipeToSlide: true,
		touchThreshold: 30,
		infinite: true,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				},  
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					swipeToSlide: false
				}
			}
		]
	});

	$('.header-slider-mob').slick({
		arrows: false,
		dots: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		fade: true,
		adaptiveHeight: true,
	});
	
	// ОТКРЫТИЕ БУРГЕРА
	$('.burger').click(function () {
		$('.burger').addClass('click');
		$('.overlay').addClass('show');
		$('.mobile-nav').addClass('show');
		$('body').addClass('overflow');
	});

	$('.overlay, .click, .close-burger').click(function () {
		$('.mobile-nav').removeClass('show');
		$('.overlay').removeClass('show');
		$('.burger').removeClass('click');
		$('.menu-element__title').removeClass('active');
		$('.menu-element__info').slideUp(300);
	});
 

	// ТАБЫ В БУРГЕРЕ
	$('.element').not(':first').hide();
	$('.mobile-menu-tabs .tab').click(function () {
		$('.mobile-menu-tabs .tab').removeClass('active').eq($(this).index()).addClass('active');
		$('.element').hide().eq($(this).index()).fadeIn('500');
	});

	// ACCORDION В БУРГЕРЕ
	$('.menu-element__title').click(function () {
		if ($('.mobile-menu').hasClass('one')) {
			$('.menu-element__title').not($(this)).removeClass('active');
			$('.menu-element__info').not($(this).next()).slideUp(300);
		}
		$(this).toggleClass('active').next().slideToggle(300);

	});
	  
	// ACCORDION В FOOTER MOBILE
	$('.footer-block-mob .title').click(function () {
		if ($('.footer-block-mob').hasClass('one')) {
			$('.footer-block-mob .title').not($(this)).removeClass('active');
			$('.footer-block-mob .links').not($(this).next()).slideUp(300);
		}
		$(this).toggleClass('active').next().slideToggle(300);

	});

	// УВЕЛИЧЕНИЕ КОЛИЧЕСТВА ТОВАРА В БЫСТРОМ ПРОСМОТРЕ ТОВАРА
	$('.button-minus').click(function () {
		var $input = $(this).parent().find('input, .input');
		var count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		// $input.change();
		return false;
	});
	$('.button-plus').click(function () {
		var $input = $(this).parent().find('input, .input');
		$input.val(parseInt($input.val()) + 1);
		// $input.change();
		return false;
	});

	$('.tab').click(function () {
		$('.tab').removeClass('active').eq($(this).index()).addClass('active');
	});
	$('.tab').keydown(function (e) {
		var tab = $('.header-container');

		if (e.keyCode == 39) {
			$('.nav-dot-current').next().addClass('active').prev().removeClass('active');
			console.log("тоже норм");
			if ($('.tab').eq(3).hasClass('nav-dot-current')) {
				$('.tab').eq(1).prev().addClass('active');
			}
		} else if (e.keyCode == 37) {
			if ($('.tab').eq(0).hasClass('nav-dot-current')) {
				$('.tab').eq(3).addClass('active');
				$('.tab').eq(0).removeClass('active');
			}
			$('.nav-dot-current').prev().addClass('active').next().removeClass('active');
		}
	});

});

$(document).ready(function () {
	var HeaderTop = $('.header').offset().top;
	$(window).scroll(function () {
		if ($(window).scrollTop() > HeaderTop) {
			$('.header').addClass('fixed');
		} else {
			$('.header').removeClass('fixed');
		}
	});
});

$(document).ready(function () {
	$('.transp').wrapInner('<div>').children().addClass('content');
	$('.transp .content').before('<div>').prev().addClass('transparency');
});

// слайдер при нажатии на увеличение изображения на странице project-single
$(document).ready(function () {
	$('.zoom-single-projects_slider').slick({
		dots: true,
		arrows: true,
		prevArrow: '<button class="similar-projects_slider prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="similar-projects_slider next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		variableWidth: true,
		responsive: [{
			breakpoint: 1240,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				dots: false,
				arrows: false
			},
			
		}
		]
	});
	$('.zoom-single-projects_slider').slick('setPosition');
});


// Слайдер single-projects_slider

$(document).ready(function () {
	$('.similar-projects_slider').slick({
		dots: false,
		arrows: true,
		prevArrow: '<button class="similar-projects_slider prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="similar-projects_slider next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
		slidesToShow: 5,
		slidesToScroll: 1,
		infinite: true,
		variableWidth: true,
		responsive: [
			{
			breakpoint: 1240,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				dots: false,
				arrows: false,
				centerMode: true
			}
		  
		}
		]
	});
	// $('.similar-projects_slider').slick('setPosition');
});

// Слайдер team-slider
$(document).ready(function () {
	$('.team-slider').slick({
		dots: false,
		arrows: true,
		prevArrow: '<button class="team-slider prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="team-slider next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="next"></button>',
		slidesToShow: 5,
		slidesToScroll: 1,
		infinite: true,
		variableWidth: true,
		responsive: [
			{
				breakpoint: 1240,
				settings: {
					slidesToShow: 3,
					arrows: false,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					arrows: false,
					centerMode: true
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					arrows: false,
					centerMode: true
				}
			}
		]
	});
	// $('.team-slider').slick('setPosition');
});

// Слайдер reviews-slider
$(document).ready(function () {
	$('.reviews-slider').slick({
		dots: true,
		arrows: true,
		prevArrow: '<button class="review prev"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.8"><path opacity="0.8" d="M0.0268126 5.77975L5.21281 0.59375L6.75781 2.13875L3.11681 5.77975L6.75781 9.42175L5.21281 10.9668L0.0268126 5.77975Z" fill="white"/></g></svg></button>',
		nextArrow: '<button class="review next"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.8" d="M6.97319 5.77975L1.78719 0.59375L0.242187 2.13875L3.88319 5.77975L0.242187 9.42175L1.78719 10.9668L6.97319 5.77975Z" fill="white"/></svg></button>',
		slidesToShow: 3,
		slidesToScroll: 1,
		infinite: true,
		// variableWidth: true,
		responsive: [
			{
				breakpoint: 884,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		 
		]
	});
	$('.reviews-slider').slick('setPosition');
});

// Слайдер reviews-slider на странице о нас
$(document).ready(function () {
	$('.partner-slider').slick({
		dots: true,
		arrows: true,
		prevArrow: '<button class="partner-slider prev"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.8"><path opacity="0.8" d="M0.0268126 5.77975L5.21281 0.59375L6.75781 2.13875L3.11681 5.77975L6.75781 9.42175L5.21281 10.9668L0.0268126 5.77975Z" fill="white"/></g></svg></button>',
		nextArrow: '<button class="partner-slider next"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.8" d="M6.97319 5.77975L1.78719 0.59375L0.242187 2.13875L3.88319 5.77975L0.242187 9.42175L1.78719 10.9668L6.97319 5.77975Z" fill="white"/></svg></button>',
		slidesToScroll: 1,
		infinite: true,
		adaptiveHeight: true,
		rows: 3,
		slidesPerRow: 5,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					arrows: false,
					rows: 3,
					slidesPerRow: 3,
				}
			},
			{
				breakpoint: 700,
				settings: {
					arrows: false,
					rows: 2,
					slidesPerRow: 2,
				}
			},
			{
				breakpoint: 500,
				settings: {
					arrows: false,
					rows: 3,
					slidesPerRow: 1,
				}
			}
		]
	});
	// $('.partner-slider').slick('setPosition');
});


// ТАБЫ В CONDITIONS 
$(document).ready(function () {
	$('.conditions .conditions-steps').not(':first').hide();
	$('.sidebar .tabs li').click(function () {
		$('.sidebar .tabs li').removeClass('active').eq($(this).index()).addClass('active');
		$('.conditions .conditions-steps').hide().eq($(this).index()).fadeIn('500');
	});

	$('.conditions .conditions-steps').not(':first').hide();
	$('.content .tab').click(function () {
		$('.content .tab').removeClass('active').eq($(this).index()).addClass('active');
		$('.conditions .conditions-steps').hide().eq($(this).index()).fadeIn('500');
	});
});

// АККАРДИОН НА СТРАНИЦЕ CATEGORY
$(document).ready(function () {
	$('.filter-name').click(function () {
		if ($('.filters').hasClass('one')) {
			$('.filter-name').not($(this)).removeClass('active');
			$('.filter-block').not($(this).next()).slideUp(300);
		}
		$(this).toggleClass('active').next().slideToggle(300);
	});

	$('.filter-all-svg, .filter-all-svg-burger, .filter-all-svg-up, .filter-all-svg-burger-up').click(function () {
		if ($('.filter-all-svg, .filter-all-svg-burger').hasClass('active')) {
			$('.filter-block').slideUp(300);
			$('.filter-name').removeClass('active');
		} else {
			$('.filter-block').slideDown(300);
			$('.filter-name').addClass('active');
		}
		$(this).toggleClass('active');
	});
	$('.filter-all-svg').click(function () {
		$('.filter-all-svg-up').toggleClass('active');
	});
	$('.filter-all-svg-up').click(function () {
		$('.filter-all-svg').toggleClass('active');
	});
	$('.filter-all-svg-burger-up').click(function () {
		$('.filter-all-svg-burger').toggleClass('active');
	});
	$('.filter-all-svg-burger').click(function () {
		$('.filter-all-svg-burger-up').toggleClass('active');
	});
});

// selection на старнице category
$(document).ready(function () {
	$('.options-item').click(function () {
		$('.options-item').eq($(this).index()).toggleClass('active');
	});
});

// УВЕЛИЧЕНИЕ/УМЕНЬШЕНИЕ КОЛ-ВА ТОВАРА В КАРТОЧКЕ ТОВАРА (страница card)
jQuery(($) => {
	// Уменьшаем на 1 
	$(document).on('click', '.info form .bottom', function () {
		let total = $(this).prev().prev();
		if (total.val() > 1) {
			total.val(+total.val() - 1);
		}
	});

	// Увеличиваем на 1 
	$(document).on('click', '.info form .top', function () {
		let total = $(this).prev();
		total.val(+total.val() + 1);
	});

	// Запрещаем ввод текста 
	document.querySelectorAll('.form-input').forEach(function (el) {
		el.addEventListener('input', function () {
			this.value = this.value.replace(/[^\d]/g, '');
		});
	});

});

/* секция products-descr вкладки, переходящие в аккордеон - страница CARD */
$('.product-description .content').not(':first').hide();
/* в режиме вкладок */
$(".section-tabs li").click(function () {
	$(".product-description .content").hide();
	var activeTabs = $(this).attr("rel");
	$("#" + activeTabs).fadeIn();
	$(".section-tabs li").removeClass("active");
	$(this).addClass("active");
	$(".products-mobile-head").removeClass("active");
	$(".products-mobile-head[rel^='" + activeTabs + "']").addClass("active");
});
/* в режиме аккордеона */
$(".product-description-mob-head").click(function () {
	$(".product-description .content").hide();
	var d_activeTabs = $(this).attr("rel");
	$("#" + d_activeTabs).fadeIn();
	$(".product-description-mob-head").removeClass("active");
	$(this).addClass("active");
	$(".section-tabs li").removeClass("active");
	$(".section-tabs li[rel^='" + d_activeTabs + "']").addClass("active");
});

// profile-settings
function enableInput(id) {
	event.preventDefault();
	document.getElementById(id).disabled = false;
	document.getElementById(id + '-one').style.display = "none";
	document.getElementById(id + '-two').style.display = "flex";
}
function change(id) {
	event.preventDefault();
	document.getElementById(id).disabled = true;
	document.getElementById(id + '-two').style.display = "none";
	document.getElementById(id + '-one').style.display = "flex";
	//document.forms["frmProduct"].submit(); //это чтобы слало куда-то
	return false;
}
// СКРЫТИЕ ГЛАЗА В ИНПУТЕ ПАРОЛЯ
function passVis(id) {
	document.getElementById(id + '-vis').style.display = "none";
	document.getElementById(id + '-hid').style.display = "flex";
}
function passHid(id) {
	document.getElementById(id + '-hid').style.display = "none";
	document.getElementById(id + '-vis').style.display = "flex";
	//document.forms["frmProduct"].submit(); //это чтобы слало куда-то
	return false;
}


$(document).ready(function () {
	// слайдер - мобильных виджетов 
	$('.widgets-slider').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		arrows: false,
		variableWidth: true,
		responsive: [{
			breakpoint: 501,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				infinite: true,
				arrows: true,
				prevArrow: '<div class="arrow-widgets arrow-widgets-prev"><span></span><span></span><span></span></div>',
				nextArrow: '<div class="arrow-widgets arrow-widgets-next"><span></span><span></span><span></span></div>',
				dots: false,
				variableWidth: true,
			},
		}
		]
	});

	$('.project-popup-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		dots: true,
	});	

	// слайдер - быстрый просмотр товара
	$('.slider-for-popup').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		prevArrow: '<button class="slider-for-popup-arrow prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="slider-for-popup-arrow next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="next"></button>',
		// variableWidth: true
	});

	// CARD.HTML
	$('.slider-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		prevArrow: '<button class="card-slider-for prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
		nextArrow: '<button class="card-slider-for next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="next"></button>',
		asNavFor: '.slider-nav',
	});
	$('.slider-nav').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.slider-for',
		dots: false,
		variableWidth: true,
		arrows: true,
		prevArrow: '<button class="card-slider-nav prev"></button>',
		nextArrow: '<button class="card-slider-nav next"></button>',
		centerMode: true,
		focusOnSelect: true
	});

	/* ===== ===== ===== ===== ===== ===== ===== */
	/*       Обработчики модальных окон          */
	/* ===== ===== ===== ===== ===== ===== ===== */

	// открытие / закрытие окна регисрации
	$('.register-modal').click(function () {
		$('.container-register-popup').toggleClass('active');
		$('.container-enter-popup').removeClass('active');
		$('.overlay-popup').addClass('show');
		$('body').addClass('active');
	});
	$('.popup-close, .overlay-popup').click(function () {
		$('.container-register-popup').removeClass('active');
		$('.overlay-popup').removeClass('show');
		$('body').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.container-register-popup').classList.remove('active');
			document.querySelector('.overlay-popup').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	// открытие / закрытие окна входа
	$('.enter-modal').click(function () {
		$('.container-enter-popup').toggleClass('active');
		$('.overlay-popup').toggleClass('show');
		$('body').addClass('active');
	});
	$('.popup-close, .overlay-popup').click(function () {
		$('.container-enter-popup').removeClass('active');
		$('.overlay-popup').removeClass('show');
		$('body').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.container-enter-popup').classList.remove('active');
			document.querySelector('.overlay-popup').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	// открытие / закрытие окна документов
	$('.download-docs').click(function () {
		$('.container-docs-popup').toggleClass('active');
		$('.overlay-popup').toggleClass('show');
		$('body').addClass('active');
	});
	$('.popup-close, .overlay-popup').click(function () {
		$('.container-docs-popup').removeClass('active');
		$('.overlay-popup').removeClass('show');
		$('body').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.container-docs-popup').classList.remove('active');
			document.querySelector('.overlay-popup').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	$('.popup-close, .overlay-popup').click(function () {
		$('.container-project-popup').removeClass('active');
		$('.overlay-popup').removeClass('show');
		$('body').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.container-project-popup').classList.remove('active');
			document.querySelector('.overlay-popup').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	//  быстрый просмотр товара
	$('.card-loop').click(function () {
		$('.container-goods-popup').toggleClass('active').removeClass('closed');
		$('.overlay-popup').toggleClass('show');
		$('body').addClass('active');
	});

	$('.popup-close, .overlay-popup, .download-docs').click(function () {
		$('.container-goods-popup').removeClass('active');
		$('.overlay-popup').addClass('show');
		$('body').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.container-goods-popup').classList.remove('active');
			document.querySelector('.overlay-popup').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	// открытие / закрытие окна купить в 1 клик
	$('.buy-modal').click(function () {
		$('.container-click-popup').toggleClass('active').removeClass('closed');
		$('.container-goods-popup').removeClass('active');
		$('.overlay-popup').addClass('show');
		$('body').addClass('active');
	});

	$('.popup-close, .overlay-popup').click(function () {
		$('.container-click-popup').removeClass('active');
		$('.overlay-popup').removeClass('show');
		$('body').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.container-click-popup').classList.remove('active');
			document.querySelector('.overlay-popup').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	// открытие / закрытие окна заказать консультацию
	$('.consult-modal').click(function () {
		$('.container-consult-popup').toggleClass('active').removeClass('closed');
		$('.overlay-popup').toggleClass('show');
		$('body').addClass('active');
	});

	$('.popup-close, .overlay-popup').click(function () {
		$('.container-consult-popup').removeClass('active');
		$('.overlay-popup').removeClass('show');
		$('body').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.container-consult-popup').classList.remove('active');
			document.querySelector('.overlay-popup').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	// открытие / закрытие окна заказать звонок
	$('.call-modal').click(function () {
		$('.container-call-popup').toggleClass('active').removeClass('closed');
		$('.overlay-popup').toggleClass('show');
		$('body').addClass('active');
	});

	$('.popup-close, .overlay-popup').click(function () {
		$('.container-call-popup').removeClass('active');
		$('.overlay-popup').removeClass('show');
		$('body').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.container-call-popup').classList.remove('active');
			document.querySelector('.overlay-popup').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	/* ===== ===== ===== ===== ===== ===== ===== */
	/*       Обработчики клик событий            */
	/* ===== ===== ===== ===== ===== ===== ===== */

	// Показать еще на странице category
	$('.hidden-category-column').hide();
	$('.show-more').click(function () {
		$('.hidden-category-column').fadeIn(300);
	});

	$('.content-block_hidden').slideUp();
	$('.content-block_title').click(function () {
		if ($('.profile-content').hasClass('one')) {
			$('.content-block_title').not($(this)).removeClass('active');
			$('content-block_hidden').not($(this).next()).slideUp(300);
		}
		$(this).toggleClass('active').next().slideToggle(300);
	});

	// PROFILE
	//profile-selection
	$('.dropdown-one').click(function () {
		$(this).toggleClass('active');
	});
	$('.dropdown-two').click(function () {
		$(this).toggleClass('active');
	});

	// ТАБЫ В my-revies
	$('.profile-content').not(':first').hide();
	$('.profile-tab').click(function () {
		$('.profile-tab').removeClass('active').eq($(this).index()).addClass('active');
		$('.profile-content').hide().eq($(this).index()).fadeIn('500');
	});

	$('.profile-select-body').click(function () {
		$('.profile-select-body').eq($(this).index('.profile-select-body')).not($(this)).hide();
	});

	// плавные переходы по якорным ссылкам
	$('a[href^="#"]').click(function (event) {
		if ( !$(this).hasClass('fancybox-trigger') ) {
			event.preventDefault();
			var sc = $(this).attr("href");

			if ( sc.length > 2 ) {
				var dn = $(sc).offset().top;

				$('html, body').animate({
					scrollTop: dn
				}, 1000);
			}
		}
	});

	$('.compare-descr-value-no').click(function () {
		if (!$(this).data('status')) {
			$(this).html('Нет');
			$(this).data('status', true);
		} else { /* to do */ }
	});
	$('.compare-descr-value-yes').click(function () {
		if (!$(this).data('status')) {
			$(this).html('Да');
			$(this).data('status', true);
		} else { /* to do */ }
	});
	$('.compare-descr-value-yes-basket').click(function () {
		if (!$(this).data('status')) {
			$(this).html('В корзине');
			$(this).data('status', true);
		} else { /* to do */ }
	});
	$('.compare-descr-value-no-basket').click(function () {
		if (!$(this).data('status')) {
			$(this).html('Нет');
			$(this).data('status', true);
		} else { /* to do */ }
	});

	$('.filters-btn').click(function () {
		$('.burger-filter-nav').addClass('active');
		$('.overlay').addClass('show');
		$('body').addClass('active');
	});
	$('.close-burger-filters, .overlay').click(function () {
		$('.burger-filter-nav').removeClass('active');
		$('.overlay').removeClass('show');
		$('body').removeClass('active');
		$('.filter-block').slideUp(300);
		$('.filter-name').removeClass('active');
	});
	document.body.addEventListener('keyup', function (e) {
		var key = e.keyCode;

		if (key == 27) {
			document.querySelector('.burger-filter-nav').classList.remove('active');
			document.querySelector('.overlay').classList.remove('show');
			document.querySelector('body').classList.remove('active');
		}
	}, false);

	$('#wi1, #wi2, #wi3').hide();
	$('#wc1').click(function () {
		$('#wc1').addClass('active');
		$('#wi1').fadeIn('fast').addClass('active');
		$('.widgets-mob').hide();
	});
	$('.inside-back').click(function () {
		$('.widgets-mob').show();
		$('#wi1').hide().removeClass('active');
		$('#wc1').removeClass('active');
	});

	$('#wc2').click(function () {
		$('#wc2').addClass('active');
		$('#wi2').fadeIn('fast').addClass('active');
		$('.widgets-mob').hide();
	});
	$('.inside-back').click(function () {
		$('.widgets-mob').show();
		$('#wi2').hide().removeClass('active');
		$('#wc2').removeClass('active');
	});

	$('#wc3').click(function () {
		$('#wc3').addClass('active');
		$('#wi3').fadeIn('fast').addClass('active');
		$('.widgets-mob').hide();
	});
	$('.inside-back').click(function () {
		$('.widgets-mob').show();
		$('#wi3').hide().removeClass('active');
		$('#wc3').removeClass('active');
	});
});


$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();

	$(".hover-zoom").imagezoomsl({
		zoomrange: [1, 12],
		zoomstart: 4,
		innerzoom: true,
		magnifierborder: "none"
	});

	baguetteBox.run('.content-info_img, .info-flex_img, .content-info_grid__item', {
		animation: 'fadeIn',
		noScrollbars: true,
		buttons: false,
	});

	baguetteBox.run('.slider-for', {
		animation: 'fadeIn',
		noScrollbars: true,
		buttons: true,
	});

	/* SVG Ajax Loading */
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "/local/templates/dcut/assets/img/svg-sprite.svg", true);
	ajax.send();
	ajax.onload = function (e) {
		var block = document.createElement("div");
		block.innerHTML = ajax.responseText;
		document.body.insertBefore(block, document.body.childNodes[0]);
	};

	/* SVG fix for IE 11 */
	document.addEventListener("DOMContentLoaded", function () {
		var baseUrl = window.location.href.replace(window.location.hash, "");

		[].slice.call(document.querySelectorAll("use[*|href]")).filter(function (element) {
			return (element.getAttribute("xlink:href").indexOf("#") === 0);
		}).forEach(function (element) {
			element.setAttribute("xlink:href", baseUrl + element.getAttribute("xlink:href"));
		});

	}, false);
});

$(function () {

	var Page = (function () {

		var $navArrows = $('#nav-arrows'),
			$nav = $('#nav-dots > .header-container button'),
			slitslider = $('#slider').slitslider({
                autoplay: true,
                interval: 5000,
				onBeforeChange: function (slide, pos) {

					$nav.removeClass('nav-dot-current');
					$nav.eq(pos).addClass('nav-dot-current');

				}
			}),

			init = function () {

				initEvents();

			},
			initEvents = function () {

				// add navigation events
				$navArrows.children(':last').on('click', function () {

					slitslider.next();
					return false;

				});

				$navArrows.children(':first').on('click', function () {

					slitslider.previous();
					return false;

				});

				$nav.each(function (i) {

					$(this).on('click', function (event) {

						var $dot = $(this);

						if (!slitslider.isActive()) {

							$nav.removeClass('nav-dot-current');
							$dot.addClass('nav-dot-current');

						}

						slitslider.jump(i + 1);
						return false;

					});

				});

			};

		return {
			init: init
		};

	})();

	Page.init();
});
