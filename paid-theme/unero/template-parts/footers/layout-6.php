<?php
$footer_skin = unero_get_option( 'footer_skin' );
$footer_skin .= ' ' . unero_footer_classes();
?>
<nav class="footer-layout footer-layout-6 footer-layout-<?php echo esc_attr( $footer_skin ); ?>">
	<div class="unero-container">
		<?php
		unero_footer_widgets();
		?>
	</div>
</nav>