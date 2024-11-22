<?php
$css_class  = 'container';
if ( intval( unero_get_option( 'header_full_width' ) ) ) {
	$css_class = 'unero-container header-full-width';
}
?>
<div class="<?php echo esc_attr( $css_class ); ?>">
	<div class="header-main">
		<div class="row">
			<?php unero_icon_menu() ?>
			<div class="menu-logo col-lg-2 col-md-6 col-sm-6 col-xs-6">
				<?php get_template_part( 'template-parts/logo' ); ?>
			</div>
			<div class="primary-nav nav col-lg-7 hidden-md hidden-sm hidden-xs">
				<?php unero_header_menu(); ?>
			</div>
			<div class="menu-extra col-md-3 col-sm-3 col-xs-3">
				<ul>
					<?php
					unero_extra_search();
					unero_extra_account();
					unero_extra_wishlist();
					unero_extra_cart();
					unero_extra_sidebar();
					?>
				</ul>

			</div>
		</div>

	</div>
</div>
