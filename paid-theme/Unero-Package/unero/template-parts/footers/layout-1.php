<?php
$logo = get_template_directory_uri() . '/images/logo/logo.png';
$footer_skin = unero_get_option( 'footer_skin' );
$footer_skin .= ' ' . unero_footer_classes();

?>

<nav class="footer-layout footer-layout-1 footer-layout-<?php echo esc_attr( $footer_skin ); ?>">
	<div class="footer-nav">
		<div class="container">
			<div class="row">
				<div class="col-footer-column col-md-4 col-sm-12 col-xs-12">
					<?php unero_footer_logo( $logo ); ?>
				</div>
				<div class="col-footer-column col-md-5 col-sm-12 col-xs-12 col-right">
					<div class="footer-newsletter">
						<?php unero_footer_newsletter(); ?>
					</div>
				</div>
				<div class="col-footer-column col-md-3 col-sm-12 col-xs-12">
					<?php unero_footer_socials(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<div class="footer-sep"></div>
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12 text-left col-footer-copyright">
					<?php unero_footer_copyright(); ?>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 text-right">
					<?php unero_footer_menu_1(); ?>
				</div>
			</div>
		</div>
	</div>

</nav>