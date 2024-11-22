(function ($) {
"use strict";

$.scrollUp({
	easingType: 'linear',
	scrollSpeed: 900,
	animation: 'fade',
	scrollText: '<i class="fa fa-chevron-up"></i>',
});

$('#bravery-container').mixItUp();
$.scrollUp({
	easingType: 'linear',
	scrollSpeed: 900,
	animation: 'fade',
	scrollText: '<i class="icofont icofont-simple-up"></i>',
});

  /*=================
	VENOBOX ACTIVE JS
	===================*/
		$('.venobox').venobox({
			framewidth: '700px',        // default: ''
			frameheight: '700px',       // default: ''
			border: '2px',             // default: '0'
			bgcolor: '#47d5ff',         // default: '#fff'
			titleattr: 'data-title',    // default: 'title'
			numeratio: true,            // default: false
			infinigall: true            // default: false
		});
	


/*--
	Mobile Menu
------------------------*/
$('.mobile-menu nav').meanmenu({
	meanScreenWidth: "990",
	meanMenuContainer: ".mobile-menu",
	onePage: true,
});




/*--
	One Page Nav
-----------------------------------*/
$('.navid').onePageNav({
    currentClass: 'current',
    changeHash: false,
    scrollSpeed: 1000,
    scrollThreshold: 0.5,
    filter: '',
    easing: 'swing',
});
	/*--
	Smooth Scroll
-----------------------------------*/
$('.menu ul li a').on('click', function(e) {
	e.preventDefault();
	var link = this;
	$.smoothScroll({
	  offset: -80,
	  scrollTarget: link.hash
	});
});	

	/*---------------------
	scrollUp
	--------------------- */
	$.scrollUp({
		scrollName: 'scrollUp',      // Element ID
		scrollDistance: 300,         // Distance from top/bottom before showing element (px)
		scrollFrom: 'top',           // 'top' or 'bottom'
		scrollSpeed: 1000,            // Speed back to top (ms)
		easingType: 'linear',       
		animation: 'fade',           // Fade, slide, none
		animationSpeed: 200,         // Animation speed (ms)
		scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
		zIndex: 2147483647           // Z-Index for the overlay
	});





})(jQuery);	
