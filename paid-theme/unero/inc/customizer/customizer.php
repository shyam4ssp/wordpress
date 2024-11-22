<?php
/**
 * Unero theme customizer
 *
 * @package Unero
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Unero_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();
	}

	/**
	 * Register settings
	 */
	public function register() {

		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {
		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][$name] ) ) {
			return false;
		}

		return isset( $this->config['fields'][$name]['default'] ) ? $this->config['fields'][$name]['default'] : false;
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function unero_get_option( $name ) {
	global $unero_customize;

	$value = false;

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( 'unero', $name );
	} elseif ( ! empty( $unero_customize ) ) {
		$value = $unero_customize->get_option( $name );
	}

	return apply_filters( 'unero_get_option', $value, $name );
}

/**
 * Get default option values
 *
 * @param $name
 *
 * @return mixed
 */
function unero_get_option_default( $name ) {
	global $unero_customize;

	if ( empty( $unero_customize ) ) {
		return false;
	}

	return $unero_customize->get_option_default( $name );
}

/**
 * The custom control class
 */

function unero_kirki_enqueue_scripts() {
	wp_enqueue_style( 'unero-kirki-style', get_template_directory_uri() . '/css/backend/custom-kirki.css', array(), '20170106' );
}

add_action( 'customize_controls_print_styles', 'unero_kirki_enqueue_scripts', 30 );

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function unero_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'unero_customize_modify' );

function unero_customize_selective_refresh( $wp_customize ) {
	$wp_customize->selective_refresh->add_partial(
		'logo', array(
			'selector' => '.site-header .logo',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'menu_extras', array(
			'selector' => '.site-header .menu-extra',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'footer_logo', array(
			'selector' => '.site-footer .footer-logo',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'footer_news_letter', array(
			'selector' => '.site-footer .footer-newsletter',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'footer_copyright', array(
			'selector' => '.site-footer .text-copyright',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'footer_socials', array(
			'selector' => '.site-footer .socials',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'page_header_layout_shop', array(
			'selector' => '.post-type-archive-product .page-header, .tax-product_cat .page-header',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'shop_toolbar_layout', array(
			'selector' => '#un-shop-toolbar',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'shop_element', array(
			'selector' => '.post-type-archive-product .un-shop-desc, #un-shop-product-cats > .container',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'product_instagram', array(
			'selector' => '.single-product .unero-product-instagram',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'related_products_columns', array(
			'selector' => '.single-product .related.products',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'show_product_meta', array(
			'selector' => '.single-product .product_meta',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'product_social_icons', array(
			'selector' => '.single-product div.product .product-summary .social-links',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'catalog_layout', array(
			'selector' => '#un-shop-content',
		)
	);

}

add_action( 'customize_register', 'unero_customize_selective_refresh', 30 );

/**
 * Get nav menus
 *
 * @return string
 */
function unero_customizer_get_nav_menus() {

	if ( ! is_admin() ) {
		return;
	}

	$menus = wp_get_nav_menus();
	if ( ! $menus ) {
		return;
	}

	$output = array(
		0 => esc_html__( 'Select Menu', 'unero' ),
	);
	foreach ( $menus as $menu ) {
		$output[$menu->term_id] = $menu->name;
	}

	return $output;
}

/**
 * Get nav menus
 *
 * @return string
 */
function unero_customizer_get_categories( $taxonomies, $default = false ) {
	if ( ! taxonomy_exists( $taxonomies ) ) {
		return;
	}

	if ( ! is_admin() ) {
		return;
	}

	$output = array();

	if ( $default ) {
		$output[0] = esc_html__( 'Select Category', 'unero' );
	}


	$get_terms_args               = array( 'hide_empty' => '1' );
	$get_terms_args['menu_order'] = 'ASC';

	$terms = get_terms( $taxonomies, $get_terms_args );

	if ( ! is_wp_error( $terms ) && $terms ) {
		// Build the array.
		foreach ( $terms as $term ) {
			$output[$term->slug] = $term->name;
		}
	}

	return $output;
}

/**
 * Disable home section
 *
 * @return string
 */
function unero_homepage_section() {
	if ( intval( get_option( 'woocommerce_shop_page_id' ) ) == intval( get_option( 'page_on_front' ) ) ) {
		return false;
	}

	return true;
}

/**
 * Get product attributes
 *
 * @return string
 */
function unero_product_attributes() {
	$output = array();
	if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
		$attributes_tax = wc_get_attribute_taxonomies();
		if ( $attributes_tax ) {
			$output['none'] = esc_html__( 'None', 'unero' );

			foreach ( $attributes_tax as $attribute ) {
				$output[$attribute->attribute_name] = $attribute->attribute_label;
			}

		}
	}

	return $output;
}

/**
 * Get customize settings
 *
 * @return array
 */
function unero_customize_settings() {
	/**
	 * Customizer configuration
	 */

	return array(
		'theme'    => 'unero',

		'panels'   => array(
			'general'     => array(
				'priority' => 10,
				'title'    => esc_html__( 'General', 'unero' ),
			),
			'typography'  => array(
				'priority' => 20,
				'title'    => esc_html__( 'Typography', 'unero' ),
			),
			// Styling
			'styling'     => array(
				'title'    => esc_html__( 'Styling', 'unero' ),
				'priority' => 30,
			),
			'header'      => array(
				'priority' => 50,
				'title'    => esc_html__( 'Header', 'unero' ),
			),
			'woocommerce' => array(
				'priority' => 70,
				'title'    => esc_html__( 'Woocommerce', 'unero' ),
			),
			'blog'        => array(
				'title'    => esc_html__( 'Blog', 'unero' ),
				'priority' => 80,
			),
			'portfolio'   => array(
				'title'    => esc_html__( 'Portfolio', 'unero' ),
				'priority' => 80,
			),
			'pages'       => array(
				'title'    => esc_html__( 'Pages', 'unero' ),
				'priority' => 80,
			),
		),

		'sections' => array(
			'theme_fonts'                  => array(
				'title'       => esc_html__( 'Theme Fonts', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'body_typo'                    => array(
				'title'       => esc_html__( 'Body', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'heading_typo'                 => array(
				'title'       => esc_html__( 'Heading', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'page_header_typo'             => array(
				'title'       => esc_html__( 'Page Header', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'widget_typo'                  => array(
				'title'       => esc_html__( 'Widget', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'footer_typo'                  => array(
				'title'       => esc_html__( 'Footer', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'image_sizes'                  => array(
				'title'       => esc_html__( 'Image Sizes', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'general',
			),
			'instagram'                    => array(
				'title'       => esc_html__( 'Instagram', 'unero' ),
				'description' => '',
				'priority'    => 220,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),

			// Styling
			'styling_general'              => array(
				'title'       => esc_html__( 'General', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			'boxed_layout'                 => array(
				'title'       => esc_html__( 'Boxed Layout', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			'color_scheme'                 => array(
				'title'       => esc_html__( 'Color Scheme', 'unero' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			// Header
			'logo'                         => array(
				'title'       => esc_html__( 'Logo', 'unero' ),
				'description' => '',
				'priority'    => 15,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'header'                       => array(
				'title'       => esc_html__( 'Header Layout', 'unero' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'header_mobile'                => array(
				'title'       => esc_html__( 'Header On Mobile', 'unero' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'blog'                         => array(
				'title'       => esc_html__( 'General', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'panel'       => 'blog',
				'capability'  => 'edit_theme_options',
			),
			'page_header_site'             => array(
				'title'       => esc_html__( 'Blog Page Header', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'capability'  => 'edit_theme_options',
				'panel'       => 'blog',
			),
			'single_post'                  => array(
				'title'       => esc_html__( 'Single Post', 'unero' ),
				'description' => '',
				'priority'    => 50,
				'panel'       => 'blog',
				'capability'  => 'edit_theme_options',
			),
			// Portfolio
			'portfolio'                    => array(
				'title'       => esc_html__( 'General', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'panel'       => 'portfolio',
				'capability'  => 'edit_theme_options',
			),
			'page_header_portfolio'        => array(
				'title'       => esc_html__( 'Portfolio Page Header', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'capability'  => 'edit_theme_options',
				'panel'       => 'portfolio',
			),
			'single_portfolio'             => array(
				'title'       => esc_html__( 'Single Portfolio', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'panel'       => 'portfolio',
				'capability'  => 'edit_theme_options',
			),
			'page_header_single_portfolio' => array(
				'title'       => esc_html__( 'Single Page Header', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'capability'  => 'edit_theme_options',
				'panel'       => 'portfolio',
			),
			// Pages
			'pages_general'                => array(
				'title'       => esc_html__( 'General', 'unero' ),
				'description' => '',
				'priority'    => 20,
				'panel'       => 'pages',
				'capability'  => 'edit_theme_options',
			),
			'page_header_pages'            => array(
				'title'       => esc_html__( 'Page Header', 'unero' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'pages',
			),
			// homepage
			'homepage_general'             => array(
				'title'       => esc_html__( 'General', 'unero' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'homepage',
			),
			// Shop
			'catalog'                      => array(
				'title'       => esc_html__( 'General', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'page_header_shop'             => array(
				'title'       => esc_html__( 'Catalog Page Header', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'capability'  => 'edit_theme_options',
				'panel'       => 'woocommerce',
			),
			'shop_header'                  => array(
				'title'       => esc_html__( 'Shop Element', 'unero' ),
				'description' => '',
				'priority'    => 40,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'shop_toolbar'                 => array(
				'title'       => esc_html__( 'Catalog ToolBar', 'unero' ),
				'description' => '',
				'priority'    => 45,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'product_grid'                 => array(
				'title'       => esc_html__( 'Product Grid', 'unero' ),
				'description' => '',
				'priority'    => 70,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'shop_badge'                   => array(
				'title'       => esc_html__( 'Badges', 'unero' ),
				'description' => '',
				'priority'    => 80,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'single_product'               => array(
				'title'       => esc_html__( 'Single Product', 'unero' ),
				'description' => '',
				'priority'    => 90,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'footer'                       => array(
				'title'       => esc_html__( 'Footer', 'unero' ),
				'description' => '',
				'priority'    => 60,
				'capability'  => 'edit_theme_options',
			),
			'coming_soon_page'             => array(
				'priority'   => 90,
				'title'      => esc_html__( 'Coming Soon Page', 'unero' ),
				'capability' => 'edit_theme_options',
			),
		),

		'fields'   => array(

			// Back To Top
			'lazyload'                              => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Lazy Load', 'unero' ),
				'default'     => 1,
				'section'     => 'styling_general',
				'priority'    => 10,
				'description' => esc_html__( 'Check this to delay loading of images.', 'unero' ),
			),
			'preloader'                             => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Preloader', 'unero' ),
				'default'     => 1,
				'section'     => 'styling_general',
				'priority'    => 10,
				'description' => esc_html__( 'Display a preloader when page is loading.', 'unero' ),
			),
			'back_to_top'                           => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Back To Top', 'unero' ),
				'default'     => 0,
				'section'     => 'styling_general',
				'priority'    => 10,
				'description' => esc_html__( 'Check this to show back to top.', 'unero' ),
			),
			// Typography
			'theme_fonts'                           => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Theme Fonts', 'unero' ),
				'section'  => 'theme_fonts',
				'default'  => array( 'poppins', 'playfair' ),
				'priority' => 20,
				'choices'  => array(
					'poppins'  => esc_html__( 'Poppins', 'unero' ),
					'playfair' => esc_html__( 'Playfair Display', 'unero' ),
				),
			),
			'body_typo'                             => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Body', 'unero' ),
				'section'  => 'body_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Poppins',
					'variant'        => '400',
					'font-size'      => '14px',
					'line-height'    => '1.7',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'color'          => '#999',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => 'body',
					),
				),
			),
			'heading1_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 1', 'unero' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Poppins',
					'variant'        => '600',
					'font-size'      => '14px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => '.page .entry-content h1, .single .entry-content h1, .woocommerce div.product .woocommerce-tabs .panel h1',
					),
				),
			),
			'heading2_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 2', 'unero' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Poppins',
					'variant'        => '600',
					'font-size'      => '30px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => '.page .entry-content h2, .single .entry-content h2, .woocommerce div.product .woocommerce-tabs .panel h2',
					),
				),
			),
			'heading3_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 3', 'unero' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Poppins',
					'variant'        => '600',
					'font-size'      => '24px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => '.page .entry-content h3, .single .entry-content h3, .woocommerce div.product .woocommerce-tabs .panel h3',
					),
				),
			),
			'heading4_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 4', 'unero' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Poppins',
					'variant'        => '600',
					'font-size'      => '18px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => '.page .entry-content h4, single .entry-content h4, .woocommerce div.product .woocommerce-tabs .panel h4',
					),
				),
			),
			'heading5_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 5', 'unero' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Poppins',
					'variant'        => '600',
					'font-size'      => '14px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => '.page .entry-content h5, .single .entry-content h5, .woocommerce div.product .woocommerce-tabs .panel h5',
					),
				),
			),
			'heading6_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 6', 'unero' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Poppins',
					'variant'        => '600',
					'font-size'      => '12px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => '.page .entry-content h6, .single .entry-content h6, .woocommerce div.product .woocommerce-tabs .panel h6',
					),
				),
			),
			'page_header_typo'                      => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Page Header Title', 'unero' ),
				'section'  => 'page_header_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Poppins',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.page-header h1',
					),
				),
			),
			'swidget_title_typo'                    => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Widget Title', 'unero' ),
				'section'  => 'widget_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Poppins',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.widget .widget-title',
					),
				),
			),
			'footer_text_typo'                      => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Text', 'unero' ),
				'section'  => 'footer_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Poppins',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.site-footer',
					),
				),
			),
			// Header layout
			'header_layout'                         => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Header Layout', 'unero' ),
				'section'  => 'header',
				'default'  => '1',
				'priority' => 10,
				'choices'  => array(
					'1' => esc_html__( 'Header 1', 'unero' ),
					'2' => esc_html__( 'Header 2', 'unero' ),
					'3' => esc_html__( 'Header 3', 'unero' ),
					'4' => esc_html__( 'Header 4', 'unero' ),
				),
			),
			'header_transparent'                    => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Transparent', 'unero' ),
				'default'         => 0,
				'section'         => 'header',
				'priority'        => 10,
				'description'     => esc_html__( 'Check this to enable header transparent in homepage only.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( '1', '2' ),
					),
				),
			),
			'sticky_header'                         => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Sticky Header', 'unero' ),
				'default'  => 0,
				'section'  => 'header',
				'priority' => 10,
			),
			'header_full_width'                     => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Full Width', 'unero' ),
				'default'         => 0,
				'section'         => 'header',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'header_top_desc'                       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Header Top', 'unero' ),
				'section'         => 'header',
				'default'         => '',
				'priority'        => 20,
				'description'     => esc_html__( 'Enter the description to show on the top header', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => '3',
					),
				),
			),
			'menu_extras'                           => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extras', 'unero' ),
				'section'         => 'header',
				'default'         => array( 'search', 'account', 'cart', 'sidebar' ),
				'priority'        => 20,
				'choices'         => array(
					'search'   => esc_html__( 'Search', 'unero' ),
					'account'  => esc_html__( 'Account', 'unero' ),
					'cart'     => esc_html__( 'Cart', 'unero' ),
					'sidebar'  => esc_html__( 'Sidebar', 'unero' ),
					'wishlist' => esc_html__( 'WishList', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( '1', '2' ),
					),
				),
			),
			'menu_extras_2'                         => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extras', 'unero' ),
				'section'         => 'header',
				'default'         => array( 'search', 'account', 'cart', 'language', 'currency' ),
				'priority'        => 20,
				'choices'         => array(
					'search'   => esc_html__( 'Search', 'unero' ),
					'account'  => esc_html__( 'Account', 'unero' ),
					'cart'     => esc_html__( 'Cart', 'unero' ),
					'language' => esc_html__( 'Language', 'unero' ),
					'currency' => esc_html__( 'Currency', 'unero' ),
					'wishlist' => esc_html__( 'WishList', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( '3', '4' ),
					),
				),
			),
			'flag_symbol'                         => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Flag for currency selection', 'unero' ),
				'section'         => 'header',
				'default'         => 0,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( '3', '4' ),
					),
				),
			),
			'currency_flag_pos'                     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Currency Flag Position', 'unero' ),
				'section'         => 'header',
				'default'         => 'left',
				'priority'        => 20,
				'choices'         => array(
					'left'  => esc_html__( 'Left', 'unero' ),
					'right' => esc_html__( 'Right', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( '3', '4' ),
					),
					array(
						'setting'  => 'flag_symbol',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'user_logged_type'                      => array(
				'type'     => 'select',
				'label'    => esc_html__( 'User Logged In Type', 'unero' ),
				'section'  => 'header',
				'default'  => 'avatar',
				'priority' => 90,
				'choices'  => array(
					'icon'   => esc_html__( 'Icon', 'unero' ),
					'avatar' => esc_html__( 'Avatar', 'unero' ),
				),
			),
			'header_ajax_search'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'AJAX Search', 'unero' ),
				'section'     => 'header',
				'default'     => 1,
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to enable AJAX search in the header', 'unero' ),
			),
			'search_content_type'                   => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Search Content Type', 'unero' ),
				'section'  => 'header',
				'default'  => 'products',
				'priority' => 90,
				'choices'  => array(
					'all'      => esc_html__( 'All', 'unero' ),
					'products' => esc_html__( 'Only products', 'unero' ),
				),
			),
			'header_lang_type'                      => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Language Type', 'unero' ),
				'section'         => 'header',
				'default'         => 'code',
				'priority'        => 20,
				'choices'         => array(
					'code' => esc_html__( 'Code', 'unero' ),
					'tag'  => esc_html__( 'Tag', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( '3', '4' ),
					),
				),
			),
			'show_sidebar_text'                     => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Show Sidebar Text', 'unero' ),
				'default'         => 0,
				'section'         => 'header',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => '2',
					),
				),
			),
			'logo'                                  => array(
				'type'        => 'image',
				'label'       => esc_html__( 'Logo', 'unero' ),
				'description' => esc_html__( 'This logo is used for all site.', 'unero' ),
				'section'     => 'logo',
				'default'     => '',
				'priority'    => 20,
			),
			'logo_width'                            => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Logo Width(px)', 'unero' ),
				'section'  => 'logo',
				'priority' => 20,
				array(
					'setting'  => 'logo',
					'operator' => '!=',
					'value'    => '',
				),
			),
			'logo_height'                           => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Logo Height(px)', 'unero' ),
				'section'  => 'logo',
				'priority' => 20,
				array(
					'setting'  => 'logo',
					'operator' => '!=',
					'value'    => '',
				),
			),
			'logo_margins'                          => array(
				'type'     => 'spacing',
				'label'    => esc_html__( 'Logo Margin', 'unero' ),
				'section'  => 'logo',
				'priority' => 20,
				'default'  => array(
					'top'    => '0',
					'bottom' => '0',
					'left'   => '0',
					'right'  => '0',
				),
				array(
					'setting'  => 'logo',
					'operator' => '!=',
					'value'    => '',
				),
			),
			'logo_width_mobile'                     => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Max Width on Mobile(px)', 'unero' ),
				'section'  => 'logo',
				'priority' => 20,
				array(
					'setting'  => 'logo',
					'operator' => '!=',
					'value'    => '',
				),
			),
			'logo_width_sticky'                     => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Max Width in Sticky Header(px)', 'unero' ),
				'section'  => 'logo',
				'priority' => 20,
				array(
					'setting'  => 'logo',
					'operator' => '!=',
					'value'    => '',
				),
			),
			'menu_extras_mobile'                    => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Menu Extras On Mobile', 'unero' ),
				'section'  => 'header_mobile',
				'default'  => array( 'search', 'account', 'wishlist' ),
				'priority' => 20,
				'choices'  => array(
					'search'   => esc_html__( 'Search', 'unero' ),
					'account'  => esc_html__( 'Account', 'unero' ),
					'wishlist' => esc_html__( 'WishList', 'unero' ),
				),
			),
			'submenu_mobile'                        => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Open Submenus by', 'unero' ),
				'section'  => 'header_mobile',
				'default'  => 'menu',
				'priority' => 20,
				'choices'  => array(
					'menu' => esc_html__( 'Click on menu items', 'unero' ),
					'icon' => esc_html__( 'Click on menu icons', 'unero' ),
				),
			),
			// Page Header
			'page_header_site'                      => array(
				'type'        => 'toggle',
				'default'     => 1,
				'label'       => esc_html__( 'Enable Page Header', 'unero' ),
				'section'     => 'page_header_site',
				'description' => esc_html__( 'Enable to show a page header for whole site below the site header', 'unero' ),
				'priority'    => 20,
			),
			'page_header_layout_site'               => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Page Header Layout', 'unero' ),
				'section'         => 'page_header_site',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Layout 1', 'unero' ),
					'2' => esc_html__( 'Layout 2', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_site',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_site_parallax'             => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Parallax', 'unero' ),
				'section'         => 'page_header_site',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_site',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_site',
						'operator' => '==',
						'value'    => '2',
					),
				),
			),
			'page_header_background_site'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'unero' ),
				'section'         => 'page_header_site',
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_site',
						'operator' => '==',
						'value'    => '2',
					),
				),
			),
			'page_header_shop'                      => array(
				'type'        => 'toggle',
				'default'     => 1,
				'label'       => esc_html__( 'Enable Page Header', 'unero' ),
				'section'     => 'page_header_shop',
				'description' => esc_html__( 'Enable to show a page header for catalog page below the site header', 'unero' ),
				'priority'    => 20,
			),
			'page_header_layout_shop'               => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Page Header Layout', 'unero' ),
				'section'         => 'page_header_shop',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Layout 1', 'unero' ),
					'2' => esc_html__( 'Layout 2', 'unero' ),
					'3' => esc_html__( 'Layout 3', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'shop_header_transparent'               => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Transparent', 'unero' ),
				'default'         => 0,
				'section'         => 'page_header_shop',
				'priority'        => 20,
				'description'     => esc_html__( 'Check this to enable header transparent in the catalog. This option is used for header layout 1, 2', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => 'in',
						'value'    => array( '2', '3' ),
					),
				),
			),
			'page_header_shop_parallax'             => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Parallax', 'unero' ),
				'section'         => 'page_header_shop',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => 'in',
						'value'    => array( '2', '3' ),
					),
				),
			),
			'page_header_background_shop'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'unero' ),
				'section'         => 'page_header_shop',
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => '==',
						'value'    => '2',
					),
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_height_shop'               => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Height(px)', 'unero' ),
				'section'         => 'page_header_shop',
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => '==',
						'value'    => '2',
					),
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_slider_shop'               => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Sliders Content', 'unero' ),
				'section'         => 'page_header_shop',
				'default'         => '',
				'priority'        => 40,
				'row_label'       => array(
					'type'  => 'text',
					'value' => esc_html__( 'Slider', 'unero' ),
				),
				'fields'          => array(
					'title'     => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'Title', 'unero' ),
						'default' => '',
					),
					'subtitle'  => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'SubTitle', 'unero' ),
						'default' => '',
					),
					'image'     => array(
						'type'    => 'image',
						'label'   => esc_html__( 'Image', 'unero' ),
						'default' => '',
					),
					'video_url' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'MP4 Video URL', 'unero' ),
						'default' => '',
					),
					'link_url'  => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Link(URL)', 'unero' ),
						'default' => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => '==',
						'value'    => '3',
					),
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_slider_height'             => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Sliders Height(px)', 'unero' ),
				'default'         => 860,
				'section'         => 'page_header_shop',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => '==',
						'value'    => '3',
					),
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_slider_autoplay'           => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Sliders Autoplay', 'unero' ),
				'default'         => 0,
				'section'         => 'page_header_shop',
				'priority'        => 40,
				'description'     => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => '==',
						'value'    => '3',
					),
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			// Blog
			'blog_sidebar'                          => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Blog Sidebar', 'unero' ),
				'default'     => 'full-content',
				'section'     => 'blog',
				'priority'    => 10,
				'description' => esc_html__( 'Select default sidebar for blog page.', 'unero' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'No Sidebar', 'unero' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'unero' ),
					'content-sidebar' => esc_html__( 'Right Content', 'unero' ),
				),
			),
			'show_blog_cats'                        => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Categories List', 'unero' ),
				'section'     => 'blog',
				'default'     => 0,
				'description' => esc_html__( 'Display categories list below site header on blog, category page', 'unero' ),
				'priority'    => 20,
			),
			'blog_cats_number'                      => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Categories Number', 'unero' ),
				'section'         => 'blog',
				'description'     => esc_html__( 'Specify how many categories you want to show.', 'unero' ),
				'default'         => 4,
				'priority'        => 20,
				'choices'         => array(
					'min'  => 1,
					'max'  => 30,
					'step' => 1,
				),
				'active_callback' => array(
					array(
						'setting'  => 'show_blog_cats',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'blog_view'                             => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Blog View', 'unero' ),
				'section'  => 'blog',
				'default'  => 'list',
				'priority' => 20,
				'choices'  => array(
					'list'    => esc_html__( 'List', 'unero' ),
					'masonry' => esc_html__( 'Masonry', 'unero' ),
					'grid'    => esc_html__( 'Grid', 'unero' ),
				),
			),
			'blog_nav_type'                         => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Type of Navigation', 'unero' ),
				'section'  => 'blog',
				'default'  => 'links',
				'priority' => 20,
				'choices'  => array(
					'links'    => esc_html__( 'Links', 'unero' ),
					'infinite' => esc_html__( 'Infinite Scroll', 'unero' ),
				),
			),
			'excerpt_length'                        => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Excerpt Length', 'unero' ),
				'section'         => 'blog',
				'default'         => 30,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'blog_sidebar',
						'operator' => '==',
						'value'    => 'list',
					),
				),
			),
			'single_post_sidebar'                   => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Single Post Sidebar', 'unero' ),
				'default'     => 'full-content',
				'section'     => 'single_post',
				'priority'    => 10,
				'description' => esc_html__( 'Select default sidebar for single post.', 'unero' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'No Sidebar', 'unero' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'unero' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'unero' ),
				),
			),
			'post_share_box'                        => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Sharing Icons', 'unero' ),
				'section'     => 'single_post',
				'default'     => 1,
				'description' => esc_html__( 'Display social sharing icons on single post', 'unero' ),
				'priority'    => 20,
			),
			'post_social_icons'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Social Icons', 'unero' ),
				'section'         => 'single_post',
				'default'         => array( 'facebook', 'twitter', 'pinterest', 'google', 'linkedin', 'vkontakte' ),
				'priority'        => 60,
				'choices'         => array(
					'twitter'   => esc_html__( 'Twitter', 'unero' ),
					'facebook'  => esc_html__( 'Facebook', 'unero' ),
					'google'    => esc_html__( 'Google Plus', 'unero' ),
					'pinterest' => esc_html__( 'Pinterest', 'unero' ),
					'linkedin'  => esc_html__( 'Linkedin', 'unero' ),
					'vkontakte' => esc_html__( 'Vkontakte', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'post_share_box',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			//Portfolio
			'portfolio_layout'                      => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Portfolio Layout', 'unero' ),
				'section'  => 'portfolio',
				'default'  => 'masonry',
				'priority' => 20,
				'choices'  => array(
					'carousel' => esc_html__( 'Carousel', 'unero' ),
					'masonry'  => esc_html__( 'Masonry', 'unero' ),
				),
			),
			'portfolio_sidebar'                     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Portfolio Sidebar', 'unero' ),
				'default'         => 'full-content',
				'section'         => 'portfolio',
				'priority'        => 20,
				'choices'         => array(
					'full-content'    => esc_html__( 'No Sidebar', 'unero' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'unero' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_layout',
						'operator' => '==',
						'value'    => 'masonry',
					),
				),
			),
			'show_portfolio_cats'                   => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Categories List', 'unero' ),
				'section'     => 'portfolio',
				'default'     => 0,
				'description' => esc_html__( 'Display categories list below site header on portfolio, portfolio category page', 'unero' ),
				'priority'    => 20,
			),
			'portfolio_cats_number'                 => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Categories Number', 'unero' ),
				'section'         => 'portfolio',
				'description'     => esc_html__( 'Specify how many categories you want to show.', 'unero' ),
				'default'         => 4,
				'priority'        => 20,
				'choices'         => array(
					'min'  => 1,
					'max'  => 30,
					'step' => 1,
				),
				'active_callback' => array(
					array(
						'setting'  => 'show_portfolio_cats',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'portfolio_carousel_active_slide'       => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Active Slide', 'unero' ),
				'default'         => 2,
				'section'         => 'portfolio',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_layout',
						'operator' => '==',
						'value'    => 'carousel',
					),
				),
			),
			'portfolio_carousel_autoplay'           => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Sliders Autoplay', 'unero' ),
				'default'         => 0,
				'section'         => 'portfolio',
				'priority'        => 20,
				'description'     => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_layout',
						'operator' => '==',
						'value'    => 'carousel',
					),
				),
			),
			'portfolio_columns'                     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Portfolio Columns', 'unero' ),
				'section'         => 'portfolio',
				'default'         => 2,
				'priority'        => 20,
				'choices'         => array(
					2 => esc_html__( '2 Columns', 'unero' ),
					3 => esc_html__( '3 Columns', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_layout',
						'operator' => '==',
						'value'    => 'masonry',
					),
				),
			),
			'portfolio_per_page'                    => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Portfolio Numbers Per Page', 'unero' ),
				'section'     => 'portfolio',
				'default'     => 6,
				'description' => esc_html__( 'Specify how many portfolios you want to show on portfolio page', 'unero' ),
				'priority'    => 20,
			),
			'portfolio_nav_type'                    => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Type of Navigation', 'unero' ),
				'section'         => 'portfolio',
				'default'         => 'links',
				'priority'        => 20,
				'choices'         => array(
					'links'    => esc_html__( 'Links', 'unero' ),
					'infinite' => esc_html__( 'Infinite Scroll', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_layout',
						'operator' => '==',
						'value'    => 'masonry',
					),
				),
			),
			// Page Header Portfolio
			'page_header_portfolio'                 => array(
				'type'        => 'toggle',
				'default'     => 1,
				'label'       => esc_html__( 'Enable Page Header', 'unero' ),
				'section'     => 'page_header_portfolio',
				'description' => esc_html__( 'Enable to show a page header for portfolio page below the site header', 'unero' ),
				'priority'    => 20,
			),
			'page_header_layout_portfolio'          => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Page Header Layout', 'unero' ),
				'section'         => 'page_header_portfolio',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Layout 1', 'unero' ),
					'2' => esc_html__( 'Layout 2', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_portfolio_parallax'        => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Parallax', 'unero' ),
				'section'         => 'page_header_portfolio',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_portfolio',
						'operator' => 'in',
						'value'    => array( '2' ),
					),
				),
			),
			'page_header_slider_portfolio'          => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Sliders Content', 'unero' ),
				'section'         => 'page_header_portfolio',
				'default'         => '',
				'priority'        => 40,
				'row_label'       => array(
					'type'  => 'text',
					'value' => esc_html__( 'Slider', 'unero' ),
				),
				'fields'          => array(
					'title'    => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'Title', 'unero' ),
						'default' => '',
					),
					'subtitle' => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'SubTitle', 'unero' ),
						'default' => '',
					),
					'image'    => array(
						'type'    => 'image',
						'label'   => esc_html__( 'Image', 'unero' ),
						'default' => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_portfolio',
						'operator' => '==',
						'value'    => '2',
					),
					array(
						'setting'  => 'page_header_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_portfolio_slider_height'   => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Sliders Height(px)', 'unero' ),
				'default'         => 563,
				'section'         => 'page_header_portfolio',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_portfolio',
						'operator' => '==',
						'value'    => '2',
					),
					array(
						'setting'  => 'page_header_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_portfolio_slider_autoplay' => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Sliders Autoplay', 'unero' ),
				'default'         => 0,
				'section'         => 'page_header_portfolio',
				'priority'        => 40,
				'description'     => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_portfolio',
						'operator' => '==',
						'value'    => '2',
					),
					array(
						'setting'  => 'page_header_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'portfolio_share_box'                   => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Sharing Icons', 'unero' ),
				'section'     => 'single_portfolio',
				'default'     => 1,
				'description' => esc_html__( 'Display social sharing icons on single portfolio', 'unero' ),
				'priority'    => 20,
			),
			'portfolio_social_icons'                => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Social Icons', 'unero' ),
				'section'         => 'single_portfolio',
				'default'         => array( 'facebook', 'twitter', 'pinterest', 'google', 'linkedin', 'vkontakte' ),
				'priority'        => 20,
				'choices'         => array(
					'twitter'   => esc_html__( 'Twitter', 'unero' ),
					'facebook'  => esc_html__( 'Facebook', 'unero' ),
					'google'    => esc_html__( 'Google Plus', 'unero' ),
					'pinterest' => esc_html__( 'Pinterest', 'unero' ),
					'linkedin'  => esc_html__( 'Linkedin', 'unero' ),
					'vkontakte' => esc_html__( 'Vkontakte', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_share_box',
						'operator' => ' == ',
						'value'    => 1,
					),
				),
			),
			'portfolio_back_link'                   => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Portfolio Back Link', 'unero' ),
				'section'  => 'single_portfolio',
				'default'  => '',
				'priority' => 20,
			),
			// Page Header single Portfolio
			'page_header_single_portfolio'          => array(
				'type'        => 'toggle',
				'default'     => 1,
				'label'       => esc_html__( 'Enable Page Header', 'unero' ),
				'section'     => 'page_header_single_portfolio',
				'description' => esc_html__( 'Enable to show a page header for single portfolio page below the site header', 'unero' ),
				'priority'    => 20,
			),
			'page_header_layout_single_portfolio'   => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Page Header Layout', 'unero' ),
				'section'         => 'page_header_single_portfolio',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Layout 1', 'unero' ),
					'2' => esc_html__( 'Layout 2', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_single_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_single_portfolio_bg'       => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'unero' ),
				'section'         => 'page_header_single_portfolio',
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_single_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_single_portfolio',
						'operator' => 'in',
						'value'    => array( '2' ),
					),
				),
			),
			'page_header_single_portfolio_parallax' => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Parallax', 'unero' ),
				'section'         => 'page_header_single_portfolio',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_single_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_single_portfolio',
						'operator' => 'in',
						'value'    => array( '2' ),
					),
				),
			),
			// Catalog
			'catalog_ajax_filter'                   => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Ajax For Filtering', 'unero' ),
				'section'     => 'catalog',
				'description' => esc_html__( 'Check this option to use ajax for filtering in the catalog page.', 'unero' ),
				'default'     => 1,
				'priority'    => 70,
			),

			'catalog_layout'                        => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Catalog Layout', 'unero' ),
				'default'     => 'full-content',
				'section'     => 'catalog',
				'priority'    => 70,
				'description' => esc_html__( 'Select default layout for catalog.', 'unero' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'No Sidebar', 'unero' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'unero' ),
					'content-sidebar' => esc_html__( 'Right Content', 'unero' ),
					'board-content'   => esc_html__( 'Board Content', 'unero' ),
					'masonry-content' => esc_html__( 'Masonry Content', 'unero' ),
				),
			),
			'catalog_full_width'                    => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Catalog Full Width', 'unero' ),
				'section'         => 'catalog',
				'default'         => 0,
				'priority'        => 70,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => '==',
						'value'    => 'full-content',
					),
				),
			),
			'shop_view'                             => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Catalog View', 'unero' ),
				'section'         => 'catalog',
				'default'         => 'grid',
				'priority'        => 70,
				'choices'         => array(
					'grid' => esc_html__( 'Grid', 'unero' ),
					'list' => esc_html__( 'List', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
				),
			),
			'product_columns'                       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Product Columns Per Page', 'unero' ),
				'section'         => 'catalog',
				'default'         => '4',
				'priority'        => 80,
				'choices'         => array(
					'4' => esc_html__( '4 Columns', 'unero' ),
					'6' => esc_html__( '6 Columns', 'unero' ),
					'3' => esc_html__( '3 Columns', 'unero' ),
					'2' => esc_html__( '2 Columns', 'unero' ),
				),
				'description'     => esc_html__( 'Specify how many product columns you want to show on catalog page', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'shop_view',
						'operator' => '==',
						'value'    => 'grid',
					),
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
				),
			),
			'shop_expert_length'                    => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Product Expert Length', 'unero' ),
				'section'         => 'catalog',
				'default'         => 30,
				'priority'        => 80,
				'active_callback' => array(
					array(
						'setting'  => 'shop_view',
						'operator' => '==',
						'value'    => 'list',
					),
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
				),
			),
			'products_animation'                    => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Products Animation', 'unero' ),
				'section'         => 'catalog',
				'default'         => 0,
				'priority'        => 90,
				'description'     => esc_html__( 'Check this option to enable animation products on scroll in the catalog page.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'board-content', 'masonry-content' ),
					),
				),
			),
			'products_per_page'                     => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Product Numbers Per Page', 'unero' ),
				'section'     => 'catalog',
				'default'     => 12,
				'priority'    => 90,
				'description' => esc_html__( 'Specify how many products you want to show on catalog page', 'unero' ),
			),
			'shop_nav_type'                         => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Type of Navigation', 'unero' ),
				'section'  => 'catalog',
				'default'  => 'numbers',
				'priority' => 90,
				'choices'  => array(
					'numbers'  => esc_html__( 'Page Numbers', 'unero' ),
					'infinite' => esc_html__( 'Infinite Scroll', 'unero' ),
				),
			),
			// Categories Grid
			'shop_element'                          => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Shop Element', 'unero' ),
				'section'     => 'shop_header',
				'default'     => '0',
				'priority'    => 40,
				'choices'     => array(
					'0'                => esc_html__( 'Select an element', 'unero' ),
					'product_cats_box' => esc_html__( 'Product Categories Grid', 'unero' ),
					'shop_description' => esc_html__( 'Shop Description', 'unero' ),
				),
				'description' => esc_html__( 'Select element to show for shop page only below the page header.', 'unero' ),
			),
			'catalog_element_only'                  => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Use For Catalog Pages', 'unero' ),
				'section'     => 'shop_header',
				'default'     => 0,
				'priority'    => 40,
				'description' => esc_html__( 'Check this option to use this option for the catalog pages.', 'unero' ),
			),
			'shop_product_cats_box'                 => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Product Categories', 'unero' ),
				'section'         => 'shop_header',
				'default'         => '',
				'priority'        => 40,
				'row_label'       => array(
					'type'  => 'text',
					'value' => esc_html__( 'Product Category', 'unero' ),
				),
				'fields'          => array(
					'heading' => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'Category Heading', 'unero' ),
						'default' => '',
					),
					'slug'    => array(
						'type'        => 'select',
						'label'       => esc_html__( 'Category Slug', 'unero' ),
						'description' => esc_html__( 'Select product category you want to show.', 'unero' ),
						'default'     => '',
						'choices'     => unero_customizer_get_categories( 'product_cat', true ),
					),
					'image'   => array(
						'type'    => 'image',
						'label'   => esc_html__( 'Category Image', 'unero' ),
						'default' => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'shop_element',
						'operator' => '==',
						'value'    => 'product_cats_box',
					),
				),
			),

			'shop_description'                      => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Shop Description', 'unero' ),
				'section'         => 'shop_header',
				'priority'        => 40,
				'description'     => esc_html__( 'Enter the description to show on the top shop page only.', 'unero' ),
				'row_label'       => array(
					'type'  => 'text',
					'value' => esc_html__( 'Shop Description', 'unero' ),
				),
				'default'         => array(
					array(
						'style' => 1,
						'title' => '',
						'desc'  => '',
					),
				),
				'fields'          => array(
					'style' => array(
						'type'    => 'radio',
						'label'   => esc_html__( 'Style', 'unero' ),
						'default' => 1,
						'choices' => array(
							1 => esc_html__( 'Style 1', 'unero' ),
							2 => esc_html__( 'Style 2', 'unero' ),
						),
					),
					'title' => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'Title', 'unero' ),
						'default' => '',
					),
					'desc'  => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'Description', 'unero' ),
						'default' => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'shop_element',
						'operator' => '==',
						'value'    => 'shop_description',
					),
				),
			),
			//Shop ToolBar
			'shop_toolbar'                          => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show ToolBar', 'unero' ),
				'section'     => 'shop_toolbar',
				'default'     => 1,
				'priority'    => 40,
				'description' => esc_html__( 'Check this option to show toolbar on top of the catalog page.', 'unero' ),
			),
			'shop_toolbar_layout'                   => array(
				'type'            => 'select',
				'label'           => esc_html__( 'ToolBar Layout', 'unero' ),
				'section'         => 'shop_toolbar',
				'default'         => 1,
				'priority'        => 40,
				'choices'         => array(
					1 => esc_html__( 'Layout 1', 'unero' ),
					2 => esc_html__( 'Layout 2', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
				),
				'description'     => esc_html__( 'Select layout you want to show.', 'unero' ),
			),
			'shop_toolbar_els1'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'ToolBar Elements', 'unero' ),
				'section'         => 'shop_toolbar',
				'default'         => array( 'categories', 'filters', 'view' ),
				'priority'        => 40,
				'choices'         => array(
					'categories' => esc_html__( 'Categories', 'unero' ),
					'filters'    => esc_html__( 'Filters', 'unero' ),
					'view'       => esc_html__( 'View', 'unero' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'shop_toolbar_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
				),
			),
			'shop_cats_slug1'                       => array(
				'type'            => 'select',
				'section'         => 'shop_toolbar',
				'label'           => esc_html__( 'Custom Categories', 'unero' ),
				'description'     => esc_html__( 'Select product categories you want to show.', 'unero' ),
				'default'         => '',
				'multiple'        => 999,
				'priority'        => 40,
				'choices'         => unero_customizer_get_categories( 'product_cat' ),
				'active_callback' => array(
					array(
						'setting'  => 'shop_toolbar_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
					array(
						'setting'  => 'shop_toolbar_els1',
						'operator' => 'contains',
						'value'    => 'categories',
					),
				),
			),
			'shop_cats_order_1'                     => array(
				'type'            => 'select',
				'section'         => 'shop_toolbar',
				'label'           => esc_html__( 'Categories Order', 'unero' ),
				'default'         => 'order',
				'priority'        => 40,
				'choices'         => array(
					'order' => esc_html__( 'Category order', 'unero' ),
					'title' => esc_html__( 'Name', 'unero' ),
					'count' => esc_html__( 'Count', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'shop_toolbar_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
					array(
						'setting'  => 'shop_toolbar_els1',
						'operator' => 'contains',
						'value'    => 'categories',
					),
				),
			),
			'shop_toolbar_els2'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'ToolBar Elements', 'unero' ),
				'section'         => 'shop_toolbar',
				'default'         => array( 'found', 'sort_by', 'filters', 'view' ),
				'priority'        => 40,
				'choices'         => array(
					'found'   => esc_html__( 'Products Found', 'unero' ),
					'sort_by' => esc_html__( 'Sort By', 'unero' ),
					'filters' => esc_html__( 'Filters', 'unero' ),
					'view'    => esc_html__( 'View', 'unero' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'shop_toolbar_layout',
						'operator' => '==',
						'value'    => 2,
					),
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
				),
			),
			'shop_toolbar_els3'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'ToolBar Elements', 'unero' ),
				'section'         => 'shop_toolbar',
				'default'         => array( 'categories', 'filters' ),
				'priority'        => 40,
				'choices'         => array(
					'categories' => esc_html__( 'Categories', 'unero' ),
					'filters'    => esc_html__( 'Filters', 'unero' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'board-content', 'masonry-content' ),
					),
				),
			),
			'shop_cats_slug3'                       => array(
				'type'            => 'select',
				'section'         => 'shop_toolbar',
				'label'           => esc_html__( 'Custom Categories', 'unero' ),
				'description'     => esc_html__( 'Select product categories you want to show.', 'unero' ),
				'default'         => '',
				'multiple'        => 999,
				'priority'        => 40,
				'choices'         => unero_customizer_get_categories( 'product_cat' ),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'board-content', 'masonry-content' ),
					),
					array(
						'setting'  => 'shop_toolbar_els3',
						'operator' => 'contains',
						'value'    => 'categories',
					),
				),
			),
			'shop_cats_order_3'                     => array(
				'type'            => 'select',
				'section'         => 'shop_toolbar',
				'label'           => esc_html__( 'Categories Order', 'unero' ),
				'default'         => 'order',
				'priority'        => 40,
				'choices'         => array(
					'order' => esc_html__( 'Category order', 'unero' ),
					'title' => esc_html__( 'Name', 'unero' ),
					'count' => esc_html__( 'Count', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'board-content', 'masonry-content' ),
					),
					array(
						'setting'  => 'shop_toolbar_els3',
						'operator' => 'contains',
						'value'    => 'categories',
					),
				),
			),
			'shop_filter_widget_columns'            => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Filter Widget Columns', 'unero' ),
				'section'  => 'shop_toolbar',
				'default'  => '5',
				'priority' => 40,
				'choices'  => array(
					'5' => esc_html__( '5 columns', 'unero' ),
					'4' => esc_html__( '4 columns', 'unero' ),
					'3' => esc_html__( '3 columns', 'unero' ),
				),
			),
			// Product Grid
			'product_grid_layout'                   => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Product Grid Layout', 'unero' ),
				'section'  => 'product_grid',
				'default'  => '1',
				'priority' => 20,
				'choices'  => array(
					'1' => esc_html__( 'Layout 1', 'unero' ),
					'2' => esc_html__( 'Layout 2', 'unero' ),
				),
			),
			'open_cart_custom'                      => array(
				'type'     => 'custom',
				'label'    => esc_html__( 'Add to cart behaviour', 'unero' ),
				'section'  => 'product_grid',
				'priority' => 20,
			),
			'open_cart_mini'                        => array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Open the cart mini after successful addition', 'unero' ),
				'section'     => 'product_grid',
				'default'     => 1,
				'description' => esc_html__( 'This option only works when enable AJAX add to cart buttons.', 'unero' ),
				'priority'    => 20,
			),
			'disable_secondary_thumb'               => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Disable Secondary Product Thumbnail', 'unero' ),
				'section'     => 'product_grid',
				'default'     => 0,
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to disable secondary product thumbnail when hover over the main product image.', 'unero' ),
			),
			'product_quick_view'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Quick View', 'unero' ),
				'section'     => 'product_grid',
				'default'     => 1,
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to enable the quick view in every product.', 'unero' ),
			),
			'product_quick_view_method'             => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Quick View Method', 'unero' ),
				'section'  => 'product_grid',
				'default'  => '1',
				'priority' => 20,
				'choices'  => array(
					'1' => esc_html__( 'Method 1', 'unero' ),
					'2' => esc_html__( 'Method 2', 'unero' ),

				),
			),
			'product_attribute'                     => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Attribute', 'unero' ),
				'section'     => 'product_grid',
				'default'     => 'none',
				'priority'    => 20,
				'choices'     => unero_product_attributes(),
				'description' => esc_html__( 'Show product attribute for each item listed under the item name.', 'unero' ),
			),
			'product_columns_mobile'                => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Columns on Mobile', 'unero' ),
				'section'     => 'product_grid',
				'default'     => '2',
				'priority'    => 20,
				'choices'     => array(
					'2' => esc_html__( '2 Columns', 'unero' ),
					'1' => esc_html__( '1 Column', 'unero' ),

				),
				'description' => esc_html__( 'Select product columns you want to show on mobile', 'unero' ),
			),
			'product_icons_mobile'                  => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Icons on Mobile', 'unero' ),
				'section'     => 'product_grid',
				'default'     => 0,
				'description' => esc_html__( 'Check this option to show the quick view and add to cart on mobile.', 'unero' ),
				'priority'    => 20,
			),
			'tooltips'                              => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'ToolTips', 'unero' ),
				'section'     => 'product_grid',
				'default'     => 1,
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to show the tooltips for quick view, add to cart and wishlist.', 'unero' ),
			),
			//Badge
			'show_badges'                           => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Badges', 'unero' ),
				'section'     => 'shop_badge',
				'default'     => 1,
				'priority'    => 20,
				'description' => esc_html__( 'Check this to show badges on every products.', 'unero' ),
			),
			'badges'                                => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Badges', 'unero' ),
				'section'         => 'shop_badge',
				'default'         => array( 'hot', 'new', 'sale', 'outofstock' ),
				'priority'        => 20,
				'choices'         => array(
					'hot'        => esc_html__( 'Hot', 'unero' ),
					'new'        => esc_html__( 'New', 'unero' ),
					'sale'       => esc_html__( 'Sale', 'unero' ),
					'outofstock' => esc_html__( 'Out Of Stock', 'unero' ),
				),
				'description'     => esc_html__( 'Select which badges you want to show', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'hot_text'                              => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Custom Hot Text', 'unero' ),
				'section'         => 'shop_badge',
				'default'         => 'Hot',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'badges',
						'operator' => 'contains',
						'value'    => 'hot',
					),
				),
			),
			'outofstock_text'                       => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Custom Out Of Stock Text', 'unero' ),
				'section'         => 'shop_badge',
				'default'         => 'Out Of Stock',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'badges',
						'operator' => 'contains',
						'value'    => 'outofstock',
					),
				),
			),
			'new_text'                              => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Custom New Text', 'unero' ),
				'section'         => 'shop_badge',
				'default'         => 'New',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'badges',
						'operator' => 'contains',
						'value'    => 'new',
					),
				),
			),
			'product_newness'                       => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Product Newness', 'unero' ),
				'section'         => 'shop_badge',
				'default'         => 3,
				'priority'        => 20,
				'description'     => esc_html__( 'Display the "New" badge for how many days?', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'badges',
						'operator' => 'contains',
						'value'    => 'new',
					),
				),
			),
			// Single Product
			'product_page_layout'                   => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Product Page Layout', 'unero' ),
				'section'  => 'single_product',
				'default'  => '1',
				'priority' => 20,
				'choices'  => array(
					'1' => esc_html__( 'Default', 'unero' ),
					'2' => esc_html__( 'Full Screen', 'unero' ),
					'3' => esc_html__( 'Sticky Info', 'unero' ),
					'4' => esc_html__( 'Left Sidebar', 'unero' ),
					'5' => esc_html__( 'Right Sidebar', 'unero' ),
					'6' => esc_html__( 'Carousel', 'unero' ),
				),
			),
			'product_page_no_bg'                    => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Product Page No Background', 'unero' ),
				'section'         => 'single_product',
				'default'         => 0,
				'priority'        => 20,
				'description'     => esc_html__( 'Check this option to disable background in the product page.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'product_breadcrumb'                    => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Breadcrumb', 'unero' ),
				'section'         => 'single_product',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4', '5' ),
					),
				),
			),
			'product_navigation'                    => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Navigation', 'unero' ),
				'section'         => 'single_product',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '4', '5' ),
					),
				),
			),
			'product_add_to_cart_ajax'              => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'AJAX add to cart button', 'unero' ),
				'section'     => 'single_product',
				'default'     => 1,
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to enable AJAX add to cart button in the product page.', 'unero' ),
			),
			'product_open_cart_custom'              => array(
				'type'            => 'custom',
				'label'           => esc_html__( 'Add to cart behaviour', 'unero' ),
				'section'         => 'single_product',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'product_add_to_cart_ajax',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'product_open_cart_mini'                => array(
				'type'            => 'checkbox',
				'label'           => esc_html__( 'Open the cart mini after successful addition', 'unero' ),
				'section'         => 'single_product',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'product_add_to_cart_ajax',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'product_zoom'                          => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Product Zoom', 'unero' ),
				'section'         => 'single_product',
				'default'         => 0,
				'description'     => esc_html__( 'Check this option to show a bigger size product image on mouseover', 'unero' ),
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4', '5' ),
					),
				),
			),
			'product_zoom_mobile'                   => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Product Zoom On Mobile', 'unero' ),
				'section'         => 'single_product',
				'default'         => 0,
				'description'     => esc_html__( 'Check this option to show a bigger size product image on mouseover on mobile.', 'unero' ),
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4', '5' ),
					),
				),
			),
			'product_images_lightbox'               => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Images Gallery', 'unero' ),
				'section'     => 'single_product',
				'default'     => 1,
				'description' => esc_html__( 'Check this option to open product gallery images in a lightbox', 'unero' ),
				'priority'    => 20,
			),
			'show_product_socials'                  => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Product Socials', 'unero' ),
				'section'  => 'single_product',
				'default'  => 1,
				'priority' => 40,
			),
			'product_social_icons'                  => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Social Icons', 'unero' ),
				'section'         => 'single_product',
				'default'         => array( 'twitter', 'facebook', 'google', 'pinterest', 'linkedin', 'vkontakte' ),
				'priority'        => 40,
				'choices'         => array(
					'twitter'   => esc_html__( 'Twitter', 'unero' ),
					'facebook'  => esc_html__( 'Facebook', 'unero' ),
					'google'    => esc_html__( 'Google Plus', 'unero' ),
					'pinterest' => esc_html__( 'Pinterest', 'unero' ),
					'linkedin'  => esc_html__( 'Linkedin', 'unero' ),
					'vkontakte' => esc_html__( 'Vkontakte', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'show_product_socials',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'custom_product_tab_1'                  => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Custom Product Tab 1', 'unero' ),
				'section'     => 'single_product',
				'default'     => esc_html__( 'Size Guide', 'unero' ),
				'priority'    => 40,
				'description' => esc_html__( 'Enter the text for custom product tab 1', 'unero' ),
			),
			'custom_product_tab_2'                  => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Custom Product Tab 2', 'unero' ),
				'section'     => 'single_product',
				'default'     => esc_html__( 'Shipping', 'unero' ),
				'priority'    => 40,
				'description' => esc_html__( 'Enter the text for custom product tab 2', 'unero' ),
			),
			'show_product_meta'                     => array(
				'type'        => 'multicheck',
				'label'       => esc_html__( 'Show Product Meta', 'unero' ),
				'section'     => 'single_product',
				'default'     => array( 'sku', 'categories', 'tags' ),
				'priority'    => 40,
				'choices'     => array(
					'sku'        => esc_html__( 'SKU', 'unero' ),
					'categories' => esc_html__( 'Categories', 'unero' ),
					'tags'       => esc_html__( 'Tags', 'unero' ),
				),
				'description' => esc_html__( 'Select which product meta you want to show in single product page', 'unero' ),
			),
			'product_instagram'                     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Instagram Photos', 'unero' ),
				'section'     => 'single_product',
				'default'     => 1,
				'priority'    => 40,
				'description' => esc_html__( 'Check this option to show instagram photos in single product page', 'unero' ),
			),
			'product_instagram_title'               => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Product Instagram Title', 'unero' ),
				'section'         => 'single_product',
				'default'         => esc_html__( 'See It Styled On Instagram', 'unero' ),
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'product_instagram',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'product_instagram_columns'             => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Instagram Photos Columns', 'unero' ),
				'section'     => 'single_product',
				'default'     => '5',
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many columns of Instagram Photos you want to show on single product page', 'unero' ),
				'choices'     => array(
					'3' => esc_html__( '3 Columns', 'unero' ),
					'4' => esc_html__( '4 Columns', 'unero' ),
					'5' => esc_html__( '5 Columns', 'unero' ),
					'6' => esc_html__( '6 Columns', 'unero' ),
					'7' => esc_html__( '7 Columns', 'unero' ),
				),
			),
			'product_instagram_numbers'             => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Instagram Photos Numbers', 'unero' ),
				'section'         => 'single_product',
				'default'         => 10,
				'priority'        => 40,
				'description'     => esc_html__( 'Specify how many Instagram Photos you want to show on single product page.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'product_instagram',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'product_instagram_image_size'          => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Instagram Image Size', 'unero' ),
				'section'  => 'single_product',
				'default'  => 'low_resolution',
				'priority' => 40,
				'choices'  => array(
					'low_resolution'      => esc_html__( 'Low', 'unero' ),
					'thumbnail'           => esc_html__( 'Thumbnail', 'unero' ),
					'standard_resolution' => esc_html__( 'Standard', 'unero' ),
				),
			),
			'product_upsells_custom'                => array(
				'type'     => 'custom',
				'section'  => 'single_product',
				'default'  => '<hr>',
				'priority' => 40,
			),
			'product_upsells'                       => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Up-sells Products', 'unero' ),
				'section'  => 'single_product',
				'default'  => 1,
				'priority' => 40,
			),
			'upsells_products_columns'              => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Up-sells Products Columns', 'unero' ),
				'section'         => 'single_product',
				'default'         => '4',
				'priority'        => 40,
				'description'     => esc_html__( 'Specify how many columns of up-sells products you want to show on single product page', 'unero' ),
				'choices'         => array(
					'3' => esc_html__( '3 Columns', 'unero' ),
					'4' => esc_html__( '4 Columns', 'unero' ),
					'5' => esc_html__( '5 Columns', 'unero' ),
					'6' => esc_html__( '6 Columns', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
				),
			),
			'upsells_products_numbers'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Up-sells Products Numbers', 'unero' ),
				'section'     => 'single_product',
				'default'     => 6,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many numbers of up-sells products you want to show on single product page', 'unero' ),
			),
			'product_related_custom'                => array(
				'type'     => 'custom',
				'section'  => 'single_product',
				'default'  => '<hr>',
				'priority' => 40,
			),
			'product_related'                       => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Related Products', 'unero' ),
				'section'  => 'single_product',
				'default'  => 1,
				'priority' => 40,
			),
			'related_products_columns'              => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Related Products Columns', 'unero' ),
				'section'         => 'single_product',
				'default'         => '4',
				'priority'        => 40,
				'description'     => esc_html__( 'Specify how many columns of related products you want to show on single product page', 'unero' ),
				'choices'         => array(
					'3' => esc_html__( '3 Columns', 'unero' ),
					'4' => esc_html__( '4 Columns', 'unero' ),
					'5' => esc_html__( '5 Columns', 'unero' ),
					'6' => esc_html__( '6 Columns', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_layout',
						'operator' => 'in',
						'value'    => array( 'full-content', 'sidebar-content', 'content-sidebar' ),
					),
				),
			),
			'related_products_numbers'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Related Products Numbers', 'unero' ),
				'section'     => 'single_product',
				'default'     => 6,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many numbers of related products you want to show on single product page', 'unero' ),
			),
			// Instagram
			'unero_instagram_token'                 => array(
				'type'        => 'textarea',
				'label'       => esc_html__( 'Access Token', 'unero' ),
				'section'     => 'instagram',
				'default'     => '',
				'priority'    => 40,
				'description' => esc_html__( 'Enter your Access Token', 'unero' ),
			),
			// Pages
			'pages_sidebar'                         => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Pages Sidebar', 'unero' ),
				'default'     => 'full-content',
				'section'     => 'pages_general',
				'priority'    => 10,
				'description' => esc_html__( 'Select default sidebar for blog page.', 'unero' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'No Sidebar', 'unero' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'unero' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'unero' ),
				),
			),
			'page_header_pages'                     => array(
				'type'        => 'toggle',
				'default'     => 1,
				'label'       => esc_html__( 'Enable Page Header', 'unero' ),
				'section'     => 'page_header_pages',
				'description' => esc_html__( 'Enable to show a page header for pages below the site header', 'unero' ),
				'priority'    => 20,
			),
			'page_header_layout_pages'              => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Page Header Layout', 'unero' ),
				'section'         => 'page_header_pages',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Layout 1', 'unero' ),
					'2' => esc_html__( 'Layout 2', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_pages',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_page_parallax'             => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Parallax', 'unero' ),
				'section'         => 'page_header_pages',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_pages',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_pages',
						'operator' => '==',
						'value'    => '2',
					),
				),
			),
			'page_header_background_pages'          => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'unero' ),
				'section'         => 'page_header_pages',
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_pages',
						'operator' => '==',
						'value'    => '2',
					),
				),
			),
			// Footer
			'footer_layout'                         => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Footer Layout', 'unero' ),
				'section'  => 'footer',
				'default'  => '1',
				'priority' => 40,
				'choices'  => array(
					'1' => esc_html__( 'Footer 1', 'unero' ),
					'2' => esc_html__( 'Footer 2', 'unero' ),
					'3' => esc_html__( 'Footer 3', 'unero' ),
					'4' => esc_html__( 'Footer 4', 'unero' ),
					'5' => esc_html__( 'Footer 5', 'unero' ),
					'6' => esc_html__( 'Footer 6', 'unero' ),
				),
			),
			'footer_widget_columns'                 => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Footer Columns', 'unero' ),
				'section'         => 'footer',
				'default'         => '5',
				'description'     => esc_html__( 'Go to Appearance - Widgets - Footer 1, 2, 3, 4, 5, 6 to add widgets content.', 'unero' ),
				'priority'        => 40,
				'choices'         => array(
					'4' => esc_html__( '4 Columns', 'unero' ),
					'3' => esc_html__( '3 Columns', 'unero' ),
					'5' => esc_html__( '5 Columns', 'unero' ),
					'6' => esc_html__( '6 Columns', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '6' ),
					),
				),

			),
			'footer_skin'                           => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Footer Skin', 'unero' ),
				'section'  => 'footer',
				'default'  => 'light',
				'priority' => 40,
				'choices'  => array(
					'light' => esc_html__( 'Light', 'unero' ),
					'gray'  => esc_html__( 'Gray', 'unero' ),
				),
			),
			'footer_logo_custom'                    => array(
				'type'            => 'custom',
				'section'         => 'footer',
				'default'         => '<hr>',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4' ),
					),
				),
			),
			'footer_logo'                           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Footer Logo', 'unero' ),
				'section'         => 'footer',
				'default'         => '',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4' ),
					),
				),
			),
			'footer_news_letter_custom'             => array(
				'type'            => 'custom',
				'section'         => 'footer',
				'default'         => '<hr>',
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1' ),
					),
				),
			),
			'footer_news_letter'                    => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Footer NewsLetter', 'unero' ),
				'description'     => sprintf( wp_kses_post( 'Please go to <a href="%s">MailChimp Forms</a> to get shortcode.', 'unero' ), admin_url( 'admin.php?page=mailchimp-for-wp-forms' ) ),
				'section'         => 'footer',
				'default'         => '',
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1' ),
					),
				),
			),
			'footer_copyright_custom'               => array(
				'type'            => 'custom',
				'section'         => 'footer',
				'default'         => '<hr>',
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4', '5' ),
					),
				),
			),
			'footer_copyright'                      => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Footer Copyright', 'unero' ),
				'description'     => esc_html__( 'Shortcodes are allowed', 'unero' ),
				'section'         => 'footer',
				'default'         => esc_html__( 'Copyright &copy; 2017', 'unero' ),
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4', '5' ),
					),
				),
			),
			'footer_menu_custom'                    => array(
				'type'            => 'custom',
				'section'         => 'footer',
				'default'         => '<hr>',
				'priority'        => 60,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '3', '4' ),
					),
				),
			),
			'footer_menu_1'                         => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Footer Menu 1', 'unero' ),
				'section'         => 'footer',
				'priority'        => 60,
				'default'         => '',
				'choices'         => unero_customizer_get_nav_menus(),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '3', '4' ),
					),
				),
			),
			'footer_menu_2'                         => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Footer Menu 2', 'unero' ),
				'section'         => 'footer',
				'priority'        => 60,
				'default'         => '',
				'choices'         => unero_customizer_get_nav_menus(),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '4' ),
					),
				),
			),
			'footer_socials_custom'                 => array(
				'type'            => 'custom',
				'section'         => 'footer',
				'default'         => '<hr>',
				'priority'        => 60,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4', '5' ),
					),
				),
			),
			'footer_socials_label'                  => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Footer Socials Label', 'unero' ),
				'section'         => 'footer',
				'default'         => esc_html__( 'Follow Us On Social', 'unero' ),
				'priority'        => 60,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '3', '4', '5' ),
					),
				),
			),
			'footer_socials'                        => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Socials', 'unero' ),
				'section'         => 'footer',
				'priority'        => 60,
				'default'         => array(
					array(
						'link_url' => 'https://facebook.com/unero',
					),
					array(
						'link_url' => 'https://twitter.com/unero',
					),
					array(
						'link_url' => 'https://plus.google.com/unero',
					),
				),
				'fields'          => array(
					'link_url' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Social URL', 'unero' ),
						'description' => esc_html__( 'Enter the URL for this social', 'unero' ),
						'default'     => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4', '5' ),
					),
				),
			),

			// Coming Soon
			'coming_soon_logo'                      => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Logo', 'unero' ),
				'section'  => 'coming_soon_page',
				'priority' => 60,
				'default'  => '',
			),
			'coming_soon_bg_image'                  => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Bacground Image', 'unero' ),
				'section'  => 'coming_soon_page',
				'priority' => 60,
				'default'  => '',
			),
			'coming_soon_title'                     => array(
				'type'      => 'textarea',
				'label'     => esc_html__( 'Title', 'unero' ),
				'section'   => 'coming_soon_page',
				'priority'  => 60,
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.un-coming-soon-content .c-title',
						'function' => 'html',
					),
				),
			),
			'coming_soon_desc'                      => array(
				'type'      => 'textarea',
				'label'     => esc_html__( 'Description', 'unero' ),
				'section'   => 'coming_soon_page',
				'priority'  => 60,
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.un-coming-soon-content .c-desc',
						'function' => 'html',
					),
				),
			),
			'coming_soon_countdown_text'            => array(
				'type'      => 'textarea',
				'label'     => esc_html__( 'Count Down Text', 'unero' ),
				'section'   => 'coming_soon_page',
				'priority'  => 60,
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.un-coming-soon-content .countdown-text',
						'function' => 'html',
					),
				),
			),
			'coming_soon_countdown_date'            => array(
				'type'        => 'text',
				'label'       => esc_html__( 'CountDown Date', 'unero' ),
				'section'     => 'coming_soon_page',
				'priority'    => 60,
				'default'     => '',
				'description' => esc_html__( 'Enter the date by format: YYYY/MM/DD', 'unero' ),
			),
			'coming_soon_socials_text'              => array(
				'type'      => 'textarea',
				'label'     => esc_html__( 'Social Text', 'unero' ),
				'section'   => 'coming_soon_page',
				'priority'  => 60,
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.un-coming-soon-content .socials label',
						'function' => 'html',
					),
				),
			),
			'coming_soon_socials'                   => array(
				'type'     => 'repeater',
				'label'    => esc_html__( 'Socials', 'unero' ),
				'section'  => 'coming_soon_page',
				'priority' => 60,
				'default'  => array(
					array(
						'link_url' => 'https://facebook.com/unero',
					),
					array(
						'link_url' => 'https://twitter.com/unero',
					),
					array(
						'link_url' => 'https://plus.google.com/unero',
					),
				),
				'fields'   => array(
					'link_url' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Social URL', 'unero' ),
						'description' => esc_html__( 'Enter the URL for this social', 'unero' ),
						'default'     => '',
					),
				),
			),
			// image size
			'image_sizes_default'                   => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Image Sizes', 'unero' ),
				'default'  => array(
					'blog_large',
					'blog_normal',
					'blog_masonry',
					'blog_grid',
					'post_normal',
					'categories_grid',
					'shop_masonry',
					'portfolio_masonry',
					'portfolio_carousel',
				),
				'section'  => 'image_sizes',
				'priority' => 20,
				'choices'  => array(
					'blog_large'         => esc_attr__( 'Blog List - No Sidebar', 'unero' ),
					'blog_normal'        => esc_attr__( 'Blog List - With Sidebar', 'unero' ),
					'blog_masonry'       => esc_attr__( 'Blog Masonry', 'unero' ),
					'blog_grid'          => esc_attr__( 'Blog Grid', 'unero' ),
					'post_normal'        => esc_attr__( 'Section Post element', 'unero' ),
					'categories_grid'    => esc_attr__( 'Categories Grid element in shop and homepage', 'unero' ),
					'shop_masonry'       => esc_attr__( 'Shop Masonry', 'unero' ),
					'portfolio_masonry'  => esc_attr__( 'Portfolio Masonry', 'unero' ),
					'portfolio_carousel' => esc_attr__( 'Portfolio Carousel', 'unero' ),
				),
			),
			// Boxed
			'enable_boxed_layout'                   => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Boxed Layout', 'unero' ),
				'section'     => 'boxed_layout',
				'priority'    => 60,
				'default'     => '',
				'description' => esc_html__( 'Check this to show boxed layout for only homepage.', 'unero' ),
			),
			'boxed_layout'                          => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Boxed Layout', 'unero' ),
				'section'  => 'boxed_layout',
				'priority' => 60,
				'default'  => 1,
				'choices'  => array(
					1 => esc_html__( 'Layout 1', 'unero' ),
					2 => esc_html__( 'Layout 2', 'unero' ),
				),
			),
			'boxed_header_bg_transparent'           => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Background Transparent', 'unero' ),
				'section'         => 'boxed_layout',
				'priority'        => 60,
				'default'         => 0,
				'description'     => esc_html__( 'Check this option to enable header background transparent for only homepage.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_footer_bg_transparent'           => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Footer Background Transparent', 'unero' ),
				'section'         => 'boxed_layout',
				'priority'        => 60,
				'default'         => 0,
				'description'     => esc_html__( 'Check this option to enable footer background transparent for only homepage.', 'unero' ),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),

			),
			'boxed_background_color'                => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Color', 'unero' ),
				'default'  => '',
				'section'  => 'boxed_layout',
				'priority' => 60,
			),
			'boxed_background_image'                => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'unero' ),
				'default'         => '',
				'section'         => 'boxed_layout',
				'priority'        => 60,
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_horizontal'           => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Horizontal', 'unero' ),
				'default'         => 'left',
				'section'         => 'boxed_layout',
				'priority'        => 60,
				'choices'         => array(
					'left'   => esc_html__( 'Left', 'unero' ),
					'right'  => esc_html__( 'Right', 'unero' ),
					'center' => esc_html__( 'Center', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_vertical'             => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Vertical', 'unero' ),
				'default'         => 'top',
				'section'         => 'boxed_layout',
				'priority'        => 60,
				'choices'         => array(
					'top'    => esc_html__( 'Top', 'unero' ),
					'center' => esc_html__( 'Center', 'unero' ),
					'bottom' => esc_html__( 'Bottom', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_repeats'              => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Repeat', 'unero' ),
				'default'         => 'repeat',
				'section'         => 'boxed_layout',
				'priority'        => 60,
				'choices'         => array(
					'repeat'    => esc_html__( 'Repeat', 'unero' ),
					'repeat-x'  => esc_html__( 'Repeat Horizontally', 'unero' ),
					'repeat-y'  => esc_html__( 'Repeat Vertically', 'unero' ),
					'no-repeat' => esc_html__( 'No Repeat', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_attachments'          => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Attachment', 'unero' ),
				'default'         => 'scroll',
				'section'         => 'boxed_layout',
				'priority'        => 60,
				'choices'         => array(
					'scroll' => esc_html__( 'Scroll', 'unero' ),
					'fixed'  => esc_html__( 'Fixed', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_size'                 => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Size', 'unero' ),
				'default'         => 'normal',
				'section'         => 'boxed_layout',
				'priority'        => 60,
				'choices'         => array(
					'normal'  => esc_html__( 'Normal', 'unero' ),
					'contain' => esc_html__( 'Contain', 'unero' ),
					'cover'   => esc_html__( 'Cover', 'unero' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Color Scheme
			'color_scheme'                          => array(
				'type'     => 'radio-image',
				'label'    => esc_html__( 'Base Color Scheme', 'unero' ),
				'default'  => '0',
				'section'  => 'color_scheme',
				'priority' => 10,
				'choices'  => array(
					'0'       => get_template_directory_uri() . '/images/colors/default.jpg',
					'#305e7b' => get_template_directory_uri() . '/images/colors/blue.jpg',
					'#8c3718' => get_template_directory_uri() . '/images/colors/sienna.jpg',
					'#e8ae5c' => get_template_directory_uri() . '/images/colors/lightorange.jpg',
					'#9b6501' => get_template_directory_uri() . '/images/colors/goldenrod.jpg',
					'#ff7a5e' => get_template_directory_uri() . '/images/colors/coral.jpg',
					'#cd3333' => get_template_directory_uri() . '/images/colors/lightred01.jpg',
					'#cc0000' => get_template_directory_uri() . '/images/colors/lightred02.jpg',
					'#ff6666' => get_template_directory_uri() . '/images/colors/pink.jpg',
					'#ca7f09' => get_template_directory_uri() . '/images/colors/gold.jpg',
				),
			),
			'custom_color_scheme'                   => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Custom Color Scheme', 'unero' ),
				'default'  => 0,
				'section'  => 'color_scheme',
				'priority' => 10,
			),
			'custom_color'                          => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'unero' ),
				'default'         => '',
				'section'         => 'color_scheme',
				'priority'        => 10,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'custom_color_scheme',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
		),
	);

}

/**
 * init customize
 *
 * @return array
 */

function unero_customize_init() {
	$unero_customize = new Unero_Customize( unero_customize_settings() );
}

if ( class_exists( 'Kirki' ) ) {
	add_action( 'init', 'unero_customize_init', 30 );
} else {
	$unero_customize = new Unero_Customize( unero_customize_settings() );
}
