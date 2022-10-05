
(function ($) {

    $.fn.bekeyProgressbar = function (options) {

        options = $.extend({
            animate: true,
            animateText: true
        }, options);

        var $this = $(this);

        var $progressBar = $this;
        var $progressCount = $progressBar.find('.ProgressBar-percentage--count'); // выбирает первый элемент из массива ProgressBar-percentage--count
        var $progressCountB = $progressBar.find('.ProgressBar-percentage--countB'); // выбирает первый элемент из массива ProgressBar-percentage--countB
        var $progressCountC = $progressBar.find('.ProgressBar-percentage--countC'); // выбирает первый элемент из массива ProgressBar-percentage--countC
        var $circle = $progressBar.find('.ProgressBar-circle'); // выбирает первый элемент из массива ProgressBar-circle
        var $circleB = $progressBar.find('.ProgressBar-circleB'); // выбирает первый элемент из массива ProgressBar-circleB
        var $circleC = $progressBar.find('.ProgressBar-circleC'); // выбирает первый элемент из массива ProgressBar-circleC
        var percentageProgress = $progressBar.attr('data-progress'); // получает атрибут data-progress
        var percentageProgressB = $progressBar.attr('data-progress-b'); // получает атрибут data-progress-b
        var percentageProgressC = $progressBar.attr('data-progress-c'); // получает атрибут data-progress-c
        var percentageRemaining = (100 - percentageProgress);
        var percentageRemainingB = (100 - 75);
        var percentageRemainingC = (100 - 85);
        var percentageText = $progressCount.parent().attr('data-progress');
        var percentageTextB = $progressCountB.parent().attr('data-progress-b');
        var percentageTextC = $progressCountC.parent().attr('data-progress-c');

        //Calcule la circonférence du cercle
        var radius = $circle.attr('r');
        var radiusB = $circleB.attr('r');
        var radiusC = $circleC.attr('r');
        var diameter = radius * 2;
        var diameterB = radiusB * 2;
        var diameterC = radiusC * 2;
        var circumference = Math.round(Math.PI * diameter);
        var circumferenceB = Math.round(Math.PI * diameterB);
        var circumferenceC = Math.round(Math.PI * diameterC);

        //Calcule le pourcentage d'avancement
        var percentage = circumference * percentageRemaining / 100;
        var percentageB = circumferenceB * percentageRemainingB / 100;
        var percentageC = circumferenceC * percentageRemainingC / 100;

        $circle.css({
            'stroke-dasharray': circumference,
            'stroke-dashoffset': percentage
        });
        $circleB.css({
            'stroke-dasharray': circumferenceB,
            'stroke-dashoffset': percentageB
        });
        $circleC.css({
            'stroke-dasharray': circumferenceC,
            'stroke-dashoffset': percentageC
        });

        //Animation de la barre de progression
        if (options.animate === true) {
            $circle.css({
                'stroke-dashoffset': circumference
            }).animate({
                'stroke-dashoffset': percentage
            }, 6000);
            $circleB.css({
                'stroke-dashoffset': circumferenceB
            }).animate({
                'stroke-dashoffset': percentageB
            }, 6000);
            $circleC.css({
                'stroke-dashoffset': circumferenceC
            }).animate({
                'stroke-dashoffset': percentageC
            }, 6000);
        }

        //Animation du texte (pourcentage)
        if (options.animateText == true) {

            $({
                Counter: 0
            }).animate({
                Counter: percentageText,
                CounterB: percentageTextB,
                CounterC: percentageTextC
            }, {
                duration: 6000,
                step: function () {
                    function formatNumber (num) {
                        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ")
                    }
                    var clearCounterB = Math.ceil(this.CounterB), clearCounterC = Math.ceil(this.CounterC);
                    
                    $progressCount.text(Math.ceil(this.Counter) + '%');
                    $progressCountB.text(formatNumber(clearCounterB));
                    $progressCountC.text(formatNumber(clearCounterC));
                }
            });

        } else {
            $progressCount.text(percentageText + '%');
            $progressCountB.text(percentageTextB);
            $progressCountC.text(percentageTextC);
        }

    };

})(jQuery);
$(document).ready(function progress() {

    $('.ProgressBar--animateNone').bekeyProgressbar({
        animate: false,
        animateText: false
    });

    $('.ProgressBar--animateCircle').bekeyProgressbar({
        animate: true,
        animateText: false
    });

    $('.ProgressBar--animateText').bekeyProgressbar({
        animate: false,
        animateText: true
    });

    $('.ProgressBar--animateAll').bekeyProgressbar();
});




