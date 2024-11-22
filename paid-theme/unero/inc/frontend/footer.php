<?php
/**
 * Hooks for template footer
 *
 * @package Unero
 */

function unero_shop_footer() {

	if ( ! unero_is_catalog() ) {
		return;
	}

	echo '<div id="un-shop-footer"></div>';
}

add_action( 'unero_before_footer', 'unero_shop_footer' );

/**
 * Show footer
 */
function unero_show_footer() {

	if ( is_page_template( 'template-coming-soon-page.php' ) ) {
		return;
	}

	$footer_layout = unero_get_option( 'footer_layout' );
	$footer_layout = $footer_layout ? $footer_layout : 1;
	get_template_part( 'template-parts/footers/layout', $footer_layout );
}

add_action( 'unero_footer', 'unero_show_footer' );

/**
 * Adds photoSwipe dialog element
 */
function unero_product_images_lightbox() {
	if ( ! is_singular() ) {
		return;
	}

	if ( is_page_template( 'template-coming-soon-page.php' ) ) {
		return;
	}

	if ( ! function_exists( 'is_woocommerce' ) ) {
		return;
	}

	?>
    <div id="pswp" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="pswp__bg"></div>

        <div class="pswp__scroll-wrap">

            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">


                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close"
                            title="<?php esc_attr_e( 'Close (Esc)', 'unero' ) ?>"></button>

                    <button class="pswp__button pswp__button--share"
                            title="<?php esc_attr_e( 'Share', 'unero' ) ?>"></button>

                    <button class="pswp__button pswp__button--fs"
                            title="<?php esc_attr_e( 'Toggle fullscreen', 'unero' ) ?>"></button>

                    <button class="pswp__button pswp__button--zoom"
                            title="<?php esc_attr_e( 'Zoom in/out', 'unero' ) ?>"></button>

                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button pswp__button--arrow--left"
                        title="<?php esc_attr_e( 'Previous (arrow left)', 'unero' ) ?>">
                </button>

                <button class="pswp__button pswp__button--arrow--right"
                        title="<?php esc_attr_e( 'Next (arrow right)', 'unero' ) ?>">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>

            </div>

        </div>

    </div>
	<?php
}

add_action( 'wp_footer', 'unero_product_images_lightbox' );


/**
 * Add off canvas shopping cart to footer
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'unero_off_canvas_cart' ) ) :
	function unero_off_canvas_cart() {

		if ( is_page_template( 'template-coming-soon-page.php' ) ) {
			return;
		}

		if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
			return;
		}

		$extras = unero_get_menu_extras();

		if ( empty( $extras ) || ! in_array( 'cart', $extras ) ) {
			return '';
		}

		?>
        <div id="cart-panel" class="cart-panel woocommerce mini-cart unero-off-canvas-panel">
            <div class="widget-canvas-content">
                <div class="widget-cart-header  widget-panel-header">
                    <a href="#" class="close-canvas-panel"><span aria-hidden="true" class="icon-cross2"></span></a>
                </div>
                <div class="widget_shopping_cart_content">
					<?php woocommerce_mini_cart(); ?>
                </div>
            </div>
            <div class="mini-cart-loading"><span class="unero-loader"></span></div>
        </div>
		<?php
	}

endif;

add_action( 'wp_footer', 'unero_off_canvas_cart' );

/**
 * Add off canvas shopping cart to footer
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'unero_off_canvas_menu_sidebar' ) ) :
	function unero_off_canvas_menu_sidebar() {

		if ( is_page_template( 'template-coming-soon-page.php' ) ) {
			return;
		}

		$extras = unero_get_menu_extras();

		if ( empty( $extras ) || ! in_array( 'sidebar', $extras ) ) {
			return;
		}

		?>
        <div id="menu-sidebar-panel" class="menu-sidebar unero-off-canvas-panel">
            <div class="widget-canvas-content">
                <div class="widget-panel-header">
                    <a href="#" class="close-canvas-panel"><span aria-hidden="true" class="icon-cross2"></span></a>
                </div>
                <div class="widget-panel-content">
					<?php
					$sidebar = 'menu-sidebar';
					if ( is_active_sidebar( $sidebar ) ) {
						dynamic_sidebar( $sidebar );
					}
					?>
                </div>
                <div class="widget-panel-footer">
                </div>
            </div>
        </div>
		<?php
	}

endif;

add_action( 'wp_footer', 'unero_off_canvas_menu_sidebar' );

/**
 * Display a layer to close canvas panel everywhere inside page
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'unero_site_canvas_layer' ) ) :
	function unero_site_canvas_layer() {
		?>
        <div id="off-canvas-layer" class="unero-off-canvas-layer"></div>
		<?php
	}

endif;

add_action( 'wp_footer', 'unero_site_canvas_layer' );

/**
 * Add off mobile menu to footer
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'unero_off_canvas_mobile_menu' ) ) :
	function unero_off_canvas_mobile_menu() {
		$header_mobile = unero_get_option( 'menu_extras_mobile' );
		?>
        <div class="primary-mobile-nav" id="primary-mobile-nav">
            <div class="mobile-nav-content">
                <a href="#" class="close-canvas-mobile-panel">
				<span class="mnav-icon icon-cross2">
				</span>
                </a>
				<?php if ( in_array( 'search', $header_mobile ) ) : ?>
                    <form method="get" class="instance-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="text" name="s" placeholder="<?php esc_html_e( 'Search', 'unero' ); ?>"
                               class="search-field" autocomplete="off">
						<?php if ( unero_get_option( 'search_content_type' ) == 'products' ) { ?>
                            <input type="hidden" name="post_type" value="product">
						<?php } ?>
                        <i class="t-icon icon-magnifier"></i>
                        <input type="submit" class="btn-submit">
                    </form>
				<?php endif; ?>
				<?php

				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
						)
					);
				}

				$extras = unero_get_menu_extras();

				$wishlist = '';
				if ( in_array( 'wishlist', $header_mobile ) ) :
					if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) && $extras && in_array( 'wishlist', $extras ) ) {
						$wishlist = sprintf(
							'<li>
						<a href="%s">%s <i class="t-icon icon-heart"></i></a>
					</li>',
							esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ),
							esc_html__( 'My Wishlist', 'unero' )
						);
					}
				endif;
				?>
                <div class="mobile-nav-footer">
                    <ul class="menu">
						<?php if ( in_array( 'account', $header_mobile ) ) : ?>
							<?php if ( is_user_logged_in() ) :
								$user_id = get_current_user_id();
								$author = get_user_by( 'id', $user_id );
								?>
                                <li>
                                    <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"><?php echo esc_html__( 'Hello,', 'unero' ) . ' ' . $author->display_name; ?>
                                        <i class="t-icon icon-user"></i></a>
                                </li>
							<?php else : ?>
                                <li>
                                    <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"><?php esc_html_e( 'Login', 'unero' ); ?>
                                        <i class="t-icon icon-user"></i></a>
                                </li>
							<?php endif; ?>
						<?php endif; ?>
						<?php
						echo ! empty( $wishlist ) ? $wishlist : '';

						$currency = apply_filters( 'unero_mobile_menu_extra_currency', unero_currency_switcher( true ), true );
						if ( $currency ) {
							echo '<li class="menu-item-currency menu-item-has-children">' . $currency . '</li>';
						}

						$language = apply_filters( 'unero_mobile_menu_extra_language', unero_language_switcher( 'name' ), true );
						if ( $language ) {
							echo '<li class="menu-item-language menu-item-has-children">' . $language . '</li>';
						}
						?>
                    </ul>
                </div>
            </div>
        </div>
		<?php
	}

endif;

add_action( 'wp_footer', 'unero_off_canvas_mobile_menu' );


/**
 * Add search modal to footer
 */
if ( ! function_exists( 'unero_search_modal' ) ) :
	function unero_search_modal() {

		if ( is_page_template( 'template-coming-soon-page.php' ) ) {
			return;
		}

		if ( unero_get_option( 'header_layout' ) == 4 ) {
			return;
		}

		?>
        <div id="search-modal" class="search-modal unero-modal" tabindex="-1" role="dialog">
            <div class="modal-content">
                <h2 class="modal-title"><?php esc_html_e( 'Search', 'unero' ); ?></h2>

                <div class="container">
                    <form method="get" class="instance-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php
						$number = apply_filters( 'unero_product_cats_search_number', 4 );
						$cats   = '';
						if ( unero_get_option( 'search_content_type' ) == 'products' ) {
							$args = array(
								'number'       => $number,
								'orderby'      => 'count',
								'order'        => 'desc',
								'hierarchical' => false,
								'taxonomy'     => 'product_cat',
							);
							$cats = get_terms( $args );
						}
						?>
						<?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
                            <div class="product-cats">
                                <label>
                                    <input type="radio" name="product_cat" value="" checked="checked">
                                    <span class="line-hover"><?php esc_html_e( 'All', 'unero' ) ?></span>
                                </label>

								<?php foreach ( $cats as $cat ) : ?>
                                    <label>
                                        <input type="radio" name="product_cat"
                                               value="<?php echo esc_attr( $cat->slug ); ?>">
                                        <span class="line-hover"><?php echo esc_html( $cat->name ); ?></span>
                                    </label>
								<?php endforeach; ?>
                            </div>
						<?php endif; ?>

                        <div class="search-fields">
                            <input type="text" name="s" placeholder="<?php esc_attr_e( 'Search', 'unero' ); ?>"
                                   class="search-field" autocomplete="off">
							<?php if ( unero_get_option( 'search_content_type' ) == 'products' ) { ?>
                                <input type="hidden" name="post_type" value="product">
							<?php } ?>
                            <input type="submit" class="btn-submit">
                            <span class="search-submit">
						</span>
                        </div>
                    </form>

                    <div class="search-results">
                        <div class="text-center loading">
                            <span class="unero-loader"></span>
                        </div>
                        <div class="woocommerce"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="close-modal"><?php esc_html_e( 'Close', 'unero' ) ?></a>
            </div>
        </div>
		<?php
	}

endif;

add_action( 'wp_footer', 'unero_search_modal' );

/**
 * Add login modal to footer
 */

/**
 * Add login modal to footer
 */

if ( ! function_exists( 'unero_login_modal' ) ) :
	function unero_login_modal() {

		if ( is_page_template( 'template-coming-soon-page.php' ) ) {
			return;
		}

		if ( ! shortcode_exists( 'woocommerce_my_account' ) ) {
			return;
		}

		if ( is_user_logged_in() ) {
			return;
		}
		?>

        <div id="login-modal" class="login-modal unero-modal woocommerce-account" tabindex="-1" role="dialog">
            <div class="modal-content">
                <div class="container">
					<?php echo do_shortcode( '[woocommerce_my_account]' ) ?>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="close-modal"><?php esc_html_e( 'Close', 'unero' ) ?></a>
            </div>
        </div>

		<?php
	}

endif;

add_action( 'wp_footer', 'unero_login_modal' );


/**
 * Adds quick view modal to footer
 */
if ( ! function_exists( 'unero_quick_view_modal' ) ) :
	function unero_quick_view_modal() {
		if ( is_page_template( 'template-coming-soon-page.php' ) ) {
			return;
		}
		?>

        <div id="quick-view-modal" class="quick-view-modal unero-modal woocommerce" tabindex="-1" role="dialog">
            <div class="modal-header">
                <a href="#" class="close-modal">
                    <i class="icon-cross"></i>
                </a>
            </div>
			<?php if ( unero_get_option( 'product_quick_view_method' ) == '1' ) { ?>
                <div class="modal-content">
                    <div class="container">
                        <div class="unero-product-content"></div>
                    </div>
                </div>
			<?php } else { ?>
                <div class="modal-content">
                    <div class="container">
                        <div class="unero-product-content">
                            <div class="product">
                                <div class="row">
                                    <div class="col-md-7 col-sm-12 col-xs-12 product-images-wrapper">
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 col-md-offset-1 product-summary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			<?php } ?>
            <div class="unero-loader"></div>
        </div>

		<?php
	}

endif;

add_action( 'wp_footer', 'unero_quick_view_modal' );

/**
 * Dispaly back to top
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_back_to_top' ) ) :
	function unero_back_to_top() {

		if ( unero_get_option( 'back_to_top' ) ) : ?>
            <a id="scroll-top" class="backtotop" href="#page-top">
                <i class="fa fa-angle-up"></i>
            </a>
		<?php endif; ?>
		<?php
	}
endif;

add_action( 'wp_footer', 'unero_back_to_top' );