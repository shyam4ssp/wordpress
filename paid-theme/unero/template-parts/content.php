<?php
/**
 * @package Unero
 */
$layout      = unero_get_layout();
$blog_view   = unero_get_option( 'blog_view' );
$image_below = false;
if ( 'full-content' != $layout && $blog_view == 'list' ) {
	$image_below = true;
}
$size = 'unero-blog-normal';
if ( $blog_view == 'list' ) {
	if ( 'full-content' == unero_get_layout() ) {
		$size = 'unero-blog-large';
	}
} elseif ( $blog_view == 'grid' ) {
	$size = 'unero-product-masonry-normal';
} else {
	$size = 'unero-blog-masonry';
}
$css_class = '';

if ( $post_format = get_post_format() ) {
	$css_class = 'format-' . $post_format;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-wapper un-post-item' ); ?>>
	<header class="entry-header">
		<?php if ( $image_below ) {
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" class="post-title" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			unero_posted_on();
		}
		?>
		<?php unero_entry_thumbnail( $size ); ?>

		<?php if ( ! $image_below ) {
			if ( $blog_view == 'masonry' ) {
				unero_posted_on();
			}
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" class="post-title" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

			if ( $blog_view != 'masonry' ) {
				unero_posted_on();
			}
		}
		?>
	</header>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>
	<!-- .entry-content -->

	<footer class="entry-footer">
		<a class="readmore button" href="<?php the_permalink() ?>"><?php esc_html_e( 'Continue', 'unero' ) ?></a>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->
