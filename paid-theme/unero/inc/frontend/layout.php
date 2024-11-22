<?php
/**
 * Hooks for frontend display
 *
 * @package Unero
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function unero_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_page_template( 'template-homepage.php' ) ||
	     is_page_template( 'template-home-no-footer.php' ) ||
	     is_front_page()
	) {
		if ( in_array( unero_get_option( 'header_layout' ), array(
				1,
				2,
			) ) && intval( unero_get_option( 'header_transparent' ) ) ) {
			$classes[] = 'header-transparent';
		}
	}

	if ( intval( unero_get_option( 'enable_boxed_layout' ) ) && ! is_page_template( 'template-coming-soon-page.php' ) ) {
		$classes[] = 'boxed';
		if ( unero_get_option( 'boxed_layout' ) == '2' ) {
			$classes[] = 'boxed-layout-2';
		} else {
			$classes[] = 'boxed-layout-1';
			if ( is_page_template( 'template-homepage.php' ) ||
			     is_page_template( 'template-home-no-footer.php' ) ||
			     is_front_page()
			) {
				if ( intval( unero_get_option( 'boxed_header_bg_transparent' ) ) ) {
					$classes[] = 'boxed-header-transparent';
				}

				if ( intval( unero_get_option( 'boxed_footer_bg_transparent' ) ) ) {
					$classes[] = 'boxed-footer-transparent';
				}
			}
		}

	}

	// Add a class of layout
	$classes[] = unero_get_layout();

	if ( unero_is_catalog() ) {
		$shop_view = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : unero_get_option( 'shop_view' );

		if ( in_array( unero_get_option( 'catalog_layout' ), array( 'board-content', 'masonry-content' ) ) ) {
			$shop_view = 'grid';
		} else {
			$classes[] = 'product-grid-layout-' . unero_get_option( 'product_grid_layout' );
		}
		$classes[] = 'shop-view-' . $shop_view;

		if ( intval( unero_get_option( 'catalog_ajax_filter' ) ) ) {
			$classes[] = 'catalog-ajax-filter';
		}

		if ( unero_shop_page_header() ) {
			if ( in_array( unero_get_option( 'page_header_layout_shop' ), array( '2', '3' ) ) ) {
				if ( in_array( unero_get_option( 'header_layout' ), array( 1, 2 ) ) ) {
					if ( intval( unero_get_option( 'shop_header_transparent' ) ) ) {
						$classes[] = 'header-transparent';
					} else {
						$classes[] = 'header-no-transparent';
					}
				}
			}
		}

		if ( unero_get_option( 'catalog_layout' ) == 'board-content' ) {
			$classes[] = 'catalog-board-content';
		} elseif ( unero_get_option( 'catalog_layout' ) == 'masonry-content' ) {
			$classes[] = 'catalog-masonry-content';
		}
	} else {
		$classes[] = 'product-grid-layout-' . unero_get_option( 'product_grid_layout' );
	}

	if ( function_exists( 'is_product' ) && is_product() ) {
		if ( intval( unero_get_option( 'product_page_no_bg' ) ) ) {
			$classes[] = 'product-page-no-bg';
		}

		if ( ! intval( unero_get_option( 'product_zoom_mobile' ) ) ) {
			$classes[] = 'product-no-zoom-mobile';
		}

		$classes[] = 'product-page-layout-' . intval( unero_get_option( 'product_page_layout' ) );
	}

	if ( $header_layout = unero_get_option( 'header_layout' ) ) {
		$classes[] = 'header-layout-' . $header_layout;
	}

	if ( ! is_page_template( 'template-coming-soon-page.php' ) ) {
		if ( intval( unero_get_option( 'sticky_header' ) ) ) {
			$classes[] = 'sticky-header';
		}
	}

	if ( intval( unero_get_option( 'product_columns_mobile' ) ) == 1 ) {
		$classes[] = 'product-column-mobile';
	}

	if ( unero_is_portfolio() ) {
		$classes[] = 'portfolio-layout-' . unero_get_option( 'portfolio_layout' );
	}

	if ( $page_header = unero_get_page_header() ) {
		if ( isset( $page_header['layout'] ) && $page_header['layout'] ) {
			$classes[] = 'page-header-layout-' . $page_header['layout'];
		}
	}

	if ( intval( unero_get_option( 'product_icons_mobile' ) ) ) {
		$classes[] = 'product-grid-icons-mobile';
	}

	if ( unero_get_option( 'submenu_mobile' ) != 'menu' ) {
		$classes[] = 'submenus-mobile-' . unero_get_option( 'submenu_mobile' );
	}

	return $classes;
}

add_filter( 'body_class', 'unero_body_classes' );

/**
 * Print the open tags of site content container
 */
function unero_open_site_content_container() {
	if (
	is_page_template( 'template-coming-soon-page.php' )
	) {
		printf( '<div class="container">' );
	} else {
		printf( '<div class="%s"><div class="row">', esc_attr( apply_filters( 'unero_site_content_container_class', unero_class_full_width() ) ) );
	}
}

add_action( 'unero_after_site_content_open', 'unero_open_site_content_container' );

/**
 * Print the close tags of site content container
 */
function unero_close_site_content_container() {
	if ( is_page_template( 'template-coming-soon-page.php' )
	) {
		echo '</div>';
	} else {
		echo '</div></div><!-- .container -->';
	}
}

add_action( 'unero_before_site_content_close', 'unero_close_site_content_container' );
