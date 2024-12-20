<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Unero
 */

get_header(); ?>

<div id="primary" class="content-area <?php unero_content_columns() ?>">
	<?php do_action( 'unero_before_content' ); ?>
	<main id="main" class="site-main">
		<?php if ( have_posts() ) : ?>

			<?php $blog_view = 'blog-layout-' . unero_get_option( 'blog_view' ); ?>

			<div id="unero-site-content" class="<?php echo esc_attr( $blog_view ); ?>">
				<div class="unero-post-list">
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
						?>

					<?php endwhile; ?>
				</div>
			</div>

			<?php unero_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>

	</main>


	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
