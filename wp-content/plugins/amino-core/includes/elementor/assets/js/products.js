(function($) {
	"use strict";   
	var WidgetProductsHandler = function($scope, $) { 

		var $slider = $scope.find('.products-container.slider');
		var $datasetting = $slider.attr('data-settings');
		var $data_responsive = JSON.parse($slider.attr('data-responsive'));
		if(!$data_responsive.slidesToShow_laptop) {
			$data_responsive.slidesToShow_laptop = 4
		}
		if(!$data_responsive.slidesToShow_tablet) {
			$data_responsive.slidesToShow_tablet = 3
		}
		if(!$data_responsive.slidesToShow_phone) {
			$data_responsive.slidesToShow_phone = 2
		}
		if(!$data_responsive.slidesToShow_small_phone) {
			$data_responsive.slidesToShow_small_phone = 1
		}
		var responsiveOptions = {
            responsive: [
                {
			      breakpoint: 1199,
			      settings: {
			        slidesToShow: $data_responsive.slidesToShow_laptop,
			        slidesToScroll: 1,
			      }
			    },
			    {
			      breakpoint: 992,
			      settings: {
			        slidesToShow: $data_responsive.slidesToShow_tablet,
			        slidesToScroll: 1
			      }
			    },
			    {
			      breakpoint: 768,
			      settings: {
			        slidesToShow: $data_responsive.slidesToShow_phone,
			        slidesToScroll: 1
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: $data_responsive.slidesToShow_small_phone,
			        slidesToScroll: 1
			      }
			    }
            ]
        };
		if($slider.length > 0 && $slickOptions !='') { 

			var $selector 	= $slider.find('ul.products'), 
				$options 	= JSON.parse($datasetting); 

			var $slickOptions = $.extend({}, responsiveOptions, $options);	
			$selector.slick($slickOptions);


		}
	};
	
	// Make sure we run this code under Elementor
	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/rt_products.default', WidgetProductsHandler);
	});
})(jQuery);