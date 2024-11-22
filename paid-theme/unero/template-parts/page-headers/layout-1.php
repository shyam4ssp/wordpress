<?php

$show_breadcrumbs = true;
if ( unero_get_post_meta( 'hide_breadcrumb' ) ) {
	$show_breadcrumbs = false;
}


$show_title = true;
$show_nav   = false;

if ( unero_get_post_meta( 'hide_page_title' ) ) {
	$show_title = false;
}

if ( is_singular( 'product' ) ) {
	$show_title       = false;
	$show_breadcrumbs = unero_get_option( 'product_breadcrumb' );
	$show_nav         = unero_get_option( 'product_navigation' );
}

$page_header = unero_get_page_header();

$css_class = '';
if ( isset( $page_header['parallax'] ) && intval( $page_header['parallax'] ) ) {
	$css_class = 'parallax';
}

$id    = "un-page-header";
$style = '';
if ( unero_is_catalog() ) {
	$id = "un-catalog-page-header";

	if ( isset( $page_header['layout'] ) && intval( $page_header['layout'] ) == 2 ) {
		if ( $height = unero_get_option( 'page_header_height_shop' ) ) {
			$style     = 'style=height:' . esc_attr( $height . 'px' );
			$css_class .= ' has-height';
		}
	}
}

?>

<div id="<?php echo esc_attr( $id ); ?>"
     class="page-header text-center <?php echo esc_attr( $css_class ); ?>" <?php echo esc_attr( $style ); ?>>
    <div class="container">
		<?php
		if ( $show_title ) {
			the_archive_title( '<h1>', '</h1>' );
		}
		if ( $show_breadcrumbs || $show_nav ) {
			?>
            <div class="page-breadcrumbs">
				<?php
				if ( $show_breadcrumbs ) {
					unero_get_breadcrumbs();
				}
				if ( $show_nav ) {
					unero_products_links();
				}
				?>
            </div>
		<?php } ?>
    </div>
</div>