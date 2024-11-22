<?php
$footer_skin = unero_get_option( 'footer_skin' );
$footer_skin .= ' ' . unero_footer_classes();

?>

<nav class="footer-layout footer-layout-5 footer-layout-<?php echo esc_attr( $footer_skin ); ?>">
	<div class="footer-nav">
		<div class="container">
			<?php unero_footer_socials(true); ?>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<?php unero_footer_copyright(); ?>
		</div>
	</div>

</nav>