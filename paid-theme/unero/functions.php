<?php
/**
 * Drfuri Core functions and definitions
 *
 * @package Unero
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since  1.0
 *
 * @return void
 */
function unero_setup() {
	// Sets the content width in pixels, based on the theme's design and stylesheet.
	$GLOBALS['content_width'] = apply_filters( 'unero_content_width', 840 );

	// Make theme available for translation.
	load_theme_textdomain( 'unero', get_template_directory() . '/lang' );

	// Theme supports
	add_theme_support( 'woocommerce' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'video' ) );
	add_theme_support(
		'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
		)
	);


	if( unero_fonts_url() ) {
		add_editor_style( array( 'css/editor-style.css', unero_fonts_url(), get_template_directory_uri() . '/css/linearicons.min.css' ) );
	} else {
		add_editor_style( 'css/editor-style.css' );
	}

	// Load regular editor styles into the new block-based editor.
	add_theme_support( 'editor-styles' );

	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'align-wide' );

	add_theme_support( 'align-full' );

	// Register theme nav menu
	register_nav_menus(
		array(
			'primary'     => esc_html__( 'Primary Menu', 'unero' ),
			'user_logged' => esc_html__( 'User Logged Menu', 'unero' ),
		)
	);

	$image_sizes = unero_get_option( 'image_sizes_default' );
	if ( is_null( $image_sizes ) || ! is_array( $image_sizes ) ) {
		$image_sizes = array(
			'blog_large',
			'blog_normal',
			'blog_masonry',
			'blog_grid',
			'post_normal',
			'categories_grid',
			'shop_masonry',
			'portfolio_masonry',
			'portfolio_carousel',
		);
	}

	// Image Size
	if ( in_array( 'blog_large', $image_sizes ) ) {
		add_image_size( 'unero-blog-large', 1170, 360, true );
	}

	if ( in_array( 'blog_normal', $image_sizes ) ) {
		add_image_size( 'unero-blog-normal', 800, 397, true );
	}

	if ( in_array( 'blog_masonry', $image_sizes ) ) {
		add_image_size( 'unero-blog-masonry', 370, 588, false );
	}

	if ( in_array( 'post_normal', $image_sizes ) || in_array( 'blog_grid', $image_sizes ) || in_array( 'shop_masonry', $image_sizes ) ) {
		add_image_size( 'unero-product-masonry-normal', 370, 370, true );
	}

	if ( in_array( 'categories_grid', $image_sizes ) ) {
		add_image_size( 'unero-product-cat-normal', 360, 422, true );
		add_image_size( 'unero-product-cat-long', 800, 422, true );
	}

	if ( in_array( 'shop_masonry', $image_sizes ) ) {
		add_image_size( 'unero-product-masonry-large', 370, 499, true );
		add_image_size( 'unero-product-masonry-long', 270, 364, true );
	}

	if ( in_array( 'portfolio_masonry', $image_sizes ) ) {
		add_image_size( 'unero-portfolio-masonry', 540, 670, false );
	}

	if ( in_array( 'portfolio_carousel', $image_sizes ) ) {
		add_image_size( 'unero-portfolio-carousel', 1170, 644, true );
	}

	// Initialize

	global $unero_woocommerce;
	$unero_woocommerce = new Unero_WooCommerce;

	if ( is_admin() ) {
		new Unero_Meta_Box_Product_Data;
	}
}

add_action( 'after_setup_theme', 'unero_setup' );


/**
 * Register widgetized area and update sidebar with default widgets.
 *
 * @since 1.0
 *
 * @return void
 */
function unero_register_sidebar() {
	// Register primary sidebar
	$sidebars = array(
		'blog-sidebar'      => esc_html__( 'Blog Sidebar', 'unero' ),
		'menu-sidebar'      => esc_html__( 'Menu Sidebar', 'unero' ),
		'catalog-sidebar'   => esc_html__( 'Catalog Sidebar', 'unero' ),
		'catalog-filter'    => esc_html__( 'Catalog Filter', 'unero' ),
		'portfolio-sidebar' => esc_html__( 'Portfolio Sidebar', 'unero' ),
		'page-sidebar'      => esc_html__( 'Page Sidebar', 'unero' ),
		'product-sidebar'   => esc_html__( 'Product Sidebar', 'unero' ),
	);

	// Register footer sidebars
	for ( $i = 1; $i <= 6; $i ++ ) {
		$sidebars["footer-sidebar-$i"] = esc_html__( 'Footer', 'unero' ) . " $i";
	}

	// Register sidebars
	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}

add_action( 'widgets_init', 'unero_register_sidebar' );

/**
 * Load theme
 */


// Widgets
require get_template_directory() . '/inc/widgets/widgets.php';

// customizer hooks
require get_template_directory() . '/inc/customizer/customizer.php';

require get_template_directory() . '/inc/frontend/woocommerce.php';

require get_template_directory() . '/inc/functions/entry.php';

require get_template_directory() . '/inc/functions/media.php';


if ( is_admin() ) {
	require get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php';
	require get_template_directory() . '/inc/backend/plugins.php';
	require get_template_directory() . '/inc/backend/meta-boxes.php';
	require get_template_directory() . '/inc/mega-menu/class-mega-menu.php';
	require get_template_directory() . '/inc/backend/product-meta-box-data.php';
	require get_template_directory() . '/inc/backend/importer.php';
	require get_template_directory() . '/inc/backend/editor.php';
} else {
	// Frontend functions and shortcodes
	require get_template_directory() . '/inc/functions/header.php';
	require get_template_directory() . '/inc/functions/layout.php';
	require get_template_directory() . '/inc/functions/breadcrumbs.php';
	require get_template_directory() . '/inc/functions/nav.php';
	require get_template_directory() . '/inc/functions/class-menu-walker.php';
	require get_template_directory() . '/inc/mega-menu/class-mega-menu-walker.php';
	require get_template_directory() . '/inc/functions/footer.php';
	require get_template_directory() . '/inc/functions/options.php';

	// Frontend hooks
	require get_template_directory() . '/inc/frontend/layout.php';
	require get_template_directory() . '/inc/frontend/header.php';
	require get_template_directory() . '/inc/frontend/nav.php';
	require get_template_directory() . '/inc/frontend/entry.php';
	require get_template_directory() . '/inc/frontend/comments.php';
	require get_template_directory() . '/inc/frontend/footer.php';
}