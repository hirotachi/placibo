(function($) {
	"use strict";   
	var WidgetCategoriessHandler = function($scope, $) { 

		var $slider = $scope.find('.categories-container.slider');
		var $datasetting = $slider.attr('data-settings');

		if($slider.length > 0 && $datasetting !='') { 

			var $selector 	= $slider.find('ul.products'), 
				$options 	= JSON.parse($datasetting); 
			
			$selector.slick($options);

		}
	};
	
	// Make sure we run this code under Elementor
	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/rt_categories.default', WidgetCategoriessHandler);
	});
})(jQuery);