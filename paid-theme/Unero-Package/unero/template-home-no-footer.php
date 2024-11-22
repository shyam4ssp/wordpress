<?php
/**
 * Template Name: HomePage Without Footer
 *
 * The template file for displaying home page no footer.
 *
 * @package Unero
 */

get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;

endif;
?>
<?php get_footer(); ?>
