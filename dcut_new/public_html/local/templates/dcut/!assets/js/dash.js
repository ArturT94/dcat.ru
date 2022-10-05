$(document).ready(function () {
    // ---------------------переключение языков-------------------------------
   
    $('.en').click(function () {
        $('.ru').removeClass('active');
        $(this).addClass('active');

    });
    $('.ru').click(function () {
        $(this).addClass('active');
        $('.en').removeClass('active');
    });







    // ------------ появление синего сердца в карточке товара в products ------------------------------------------------------
    
    $('.item-like__heart').click(function () {
        $('.item-like__heart').eq($(this).index('.item-like__heart')).toggleClass('active');
    });
    $('.item-like__arrows').click(function () {
        $('.item-like__arrows').eq($(this).index('.item-like__arrows')).toggleClass('active');
    });

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






    $('.products-slider').slick({
        dots: true,
        arrows: true,
        prevArrow: '<button class="products-slider-arrow prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
        nextArrow: '<button class="products-slider-arrow next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: true,
        // centerMode: true,
        variableWidth: true,
        responsive: [{
            breakpoint: 1240,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: true,
                arrows: false,
                centerMode: true,
                }
        },
            {
                breakpoint: 800,
                settings: {
                    arrows: false
                }
            },
        ]
    });
    $('.products-slider').slick('setPosition');
// ------- СЛАЙДЕР В PRODUCTS FOR SMALL SCREEN ---------------------------------------------------
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

    $('.products-slider-mobile').not(':first').slideUp();
    $('.products-mobile-head').click(function () {
        if ($('.products-container-mobile').hasClass('one')) {
            $('.products-mobile-head').not($(this)).removeClass('active');
            $('.products-slider-mobile').not($(this).next()).slideUp(300);
        }
        $(this).toggleClass('active').next().slideToggle(300);
        $('.products-slider-mobile').slick('setPosition');
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





// ------------------------ Табы в products -------------------------------------

    
    $('.products-slider').not(':first').hide();
    $('.products-tabs li').click(function () {
        $('.products-tabs li').removeClass('active').eq($(this).index()).addClass('active');
        $('.products-slider').hide().eq($(this).index()).fadeIn('500');
        $('.products-slider').slick('setPosition');  // Этот метод "встряхивает" слайдер переинициализирует его после каждого изменения страницы или переключении вкладок
    });





// --------------- слайдер в projects ------------------------------------------ 
    $('.projects-slider').slick({
        dots: true,
        arrows: true,
        prevArrow: '<button class="prev projects-slider-prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
        nextArrow: '<button class="next projects-slider-next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        variableWidth: true,
        // responsive: [
            // {
            //     breakpoint: 1920,
            //     settings: {
            //         slidesToShow: 4.5,
            //         slidesToScroll: 1,
            //         arrows: true,
            //         dots: true,
            //         variableWidth: true,
            //     }
            // },
            // {
            //     breakpoint: 1530,
            //     settings: {
            //         slidesToShow: 4.5,
            //         slidesToScroll: 1,
            //         dots: true,
            //         arrows: true,
            //         // variableWidth: true,
            //     }
            // },
        //     {
        //         breakpoint: 1921,
        //         settings: {
        //             slidesToShow: 4,
        //             slidesToScroll: 1,
        //             arrows: true,
        //             dots: true,
        //             variableWidth: true,
        //         }
        //     },
        //     {
        //         breakpoint: 1530,
        //         settings: {
        //             slidesToShow: 4,
        //             slidesToScroll: 1,
        //             arrows: true,
        //             dots: true,
        //             variableWidth: true,
        //         }
        //     },
        //     {
        //         breakpoint: 1200,
        //         settings: {
        //             slidesToShow: 3,
        //             slidesToScroll: 1,
        //             arrows: true,
        //             dots: true,
        //             variableWidth: true,
        //         }
        //     },
        //     {
        //         breakpoint: 950,
        //         settings: {
        //             slidesToShow: 2,
        //             slidesToScroll: 1,
        //             arrows: true,
        //             dots: true,
        //             variableWidth: true,
        //         }
        //     },
        //     {
        //         breakpoint: 650,
        //         settings: {
        //             slidesToScroll: 1,
        //             slidesToShow: 2,
        //             arrows: true,
        //             dots: true,
        //             variableWidth: true,
        //         }
        //     },
        // ]
    });
    $('.projects-slider').slick('setPosition');
    






// ------------ слайдер в partners -----------------------------------------------------------------

    $('.partners-slider').slick({
        dots: true,
        arrows: true,
        prevArrow: '<button class="prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
        nextArrow: '<button class="next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="prev"></button>',
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: true,
        variableWidth: true,
        responsive: [{
            breakpoint: 1230,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: true,
                variableWidth: true,
            },  
        },
        {
            breakpoint: 800,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                variableWidth: true,
            }
        },
        {
            breakpoint: 501,
            settings: {
                // slidesToShow: 2,
                slidesToScroll: 1,
                arrows: true,
                dots: true,
                variableWidth: true,
            }
        },
        {
            breakpoint: 370,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                dots: true,
                variableWidth: true,
            }
        },
    ]
    });
    $('.partners-slider').slick('setPosition');
    




// ---------- ОТКРЫТИЕ БУРГЕРА ------------------------------------------------
    $('.burger').click(function () {
        $('.burger').addClass('click');
        $('.overlay').addClass('show');
        $('.mobile-nav').addClass('show');
        $('body').addClass('overflow');
    });
    $('.mobile-nav a, .overlay, .click, .close-burger').click(function () {
        $('.mobile-nav').removeClass('show');
        $('.overlay').removeClass('show');
        $('.burger').removeClass('click');
        $('.menu-element__title').removeClass('active');
        $('.menu-element__info').slideUp(300);
    });
 

// ------ ТАБЫ В БУРГЕРЕ ---------------------------------------------------
    $('.element').not(':first').hide();
    $('.mobile-menu-tabs .tab').click(function () {
        $('.mobile-menu-tabs .tab').removeClass('active').eq($(this).index()).addClass('active');
        $('.element').hide().eq($(this).index()).fadeIn('500');
    });

// ----- ACCORDION В БУРГЕРЕ -------------------------------------------------------
    $('.menu-element__title').click(function () {
        if ($('.mobile-menu').hasClass('one')) {
            $('.menu-element__title').not($(this)).removeClass('active');
            $('.menu-element__info').not($(this).next()).slideUp(300);
        }
        $(this).toggleClass('active').next().slideToggle(300);

    });
      
// ACCORDION В FOOTER MOBILE
// ==========================================================
    $('.footer-mob .title').click(function () {
        if ($('.footer-block-mob').hasClass('one')) {
            $('.footer-mob .title').not($(this)).removeClass('active');
            $('.footer-mob .links').not($(this).next()).slideUp(300);
        }
        $(this).toggleClass('active').next().slideToggle(300);

    });






// УВЕЛИЧЕНИЕ КОЛИЧЕСТВА ТОВАРА В БЫСТРОМ ПРОСМОТРЕ ТОВАРА
        $('.button-minus').click(function () {
            var $input = $(this).parent().find('input, .input');
            var count = parseInt($input.val()) - 1;
            count = count < 1 ? 1 : count;
            $input.val(count);
            $input.change();
            return false;
        });
        $('.button-plus').click(function () {
            var $input = $(this).parent().find('input, .input');
            $input.val(parseInt($input.val()) + 1);
            $input.change();
            return false;
        });

});






// активная полоска

var tabs = document.getElementsByClassName('tab');

// Array.prototype.forEach.call(tabs, function (tab) {
//     tab.addEventListener('click', setActiveClass);
    
//     function setActiveClass(evt) {
//         Array.prototype.forEach.call(tabs, function (tab) {
//             tab.classList.remove('active');
//         });

//         evt.currentTarget.classList.add('active');
//     }
// });

$(document).ready(function () {
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






    

    



// плавающий header
// var header = new Headhesive('.header');

// $(document).ready(function () {
//     $(document).scroll(function () {
//         if ($(document).scrollTop() > $('.header').height() + 100) {
//             $('.header').addClass('fixed'); 
//         } else {
//             $('.header').removeClass('fixed'); 
//         }  
//     });
// });

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
    $('.header-slider-mob').slick({
        arrows: true,
        prevArrow: '<div class="arrow-mob arrow-mob-prev"><span></span><span></span><span></span></div>',
        nextArrow: '<div class="arrow-mob arrow-mob-next"><span></span><span></span><span></span></div>',
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        fade: true,
        autoplay: true,
        autoplaySpeed: 6000,
        speed: 1700,
        responsive: [
            {
                breakpoint: 700,
                settings: {
                    arrows: true,
                }
            }
        ]
    });
    $('.header-slider-mob').slick('setPosition');
});




$(document).ready(function () {
    $('.transp').wrapInner('<div>').children().addClass('content');
    $('.transp .content').before('<div>').prev().addClass('transparency');
});



// ТАБЫ В SERVICES
$(document).ready(function () {
    // $('.services-two').not(':first').hide();
    $('.services .content').hide();
    $('.services-one li, .services-column-tab').click(function () {
        $('.services-one li').removeClass('active').eq($(this).index()).addClass('active');
        $('.services .content').hide().eq($(this).index()).fadeIn('500');
        $('.services-two').hide();
    });
});












// СТРАНИЦА PROJECTS - Tabs

$(document).ready(function () {
    $('.projects-all').not(':first').hide();
    $('.projects-tab').click(function () {
        $('.projects-tab').removeClass('active').eq($(this).index()).addClass('active');
        $('.projects-all').hide().eq($(this).index()).fadeIn('500');
    });
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




// АККАРДИОН НА СТРАНИЦЕ ABOUT-US
$('.sidebar-accordion_item__title').click(function () {
    if ($('.sidebar-accordion').hasClass('one')) {
        $('.sidebar-accordion_item__title').not($(this)).removeClass('active');
        $('.sidebar-accordion_item__text').not($(this).next()).slideUp(300);
    }
    $(this).toggleClass('active').next().slideToggle(300);

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
        responsive: [{
            breakpoint: 1240,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: false,
                arrows: false,
                centerMode: true
            }
        }]
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








// Слайдер reviews-slider
$(document).ready(function () {
    $('.partner-slider').slick({
        dots: true,
        arrows: true,
        prevArrow: '<button class="partner-slider prev"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.8"><path opacity="0.8" d="M0.0268126 5.77975L5.21281 0.59375L6.75781 2.13875L3.11681 5.77975L6.75781 9.42175L5.21281 10.9668L0.0268126 5.77975Z" fill="white"/></g></svg></button>',
        nextArrow: '<button class="partner-slider next"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.8" d="M6.97319 5.77975L1.78719 0.59375L0.242187 2.13875L3.88319 5.77975L0.242187 9.42175L1.78719 10.9668L6.97319 5.77975Z" fill="white"/></svg></button>',
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        // variableWidth: true,
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    arrows: false
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
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


// Показать еще на странице category
$(document).ready(function () {
    $('.hidden-category-column').hide();
    $('.show-more').click(function () {
        $('.hidden-category-column').fadeIn(300);
    });
});










// CARD.HTML
$(document).ready(function () {
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="card-slider-for prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
        nextArrow: '<button class="card-slider-for next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="next"></button>',
        asNavFor: '.slider-nav',
        // variableWidth: true
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



// ТАБЫ В CARD.HTML
$(document).ready(function () {
    $('.product-description .content').not(':first').hide();
    $('.section-tabs li').click(function () {
        $('.section-tabs li').removeClass('active').eq($(this).index()).addClass('active');
        $('.product-description .content').hide().eq($(this).index()).fadeIn('500');
    });
});




// ACCORDION В CARD MOBILE
$(document).ready(function () {
    $('.product-description-mob .content').not(':first').slideUp();
    $('.product-description-mob-head').click(function () {
        if ($('.container-large').hasClass('one')) {
            $('.product-description-mob-head').not($(this)).removeClass('active');
            $('.product-description-mob .content').not($(this).next()).slideUp(300);
        }
        $(this).toggleClass('active').next().slideToggle(300);
    });
});



















// POPUP =====================================================================================
// слайдер - быстрый просмотр товара
$(document).ready(function () {
    $('.slider-for-popup').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="slider-for-popup-arrow prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
        nextArrow: '<button class="slider-for-popup-arrow next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="next"></button>',
        // variableWidth: true
    });
});

// слайдер - карточки сотрудников
$(document).ready(function () {
    $('.member-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="member-slider-arrow prev"><img src="/local/templates/dcut/assets/img/products/prev-arrow.svg" alt="prev"></button>',
        nextArrow: '<button class="member-slider-arrow next"><img src="/local/templates/dcut/assets/img/products/next-arrow.svg" alt="next"></button>',
        // variableWidth: true
    });
});


// открытие / закрытие карточки сотрудника
$(document).ready(function () {
    $('.team-icon-hidden').click(function () {
        $('.container-member-popup').toggleClass('active');
        $('.overlay-popup').toggleClass('show');
        $('body').addClass('active');
    });

    $('.popup-close, .overlay-popup').click(function () {
        $('.container-member-popup').removeClass('active');
        $('.overlay-popup').removeClass('show');  
        $('body').removeClass('active');
    });
    document.body.addEventListener('keyup', function (e) {
        var key = e.keyCode;

        if (key == 27) {
            document.querySelector('.container-member-popup').classList.remove('active');
            document.querySelector('.overlay-popup').classList.remove('show');
            document.querySelector('body').classList.remove('active');
        }
    }, false);
});


// открытие / закрытие окна регисрации
$(document).ready(function () {
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
        
    });

    // открытие / закрытие окна входа
    $(document).ready(function () {
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
    });

    // открытие / закрытие окна документов
    $(document).ready(function () {
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

    });



    // открытие / закрытие окна с увеличенными картинками
    $(document).ready(function () {
        $('.project-popup-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            // variableWidth: true
        });
    });

    $(document).ready(function () {
        $('.single-project_info__img').click(function () {
            $('.container-project-popup').toggleClass('active').removeClass('closed');
            $('.overlay-popup').toggleClass('show');
            $('body').addClass('active');
        });

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
    });


    //  быстрый просмотр товара
    $(document).ready(function () {
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

    });

    // открытие / закрытие окна купить в 1 клик
    $(document).ready(function () {
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
 
    });


    // открытие / закрытие окна заказать консультацию
    $(document).ready(function () {
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

    });

    // открытие / закрытие окна заказать звонок
    $(document).ready(function () {
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

    });







    // PROFILE

    //profile-selection
    $(document).ready(function () {
        $('.dropdown-one').click(function () {
            $(this).toggleClass('active');
        });
        $('.dropdown-two').click(function () {
            $(this).toggleClass('active');
        });
    });


    // ТАБЫ В my-revies
    $(document).ready(function () {
        $('.profile-content').not(':first').hide();
        $('.profile-tab').click(function () {
            $('.profile-tab').removeClass('active').eq($(this).index()).addClass('active');
            $('.profile-content').hide().eq($(this).index()).fadeIn('500');
        });
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


    $(document).ready(function () {
        $('.content-block_hidden').slideUp();
        $('.content-block_title').click(function () {
            if ($('.profile-content').hasClass('one')) {
                $('.content-block_title').not($(this)).removeClass('active');
                $('content-block_hidden').not($(this).next()).slideUp(300);
            }
            $(this).toggleClass('active').next().slideToggle(300);
        });
    });




    // --------------------------
    // jQuery(document).ready(function () {
    //     jQuery('.scrollbar-inner').scrollbar();
    // });






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
        $('.profile-select-body').click(function () {
            $('.profile-select-body').eq($(this).index('.profile-select-body')).not($(this)).hide();
        });
    });










    // плавные переходы по якорным ссылкам
    $(document).ready(function () {
        $('a[href^="#"]').click(function (event) {
            event.preventDefault(); // отменяем стандартное действие
            let sc = $(this).attr("href"), //sc - в переменную заносим информацию о том, к какому блоку надо перейти
                dn = $(sc).offset().top; //dn - определяем положение блока на странице

            $('html, body').animate({
                scrollTop: dn
            }, 1000); // анимируем
        });
    });






    




    $(document).ready(function () {
        $('.compare-descr-value-no').click(function () {
            if (!$(this).data('status')) {
                $(this).html('Нет');
                $(this).data('status', true);
            } else {

            }
        });
        $('.compare-descr-value-yes').click(function () {
            if (!$(this).data('status')) {
                $(this).html('Да');
                $(this).data('status', true);
            } else {

            }
        });
        $('.compare-descr-value-yes-basket').click(function () {
            if (!$(this).data('status')) {
                $(this).html('В корзине');
                $(this).data('status', true);
            } else {

            }
        });
        $('.compare-descr-value-no-basket').click(function () {
            if (!$(this).data('status')) {
                $(this).html('Нет');
                $(this).data('status', true);
            } else {

            }
        });
    });

$(document).ready(function () {
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
});




// открытие счетчика на странице servces при нажатии на вкладку сервисное обслуживание
$(document).ready(function () {
    $('.counter-services').hide();
    $('.services-tab').click(function () {
        $('.counter-services').fadeIn();
        $('.counter-row').addClass('active');
    });
    $('.other-tab').click(function () {
        $('.counter-services').hide();
        $('.counter-row').removeClass('active');
    });
});





// слайдер - мобильных виджетов 
$(document).ready(function () {
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
});





// табы в profile.html - мобильная версия
// $(document).ready(function () {
//     $('.inside').hide();
//     $('.widgets-slider-column').click(function () {
//         $('[data-toggle="active"]').removeClass('active').eq($(this).index($(''))).addClass('active');
//         $('.inside').hide().eq($(this).index()).fadeIn('fast').addClass('active');
//         $('.widgets-mob').hide();
//     });
//     $('.inside-back').click(function () {
//         $('.widgets-mob').show();
//         $('.inside').hide().removeClass('active');  
//         $('[data-toggle="active"]').removeClass('active');
//     });
// });


$(document).ready(function () {
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








