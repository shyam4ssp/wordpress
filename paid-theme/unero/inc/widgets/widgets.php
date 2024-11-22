<?php
/**
 * Load and register widgets
 *
 * @package Unero
 */

require_once get_template_directory() . '/inc/widgets/woo-attributes-filter.php';
require_once get_template_directory() . '/inc/widgets/product-sort-by.php';
require_once get_template_directory() . '/inc/widgets/filter-price-list.php';
require_once get_template_directory() . '/inc/widgets/social-media-links.php';
require_once get_template_directory() . '/inc/widgets/language-currency.php';
require_once get_template_directory() . '/inc/widgets/product-tag.php';
require_once get_template_directory() . '/inc/widgets/product-categories.php';


/**
 * Register widgets
 *
 * @since  1.0
 *
 * @return void
 */


function unero_register_widgets() {
	if ( class_exists( 'WC_Widget' ) ) {
		register_widget( 'Unero_Widget_Attributes_Filter' );
		register_widget( 'Unero_Widget_Product_Tag_Cloud' );
		register_widget( 'Unero_Widget_Product_Categories' );
	}

	register_widget( 'Unero_Product_SortBy_Widget' );
	register_widget( 'Unero_Price_Filter_List_Widget' );
	register_widget( 'Unero_Social_Links_Widget' );
	register_widget( 'Unero_Language_Currency_Widget' );
}

add_action( 'widgets_init', 'unero_register_widgets' );