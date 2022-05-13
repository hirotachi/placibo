( function( $, api ) {
	api.bind('preview-ready', function() {
		var elements = {
			'.custom-logo-link': 'Logo',
			'.header-contact': 'Contact',
			'.cart-dropdown': 'Cart',
			'#_desktop_cart_': 'Cart',
			'#_desktop_txt_notice_': 'Notice',
			'.header-link1': 'HTML',
			'.header-link2': 'HTML',
			'.amino-currency-switcher': 'HTML',
			'.amino-language-switcher': 'HTML',
			'.header-account-block': 'Account',
			'.promo-block': 'Promo',
			'.search-block': 'Search',
			'.primary-menu-wrapper': 'Main menu',
			'.vertical-menu-wrapper': 'Vertical menu',
			'.site-footer': 'Footer',
			'.footer-column.sidebar-footer-column-1'    : 'Footer column 1',
			'.footer-column.sidebar-footer-column-2'    : 'Footer column 2',
			'.footer-column.sidebar-footer-column-3'    : 'Footer column 3',
			'.footer-column.sidebar-footer-column-4'    : 'Footer column 4',
			'.footer-column.sidebar-footer-column-5'    : 'Footer column 5',
		};
		$.each(elements, function(el, title) {
			$(document).on( 'mouseenter', el, function(e){
				$(this).addClass('rt-active-element');
				$(this).prepend('<div class="rt-edit-shortcut">'+title+'</div>');
			});
			$(document).on( 'mouseleave', el, function(e){
				$(this).removeClass('rt-active-element');
				$('.rt-edit-shortcut').remove();
			});
		});
		$(document).on('click', '.rt-edit-shortcut', function(e) {
				e.preventDefault();
				var section_id = $(this).parents('[data-element]').attr('data-element') || '';
				if (section_id && target.wp.customize.section(section_id) )
					target.wp.customize.section(section_id).focus();
				else 
					$(this).parent().find('.customize-partial-edit-shortcut').first().trigger('click');
			}
		);
	});
}( jQuery, wp.customize ) );