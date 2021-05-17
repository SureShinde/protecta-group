require([
	'jquery',
	'digital/homebanner',
	'digital/homebannerscroll',
	'digital/homebannermousewheel',
	'digital/unveil',
], function ($) {    /**** Main Function START ****/

	jQuery(document).ready(function () {  /**** Document Ready START ****/

		/**** Product Tab FAQ Accordian Start ****/
		jQuery('#que ul li:first-child').addClass('active');
		jQuery('#que ul li:first-child').find('.ans').show();
		jQuery('#que ul li h3').click(function () {
			var closest_li = jQuery(this).closest('li');
			closest_li.siblings('li').removeClass('active');
			closest_li.siblings('li').find('.ans').slideUp();
			closest_li.toggleClass('active');
			closest_li.find('.ans').slideToggle()
		});
		/**** Product Tab FAQ Accordian END ****/


		/* Resize */
		window.addEventListener('orientationchange', function () {
			document.location.reload();
		});
		/* Lazy Load */
		if (jQuery("img.lazy").length > 0) {
			jQuery("img.lazy").unveil(10);
		}
		/* Lazy Load  END */

		addStickyClass();
		footer_always_bottom();
		scrollToTop();

		/**** Location popup Start*******/

		jQuery('#top_warehouse_popup_link').click(function (e) {
			jQuery('#top_warehouse_popup_content').addClass('active');
			jQuery('html').addClass('show_location_popup');
		});

		jQuery('.close-warehouse-popup').click(function (e) {
			jQuery('#top_warehouse_popup_content').removeClass('active');
			jQuery('html').removeClass('show_location_popup');
		});

		/**** Location popup END*******/

		/* Hide page message */
		jQuery(document).ajaxComplete(function (event, xhr, settings) {

			if (settings.url.indexOf("/customer/section/load/?sections=cart") !== -1) {
				setTimeout(function () {
					jQuery(".page.messages div[data-bind='html: message.text']").each(function () {
						jQuery(this).parent().delay(6000).fadeOut('slow');
						jQuery(this).click(function () {
							jQuery(this).parent().hide();
						});
					});

				}, 1000);
			}

			if (settings.url.indexOf("/customer/section/load/?sections=messages") !== -1) {
				setTimeout(function () {
					jQuery(".page.messages div[data-bind='html: message.text']").each(function () {
						jQuery(this).parent().delay(6000).fadeOut('slow');
						jQuery(this).click(function () {
							jQuery(this).parent().hide();
						});
					});

				}, 1000);
			}

			if (settings.url.indexOf("/customer/section/load/?sections=wishlist") !== -1) {
				setTimeout(function () {
					jQuery(".page.messages div[data-bind='html: message.text']").each(function () {
						jQuery(this).parent().delay(6000).fadeOut('slow');
						jQuery(this).click(function () {
							jQuery(this).parent().hide();
						});
					});

				}, 1000);
			}
		});
		setTimeout(function () {
			if (jQuery(".page.messages div[data-bind='html: message.text']").length) {
				jQuery(".page.messages div[data-bind='html: message.text']").each(function () {
					jQuery(this).parent().delay(6000).fadeOut('slow');
					jQuery(this).click(function () {
						jQuery(this).parent().hide();
					});
				});
			} else {
				setTimeout(function () {
					if (jQuery(".page.messages div[data-bind='html: message.text']").length) {
						jQuery(".page.messages div[data-bind='html: message.text']").each(function () {
							jQuery(this).parent().delay(6000).fadeOut('slow');
							jQuery(this).click(function () {
								jQuery(this).parent().hide();
							});
						});
					}
				}, 1000);
			}
		}, 1000);
		/* Hide page message END */



		/**** Sidebar Quick Enquiry Start****/
		jQuery('.stickyform-btn').click(function () {
			jQuery('.sticky-form').toggleClass('active');
		});
		jQuery('.touch .stickyform-btn').click(function () {
			jQuery('html, body').animate({ scrollTop: 0 }, 800);
		});
		jQuery('.close-sticky-form').click(function () {
			jQuery('.sticky-form').removeClass('active');
		});

		if (jQuery(window).width() < 1024) {
			jQuery(".left-side-shopbycat-menu").click(function (e) {
				jQuery('.left-side-shopbycat-menu').toggleClass('active');
				jQuery(".cat_left_side_content").toggleClass('active');
				jQuery(".cat_left_side_content").toggle('slow');

			});
		}

		jQuery(document).click(function (e) {
			if (jQuery(e.target).closest('#sliderslider').size() == 0) {
				jQuery('#sliderslider').removeClass('active');
			}
		});
		/**** Sidebar Quick Enquiry END****/

		jQuery("#prod_specification_link").click(function () {
			jQuery("#tab-label-description").focus();
			jQuery("#tab-label-description").trigger('click');
			var offset = jQuery("#tab-label-description").offset().top - 170;
			jQuery('html,body').animate({ scrollTop: offset }, 'slow');
		});

		jQuery("#prod_resources_link").click(function () {
			jQuery("#tab-label-resourcestab").focus();
			jQuery("#tab-label-resourcestab").trigger('click');
			var offset = jQuery("#tab-label-resourcestab").offset().top - 170;
			jQuery('html,body').animate({ scrollTop: offset }, 'slow');
		});

		/**** Contact Form Tab Start****/
		jQuery(".contact-tab .tab_title li").click(function () {
			jQuery(".contact-tab .tab_title li").removeClass('active');
			jQuery(".contact-tab .tab_content .contact_info").removeClass('active');

			var selected_tab_id = jQuery(this).attr('data-content-class');
			jQuery(this).addClass('active');
			jQuery(".contact-tab .tab_content #" + selected_tab_id).addClass('active');
		});

		/**** Contact Form Tab END****/


		jQuery(".login-toggle").click(function () {
			if (jQuery(".login-toggle-box").hasClass('active')) {
				jQuery(".login-toggle-box").removeClass('active');
			}
			else {
				jQuery(".login-toggle-box").addClass('active');
			}
			jQuery(".login-toggle-box").toggle('slow');
		});

		jQuery('#login-popup').hover(
			function () {
				jQuery("#login-popup-modal-fly").addClass('active');
			},
			function () {
				jQuery("#login-popup-modal-fly").removeClass('active');
			});

		jQuery('.about_menu_sub_click').hover(
			function () {
				jQuery(".about-toggle-box").addClass('active');
			},
			function () {
				jQuery(".about-toggle-box").removeClass('active');
			});


		jQuery('.resources_menu_sub_click').hover(
			function () {
				jQuery(".resources-toggle-box").addClass('active');
			},
			function () {
				jQuery(".resources-toggle-box").removeClass('active');
			});

		if (jQuery(window).width() < 568) {
			if (!jQuery('.block-search .block-content').hasClass('show_search')) {
				jQuery(".block-search .block-title").click(function (e) {
					jQuery(".block-search .block-content").toggle('slow');
					jQuery('.block-search .block-content').addClass('show_search');
				});
			}
		}


		/**** Add Body Class ****/
		var isTouchDevice = 'ontouchstart' in document.documentElement;
		if (isTouchDevice) {
			jQuery('html').addClass('touch').removeClass('no-touch');
		} else {
			jQuery('html').addClass('no-touch').removeClass('touch');
		}
		/****/

		if (jQuery("html").hasClass('touch')) {
			jQuery('.about_menu_sub_click a').on('touchend click', function (e) {
				if (jQuery(this).hasClass('touched')) {
					jQuery(this).addClass('selected');
					jQuery(".about-toggle-box").removeClass('active');
				}
				else {
					jQuery(this).addClass('touched');
					if (!jQuery(".about-toggle-box").hasClass('active')) {
						jQuery(".resources-toggle-box").removeClass('active');
						jQuery(".about-toggle-box").addClass('active');
						e.stopPropagation();
						return false;
					}
				}
			});



			jQuery('.resources_menu_sub_click a').on('touchend click', function (e) {
				if (jQuery(this).hasClass('touched')) {
					jQuery(this).addClass('selected');
					jQuery(".resources-toggle-box").removeClass('active');
				}
				else {
					jQuery(this).addClass('touched');
					if (!jQuery(".resources-toggle-box").hasClass('active')) {
						jQuery(".about-toggle-box").removeClass('active');
						jQuery(".resources-toggle-box").addClass('active');
						e.stopPropagation();
						return false;
					}
				}
			});


		}

		if (jQuery("html").hasClass('touch')) {
			jQuery('.main-top-category ul > li.parent').each(function () {
				jQuery(this).on('touchend click', function () {
					jQuery(this).siblings('li').removeClass('touched selected');
					jQuery('html').removeClass('no-scroll');
					if (jQuery(this).hasClass('touched')) {
						jQuery(this).addClass('selected');
						jQuery('html').addClass('no-scroll');
					} else {
						jQuery(this).addClass('touched');
						jQuery('html').addClass('no-scroll');
					}
				});

			});
		}


		if (jQuery('html').hasClass('no-touch')) {
			jQuery(document).click(function (e) {
				reset_element(e);
			});
		} else {
			jQuery(document).on('touchend', function (e) {
				reset_element(e);
			});
		}




		jQuery(".showcart").click(function (e) {
			reset_element(e);
			jQuery("html").addClass("show_mini_cart");
			jQuery("#btn-minicart-close").click(function (e) {
				jQuery("html").removeClass("show_mini_cart");
			});
		});












		/**** Mega Menu js ****/
		if (jQuery(window).width() >= 768) {
			jQuery('li.submenu-cols.level1.parent').each(function () {
				jQuery(this).hover(
					function () {
						jQuery('li.submenu-cols.level1.first-menu').removeClass('active-menu');
						jQuery(this).addClass('active-menu');

					},
					function () {
						jQuery(this).removeClass('active-menu');
						jQuery('li.submenu-cols.level1.first-menu').addClass('active-menu');
					});
			});

			jQuery('.no-touch .products-menu').hover(
				function () {
					jQuery('html').addClass('no-scroll');
				},
				function () {
					jQuery('html').removeClass('no-scroll');
				});




		}
		/** Mega Menu js End **/

		/**** Footer Accordion Start*****/
		if (jQuery(window).width() <= 767) {
			jQuery('.page-footer .footer-links-outer .quick-linkswrapper .footer-accordian-title').click(function () {
				var closest_ele = jQuery(this);
				var closest_parent = jQuery(this).closest('.links.footer-col1');
				closest_parent.siblings().find('.footer-accordian-title').removeClass('active');
				closest_ele.toggleClass('active');
				closest_parent.siblings().find('.footer-accordian-content').slideUp();
				closest_ele.parent().find('.footer-accordian-content').slideToggle();
			});
		}
		/**** Footer Accordion END*****/














		/* Active Class Js start*/
		jQuery(function () {
			var url = window.location.href,
				urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");

			/* Header Top Right Active Class start */
			jQuery('.top-right-links li a').each(function () {
				if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
					jQuery(this).parents('li').addClass('active');
				}
			});
			/* Header Top Right Active Class end */

			/* Header Menu Active Class start */
			jQuery('.navigation li a').each(function () {
				if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
					jQuery(this).parents('li').addClass('active');
				}
			});
			/* Header Menu Active Class end */

			/* Footer links Active Class start */
			jQuery('.footer-accordian-content li a').each(function () {
				if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
					jQuery(this).parent('li').addClass('active');
				}
			});
			/* Footer links Active Class end */
		});
		/* Active Class Js End*/
		/*if(jQuery(window).width() < 768)
		{
			jQuery('#top_info_box').addClass('owl-header_info_block owl-carousel');
			jQuery(".owl-header_info_block").owlCarousel({
				navigation: true,
				pagination: false,
				autoplay:true,
				items:1,
				smartSpeed:1400,
				lazyLoad:true,
				autoplayHoverPause:!0,
				autoplayTimeout:4000,
				transitionStyle : "fade",
				animateIn: 'fadeIn',
				animateOut: 'fadeOut',
				loop:true,
				nav:false,
				dots:false,
				margin:0,
				responsiveClass:!0,
				responsive:
				{
					767:{items:1,dots:false,navigation: false},
					1e3:{items:1,dots:false,navigation: false}
				}
			});
		}*/

		if (jQuery(".owl-dcs-product-list").length > 0) {

			jQuery(".owl-dcs-product-list").owlCarousel({
				nav: true,
				navigation: true,
				dots: false,
				margin: 25,
				responsiveClass: true,
				smartSpeed: 1500,
				lazyLoad: true,
				responsive: {
					0: {
						items: 1,
					},
					479: {
						items: 2,
					},
					640: {
						items: 2,
					},
					693: {
						items: 3,
					},
					1000: {
						items: 4,
					}
				}
			});
		}

		if (jQuery(".related-product-carousel").size() > 0) {
			jQuery(".related-product-carousel").owlCarousel({
				nav: true,
				navigation: true,
				dots: false,
				margin: 25,
				responsiveClass: true,
				smartSpeed: 1500,
				lazyLoad: true,
				responsive: {
					0: {
						items: 1,
					},
					479: {
						items: 2,
					},
					640: {
						items: 2,
					},
					693: {
						items: 3,
					},
					1000: {
						items: 4,
					}
				}
			});
		}

		if (jQuery(window).width() < 768) {
			jQuery(".home-categories-sec").owlCarousel({
				nav: true,
				navigation: false,
				dots: true,
				margin: 15,
				responsiveClass: true,
				smartSpeed: 1500,
				lazyLoad: true,
				responsive: {
					0: {
						items: 1,
					},
					360: {
						items: 2,
					},
					640: {
						items: 3,
					},
					767: {
						items: 3,
					}
				}
			});

			jQuery(".home-news-inner .post-list-body").owlCarousel({
				nav: true,
				navigation: false,
				dots: true,
				margin: 25,
				responsiveClass: true,
				smartSpeed: 1500,
				lazyLoad: true,
				responsive: {
					0: {
						items: 1,
					},
					479: {
						items: 2,
					},
					640: {
						items: 2,
					},
					767: {
						items: 3,
					}
				}
			});

		}



		/* Menu Js Start */

		if (jQuery(window).width() > 991) {
			//jQuery('#simple_menu_prod').html();
			jQuery('#simple_menu_prod').wrap('<div class="simple-products-men">');
		}

		if (jQuery(window).width() > 991) {
			jQuery('.products-menu-first').wrap('<div class="simple-products-men">');

			/*jQuery('.submenu-outer').jScrollPane({autoReinitialise:1}); */

		}
		/* Menu Js END */
		var globalWidthVar, globalHeightVar;
		globalWidthVar = jQuery(window).width(), globalHeightVar = jQuery(window).height();
		if (globalWidthVar < 1025) {

			jQuery(".navigation.main-top-category > ul > li.level0.parent > a").after('<span class="level0-ico-corner"></span>');
			jQuery(".navigation.main-top-category > ul > li.level0.parent > ul > li.level1.parent > a").after('<span class="level1-ico-corner"></span>');
			jQuery(".navigation.main-top-category > ul > li.level0.parent > ul > li.level1.parent > .submenu_wrapper > ul > li.level2.parent > a").after('<span class="level2-ico-corner"></span>');


			jQuery.each(jQuery(".navigation.main-top-category > ul > li > span.level0-ico-corner"), function (index, value) {
				jQuery(this).bind('click touchend', function (e) {
					if (jQuery(this).parent("li").children("ul").length) {
						jQuery(this).parent("li").siblings().find(".level0.submenu").slideUp(500, "swing");
						jQuery(this).parent("li").siblings().find(".level1.submenu").slideUp(500, "swing");
						jQuery(this).parent("li").siblings().find(".level1-ico-corner").removeClass('ui-state-active');
						jQuery(this).parent("li").siblings().find(".level0-ico-corner").removeClass('ui-state-active');
						jQuery(this).parent("li").siblings().find(".level2-ico-corner").removeClass('ui-state-active');
						jQuery(this).parent("li").find(".level0.submenu").slideToggle("slow");
						jQuery(this).toggleClass("ui-state-active");

						jQuery(".navigation.main-top-category > ul > li").removeClass("opened_menu");
						jQuery('.ui-state-active').parent("li").addClass("opened_menu");

						e.stopPropagation();
						return false;
					}
				});
			});

			jQuery.each(jQuery(".navigation.main-top-category > ul > li >  ul > li > span.level1-ico-corner"), function (index, value) {
				jQuery(this).bind('click touchend', function (e) {
					//if (jQuery(this).parent("li").children("ul").length) {
					jQuery(this).parent("li").siblings().find(".level1.submenu").slideUp(500, "swing");
					jQuery(this).parent("li").siblings().find(".level1-ico-corner").removeClass('ui-state-active');
					jQuery(this).parent("li").find(".level1.submenu").slideToggle("slow");
					jQuery(this).toggleClass("ui-state-active");

					jQuery(".navigation.main-top-category > ul > li >  ul > li").removeClass("opened_menu");
					jQuery('.ui-state-active').parent("li").addClass("opened_menu");

					e.stopPropagation();
					return false;
					//}
				});
			});

			jQuery.each(jQuery(".navigation.main-top-category > ul > li >  ul > li .submenu_wrapper > ul > li > span.level2-ico-corner"), function (index, value) {
				jQuery(this).bind('click touchend', function (e) {
					//if (jQuery(this).parent("li").children("ul").length) {
					jQuery(this).parent("li").siblings().find(".level2.submenu").slideUp(500, "swing");
					jQuery(this).parent("li").siblings().find(".level2-ico-corner").removeClass('ui-state-active');
					jQuery(this).parent("li").find(".level3.submenu").slideToggle("slow");
					jQuery(this).toggleClass("ui-state-active");

					jQuery(".navigation.main-top-category > ul > li >  ul > li .submenu_wrapper > ul > li").removeClass("opened_menu");
					jQuery('.ui-state-active').parent("li").addClass("opened_menu");

					e.stopPropagation();
					return false;
					//}
				});
			});

			jQuery('.navigation li > a').click(function (e) {
				e.preventDefault();
				window.location.href = jQuery(this).attr('href');
				e.stopImmediatePropagation();
				return false;
			});

			jQuery('.menu-close-btn').click(function () {
				jQuery('html').removeClass("nav-before-open nav-open");
			});

			/* Left Sidebar Navigation	*/
			jQuery(".navigation.category-left-sidebar > ul > li.level0.parent > a").after('<span class="catleft-level0-ico-corner"></span>');

			jQuery.each(jQuery(".navigation.category-left-sidebar > ul > li.level0.parent span.catleft-level0-ico-corner"), function (index, value) {
				jQuery(this).bind('click touchend', function (e) {
					if (jQuery(this).parent("li").children("ul").length) {
						e.preventDefault();
						var $this = $(this);
						if ($this.next().hasClass('show')) {
							$this.removeClass("ui-state-active");
							$this.next().removeClass('show');
							$this.next().slideUp(500);
						} else {
							$this.parent("li").siblings().find("span.catleft-level0-ico-corner").removeClass('ui-state-active');
							$this.parent().siblings().children('ul').removeClass('show');
							$this.parent().siblings().children('ul').hide();

							$this.toggleClass("ui-state-active");
							$this.next().toggleClass('show');
							$this.next().slideToggle(500);
						}
					}
				});
			});


		}






	});  /**** Document Ready END ****/






	jQuery(window).resize(function () {
		addStickyClass();
		footer_always_bottom();
	});
	jQuery(window).scroll(function (event) {
		addStickyClass();
	});
	window.onload = function (e) {
		var globalWidthVar = jQuery(window).width(), globalHeightVar = jQuery(window).height();
		if (globalWidthVar >= 768 && globalWidthVar <= 1024) {
			window.addEventListener('orientationchange', function () {
				jQuery('html').removeClass("nav-before-open nav-open");
			});
		}
	}


}); /**** Main Function END ****/


/**** Back to top ****/
function scrollToTop() {
	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() > 100) {
			jQuery('.scrollToTop').fadeIn();
		} else {
			jQuery('.scrollToTop').fadeOut();
		}
	});
	if (jQuery(this).scrollTop() > 100) {
		jQuery('.scrollToTop').fadeIn();
	} else {
		jQuery('.scrollToTop').fadeOut();
	}

	jQuery('.scrollToTop').click(function () {
		jQuery('html, body').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
}
/****/

/**** Header Stiky Js *****/
function addStickyClass() {
	if (jQuery(window).width() > 0) {
		if (jQuery(this).scrollTop() > jQuery(".page-header .panel.wrapper").outerHeight()) {
			jQuery(".page-header,body").addClass('sticky');
		} else {
			jQuery(".page-header,body").removeClass('sticky');
		}
	} else if (jQuery(".page-header,body").hasClass('sticky')) {
		jQuery(".page-header,body").removeClass('sticky');

	}
}
/****/

/**** Footer Always Bottom ****/
function footer_always_bottom() {
	var globalWidthVar = jQuery(window).width();
	if (globalWidthVar > 768) {
		var variation = 0;
		var footer_height = parseInt(jQuery('.page-footer').height()) + parseInt(jQuery('.page-footer').css('padding-top')) + parseInt(jQuery('.page-footer').css('padding-bottom'));
		jQuery('.page-main').css('min-height', jQuery(window).height() - footer_height);
	} else {
		jQuery('.page-main').removeAttr('style');
	}
}

/**** Search and micart Close Js ******/
function reset_element(e) {

	if (jQuery(e.target).closest('.span-bulk-buy-price').size() == 0 && jQuery('.span-bulk-buy-price').hasClass('active-bulk-price')) {
		jQuery('.span-bulk-buy-price').removeClass('active-bulk-price');
		jQuery(".simple-tier-price-drop-down").hide('slow');
	}

	if (jQuery(e.target).closest('.selected').size() == 0 && jQuery('html').hasClass('no-scroll') && jQuery('.main-top-category ul > li.parent').hasClass('selected')) {
		jQuery('html').removeClass('no-scroll');
		jQuery('.main-top-category ul > li.parent').removeClass('selected');
		jQuery('.main-top-category ul > li.parent').removeClass('touched');
	}


	if (jQuery(e.target).closest('.block-minicart').size() == 0 && jQuery('html').hasClass('show_mini_cart')) {
		jQuery('html').removeClass('show_mini_cart');
	}

	if (jQuery(e.target).closest('.nav-sections').size() == 0 && jQuery('html').hasClass("nav-open")) {
		jQuery('html').removeClass("nav-open nav-before-open");
	}



	if (jQuery(e.target).closest('.header_search').size() == 0 && jQuery('.header_search').is(":visible") && jQuery(e.target).closest('.section-top-mini-search').size() == 0 && jQuery('.block-search .block-content').hasClass('show_search')) {
		jQuery(".block-search .block-title").trigger('click');
		jQuery('.block-search .block-content').removeClass('show_search');

	}

	if (jQuery(e.target).closest('.login-toggle').size() == 0 && jQuery(".login-toggle-box").hasClass('active')) {
		jQuery(".login-toggle-box").removeClass('active');
		jQuery(".login-toggle-box").toggle('slow');
	}

	if (jQuery(e.target).closest('.about_menu_sub_click').size() == 0 && jQuery(".about-toggle-box").hasClass('active')) {
		jQuery(".about-toggle-box").removeClass('active');
	}


	if (jQuery(e.target).closest('.resources_menu_sub_click').size() == 0 && jQuery(".resources-toggle-box").hasClass('active')) {
		jQuery(".resources-toggle-box").removeClass('active');
	}


}
/*****/



function qtyUpAndDown(element, action, configar) {
	var currentValue = jQuery(element).parent().find("input.qty").val();
	var newValue = 1;
	/*if (!jQuery.isNumeric(Number(Math.trunc(currentValue)))) {
		currentValue = 1;
	} else {
		currentValue = Number(Math.trunc(currentValue));
	}*/
	if (action == '+') {
		newValue = parseFloat(currentValue) + 1;
	}
	if (action == '-') {
		if (currentValue > 2) {
			newValue = parseFloat(currentValue) - 1;
		} /*else if (configar) {
	            newValue = 0;
	        }*/ else {
			newValue = 1;
		}
	}
	jQuery(element).parent().find("input.qty").val(newValue);
	jQuery(element).parent().find("input.qty").attr('value', newValue);
}
