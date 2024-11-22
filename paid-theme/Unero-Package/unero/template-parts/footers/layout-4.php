<?php
$logo        = get_template_directory_uri() . '/images/logo/logo.png';
$footer_skin = unero_get_option( 'footer_skin' );
$footer_skin .= ' ' . unero_footer_classes();
?>


<nav class="footer-layout footer-layout-4 footer-layout-<?php echo esc_attr( $footer_skin ); ?>">
	<div class="unero-container">
		<div class="row">
			<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 col-logo">
				<?php unero_footer_logo( $logo ); ?>
			</div>
			<div class="footer-content col-lg-7 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 col-copyright">
						<?php unero_footer_copyright(); ?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-menu">
						<?php unero_footer_menu_1(); ?>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-3 col-xs-12 col-menu">
						<?php unero_footer_menu_2(); ?>
					</div>
				</div>
			</div>

			<div class="footer-socials col-lg-3 col-md-12 col-sm-12 col-xs-12">
				<?php unero_footer_socials( true ); ?>
			</div>
		</div>
	</div>
</nav>