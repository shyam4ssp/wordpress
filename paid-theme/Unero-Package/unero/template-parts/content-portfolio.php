<?php
/**
 * @package Unero
 */

$portfolio_layout = unero_get_option( 'portfolio_layout' );
$size             = 'unero-portfolio-carousel';
if ( $portfolio_layout == 'masonry' ) {
	$size = 'unero-portfolio-masonry';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-wapper un-post-item' ); ?>>
	<header class="entry-header">
		<?php unero_entry_thumbnail( $size ); ?>
        <?php if ( $portfolio_layout == 'masonry' && unero_get_option('portfolio_columns') == '3' ) : ?>
        <a class="entry-link" href="<?php echo esc_url( get_the_permalink()); ?>"></a>
		<?php endif; ?>
		<div class="entry-meta">
			<?php
			the_terms( get_the_ID(), 'portfolio_category', '<div class="entry-cats">', ' ', '</div>' );
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" class="post-title" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			?>
		</div>

	</header>
	<!-- .entry-content -->
</article><!-- #post-## -->
