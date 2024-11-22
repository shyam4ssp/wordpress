jQuery( document ).ready( function( $ ) {
	"use strict";

	// Show/hide settings for post format when choose post format
	var $format = $( '#post-formats-select' ).find( 'input.post-format' ),
		$formatBox = $( '#post-format-settings' );

	$format.on( 'change', function() {
        var type = $(this).filter(':checked').val();
        postFormatSettings(type);
	} );
	$format.filter( ':checked' ).trigger( 'change' );

    $(document.body).on('change', '.editor-post-format .components-select-control__input', function () {
        var type = $(this).val();
        postFormatSettings(type);
    });

    $(window).load(function () {
        var $el = $(document.body).find('.editor-post-format .components-select-control__input'),
            type = $el.val();
        postFormatSettings(type);
    });

    function postFormatSettings(type) {
        $formatBox.hide();
        if ($formatBox.find('.rwmb-field').hasClass(type)) {
            $formatBox.show();
        }

        $formatBox.find('.rwmb-field').slideUp();
        $formatBox.find('.' + type).slideDown();
    }

	// Show/hide settings for custom layout settings
	$( '#custom_sidebar' ).on( 'change', function() {
		if( $( this ).is( ':checked' ) ) {
			$( '.rwmb-field.custom-layout' ).slideDown();
		}
		else {
			$( '.rwmb-field.custom-layout' ).slideUp();
		}
	} ).trigger( 'change' );

	$( '#portfolio-display-settings #page_header_layout' ).on( 'change', function() {
		if ($(this).val() == '2') {
			$( '#portfolio-display-settings').find('.show-page-header-2').slideDown();
			$( '#portfolio-display-settings').find('.show-page-header-1').slideUp();
		}
		else {
			$( '#portfolio-display-settings').find('.show-page-header-1').slideDown();
			$( '#portfolio-display-settings').find('.show-page-header-2').slideUp();
		}
	} ).trigger( 'change' );

	$( '#page-header-settings #page_header_layout' ).on( 'change', function() {
		if ($(this).val() == '2') {
			$( '#page-header-settings').find('.show-page-header-2').slideDown();
			$( '#page-header-settings').find('.show-page-header-1').slideUp();
		}
		else {
			$( '#page-header-settings').find('.show-page-header-1').slideDown();
			$( '#page-header-settings').find('.show-page-header-2').slideUp();
		}
	} ).trigger( 'change' );

	$('#variable_product_options').on('reload', function (event, data) {
		var postID = $('#post_ID').val();
		$.ajax({
			url     : ajaxurl,
			dataType: 'json',
			method  : 'post',
			data    : {
				action : 'product_meta_fields',
				post_id: postID
			},
			success : function (response) {
				$('#product_attributes_extra').empty().append(response.data);
			}
		});
	});

	// Show/hide settings for template settings
	$('#page_template').on('change', function () {

        pageHeaderSettings($(this));

	}).trigger('change');

    $(document.body).on('change', '.editor-page-attributes__template .components-select-control__input', function () {
        pageHeaderSettings($(this));
    });

    $(window).load(function () {
        var $el = $(document.body).find('.editor-page-attributes__template .components-select-control__input');
        pageHeaderSettings($el);
    });

    function pageHeaderSettings($el) {

        if ($el.val() == 'template-homepage.php' ||
            $el.val() == 'template-home-no-footer.php' ||
            $el.val() == 'template-coming-soon-page.php' ) {
            $('#display-settings').hide();
        } else {
            $('#display-settings').show();
        }
    }
} );
