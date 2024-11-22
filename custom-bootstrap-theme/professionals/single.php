<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package professionals
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
		<?php if ( is_active_sidebar( 'blog-single' ) ) : ?>
		<div id="secondary">
			<div class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'blog-single' ); ?>
			</div>
		</div>
		<?php endif; ?>
	</div><!-- #primary -->

<?php

get_footer();
