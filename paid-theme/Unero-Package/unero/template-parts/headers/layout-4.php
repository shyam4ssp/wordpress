<div class="container">
	<div class="header-main">
		<div class="row">
			<?php unero_icon_menu() ?>
			<div class="menu-extra menu-extra-left col-lg-4 hidden-md hidden-xs hidden-sm">
				<ul>
					<?php unero_extra_search(); ?>
				</ul>
			</div>
			<div class="menu-logo col-lg-4 col-md-6 col-sm-6 col-xs-6">
				<?php get_template_part( 'template-parts/logo' ); ?>
			</div>
			<div class="menu-extra col-lg-4 col-md-3 col-sm-3 col-xs-3">
				<ul>
					<?php
					unero_extra_language();
					unero_extra_currency();
					unero_extra_account();
					unero_extra_wishlist();
					unero_extra_cart();
					?>
				</ul>

			</div>
		</div>
		<div class="primary-nav nav">
			<?php unero_header_menu(); ?>
		</div>

	</div>
</div>
