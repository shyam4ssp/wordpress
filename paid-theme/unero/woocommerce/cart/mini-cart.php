<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<ul class="cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
                <li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php
					$remove_url = '';
					if ( function_exists( 'wc_get_cart_remove_url' ) ) {
						$remove_url = wc_get_cart_remove_url( $cart_item_key );
					} else {
						$remove_url = WC()->cart->get_remove_url( $cart_item_key );
					}
					echo apply_filters(
						'woocommerce_cart_item_remove_link', sprintf(
						'<a href="%s" class="remove" title="%s" data-item_key="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
						esc_url( $remove_url ),
						__( 'Remove this item', 'unero' ),
						esc_attr( $cart_item_key ),
						esc_attr( $product_id ),
						esc_attr( $_product->get_sku() )
					), $cart_item_key
					);
					?>
                    <div class="un-mini-cart-thumbnail">
						<?php if ( ! $_product->is_visible() ) : ?>
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?>
						<?php else : ?>
                            <a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?>
                            </a>
						<?php endif; ?>
                    </div>
                    <div class="un-mini-cart-content">
						<?php if ( ! $_product->is_visible() ) : ?>
							<?php echo wp_kses_post( $product_name ); ?>
						<?php else : ?>
                            <a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo wp_kses_post( $product_name ); ?>
                            </a>
						<?php endif; ?>
						<?php
						if ( function_exists( 'wc_get_formatted_cart_item_data' ) ) {
							echo wc_get_formatted_cart_item_data( $cart_item );
						} else {
							echo WC()->cart->get_item_data( $cart_item );
						}
						?>

						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s: %s %s', esc_html__( 'QTY', 'unero' ), $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                    </div>

                </li>
				<?php
			}
		}
		?>

	<?php else : ?>

        <li class="empty"><?php esc_html_e( 'No products in the cart.', 'unero' ); ?></li>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>
    <div class="un-cart-panel-footer">
        <p class="total">
            <strong><?php esc_html_e( 'Subtotal', 'unero' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?>
        </p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

        <p class="buttons">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
               class="button wc-forward"><?php esc_html_e( 'View Cart', 'unero' ); ?></a>
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
               class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'unero' ); ?></a>
        </p>
    </div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
