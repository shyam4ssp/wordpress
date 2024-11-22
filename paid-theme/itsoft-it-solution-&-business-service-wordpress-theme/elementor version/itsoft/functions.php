<?php

require_once 'custom-elementor.php';
require_once 'cicon.php';

/**
 * itsoft functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package itsoft
 */


if ( ! function_exists( 'itsoft_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function itsoft_setup() {

	load_theme_textdomain( 'itsoft', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-formats', array( 'gallery', 'quote', 'video', 'audio' ) );
	add_image_size( 'itsoft-blog-default', 390, 290, true );
	add_image_size( 'itsoft-blog-adn', 250, 300, true );
	add_image_size( 'itsoft-blog-single', 900, 550, true );
	add_image_size( 'itsoft-blog-both', 570, 350, true );
	add_image_size( 'itsoft-team', 450, 450, true );
	add_image_size( 'itsoft-testimonial', 106, 106, true );
	add_image_size( 'itsoft-single-portfolio', 1170, 600, true );
	add_image_size( 'itsoft-gallery-thumb', 560, 560, true );
	add_image_size( 'itsoft-recent-image', 80, 80, true );
	add_image_size( 'itsoft-case-thumb', 400, 250, true );
	add_theme_support('woocommerce');
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );						
	add_theme_support( 'post-thumbnails');
	add_editor_style();

	register_nav_menus( array(
		'menu-top' => esc_html__( 'Top Menu', 'itsoft' ),
		'menu-1' => esc_html__( 'Main Menu', 'itsoft' ),
		'one-pages' => esc_html__( 'OnePage Menu', 'itsoft' ),
		'menu-3' => esc_html__( 'Mobile Menu', 'itsoft' ),
		'menu-4' => esc_html__( 'Footer Menu', 'itsoft' ),

	) );
	
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'custom-background', apply_filters( 'itsoft_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'itsoft_setup' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/jetpack.php';

/**
*visual composer 
*/

// load redux
if ( class_exists('ReduxFrameworkPlugin') ) {
	require get_template_directory(). '/includes/itsoft-option-framework.php';
}
require get_template_directory(). '/includes/itsoft-global-function.php';
require get_template_directory(). '/includes/itsoft-breadcrumb.php';
require get_template_directory(). '/includes/itsoft-tgm-activation.php';


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function itsoft_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'itsoft_content_width', 1140 );
}
add_action( 'after_setup_theme', 'itsoft_content_width', 0 );

/**
 *Register Fonts
*/
if(!function_exists('itsoft_fonts_url')){
	
	function itsoft_fonts_url(){
	 $fonts_url = '';
	 
	 /* Translators: If there are characters in your language that are not
	 * supported by Roboto, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	 $firasans = _x( 'on', 'Fira Sans font: on or off', 'itsoft' );
 	 $rubik = _x( 'on', 'Rubik font: on or off', 'itsoft' );
	 
	 if ( 'off' !== $firasans ) {
	 $font_families = array();
	 }
	 
	 if ( 'off' !== $firasans ) {
	 $font_families[] = 'Fira Sans:300,400,500,600,700,800,900';
	 }
	 
 	 if ( 'off' !== $rubik ) {
	 $font_families[] = 'Rubik:300,400,500,600,700,800,900';
	 }

	if ( $font_families ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		), 'https://fonts.googleapis.com/css' );
	}
	 
	 return esc_url_raw( $fonts_url ); 
	}
}

// load style
if(!function_exists('itsoft_styles')){
	
	function itsoft_styles(){
		
		wp_enqueue_style('bootstrap', get_template_directory_uri() .'/assets/css/bootstrap.min.css');
		wp_enqueue_style( 'itsoft-fonts', itsoft_fonts_url(), array() );		
		wp_enqueue_style('venobox', get_template_directory_uri() .'/venobox/venobox.css');
		wp_enqueue_style('nivo', get_template_directory_uri() .'/assets/css/nivo-slider.css');
		wp_enqueue_style('animate', get_template_directory_uri() .'/assets/css/animate.css');
		wp_enqueue_style('slick', get_template_directory_uri() .'/assets/css/slick.css');
		wp_enqueue_style('owl-carousel', get_template_directory_uri() .'/assets/css/owl.carousel.css');
		wp_enqueue_style('owl-transitions', get_template_directory_uri() .'/assets/css/owl.transitions.css');
		wp_enqueue_style('fontawesome', get_template_directory_uri() .'/assets/css/font-awesome.min.css');
		wp_enqueue_script( 'modernizrs', get_template_directory_uri() . '/assets/js/modernizr.custom.79639.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'mouse-directions', get_template_directory_uri() . '/assets/js/jquery.directional-hover.min.js', array('jquery'), '3.2.4', true );
		wp_enqueue_style('meanmenu', get_template_directory_uri() .'/assets/css/meanmenu.min.css');
		wp_enqueue_style('itsoft-theme-default', get_template_directory_uri() .'/assets/css/theme-default.css');
		wp_enqueue_style('itsoft-widget', get_template_directory_uri() .'/assets/css/widget.css');
		wp_enqueue_style('itsoft-unittest', get_template_directory_uri() .'/assets/css/unittest.css');
		wp_enqueue_style( 'itsoft-style', get_stylesheet_uri() );	
		wp_enqueue_style('itsoft-responsive', get_template_directory_uri() .'/assets/css/responsive.css');		
	}
	
}


add_action( 'wp_enqueue_scripts', 'itsoft_styles' );


 // Load scripts.
if(!function_exists('itsoft_scripts')){
	
	function itsoft_scripts() {
		
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.8.3.min.js', array(), '2.8.3', true );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.5', true );
		wp_enqueue_script( 'imagesloaded');
		wp_enqueue_script( 'meanmenu', get_template_directory_uri() . '/assets/js/jquery.meanmenu.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'scrollup', get_template_directory_uri() . '/assets/js/jquery.scrollUp.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'nivo-slider', get_template_directory_uri() . '/assets/js/jquery.nivo.slider.pack.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'headroom', get_template_directory_uri() . '/assets/js/headroom.min.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'paralax', get_template_directory_uri() . '/assets/js/parallax.min.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'jquery-counterup', get_template_directory_uri() . '/assets/js/jquery.counterup.min.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'jquery-nav', get_template_directory_uri() . '/assets/js/jquery.nav.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'animate-text', get_template_directory_uri() . '/assets/js/headline.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'wow', get_template_directory_uri() . '/assets/js/wow.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'jquery-scrolltofixed', get_template_directory_uri() . '/assets/js/jquery-scrolltofixed-min.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'venobox', get_template_directory_uri() . '/venobox/venobox.min.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/assets/js/waypoints.min.js', array('jquery'), '3.2.4', true );
		wp_enqueue_script( 'itsoft-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
		wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/js/app.js', array(), '20151227', true );
		wp_enqueue_script( 'particles', get_template_directory_uri() . '/assets/js/particles.min.js', array(), '20151265', true );
		wp_enqueue_script( 'itsoft-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
		wp_enqueue_script( 'itsoft-theme', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), '3.2.4', true );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'itsoft_scripts' );

/**
 * itsoft widget js
 */
 if(!function_exists('itsoft_media_scripts')){
	 
	function itsoft_media_scripts() {
		wp_enqueue_media();
		wp_enqueue_script('itsoft-uploader', get_template_directory_uri() .'/assets/js/itsoft_uploader.js', false, '', true );
	}
 }
add_action('admin_enqueue_scripts', 'itsoft_media_scripts');



// Content word count
if(!function_exists('itsoft_read_more')){
		
	function itsoft_read_more($limit){
		$content = explode(' ', get_the_content());
		$count   = array_slice($content, 0 , $limit);
		echo implode (' ', $count);
	}
}

// Title word count
if(!function_exists('itsoft_title')){
	
	function itsoft_title($limit){
		$title = explode(' ' , get_the_title());
		$titles = array_slice($title , 0, $limit);
		echo implode(' ', $titles);
	}
	
}
/**
 * Register widget area.
 */
if(!function_exists('itsoft_widgets_init')){
	function itsoft_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'itsoft' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'itsoft' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Page', 'itsoft' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'itsoft' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		
		/**
		 * Register Footer Sidebars
		 */
		for( $footer = 1; $footer < 5; $footer++ ) {
			register_sidebar( array(
				'id'		=> 'itsoft-footer-' . $footer,
				'name'		=> esc_html__( 'Footer ', 'itsoft' ) . $footer,
				'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h2 class="widget-title">',
				'after_title'	=> '</h2>',
			) );
		} // for footers		
	}
	
}
add_action( 'widgets_init', 'itsoft_widgets_init' );


add_filter('autoptimize_html_after_minify', function($content) {

    $site_url = 'https://bulk-editor.com';//drop here your site link without slash on the end

    $content = str_replace("type='text/javascript'", ' ', $content);
    $content = str_replace('type="text/javascript"', ' ', $content);

    $content = str_replace("type='text/css'", ' ', $content);
    $content = str_replace('type="text/css"', ' ', $content);

    $content = str_replace($site_url . '/wp-includes/js', '/wp-includes/js', $content);
    $content = str_replace($site_url . '/wp-content/cache/autoptimize', '/wp-content/cache/autoptimize', $content);
    $content = str_replace($site_url . '/wp-content/themes/', '/wp-content/themes/', $content);
    $content = str_replace($site_url . '/wp-content/uploads/', '/wp-content/uploads/', $content);
    return $content;
}, 10, 1);