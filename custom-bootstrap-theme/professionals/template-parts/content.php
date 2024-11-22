<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package professionals
 */

?>
<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		?>
	</header><!-- .entry-header -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php professionals_post_thumbnail(); ?>

	<div class="entry-content">
	
	<div class="article-head">
	<?php if ( is_singular() ){ ?>
		<div class="post-avatar">
					<?php
						$user = wp_get_current_user();
						if ( $user ) :
							?>
							<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" />
					<?php endif; ?>
		</div>
	<?php } ?>
	<?php	if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				professionals_posted_on();
				professionals_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</div>
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'professionals' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'professionals' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php professionals_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
