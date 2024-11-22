<?php
/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

?>

<form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post"
      class="woocommerce-form woocommerce-form-track-order track_order">
    <div class="row">
        <div class="col-md-10 col-sm-10 col-sm-offset-1 col-md-offset-1">
            <p><?php esc_html_e( 'To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.', 'unero' ); ?></p>
        </div>
        <div class="col-md-6 col-sm-6 col-sm-offset-3 col-md-offset-3 form-track_order">
            <p class="form-row form-row-first"><label
                        for="orderid"><?php esc_html_e( 'Order ID', 'unero' ); ?></label> <input
                        class="input-text" type="text" name="orderid" id="orderid"
                        value="<?php echo isset( $_REQUEST['orderid'] ) ? esc_attr( wp_unslash( $_REQUEST['orderid'] ) ) : ''; ?>"
                        placeholder="<?php esc_attr_e( 'Found in your order confirmation email.', 'unero' ); ?>"/>
            </p><?php // @codingStandardsIgnoreLine ?>
            <p class="form-row form-row-last"><label
                        for="order_email"><?php esc_html_e( 'Billing email', 'unero' ); ?></label> <input
                        class="input-text" type="text" name="order_email" id="order_email"
                        value="<?php echo isset( $_REQUEST['order_email'] ) ? esc_attr( wp_unslash( $_REQUEST['order_email'] ) ) : ''; ?>"
                        placeholder="<?php esc_attr_e( 'Email you used during checkout.', 'unero' ); ?>"/>
            </p><?php // @codingStandardsIgnoreLine ?>
            <div class="clear"></div>

            <p class="form-row">
                <button type="submit" class="button" name="track"
                        value="<?php esc_attr_e( 'Track', 'unero' ); ?>"><?php esc_html_e( 'Track', 'unero' ); ?></button>
            </p>
			<?php wp_nonce_field( 'woocommerce-order_tracking', 'woocommerce-order-tracking-nonce' ); ?>
        </div>
    </div>

</form>
