 (function ($) {

    const wdtParallaxCarouselWidgetHandler = function($scope, $) {

      const $parallax_carousel_holder = $scope.find('.wdt-parallax-carousel-holder');
      // const $parallax_carousel_option = $parallax_carousel_holder.data('settings');
      const $swiperItem = $parallax_carousel_holder.find('.swiper');
      const $moduleId = $swiperItem.data('wrapper-class');

      // const $arrows = ($parallax_carousel_option['arrows'] !== undefined) ? ($parallax_carousel_option['arrows'] == 'yes') : false;
        
      /* if($parallax_carousel_option === undefined) {
        return;
      } */

      var swiper = {
        simulateTouch: true,
        keyboardControl: true,
        clickable: true,
        grabCursor: true,

        // loop: $loop,
        // spaceBetween: $space_between,
        // slidesPerView: $slides_to_show,
        // slidesPerGroup: $slides_to_scroll,
        // freeMode: $freemode,
        // watchSlidesProgress: true,
        // centeredSlides: $centered_slides,

        speed: 600,
        parallax: true,
        /* pagination: {
          el: ".swiper-pagination",
          clickable: true,
        }, */
        navigation: {
          prevEl: '.wdt-arrow-thumb-pagination-prev-'+$moduleId,
          nextEl: '.wdt-arrow-thumb-pagination-next-'+$moduleId
        }
      }

      const swiperGallery = new Swiper('.'+$moduleId, swiper);

    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-parallax-carousel.default', wdtParallaxCarouselWidgetHandler);
    });

  })(jQuery);