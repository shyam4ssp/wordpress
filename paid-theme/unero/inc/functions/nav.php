<?php
/**
 * Custom functions for nav menu
 *
 * @package Unero
 */


/**
 * Display numeric pagination
 *
 * @since 1.0
 * @return void
 */
if ( ! function_exists( 'unero_numeric_pagination' ) ) :
	function unero_numeric_pagination() {
		global $wp_query;

		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		?>
		<nav class="navigation paging-navigation mumeric-navigation">
			<?php
			$big  = 999999999;
			$args = array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'total'     => $wp_query->max_num_pages,
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'prev_text' => esc_html__( 'Previous', 'unero' ),
				'next_text' => esc_html__( 'Next', 'unero' ),
				'type'      => 'plain',
			);

			echo paginate_links( $args );
			?>
		</nav>
		<?php
	}
endif;

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since 1.0
 * @return void
 */
if ( ! function_exists( 'unero_paging_nav' ) ) :
	function unero_paging_nav() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$nav_class = '';
		$nav_type  = unero_get_option( 'blog_nav_type' );
		if ( unero_is_portfolio() ) {
			$nav_type = unero_get_option( 'portfolio_nav_type' );
		}

		if ( $nav_type == 'infinite' ) {
			$nav_class = 'infinite';
		}
		?>
		<nav class="navigation paging-navigation <?php echo esc_attr( $nav_class ); ?>">
			<div class="nav-links">
				<?php if ( get_next_posts_link() ) : ?>
					<?php if ( $nav_type == 'infinite' ) { ?>
						<div id="unero-infinite-loading" class="nav-previous"><?php next_posts_link( wp_kses_post( sprintf( '<span class="dots-loading"><span>.</span><span>.</span><span>.</span>%s<span>.</span><span>.</span><span>.</span></span>', esc_html__( 'Loading', 'unero' ) ) ) ); ?></div>
					<?php } else { ?>
						<div class="nav-previous"><?php next_posts_link( wp_kses_post( sprintf( '<span class="meta-nav icon-arrow-left"></span>%s', esc_html__( 'Older posts', 'unero' ) ) ) ); ?></div>
					<?php } ?>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( wp_kses_post( sprintf( '%s<span class="meta-nav icon-arrow-right"></span>', esc_html__( 'Newer posts', 'unero' ) ) ) ); ?></div>
				<?php endif; ?>


			</div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;
