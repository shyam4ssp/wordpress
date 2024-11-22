<?php

if ( ! intval( unero_get_option( 'page_header_single_portfolio' ) ) ) {
	return;
}

$page_header = unero_get_page_header();

$css_class = '';
if ( isset( $page_header['parallax'] ) && intval( $page_header['parallax'] ) ) {
	$css_class = 'parallax';
}
?>
<div class="page-header-portfolio">
	<div class="page-header ph-single-portfolio text-center <?php echo esc_attr( $css_class ); ?>">
		<div class="page-header-content">
			<?php
			the_archive_title( '<h1>', '</h1>' );
			the_terms( get_the_ID(), 'portfolio_category', '<div class="entry-cats">', ' ', '</div>' );
			?>
		</div>
	</div>
</div>