<?php
/**
 * Hooks for template archive
 *
 * @package Unero
 */


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @since 1.0
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function unero_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'unero_setup_author' );

function unero_excerpt_more( $more ) {
	$more = '&hellip;';

	return $more;
}

add_filter( 'excerpt_more', 'unero_excerpt_more' );

/**
 * Change length of the excerpt
 *
 * @since  1.0
 *
 * @param string $length
 *
 * @return string
 */
function unero_excerpt_length( $length ) {
	$excerpt_length = intval( unero_get_option( 'excerpt_length' ) );
	if ( $excerpt_length > 0 ) {
		return $excerpt_length;
	}

	return $length;
}

add_filter( 'excerpt_length', 'unero_excerpt_length' );

/**
 * The archive title
 *
 * @since  1.0
 *
 * @param  array $title
 *
 * @return mixed
 */
function unero_the_archive_title( $title ) {
	if ( is_search() ) {
		$title = sprintf( esc_html__( 'Search Results', 'unero' ) );
	} elseif ( is_404() ) {
		$title = sprintf( esc_html__( 'Page Not Found', 'unero' ) );
	} elseif ( is_page() ) {
		$title = get_the_title();
	} elseif ( is_home() && is_front_page() ) {
		$title = esc_html__( 'The Latest Posts', 'unero' );
	} elseif ( is_home() && ! is_front_page() ) {
		$title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$title = get_the_title();
	} elseif ( is_single() ) {
		$title = get_the_title();
	} elseif ( is_post_type_archive( 'portfolio_project' ) ) {
		$title = get_the_title( get_option( 'drf_portfolio_page_id' ) );
	} elseif ( is_tax() || is_category() ) {
		$title = single_term_title( '', false );
	}

	if ( get_option( 'woocommerce_shop_page_id' ) ) {
		if ( is_front_page() && ( get_option( 'woocommerce_shop_page_id' ) == get_option( 'page_on_front' ) ) ) {
			$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		}
	}


	return $title;
}

add_filter( 'get_the_archive_title', 'unero_the_archive_title', 30 );


/**
 * Show categories list in blog
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'unero_blog_categories_list' ) ) :
	function unero_blog_categories_list() {

		if ( ! is_home() && ! is_category() ) {
			return;
		}

		unero_taxs_list();

		?>
		<?php
	}

endif;

add_action( 'unero_before_content', 'unero_blog_categories_list', 20 );

/**
 * Show categories list in portfolio
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'unero_portfolio_categories_list' ) ) :
	function unero_portfolio_categories_list() {

		if ( ! unero_is_portfolio() ) {
			return;
		}

		unero_taxs_list( 'portfolio_category' );

		?>
		<?php
	}
endif;

add_action( 'unero_before_content', 'unero_portfolio_categories_list', 20 );

/**
 * Set order by get posts
 *
 * @since  1.0
 *
 * @param object $query
 *
 * @return string
 */
function unero_pre_get_posts( $query ) {
	if ( is_admin() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	if ( $query->get( 'page_id' ) ) {
		if ( ( $query->get( 'page_id' ) == get_option( 'page_on_front' ) || is_front_page() )
			&& ( get_option( 'woocommerce_shop_page_id' ) != get_option( 'page_on_front' ) )
		) {
			return;
		}
	}

	$default = intval( unero_get_option( 'products_per_page' ) );
	$default = $default ? $default : 12;
	$number  = isset( $_GET['showposts'] ) ? absint( $_GET['showposts'] ) : $default;

	if ( $query->is_search() ) {
		$query->set( 'orderby', 'post_type' );
		$query->set( 'order', 'desc' );

		if ( $_GET && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) {
			$query->set( 'posts_per_page', $number );
		}
	} elseif ( $query->is_archive() ) {
		if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) {
			$query->set( 'posts_per_page', $number );
		}

		if ( unero_is_portfolio() ) {
			$number = intval( unero_get_option( 'portfolio_per_page' ) );
			$query->set( 'posts_per_page', $number );
		}
	}
}

add_action( 'pre_get_posts', 'unero_pre_get_posts' );

/**
 * Hooks to coming soon page
 *
 * @since  1.0
 * @return void
 */

if ( ! function_exists( 'unero_coming_soon_elements' ) ) :
	function unero_coming_soon_elements() {

		printf( '<div class="un-coming-soon-content">' );

		$c_title = unero_get_option( 'coming_soon_title' );
		if ( $c_title ) {
			printf( '<h2 class="c-title">%s</h2>', wp_kses( $c_title, wp_kses_allowed_html( 'post' ) ) );
		}

		$c_desc = unero_get_option( 'coming_soon_desc' );
		if ( $c_desc ) {
			printf( '<div class="c-desc">%s</div>', wp_kses( $c_desc, wp_kses_allowed_html( 'post' ) ) );
		}
		printf( '<div class="countdown-content">' );
		$countdown_text = unero_get_option( 'coming_soon_countdown_text' );
		if ( $countdown_text ) {
			printf( '<div class="countdown-text">%s</div>', wp_kses( $countdown_text, wp_kses_allowed_html( 'post' ) ) );
		}

		$countdown_date = wp_kses( unero_get_option( 'coming_soon_countdown_date' ), wp_kses_allowed_html( 'post' ) );
		if ( $countdown_date ) {
			$second_current = strtotime( date_i18n( 'Y/m/d H:i:s' ) );
			$date           = new DateTime( $countdown_date );
			if ( $date ) {
				$second_discount = strtotime( date_i18n( 'Y/m/d H:i:s', $date->getTimestamp() ) );
				if ( $second_discount > $second_current ) {
					$second = $second_discount - $second_current;

					printf( '<div class="countdown-date" id="unero-countdown-date">%s</div>', $second );

				}
			}
		}

		printf( '</div>' );
		$socials_text = unero_get_option( 'coming_soon_socials_text' );
		$cm_social    = unero_get_option( 'coming_soon_socials' );
		unero_get_socials_html( $cm_social, $socials_text );

		printf( '</div>' );
	}

endif;

add_action( 'unero_coming_soon_page_content', 'unero_coming_soon_elements' );
