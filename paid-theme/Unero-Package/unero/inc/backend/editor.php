<?php
/**
 * Custom functions for editor typography.
 *
 * @package Henlendo
 */

if ( ! function_exists( 'unero_editor_typography_css' ) ) :
	/**
	 * Get typography CSS base on settings
	 *
	 * @since 1.1.6
	 */
	function unero_editor_typography_css() {
		$css        = '';

		if ( ! class_exists( 'Kirki' ) ) {
			return $css;
		}

		$properties = array(
			'font-family'    => 'font-family',
			'font-size'      => 'font-size',
			'variant'        => 'font-weight',
			'line-height'    => 'line-height',
			'letter-spacing' => 'letter-spacing',
			'color'          => 'color',
			'text-transform' => 'text-transform',
			'text-align'     => 'text-align',
		);

		$settings = array(
			'body_typo'        => '.edit-post-layout__content .editor-styles-wrapper',
			'heading1_typo'    => '.editor-styles-wrapper .wp-block-heading h1',
			'heading2_typo'    => '.editor-styles-wrapper .wp-block-heading h2',
			'heading3_typo'    => '.editor-styles-wrapper .wp-block-heading h3',
			'heading4_typo'    => '.editor-styles-wrapper .wp-block-heading h4',
			'heading5_typo'    => '.editor-styles-wrapper .wp-block-heading h5',
			'heading6_typo'    => '.editor-styles-wrapper .wp-block-heading h6',
		);

		foreach ( $settings as $setting => $selector ) {
			$typography = unero_get_option( $setting );
			$default    = (array) unero_get_option_default( $setting );
			$style      = '';

			foreach ( $properties as $key => $property ) {
				if ( isset( $typography[$key] ) && ! empty( $typography[$key] ) ) {
					if ( isset( $default[$key] ) && strtoupper( $default[$key] ) == strtoupper( $typography[$key] ) ) {
						continue;
					}

					$value = 'font-family' == $key ? '"' . rtrim( trim( $typography[$key] ), ',' ) . '"' : $typography[$key];
					$value = 'variant' == $key ? str_replace( 'regular', '400', $value ) : $value;

					if ( $value ) {
						$style .= $property . ': ' . $value . ';';
					}
				}
			}

			if ( ! empty( $style ) ) {
				$css .= $selector . '{' . $style . '}';
			}
		}

		return $css;
	}
endif;

/**
 * Enqueue editor styles for Gutenberg
 *
 */
function unero_block_editor_styles() {

	wp_enqueue_style( 'unero-block-editor-style', get_theme_file_uri( '/css/editor-blocks.css' ) );
	wp_enqueue_style( 'unero-block-editor-fonts', unero_fonts_url(), array(), '20180831' );
	wp_enqueue_style( 'unero-block-editor-linearicons', get_template_directory_uri() . '/css/linearicons.min.css', array(), '1.0.0' );
	wp_add_inline_style( 'unero-block-editor-style', unero_editor_typography_css() );
}

add_action( 'enqueue_block_editor_assets', 'unero_block_editor_styles' );