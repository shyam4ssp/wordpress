<?php
/**
 * Template for displaying single portfolio
 *
 * @package Unero
 */

get_header(); ?>

<div id="primary" class="content-area <?php unero_content_columns() ?>">
	<?php while ( have_posts() ) :
		the_post(); ?>

		<?php get_template_part( 'template-parts/content-single', 'portfolio' ); ?>


		<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

	<?php endwhile; ?>

	<div class="navigation-portfolio">
		<div class="row">
			<div class="port-prev col-md-4 col-sm-4 col-xs-12">
				<?php
				echo get_previous_post_link( '%link', esc_html__( 'Prev', 'unero' ) );
				?>
			</div>
			<div class="port-archive text-center col-md-4 col-sm-4 col-xs-12">
				<?php
				$back_link = unero_get_option( 'portfolio_back_link' );
				if ( empty ( $back_link ) ) {
					$back_link = get_page_link( get_option( 'drf_portfolio_page_id' ) );
				}
				printf( '<a href="%s"><i class="ion-grid"></i> </a>', esc_url( $back_link ) );
				?>
			</div>
			<div class="port-next text-right col-md-4 col-sm-4 col-xs-12">
				<?php
				echo get_next_post_link( '%link', esc_html__( 'Next', 'unero' ) );
				?>
			</div>
		</div>
	</div>

</div>
<?php get_footer(); ?>
