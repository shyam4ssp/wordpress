<?php
$logo        = get_template_directory_uri() . '/images/logo/logo.png';
$footer_skin = unero_get_option( 'footer_skin' );
$footer_skin .= ' ' . unero_footer_classes();
?>

<nav class="footer-layout footer-layout-2 footer-layout-<?php echo esc_attr( $footer_skin ); ?>">
	<div class="row">
		<div class="footer-logo col-md-2 col-sm-12 col-xs-12">
			<?php unero_footer_logo( $logo ); ?>
		</div>
		<div class="footer-copyright col-md-6 col-sm-12 col-xs-12">
			<?php unero_footer_copyright(); ?>
		</div>
		<div class="footer-socials col-md-4 col-sm-12 col-xs-12">
			<?php unero_footer_socials(); ?>
		</div>
	</div>


</nav>