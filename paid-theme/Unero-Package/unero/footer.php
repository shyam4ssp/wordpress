<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Unero
 */
?>
<?php do_action( 'unero_before_site_content_close' ); ?>
</div><!-- #content -->

<?php do_action('unero_before_footer') ?>

<?php if( ! is_page_template( 'template-home-no-footer.php' ) ) : ?>

<footer id="site-footer" class="site-footer">
	<?php do_action('unero_footer') ?>
</footer><!-- #colophon -->

<?php endif; ?>

<?php do_action('unero_after_footer') ?>
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
