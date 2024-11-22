<?php

if ( ! intval( unero_get_option( 'page_header_portfolio' ) ) ) {
	return;
}

$sliders = unero_get_option( 'page_header_slider_portfolio' );

if ( ! $sliders ) {
	return;
}

$output = array();
foreach ( $sliders as $slider ) {
	$bg = '';
	if ( isset( $slider['image'] ) && $slider['image'] ) {
		$image = wp_get_attachment_image_src( $slider['image'], 'full' );

		if ( $image ) {
			$bg = 'style="background-image:url(' . esc_url( $image[0] ) . ')"';
		}
	}

	$title = '';
	if ( isset( $slider['title'] ) && $slider['title'] ) {
		$title = sprintf( '<h3>%s</h3>', wp_kses( $slider['title'], wp_kses_allowed_html( 'post' ) ) );
	}

	if ( isset( $slider['subtitle'] ) && $slider['subtitle'] ) {
		$title .= sprintf( '<p>%s</p>', wp_kses( $slider['subtitle'], wp_kses_allowed_html( 'post' ) ) );
	}

	$output[] = sprintf( '<li class="ph-slider" %s><div class="page-header-content">%s</div></li>', $bg, $title );

}

if ( ! $output ) {
	return;
}


$css_class = '';

if( $shop_parallax = intval( unero_get_option( 'page_header_portfolio_parallax' ) ) ) {
	$css_class = 'parallax';
}

$height   = intval( unero_get_option( 'page_header_portfolio_slider_height' ) ) . 'px';
$speed    = intval( unero_get_option( 'page_header_portfolio_slider_autoplay' ) );
$autoplay = 0;
if ( $speed ) {
	$autoplay = 1;
} else {
	$speed = 500;
}

?>

<div class="page-header page-header-sliders ph-portfolio-sliders <?php echo esc_attr( $css_class ); ?>" data-parallax="0" data-speed="<?php echo esc_attr( $speed ); ?>" data-auto="<?php echo esc_attr( $autoplay ); ?>" style="height: <?php echo esc_attr( $height ); ?>">
	<div class="page-header-inner" style="height: <?php echo esc_attr( $height ); ?>">
		<ul>
			<?php
			echo implode( ' ', $output );
			?>
		</ul>
	</div>
</div>
