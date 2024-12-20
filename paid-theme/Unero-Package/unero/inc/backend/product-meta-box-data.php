<?php
/**
 * Functions and Hooks for product meta box data
 *
 * @package Unero
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * unero_Meta_Box_Product_Data class.
 */
class Unero_Meta_Box_Product_Data {

	/**
	 * Constructor.
	 */
	public function __construct() {

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}
		// Add form
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_meta_fields' ) );
		add_action( 'woocommerce_product_data_tabs', array( $this, 'product_meta_tab' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'product_meta_fields_save' ) );

		add_action( 'wp_ajax_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
		add_action( 'wp_ajax_nopriv_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
	}

	/**
	 * Get product data fields
	 *
	 */
	public function instance_product_meta_fields() {
		$post_id = $_POST['post_id'];

		if ( empty( $post_id ) ) {
			return;
		}

		ob_start();
		$this->create_product_extra_fields( $post_id );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}

	/**
	 * Product data tab
	 */
	public function product_meta_tab( $product_data_tabs ) {
		$product_data_tabs['unero_instagram'] = array(
			'label'  => esc_html__( 'Instagram', 'unero' ),
			'target' => 'product_unero_instagram',
			'class'  => 'product-unero_instagram'
		);

		$product_data_tabs['unero_attributes_extra'] = array(
			'label'  => esc_html__( 'Extra', 'unero' ),
			'target' => 'product_attributes_extra',
			'class'  => 'product-attributes-extra'
		);

		return $product_data_tabs;
	}

	/**
	 * Add product data fields
	 *
	 */
	public function product_meta_fields() {
		global $post;
		echo '<div id="product_unero_instagram" class="panel woocommerce_options_panel">';
		$this->create_product_instagram_fields( $post->ID );
		echo '</div>';

		echo '<div id="product_attributes_extra" class="panel woocommerce_options_panel">';
		$this->create_product_extra_fields( $post->ID );
		echo '</div>';
	}

	/**
	 * product_meta_fields_save function.
	 *
	 * @param mixed $post_id
	 */
	public function product_meta_fields_save( $post_id ) {
		if ( isset( $_POST['product_instagram_hashtag'] ) ) {
			$woo_data = $_POST['product_instagram_hashtag'];
			update_post_meta( $post_id, 'product_instagram_hashtag', $woo_data );
		}

		if ( isset( $_POST['attributes_extra'] ) ) {
			$woo_data = $_POST['attributes_extra'];
			update_post_meta( $post_id, 'attributes_extra', $woo_data );
		}

		if ( isset( $_POST['custom_badges_text'] ) ) {
			$woo_data = $_POST['custom_badges_text'];
			update_post_meta( $post_id, 'custom_badges_text', $woo_data );
		}

		if ( isset( $_POST['_is_new'] ) ) {
			$woo_data = $_POST['_is_new'];
			update_post_meta( $post_id, '_is_new', $woo_data );
		} else {
			update_post_meta( $post_id, '_is_new', 0 );
		}
	}

	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public function create_product_instagram_fields( $post_id ) {
		woocommerce_wp_text_input(
			array(
				'id'       => 'product_instagram_hashtag',
				'label'    => esc_html__( 'Hashtag', 'unero' ),
				'desc_tip' => esc_html__( 'Enter the hashtag for which photos will be displayed. If no hashtag is entered, no photos will display.', 'unero' ),
			)
		);
	}

	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public function create_product_extra_fields( $post_id ) {
		$attributes = maybe_unserialize( get_post_meta( $post_id, '_product_attributes', true ) );

		if ( ! $attributes ) : ?>
            <div id="message" class="inline notice woocommerce-message">
                <p><?php esc_html_e( 'You need to add attributes on the Attributes tab.', 'unero' ); ?></p>
            </div>

		<?php else :
			$options         = array();
			$options['']     = esc_html__( 'Default', 'unero' );
			$options['none'] = esc_html__( 'None', 'unero' );
			foreach ( $attributes as $attribute ) {
				$options[ sanitize_title( $attribute['name'] ) ] = wc_attribute_label( $attribute['name'] );
			}
			woocommerce_wp_radio(
				array(
					'id'       => 'attributes_extra',
					'label'    => esc_html__( 'Product Attribute', 'unero' ),
					'desc_tip' => esc_html__( 'Show product attribute for each item listed under the item name.', 'unero' ),
					'options'  => $options
				)
			);

		endif;

		woocommerce_wp_text_input(
			array(
				'id'       => 'custom_badges_text',
				'label'    => esc_html__( 'Custom Badge Text', 'unero' ),
				'desc_tip' => esc_html__( 'Enter this optional to show your badges.', 'unero' ),
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'          => '_is_new',
				'label'       => esc_html__( 'New product?', 'unero' ),
				'description' => esc_html__( 'Enable to set this product as a new product. A "New" badge will be added to this product.', 'unero' ),
			)
		);

	}
}