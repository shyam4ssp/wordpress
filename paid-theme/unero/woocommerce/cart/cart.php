<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>
<h2 class="cart-title"><?php esc_html_e( 'Your cart items', 'unero' ); ?></h2>
<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
		<tr>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php esc_html_e( 'Product', 'unero' ); ?></th>
			<th class="product-price"><?php esc_html_e( 'Price', 'unero' ); ?></th>
			<th class="product-quantity"><?php esc_html_e( 'Quantity', 'unero' ); ?></th>
			<th class="product-subtotal"><?php esc_html_e( 'Total', 'unero' ); ?></th>
			<th class="product-remove">&nbsp;</th>

		</tr>
		</thead>
		<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo wp_kses_post( $thumbnail );
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
						}
						?>
					</td>

					<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'unero' ); ?>">
						<div class="product-item product-detail-mobile">
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( $thumbnail );
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
							}
							?>
						</div>
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						// Meta data
						if ( function_exists( 'wc_get_formatted_cart_item_data' ) ) {
							echo wc_get_formatted_cart_item_data( $cart_item );
						} else {
							echo WC()->cart->get_item_data( $cart_item );
						}

						// Backorder notification
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'unero' ) . '</p>', $product_id ) );
						}
						?>
						<div class="product-detail-mobile">
							<div class="product-item">
								<label>
									<?php esc_html_e( 'Price:', 'unero' ); ?>
								</label>
								<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
							</div>
							<div class="product-item">
								<label>
									<?php esc_html_e( 'Total:', 'unero' ); ?>
								</label>
								<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								?>
							</div>
						</div>
					</td>

					<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'unero' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'unero' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input( array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							), $_product, false );
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>

					<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'unero' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-remove">
						<?php
						$remove_url = '';
						if ( function_exists( 'wc_get_cart_remove_url' ) ) {
							$remove_url = wc_get_cart_remove_url($cart_item_key);
						} else {
							$remove_url = WC()->cart->get_remove_url( $cart_item_key );
						}
						echo apply_filters(
							'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon-cross2"></i></a>',
							esc_url( $remove_url ),
							esc_html__( 'Remove this item', 'unero' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key
						);
						?>
					</td>
				</tr>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_contents' ); ?>

		<tr>
			<td colspan="6" class="actions">

				<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ); ?>" class="btn-shop"><i class="icon-arrow-left"></i> <?php esc_html_e( 'Back To Shop', 'unero' ); ?>
				</a>

				<div class="btn-update">
					<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'unero' ); ?>" />
				</div>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
	<?php if ( wc_coupons_enabled() ) { ?>
		<div class="row">
			<div class="col-md-4 col-sm-12 col-coupon">
				<div class="coupon">
					<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'unero' ); ?></label>
					<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'unero' ); ?>" />
					<input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'unero' ); ?>" />
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			</div>
		</div>
	<?php } ?>
</form>

<div class="cart-collaterals">
	<div class="row">
		<div class="col-md-4 col-sm-12 col-colla">

		</div>

		<?php
		$cart_class = 'col-md-8 col-sm-12 col-colla';
		if ( 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
			$cart_class = 'col-md-4 col-sm-12 col-colla';
			?>
			<div class="col-md-4 col-sm-12 col-colla">
				<?php woocommerce_shipping_calculator(); ?>
			</div>
		<?php } ?>
		<div class="<?php echo esc_attr( $cart_class ); ?>">
			<?php do_action( 'woocommerce_cart_collaterals' ); ?>
		</div>
	</div>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
