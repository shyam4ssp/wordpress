<?php
/**
 * @package Unero
 */

$css_class = '';

if ( $post_format = get_post_format() ) {
	$css_class = 'format-' . $post_format;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-wapper' ); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php unero_posted_on(); ?>
		</div>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<?php unero_entry_thumbnail( 'full' ); ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'unero' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
	<!-- .entry-content -->

	<footer class="entry-footer">
		<?php unero_entry_footer(); ?>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->
