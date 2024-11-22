<?php
/**
 * Register required, recommended plugins for theme
 *
 * @package Unero
 */

/**
 * Register required plugins
 *
 * @since  1.0
 */
function unero_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__( 'Meta Box', 'unero' ),
			'slug'               => 'meta-box',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Kirki', 'unero' ),
			'slug'               => 'kirki',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'WooCommerce', 'unero' ),
			'slug'               => 'woocommerce',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'WPBakery Page Builder', 'unero' ),
			'slug'               => 'js_composer',
			'source'             => get_template_directory() . '/plugins/js_composer.zip',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '5.1.1',
		),
		array(
			'name'               => esc_html__( 'Unero Addons', 'unero' ),
			'slug'               => 'unero-vc-addons',
			'source'             => get_template_directory() . '/plugins/unero-vc-addons.zip',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.1.5',
		),
		array(
			'name'               => esc_html__( 'YITH WooCommerce Wishlist', 'unero' ),
			'slug'               => 'yith-woocommerce-wishlist',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Variation Swatches for WooCommerce', 'unero' ),
			'slug'               => 'variation-swatches-for-woocommerce',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'DRF Portfolio Management', 'unero' ),
			'slug'               => 'drf-portfolio',
			'source'             => get_template_directory() . '/plugins/drf-portfolio.zip',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.0.1'
		),
		array(
			'name'               => esc_html__( 'Contact Form 7', 'unero' ),
			'slug'               => 'contact-form-7',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'     => esc_html__( 'MailChimp for WordPress', 'unero' ),
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),
	);
	$config  = array(
		'domain'       => 'unero',
		'default_path' => '',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'unero' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'unero' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'unero' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'unero' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'unero' ),
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'unero' ),
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'unero' ),
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'unero' ),
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'unero' ),
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'unero' ),
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'unero' ),
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'unero' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'unero' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'unero' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'unero' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'unero' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'unero' ),
			'nag_type'                        => 'updated'
		)
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'unero_register_required_plugins' );
