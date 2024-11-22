<?php

/**
 * Class for all WooCommerce template modification
 *
 * @version 1.0
 */
class Unero_WooCommerce {
	/**
	 * @var string Layout of current page
	 */
	public $layout;

	/**
	 * @var string shop view
	 */
	public $shop_view;

	/**
	 * Construction function
	 *
	 * @since  1.0
	 * @return unero_WooCommerce
	 */
	function __construct() {
		// Check if Woocomerce plugin is actived
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}

		// Define all hook
		add_action( 'template_redirect', array( $this, 'hooks' ) );

		// Need an early hook to ajaxify update mini shop cart
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );

		add_action( 'wp_ajax_unero_remove_mini_cart_item', array( $this, 'remove_mini_cart_item' ) );
		add_action( 'wp_ajax_nopriv_unero_remove_mini_cart_item', array( $this, 'remove_mini_cart_item' ) );

		add_action( 'wp_ajax_unero_search_products', array( $this, 'instance_search_result' ) );
		add_action( 'wp_ajax_nopriv_unero_search_products', array( $this, 'instance_search_result' ) );

		add_action( 'wp_ajax_unero_update_wishlist_count', array( $this, 'update_wishlist_count' ) );
		add_action( 'wp_ajax_nopriv_unero_update_wishlist_count', array( $this, 'update_wishlist_count' ) );

		add_filter( 'posts_search', array( $this, 'product_search_sku' ), 9 );

		add_filter( 'template_include', array( $this, 'single_product_template_loader' ), 20 );

		add_action( 'wp_ajax_unero_product_quick_view', array( $this, 'product_quick_view' ) );
		add_action( 'wp_ajax_nopriv_unero_product_quick_view', array(
			$this,
			'product_quick_view',
		) );

		// QuicKview
		add_action( 'unero_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		add_action( 'unero_single_product_summary', 'woocommerce_template_single_title', 5 );
		add_action( 'unero_single_product_summary', 'woocommerce_template_single_rating', 10 );
		add_action( 'unero_single_product_summary', 'woocommerce_template_single_price', 10 );
		add_action( 'unero_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		add_action( 'unero_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		add_action( 'unero_single_product_summary', array( $this, 'share' ), 30 );
		add_action( 'unero_single_product_summary', array( $this, 'product_wishlist' ), 30 );

		if ( class_exists( 'TA_WC_Variation_Swatches_Frontend' ) && is_admin() ) {
			add_action( 'init', array( 'TA_WC_Variation_Swatches_Frontend', 'instance' ) );
		}

	}

	/**
	 * Hooks to WooCommerce actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	function hooks() {
		$this->layout       = unero_get_layout();
		$this->new_duration = unero_get_option( 'product_newness' );
		$this->shop_view    = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : unero_get_option( 'shop_view' );

		if ( unero_is_catalog() ) {
			if ( in_array( unero_get_option( 'catalog_layout' ), array( 'board-content', 'masonry-content' ) ) ) {
				$this->shop_view = 'grid';
			}
		}

		if ( function_exists( 'wsl_render_auth_widget_in_wp_login_form' ) ) {
			add_action( 'woocommerce_login_form_end', 'wsl_render_auth_widget_in_wp_login_form' );
		}

		// WooCommerce Styles
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'wc_styles' ) );

		// Remove breadcrumb, use theme's instead
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// Remove badges
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );

		// remove add to cart link
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

		// Remove product link
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

		// Add Bootstrap classes
		add_filter( 'post_class', array( $this, 'product_class' ), 30, 3 );

		add_filter( 'product_cat_class', array( $this, 'product_cat_class' ), 30, 3 );


		// Wrap product loop content
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'open_product_inner' ), 1 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_product_inner' ), 50 );

		// Add product thumbnail
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_content_thumbnail' ) );

		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product_add_to_cart' ), 6 );

		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product_link' ), 6 );

		// Add WishList link
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product_wishlist' ), 7 );


		// Add product title link
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'products_title' ), 10 );

		// Change shop columns
		add_filter( 'loop_shop_columns', array( $this, 'shop_columns' ), 20 );

		// Remove Product Meta in Prouduct Summary
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 10 );


		// Show share icons
		add_action( 'woocommerce_single_product_summary', array( $this, 'share' ), 30 );

		// Change product stock html
		add_filter( 'woocommerce_get_stock_html', array( $this, 'product_stock_html' ), 10, 2 );

		// Change variable text
		add_filter( 'woocommerce_dropdown_variation_attribute_options_args', array(
			$this,
			'variation_attribute_options',
		) );

		// remove description heading
		add_filter( 'woocommerce_product_description_heading', '__return_false' );

		// Change comment notes before
		add_filter( 'woocommerce_product_review_comment_form_args', array( $this, 'review_comment_form_args' ) );

		// remove products upsell display
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

		// Add product upsell
		if ( intval( unero_get_option( 'product_upsells' ) ) ) {
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'upsell_products' ), 15 );
		}

		// Change number of related products
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products' ) );

		// Add product size guide in product tabs
		add_filter( 'woocommerce_product_tabs', array( $this, 'product_size_guide' ) );

		// Add product shipping in product tabs
		add_filter( 'woocommerce_product_tabs', array( $this, 'product_shipping' ) );

		// Add instagram photos
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'instagram_photos' ), 10 );

		// Change possition cross sell
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );

		// Change columns and total of cross sell
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'cross_sells_columns' ) );
		add_filter( 'woocommerce_cross_sells_total', array( $this, 'cross_sells_numbers' ) );

		// Orders account
		add_action( 'woocommerce_account_dashboard', 'woocommerce_account_orders', 5 );
		// Add orders title
		add_action( 'woocommerce_before_account_orders', array( $this, 'orders_title' ), 10, 1 );

		// billing address
		add_action( 'woocommerce_account_dashboard', 'woocommerce_account_edit_address', 15 );

		// Remove shop page title
		add_filter( 'woocommerce_show_page_title', '__return_false' );

		// Remove shop result count
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

		// Remove catelog ordering
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		// Add Shop Toolbar
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_toolbar' ), 20 );

		// Add Shop Topbar
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_topbar' ), 25 );

		// Add Shop Bottombar
		add_action( 'unero_after_footer', array( $this, 'shop_bottombar' ), 15 );

		// Categories Grid
		add_action( 'unero_after_header', array( $this, 'categories_grid' ), 40 );

		// Shop description
		add_action( 'woocommerce_archive_description', array( $this, 'shop_description' ), 15 );

		// Show except in shop view list
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5 );

		// Change length of description
		add_filter( 'unero_short_description', array( $this, 'short_description' ) );
		add_filter( 'unero_short_description', 'wptexturize' );
		add_filter( 'unero_short_description', 'convert_smilies' );
		add_filter( 'unero_short_description', 'convert_chars' );
		add_filter( 'unero_short_description', 'wpautop' );
		add_filter( 'unero_short_description', 'shortcode_unautop' );
		add_filter( 'unero_short_description', 'prepend_attachment' );
		add_filter( 'unero_short_description', 'do_shortcode', 11 ); // AFTER wpautop()
		add_filter( 'unero_short_description', 'wc_format_product_short_description', 9999999 );

		// Change catalog orderby
		add_filter( 'woocommerce_catalog_orderby', array( $this, 'catalog_orderby' ), 20 );

		// Change HTML nav count
		add_filter( 'woocommerce_layered_nav_count', array( $this, 'layered_nav_count' ), 20, 2 );

		// Add div before shop loop
		add_action( 'woocommerce_before_shop_loop', array( $this, 'before_shop_loop' ), 30 );

		// Add div before empty shop
		add_action( 'woocommerce_no_products_found', array( $this, 'before_shop_loop' ), 1 );

		// Add div after shop loop
		add_action( 'woocommerce_after_shop_loop', array( $this, 'after_shop_loop' ), 20 );

		// Add div after empty shop
		add_action( 'woocommerce_no_products_found', array( $this, 'after_shop_loop' ), 100 );

		// Add loading shop
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_loading' ), 40 );

		// Add loading shop for empty catalog
		add_action( 'woocommerce_no_products_found', array( $this, 'shop_loading' ), 5 );

		// Add post class
		add_filter( 'post_class', array( $this, 'product_post_class' ), 30, 3 );

		add_filter( 'woocommerce_product_review_comment_form_args', array(
			$this,
			'product_review_comment_form_args',
		), 30 );

		// add product attribute
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product_attribute' ), 4 );

		add_filter( 'woocommerce_get_price_html_from_to', array( $this, 'get_price_html_from_to' ), 20, 4 );

		add_filter( 'unero_after_single_product_image', array( $this, 'product_thumbnails' ) );

		if ( ! intval( unero_get_option( 'product_related' ) ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}

		// Add WishList link
		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'single_product_wishlist' ) );

		add_action( 'woocommerce_single_product_summary', array( $this, 'single_product_breadcrumb' ), 1 );

		add_filter( 'woocommerce_gallery_image_size', array( $this, 'gallery_image_size' ) );


	}

	/**
	 * Ajaxify update cart viewer
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	function add_to_cart_fragments( $fragments ) {
		global $woocommerce;

		if ( empty( $woocommerce ) ) {
			return $fragments;
		}

		ob_start();
		$icon_cart = '<i class="t-icon icon-bag2"></i>';
		?>

        <a href="<?php echo esc_url( wc_get_cart_url() ) ?>" class="cart-contents" id="icon-cart-contents">
			<?php echo apply_filters( 'unero_icon_cart', $icon_cart ); ?>
            <span class="mini-cart-counter"><?php echo intval( $woocommerce->cart->cart_contents_count ) ?></span>
        </a>

		<?php
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}


	/**
	 * Remove default woocommerce styles
	 *
	 * @since  1.0
	 *
	 * @param  array $styles
	 *
	 * @return array
	 */
	function wc_styles( $styles ) {
		unset( $styles['woocommerce-layout'] );
		unset( $styles['woocommerce-smallscreen'] );

		return $styles;
	}

	/**
	 * Change the shop columns
	 *
	 * @since  1.0.0
	 *
	 * @param  int $columns The default columns
	 *
	 * @return int
	 */
	function shop_columns( $columns ) {
		$columns = intval( unero_get_option( 'product_columns' ) );
		if ( unero_is_catalog() ) {
			if ( unero_get_option( 'catalog_layout' ) == 'board-content' ) {
				$columns = 2;
			} elseif ( unero_get_option( 'catalog_layout' ) == 'masonry-content' ) {
				$columns = 3;
			}
		}


		return apply_filters( 'unero_shop_columns', $columns );

	}


	/**
	 * Add Bootstrap's column classes for product
	 *
	 * @since 1.0
	 *
	 * @param array $classes
	 * @param string $class
	 * @param string $post_id
	 *
	 * @return array
	 */
	function product_class( $classes, $class = '', $post_id = '' ) {
		if ( ! $post_id || get_post_type( $post_id ) !== 'product' || is_single( $post_id ) ) {
			return $classes;
		}
		global $woocommerce_loop;

		$sm_class = 'col-sm-4';

		if ( $woocommerce_loop['columns'] == 2 ) {
			$sm_class = 'col-sm-6';
		}

		if ( ! is_search() ) {
			$classes[] = 'col-xs-6 ' . $sm_class;
			$classes[] = 'col-md-' . ( 12 / $woocommerce_loop['columns'] );
			$classes[] = 'un-' . $woocommerce_loop['columns'] . '-cols';
		} else {
			if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
				$classes[] = 'col-xs-6 ' . $sm_class;
				$classes[] = 'col-md-' . ( 12 / $woocommerce_loop['columns'] );
				$classes[] = 'un-' . $woocommerce_loop['columns'] . '-cols';
			}
		}

		return $classes;
	}

	/**
	 * Add Bootstrap's column classes for product cat
	 *
	 * @since 1.0
	 *
	 * @param array $classes
	 * @param string $class
	 * @param string $post_id
	 *
	 * @return array
	 */
	function product_cat_class( $classes, $class = '', $category = '' ) {
		if ( is_search() ) {
			return $classes;
		}

		global $woocommerce_loop;

		$sm_class = 'col-sm-4';

		if ( $woocommerce_loop['columns'] == 2 ) {
			$sm_class = 'col-sm-6';
		}

		$classes[] = 'col-xs-6 ' . $sm_class;
		$classes[] = 'col-md-' . ( 12 / $woocommerce_loop['columns'] );
		$classes[] = 'un-' . $woocommerce_loop['columns'] . '-cols';

		return $classes;
	}

	/**
	 * Wrap product content
	 * Open a div
	 *
	 * @since 1.0
	 */
	function open_product_inner() {
		echo '<div class="product-inner  clearfix">';
	}

	/**
	 * Wrap product content
	 * Close a div
	 *
	 * @since 1.0
	 */
	function close_product_inner() {
		echo '</div>';
	}

	/**
	 * WooCommerce Loop Product Content Thumbs
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function product_content_thumbnail() {
		global $product, $post, $woocommerce_loop;;

		$attachment_ids  = $product->get_gallery_image_ids();
		$secondary_thumb = intval( unero_get_option( 'disable_secondary_thumb' ) );

		$css_image = 'un-loop-thumbnail';
		if ( count( $attachment_ids ) == 0 || $secondary_thumb ) {
			$css_image .= ' product-thumbnail-single';
		}

		printf( '<a class="%s" href ="%s">', esc_attr( $css_image ), esc_url( get_the_permalink() ) );

		$image_size = 'shop_catalog';

		$lazy_load = true;
		if ( unero_is_catalog() ) {
			if ( unero_get_option( 'catalog_layout' ) == 'masonry-content' ) {
				$image_size = 'unero-product-masonry-normal';

				if ( $woocommerce_loop && isset( $woocommerce_loop['loop'] ) ) {
					$index = intval( $woocommerce_loop['loop'] ) % 12;
					if ( in_array( $index, array( 1, 9 ) ) ) {
						$image_size = 'unero-product-masonry-long';
					} elseif ( in_array( $index, array( 2, 8 ) ) ) {
						$image_size = 'unero-product-masonry-large';
					}
				}
			} elseif ( unero_get_option( 'catalog_layout' ) == 'board-content' ) {
				$lazy_load = false;
			}
		}


		$image_size = apply_filters( 'single_product_archive_thumbnail_size', $image_size );
		if ( has_post_thumbnail() ) {
			$post_thumbnail_id = get_post_thumbnail_id( $post );
			if ( $lazy_load ) {
				echo unero_get_image_html( $post_thumbnail_id, $image_size );

			} else {
				echo wp_get_attachment_image( $post_thumbnail_id, $image_size );

			}

		}

		if ( ! $secondary_thumb ) {
			if ( count( $attachment_ids ) > 0 && isset ( $attachment_ids[0] ) ) {
				echo unero_get_image_html( $attachment_ids[0], $image_size, 'image-hover' );
			}

		}


		$this->product_ribbons();

		echo '</a>';

		$qv_class = '';
		if ( ! intval( unero_get_option( 'product_quick_view' ) ) ) {
			$qv_class = 'no-quick-view';
		}

		echo sprintf( '<div class="footer-button %s">', esc_attr( $qv_class ) );

		if ( intval( unero_get_option( 'product_quick_view' ) ) ) {
			$quick_view = apply_filters( 'unero_product_quick_view_text', esc_attr__( 'Quick View', 'unero' ) );
			echo '<a href="' . esc_url( $product->get_permalink() ) . '" data-id = "' . esc_attr( $product->get_id() ) . '"  class="product-quick-view"><i class="p-icon icon-plus" data-original-title="' . $quick_view . '" rel="tooltip"></i></a>';
		}

		if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {
			woocommerce_template_loop_add_to_cart();
		}

		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}

		echo '</div>';

	}

	/**
	 * WooCommerce Loop Product quick view
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function product_add_to_cart() {
		if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {
			woocommerce_template_loop_add_to_cart();
		}
	}

	/**
	 * WooCommerce Loop Product link
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function product_link() {

		if ( ! unero_is_catalog() ) {
			return;
		}

		if ( unero_get_option( 'catalog_layout' ) != 'masonry-content' ) {
			return;
		}

		printf( '<a href="%s" class="un-product-link"></a>', esc_url( get_the_permalink() ) );
	}


	/**
	 * WooCommerce Loop Product quick view
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function product_wishlist() {
		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}
	}

	/**
	 * Add product title link
	 *
	 * @since  1.0
	 *
	 * @param  array $styles
	 *
	 * @return array
	 */
	function products_title() {
		printf( '<h2 class="un-product-title"><a href="%s">%s</a></h2>', esc_url( get_the_permalink() ), get_the_title() );
	}

	/**
	 * Display Addthis sharing
	 *
	 * @since 1.0
	 */
	function share() {

		if ( ! intval( unero_get_option( 'show_product_socials' ) ) ) {
			return;
		}
		if ( function_exists( 'unero_share_link_socials' ) ) {
			global $product;
			$image_id   = $product->get_image_id();
			$image_link = '';
			if ( $image_id ) {
				$image_link = wp_get_attachment_url( $image_id );
			}
			echo unero_share_link_socials( $product->get_title(), $product->get_permalink(), $image_link );
		}

	}

	/**
	 * Display product stock
	 *
	 * @since 1.0
	 */
	function product_stock_html( $availability_html, $product ) {
		$availability      = $product->get_availability();
		$available_text    = apply_filters( 'unero_product_available_text', esc_html__( 'Available', 'unero' ) );
		$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . $available_text . ': <span>' . esc_html( $availability['availability'] ) . '</span>' . '</p>';

		return $availability_html;
	}

	/**
	 * Change variation text
	 *
	 * @since 1.0
	 */
	function variation_attribute_options( $args ) {
		$attribute = $args['attribute'];
		if ( function_exists( 'wc_attribute_label' ) && $attribute ) {
			$args['show_option_none'] = esc_html__( 'Select', 'unero' ) . ' ' . wc_attribute_label( $attribute );
		}

		return $args;
	}

	/**
	 * Change variation text
	 *
	 * @since 1.0
	 */
	function review_comment_form_args( $args ) {
		$args['comment_notes_before'] = '<p class="comment-notes">' . esc_html__( 'Your email address will not be published. Required fields are marked ', 'unero' ) . '<span class="required">*</span>' . '</p>';

		return $args;
	}

	/**
	 * Remove mini cart item
	 *
	 * @since 1.0
	 */
	function remove_mini_cart_item() {
		global $woocommerce;
		$nonce       = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';
		$remove_item = isset( $_POST['item'] ) ? $_POST['item'] : '';
		$response    = 0;
		if ( wp_verify_nonce( $nonce, '_unero_nonce' ) && ! empty( $remove_item ) ) {
			$woocommerce->cart->remove_cart_item( $remove_item );
			$response = 1;
		}
		// Send the comment data back to Javascript.
		wp_send_json_success( $response );
		die();
	}

	/**
	 * Display upsell products
	 *
	 * @since 1.0
	 */
	function upsell_products() {
		$upsell_numbers = intval( unero_get_option( 'upsells_products_numbers' ) );
		$upsell_columns = intval( unero_get_option( 'upsells_products_columns' ) );

		if ( $upsell_columns && $upsell_numbers ) {
			woocommerce_upsell_display( $upsell_numbers, $upsell_columns );
		}

	}

	/**
	 * Change related products args to display in correct grid
	 *
	 * @param  array $args
	 *
	 * @return array
	 */
	function related_products( $args ) {

		$args['posts_per_page'] = intval( unero_get_option( 'related_products_numbers' ) );;
		$args['columns'] = intval( unero_get_option( 'related_products_columns' ) );

		return $args;
	}

	/**
	 * Add product size guide
	 *
	 * @param  array $args
	 *
	 * @return array
	 */
	function product_size_guide( $args ) {
		global $product;
		$product_custom_tab1 = get_theme_mod( 'custom_product_tab_1', esc_html__( 'Size Guide', 'unero' ) );
		$size_guide          = get_post_meta( $product->get_id(), 'unero_product_size_guide', true );
		if ( $size_guide ) {
			$args['size_guide'] = array(
				'title'    => $product_custom_tab1,
				'priority' => 25,
				'callback' => 'unero_product_size_guide',
			);
		}

		return $args;
	}

	/**
	 * Add product size guide
	 *
	 * @param  array $args
	 *
	 * @return array
	 */
	function product_shipping( $args ) {
		global $product;

		$product_custom_tab2 = get_theme_mod( 'custom_product_tab_2', esc_html__( 'Shipping', 'unero' ) );
		$shipping            = get_post_meta( $product->get_id(), 'unero_product_shipping', true );
		if ( $shipping ) {
			$args['shipping'] = array(
				'title'    => $product_custom_tab2,
				'priority' => 25,
				'callback' => 'unero_product_shipping',
			);
		}

		return $args;
	}

	/**
	 * Change number of columns when display cross sells products
	 *
	 * @param  int $cl
	 *
	 * @return int
	 */
	function cross_sells_columns( $cross_columns ) {
		return apply_filters( 'unero_cross_sells_columns', 4 );
	}

	/**
	 * Change number of columns when display cross sells products
	 *
	 * @param  int $cl
	 *
	 * @return int
	 */
	function cross_sells_numbers( $cross_numbers ) {
		return apply_filters( 'unero_cross_sells_total', 4 );
	}

	/**
	 * Display instagram photos by hashtag
	 *
	 * @return string
	 */
	function instagram_photos() {

		if ( ! intval( unero_get_option( 'product_instagram' ) ) ) {
			return;
		}

		global $post;
		$default_hashtag = get_post_meta( $post->ID, 'product_instagram_hashtag', true );
		$numbers         = unero_get_option( 'product_instagram_numbers' );
		$title           = unero_get_option( 'product_instagram_title' );
		$columns         = unero_get_option( 'product_instagram_columns' );
		$image_size      = unero_get_option( 'product_instagram_image_size' );
		echo unero_instagram_photos( $default_hashtag, $numbers, $title, $columns, 0, false, $image_size );
	}

	/**
	 * Display orders tile
	 *
	 * @since 1.0
	 */
	function orders_title( $has_orders ) {
		if ( $has_orders ) {
			printf( '<h2 class="orders-title">%s</h2>', esc_html__( 'Orders History', 'unero' ) );
		}
	}

	/**
	 * Display a tool bar on top of product archive
	 *
	 * @since 1.0
	 */
	function shop_toolbar() {
		if ( ! unero_is_catalog() ) {
			return;
		}
		if ( ! intval( unero_get_option( 'shop_toolbar' ) ) ) {
			return;
		}

		$elements = $this->get_toolbar_elements();
		if ( ! $elements ) {
			return;
		}

		$output = array();

		$shop_view = '';
		if ( in_array( 'view', $elements ) ) {
			$list_current = $this->shop_view == 'list' ? 'current' : '';
			$grid_current = $this->shop_view == 'grid' ? 'current' : '';
			$shop_view    = sprintf(
				'<a href="#" class="list-view un-shop-view %s" data-view="list"><i class="icon-menu2"></i></a>' .
				'<a href="#" class="grid-view un-shop-view %s" data-view="grid"><i class="icon-icons2"></i></a>',
				$list_current,
				$grid_current
			);
		}

		$categories_filter = '';
		if ( in_array( 'categories', $elements ) ) {
			$categories_filter = $this->get_categories_filter();
		}

		$filters = '';
		if ( in_array( 'filters', $elements ) ) {
			$filters = sprintf( '<a href="#" class="un-filter filters">%s <i class="icon-plus"></i> </a>', esc_html__( 'Filters', 'unero' ) );
		}

		$found = '';
		if ( in_array( 'found', $elements ) ) {
			global $wp_query;
			if ( $wp_query && isset( $wp_query->found_posts ) ) {
				$found = '<span>' . $wp_query->found_posts . ' </span>' . esc_html__( 'Products Found', 'unero' );
			}

			if ( $found ) {
				$found = sprintf( '<span class="product-found">%s</span>', $found );
			}
		}

		$sort_by     = '';
		$sort_by_cls = 'hidden';
		if ( in_array( 'sort_by', $elements ) ) {
			ob_start();
			woocommerce_catalog_ordering();
			$sort_by     = ob_get_clean();
			$sort_by_cls = '';
		}

		if ( in_array( unero_get_option( 'catalog_layout' ), array( 'board-content', 'masonry-content' ) ) ) {
			if ( $categories_filter ) {
				$output[] = sprintf( '<div class="col-md-12 col-sm-12 col-xs-12 text-center">%s %s</div>', $categories_filter, $filters );
			}

		} else {
			$toolbar_layout = unero_get_option( 'shop_toolbar_layout' );
			if ( $toolbar_layout == '1' ) {
				$output[] = sprintf( '<div class="col-md-9 col-sm-12 col-xs-12 un-categories-left">%s</div>', $categories_filter );
				$output[] = sprintf( '<div class="col-md-3 col-sm-6 col-xs-6 text-right toolbar-right">%s %s</div>', $shop_view, $filters );
			} elseif ( $toolbar_layout == '2' ) {

				$col_found = 'col-lg-5 hidden-md hidden-sm hidden-xs';
				$col_sort  = 'col-lg-7 col-md-12 col-sm-12 col-xs-12';

				$col_left  = 'col-lg-9 col-md-6 col-sm-6 col-xs-6';
				$col_right = 'col-lg-3 col-md-6 col-sm-6 col-xs-6';

				if ( unero_get_layout() == 'full-content' ) {
					if ( $found ) {
						$col_found = 'col-md-4 hidden-sm hidden-xs col-found';
						$col_sort  = 'col-md-8 col-sm-12 col-xs-12';
					} else {
						$col_sort = 'col-md-12 col-sm-12 col-xs-12';
					}

					$col_left  = 'col-md-9 col-sm-6 col-xs-6 col-toolbar-right';
					$col_right = 'col-md-3 col-sm-6 col-xs-6';
				}

				$output[] = sprintf(
					'<div class="%s">' .
					'<div class="row">' .
					'<div class="%s">%s</div>' .
					'<div class="%s"><div class="un-ordering %s" id="un-ordering">%s</div> %s </div>' .
					'</div></div>',
					esc_attr( $col_left ),
					esc_attr( $col_found ),
					$found,
					esc_attr( $col_sort ),
					esc_attr( $sort_by_cls ),
					esc_html__( 'Sort By', 'unero' ),
					$sort_by
				);
				$output[] = sprintf( '<div class="%s text-right toolbar-right">%s %s</div>', esc_attr( $col_right ), $shop_view, $filters );
			}
		}

		if ( $output ) {
			?>
            <div id="un-shop-toolbar" class="shop-toolbar">
                <div class="row">
					<?php echo implode( ' ', $output ); ?>
                </div>
            </div>
			<?php
		}
	}

	/**
	 * Display a top bar on top of product archive
	 *
	 * @since 1.0
	 */
	function shop_topbar() {
		if ( ! unero_is_catalog() ) {
			return;
		}

		$this->shop_filter_content();
	}

	/**
	 * Display a bottom bar on top of product archive
	 *
	 * @since 1.0
	 */
	function shop_bottombar() {

		if ( ! unero_is_catalog() ) {
			return;
		}

		if ( ! in_array( unero_get_option( 'catalog_layout' ), array( 'board-content', 'masonry-content' ) ) ) {
			return;
		}

		$elements = $this->get_toolbar_elements();
		if ( ! $elements ) {
			return;
		}

		if ( ! in_array( 'filters', $elements ) ) {
			return;
		}

		echo '<div class="shop-bottombar"><div class="container"><div class="shop-bottombar-content">';
		printf( '<div class="filters-bottom"><a href="#" class="un-filter filters">%s <i class="icon-plus"></i> </a></div>', esc_html__( 'Filters', 'unero' ) );

		echo '</div></div></div>';
	}

	/**
	 * Display a top bar on top of product archive
	 *
	 * @since 1.0
	 */
	function shop_filter_content() {
		if ( ! unero_is_catalog() ) {
			return;
		}

		$columns       = intval( unero_get_option( 'shop_filter_widget_columns' ) );
		$columns_class = $columns ? 'widgets-' . $columns : '';
		?>
        <div id="un-shop-topbar" class="widgets-area shop-topbar <?php echo esc_attr( $columns_class ); ?>">
            <div class="shop-topbar-content">
				<?php
				$sidebar = 'catalog-filter';
				if ( is_active_sidebar( $sidebar ) ) {
					dynamic_sidebar( $sidebar );
				}
				?>
                <div class="shop-filter-actived">
					<?php
					global $wp_query;
					if ( $wp_query && isset( $wp_query->found_posts ) ) {
						echo '<span class="found">' . $wp_query->found_posts . ' </span>' . esc_html__( 'Products Found', 'unero' );
					}

					$link = unero_get_page_base_url();

					if ( $_GET ) {
						printf( '<a href="%s" id="remove-filter-actived" class="remove-filter-actived"><i class="icon-cross2"></i>%s</a>', esc_url( $link ), esc_html__( 'Clear All Filter', 'unero' ) );
					}

					?>
                </div>
            </div>
        </div>

		<?php

		if ( ! in_array( unero_get_option( 'catalog_layout' ), array( 'board-content', 'masonry-content' ) ) ) {
			return;
		}

		$elements = $this->get_toolbar_elements();
		if ( ! $elements ) {
			return;
		}

		if ( ! in_array( 'filters', $elements ) ) {
			return;
		}

		echo '<div id="un-filter-overlay" class="un-filter-overlay"></div>';
	}

	/**
	 * Display badge for new product or featured product
	 *
	 * @since 1.0
	 */
	function product_ribbons() {
		global $product;


		if ( intval( unero_get_option( 'show_badges' ) ) ) {
			$output = array();
			$badges = unero_get_option( 'badges' );
			// Change the default sale ribbon

			$custom_badges = maybe_unserialize( get_post_meta( $product->get_id(), 'custom_badges_text', true ) );
			if ( $custom_badges ) {

				$output[] = '<span class="custom ribbon">' . esc_html( $custom_badges ) . '</span>';

			} else {
				if ( ! $product->is_in_stock() && in_array( 'outofstock', $badges ) ) {
					$outofstock = unero_get_option( 'outofstock_text' );
					if ( ! $outofstock ) {
						$outofstock = esc_html__( 'Out Of Stock', 'unero' );
					}
					$output[] = '<span class="out-of-stock ribbon">' . esc_html( $outofstock ) . '</span>';
				} elseif ( $product->is_on_sale() && in_array( 'sale', $badges ) ) {
					$percentage = 0;
					if ( $product->get_type() == 'variable' ) {
						$available_variations = $product->get_available_variations();
						$max_percentage       = 0;

						for ( $i = 0; $i < count( $available_variations ); $i ++ ) {
							$variation_id     = $available_variations[ $i ]['variation_id'];
							$variable_product = new WC_Product_Variation( $variation_id );
							$regular_price    = $variable_product->get_regular_price();
							$sales_price      = $variable_product->get_sale_price();
							if ( empty( $sales_price ) ) {
								continue;
							}
							$percentage = $regular_price ? round( ( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 ) ) : 0;

							if ( $percentage > $max_percentage ) {
								$max_percentage = $percentage;
							}
						}
					} elseif ( $product->get_type() == 'simple' || $product->get_type() == 'external' ) {
						$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
					}

					if ( $percentage ) {
						$output[] = '<span class="onsale ribbon"><span class="sep">-</span>' . ' ' . $percentage . '%' . '</span>';
					}
				} elseif ( $product->is_featured() && in_array( 'hot', $badges ) ) {
					$hot = unero_get_option( 'hot_text' );
					if ( ! $hot ) {
						$hot = esc_html__( 'Hot', 'unero' );
					}
					$output[] = '<span class="featured ribbon">' . esc_html( $hot ) . '</span>';
				} elseif ( ( time() - ( 60 * 60 * 24 * $this->new_duration ) ) < strtotime( get_the_time( 'Y-m-d' ) ) && in_array( 'new', $badges ) ||
				           get_post_meta( $product->get_id(), '_is_new', true ) == 'yes'
				) {
					$new = unero_get_option( 'new_text' );
					if ( ! $new ) {
						$new = esc_html__( 'New', 'unero' );
					}
					$output[] = '<span class="newness ribbon">' . esc_html( $new ) . '</span>';
				}
			}


			if ( $output ) {
				printf( '<span class="ribbons">%s</span>', implode( '', $output ) );
			}


		}
	}

	function product_in_stock_status() {
		global $product;

		$instock = false;
		if ( $product->get_type() == 'variable' ) {
			$available_variations = $product->get_available_variations();

			for ( $i = 0; $i < count( $available_variations ); $i ++ ) {
				$variation_id     = $available_variations[ $i ]['variation_id'];
				$variable_product = new WC_Product_Variation( $variation_id );
				if ( $variable_product->get_stock_status() == 'instock' ) {
					$instock = true;
					break;
				}
			}
		} elseif ( $product->get_stock_status() == 'instock' ) {
			$instock = true;
		}

		return $instock;
	}

	/**
	 * Get toolbar elements
	 *
	 * @since 1.0
	 */
	function get_toolbar_elements() {

		if ( in_array( unero_get_option( 'catalog_layout' ), array( 'board-content', 'masonry-content' ) ) ) {
			return unero_get_option( 'shop_toolbar_els3' );
		} else {

			if ( unero_get_option( 'shop_toolbar_layout' ) == '1' ) {
				return unero_get_option( 'shop_toolbar_els1' );
			} elseif ( unero_get_option( 'shop_toolbar_layout' ) == '2' ) {
				return unero_get_option( 'shop_toolbar_els2' );
			}
		}

		return false;
	}

	/**
	 * show categories filter
	 *
	 * @return string
	 */
	function get_categories_filter() {

		$filters    = '';
		$found      = false;
		$output     = array();
		$cats_slug  = unero_get_option( 'shop_cats_slug1' );
		$cats_order = unero_get_option( 'shop_cats_order_1' );

		if ( in_array( unero_get_option( 'catalog_layout' ), array( 'board-content', 'masonry-content' ) ) ) {
			$cats_slug  = unero_get_option( 'shop_cats_slug3' );
			$cats_order = unero_get_option( 'shop_cats_order_3' );
		}

		$current_id = '';
		if ( is_tax( 'product_cat' ) ) {
			$queried_object = get_queried_object();
			if ( $queried_object ) {
				$current_id = $queried_object->term_id;
			}
		}

		$term_id = 0;
		$args    = array(
			'parent' => $term_id,
			'number' => apply_filters( 'unero_product_categories_filter', 4 ),
		);

		$args['menu_order'] = false;

		if ( 'order' === $cats_order ) {
			$args['menu_order'] = 'asc';
		} else {
			$args['orderby'] = $cats_order;
			if ( $cats_order === 'count' ) {
				$args['order'] = 'desc';
			}
		}

		if ( $cats_slug ) {
			$cats_id = array();
			foreach ( $cats_slug as $slug ) {
				$cat = get_term_by( 'slug', $slug, 'product_cat' );
				if ( ! is_wp_error( $cat ) && $cat ) {
					$cats_id[] = $cat->term_id;
				}
			}

			$args['include'] = $cats_id;
			$args['number']  = false;
			$args['parent']  = '';
		}

		$categories = get_terms( 'product_cat', $args );


		if ( ! is_wp_error( $categories ) && $categories ) {
			foreach ( $categories as $cat ) {

				$css_class = '';
				if ( $cat->term_id == $current_id ) {
					$css_class = 'selected';
					$found     = true;
				}
				$filters .= sprintf( '<li><a class="%s" href="%s">%s</a></li>', esc_attr( $css_class ), esc_url( get_term_link( $cat ) ), esc_html( $cat->name ) );
			}
		}


		$css_class = $found ? '' : 'selected';

		if ( $filters ) {
			$output[] = sprintf(
				'<ul class="option-set" data-option-key="filter">
				<li><a href="%s" class="%s">%s</a></li>
				 %s
			</ul>',
				esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ),
				esc_attr( $css_class ),
				esc_html__( 'All', 'unero' ),
				$filters
			);
		}


		return '<div class="un-toggle-cats-filter" id="un-toggle-cats-filter">' . esc_html__( 'Categories', 'unero' ) . '</div> <div id="un-categories-filter" class="un-categories-filter">' . implode( "\n", $output ) . '</div>';

	}

	/**
	 * Chnage length of  product description
	 *
	 * @since  1.0
	 *
	 * @param  string $desc
	 *
	 * @return string
	 */
	function short_description( $desc ) {

		if ( empty( $desc ) ) {
			return $desc;
		}

		if ( unero_is_catalog() ) {
			$length = intval( unero_get_option( 'shop_expert_length' ) );

			return unero_content_limit( $desc, $length, false );
		}

		return $desc;
	}

	/**
	 * Change the catalog orderby
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function catalog_orderby() {
		$catalog_orderby_options = array(
			'menu_order' => esc_html__( 'Default', 'unero' ),
			'popularity' => esc_html__( 'Popularity', 'unero' ),
			'rating'     => esc_html__( 'Average rating', 'unero' ),
			'date'       => esc_html__( 'Newness', 'unero' ),
			'price'      => esc_html__( 'Price: low to high', 'unero' ),
			'price-desc' => esc_html__( 'Price: high to low', 'unero' ),
		);

		return $catalog_orderby_options;
	}

	/**
	 * Change HTML of nav widget
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function layered_nav_count( $output, $count ) {
		$output = '<span class="count">' . absint( $count ) . '</span>';

		return $output;
	}

	/**
	 * Shop loading
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function shop_loading() {
		if ( ! unero_is_catalog() ) {
			return;
		}
		echo '<div id="un-shop-loading" class="un-shop-loading"><div class="unero-loader"></div></div>';
	}

	/**
	 * Shop loading
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function before_shop_loop() {
		if ( ! unero_is_catalog() ) {
			return;
		}
		echo '<div id="un-shop-content" class="un-shop-content">';
	}

	/**
	 * Shop loading
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function after_shop_loop() {
		if ( ! unero_is_catalog() ) {
			return;
		}
		echo '</div>';
	}

	/**
	 * Get shop description
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function shop_description() {


		if ( intval( unero_get_option( 'catalog_element_only' ) ) ) {
			if ( ! unero_is_catalog() ) {
				return;
			}
		} else {
			if ( function_exists( 'is_shop' ) && ! is_shop() ) {
				return;
			}
		}

		$shop_element = unero_get_option( 'shop_element' );

		if ( ! $shop_element ) {
			return;
		}

		if ( $shop_element != 'shop_description' ) {
			return;
		}

		$descs = unero_get_option( 'shop_description' );
		if ( empty ( $descs ) ) {
			return;
		}

		$output    = array();
		$css_class = '';
		foreach ( $descs as $dc ) {
			if ( isset( $dc['title'] ) && $dc['title'] ) {
				$output[] = sprintf( '<h3 class="title">%s</h3>', wp_kses( $dc['title'], wp_kses_allowed_html( 'post' ) ) );
			}

			if ( isset( $dc['desc'] ) && $dc['desc'] ) {
				$output[] = sprintf( '<div class="desc">%s</div>', wp_kses( $dc['desc'], wp_kses_allowed_html( 'post' ) ) );
			}

			if ( isset( $dc['style'] ) && $dc['style'] == '2' ) {
				$css_class = 'style-2';
			}

			continue;
		}

		if ( $output ) {
			printf(
				'<div class="un-shop-desc %s">' .
				'<div class="container">' .
				'%s' .
				'</div>' .
				'</div>',
				esc_attr( $css_class ),
				implode( ' ', $output )
			);
		}
	}

	/**
	 * Get post class
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function product_post_class( $classes, $class = '', $post_id = '' ) {
		if ( ! $post_id || 'product' !== get_post_type( $post_id ) ) {
			return $classes;
		}

		if ( ! unero_is_catalog() ) {
			return $classes;
		}

		if ( unero_get_option( 'catalog_layout' ) != 'masonry-content' ) {
			return $classes;
		}
		global $woocommerce_loop;

		if ( ! $woocommerce_loop || ! isset( $woocommerce_loop['loop'] ) ) {
			return $classes;
		}
		$index = $woocommerce_loop['loop'] % 12;

		if ( in_array( $index, array( 1, 9 ) ) ) {
			$classes[] = 'unero-product-masonry-long';
		} elseif ( in_array( $index, array( 2, 8 ) ) ) {
			$classes[] = 'unero-product-masonry-large';
		} elseif ( in_array( $index, array( 3, 5, 7, 11 ) ) ) {
			$classes[] = 'unero-product-masonry-small';
		} else {
			$classes[] = 'unero-product-masonry-normal';
		}

		return $classes;
	}

	/**
	 * Display product attribute
	 *
	 * @since 1.0
	 */
	function product_attribute() {

		$default_attribute = sanitize_title( unero_get_option( 'product_attribute' ) );

		if ( $default_attribute == '' || $default_attribute == 'none' ) {
			return;
		}

		$default_attribute = 'pa_' . $default_attribute;

		global $product;
		$attributes         = maybe_unserialize( get_post_meta( $product->get_id(), '_product_attributes', true ) );
		$product_attributes = maybe_unserialize( get_post_meta( $product->get_id(), 'attributes_extra', true ) );

		if ( $product_attributes == 'none' ) {
			return;
		}

		if ( $product_attributes == '' ) {
			$product_attributes = $default_attribute;
		}

		$variations = $this->get_variations( $product_attributes );

		if ( ! $attributes ) {
			return;
		}

		foreach ( $attributes as $attribute ) {


			if ( $product->get_type() == 'variable' ) {
				if ( ! $attribute['is_variation'] ) {
					continue;
				}
			}

			if ( sanitize_title( $attribute['name'] ) == $product_attributes ) {

				echo '<div class="un-attr-swatches">';
				if ( $attribute['is_taxonomy'] ) {
					$post_terms = wp_get_post_terms( $product->get_id(), $attribute['name'] );

					$attr_type = '';

					if ( function_exists( 'TA_WCVS' ) ) {
						$attr = TA_WCVS()->get_tax_attribute( $attribute['name'] );
						if ( $attr ) {
							$attr_type = $attr->attribute_type;
						}
					}
					$found = false;
					foreach ( $post_terms as $term ) {
						$css_class = '';
						if ( is_wp_error( $term ) ) {
							continue;
						}
						if ( $variations && isset( $variations[ $term->slug ] ) ) {
							$attachment_id = $variations[ $term->slug ];
							$attachment    = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );
							$image_srcset  = '';
							if ( ! intval( unero_get_option( 'lazyload' ) ) ) {
								$image_srcset = wp_get_attachment_image_srcset( $attachment_id, 'shop_catalog' );
							}

							if ( $attachment_id == get_post_thumbnail_id() && ! $found ) {
								$css_class .= ' selected';
								$found     = true;
							}

							if ( $attachment ) {
								$css_class   .= ' un-swatch-variation-image';
								$img_src     = $attachment[0];
								$term_swatch = $this->swatch_html( $term, $attr_type, $img_src, $css_class, $image_srcset );
								echo ! empty( $term_swatch ) ? $term_swatch : '';
							}

						}
					}
				}
				echo '</div>';
				break;
			}
		}

	}

	/**
	 * Get product review comment form args
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function product_review_comment_form_args( $args ) {

		$args['format'] = 'xhtml';

		return $args;
	}


	/**
	 * Getting parts of a price, in html, used by get_price_html.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function get_price_html_from_to( $price, $from, $to ) {

		$price = '<ins>' . ( ( is_numeric( $to ) ) ? wc_price( $to ) : $to ) . '</ins> <del>' . ( ( is_numeric( $from ) ) ? wc_price( $from ) : $from ) . '</del>';

		return $price;
	}

	/**
	 * Get product thumnails
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function product_thumbnails() {
		global $post, $product, $woocommerce;

		if ( in_array( unero_get_option( 'product_page_layout' ), array( '3', '6' ) ) ) {
			return;
		}

		$attachment_ids = $product->get_gallery_image_ids();
		$video_position = intval( get_post_meta( $product->get_id(), 'video_position', true ) );
		$video_thumb    = get_post_meta( $product->get_id(), 'video_thumbnail', true );
		if ( $video_thumb ) {
			$video_thumb = wp_get_attachment_image( $video_thumb, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
		}

		if ( $attachment_ids || $video_thumb ) {
			$loop    = 1;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
			?>
            <div class="product-thumbnails" id="product-thumbnails">
                <div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php

					$image_thumb = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );

					if ( $image_thumb ) {

						printf(
							'<div>%s</div>',
							$image_thumb
						);

					}

					if ( $attachment_ids ) {
						foreach ( $attachment_ids as $attachment_id ) {

							if ( $video_thumb ) {
								if ( intval( $video_position ) == $loop + 1 ) {
									printf(
										'<div class="video-thumb">%s</div>',
										$video_thumb
									);
								}
							}

							echo apply_filters(
								'woocommerce_single_product_image_thumbnail_html',
								sprintf(
									'<div>%s</div>',
									wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) )
								),
								$attachment_id,
								$post->ID
							);

							$loop ++;
						}
					}

					if ( $video_thumb ) {
						if ( $video_position > count( $attachment_ids ) + 1 ) {
							printf(
								'<div class="video-thumb">%s</div>',
								$video_thumb
							);
						}
					}

					?>
                </div>
            </div>
			<?php
		}

	}

	/**
	 * Get categories grid
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function categories_grid() {

		if ( function_exists( 'is_shop' ) && ! is_shop() ) {
			return;
		}

		$shop_element = unero_get_option( 'shop_element' );

		if ( ! $shop_element ) {
			return;
		}

		if ( $shop_element != 'product_cats_box' ) {
			return;
		}

		$categories = unero_get_option( 'shop_product_cats_box' );

		if ( ! $categories ) {
			return;
		}

		$output = array();
		$i      = 0;
		foreach ( $categories as $cat ) {
			$css_class  = 'product-cat-normal';
			$image_size = 'unero-product-cat-normal';

			if ( $i % 4 == 0 || $i % 4 == 3 ) {
				$image_size = 'unero-product-cat-long';
				$css_class  = 'product-cat-long';
			}

			$i ++;

			$content = '';
			if ( isset( $cat['heading'] ) && $cat['heading'] ) {
				$content = sprintf( '<h3>%s</h3>', wp_kses( $cat['heading'], wp_kses_allowed_html( 'post' ) ) );
			}

			$link = '';
			if ( isset( $cat['slug'] ) && $cat['slug'] ) {
				$product_cat = get_term_by( 'slug', $cat['slug'], 'product_cat' );
				if ( ! is_wp_error( $product_cat ) && $product_cat ) {
					$content .= sprintf( '<span class="cat-title">%s</span>', $product_cat->name );
					$link    = get_term_link( $product_cat, 'product_cat' );
				}
			}

			$content = sprintf( '<div class="product-cat-text">%s</div>', $content );
			if ( isset( $cat['image'] ) && $cat['image'] ) {
				$content .= wp_get_attachment_image( $cat['image'], $image_size );
			}

			$output[] = sprintf( '<li class="product-cat %s"><a class="cat-link" href="%s"></a>%s</li>', esc_attr( $css_class ), esc_url( $link ), $content );
		}

		if ( $output ) {
			printf( '<div id="un-shop-product-cats" class="un-shop-product-cats"><div class="container"><ul>%s</ul></div></div>', implode( ' ', $output ) );
		}
	}

	function single_product_template_loader( $template ) {
		if ( ! is_singular( 'product' ) ) {
			return $template;
		}

		if ( unero_get_option( 'product_page_layout' ) == '1' ) {
			return $template;
		}

		return wc_get_template_part( 'unero', 'single-product' );
	}

	/**
	 * Search SKU
	 *
	 * @since 1.0
	 */
	function product_search_sku( $where ) {
		global $pagenow, $wpdb, $wp;

		if ( ( is_admin() && 'edit.php' != $pagenow )
		     || ! is_search()
		     || ! isset( $wp->query_vars['s'] )
		     || ( isset( $wp->query_vars['post_type'] ) && 'product' != $wp->query_vars['post_type'] )
		     || ( isset( $wp->query_vars['post_type'] ) && is_array( $wp->query_vars['post_type'] ) && ! in_array( 'product', $wp->query_vars['post_type'] ) )
		) {
			return $where;
		}
		$search_ids = array();
		$terms      = explode( ',', $wp->query_vars['s'] );

		foreach ( $terms as $term ) {
			//Include the search by id if admin area.
			if ( is_admin() && is_numeric( $term ) ) {
				$search_ids[] = $term;
			}
			// search for variations with a matching sku and return the parent.

			$sku_to_parent_id = $wpdb->get_col( $wpdb->prepare( "SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key='_sku' and pm.meta_value LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent", wc_clean( $term ) ) );

			//Search for a regular product that matches the sku.
			$sku_to_id = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value LIKE '%%%s%%';", wc_clean( $term ) ) );

			$search_ids = array_merge( $search_ids, $sku_to_id, $sku_to_parent_id );
		}

		$search_ids = array_filter( array_map( 'absint', $search_ids ) );

		if ( sizeof( $search_ids ) > 0 ) {
			$where = str_replace( ')))', ") OR ({$wpdb->posts}.ID IN (" . implode( ',', $search_ids ) . "))))", $where );
		}

		return $where;
	}

	/**
	 * Search products
	 *
	 * @since 1.0
	 */
	public function instance_search_result() {
		check_ajax_referer( '_unero_nonce', 'nonce' );

		$args_sku = array(
			'post_type'        => 'product',
			'posts_per_page'   => 30,
			'meta_query'       => array(
				array(
					'key'     => '_sku',
					'value'   => trim( $_POST['term'] ),
					'compare' => 'like',
				),
			),
			'suppress_filters' => 0,
		);

		$args_variation_sku = array(
			'post_type'        => 'product_variation',
			'posts_per_page'   => 30,
			'meta_query'       => array(
				array(
					'key'     => '_sku',
					'value'   => trim( $_POST['term'] ),
					'compare' => 'like',
				),
			),
			'suppress_filters' => 0,
		);

		$args = array(
			'post_type'        => 'product',
			'posts_per_page'   => 30,
			's'                => trim( $_POST['term'] ),
			'suppress_filters' => 0,
		);

		if ( isset( $_POST['cat'] ) && $_POST['cat'] != '' ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $_POST['cat'],
				),
			);

			$args_sku['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $_POST['cat'],
				),
			);
		}

		$products_sku           = get_posts( $args_sku );
		$products_s             = get_posts( $args );
		$products_variation_sku = get_posts( $args_variation_sku );

		$response    = array();
		$products    = array_merge( $products_sku, $products_s, $products_variation_sku );
		$product_ids = array();
		foreach ( $products as $product ) {
			$id = $product->ID;
			if ( ! in_array( $id, $product_ids ) ) {
				$product_ids[] = $id;

				$productw   = new WC_Product( $id );
				$response[] = sprintf(
					'<li>' .
					'<a class="search-item" href="%s">' .
					'%s' .
					'<span class="title">%s</span>' .
					'</a>' .
					'</li>',
					esc_url( $productw->get_permalink() ),
					$productw->get_image( 'shop_thumbnail' ),
					$productw->get_title()
				);
			}
		}


		if ( empty( $response ) ) {
			$response[] = sprintf( '<li>%s</li>', esc_html__( 'Nothing found', 'unero' ) );
		}

		$output = sprintf( '<ul>%s</ul>', implode( ' ', $response ) );

		wp_send_json_success( $output );
		die();
	}


	/**
	 * Print HTML of a single swatch
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function swatch_html( $term, $attr_type, $img_src, $css_class, $image_srcset ) {

		$html = '';
		$name = $term->name;

		switch ( $attr_type ) {
			case 'color':
				$color = get_term_meta( $term->term_id, 'color', true );
				list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
				$html = sprintf(
					'<span class="swatch swatch-color %s" data-src="%s" data-src-set="%s" title="%s"><span class="sub-swatch" style="background-color:%s;color:%s;"></span> </span>',
					esc_attr( $css_class ),
					esc_url( $img_src ),
					esc_attr( $image_srcset ),
					esc_attr( $name ),
					esc_attr( $color ),
					"rgba($r,$g,$b,0.5)"
				);
				break;

			case 'image':
				$image = get_term_meta( $term->term_id, 'image', true );
				if ( $image ) {
					$image = wp_get_attachment_image_src( $image );
					$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
					$html  = sprintf(
						'<span class="swatch swatch-image %s" data-src="%s" data-src-set="%s" title="%s"><img src="%s" alt="%s"></span>',
						esc_attr( $css_class ),
						esc_url( $img_src ),
						esc_attr( $image_srcset ),
						esc_attr( $name ),
						esc_url( $image ),
						esc_attr( $name )
					);
				}

				break;

			default:
				$label = get_term_meta( $term->term_id, 'label', true );
				$label = $label ? $label : $name;
				$html  = sprintf(
					'<span class="swatch swatch-label %s" data-src="%s" data-src-set="%s" title="%s">%s</span>',
					esc_attr( $css_class ),
					esc_url( $img_src ),
					esc_attr( $image_srcset ),
					esc_attr( $name ),
					esc_html( $label )
				);
				break;


		}

		return $html;
	}

	/**
	 * Get variations
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function get_variations( $default_attribute ) {
		global $product;

		$variations = array();
		if ( $product->get_type() == 'variable' ) {
			$args = array(
				'post_parent' => $product->get_id(),
				'post_type'   => 'product_variation',
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'fields'      => 'ids',
				'post_status' => 'publish',
				'numberposts' => - 1,
			);

			if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				$args['meta_query'][] = array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '=',
				);
			}

			$thumbnail_id = get_post_thumbnail_id();

			$posts = get_posts( $args );

			foreach ( $posts as $post_id ) {
				$attachment_id = get_post_thumbnail_id( $post_id );
				$attribute     = $this->get_variation_attributes( $post_id, 'attribute_' . $default_attribute );

				if ( ! $attachment_id ) {
					$attachment_id = $thumbnail_id;
				}

				if ( $attribute ) {
					$variations[ $attribute[0] ] = $attachment_id;
				}

			}

		}

		return $variations;
	}

	/**
	 * Ajaxify update count wishlist
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	function update_wishlist_count() {
		if ( ! function_exists( 'YITH_WCWL' ) ) {
			return;
		}

		wp_send_json( YITH_WCWL()->count_products() );

	}

	/**
	 * Get variation attribute
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_variation_attributes( $child_id, $attribute ) {
		global $wpdb;

		$values = array_unique(
			$wpdb->get_col(
				$wpdb->prepare(
					"SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND post_id IN (" . $child_id . ")",
					$attribute
				)
			)
		);

		return $values;
	}

	/**
	 * WooCommerce Loop Product quick view
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function single_product_wishlist() {

		if ( ! in_array( unero_get_option( 'product_page_layout' ), array( '2', '4', '5', '6' ) ) ) {
			return;
		}

		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}
	}

	function single_product_breadcrumb() {

		if ( ! in_array( unero_get_option( 'product_page_layout' ), array( '3' ) ) ) {
			return;
		}

		get_template_part( 'template-parts/page-headers/layout', 1 );
	}

	/**
	 *product_quick_view
	 */
	function product_quick_view() {
		check_ajax_referer( '_unero_nonce', 'nonce' );
		ob_start();
		if ( isset( $_POST['product_id'] ) && ! empty( $_POST['product_id'] ) ) {
			$product_id      = $_POST['product_id'];
			$original_post   = $GLOBALS['post'];
			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', 'product-quick-view' );
			$GLOBALS['post'] = $original_post; // WPCS: override ok.

		}
		$output = ob_get_clean();
		wp_send_json_success( $output );
		die();
	}

	/**
	 * Change gallery image size.
	 *
	 * @return string
	 */
	public function gallery_image_size() {
		return 'woocommerce_single';
	}
}