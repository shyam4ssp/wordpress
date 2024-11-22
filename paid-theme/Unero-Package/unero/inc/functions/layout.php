<?php
/**
 * Custom functions for layout.
 *
 * @package Unero
 */

/**
 * Get layout base on current page
 *
 * @return string
 */
if ( ! function_exists( 'unero_get_layout' ) ) :
	function unero_get_layout() {
		$layout = unero_get_option( 'blog_sidebar' );

		if ( unero_get_post_meta( 'custom_sidebar' ) ) {
			$layout = unero_get_post_meta( 'layout' );
		} elseif ( is_singular( 'post' ) ) {
			$layout = unero_get_option( 'single_post_sidebar' );
		} elseif ( unero_is_catalog() ) {
			$layout = unero_get_option( 'catalog_layout' );

			if ( in_array( $layout, array( 'board-content', 'masonry-content' ) ) ) {
				$layout = 'full-content';
			}

		} elseif ( is_singular( 'product' ) ) {
			$layout = 'full-content';
			$product_page_layout = unero_get_option('product_page_layout');

			if( $product_page_layout == '4' ) {
				$layout = 'sidebar-content';
			} elseif( $product_page_layout == '5' ) {
				$layout = 'content-sidebar';
			}
		} elseif ( is_page() ) {
			$layout = unero_get_option( 'pages_sidebar' );
		} elseif ( is_search() ) {
			$layout = 'full-content';
		} elseif ( unero_is_portfolio() ) {
			if ( unero_get_option( 'portfolio_layout' ) == 'carousel' ) {
				$layout = 'full-content';
			} else {
				$layout = unero_get_option( 'portfolio_sidebar' );
			}
		}

		return apply_filters( 'unero_site_layout', $layout );
	}
endif;

/**
 * Get Bootstrap column classes for content area
 *
 * @since  1.0
 *
 * @return array Array of classes
 */
if ( ! function_exists( 'unero_get_content_columns' ) ) :
	function unero_get_content_columns( $layout = null ) {
		$layout  = $layout ? $layout : unero_get_layout();
		$classes = array( 'col-md-9', 'col-sm-12', 'col-xs-12' );

		if ( 'full-content' == $layout ) {
			$classes = array( 'col-md-12' );
		}

		return $classes;
	}
endif;
/**
 * Echos Bootstrap column classes for content area
 *
 * @since 1.0
 */
if ( ! function_exists( 'unero_content_columns' ) ) :
	function unero_content_columns( $layout = null ) {
		echo implode( ' ', unero_get_content_columns( $layout ) );
	}
endif;

/**
 * Get classes for content area
 *
 * @since  1.0
 *
 * @return string of classes
 */
if ( ! function_exists( 'unero_class_full_width' ) ) :
	function unero_class_full_width() {

		if ( is_page_template( 'template-homepage.php' ) ||
			is_page_template( 'template-home-no-footer.php' ) ||
			is_page_template( 'template-full-width.php' )
		) {
			return 'container-fluid';
		} elseif ( ( function_exists( 'is_product' ) && is_product() ) ) {

			$product_layout = unero_get_option( 'product_page_layout' );
			if ( in_array( $product_layout, array( '4', '5' ) ) ) {
				return 'container';
			}

			return 'container-fluid';
		} elseif ( unero_is_catalog() && intval( unero_get_option( 'catalog_full_width' ) ) && unero_get_option( 'catalog_layout' ) == 'full-content' ) {
			return 'unero-container shop-full-with';
		} elseif ( unero_is_portfolio() && unero_get_option( 'portfolio_layout' ) == 'carousel' ) {
			return 'container-fluid';
		}

		return 'container';
	}
endif;

/**
 * Check is catalog
 *
 * @return bool
 */
if ( ! function_exists( 'unero_is_catalog' ) ) :
	function unero_is_catalog() {

		if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is portfolio
 *
 * @return bool
 */
if ( ! function_exists( 'unero_is_portfolio' ) ) :
	function unero_is_portfolio() {

		if ( is_post_type_archive( 'portfolio_project' ) || is_tax( 'portfolio_category' ) ) {
			return true;
		}

		return false;
	}
endif;