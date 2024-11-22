<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="unero-single-product-detail">
		<div class="container">
			<div class="row">
				<div class="col-md-7 col-sm-12 col-xs-12 product-images-wrapper">
					<?php
					do_action( 'unero_before_single_product_summary' );
					?>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12 col-md-offset-1 product-summary">
					<div class="summary entry-summary">
						<?php
						do_action( 'unero_single_product_summary' );
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- .summary -->
	</div>
</div><!-- #product-<?php the_ID(); ?> -->

