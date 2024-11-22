<?php

if ( ! intval( unero_get_option( 'page_header_shop' ) ) ) {
	return;
}

if ( unero_get_post_meta( 'page_header_site' ) ) {
	return;
}

$sliders = unero_get_option( 'page_header_slider_shop' );

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

	$item_html = '';
	if ( isset( $slider['video_url'] ) && $slider['video_url'] ) {
		$video_url = $slider['video_url'];
		$ext       = wp_check_filetype( $video_url );
		$item_html = sprintf(
			'<div class="unvideo-bg">' .
			'<video loop muted autoplay>' .
			'<source src="%s" type="%s">' .
			'</video>' .
			'</div>',
			esc_url( $video_url ),
			esc_attr( $ext['type'] )
		);
	}

	if ( $title ) {
		$item_html .= sprintf( '<div class="page-header-content">%s</div>', $title );
	}

	if ( isset( $slider['link_url'] ) && $slider['link_url'] ) {
		$item_html = sprintf( '<a class="link" href="%s"></a> %s', esc_url( $slider['link_url'] ), $item_html );
	}

	$output[] = sprintf( '<li class="ph-slider"><div class="featured-img" %s></div>%s</li>', $bg, $item_html );

}

if ( ! $output ) {
	return;
}


$parallax  = 0;
$css_class = '';

if ( $shop_parallax = intval( unero_get_option( 'page_header_shop_parallax' ) ) ) {
	if ( in_array( unero_get_option( 'header_layout' ), array( '1', '2' ) ) ) {
		$parallax = $shop_parallax;
	} else {
		$css_class = 'parallax';
		$parallax  = 0;
	}
}

if ( unero_get_option( 'shop_element' ) == 'product_cats_box' ) {
	$css_class = 'parallax';
	$parallax  = 0;
}

$height   = intval( unero_get_option( 'page_header_slider_height' ) ) . 'px';
$speed    = intval( unero_get_option( 'page_header_slider_autoplay' ) );
$autoplay = 0;
if ( $speed ) {
	$autoplay = 1;
} else {
	$speed = 500;
}

?>

<div class="page-header page-header-sliders <?php echo esc_attr( $css_class ); ?>" data-parallax="<?php echo esc_attr( $parallax ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-auto="<?php echo esc_attr( $autoplay ); ?>" style="height: <?php echo esc_attr( $height ); ?>">
	<div class="page-header-inner" style="height: <?php echo esc_attr( $height ); ?>">
		<ul>
			<?php
			echo implode( ' ', $output );
			?>
		</ul>
	</div>
</div>
