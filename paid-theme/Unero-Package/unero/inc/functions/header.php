<?php
/**
 * Custom functions for header.
 *
 * @package unero
 */


/**
 * Get header menu
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_header_menu' ) ) :
	function unero_header_menu() {
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'walker'         => new Unero_Mega_Menu_Walker(),
				)
			);
		}
	}
endif;

/**
 * Get Icon Menu Mobile
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_icon_menu' ) ) :
	function unero_icon_menu() {
		printf(
			'<div class="navbar-toggle col-md-3 col-sm-3 col-xs-3">
			<span id="un-navbar-toggle" class="t-icon icon-menu">
			</span>
		</div>'
		);

	}

endif;

/**
 * Get Menu extra Account
 *
 * @since  1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'unero_extra_account' ) ) :
	function unero_extra_account() {
		$extras = unero_get_menu_extras();
		$items  = '';

		if ( empty( $extras ) || ! in_array( 'account', $extras ) ) {
			return $items;
		}

		$user_id = get_current_user_id();
		if ( is_user_logged_in() ) {
			$user_menu = unero_nav_user_menu();
			$user_class = unero_get_option('user_logged_type') == 'icon' ? 'menu-item-account-icon' : '';

			$items .= sprintf(
				'<li class="extra-menu-item menu-item-account logined %s">
					<a href="%s"> %s</i></a>
					<ul>
						<li>
							%s
						</li>
						<li>
							<a href="%s">%s</a>
						</li>
					</ul>
				</li>',
				esc_attr( $user_class ),
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				get_avatar( get_the_author_meta( 'ID', $user_id ), 40 ),
				implode( ' ', $user_menu ),
				esc_url( wp_logout_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) ),
				esc_html__( 'Logout', 'unero' )
			);
		} else {

			$items .= sprintf(
				'<li class="extra-menu-item menu-item-account">
				<a href="%s" class="item-login" id="menu-extra-login"><i class="t-icon icon-user"></i></a>
			</li>',
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) )
			);
		}

		echo ! empty( $items ) ? $items : '';

	}

endif;

/**
 * Get Custom Vendor
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_nav_user_menu' ) ) :
	function unero_nav_user_menu() {
		$user_menu = array();
		if ( ! has_nav_menu( 'user_logged' ) ) {
			$orders  = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
			$account = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			if ( $orders ) {
				$account .= '/' . $orders;
			}


			$wishlist = '';
			if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
				$wishlist = sprintf(
					'<li>
						<a href="%s">%s</a>
					</li>',
					esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ),
					esc_html__( 'My Wishlist', 'unero' )
				);
			}

			$user_menu[] = sprintf(
				'<ul>
					%s
					<li>
						<a href="%s">%s</a>
					</li>
					<li>
						<a href="%s">%s</a>
					</li>
				</ul>',
				$wishlist,
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				esc_html__( 'Account Settings', 'unero' ),
				esc_url( $account ),
				esc_html__( 'Orders History', 'unero' )
			);
		} else {
			$user_menu[] = wp_nav_menu(
				array(
					'theme_location' => 'user_logged',
					'container'      => false,
					'echo'           => false,
				)
			);
		}

		return $user_menu;
	}
endif;

/**
 * Get Menu extra WishList
 *
 * @since  1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'unero_extra_wishlist' ) ) :
	function unero_extra_wishlist() {
		$extras = unero_get_menu_extras();
		$items  = '';

		if ( empty( $extras ) || ! in_array( 'wishlist', $extras ) ) {
			return $items;
		}

		if ( ! function_exists( 'YITH_WCWL' ) ) {
			return '';
		}

		$count = YITH_WCWL()->count_products();

		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			$items = sprintf(
				'<li class="extra-menu-item menu-item-wishlist">
				<a href="%s"><i class="t-icon icon-heart"></i><span class="mini-cart-counter">%s</span></a>
			</li>',
				esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ),
				intval( $count )
			);
		}

		echo ! empty( $items ) ? $items : '';

	}

endif;


/**
 * Get Menu extra cart
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_extra_cart' ) ) :
	function unero_extra_cart() {
		$extras = unero_get_menu_extras();

		if ( empty( $extras ) || ! in_array( 'cart', $extras ) ) {
			return '';
		}

		if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
			return '';
		}
		global $woocommerce;

		$icon_cart = '<i class="t-icon icon-bag2"></i>';
		$icon_cart = apply_filters( 'unero_icon_cart', $icon_cart );

		printf(
			'<li class="extra-menu-item menu-item-cart mini-cart woocommerce">
			<a class="cart-contents" id="icon-cart-contents" href="%s">
				%s
				<span class="mini-cart-counter">
					%s
				</span>
			</a>
		</li>',
			esc_url( wc_get_cart_url() ),
			$icon_cart,
			intval( $woocommerce->cart->cart_contents_count )
		);

	}
endif;

/**
 * Get Menu extra search
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_extra_search' ) ) :
	function unero_extra_search() {
		$extras = unero_get_menu_extras();

		if ( empty( $extras ) || ! in_array( 'search', $extras ) ) {
			return;
		}

		$items          = '<a href="#" id="menu-extra-search"><i class="t-icon icon-magnifier"></i></a>';
		$id             = 'un-menu-item-search';
		$css_class      = '';
		$post_type_html = '';
		if ( unero_get_option( 'search_content_type' ) == 'products' ) {
			$post_type_html = '<input type="hidden" name="post_type" value="product">';
		}
		if ( unero_get_option( 'header_layout' ) == 4 ) {
			$items = sprintf(
				'<form method="get" class="instance-search" action="%s">' .
				'<input type="text" name="s" placeholder="%s..." class="search-field" autocomplete="off">' .
				'%s' .
				'<i class="t-icon icon-magnifier"></i>' .
				'</form>' .
				'<div class="loading">' .
				'<span class="unero-loader"></span>' .
				'</div>' .
				'<div class="search-results">' .
				'<div class="woocommerce"></div>' .
				'</div>',
				esc_url( home_url( '/' ) ),
				esc_html__( 'Search anything', 'unero' ),
				$post_type_html
			);

			$id        = 'search-modal';
			$css_class = 'search-modal';
		}

		$items = sprintf(
			'<li id="%s" class="extra-menu-item menu-item-search %s">%s</li>',
			esc_attr( $id ),
			esc_attr( $css_class ),
			$items
		);

		echo ! empty( $items ) ? $items : '';
	}

endif;

/**
 * Get Menu extra language
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_extra_language' ) ) :
	function unero_extra_language() {
		$extras = unero_get_menu_extras();

		if ( empty( $extras ) || ! in_array( 'language', $extras ) ) {
			return;
		}


		$type = unero_get_option( 'header_lang_type' );

		$items = apply_filters( 'unero_header_menu_extra_language', unero_language_switcher( $type ) );
		if ( $items ) {
			echo '<li class="extra-menu-item menu-item-language">' .
			     $items .
			     '</li>';
		}
	}
endif;

/**
 * Get Menu extra currency
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_extra_currency' ) ) :
	function unero_extra_currency() {
		$extras = unero_get_menu_extras();

		if ( empty( $extras ) || ! in_array( 'currency', $extras ) ) {
			return;
		}

		$items = apply_filters( 'unero_header_menu_extra_currency', unero_currency_switcher() );

		$flow_symbol = intval( unero_get_option( 'flag_symbol' ) );

		$css = $flow_symbol ? 'show-flag ' . 'flag-' . unero_get_option( 'currency_flag_pos' ) : '';

		echo '<li class="extra-menu-item menu-item-currency ' . esc_attr( $css ) . '">' .
		     $items .
		     '</li>';
	}
endif;

/**
 * Get Menu extra sidebar
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_extra_sidebar' ) ) :
	function unero_extra_sidebar() {
		$extras = unero_get_menu_extras();

		if ( empty( $extras ) || ! in_array( 'sidebar', $extras ) ) {
			return '';
		}

		$icon_cart = '<i class="t-icon icon-menu"></i>';

		$menu_class = '';
		if ( unero_get_option( 'header_layout' ) == '2' ) {

			if ( intval( unero_get_option( 'show_sidebar_text' ) ) ) {
				$menu_class = 'show-sidebar-text';
			}
			$icon_cart = sprintf( '<span class="text">%s</span> %s', esc_html__( 'Menu', 'unero' ), $icon_cart );
		}
		$icon_cart = apply_filters( 'unero_icon_menu', $icon_cart );

		printf(
			'<li class="extra-menu-item menu-item-sidebar %s">
			<a class="menu-sidebar" id="icon-menu-sidebar" href="#">
				%s
			</a>
		</li>',
			esc_attr( $menu_class ),
			$icon_cart
		);

	}

endif;

/**
 * Get Menu extra
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_get_menu_extras' ) ) :
	function unero_get_menu_extras() {
		if ( in_array( unero_get_option( 'header_layout' ), array( 3, 4 ) ) ) {
			return unero_get_option( 'menu_extras_2' );
		} else {
			return unero_get_option( 'menu_extras' );
		}

	}

endif;

/**
 * Get socials
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_get_socials' ) ) :
	function unero_get_socials() {
		$socials = array(
			'facebook'   => esc_html__( 'Facebook', 'unero' ),
			'twitter'    => esc_html__( 'Twitter', 'unero' ),
			'google'     => esc_html__( 'Google', 'unero' ),
			'tumblr'     => esc_html__( 'Tumblr', 'unero' ),
			'flickr'     => esc_html__( 'Flickr', 'unero' ),
			'vimeo'      => esc_html__( 'Vimeo', 'unero' ),
			'youtube'    => esc_html__( 'Youtube', 'unero' ),
			'linkedin'   => esc_html__( 'LinkedIn', 'unero' ),
			'pinterest'  => esc_html__( 'Pinterest', 'unero' ),
			'dribbble'   => esc_html__( 'Dribbble', 'unero' ),
			'spotify'    => esc_html__( 'Spotify', 'unero' ),
			'instagram'  => esc_html__( 'Instagram', 'unero' ),
			'tumbleupon' => esc_html__( 'Tumbleupon', 'unero' ),
			'wordpress'  => esc_html__( 'WordPress', 'unero' ),
			'rss'        => esc_html__( 'Rss', 'unero' ),
			'deviantart' => esc_html__( 'Deviantart', 'unero' ),
			'share'      => esc_html__( 'Share', 'unero' ),
			'skype'      => esc_html__( 'Skype', 'unero' ),
			'picassa'    => esc_html__( 'Picassa', 'unero' ),
			'blogger'    => esc_html__( 'Blogger', 'unero' ),
			'delicious'  => esc_html__( 'Delicious', 'unero' ),
			'myspace'    => esc_html__( 'Myspace', 'unero' ),
			'vk'         => esc_html__( 'VK', 'unero' ),
		);

		$socials = apply_filters( 'unero_elegan_socials', $socials );

		return $socials;
	}
endif;


/**
 * Get page header layout
 *
 * @return array
 */

if ( ! function_exists( 'unero_get_page_header' ) ) :
	function unero_get_page_header() {
		if ( is_singular( 'product' ) || is_singular( 'post' ) || is_404() ) {
			return false;
		}

		if ( unero_get_post_meta( 'hide_page_header' ) ) {
			return false;
		}

		$page_header = array(
			'layout'   => 1,
			'bg_image' => '',
			'parallax' => false,
		);


		if ( unero_is_catalog() ) {
			if ( ! intval( unero_get_option( 'page_header_shop' ) ) ) {
				return false;
			}

			$pg_layout             = unero_get_option( 'page_header_layout_shop' );
			$page_header['layout'] = $pg_layout;
			if ( $pg_layout == '2' ) {
				$page_header['bg_image'] = unero_get_option( 'page_header_background_shop' );
				$page_header['parallax'] = intval( unero_get_option( 'page_header_shop_parallax' ) );
			}
			$post_id = get_the_ID();
			if ( function_exists( 'is_shop' ) && is_shop() ) {
				$post_id = get_option( 'woocommerce_shop_page_id' );
			}

			$custom_layout = get_post_meta( $post_id, 'custom_page_header', true );
			if ( $custom_layout ) {
				$pg_layout             = get_post_meta( $post_id, 'page_header_layout', true );
				$page_header['layout'] = $pg_layout;
				if ( $pg_layout == '2' ) {
					$image_id  = get_post_meta( $post_id, 'page_bg', true );
					$image_src = '';
					if ( $image_id ) {
						$image     = wp_get_attachment_image_src( $image_id, 'full' );
						$image_src = $image ? $image[0] : '';
					}
					$page_header['bg_image'] = $image_src;
					$page_header['parallax'] = get_post_meta( $post_id, 'page_parallax', true );
				}
			}

		} elseif ( is_page() ) {
			if ( ! intval( unero_get_option( 'page_header_pages' ) ) ) {
				return false;
			}

			$custom_layout = get_post_meta( get_the_ID(), 'custom_page_header', true );
			if ( $custom_layout ) {
				$pg_layout             = get_post_meta( get_the_ID(), 'page_header_layout', true );
				$page_header['layout'] = $pg_layout;
				if ( $pg_layout == '2' ) {
					$image_id  = get_post_meta( get_the_ID(), 'page_bg', true );
					$image_src = '';
					if ( $image_id ) {
						$image     = wp_get_attachment_image_src( $image_id, 'full' );
						$image_src = $image ? $image[0] : '';
					}
					$page_header['bg_image'] = $image_src;
					$page_header['parallax'] = get_post_meta( get_the_ID(), 'page_parallax', true );
				}
			} else {
				$pg_layout             = unero_get_option( 'page_header_layout_pages' );
				$page_header['layout'] = $pg_layout;
				if ( $pg_layout == '2' ) {
					$page_header['bg_image'] = unero_get_option( 'page_header_background_pages' );
					$page_header['parallax'] = intval( unero_get_option( 'page_header_page_parallax' ) );
				}
			}
		} elseif ( unero_is_portfolio() ) {
			if ( ! intval( unero_get_option( 'page_header_portfolio' ) ) ) {
				return false;
			}
			$pg_layout             = unero_get_option( 'page_header_layout_portfolio' );
			$page_header['layout'] = $pg_layout;

		} elseif ( is_singular( 'portfolio_project' ) ) {
			if ( ! intval( unero_get_option( 'page_header_single_portfolio' ) ) ) {
				return false;
			}

			$custom_layout = get_post_meta( get_the_ID(), 'custom_page_header', true );
			if ( $custom_layout ) {
				$pg_layout             = get_post_meta( get_the_ID(), 'page_header_layout', true );
				$page_header['layout'] = $pg_layout;
				if ( $pg_layout == '2' ) {
					$image_id  = get_post_meta( get_the_ID(), 'portfolio_bg', true );
					$image_src = '';
					if ( $image_id ) {
						$image     = wp_get_attachment_image_src( $image_id, 'full' );
						$image_src = $image ? $image[0] : '';
					}
					$page_header['bg_image'] = $image_src;
					$page_header['parallax'] = get_post_meta( get_the_ID(), 'portfolio_parallax', true );
				}
			} else {
				$pg_layout             = unero_get_option( 'page_header_layout_single_portfolio' );
				$page_header['layout'] = $pg_layout;
				if ( $pg_layout == '2' ) {
					$page_header['bg_image'] = unero_get_option( 'page_header_single_portfolio_bg' );
					$page_header['parallax'] = intval( unero_get_option( 'page_header_single_portfolio_parallax' ) );
				}
			}


		} else {
			if ( ! intval( unero_get_option( 'page_header_site' ) ) ) {
				return false;
			}

			$pg_layout             = unero_get_option( 'page_header_layout_site' );
			$page_header['layout'] = $pg_layout;
			if ( $pg_layout == '2' ) {
				$page_header['bg_image'] = unero_get_option( 'page_header_background_site' );
				$page_header['parallax'] = intval( unero_get_option( 'page_header_site_parallax' ) );
			}
		}

		return $page_header;

	}

endif;

/**
 * Get home boxed
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'unero_boxed_content' ) ) :
	function unero_boxed_content() {
		if ( ! intval( unero_get_option( 'enable_boxed_layout' ) ) ) {
			return;
		}

		$bg_color = unero_get_option( 'boxed_background_color' );

		$bg_css = ! empty( $bg_color ) ? "background-color: {$bg_color};" : '';

		if ( unero_get_option( 'boxed_layout' ) == '1' ) {
			$bg_image = unero_get_option( 'boxed_background_image' );
			if ( ! empty( $bg_image ) ) {


				$bg_css .= "background-image: url({$bg_image});";

				$bg_repeats = unero_get_option( 'boxed_background_repeats' );
				$bg_css     .= "background-repeat: {$bg_repeats};";

				$bg_vertical   = unero_get_option( 'boxed_background_vertical' );
				$bg_horizontal = unero_get_option( 'boxed_background_horizontal' );
				$bg_css        .= "background-position: {$bg_horizontal} {$bg_vertical};";

				$bg_attachments = unero_get_option( 'boxed_background_attachments' );
				$bg_css         .= "background-attachment: {$bg_attachments};";

				$bg_size = unero_get_option( 'boxed_background_size' );
				$bg_css  .= "background-size: {$bg_size};";
			}
		}


		if ( $bg_css ) {
			$bg_css = 'body.boxed {' . $bg_css . '}';
		}

		return $bg_css;
	}
endif;