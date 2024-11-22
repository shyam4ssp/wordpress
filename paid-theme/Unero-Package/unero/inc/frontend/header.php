<?php
/**
 * Hooks for template header
 *
 * @package Unero
 */

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0
 */
function unero_enqueue_scripts() {
	/**
	 * Register and enqueue styles
	 */
	wp_register_style( 'unero-fonts', unero_fonts_url(), array(), '20170106' );
	wp_register_style( 'linearicons', get_template_directory_uri() . '/css/linearicons.min.css', array(), '1.0.0' );
	wp_register_style( 'eleganticons', get_template_directory_uri() . '/css/eleganticons.min.css', array(), '1.0.0' );
	wp_register_style( 'ionicons', get_template_directory_uri() . '/css/ionicons.min.css', array(), '2.0.0' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.3' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_enqueue_style( 'unero', get_template_directory_uri() . '/style.css', array(
		'unero-fonts',
		'linearicons',
		'eleganticons',
		'ionicons',
		'font-awesome',
		'bootstrap',
	), '20170106' );

	wp_add_inline_style( 'unero', unero_header_styles() );

	/**
	 * Register and enqueue scripts
	 */

	$min = defined( 'SCRIPT_DEBUG' ) ? '' : '.min';

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/plugins/html5shiv.min.js', array(), '3.7.2' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/plugins/respond.min.js', array(), '1.4.2' );
	wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() ) {
		if ( get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	$lightbox = 'no';

	if ( is_singular() ) {

		$photoswipe = 'photoswipe';
		if ( wp_style_is( $photoswipe, 'registered' ) && ! wp_style_is( $photoswipe, 'enqueued' ) ) {
			wp_enqueue_style( $photoswipe );
		}

		$photoswipe_skin = 'photoswipe-default-skin';
		if ( wp_style_is( $photoswipe_skin, 'registered' ) && ! wp_style_is( $photoswipe_skin, 'enqueued' ) ) {
			wp_enqueue_style( $photoswipe_skin );
		}

		$photoswipe_ui = 'photoswipe-ui-default';
		if ( wp_script_is( $photoswipe_ui, 'registered' ) && ! wp_script_is( $photoswipe_ui, 'enqueued' ) ) {
			wp_enqueue_script( $photoswipe_ui );
			$lightbox = 'yes';
		}
	}


	$script_name = 'wc-add-to-cart-variation';
	if ( wp_script_is( $script_name, 'registered' ) && ! wp_script_is( $script_name, 'enqueued' ) ) {
		wp_enqueue_script( $script_name );
	}

	wp_register_script( 'scrollreveal', get_template_directory_uri() . "/js/plugins/scrollreveal.min.js", array( 'jquery' ), '20170106', true );
	$animation_product = 0;
	if ( unero_is_catalog() ) {
		if ( in_array( unero_get_option( 'catalog_layout' ), array( 'masonry-content', 'board-content' ) ) ) {
			$animation_product = intval( unero_get_option( 'products_animation' ) );
			wp_enqueue_script( 'scrollreveal' );
		}
	}

	wp_register_script( 'flipclock', get_template_directory_uri() . '/js/plugins/flipclock.min.js', array(), '1.0.0', true );
	wp_register_script( 'isInViewport', get_template_directory_uri() . '/js/plugins/isInViewport.min.js', array(), '1.0.0', true );
	wp_register_script( 'isotope', get_template_directory_uri() . '/js/plugins/isotope.pkgd.min.js', array(), '2.2.2', true );
	wp_register_script( 'fitvids', get_template_directory_uri() . '/js/plugins/jquery.fitvids.js', array(), '1.1.0', true );
	wp_register_script( 'lazyload', get_template_directory_uri() . '/js/plugins/jquery.lazyload.min.js', array(), '1.9.7', true );
	wp_register_script( 'magnific-popup', get_template_directory_uri() . '/js/plugins/jquery.magnific-popup.min.js', array(), '1.1.0', true );
	wp_register_script( 'parallax', get_template_directory_uri() . '/js/plugins/jquery.parallax.min.js', array(), '1.0.0', true );
	wp_register_script( 'sticky-kit', get_template_directory_uri() . '/js/plugins/jquery.sticky-kit.min.js', array(), '1.1.2', true );
	wp_register_script( 'zoom', get_template_directory_uri() . '/js/plugins/jquery.zoom.min.js', array(), '1.7.1', true );
	wp_register_script( 'tooltip', get_template_directory_uri() . '/js/plugins/jquery-tooltip.js', array(), '2.1.1', true );
	wp_register_script( 'slick', get_template_directory_uri() . '/js/plugins/slick.min.js', array(), '1.6.0', true );
	wp_register_script( 'sly', get_template_directory_uri() . '/js/plugins/sly.min.js', array(), '1.6.1', true );

	wp_enqueue_script( 'unero', get_template_directory_uri() . "/js/scripts$min.js", array(
		'jquery',
		'imagesloaded',
		'flipclock',
		'isInViewport',
		'isotope',
		'fitvids',
		'lazyload',
		'magnific-popup',
		'parallax',
		'sticky-kit',
		'zoom',
		'tooltip',
		'slick',
		'sly',
	), '20170106', true );

	$product_open_cart_mini   = 0;
	$product_add_to_cart_ajax = intval( unero_get_option( 'product_add_to_cart_ajax' ) );
	if ( $product_add_to_cart_ajax ) {
		$product_open_cart_mini = intval( unero_get_option( 'product_open_cart_mini' ) );
	}
	$upsells_products_columns = intval( unero_get_option( 'upsells_products_columns' ) );
	$related_products_columns = intval( unero_get_option( 'related_products_columns' ) );
	$products_column_mobile   = intval( unero_get_option( 'product_columns_mobile' ) );


	$product_zoom       = intval( unero_get_option( 'product_zoom' ) );
	$header_ajax_search = intval( unero_get_option( 'header_ajax_search' ) );

	$product_page_layout = unero_get_option( 'product_page_layout' );
	$thumbnail_carousel  = false;
	$thumbnail_vertical  = false;
	$thumbnail_columns   = 6;

	if ( in_array( $product_page_layout, array( '1', '2', '4', '5' ) ) ) {
		$thumbnail_carousel = true;
	}

	if ( in_array( $product_page_layout, array( '1' ) ) ) {
		$thumbnail_vertical = true;
	}

	if ( in_array( $product_page_layout, array( '4', '5' ) ) ) {
		$thumbnail_columns = 5;
	}

	if ( in_array( $product_page_layout, array( '6' ) ) ) {
		$product_zoom = 0;
	}

	wp_localize_script(
		'unero', 'uneroData', array(
			'lightbox'                    => $lightbox,
			'ajax_url'                    => admin_url( 'admin-ajax.php' ),
			'nonce'                       => wp_create_nonce( '_unero_nonce' ),
			'catalog_ajax_filter'         => intval( unero_get_option( 'catalog_ajax_filter' ) ),
			'upsells_products_columns'    => $upsells_products_columns,
			'related_products_columns'    => $related_products_columns,
			'open_cart_mini'              => intval( unero_get_option( 'open_cart_mini' ) ),
			'product_open_cart_mini'      => $product_open_cart_mini,
			'product_add_to_cart_ajax'    => $product_add_to_cart_ajax,
			'portfolio_carousel_slide'    => intval( unero_get_option( 'portfolio_carousel_active_slide' ) ),
			'portfolio_carousel_autoplay' => intval( unero_get_option( 'portfolio_carousel_autoplay' ) ),
			'animation_product'           => $animation_product,
			'rtl'                         => is_rtl() ? 'true' : 'false',
			'product_zoom'                => $product_zoom,
			'product_images_lightbox'     => intval( unero_get_option( 'product_images_lightbox' ) ),
			'ajax_search'                 => $header_ajax_search,
			'tooltips'                    => intval( unero_get_option( 'tooltips' ) ),
			'thumbnail_carousel'          => $thumbnail_carousel,
			'thumbnail_vertical'          => $thumbnail_vertical,
			'thumbnail_columns'           => $thumbnail_columns,
			'product_columns_mobile'      => $products_column_mobile,
			'quick_view_method'           => intval( unero_get_option( 'product_quick_view_method' ) ),
		)
	);


}

add_action( 'wp_enqueue_scripts', 'unero_enqueue_scripts' );

/**
 * Custom styles on header
 *
 * @since  1.0.0
 */
function unero_header_styles() {
	/**
	 * All Custom CSS rules
	 */
	$inline_css = '';

	$inline_css = unero_boxed_content();

	//Logo
	$logo_size_width = intval( unero_get_option( 'logo_width' ) );
	$logo_css        = $logo_size_width ? 'width:' . $logo_size_width . 'px; ' : '';

	$logo_size_height = intval( unero_get_option( 'logo_height' ) );
	$logo_css         .= $logo_size_height ? 'height:' . $logo_size_height . 'px; ' : '';

	$logo_margin     = unero_get_option( 'logo_margins' );
	$logo_margin_css = $logo_margin['top'] ? 'margin-top:' . $logo_margin['top'] . '; ' : '';
	$logo_margin_css .= $logo_margin['right'] ? 'margin-right:' . $logo_margin['right'] . '; ' : '';
	$logo_margin_css .= $logo_margin['bottom'] ? 'margin-bottom:' . $logo_margin['bottom'] . '; ' : '';
	$logo_margin_css .= $logo_margin['left'] ? 'margin-left:' . $logo_margin['left'] . '; ' : '';

	if ( ! empty( $logo_css ) ) {
		$inline_css .= '.site-header .logo img ' . ' {' . $logo_css . '}';
	}

	if ( ! empty( $logo_margin_css ) ) {
		$inline_css .= '.site-header .logo ' . ' {' . $logo_margin_css . '}';
	}

	//Logo
	$logo_size_sticky = intval( unero_get_option( 'logo_width_sticky' ) );
	$logo_sticky      = $logo_size_sticky ? 'width:' . $logo_size_sticky . 'px !important;' : '';

	if ( ! empty( $logo_sticky ) ) {
		$inline_css .= '@media (min-width: 992px) {.sticky-header .site-header.minimized .logo img' . ' {max-height:inherit;height: auto;' . $logo_sticky . '}}';
	}

	//Logo
	$logo_size_mobile = intval( unero_get_option( 'logo_width_mobile' ) );
	$logo_mobile      = $logo_size_mobile ? 'max-width:' . $logo_size_mobile . 'px; ' : '';

	if ( ! empty( $logo_mobile ) ) {
		$inline_css .= '@media (max-width: 991px) {.site-header .logo img' . ' {max-height:inherit;height: auto;' . $logo_mobile . '}}';
	}


	if ( $page_header = unero_get_page_header() ) {
		if ( isset( $page_header['bg_image'] ) && ! empty( $page_header['bg_image'] ) ) {
			$inline_css .= ".page-header { background-image: url(" . esc_url( $page_header['bg_image'] ) . "); }";
		}
	}

	$coming_soon_bg_image = unero_get_option( 'coming_soon_bg_image' );
	if ( $coming_soon_bg_image ) {
		$inline_css .= ".page-template-template-coming-soon-page { background-image: url(" . esc_url( $coming_soon_bg_image ) . "); }";
	}

	$color_scheme_option = unero_get_option( 'color_scheme' );

	if ( intval( unero_get_option( 'custom_color_scheme' ) ) ) {
		$color_scheme_option = unero_get_option( 'custom_color' );
	}
	// Don't do anything if the default color scheme is selected.
	if ( $color_scheme_option ) {
		$inline_css .= unero_get_color_scheme_css( $color_scheme_option );
	}

	$body_typo = unero_get_option( 'body_typo' );
	if ( $body_typo ) {
		if ( isset( $body_typo['font-family'] ) && strtolower( $body_typo['font-family'] ) !== 'poppins' ) {
			$inline_css .= unero_get_typography_css( $body_typo['font-family'] );
		}
	}

	$inline_css .= unero_get_heading_typography_css();

	return $inline_css;

}

/**
 * Add before unload
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'unero_before_unload' ) ) :
	function unero_before_unload() {

		if ( ! intval( unero_get_option( 'preloader' ) ) ) {
			return;
		}

		?>
        <div id="un-before-unloader" class="un-before-unloader">
            <div class="unero-loader">
            </div>
        </div>
		<?php
	}
endif;

add_action( 'unero_before_header', 'unero_before_unload' );


/**
 * Display the header minimized
 *
 * @since 1.0.0
 */
function unero_header_minimized() {

	if ( is_page_template( 'template-coming-soon-page.php' ) ) {
		return;
	}

	if ( ! intval( unero_get_option( 'sticky_header' ) ) ) {
		return;
	}

	if ( is_page_template( 'template-homepage.php' ) ||
	     is_page_template( 'template-home-no-footer.php' ) ||
	     is_front_page()
	) {
		if ( in_array( unero_get_option( 'header_layout' ), array(
				1,
				2,
			) ) && intval( unero_get_option( 'header_transparent' ) ) ) {
			return;
		}
	}

	if ( unero_is_catalog() ) {

		if ( unero_shop_page_header() ) {
			if ( in_array( unero_get_option( 'page_header_layout_shop' ), array( '2', '3' ) ) ) {
				if ( in_array( unero_get_option( 'header_layout' ), array( 1, 2 ) ) ) {
					if ( intval( unero_get_option( 'shop_header_transparent' ) ) ) {
						return;
					}
				}
			}
		}
	}

	$css_class = '';
	if ( unero_get_option( 'header_layout' ) == 1 && intval( unero_get_option( 'header_full_width' ) ) ) {
		$css_class = 'header-full-width';
	} elseif ( unero_get_option( 'header_layout' ) == 3 && ! unero_get_option( 'header_top_desc' ) ) {
		$css_class = 'no-header-top';
	}

	printf( '<div id="un-header-minimized" class="un-header-minimized %s"></div>', esc_attr( $css_class ) );

}

add_action( 'unero_before_header', 'unero_header_minimized' );

/**
 * Display the site header
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_show_header' ) ) :
	function unero_show_header() {

		if ( is_page_template( 'template-coming-soon-page.php' ) ) {
			get_template_part( 'template-parts/logo' );
		} else {
			$header_layout = unero_get_option( 'header_layout' );
			$header_layout = $header_layout ? $header_layout : 1;
			get_template_part( 'template-parts/headers/layout', $header_layout );
		}

	}
endif;

add_action( 'unero_header', 'unero_show_header' );

/**
 * Show page header
 *
 * @since 1.0.0
 */
function unero_show_page_header() {

	if ( is_page_template( 'template-homepage.php' ) ||
	     is_page_template( 'template-home-no-footer.php' ) ||
	     is_page_template( 'template-coming-soon-page.php' )
	) {
		return;
	}

	$page_header = unero_get_page_header();
	if ( ! $page_header && ! is_singular( 'product' ) ) {
		return;
	}

	if ( is_singular( 'product' ) && in_array( unero_get_option( 'product_page_layout' ), array( '3', '6' ) ) ) {
		return;
	}


	$layout = 1;

	if ( $page_header && isset( $page_header['layout'] ) ) {
		$layout = $page_header['layout'];
	}

	if ( unero_is_catalog() && $layout == '3' ) {
		get_template_part( 'template-parts/page-headers/shop-layout', $layout );
	} elseif ( unero_is_portfolio() && $layout == '2' ) {
		get_template_part( 'template-parts/page-headers/portfolio-layout', $layout );
	} elseif ( is_singular( 'portfolio_project' ) && $layout == '2' ) {
		get_template_part( 'template-parts/page-headers/single-portfolio-layout', $layout );
	} else {
		get_template_part( 'template-parts/page-headers/layout', 1 );
	}

	?>
	<?php
}

add_action( 'unero_after_header', 'unero_show_page_header', 20 );

/**
 * Returns CSS for the color schemes.
 *
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 */
function unero_get_color_scheme_css( $colors ) {
	return <<<CSS
	/* Color Scheme */

	/* Color */

	.primary-color,
	.unero-banner-carousel .cs-content a:hover,
	.unero-sliders .cs-content .link,
	.unero-banners-carousel .cs-content a:hover,
	.unero-banners-grid ul .banner-item-text .link:hover,
	.unero-banner:hover h2,
	.unero-link .link:hover,
	.unero-posts .post-content .post-title:hover,
	.unero-posts .post-footer .post-link,
	.unero-hero-slider .slider-tabs-content .item-content:hover .title,.unero-hero-slider .slider-tabs-content .item-content.active .title,
	.unero-about .title,
	.unero-icon-box .b-icon,
	.unero-faq_group .g-title,
	.unero-cta a,
	.search-modal .product-cats label span:hover,
	.search-modal .product-cats input:checked + span,
	.search-modal .search-results ul li .search-item:hover .title,
	.unero-taxs-list ul li a:hover,.unero-taxs-list ul li a.selected,
	.blog-wapper .entry-footer .readmore:hover,
	.blog-wapper.sticky .entry-title:before,
	.single-post .entry-footer .tags-links a:hover,
	.single-post .entry-footer .footer-socials .social-links a:hover,
	.error-404 .page-content .page-title i,
	.error-404 .page-content a,
	.single-portfolio_project .entry-header .portfolio-socials .social-links a:hover,
	.woocommerce ul.products li.product.product-category:hover .woocommerce-loop-category__title,.woocommerce ul.products li.product.product-category:hover .count,
	.woocommerce ul.products li.product .footer-button > a:hover,
	.woocommerce div.product p.stock.out-of-stock span,
	.woocommerce div.product.product-type-variable form.cart .variations .reset_variations,
	.woocommerce table.wishlist_table .product-price ins,
	.woocommerce #shipping_method li .shipping_method:checked + label .woocommerce-Price-amount,
	.woocommerce .shop-toolbar .un-categories-filter li a.selected,.woocommerce .shop-toolbar .un-categories-filter li a:hover,
	.woocommerce .shop-toolbar .filters:hover,
	.woocommerce .shop-toolbar .filters.active,
	.woocommerce .shop-toolbar .product-found span,
	.woocommerce-checkout .woocommerce-info .showlogin:hover,.woocommerce-checkout .woocommerce-info .showcoupon:hover,
	.woocommerce-account .woocommerce .woocommerce-Addresses .woocommerce-Address .woocommerce-Address-edit .edit:hover,
	.catalog-sidebar .widget_product_categories ul li.current-cat a,.catalog-sidebar .widget_product_categories ul li.chosen a,.catalog-sidebar .widget_product_categories ul li.current-cat .count,.catalog-sidebar .widget_product_categories ul li.chosen .count,
	.shop-topbar .unero_attributes_filter ul li.chosen .swatch-color:before,
	.shop-topbar .shop-filter-actived .found,
	.shop-topbar .shop-filter-actived .remove-filter-actived,
	.comment-respond .logged-in-as a:hover,
	.widget ul li a:hover,
	.widget .woocommerce-ordering li > ul li a:hover,.widget .woocommerce-ordering li > ul li a.active,
	.widget_tag_cloud a.selected,.widget_product_tag_cloud a.selected,
	.widget_product_tag_cloud a:hover,
	.widget_layered_nav ul li.chosen a,.widget_layered_nav ul li.chosen .count,
	.unero-price-filter-list ul li a.actived,
	.unero-price-filter-list ul li.chosen a,
	.social-links-widget a.social:hover,
	.unero-language-currency .widget-lan-cur ul li.actived a,
	.footer-layout-4 .footer-content .menu li a:hover,
	.woocommerce .shop-toolbar .un-toggle-cats-filter.active,
	.woocommerce .shop-toolbar .un-ordering.active,
	.un-box-content .b-content .link {
		color: {$colors};
	}

	/* Background Color */

	.unero-loader:before,.unero-loader:after,
	.unero-banner-carousel ul:after,.unero-banner-carousel ul:before,
	.unero-sliders ul:after,.unero-sliders ul:before,
	.unero-banners-carousel ul:after,.unero-banners-carousel ul:before,
	.unero-newsletter.style-2 .nl-form input[type=submit],
	.unero-contact-form .wpcf7-form .wpcf7-submit,
	.unero-cta a:after,
	.site-header .menu-extra .menu-item-cart .mini-cart-counter,
	.single-post .post-password-form input[type="submit"],
	.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit,
	.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce #respond input#submit.alt,
	.woocommerce ul.products li.product .un-loop-thumbnail.image-loading:before,.woocommerce ul.products li.product .un-loop-thumbnail.image-loading:after,
	.woocommerce div.product .woocommerce-product-gallery__wrapper:after,.woocommerce div.product .woocommerce-product-gallery__wrapper:before,
	.woocommerce-cart .woocommerce table.cart .btn-shop,.woocommerce-cart .woocommerce table.checkout .btn-shop,
	.woocommerce .blockUI.blockOverlay:after,.woocommerce .blockUI.blockOverlay:before,
	.comment-respond .form-submit .submit,
	.footer-layout-4 .footer-socials .socials a:hover,
	.wpb_wrapper .add_to_cart_inline .button,
	.un-video-banner .banner-content .link,
	 .backtotop,
	  .site-header .menu-extra .menu-item-wishlist .mini-cart-counter {
		background-color: {$colors};
	}

	/* Border Color */
	blockquote {
		border-left-color: {$colors};
	}

CSS;
}

/**
 * Returns CSS for the typography.
 *
 *
 * @param array $body_typo Color scheme body typography.
 *
 * @return string typography CSS.
 */
function unero_get_typography_css( $body_typo ) {

	if ( ! class_exists( 'Kirki' ) ) {
		return '';
	}

	$body_typo = rtrim( trim( $body_typo ), ',' );

	return <<<CSS
	.page-header-sliders .page-header-content h3,
	.woocommerce .un-shop-desc .title,
	.woocommerce ul.products li.product .un-product-title,
	.blog-wapper .entry-header .entry-title,
	.comments-title,
	.comment-respond .comment-reply-title,
	.woocommerce div.product .product_title,
	.search-modal .modal-title,
	.unero-product-instagram > h2,
	.woocommerce div.product .upsells.products > h2,
	.woocommerce div.product .related.products > h2,
	.woocommerce-cart .woocommerce h2,
	.woocommerce-checkout form.checkout h3,
	.woocommerce-order-received h2,
	.woocommerce-order-received h3,
	.unero-section-title h2,
	.unero-faq_group .g-title,
	.unero-faq_group .title,
	.page-template-template-coming-soon-page .un-coming-soon-content .c-title,
	.error-404 .page-content .page-title,
	.woocommerce #reviews #comments .woocommerce-Reviews-title,
	.single-post .entry-header .entry-title,
	.unero-banner h2,
	.unero-products-carousel .title,
	.unero-newsletter.style-2 .nl-title,
	.unero-posts .post-content h2,
	.unero-banners-grid ul .banner-item-text h3,
	.unero-hero-slider .item-content .title,
	.woocommerce ul.products li.product .woocommerce-loop-category__title,
	.woocommerce .wishlist-title h2,
	 .woocommerce-account .woocommerce .woocommerce-MyAccount-content .orders-title,
	 .woocommerce-account .woocommerce .woocommerce-MyAccount-content .billing-title,
	 .woocommerce-account .woocommerce .woocommerce-Addresses .woocommerce-Address .woocommerce-Address-title h3{
		  font-family: {$body_typo}, Arial, sans-serif;
	}
CSS;
}

/**
 * Returns CSS for the typography.
 *
 *
 * @param array $body_typo Color scheme body typography.
 *
 * @return string typography CSS.
 */
function unero_get_heading_typography_css() {

	$inline_css = '';
	if ( ! class_exists( 'Kirki' ) ) {
		return $inline_css;
	}

	$headings = array(
		'h1' => 'heading1_typo',
		'h2' => 'heading2_typo',
		'h3' => 'heading3_typo',
		'h4' => 'heading4_typo',
		'h5' => 'heading5_typo',
		'h6' => 'heading6_typo',
	);

	foreach ( $headings as $heading ) {
		$keys = array_keys( $headings, $heading );
		if ( $keys ) {
			$inline_css .= unero_get_heading_font( $keys[0], $heading );
		}
	}


	return $inline_css;

}

/**
 * Returns CSS for the typography.
 *
 *
 * @param array $body_typo Color scheme body typography.
 *
 * @return string typography CSS.
 */
function unero_get_heading_font( $key, $heading ) {

	$inline_css = '';
	if ( ! class_exists( 'Kirki' ) ) {
		return $inline_css;
	}

	$heading_typo = unero_get_option( $heading );

	if ( $heading_typo ) {
		if ( isset( $heading_typo['font-family'] ) && strtolower( $heading_typo['font-family'] ) !== 'poppins' ) {
			$typo       = rtrim( trim( $heading_typo['font-family'] ), ',' );
			$inline_css .= $key . ' {font-family:' . $typo . ', Arial, sans-serif}';
		}
	}

	if ( empty( $inline_css ) ) {
		return;
	}

	return <<<CSS
	{$inline_css}
CSS;
}