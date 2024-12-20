<?php
/**
 * Display breadcrumbs for posts, pages, archive page with the microdata that search engines understand
 *
 * @see http://support.google.com/webmasters/bin/answer.py?hl=en&answer=185417
 *
 * @param array|string $args
 */
function unero_breadcrumbs( $args = '' ) {
	$args = wp_parse_args(
		$args, array(
			'separator'         => '',
			'home_class'        => 'home',
			'before'            => '<span class="before">' . esc_html__( 'You are here: ', 'unero' ) . '</span>',
			'before_item'       => '',
			'after_item'        => '',
			'taxonomy'          => 'category',
			'display_last_item' => true,
			'show_on_front'     => true,
			'labels'            => array(
				'home'      => esc_html__( 'Home', 'unero' ),
				'archive'   => esc_html__( 'Archives', 'unero' ),
				'blog'      => esc_html__( 'Blog', 'unero' ),
				'search'    => esc_html__( 'Search results for', 'unero' ),
				'not_found' => esc_html__( 'Not Found', 'unero' ),
				'portfolio' => esc_html__( 'Portfolio', 'unero' ),
				'author'    => esc_html__( 'Author:', 'unero' ),
				'day'       => esc_html__( 'Daily:', 'unero' ),
				'month'     => esc_html__( 'Monthly:', 'unero' ),
				'year'      => esc_html__( 'Yearly:', 'unero' ),
			),
		)
	);

	$args = apply_filters( 'unero_breadcrumbs_args', $args );

	if ( is_front_page() && ! $args['show_on_front'] ) {
		return;
	}

	$items = array();

	// HTML template for each item
	$item_tpl      = $args['before_item'] . '
		 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<a href="%s" itemprop="item"><span itemprop="name">%s</span></a>
		</li>
	' . $args['after_item'];
	$item_text_tpl = $args['before_item'] . '
		 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<span itemprop="item"><span itemprop="name">%s</span></span>
		</li>
	' . $args['after_item'];

	// Home
	if ( ! $args['home_class'] ) {
		$items[] = sprintf( $item_tpl, get_home_url(), $args['labels']['home'] );
	} else {
		$items[] = sprintf(
			'%s<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a class="%s" href="%s" itemprop="item"><span itemprop="name">%s</span></a>
			</li>%s',
			$args['before_item'],
			$args['home_class'],
			apply_filters( 'unero_breadcrumbs_home_url', get_home_url() ),
			$args['labels']['home'],
			$args['after_item']
		);

	}

	// Front page
	if ( is_front_page() ) {
		$items   = array();
		$items[] = sprintf( $item_text_tpl, $args['labels']['home'] );
	} // Blog
	elseif ( is_home() && ! is_front_page() ) {
		$items[] = sprintf(
			$item_text_tpl,
			get_the_title( get_option( 'page_for_posts' ) )
		);
	} // Single
	elseif ( is_single() ) {
		// Terms

		$taxonomy = $args['taxonomy'];

		if ( is_singular( 'product' ) ) {
			$taxonomy = 'product_cat';
			if ( $page_id = get_option( 'woocommerce_shop_page_id' ) ) {
				$items[] = sprintf( $item_tpl, esc_url( get_permalink( $page_id ) ), get_the_title( $page_id ) );
			}
		}

		if ( is_singular( 'portfolio_project' ) ) {
			$taxonomy = 'portfolio_category';
		}

		$terms = get_the_terms( get_the_ID(), $taxonomy );
		if ( $terms ) {
			$current_term = '';
			foreach ( $terms as $term ) {
				if ( $term->parent != 0 ) {
					$current_term = $term;
					break;
				}
			}
			$term    = $current_term ? $current_term : end( $terms );
			$terms   = unero_get_term_parents( $term->term_id, $taxonomy );
			$terms[] = $term->term_id;

			foreach ( $terms as $term_id ) {
				$term    = get_term( $term_id, $taxonomy );
				$items[] = sprintf( $item_tpl, get_term_link( $term, $taxonomy ), $term->name );
			}
		}

		if ( $args['display_last_item'] ) {
			$items[] = sprintf( $item_text_tpl, get_the_title() );
		}
	} // Page
	elseif ( is_page() ) {
		if ( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) ) {
			if ( $page_id = get_option( 'woocommerce_shop_page_id' ) ) {
				$items[] = sprintf( $item_tpl, esc_url( get_permalink( $page_id ) ), get_the_title( $page_id ) );
			}

		} else {
			$pages = unero_get_post_parents( get_queried_object_id() );
			foreach ( $pages as $page ) {
				$items[] = sprintf( $item_tpl, esc_url( get_permalink( $page ) ), get_the_title( $page ) );
			}
		}

		if ( $args['display_last_item'] ) {
			$items[] = sprintf( $item_text_tpl, get_the_title() );
		}
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		if ( $args['display_last_item'] ) {
			$items[] = sprintf( $item_text_tpl, $title );
		}
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$current_term = get_queried_object();
		$terms        = unero_get_term_parents( get_queried_object_id(), $current_term->taxonomy );
		if ( function_exists( 'is_product_tag' ) && is_product_tag() ) {
			if ( $page_id = get_option( 'woocommerce_shop_page_id' ) ) {
				$items[] = sprintf( $item_tpl, esc_url( get_permalink( $page_id ) ), get_the_title( $page_id ) );
			}
		}

		if ( function_exists( 'is_product_category' ) && is_product_category() ) {
			if ( $page_id = get_option( 'woocommerce_shop_page_id' ) ) {
				$items[] = sprintf( $item_tpl, esc_url( get_permalink( $page_id ) ), get_the_title( $page_id ) );
			}
		}

		if ( $terms ) {
			foreach ( $terms as $term_id ) {
				$term    = get_term( $term_id, $current_term->taxonomy );
				$items[] = sprintf( $item_tpl, get_term_link( $term, $current_term->taxonomy ), $term->name );
			}
		}

		if ( $args['display_last_item'] ) {
			$items[] = sprintf( $item_text_tpl, $current_term->name );
		}
	} elseif ( is_post_type_archive( 'portfolio_project' ) ) {
		$items[] = sprintf( $item_text_tpl, $args['labels']['portfolio'] );
	} // Search
	elseif ( is_search() ) {
		$items[] = sprintf( $item_text_tpl, $args['labels']['search'] . ' &quot;' . get_search_query() . '&quot;' );
	} // 404
	elseif ( is_404() ) {
		$items[] = sprintf( $item_text_tpl, $args['labels']['not_found'] );
	} // Author archive
	elseif ( is_author() ) {
		// Queue the first post, that way we know what author we're dealing with (if that is the case).
		the_post();
		$items[] = sprintf(
			$item_text_tpl,
			$args['labels']['author'] . ' <span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>'
		);
		rewind_posts();
	} // Day archive
	elseif ( is_day() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'unero' ), $args['labels']['day'], get_the_date() )
		);
	} // Month archive
	elseif ( is_month() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'unero' ), $args['labels']['month'], get_the_date( 'F Y' ) )
		);
	} // Year archive
	elseif ( is_year() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'unero' ), $args['labels']['year'], get_the_date( 'Y' ) )
		);
	} // Archive
	else {
		$items[] = sprintf(
			$item_text_tpl,
			$args['labels']['archive']
		);
	}

	echo '<ul itemscope itemtype="http://schema.org/BreadcrumbList">' . $args['before'] . implode( $args['separator'], $items ) . '</ul>';
}

/**
 * Searches for term parents' IDs of hierarchical taxonomies, including current term.
 * This function is similar to the WordPress function get_category_parents() but handles any type of taxonomy.
 * Modified from Hybrid Framework
 *
 * @param int|string    $term_id  The term ID
 * @param object|string $taxonomy The taxonomy of the term whose parents we want.
 *
 * @return array Array of parent terms' IDs.
 */
function unero_get_term_parents( $term_id = '', $taxonomy = 'category' ) {
	// Set up some default arrays.
	$list = array();

	// If no term ID or taxonomy is given, return an empty array.
	if ( empty( $term_id ) || empty( $taxonomy ) ) {
		return $list;
	}

	do {
		$list[] = $term_id;

		// Get next parent term
		$term    = get_term( $term_id, $taxonomy );
		$term_id = $term->parent;
	} while ( $term_id );

	// Reverse the array to put them in the proper order for the trail.
	$list = array_reverse( $list );
	array_pop( $list );

	return $list;
}

/**
 * Gets parent posts' IDs of any post type, include current post
 * Modified from Hybrid Framework
 *
 * @param int|string $post_id ID of the post whose parents we want.
 *
 * @return array Array of parent posts' IDs.
 */
function unero_get_post_parents( $post_id = '' ) {
	// Set up some default array.
	$list = array();

	// If no post ID is given, return an empty array.
	if ( empty( $post_id ) ) {
		return $list;
	}

	do {
		$list[] = $post_id;

		// Get next parent post
		$post    = get_post( $post_id );
		$post_id = $post->post_parent;
	} while ( $post_id );

	// Reverse the array to put them in the proper order for the trail.
	$list = array_reverse( $list );
	array_pop( $list );

	return $list;
}