(function( $ ) {
	"use strict";
	var aminoHelper = {
		tabPanel: function(){
			$('div.rt-tabs-wrapper').not('.rt-ajax-tabs').each( function() {
				$('ul.rt-tabs a').on( 'click', function( e ) {
					e.preventDefault();
					var tab_wrapper = $(this).closest( '.rt-tabs-wrapper' );
					tab_wrapper.find('ul.rt-tabs li').removeClass( 'active' );
					$(this).parent().addClass( 'active' );
					$(tab_wrapper).find('.rt-tab-panel').removeClass('opened');
					$( $( this ).attr( 'href' ) ).addClass('opened');
				});
				$(this).find('ul.rt-tabs li').eq(0).find('a').click();
			});	
		},
		accordionPanel: function(){
			if($('.accordion-wrapper').length <= 0) return;
			var $accordion = $('.accordion-item');
			$accordion.each(function() {
				$(this).find('.accordion-title').on('click', function(e) {
					e.preventDefault();
					var tabId = $(this).attr('href');
					if($(this).hasClass('opened')){
						$(tabId).slideUp();
						$(this).removeClass('opened')
					}else{
						$(tabId).slideDown();
						$(this).addClass('opened')
					}
				});
			});
			// Open the first tab
			$('.accordion-wrapper').each( function() {
				$(this).find('.accordion-item').eq(0).find('a').click();
			});
		},
	};
	var amino = {
		init: function(){
			aminoHelper.tabPanel();
			aminoHelper.accordionPanel();
			this.rtTabProductAjax();
			this.headerMobile(); //general
			this.headerSticky(); //general
			this.mobileMenu(); //general
			this.mobileFooter(); //general
			this.headerSearch(); //general
			this.headerPopupLogin(); //general
			this.initSlickSlider(); //general
			this.ajaxLoadMoreItem(); // shop 
			this.backToTop(); //general
			this.productQuickView(); //general - woo
			this.sidePanel(); //general
			this.rtMegamenu(); //general
			this.productVariationDefault(); // single product - quickview
			this.countDownBlock(); //general -woo
			this.wooProductContentFixed(); // single product - quickview
			this.wooProductImage(); // single product - quickview
			this.wooProductVideo(); // single product - quickview		
			this.variationSwatches(); // single product - quickview
			this.shopVariantSwatches();
			this.wooProductQuantity();
			this.sideBarHomePage2(); // just for amino homepage2
			this.customLatestpostWidget();
			if(this.isShopPage){
				this.shopAjaxActions();
			}
			if(this.isProductPage){
				this.wooInitZoom(); // single product
				this.wooInitPhotoswipe(); // single product
				this.wooAddToCart(); // single product
			}
			if(this.hasVerticalMenu){
				this.verticalMenu();
			}
			if(this.hasHeaderPromo){
				this.headerPromo();
			}
		},
		sideBarHomePage2: function() {
			const sideBarHome2 = document.querySelector(".customfor-homepage2")
			if (sideBarHome2) {
				const header = document.querySelector(".desktop-header .main-header")
			
				const adminBar = document.querySelector("#wpadminbar")
				let heightSideBar
				heightSideBar = window.innerHeight - header.offsetHeight

				if (adminBar) {
					heightSideBar = window.innerHeight - header.offsetHeight - adminBar.offsetHeight
				}
				sideBarHome2.style.height = heightSideBar + "px"
				window.addEventListener('resize', () => {
					heightSideBar = window.innerHeight - header.offsetHeight

					if (adminBar) {
						heightSideBar = window.innerHeight - header.offsetHeight - adminBar.offsetHeight
					}
					sideBarHome2.style.height = heightSideBar + "px"
				});
			}
			
		},
		customLatestpostWidget: function() {
			window.addEventListener("load",() => {
				const latestPostItems = document.querySelectorAll('.wp-block-latest-posts > li');
				if (latestPostItems) {
					latestPostItems.forEach((item) => {
						const itemImage = item.querySelector('.wp-block-latest-posts__featured-image')
						if (itemImage) {
							const itemContent = document.createElement('div')
							itemContent.classList.add('wp-block-latest-posts__content')
							item.appendChild(itemContent)
							const itemTitle = item.querySelector('li > a')
							const itemAuthor = item.querySelector('.wp-block-latest-posts__post-author')
							const itemDate = item.querySelector('.wp-block-latest-posts__post-date')
							const itemExpert = item.querySelector('.wp-block-latest-posts__post-excerpt')
							if (itemTitle) itemContent.insertAdjacentElement("beforeend",itemTitle)
							if (itemAuthor) itemContent.insertAdjacentElement("beforeend",itemAuthor)
							if (itemDate) itemContent.insertAdjacentElement("beforeend",itemDate)
							if (itemExpert) itemContent.insertAdjacentElement("beforeend",itemExpert)
						}	
					})
				}
			})
			
		},
		aminoChecker: function() {
			this.isShopPage = ($('.archive-products').length) ? true : false;
			this.isProductPage = ($('.product.type-product').length) ? true : false;
			this.isQuickView = ($('.product.product-quickview').length) ? true : false;
			this.hasVerticalMenu = ($('.vertical-menu').length) ? true : false;
			this.hasHeaderPromo = ($('.promo-block').length) ? true : false;
		},
		setCookie: function(key, value, expiry) {
	        var expires = new Date();
	        expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
	        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
	    },
		getCookie: function(key) {
	        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
	        return keyValue ? keyValue[2] : null;
	    },
	    eraseCookie: function(key) {
	        var keyValue = this.getCookie(key);
	        this.setCookie(key, keyValue, '-1');
	    },
		preloader: function(){
			if($('#preloader').length > 0) {
				$('#preloader').fadeOut('slow', function() {
					$(this).remove();
				});
			}
		},
		headerPromo: function(){
			$('.promo_close').on('click', function(){
				$('.promo-block').slideUp();
				amino.setCookie('promo-block' , true , 1);
			})
		},
		headerSticky: function(){
			if($('#header .desktop-header .has-sticky').length > 0){
				const current_width = window.innerWidth,
					  mobile = current_width < 992;
				if(mobile) {
					var headerSpaceH = $('.mobile-header').outerHeight();
				}else{
					var headerSpaceH = $('#header').outerHeight();
				}
			}
			let position = $(window).scrollTop(); 
			$(window).scroll(function(){
				const headerHeight = $('#header').outerHeight(),
					screenWidth = $(window).width();
				if($(this).scrollTop() > headerHeight){
					$('#header').addClass("sticky-enable");
					$('#header').css('height', headerSpaceH + 'px');
				}else{
					$('#header').removeClass("sticky-enable");
					 $('#header').css('height', '');
				}
				//Scroll event
				var scroll = $(window).scrollTop();
			    if(scroll > position) {
			       $('#header').removeClass('scrollup').addClass('scrolldown');
			    } else {
			        $('#header').removeClass('scrolldown').addClass('scrollup');
			    }
			    position = scroll;
			});
		},
		headerPopupLogin: function(){
			function showerror(element){
				element.css("border-color","red");
			}
			function hideerror(element){
				element.css("border-color","");
			}
			function validateEmail(value){
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				if (reg.test(value) == false) {
					return false;
				}
				return true;
			}
			$(document).on("submit", '#login-form-popup .woocommerce-form-login', function(e){
				var form = $(this);
				var error;
				var username = form.find("#username");
				var password = form.find("#password");
				if( username.val() === '' ){
					form.find(".login_msg.fail").text(aminoVars.required_message).show();
					showerror( username );
					error = true;
				} else{
					hideerror(username);
				}	
				if(password.val() == '' ){
					form.find(".login_msg.fail").text(aminoVars.required_message).show();
					showerror(password);
					error = true;
				} else {
					hideerror(password);
				}
				if(error == true){
					return false;
				}
				form.find(".login_msg").hide();
				form.find('button.button').addClass('loading');
				jQuery.ajax({
					type: 'POST',
					dataType: 'json',
					url: aminoVars.ajax_url,
					data: form.serialize(),
					success: function(data){
						form.find('button.button').removeClass('loading');
						if (data.loggedin == true){
							form.find(".login_msg.success").html(data.message).show();
							setTimeout(function(){
								if ( data.redirect != false ) {
									window.location = data.redirect;
								} else {
									window.location.reload();
								}
							}, 3000);
						} else {
							form.find(".login_msg.fail").html(data.message).show();
						}
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
							msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status == 404) {
							msg = 'Requested page not found. [404]';
						} else if (jqXHR.status == 500) {
							msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
							msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
							msg = 'Time out error.';
						} else if (exception === 'abort') {
							msg = 'Ajax request aborted.';
						} else if (jqXHR.responseText === '-1') {
							msg = 'Please refresh page and try again.';
						} else {
							msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						form.find('button.button').removeClass('loading');
						form.find(".login_msg.fail").hide();
						form.find(".login_msg.fail").html(msg).show();
			    	},
				});
				e.preventDefault();
			});
			/*
			* AJAX registration
			*/
			$(document).on("submit", '#login-form-popup .woocommerce-form-register', function(e){
				var form = $(this);
				// validation 
				var error;
				var reg_email = form.find("#reg_email");
				var reg_password = form.find("#reg_password");
				if( reg_email.val() === '' ){
					form.find(".register_msg.fail").text(aminoVars.required_message).show();
					showerror( reg_email );
					error = true;		
				} else {
					if( validateEmail( reg_email.val() ) ){
						hideerror( reg_email );						
					} else {
						form.find(".register_msg.fail").text(aminoVars.valid_email).show();
						showerror( reg_email );
						error = true;			
					}				
				}
				if(reg_password.val() == '' ){
					form.find(".register_msg.fail").text(aminoVars.required_message).show();
					showerror(reg_password);
					error = true;		
				} else {
					hideerror(reg_password);		
				}
				if(error == true){
					return false;
				}
				form.find('button.button').addClass('loading');
				form.find(".register_msg").hide();
				jQuery.ajax({
					type: 'POST',
					dataType: 'json',
					url: aminoVars.ajax_url,
					data: form.serialize(),
					success: function(data){
						form.find('button.button').removeClass('loading');
						if ( data.code === 200 ){
							form.find(".register_msg.success").text(data.message).show();
							if ( data.redirect != false ) {
								window.location.href = data.redirect;
							} else {
								window.location.reload();
							}
						} else {
							form.find(".register_msg.fail").text(data.message).show();
						}
					},
					error: function (jqXHR, exception) {
						var msg = '';
						if (jqXHR.status === 0) {
							msg = 'Not connect.\n Verify Network.';
						} else if (jqXHR.status === 404) {
							msg = 'Requested page not found. [404]';
						} else if (jqXHR.status === 500) {
							msg = 'Internal Server Error [500].';
						} else if (exception === 'parsererror') {
							msg = 'Requested JSON parse failed.';
						} else if (exception === 'timeout') {
							msg = 'Time out error.';
						} else if (exception === 'abort') {
							msg = 'Ajax request aborted.';
						} else if (jqXHR.responseText === '-1') {
							msg = 'Please refresh page and try again.';
						} else {
							msg = 'Uncaught Error.\n' + jqXHR.responseText;
						}
						form.find('button.button').removeClass('loading');
						form.find(".register_msg.fail").hide();
						form.find(".register_msg.fail").html(msg).show();
			    	},
				});
				e.preventDefault();
			});
		},
		headerMobile: function(){
			var current_width = window.innerWidth,
				mobile = current_width < 992;
			if(mobile){
				toggleMobileStyles();
			}
			function swapChildren(obj1, obj2) {
			  const temp = obj2.children().detach();
			  obj2.empty().append(obj1.children().detach());
			  obj1.append(temp);
			}
			function toggleMobileStyles() {
				var current_width = window.innerWidth,
					min_width = 992,
					mobile = current_width < min_width;
			  	if (mobile) {
				    $("*[id^='_desktop_']").each((idx, el) => {
				      const target = $(`#${el.id.replace('_desktop_', '_mobile_')}`);
				      if (target.length) {
				        swapChildren($(el), target);
				      }
				    });
				} else {
				    $("*[id^='_mobile_']").each((idx, el) => {
				      const target = $(`#${el.id.replace('_mobile_', '_desktop_')}`);
				      if (target.length) {
				        swapChildren($(el), target);
				      }
				    });
				}
			}
			$(window).on('resize', () => {
				const cw = current_width;
				const mw = 992;
				const w = window.innerWidth;
				const toggle = (cw >= mw && w < mw) || (cw < mw && w >= mw);
				current_width = w;
				if(toggle){
					toggleMobileStyles();
				}
			});
		},
		mobileMenu: function(){
			$('.navbar-toggler').each(function(){
				$(this).on('click', function(e){
					e.preventDefault();
					if($(this).hasClass('collapsed')) {
						$(this).closest('li.menu-item').addClass('open');
						$(this).removeClass('collapsed');
					}else{
						$(this).closest('li.menu-item').removeClass('open');
						$(this).addClass('collapsed');
					}
				})			
			})
		},
		mobileFooter: function(){
			$('.footer-main .widget .widget-title').on('click', function() {
						
				if($(this).closest('.widget').hasClass('opened')){
					$(this).closest('.widget').find('.widget-title ~ *').slideUp();
					$(this).closest('.widget').removeClass('opened');
					$(this).removeClass('opened')
				}else{
					$(this).closest('.widget').addClass('opened');
					$(this).addClass('opened');
					$(this).closest('.widget').find('.widget-title ~ *').slideDown();
				}
			});
		},
		rtMegamenu: function(){
			$('#_desktop_menu_ .mega-menu').each(function(){
				if($(this).hasClass('mega-full')) {
					var itemLeftOffset = $(this).offset().left;
					$(this).children('.mega-dropdown-menu').css('left' , '-'+ itemLeftOffset + 'px' )
				}
			})
			$('#_desktop_menu_ .submenu-constant-width').each(function(){
				var itemLeftOffset = $(this).parent().offset().left,
					submenuWidth = $(this).data('width'),
					windowWidth = $( window ).width();
				if((itemLeftOffset + submenuWidth ) > windowWidth) {
					var leftOffset = itemLeftOffset + submenuWidth - windowWidth;
					$(this).css('left', '-' + leftOffset + 'px');
				}
			})
		},
		verticalMenu: function(){
			//Click to show vertical menu
		    $('.click-action .vmenu-title').on('click', function(){
				$(this).next('.menu-wrapper').toggle();
			})
		},
		headerSearch: function(){
			if($('.header-block.search-simple').length > 0) {
				$('.search-simple .search-field').on('click', function(){
					if($('.search_result').is(':empty')) {
						$('.search-keywords-list').show();
					}else {
						return;
					}
				})
				$('body').not('.search-simple').on('click', function(){
					$('.search-keywords-list').hide();
				})
			};
			var ajaxSearch = function(){
				var timer ;	
				var cat = '';
				$( ".amino_ajax_search" ).click(function(e){
					e.stopPropagation();
					if(!$('.search_result').is(':empty')) {
						$( ".search-wrapper" ).addClass('has-result');
					}
					$(this).keyup(function() {
						$('.search-keywords-list').hide();
						if($(this).val().length >= 3){
							$(".search_result").removeClass('d-none');
							$( ".search_result" ).html('');
							var pr = $(this).closest('.search-wrapper');
							$(".search_content").addClass('loading_search');

							clearTimeout(timer);
							timer = setTimeout(function() {
								get_post(pr);
							}, aminoVars.time_out);
							$('.clear_search').addClass('show');
						}else{
							$(".search_result").addClass('d-none');
							$( ".search_result" ).html('');
							$('.clear_search').removeClass('show');
						}
					});
				});
				$('.clear_search').click(function(){
					$( ".search-wrapper" ).removeClass('has-result');
					$( ".amino_ajax_search" ).val('');
					$( ".search_result" ).html('');
					$(this).removeClass('show');
				});
				$( ".product_categories" ).change(function(){
					var pr = $(this).closest('.search-wrapper');
					if( pr.find('.product_categories').val() != null ) {
						cat = pr.find('.product_categories').val();
					}
					if($(".amino_ajax_search").val().length >= 3){
						$( ".search-wrapper" ).removeClass('has-result');
						$( ".search_result" ).html('');
						$(".search_content").addClass('loading_search');
						get_post(pr);
					}
				});
				$('html').click(function() {
					$(".search_result").addClass('d-none');
					$( ".search-wrapper" ).removeClass('has-result');
				});
				$('.search_result,.product_categories').click(function(e){
					e.stopPropagation();
				});
				function get_post(pr) {
					if(pr.find( ".amino_ajax_search" ).val().length < 3) {
						$( ".search_content" ).removeClass('loading_search');
						return;
					}
					var result = pr.find('.search_result');
					if(cat){
						var data = {
							'action': 'amino_get_ajax_search',
							'keyword': pr.find( ".amino_ajax_search" ).val(),
							'product_cat': cat
						};
					}else{
						var data = {
							'action': 'amino_get_ajax_search',
							'keyword': pr.find( ".amino_ajax_search" ).val(),
						};
					}
					$.get(aminoVars.ajax_url, data, function(response) {
						$( ".search-wrapper" ).addClass('has-result');
						$( ".search_content" ).removeClass('loading_search');
						$( ".search_result" ).removeClass('d-none');
						var html = '';
						html += '<div class="result-wrapper">';
							for(var i=0 ; i<response.length ; i++){
								if(response[i]['value'] != '') {
									if(response[i]['not_found']){
										html += '<div class="search-not-found">'+ response[i]['value'] +'</div>';
									}else{
										html += '<div class="content-preview">';
											html += '<div class="featured-image">';
												html += '<a href="'+ response[i]['permalink'] +'">';
													html += response[i]['thumbnail'];
												html += '</a>';
											html += '</div>';
											html += '<div class="item-desc">';
												html += '<a href="'+ response[i]['permalink'] +'" class="product-name">' + response[i]['value'] + '</a>';
												if(response[i]['price']) {
													html += '<div class="content-price">' + response[i]['price'] + '</div>';
												}
											html += '</div>';
										html += '</div>';
									}
								}else{
									html += '<div class="content-preview search-devider">'+ response[i]['divider'] +'</div>';
								}
							}
						html += '</div>';
						result.html(html);
					});
				}
			};
			ajaxSearch();
		},
		sidePanel: function(){
			const $body = $('body');
			// Open Mini Cart
			$body.on('click', '.minicart-side > a', function(e) {
				e.preventDefault();
				minicartPanelAction('open');
			});
			// Open popup login
			$body.on('click', 'a.login-popup-form', function(e){
				e.preventDefault();
				loginPanelAction('open');
			})
			// Open Filters
			$body.on('click', 'button.button-show-filter', function(e) {
				e.preventDefault();
				filterPanelAction('open');
			});
			// Open Menu Mobile
			$body.on('click', 'a.m-menu-btn', function(e) {
				e.preventDefault();
				menuPanelAction('open');
			});
			// Open Menu Dropdown
			$body.on('click', 'a.menu-dropdown-btn', function(e) {
				e.preventDefault();
				menuDropdownAction('open');
			});
			// Open Search
			$body.on('click', '.header-block > button', function(e) {
				e.preventDefault();
				searchPanelAction('open');
			});
			// Close Panel
			$('.side-close-icon , .amino-close-side').on('click', function(e){
				e.preventDefault();
				console.log();
				minicartPanelAction('close');
				menuPanelAction('close');
				menuDropdownAction('close');
				filterPanelAction('close');
				searchPanelAction('close');
				loginPanelAction('close');
			});
			// Close side action
			var closeSideAction = function($event){
				if($event == 'open'){
					$('.amino-close-side').addClass('amino-close-side-open');
					$('body').addClass('has-side-open');
					
				}else{
					$('.amino-close-side').removeClass('amino-close-side-open');
					$('body').removeClass('has-side-open');
					
				}
			};
			// Mini cart action
			var minicartPanelAction = function($event){
				if($event == 'open'){
					$('.minicart-side #cart-side').addClass('cart-open');
					closeSideAction('open');
				}else{
					$('.minicart-side #cart-side').removeClass('cart-open');
					closeSideAction('close');
				}
			};
			// Search action
			var searchPanelAction = function($event){
				if($event == 'open'){
					$('.search-sidebar .search-wrapper').addClass('search-open');
					closeSideAction('open');
				}else{
					$('.search-sidebar  .search-wrapper').removeClass('search-open');
					closeSideAction('close');
				}
			};
			// Filters action
			var filterPanelAction = function($event){
				if($event == 'open'){
					$('.filter-side').addClass('filter-open');
					closeSideAction('open');
				}else{
					$('.filter-side').removeClass('filter-open');
					closeSideAction('close');
				}
			};
			// Filters action
			var loginPanelAction = function($event){
				if($event == 'open'){
					$('#login-form-popup').addClass('form-open');
					closeSideAction('open');
				}else{
					$('#login-form-popup').removeClass('form-open');
					closeSideAction('close');
				}
			};
			// Mobile menu action
			var menuPanelAction = function($event){
				if($event == 'open'){
					$('#menu-side').addClass('menu-open');
					closeSideAction('open');
				}else{
					$('#menu-side').removeClass('menu-open');
					$('#menu-side li.menu-item').each(function(){
						$(this).removeClass('open');
					})
					$('#menu-side li.menu-item .navbar-toggler').each(function(){
						$(this).addClass('collapsed');
					})
					closeSideAction('close');
				}
			};
			// Menu dropdown action
			var menuDropdownAction = function($event){
				if($event == 'open'){
					$('#menu-dropdown-side').addClass('menu-open');
					closeSideAction('open');
				}else{
					$('#menu-dropdown-side').removeClass('menu-open');
					$('#menu-dropdown-side li.menu-item').each(function(){
						$(this).removeClass('open');
					})
					$('#menu-dropdown-side li.menu-item .navbar-toggler').each(function(){
						$(this).addClass('collapsed');
					})
					closeSideAction('close');
				}
			};
		},
		initSlickSlider: function(){
			$(".slick-slider-block").each(function(){
				var responsive = $(this).data('slick-responsive'),
					defaultOptions = {
			            rows: 1,
			            responsive: [
			                {
						      breakpoint: 1536,
						      settings: {
						        slidesToShow: responsive.items_laptop,
						        slidesToScroll: responsive.slidesToScroll,
						      }
						    },
							{
						      breakpoint: 1200,
						      settings: {
						        slidesToShow: responsive.items_landscape_tablet,
						        slidesToScroll: responsive.slidesToScroll,
						      }
						    },
						    {
						      breakpoint: 992,
						      settings: {
						        slidesToShow: responsive.items_portrait_tablet,
						        slidesToScroll: responsive.items_portrait_tablet,
						      }
						    },
						    {
						      breakpoint: 768,
						      settings: {
						        slidesToShow: responsive.items_landscape_mobile,
						        slidesToScroll: responsive.items_landscape_mobile,
						      }
						    },
							{
						      breakpoint: 568,
						      settings: {
						        slidesToShow: responsive.items_portrait_mobile,
						        slidesToScroll: responsive.items_portrait_mobile,
						      }
						    },
						    {
						      breakpoint: 360,
						      settings: {
						        slidesToShow: responsive.items_small_mobile,
						        slidesToScroll: responsive.items_small_mobile,
						      }
						    }
			            ]
			        },
			        slickOptions = $.extend({}, defaultOptions, $(this).data('slick-options'));
				$(this).not('.slick-initialized').slick(slickOptions);
			});
		},
		ajaxLoadMoreItem: function() {
			var btn_loadmore = $('.amino-ajax-loadmore');
			btn_loadmore.each( function( i, val ) {
				var data_option = $(this).data( 'load-more' );
				if ( data_option !== undefined ) {
					var page      = data_option.page,
						container = data_option.container,
						layout    = data_option.layout,
						isLoading = false,
						anchor    = $( val ).find( 'a' ),
						next      = $( anchor ).attr( 'href' ),
						i 		  = 2;
					// Load more
					if ( layout == 'loadmore' ) {
						$( val ).on( 'click', 'a', function( e ) {
							e.preventDefault();
							anchor = $( val ).find( 'a' );
							next   = $( anchor ).attr( 'href' );
							$( anchor ).html( '<i class="fa fa-circle-o-notch fa-spin"></i>' + aminoVars.loading );
							getData();
						});
					}
					// Infinite Scroll Loading
					if ( layout == 'infinite' ) {
						var animationFrame = function() {
							anchor = $( val ).find( 'a' );
							next   = $( anchor ).attr( 'href' );
							var bottomOffset = $( '.' + container ).offset().top + $( '.' + container ).height() - $( window ).scrollTop();
							if ( bottomOffset < window.innerHeight && bottomOffset > 0 && ! isLoading ) {
								if ( ! next )
									return;
								isLoading = true;
								$( anchor ).html( '<i class="fa fa-circle-o-notch fa-spin"></i>' + aminoVars.loading );
								getData();
							}
						};
						var scrollHandler = function() {
							requestAnimationFrame( animationFrame );
						};
						$( window ).scroll( scrollHandler );
					}
					var getData = function() {
						$.get( next + '', function( data ) {
							var content    = $( '.' + container, data ).wrapInner( '' ).html(),
								newElement = $( '.' + container, data ).find( '.post, .product' );
							$( content ).imagesLoaded( function() {
								next = $( anchor, data ).attr( 'href' );
								$( '.' + container ).append( newElement );
							});
							$( anchor ).text( aminoVars.load_more );
							if ( page > i ) {
								if ( aminoVars !== undefined && aminoVars.permalink == 'plain' ) {
									var link = next.replace( /paged=+[0-9]+/gi, 'paged=' + ( i + 1 ) );
								} else {
									var link = next.replace( /page\/+[0-9]+\//gi, 'page/' + ( i + 1 ) + '/' );
								}
								$( anchor ).attr( 'href', link );
							} else {
								$( anchor ).text( aminoVars.no_more_item );
								$( anchor ).removeAttr( 'href' ).addClass( 'disabled' );
							}
							isLoading = false;
							i++;
						});
					}
				}
			});
		},
		backToTop: function(){
			var backToTop = $('#back-to-top');
			backToTop.children('a').on('click', function(){
				$('html, body').animate({'scrollTop': 0 }, 400);
			})
			$(window).scroll(function(){
				if ($(window).scrollTop() > 100) {
					backToTop.addClass('active');
				} else {
					backToTop.removeClass('active');
				}
			})
		},
		productQuickView: function() {
			$( 'body' ).on( 'click', '.btn-quickview', function( e ) {
				var _this = $( this );
				_this.addClass('loading');
				var id = _this.attr( 'data-product' ),
					data = {
						action: 'amino_quickview',
						product: id
					};
				$.post( aminoVars.ajax_url, data, function( response ) {
					if ( typeof $.fn.magnificPopup != 'undefined' ) {
						$.magnificPopup.open( {
							items: {
								src: response
							},
							removalDelay: 500,
							callbacks: {
								beforeOpen: function() {
									this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
									this.st.mainClass = 'mfp-left-horizontal';
								},
								open: function() {
									amino.variationSwatches();
								},
							},
						} );
					}
					setTimeout(function() {
						if ( $( '.product-quickview form' ).hasClass( 'variations_form' ) ) {
							$( '.product-quickview form.variations_form' ).wc_variation_form();
							$( '.product-quickview select' ).trigger( 'change' );
						}
					}, 100);
					_this.removeClass('loading');
					amino.quickviewProductImage();
					amino.productVariationDefault();
				} );
				e.preventDefault();
				e.stopPropagation();
			} );
		},
		countDownBlock: function(){
			$('.block-countdown').each(function(){
				var endDate = $(this).data('end-date');
				$(this).countdown( endDate, function(event) {
					var start_format = '<div class="countdown-inner">';
					var end_format = '</div>';
				    var format = '<span class="countdown-hour"><strong>%-H</strong> <span>%!H:' + aminoVars.text_hour + ','+ aminoVars.text_hour_plu + ';</span></span> '
		                + '<span class="countdown-min"><strong>%-M</strong> <span>%!M:' + aminoVars.text_min + ','+ aminoVars.text_min_plu + ';</span></span> '
		                + '<span class="countdown-sec"><strong>%-S</strong> <span>%!S:' + aminoVars.text_sec + ','+ aminoVars.text_sec_plu + ';</span></span>';
		            if(event.offset.days > 0) { format = '<span class="countdown-day"><strong>%-D</strong> <span>%!D:'+ aminoVars.text_day +','+ aminoVars.text_day_plu +';</strong></span></span>' + format; }
				    $(this).html(event.strftime(start_format + format + end_format));
				    //$(this).countdown('pause');
			    });
			});
		},
		wooProductSingleCountdown: function(endDateSale){
			$('.amino-product-single-countdown').countdown( endDateSale, function(event) {
				var start_format = '<div class="countdown-inner">';
				var end_format = '</div>';
			    var format = '<span class="countdown-hour"><strong>%-H</strong> <span>%!H:' + aminoVars.text_hour + ','+ aminoVars.text_hour_plu + ';</span></span> '
	                + '<span class="countdown-min"><strong>%-M</strong> <span>%!M:' + aminoVars.text_min + ','+ aminoVars.text_min_plu + ';</span></span> '
	                + '<span class="countdown-sec"><strong>%-S</strong> <span>%!S:' + aminoVars.text_sec + ','+ aminoVars.text_sec_plu + ';</span></span>';
	            if(event.offset.days > 0) { format = '<span class="countdown-day"><strong>%-D</strong> <span>%!D:'+ aminoVars.text_day +','+ aminoVars.text_day_plu +';</strong></span></span>' + format; }
			    $(this).html(event.strftime(start_format + format + end_format));
		    });
		},
		wooInitZoom: function(){
			var $zoomTarget = $( '.product-image-item' ),
	            zoomEnabled = false,
	            $zoomSelector = $( '.product-images' );
	        $( $zoomTarget ).each( function() {
	            var image = $(this).find( 'img' );
	            if (image.data('large_image_width') > $(this).width() ) {
	                zoomEnabled = true;
	                return false;
	            }
	        } );
	        if($zoomSelector.hasClass('image-zoom')) zoomEnabled = true; // tam thoi de the nay.s
	        // But only zoom if the img is larger than its container.
	        if ( zoomEnabled ) {
	            var zoomOptions = {
	                touch: true,
	                callback: function(){
	                	amino.wooInitPhotoswipe();
	                }
	            };
	            if ( 'ontouchstart' in window ) {
	                zoomOptions.on = 'click';
	            }
	            $zoomTarget.trigger( 'zoom.destroy' );
	            if(window.innerWidth > 1024) {
	            	$zoomTarget.zoom( zoomOptions );
	            }
	            setTimeout( function() {
					if ( $zoomTarget.find(':hover').length ) {
						$zoomTarget.trigger( 'mouseover' );
					}
				}, 100 );
	        }
		},
		quickviewProductImage: function(){
			var $qv_images = $('.product-quickview .product-images'),
				$qv_thumbnails = $('.product-quickview .product-thumbnails');
			$qv_images.slick();
			$qv_thumbnails
			 	.on('init', function(event, slick) {
			 		$('.product-quickview .product-thumbnails .slick-slide.slick-current').addClass('is-active');
			 	})
			 	.slick();
			$qv_images.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
			 	$qv_thumbnails.slick('slickGoTo', nextSlide);
			 	var currrentNavSlideElem = $qv_thumbnails.find('.slick-slide[data-slick-index="' + nextSlide + '"]');
			 	$qv_thumbnails.find('.slick-slide').removeClass('is-active');
			 	currrentNavSlideElem.addClass('is-active');
			});
			$qv_thumbnails.on('click', '.slick-slide', function(event) {
			 	event.preventDefault();
			 	var goToSingleSlide = $(this).data('slick-index');
			 	$qv_images.slick('slickGoTo', goToSingleSlide);
			});
		},
		wooProductImage: function(){
			var $images = $('.product .product-images.slider-layout'),
				$product = $images.parents('.product'),
				$thumbnails = $product.find('.product-thumbnails');
			if($images.hasClass('has-thumbnails')) {
				$images.not('.slick-initialized').slick();
				$thumbnails
				 	.on('init', function(event, slick) {
				 		$(this).find('.slick-slide.slick-current').addClass('is-active');
				 	})
				 	.not('.slick-initialized').slick();
				$images.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
				 	$thumbnails.slick('slickGoTo', nextSlide);
				 	var currrentNavSlideElem = $thumbnails.find('.slick-slide[data-slick-index="' + nextSlide + '"]');
				 	$thumbnails.find('.slick-slide').removeClass('is-active');
				 	currrentNavSlideElem.addClass('is-active');
				});	
				$thumbnails.on('click', '.slick-slide', function(event) {
				 	event.preventDefault();
				 	var goToSingleSlide = $(this).data('slick-index');
				 	$images.slick('slickGoTo', goToSingleSlide);
				 });
			}else{
			 	$images.not('.slick-initialized').slick();
			}
		},
		wooProductVideo: function(){
	        $('.product-page-video').magnificPopup({
	          type: 'iframe',
	          mainClass: 'mfp-fade',
	          removalDelay: 160,
	          preloader: false,
	          fixedContentPos: false
	        });
		},
		wooProductContentFixed: function(){
			if($('.is-fixed').length > 0) {
				var fixed_height = $('.is-fixed').outerHeight(false),
					fixed_width = $('.is-fixed').outerWidth();
					console.log(fixed_height); //NeedToCheck : Different height because price and countdown load after
				$(window).scroll(function(){
					var static_height = $('.woocommerce-product-gallery__wrapper').outerHeight(),
						fixed_top_offset = $('.is-fixed').parent().offset().top,
						absolute_height = static_height + fixed_top_offset - fixed_height;
					if($(this).scrollTop() > fixed_top_offset && $(this).scrollTop() < absolute_height) {
						$('.is-fixed').css({'position': 'fixed', 'top': 50, 'width': fixed_width});
					}else if($(this).scrollTop() > absolute_height) {
						$('.is-fixed').css({'position': 'absolute', 'top': 'auto' , 'bottom' : 0});
					}else {
						$('.is-fixed').css('position', 'static');
					}
				})
			}
		},
		/**
		 * Init PhotoSwipe.
		 */
		wooInitPhotoswipe: function(e) {
			var $target = $('.product-images');
			var pswpElement = $( '.pswp' )[0],
				items       = getGalleryItems(),
				clicked;
			$('.zoomImg').unbind('click').on( 'click', function(e) {
				e.preventDefault();
				clicked = $(this).parent();
				var options = $.extend( {
					index: clicked.data('index'),
				}, wc_single_product_params.photoswipe_options );
				var photoswipe = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
				photoswipe.init();
			});
			function getGalleryItems() {
				var $slides = $('.product-images .product-image-item'),
					items   = [];
				if ( $slides.length > 0 ) {
					$slides.each( function( i, el ) {
						var img = $( el ).find( 'img' );
						if ( img.length ) {
							var large_image_src = img.attr( 'data-large_image' ),
								large_image_w   = img.attr( 'data-large_image_width' ),
								large_image_h   = img.attr( 'data-large_image_height' ),
								item            = {
									src  : large_image_src,
									w    : large_image_w,
									h    : large_image_h,
									title: img.attr( 'data-caption' ) ? img.attr( 'data-caption' ) : img.attr( 'title' )
								};
							items.push( item );
						}
					} );
				}
				return items;
			};
		},
		wooProductQuantity: function(){
			$('body').on( 'click', '.plus ,.minus', function() {
	            // Get current quantity values
	            var qty = $( this ).closest('.quantity').find( '.qty' );
	            var val   = parseFloat(qty.val());
	            var max = parseFloat(qty.attr( 'max' ));
	            var min = parseFloat(qty.attr( 'min' ));
	            var step = parseFloat(qty.attr( 'step' ));
	            if( !val || val === '' || val === 'NaN' ) val = 0;
	            // Change the value if plus or minus
	            if ( $( this ).is( '.plus' ) ) {
	               if ( max && ( max <= val ) ) {
	                  qty.val( max );
	               } else {
	                  qty.val( val + step ).change();
	               }
	            } else {
	               if ( min && ( min >= val ) ) {
	                  qty.val( min );
	               } else if ( val > 1 ) {
	                  qty.val( val - step ).change();
	               }
	            } 
	        }); 
		},
		wooAddToCart: function(){
			const $body = $('body');
			$body.bind('added_to_cart', function(event, fragments, cart_hash) {
	            addToCartAction();
	        });
	        $body.on('submit', 'form.cart', function(e) {
	        	var $form = $(this),
	        		$button = $form.children('button');
	        	if( $button.val() == '' ) return;
	        	e.preventDefault();
	        	productPageAddToCart($form)
	        });
			function productPageAddToCart($form) {
	            var $button = $form.find('button.single_add_to_cart_button'),
	                data = $form.serialize();
	            data += '&action=amino_ajax_add_to_cart';
	            if( $button.val() ) {
	                data += '&add-to-cart=' + $button.val();
	            }
	            $button.removeClass( 'added' );
	            $button.addClass( 'loading' );
	            // Trigger event
	            $( document.body ).trigger( 'adding_to_cart', [ $button, data ] );
	            $.ajax({
	                url: aminoVars.ajax_url,
	                data: data,
	                method: 'POST',
	                success: function(response) {
	                    if ( ! response ) {
	                        return;
	                    }
	                    // // Redirect to cart option
	                    if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
	                        window.location = wc_add_to_cart_params.cart_url;
	                        return;
	                    } else {
	                        $button.removeClass( 'loading' );
	                        $button.addClass( 'loaded' );
	                        addToCartAction();
	                        var fragments = response.fragments;
	                        var cart_hash = response.cart_hash;
	                        // Replace value
	                        if ( fragments ) {
	                            $.each( fragments, function( key, value ) {
	                                $( key ).replaceWith( value );
	                            });
	                        }
	                    }
	                },
	                error: function() {
	                    console.log('ajax adding to cart error');
	                },
	                complete: function() {},
	            }); 
			};
			function addToCartAction(){
				$.magnificPopup.close();
				if(aminoVars.cartConfig == 'dropdown'){
					$('.minicart-dropdown').addClass('cart-active');
					setTimeout(function(){ 
						$('.minicart-dropdown').removeClass('cart-active');
					}, 3000);
				}else if(aminoVars.cartConfig == 'off-canvas') {
					$('.minicart-side #cart-side').addClass('cart-open');
					$('.amino-close-side').addClass('amino-close-side-open');
					$('body').addClass('has-side-open');
				}else {
					return;
				}
			}	
		},
		productVariationDefault: function(){
			$('.variations select').each(function(){
				var defaultAttr = $(this).val();
				var $swatches = $(this).prev().children();
				$swatches.each(function(){
					if($(this).data('value') == defaultAttr) {
						$(this).addClass('selected');
					}
				})
			})
		},
		variationSwatches: function() {
			function variationSwatchesForm() {
				return $('.variations_form').each( function() {
					var $form = $(this),
						$product = $(this).parents('.product'),
						clicked = null,
						isQuickView = false,
						selected = [];
					if($product.hasClass('product-quickview')) isQuickView = true;
					$form
						.addClass( 'swatches-support' )
						.on( 'click', '.swatch', function ( e ) {
							e.preventDefault();
							var $el = $( this ),
								$select = $el.closest( '.value' ).find( 'select' ),
								attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
								value = $el.data( 'value' );
							$select.trigger( 'focusin' );
							// Check if this combination is available
							if ( ! $select.find( 'option[value="' + value + '"]' ).length ) {
								$el.siblings( '.swatch' ).removeClass( 'selected' );
								$select.val( '' ).change();
								$form.trigger( 'amino_no_matching_variations', [$el] );
								return;
							}
							clicked = attribute_name;
							if ( selected.indexOf( attribute_name ) === -1 ) {
								selected.push(attribute_name);
							}
							if ( $el.hasClass( 'selected' ) ) {
								return false;
							} else {
								$el.addClass( 'selected' ).siblings( '.selected' ).removeClass( 'selected' );
								$select.val( value );
							}
							$select.change();
						})
						.on('reset_data', function(){
						})
						.on('reset_image', function() {
			                var $thumb = $( '.product-thumbnails .product-thumbnail-item img' ).first();
			                $thumb.wc_reset_variation_attr( 'src' );
			            })
						.on('show_variation', function(e, variation, purchasable){
							var $gallery_nav = $product.find( '.product-thumbnails' ),
								$images = $product.find( '.product-images' );
								$images.slick('unslick');
							$images.addClass('loading');
							$gallery_nav.addClass('loading');
							$gallery_nav.empty();
							var $gallery = variation.variation_gallery_images;
							if($gallery.length < 1) return false;
							for(var i=0; i < $gallery.length; i ++){
								var $html = '<div class="product-thumbnail-item"><img src="'+ $gallery[i].gallery_thumbnail_src  +'" width="' + $gallery[i].gallery_thumbnail_src_w + '" height="' + $gallery[i].gallery_thumbnail_src_h + '" class="attachment-woocommerce_thumbnail"/></div>';
								$gallery_nav.append($html)
							}
							$gallery_nav.removeClass('slick-initialized');
							$images.empty();
							for(var i=0; i < $gallery.length; i ++){
								var $html = '<div class="product-image-item" data-index="'+ i +'">';
								$html += '<a href="' + $gallery[i].full_src + '">';
								$html += '<img src="'+ $gallery[i].full_src  
										+'" width="'+ $gallery[i].full_src_w 
										+'" height="'+ $gallery[i].full_src_h 
										+'" srcset="' + $gallery[i].srcset 
										+ '" sizes="' + $gallery[i].sizes 
										+ '" data-large_image="' + $gallery[i].full_src
										+ '" data-large_image_width="' + $gallery[i].full_src_w
										+ '" data-large_image_height="' + $gallery[i].full_src_h
										+ '" data-caption="' + $gallery[i].title
										+ '" class="wp-post-image"/>';
								$html += '</a></div>';
								$images.append($html)
							}
							$images.removeClass('slick-initialized');
							if(isQuickView){
								amino.quickviewProductImage();
							}else{
								amino.wooInitPhotoswipe();
								amino.wooProductImage();
								amino.wooInitZoom();
							}
							var $firstImage = $images.find('.product-image-item').eq(0)
							$firstImage.imagesLoaded(function(){
								$images.removeClass('loading');
								$gallery_nav.removeClass('loading');
							})
							// Show variant countdown
							var currentTime = $.now(),
								endDateSale = variation.sale_time.to,
								startDateSale = variation.sale_time.from;
							if(typeof endDateSale === "undefined") endDateSale = 0;
							if(typeof startDateSale === "undefined") startDateSale = 0;
							if(startDateSale < currentTime && endDateSale > currentTime ) {
								amino.wooProductSingleCountdown(endDateSale);
							}else{
								if($('.amino-product-single-countdown .countdown-inner').length > 0) 
									$('.amino-product-single-countdown').countdown('remove');
								$('.amino-product-single-countdown').html('');
							}
							//amino.wooProductContentFixed(); // re-calculate height of fixed product summary content.
						})
						.on( 'click', '.reset_variations', function () {
							$( this ).closest( '.variations_form' ).find( '.swatch.selected' ).removeClass( 'selected' );
							replace_default_gallery($form);
							if(isQuickView){
								amino.quickviewProductImage();
							}else{
								amino.wooInitPhotoswipe();
								amino.wooProductImage();
								amino.wooInitZoom();
							}
							if($('.amino-product-single-countdown .countdown-inner').length > 0) 
									$('.amino-product-single-countdown').countdown('remove');
								$('.amino-product-single-countdown').html('');
							} )
						.on( 'amino_no_matching_variations', function() {
							window.alert( wc_add_to_cart_variation_params.i18n_no_matching_variations_text );
						} );
				});
			};
			function replace_default_gallery($form){
				var defaultGallery = $form.data('default_gallery'),
					$product = $form.closest('.product'),
					$images = $product.find('.product-images'),
					$thumbnails = $product.find('.product-thumbnails');
				$images.empty();
				$images.removeClass('slick-initialized');
				var html ='';
				if($images.hasClass('has-video')){
					var $videoPosition = $images.data('video-position');
					var videoIndex = 0;
					if($videoPosition == 'second') videoIndex = 1;
					if($videoPosition == 'last') videoIndex = defaultGallery.length - 1;
					for(var i=0; i<defaultGallery.length; i++){
						if(i != videoIndex) {
							html = '<div class="product-image-item" data-index="'+ i +'">';
							html += '<a href="'+ defaultGallery[i].image_detail.full_src +'">';
							html += '<img src="'+ defaultGallery[i].image_detail.full_src +'" data-large_image="'+ defaultGallery[i].image_detail.full_src +'" data-large_image_width="'+ defaultGallery[i].image_detail.full_w +'" data-large_image_height="'+ defaultGallery[i].image_detail.full_h +'" class="wp-post-image"/>';
							html += '</a>';
							html += '</div>';
						}else{
							html = '<div class="product-video-item">';
							html += '<video controls="" autoplay="" muted="">';
							html += '<source src="'+ defaultGallery[i].video_src +'" type="video/mp4"/>';
							html += '</video>';
							html += '</div>';
						}
						$images.append(html);
					}
					$thumbnails.empty();
					$thumbnails.removeClass('slick-initialized');
					var html ='';
					for(var i=0; i<defaultGallery.length; i++){
						html = '<div class="product-thumbnail-item">';
						if(i == videoIndex) {
							html += defaultGallery[i].thumb_src;
						}else{
							html += '<img src="'+ defaultGallery[i].thumb_detail.thumb_src +'" width="'+ defaultGallery[i].thumb_detail.thumb_w +'" height="'+ defaultGallery[i].thumb_detail.thumb_h +'" class="attachment-woocommerce_thumbnail"/>';
						}
						html += '</div>';
						$thumbnails.append(html);
					}
				}else{
					for(var i=0; i<defaultGallery.length; i++){
						html = '<div class="product-image-item" data-index="'+ i +'">';
						html += '<a href="'+ defaultGallery[i].image_detail.full_src +'">';
						html += '<img src="'+ defaultGallery[i].image_detail.full_src +'" data-large_image="'+ defaultGallery[i].image_detail.full_src +'" data-large_image_width="'+ defaultGallery[i].image_detail.full_w +'" data-large_image_height="'+ defaultGallery[i].image_detail.full_h +'" class="wp-post-image"/>';
						html += '</a>';
						html += '</div>';
						$images.append(html);
					}
					$thumbnails.empty();
					$thumbnails.removeClass('slick-initialized');
					var html ='';
					for(var i=0; i<defaultGallery.length; i++){
						html = '<div class="product-thumbnail-item">';
						html += '<img src="'+ defaultGallery[i].thumb_detail.thumb_src +'" width="'+ defaultGallery[i].thumb_detail.thumb_w +'" height="'+ defaultGallery[i].thumb_detail.thumb_h +'" class="attachment-woocommerce_thumbnail"/>';
						html += '</div>';
						$thumbnails.append(html);
					}
				}
			};
			variationSwatchesForm();
		},
		shopVariantSwatches : function(){
			var shopSwatches = $('.shop-swatches'),
				shopSwatchesAction = shopSwatches.data('action-behavior'),
				product = shopSwatches.parents('.product-grid').children('.product-image');
			if(shopSwatchesAction == 'click'){
				$('.shop-swatches .swatch').on('click', function(e){
					$(this).parents('.product-grid').children('.product-image').addClass('loading');
					$('.shop-swatches .swatch').removeClass('selected');
					$(this).addClass('selected');
			    	var first_image = $(this).data('first-image'),
			    		second_image = $(this).data('second-image'),
			    		first_img_target = $(this).parents('.product-grid').find('img.wp-post-image'),
			    		second_img_target = $(this).parents('.product-grid').find('img.product_thumbnail_hover');
			    	first_img_target.attr('src', first_image).attr('srcset', '');	
			    	if(second_img_target.length > 0) second_img_target.attr('src', second_image).attr('srcset', '');
			    	first_img_target.imagesLoaded(function(){
				    	product.removeClass('loading');
			    	});
			    })
			}else{
				$('.shop-swatches .swatch').on('mouseover', function(e){
					product.addClass('loading');
					$('.shop-swatches .swatch').removeClass('selected');
					$(this).addClass('selected');
			    	var first_image = $(this).data('first-image'),
			    		second_image = $(this).data('second-image'),
			    		first_img_target = $(this).parents('.product-grid').find('img.wp-post-image'),
			    		second_img_target = $(this).parents('.product-grid').find('img.product_thumbnail_hover');
			    	first_img_target.attr('src', first_image).attr('srcset', '');
			    	second_img_target.attr('src', second_image).attr('srcset', '');
			    	first_img_target.imagesLoaded(function(){
				    	product.removeClass('loading');
			    	});
			    })
			}
		},
		rtTabProductAjax: function(){	
			$('.rt-tab-products.rt-ajax-tabs').each(function() {
				var cache = [];	
				if( $(this).find('.rt-tab-panel').length = 1 ) {
					var first_tab_id = $(this).find('.rt-ajax-tab').eq(0).data('id');
	                cache[first_tab_id] = $(this).find('.rt-tab-panel').html()
	            }
	            var height = $(this).find('.rt-tab-panel').eq(0).height();
				$(this).find('.rt-ajax-tab').on( 'click' , function(e){
					e.preventDefault();
	                var $this = $(this),
	                    atts = $this.data('atts'),
	                    id_tab = $this.data('id'),
						nonce = $this.data('nonce'),
	                    tabs = $(this).parents('.rt-tab-products');
	                tabs.find('.rt-tabs li').removeClass('active');
	                tabs.find('.rt-tab-panel').removeClass('opened');
	                $(this).parent().addClass('active');
	                loadTab(atts , $this, id_tab, tabs , cache, height, nonce, function(data) {
	                    if( data ) {
	                        tabs.append(data);
	                        amino.initSlickSlider();
	                        amino.shopVariantSwatches();
							amino.countDownBlock();
	                    }
	                });
				})
			})
			function loadTab(atts, $this, id_tab, tabs, cache , height, nonce, callback){
				if( cache[id_tab] ) {
					tabs.find('.rt-tab-panel').removeClass('opened');
					$('#rt-tab-content-'+ id_tab).addClass('opened');
	                return;
	            } else {
	                tabs.append('<div class="tab-loading" style="height:'+ height +'px"></div>');
	            };
				$.ajax({
	                url: aminoVars.ajax_url,
	                data: {
	                    'action': 'amino_ajax_tab_content',
						'attr' : atts,
						'id_tab' : id_tab,
						'ajaxtab_nonce' : nonce,
	                },
	                dataType: 'json',
	                method: 'POST',
	                success: function(data) {
	                	cache[id_tab] = data;
                    	callback(data);
	                },
	                error: function(data) {
	                    console.log('Ajax error');
	                },
	                complete: function() {
	                    tabs.find('.tab-loading').remove();
	                },
	            });
			}
		},
		shopAjaxActions : function(){
			var aminoTheme = {
				ajaxLinks: 'a.reset-filters, .amino_layered_nav a, .widget_rating_filter a, .actived_filters a, .widget_layered_nav a, .order-by-filter a, .widget_ranged_price_filter li a',
			};
			//Helper function to get content by url
			function get_woocommerce_content(currentUrl) {
				$('body').append('<div class="amino-overlay"><div class="overlay__inner"><div class="overlay__content"><span class="spinner"></span></div></div></div>');
				if (currentUrl) {
					// Make sure the URL has a trailing-slash before query args (fix 301 redirect)
					currentUrl = currentUrl.replace(/\/?(\?|#|$)/, '/$1');
					window.history.pushState({ 'url': currentUrl, 'title': '' }, '', currentUrl);
					$.ajax({
						url: currentUrl,
						dataType: 'html',
						cache: false,
						headers: { 'cache-control': 'no-cache' },
						method: 'POST',
						success: function (response) {
							$('html, body').animate({
								scrollTop : 400 // NeedToCheck
							}, 500);
							// Update shop content
							$( '#secondary' ).html($(response).find('#secondary').html()); //NeedToCheck
							$( '#shop-filters' ).html($(response).find('#shop-filters').html()); //NeedToCheck
							$( '.woo-active-filters' ).html($(response).find('.woo-active-filters').html()); //NeedToCheck
							$( '.archive-products-wrapper' ).html($(response).find('.archive-products-wrapper').html());
							$( '.product-layout.products' ).html($(response).find('.product-layout.products').html());
							$( '.woocommerce-result-count' ).html($(response).find('.woocommerce-result-count').html());
							$( '.page-heading' ).html($(response).find('.page-heading').html());
							if($( '#shop-filters .price_slider' ).length > 0){
								init_price_filter();
							}
							if($(response).find('.woocommerce-pagination').length > 0) {
								$( '.woocommerce-pagination' ).html($(response).find('.woocommerce-pagination').html());
							} else {
								$( '.woocommerce-pagination' ).empty();
							}
							if($(response).find('.amino-ajax-loadmore').length > 0) {
								$( '.amino-ajax-loadmore' ).html($(response).find('.amino-ajax-loadmore').html());
							} else {
								$( '.amino-ajax-loadmore' ).empty();
							}
							amino.shopVariantSwatches();
						},
						complete: function () {
							$('.amino-overlay').remove();
							if($('.woo-active-filters .actived_filters').is(':empty')) {
								$('.woo-active-filters').addClass('hide');
							}else{
								$('.woo-active-filters').removeClass('hide');
							}
							$('.filter-side').removeClass('filter-open');
							$('body').removeClass('has-side-open');
							$('.amino-close-side').removeClass('amino-close-side-open');
						}
					});
				}
			};
			function init_price_filter() {
				$( 'input#min_price, input#max_price' ).hide();
				$( '.price_slider, .price_label' ).show();
				var min_price         = $( '.price_slider_amount #min_price' ).data( 'min' ),
					max_price         = $( '.price_slider_amount #max_price' ).data( 'max' ),
					step              = $( '.price_slider_amount' ).data( 'step' ) || 1,
					current_min_price = $( '.price_slider_amount #min_price' ).val(),
					current_max_price = $( '.price_slider_amount #max_price' ).val();
				$( '.price_slider:not(.ui-slider)' ).slider({
					range: true,
					animate: true,
					min: min_price,
					max: max_price,
					step: step,
					values: [ current_min_price, current_max_price ],
					create: function() {
						$( '.price_slider_amount #min_price' ).val( current_min_price );
						$( '.price_slider_amount #max_price' ).val( current_max_price );
						$( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
					},
					slide: function( event, ui ) {
						$( 'input#min_price' ).val( ui.values[0] );
						$( 'input#max_price' ).val( ui.values[1] );
						$( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
					},
					change: function( event, ui ) {
						$( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
					}
				});
			}
			//Woocommerce categories
			$(document).on('click', aminoTheme.ajaxLinks, function (e) {
				// This will prevent event triggering more then once
				if (e.handled !== true) {
					e.handled = true;
					e.preventDefault();
					$(this).closest('ul').find('.current').removeClass('current');
					$(this).closest('li').addClass('current');
					get_woocommerce_content($(this).attr('href'));
				}
			});
			// Click on pagination buttons
			$(document).on('click', '.woocommerce-pagination a', function (e) {
				// This will prevent event triggering more then once
				if (e.handled !== true) {
					e.handled = true;
					e.preventDefault();
					$(this).closest('ul').find('.current').removeClass('current');
					$(this).closest('li').addClass('current');
					get_woocommerce_content($(this).attr('href'));
				}
			});
			//Click on grid/list button
			$(document).on('click', '.shop-views button', function(){
				var href = window.location.href;
				amino.eraseCookie('shop-display');
				amino.setCookie('shop-display',$(this).data('display'),'1'); //(key,value,expiry in days)
				get_woocommerce_content(href);
			})
			// Price filter
			$(document).on('click', '.price_slider_amount .button', function (e) {
				if (e.handled !== true) {
					e.handled = true;
					e.preventDefault();
					var min_price = $('.price_slider_amount #min_price').val();
					var max_price = $('.price_slider_amount #max_price').val();
					var l = window.location;
					console.log(l);
					var shop_uri = l.origin + l.pathname;
					var href = l.href;
					if(href.indexOf('min_price') != -1 || href.indexOf('max_price') != -1){
					    href = href.replace(/(?:min_price=)([0-9]+)/, 'min_price=' + min_price);
					    href = href.replace(/(?:max_price=)([0-9]+)/, 'max_price=' + max_price);
					}
					else{
						var concat = shop_uri == href  ? '?' : '&';
						href = href.replace(/page\/([0-9]+)\//, '');
						href = href + concat + $.param(
								{
									min_price: min_price,
									max_price: max_price
								}
							);
					}
					get_woocommerce_content(href);
				}
			});
			$('.shop-views .shop-display').each(function(){
				$(this).on('click', function(e){
					e.preventDefault();
					if($(this).hasClass('grid-icon')) {
						$('.shop-views').find('#shop-display-grid').addClass('active');
						$('.shop-views').find('#shop-display-list').removeClass('active');
						$('.archive-products.products').removeClass('list-view');
						$('.archive-products.products').addClass('grid-view');
					}else{
						$('.shop-views').find('#shop-display-list').addClass('active');
						$('.shop-views').find('#shop-display-grid').removeClass('active');
						$('.archive-products.products').removeClass('grid-view');
						$('.archive-products.products').addClass('list-view');
					}
				});
			});
			$('body').on('click', 'a.block-expand', function(){
				var target = $(this).parents('.expand-content');
				if(target.hasClass('expanded-content')) {
					target.removeClass('expanded-content');
				}else{
					target.addClass('expanded-content');
				}
			})
		}
	};
	$(document).ready(function(){
		amino.aminoChecker();
		amino.init();
		function getCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}
		var cookiePromo = getCookie('promo-block');
		$('.home-page-02 .main-content').append($('#footer'));
	});
	function rtSlideshowFull() {
		$('.preloader-slideshow').hide();
		var imgDefer = $('.slideshow-item img');
		for (var i=0; i<imgDefer.length; i++) {
			var img = imgDefer[i],
				imgSrc = $(img).data('src');
			if(imgSrc) {
				$(imgDefer[i]).attr('src', imgSrc);
			}
		} 
	}
	$(window).load(function() {
		rtSlideshowFull();
	});
	$(window).on('load', function() {
		amino.preloader();
	});
	$(window).resize(function(){
		amino.rtMegamenu();
		amino.wooProductContentFixed();
		if(this.isProductPage){
		    amino.wooInitZoom();
		}
	})
	$(window).on('elementor/frontend/init', function() {
		if (elementorFrontend.isEditMode()) {
			elementorFrontend.hooks.addAction('frontend/element_ready/widget', function() {
				amino.initSlickSlider();
				amino.countDownBlock();
				aminoHelper.tabPanel();
				rtSlideshowFull();
			});
		}
	});
})( jQuery );