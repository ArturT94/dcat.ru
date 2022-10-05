var submit,
    validation_text_ru = /^[а-яА-Яёй -]+$/,
    validation_phone = /^[0-9() +-]+$/,
    validation_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

function initprForm(JS_OBJECT) {
    var prForm = $('.prForm'),
        TEXT_RU = prForm.find('.text-ru'),
        EMAIL = prForm.find('input[name=EMAIL]'),
        PHONE = prForm.find('input[name=PHONE]'),
        PERSONAL_DATA = prForm.find('input[name=confirm-privacy]'),
        UPDATE_CAPTCHA = prForm.find('.update-captcha'),
        BUTTON = prForm.find('button[type=submit]'),
        CAPTCHA_SID = prForm.find('input[name=captcha_sid]'),
        CAPTCHA_IMG = prForm.find('.captcha-img');

	if($(PERSONAL_DATA).data('type') == 'basket'){
		PERSONAL_DATA = $('.customConfirm');
	}

    prForm.on('focus', 'input, textarea', function () {
        if ($(this).hasClass('novalid')) $(this).removeClass('novalid');
    })
        .on('change', 'input,select', function () {
            if ($(this).hasClass('novalid')) $(this).removeClass('novalid');
        })
        .on('click', '.update-captcha', function () {
            $.ajax({
                dataType: 'json',
                url: JS_OBJECT.AJAX_CAPTCHA_PATH,
                beforeSend: function () {
                    if (UPDATE_CAPTCHA.hasClass('rotate'))
                        UPDATE_CAPTCHA.removeClass('rotate');
                    else
                        UPDATE_CAPTCHA.addClass('rotate');
                }
            })
                .success(function (data) {
                    CAPTCHA_SID.attr('value', data.RESULT.capCode);
                    CAPTCHA_IMG.attr('src', data.RESULT.capSrc);
                });
        })
        .submit(function (event) {
            submit = true;
            $(this).find('.required').each(function () {
                if ($(this).val() == '') {
                    $(this).addClass('novalid');
                    submit = false;
                }
            });
            PERSONAL_DATA.each(function () {
                validationPersonalData($(this));
            });
            TEXT_RU.each(function () {
                validationField($(this), validation_text_ru);
            });
            PHONE.each(function () {
                validationField($(this), validation_phone);
            });
            EMAIL.each(function () {
                validationField($(this), validation_email);
            });
            if (submit) $(this).ajaxSubmit({
                dataType: 'json',
                data: {DATA: JS_OBJECT},
                beforeSubmit: function () {
                    BUTTON.attr('disabled', 'disabled');
                    BUTTON.text('Отправка...');
                },
                success: function (data) {
                    if (data.ERROR == '') {
                        $(this).clearForm();
                        $.fancybox.close(true);
                        $.fancybox.open($('<div/>', {
                            class: 'success-message modal--lg',
                            html: '<div class="success-message-inner"><div class="modal-title">'+JS_OBJECT.SUCCESS_MESSAGE_TITLE+'</div><div class="modal-description">'+JS_OBJECT.SUCCESS_MESSAGE+'</div><div class="text-center"><a href="#" data-fancybox-close class="adp-btn adp-btn--primary">Вернуться в магазин</a></div></div></div>'
                        }),{padding:0});
                        if (typeof ym !== 'undefined')
                            ym(JS_OBJECT.YA_COUNTER_ID, 'reachGoal', JS_OBJECT.GOAL_METRIKA);
                        if (typeof gtag !== 'undefined')
                            gtag('event', JS_OBJECT.GOAL_ANALITICS, {});
                    }
                    else {
                        $(this).find('input[name=captcha_word]').addClass('novalid');
                    }
                    CAPTCHA_SID.attr('value', data.RESULT.capCode);
                    CAPTCHA_IMG.attr('src', data.RESULT.capSrc);
                    BUTTON.text(JS_OBJECT.BUTTON);
                    BUTTON.attr('disabled', false);
                    $('.close_fancy').on('click',function () {
                        $.fancybox.close(true);
                    })
                }
            });
            event.preventDefault();
        });
    function validationField(object, patern) {
        if (object.val() != '' && object.val() != ' ' && !patern.test(object.val())) {
            object.addClass('novalid');
            submit = false;
        }
    }
    function validationPersonalData(object) {
        if(object.val() != 'on' || object.prop('checked') != true){
            object.addClass('novalid');
            submit = false;
        }else{
			object.removeClass('novalid');
		}
    }
}