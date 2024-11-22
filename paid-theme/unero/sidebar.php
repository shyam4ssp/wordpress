<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Unero
 */

if ( 'full-content' == unero_get_layout() ) {
	return;
}

$sidebar = 'blog-sidebar';

if ( unero_is_catalog() ) {
	$sidebar = 'catalog-sidebar';
} elseif( unero_is_portfolio()  ) {
	$sidebar = 'portfolio-sidebar';
} elseif( is_page() ) {
	$sidebar = 'page-sidebar';
} elseif( is_singular('product') ) {
	$sidebar = 'product-sidebar';
}

?>
<aside id="primary-sidebar" class="widgets-area primary-sidebar col-md-3 col-sm-12 col-xs-12 <?php echo esc_attr( $sidebar ) ?>">
	<?php
	if ( is_active_sidebar( $sidebar ) ) {
		dynamic_sidebar( $sidebar );
	}
	?>
</aside><!-- #secondary -->
