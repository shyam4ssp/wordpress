<?php
/**
 * Custom functions for footer.
 *
 * @package Unero
 */

/**
 * Display socials in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_footer_socials' ) ) :
	function unero_footer_socials( $show_label = false ) {

		$footer_social = unero_get_option( 'footer_socials' );

		$label = '';
		if ( $show_label ) {
			$label = esc_html( unero_get_option('footer_socials_label') );
		}

		unero_get_socials_html( $footer_social, $label );

	}

endif;

/**
 * Display newsletter in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_footer_newsletter' ) ) :
	function unero_footer_newsletter() {
		echo do_shortcode( wp_kses( unero_get_option( 'footer_news_letter' ), wp_kses_allowed_html( 'post' ) ) );
	}

endif;

/**
 * Display logo in footer
 *
 * $default_logo
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_footer_logo' ) ) :
	function unero_footer_logo( $default_logo ) {
		$footer_logo = unero_get_option( 'footer_logo' );

		$footer_logo = empty( $footer_logo ) ? $default_logo : $footer_logo;

		printf( '<div class="footer-logo"><img alt="logo" src="%s" /></div>', esc_url( $footer_logo ) );
	}

endif;

/**
 * Display copyright in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_footer_copyright' ) ) :
	function unero_footer_copyright() {
		echo '<div class="text-copyright">';
		echo do_shortcode( wp_kses( unero_get_option( 'footer_copyright' ), wp_kses_allowed_html( 'post' ) ) );
		echo '</div>';
	}
endif;

/**
 * Display menu in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_footer_menu_1' ) ) :
	function unero_footer_menu_1() {

		$footer_menu = unero_get_option( 'footer_menu_1' );
		if ( ! $footer_menu ) {
			return;
		}

		wp_nav_menu(
			array(
				'menu'      => $footer_menu,
				'container' => false,
				'depth'     => 1
			)
		);
	}
endif;
/**
 * Display menu in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_footer_menu_2' ) ) :
	function unero_footer_menu_2() {

		$footer_menu = unero_get_option( 'footer_menu_2' );
		if ( ! $footer_menu ) {
			return;
		}

		wp_nav_menu(
			array(
				'menu'      => $footer_menu,
				'container' => false,
				'depth'     => 1
			)
		);
	}
endif;

/**
 * Get border top in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_footer_classes' ) ) :
	function unero_footer_classes() {
		$classes = '';
		if ( is_front_page() ||
			is_page_template( 'template-home-no-footer.php' ) ||
			is_page_template( 'template-homepage.php' )
		) {
			$classes = 'no-border-top';
		}

		return $classes;

	}

endif;

/**
 * Display widget in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_footer_widgets' ) ) :
	function unero_footer_widgets() {

		$footer_widget_columns = unero_get_option( 'footer_widget_columns' );
		$columns               = max( 1, absint( $footer_widget_columns ) );
		?>
		<div class="footer-widgets">
			<?php
			for ( $i = 1; $i <= $columns; $i++ ) :
				if ( is_active_sidebar( "footer-sidebar-$i" ) ) {
					?>
					<div class="footer-sidebar footer-<?php echo esc_attr( $i ) ?>">
						<?php dynamic_sidebar( "footer-sidebar-$i" ); ?>
					</div>
				<?php } endfor;

			?>
		</div>
		<?php
	}
endif;