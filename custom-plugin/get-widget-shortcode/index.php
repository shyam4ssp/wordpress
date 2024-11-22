<?php
/*
Plugin Name: Get Widget Using Shortcode
Plugin URI: https://axiswebart.com
Description: Get post using shortcode 'custom-widget' with attribute 'id'
Author: Shyam Pareek
Version: 1.0.0
Author URI: https://axiswebart.com
*/

// get widget using shortcodes
add_shortcode( 'custom-widget', 'custom_widget' );
function custom_widget( $atts, $content = null, $tag = '' ) {
 $a = shortcode_atts( array(
 'id' => '',
 ), $atts );
 ?>
<div class="widget-shortcode widget-shortcode-<?php echo $a['id'] ?>" id="widget-shortcode-<?php echo $a['id'] ?>">
    <?php dynamic_sidebar("".$a['id']."").'';
}?>
</div>
<?php