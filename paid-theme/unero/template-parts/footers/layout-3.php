<?php
$logo = get_template_directory_uri() . '/images/logo/logo.png';
$footer_skin = unero_get_option( 'footer_skin' );
$footer_skin .= ' ' . unero_footer_classes();
?>

<nav class="footer-layout footer-layout-3 footer-layout-<?php echo esc_attr( $footer_skin ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-12 col-xs-12 col-menu">
				<?php unero_footer_menu_1() ?>

			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 col-logo">
				<?php unero_footer_logo( $logo ); ?>
				<?php unero_footer_copyright(); ?>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 col-socials">
				<?php unero_footer_socials(true); ?>
			</div>
		</div>
	</div>
</nav>