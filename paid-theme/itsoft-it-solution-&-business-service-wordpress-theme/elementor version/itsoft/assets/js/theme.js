(function ($) {
	'use strict';

	// 6.EM MOBILE MENU
	$('.mobile-menu nav').meanmenu({
		meanScreenWidth: "990",
		meanMenuContainer: ".mobile-menu",
		onePage: true,
	});
	// top quearys menu 
	var emsmenu = $(".em-quearys-menu i.t-quearys");
	var emscmenu = $(".em-quearys-menu i.t-close");
	var emsinner = $(".em-quearys-inner");
	emsmenu.on('click', function () {
		emsinner.addClass('em-s-open').fadeToggle(1000);
		$(this).addClass('em-s-hidden');
		emscmenu.removeClass('em-s-hidden');
	});
	emscmenu.on('click', function () {
		emsinner.removeClass('em-s-open').fadeToggle(1000);
		$(this).addClass('em-s-hidden');
		emsmenu.removeClass('em-s-hidden');
	});
	
	// 6.HOME 2 HERO CAROUSEL
	$('.em-slick-slider-new').slick({
		dots: false,
		speed: 900,
		arrows: true,
		autoplay: true,
		fade: true,
		autoplaySpeed: 6000,
		responsive: [{
			breakpoint: 769,
			settings: {
				arrows: false,
			}
		}]
	});
	
	// 6.SERVICES CAROUSEL
	$('.service_cursousel_slider').slick({
		dots: true,
		speed: 900,
		arrows: false,
		autoplay: true,
		fade: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplaySpeed: 6000,
        responsive: [
            {
                breakpoint: 1920,
                settings: {
                    slidesToShow: 3,
                }
            },
			 {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 2,
                }
            },
			
			
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1
              }
            },
            {
              breakpoint: 600,
              settings: {
                arrows: false,
                slidesToShow: 1
              }
            }
        ]
	});
	// 6.SERVICES CAROUSEL
	$('.country_cursousel_slider ').slick({
		dots: true,
		speed: 900,
		arrows: false,
		autoplay: false,
		fade: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplaySpeed: 6000,
        responsive: [
            {
                breakpoint: 1920,
                settings: {
                    slidesToShow: 3,
                }
            },
			 {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                }
            },
			
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2
              }
            },
            {
              breakpoint: 600,
              settings: {
                arrows: false,
                slidesToShow: 1
              }
            }
        ]
	});
	
	//* Parallaxmouse js
	function parallaxMouse() {
		if ($('#parallax').length) {
			var scene = document.getElementById('parallax');
			var parallax = new Parallax(scene);
		};
	};	
	parallaxMouse();
	// 6.EM SLICK SLIDER
	$('.em-slick-testi-description').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		dots: true,
		fade: true,
		asNavFor: '.em-slick-testi-wraper'
	});
	$('.em-slick-testi-wraper').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.em-slick-testi-description',
		dots: false,
		arrows: false,
		centerMode: true,
		focusOnSelect: true
	});
	
	// 6.EM WOW ACTIVE JS
	new WOW().init();
	// 6.EM NIVO SLIDER
	$('#mainSlider').nivoSlider({
		directionNav: true,
		animSpeed: 1000,
		effect: 'random', 
		animSpeed: 500,
		slices: 18,
		autoplay: true,
		randomStart: true,
		pauseTime: 800000,
		pauseOnHover: true,
		controlNav: true,
		prevText: '<i class="fa fa-angle-left nivo-prev-icon"></i>',
		nextText: '<i class="fa fa-angle-right nivo-next-icon"></i>'
	});
	// 6.SCROLLUP JS
	$.scrollUp({
		scrollText: '<i class="fa fa-angle-up"></i>',
		easingType: 'linear',
		scrollSpeed: 900,
		animation: 'fade'
	});
	// VenuboX
	$('.venobox').venobox({
		numeratio: true,
		infinigall: true

	});
	// 6.ONEPAGE MENU
	var top_offset = $('.one_page').height() + 0;
	$('.one_page .itsoft_menu .nav_scroll').onePageNav({
		currentClass: 'current',
		changeHash: false,
		scrollSpeed: 1000,
		scrollOffset: top_offset,
		scrollThreshold: 0.5,
		filter: '',
		easing: 'swing',
	});

	$(".nav_scroll li:first-child").addClass("current");
	/* sticky nav 1 */
	$('.one_page').scrollToFixed({
		preFixed: function () {
			$(this).find('.scroll_fixed').addClass('prefix');
		},
		postFixed: function () {
			$(this).find('.scroll_fixed').addClass('postfix').removeClass('prefix');
		}
	});
	
	// 6.EM STIKY NAV
	var headers1 = $('.trp_nav_area');
	$(window).on('scroll', function () {

		if ($(window).scrollTop() > 100) {
			headers1.addClass('hbg2');
		} else {
			headers1.removeClass('hbg2');
		}

	});
	

	// 6.EM COUNTARUP 
	$('.countr_text h1').counterUp({
		delay: 10,
		time: 1000
	});
	// 6.EM PORTFOLIO
	$('.em_load').imagesLoaded(function () {

		if ($.fn.isotope) {

			var $portfolio = $('.em_load');

			$portfolio.isotope({

				itemSelector: '.grid-item',

				filter: '*',

				resizesContainer: true,

				layoutMode: 'masonry',

				transitionDuration: '0.8s'

			});
			$('.filter_menu li').on('click', function () {

				$('.filter_menu li').removeClass('current_menu_item');

				$(this).addClass('current_menu_item');

				var selector = $(this).attr('data-filter');

				$portfolio.isotope({

					filter: selector,

				});

			});

		};

	});
	// 6.EM BLOG MASONARY
	$('.bgimgload').imagesLoaded(function () {
		if ($.fn.isotope) {
			var $blogmassonary = $('.blog-messonary');
			$blogmassonary.isotope({
				itemSelector: '.grid-item',
				filter: '*',
				resizesContainer: true,
				layoutMode: 'masonry',
				transitionDuration: '0.8s'
			});

		};
	});
	// 6.EM TESTIMONIAL
	$('.testimonial_list').owlCarousel({
		loop: true,
		autoplay: false,
		autoplayTimeout: 10000,
		dots: true,
		nav: false,
		navText: ["<i class='flaticon-back-1'></i>", "<i class='flaticon-next'></i>"],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			992: {
				items: 1
			},
			1000: {
				items: 1
			},
			1920: {
				items: 1,
			}
		}
	})
	// 6.EM TESTIMONIAL
	$('.testimonial_list2').owlCarousel({
		loop: true,
		autoplay: false,
		autoplayTimeout: 10000,
		dots: true,
		nav: false,
		navText: ["<i class='flaticon-back-1'></i>", "<i class='flaticon-next'></i>"],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 2
			},
			992: {
				items: 3
			},
			1000: {
				items: 3
			},
			1920: {
				items: 3,
			}
		}
	})
	
	// 6.EM TESTIMONIAL
	$('.testimonial_list3').owlCarousel({
		loop: true,
		autoplay: false,
		autoplayTimeout: 10000,
		dots: true,
		nav: false,
		navText: ["<i class='flaticon-back-1'></i>", "<i class='flaticon-next'></i>"],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 2
			},
			992: {
				items: 2
			},
			1000: {
				items: 2
			},
			1920: {
				items: 2,
			}
		}
	})

	// 6.EM Case Study
	$('.case_study_carousel').owlCarousel({
        loop: true,
        margin: 0,
        center: true,
        dots: true,
        nav: false,
        autoplay: true,
		navText: ["<i class='flaticon-back''></i>", "<i class='flaticon-next-1''></i>"],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 2
			},
			992: {
				items: 3
			},
			1000: {
				items: 4
			},
			1500: {
				items: 5
			},
			1920: {
				items: 5
			}
		}
	})
	
	/* Blog Curousel */
	$('.blog_carousel').owlCarousel({
		dots: true,
		nav: true,
		autoplayTimeout: 10000,
		navText: ["<i class='flaticon-left-arrow-3'></i>", "<i class='flaticon-right-arrow-3''></i>"],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 2
			},
			992: {
				items: 3
			},
			1920: {
				items: 3
			}
		}
	})

	/* Brand Curousel */
	$('.brand_carousel').owlCarousel({
		loop: true,
		autoplay: true,
		autoplayTimeout: 4000,
		dots: false,
		nav: false,
		navText: ["<i class='fa fa-long-arrow-left'></i>", "<i class='fa fa-long-arrow-right''></i>"],
		responsive: {
			0: {
				items: 2
			},
			768: {
				items: 4
			},
			992: {
				items: 5
			},
			1920: {
				items: 5
			}
		}
	})
	
	$('.single_gallery').owlCarousel({
		nav: true,
		dots: false,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			992: {
				items: 1
			},
			1920: {
				items: 1
			}
		}
	})
	$('.portfolio_gallery_post').owlCarousel({
		nav: true,
		dots: false,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			992: {
				items: 1
			},
			1920: {
				items: 1
			}
		}
	})

})(jQuery);

