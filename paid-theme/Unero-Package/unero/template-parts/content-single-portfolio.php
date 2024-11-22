<?php
/**
 * @package Unero
 */

?>
<article <?php post_class( 'single-portfolio-layout-1' ) ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-left">
					<?php
					$time_string   = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
					$time_string   = sprintf(
						$time_string,
						esc_attr( get_the_date( 'c' ) ),
						esc_html( get_the_date() )
					);
					$archive_year  = get_the_time( 'Y' );
					$archive_month = get_the_time( 'm' );
					$archive_day   = get_the_time( 'd' );

					printf(
						'<a href="' . esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) . '" class="entry-meta" rel="bookmark">' . $time_string . '</a>'
					);
					?>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<?php
					if ( unero_get_option( 'portfolio_share_box' ) ):
						printf( '<div class="portfolio-socials">' );
						printf( '<span>%s: </span>', esc_html__( 'Share', 'unero' ) );
						$image = unero_get_image(
							array(
								'size'     => 'full',
								'format'   => 'src',
								'meta_key' => 'image',
								'echo'     => false,
							)
						);
						unero_share_link_socials( get_the_title(), get_permalink(), $image );
						printf( '</div>' );
					endif;
					?>
				</div>
			</div>

		</div>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
