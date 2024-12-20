<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Unero
 */

get_header(); ?>

<section id="primary" class="content-area <?php unero_content_columns() ?>">
	<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<h2 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'unero' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
			<div id="unero-site-content">
				<div class="unero-post-list">
					<?php /* Start the Loop */ ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );
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
</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
