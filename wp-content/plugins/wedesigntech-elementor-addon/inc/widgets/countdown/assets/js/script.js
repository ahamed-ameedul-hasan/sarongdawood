(function ($) {

    const wdtCountdownWidgetHandler = function($scope, $) {

        var $countdown_holder     = $scope.find('.wdt-countdown-holder');
        var $downcount            = $countdown_holder.find('.wdt-downcount');
        var $end_date             = $downcount.data('date');
        var $counter_wrapper      = $downcount.find('.wdt-counter-wrapper');
        var $counter_icon_wrapper = $counter_wrapper.find('.wdt-counter-icon-wrapper');
        var $counterdate          = $counter_icon_wrapper.find('.wdt-counter-number.days');
        var $counthours           = $counter_icon_wrapper.find('.wdt-counter-number.hours');
        var $countminutes         = $counter_icon_wrapper.find('.wdt-counter-number.minutes');
        var $countseconds         = $counter_icon_wrapper.find('.wdt-counter-number.seconds');

        var countdownstart = new Date($end_date).getTime();

        const $counter = setInterval(function() {

            var currentdate = new Date().getTime();
                
            var $countdistance = countdownstart - currentdate;
                
            var wdtdays = Math.floor($countdistance / (1000 * 60 * 60 * 24));
            var wdthours = Math.floor(($countdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var wdtminutes = Math.floor(($countdistance % (1000 * 60 * 60)) / (1000 * 60));
            var wdtseconds = Math.floor(($countdistance % (1000 * 60)) / 1000);

            $counterdate.html(wdtdays < 10 ? "0" + wdtdays : wdtdays);
            $counthours.html(wdthours < 10 ? "0" + wdthours : wdthours);
            $countminutes.html(wdtminutes < 10 ? "0" + wdtminutes : wdtminutes);
            $countseconds.html(wdtseconds < 10 ? "0" + wdtseconds : wdtseconds);

            if ( $countdistance < 0 ) {
                $counterdate.html('00');
                $counthours.html('00');
                $countminutes.html('00');
                $countseconds.html('00');

                clearInterval($counter);
            }
        }, 1000);


    }


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-countdown.default', wdtCountdownWidgetHandler);
    });
})(jQuery);