<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Unero
 */

get_header(); ?>

	<div id="primary" class="content-area <?php unero_content_columns() ?>">
		<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php
				the_post_navigation( array(
				'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous Post', 'unero' ) . '</span><span class="icon-arrow-left"></span><span aria-hidden="true" class="nav-subtitle">' . esc_html__( 'Previous', 'unero' ) . '</span><br> <span class="nav-title">%title</span>',
				'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next Post', 'unero' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . esc_html__( 'Next', 'unero' ) . '</span><span class="icon-arrow-right"></span><br> <span class="nav-title">%title</span>',
			) );
			?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
