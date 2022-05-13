(function($) {
	"use strict";   
	var WidgetLatestHandler = function($scope, $) { 

		var $slider = $scope.find('.brand-logo.slider');
		var $datasetting = $slider.attr('data-settings');

		if($slider.length > 0 && $datasetting !='') { 

			var $selector 	= $slider, 
				$options 	= JSON.parse($datasetting); 
			
			$selector.slick($options);

		}
	};
	
	// Make sure we run this code under Elementor
	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/rt_brandlogo.default', WidgetLatestHandler);
	});
})(jQuery);