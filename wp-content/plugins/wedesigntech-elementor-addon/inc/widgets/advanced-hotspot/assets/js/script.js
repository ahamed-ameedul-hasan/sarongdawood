(function ($) {

    const wdtAdvancedHotspotWidgetHandler = function($scope, $) {
  
      const $this_holder = $scope.find('.wdt-advanced-hotspot-holder');
      const $tooltip_wrapper = $this_holder.find('.wdt-advanced-tooltip-wrapper');
      //  $('.wdt-advanced-hotspot-repeater-item').first()
        $('.wdt-advanced-tooltip-wrapper:first-child').addClass('hotspot-active');
        $(".wdt-advanced-tooltip-wrapper:first-child >.wdt-advanced-tooltip-content").addClass("active");
        $tooltip_wrapper.find(".wdt-advanced-hotspot-repeater-item").click(function(){
            $(".wdt-advanced-tooltip-content").removeClass("active");
            $('.wdt-advanced-tooltip-wrapper').removeClass('hotspot-active');
            $(this).prev().addClass("active");
            $(this).prev().parent().addClass('hotspot-active');
        });
  
    };
  
    $(window).on('elementor/frontend/init', function () {
          elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-hotspot.default', wdtAdvancedHotspotWidgetHandler);
    });
  
  })(jQuery);
  