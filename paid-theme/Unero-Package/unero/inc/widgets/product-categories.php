<?php
/**
 * Product Categories Widget
 *
 * @author   Automattic
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Widget' ) ) {
	return;
}

if ( ! class_exists( 'Unero_Widget_Product_Categories' ) ) {

	/**
	 * Product categories widget class.
	 *
	 * @extends WC_Widget
	 */
	class Unero_Widget_Product_Categories extends WC_Widget {

		/**
		 * Category ancestors.
		 *
		 * @var array
		 */
		public $cat_ancestors;

		/**
		 * Current Category.
		 *
		 * @var bool
		 */
		public $current_cat;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce un_widget_product_categories widget_product_categories';
			$this->widget_description = esc_html__( 'A list of product categories.', 'unero' );
			$this->widget_id          = 'un_product_categories';
			$this->widget_name        = esc_html__( 'Unero - Product Categories', 'unero' );
			$this->settings           = array(
				'title'      => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Product categories', 'unero' ),
					'label' => esc_html__( 'Title', 'unero' ),
				),
				'orderby'    => array(
					'type'    => 'select',
					'std'     => 'name',
					'label'   => esc_html__( 'Order by', 'unero' ),
					'options' => array(
						'order' => esc_html__( 'Category order', 'unero' ),
						'title' => esc_html__( 'Name', 'unero' ),
						'count' => esc_html__( 'Count', 'unero' ),
					),
				),
				'count'      => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show product counts', 'unero' ),
				),
				'hide_empty' => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Hide empty categories', 'unero' ),
				),
				'max_depth'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Maximum depth', 'unero' ),
				),
			);

			parent::__construct();
		}

		/**
		 * Output widget.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Widget instance.
		 */
		public function widget( $args, $instance ) {
			global $wp_query, $post;

			$count         = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
			$orderby       = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
			$hide_empty    = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
			$dropdown_args = array(
				'hide_empty' => $hide_empty,
			);
			$list_args     = array(
				'show_count'   => $count,
				'hierarchical' => 1,
				'taxonomy'     => 'product_cat',
				'hide_empty'   => $hide_empty,
			);
			$max_depth     = absint( isset( $instance['max_depth'] ) ? $instance['max_depth'] : $this->settings['max_depth']['std'] );

			$list_args['menu_order'] = false;
			$dropdown_args['depth']  = $max_depth;
			$list_args['depth']      = $max_depth;

			if ( 'order' === $orderby ) {
				$list_args['menu_order'] = 'asc';
			} else {
				$list_args['orderby'] = $orderby;
				if ( $orderby === 'count' ) {
					$atts['order'] = 'desc';
				}
			}

			$this->current_cat   = false;
			$this->cat_ancestors = array();

			if ( is_tax( 'product_cat' ) ) {
				$this->current_cat   = $wp_query->queried_object;
				$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

			} elseif ( is_singular( 'product' ) ) {
				$product_category = wc_get_product_terms(
					$post->ID, 'product_cat', apply_filters(
						'woocommerce_product_categories_widget_product_terms_args', array(
							'orderby' => 'parent',
						)
					)
				);

				if ( ! empty( $product_category ) ) {
					$this->current_cat   = end( $product_category );
					$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
				}
			}

			$this->widget_start( $args, $instance );

			$list_args['title_li']                   = '';
			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = esc_html__( 'No product categories exist.', 'unero' );
			$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
			$list_args['current_category_ancestors'] = $this->cat_ancestors;
			$list_args['max_depth']                  = $max_depth;
			$list_args['use_desc_for_title']         = 0;

			echo '<ul class="product-categories">';

			wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

			echo '</ul>';

			$this->widget_end( $args );
		}
	}
}