<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Unero
 */

get_header(); ?>

<div id="primary" class="content-area <?php unero_content_columns() ?>">
	<?php do_action( 'unero_before_content' ); ?>
	<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>
			<?php $class_view = 'blog-layout-' . unero_get_option( 'portfolio_layout' );
			$class_view .= ' portfolio-cols-' . unero_get_option( 'portfolio_columns' )
			?>

			<div id="unero-site-content" class="<?php echo esc_attr( $class_view ); ?>">
				<div class="unero-post-frame">
					<div class="unero-post-list">
						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							get_template_part( 'template-parts/content', 'portfolio' );
							?>

						<?php endwhile; ?>
					</div>
				</div>
				<div class="container">
					<div class="scrollbar"><div class="handle" style=""><div class="mousearea"></div></div></div>
				</div>
			</div>
			<?php unero_paging_nav(); ?>
		<?php else : ?>

			<?php get_template_part( 'parts/content', 'none' ); ?>

		<?php endif; ?>

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
