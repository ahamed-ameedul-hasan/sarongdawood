(function ($) {
  
    const wdtInteractiveShowcaseTemplateWidgetHandler = function($scope, $) {

        const $scopeItem = $scope.find('.wdt-interactive-showcase-template-container');
        const $hover_and_click = $scopeItem.data('click');
        const $showcaseItem = $scope.find('.wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper');

        var hover_content_section = $showcaseItem.find('.wdt-content-item .wdt-content-detail-group');
        var image_content_section = $showcaseItem.find('.wdt-content-item .wdt-content-media-group');
        
        // Standard Item - Image on Move
        const $showcaseItem_move = $scope.find('.wdt-interactive-showcase-template-container .wdt-rc-template-standard');
        var hover_centent_move_section = $showcaseItem_move.find('.wdt-content-item > .wdt-content-detail-group');
        var hover_image_move_section = $showcaseItem_move.find('.wdt-content-item > .wdt-content-media-group');
        
        $showcaseItem.find('.wdt-content-item:first-child > div').addClass('wdt-interactive-showcase-template-active');

        if( $hover_and_click ) {
            // Content on click
            hover_content_section.click( function() {

                var content_id_name = $(this).attr('id');
                if( ! ($(this).hasClass('wdt-interactive-showcase-template-active')) ) {
                    image_content_section.removeClass('wdt-interactive-showcase-template-active');
                    hover_content_section.removeClass('wdt-interactive-showcase-template-active');
                    $(this).addClass('wdt-interactive-showcase-template-active');
    
                    image_content_section.each(function() {
                        var this_image       = $(this);
                        var image_id_name    = this_image.attr('id');                
                        if( image_content_section.is('#' + content_id_name) ) {
                            if( image_id_name == content_id_name ) {
                                this_image.addClass('wdt-interactive-showcase-template-active');
                            } else {
                                this_image.removeClass('wdt-interactive-showcase-template-active');
                            }
                        }
                    });
                }
            });
        } else {
            // Content on hover
            hover_content_section.mouseover( function() {

                var content_id_name = $(this).attr('id');
                if( ! ($(this).hasClass('wdt-interactive-showcase-template-active')) ) {
                    image_content_section.removeClass('wdt-interactive-showcase-template-active');
                    hover_content_section.removeClass('wdt-interactive-showcase-template-active');
                    $(this).addClass('wdt-interactive-showcase-template-active');
    
                    image_content_section.each(function() {
                        var this_image       = $(this);
                        var image_id_name    = this_image.attr('id');                
                        if( image_content_section.is('#' + content_id_name) ) {
                            if( image_id_name == content_id_name ) {
                                this_image.addClass('wdt-interactive-showcase-template-active');
                            } else {
                                this_image.removeClass('wdt-interactive-showcase-template-active');
                            }
                        }
                    });
                }
            });
            

            // Image on Move
            hover_centent_move_section.each(function() {

                var this_content = $(this);

                this_content.mousemove( function(event) {
                    x = event.offsetX;
                    y = event.offsetY;
                    hover_image_move_section.each(function() {
                        var this_image = $(this);
                        this_image.css({'left': x +'px', 'top': y +'px'});
                    });
                } );

            });
        }
  
    };
  
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-interactive-showcase-template.default', wdtInteractiveShowcaseTemplateWidgetHandler);
    });
  
  })(jQuery);