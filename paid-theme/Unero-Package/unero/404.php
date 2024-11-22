<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Unero
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<section class="error-404 not-found">
			<div class="page-content col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
				<h3 class="page-title"><i class="icon-cord"></i> <?php esc_html_e( 'ohh! page not found', 'unero' ); ?></h3>

				<p>
					<?php esc_html_e( "It seems we can't find what you're looking for. Perhaps searching can help or go back to ", 'unero' ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Homepage', 'unero' ); ?></a>
				</p>

				<?php get_search_form(); ?>

			</div>
			<!-- .page-content -->
		</section>
		<!-- .error-404 -->

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
