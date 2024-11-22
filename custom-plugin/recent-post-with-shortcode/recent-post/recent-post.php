<?php
/*
Plugin Name: Get post Using shortcode
Plugin URI: https://facebook.com/shyam4ssp/
Description: Get post using shortcode 'recent_post_with_prams' with attribute 'title,cat,limit'
Author: Shyam Pareek
Version: 1.0.0
Author URI: https://facebook.com/shyam4ssp/
*/

// recent posts shortcode
function shapeSpace_recent_posts_shortcode($atts, $content = null) {
    global $post;
    extract(shortcode_atts(array(
        'cat'        => '',
        'num'        => '5',
        'order'      => 'DESC',
        'orderby'    => 'post_date',
        'post_type'  => 'post',
        'title'      => '',
    ), $atts));
    $args = array(
        'cat'            => $cat,
        'posts_per_page' => $num,
        'order'          => $order,
        'orderby'        => $orderby,
        'post_type'      => $post_type,
        'title'          => $title,
    );
    $output = '';
    $posts = get_posts($args);
    foreach($posts as $post) {
        setup_postdata($post);
        $output .= '<li>';
            $output .= '<a href="'. get_the_permalink() .'">';
                $output .= '<div class="thumb">';
                    $output .= ''.get_the_post_thumbnail().'';
                    if (get_field('imdb_rating')) {
                        $output .= '<span class="imdb-rating">'.get_field('imdb_rating').'</span>';
                    }
                $output .= '</div>';
                $output .= '<div class="content">';
                    $output .= '<h3 class="title">'. get_the_title() .'</h3>';
                    $output .= '<div class="excerpt">'.get_the_excerpt().'</div>';
                    $output .= '<div class="field-group">';
                            $categories = get_the_category();
                            $category_list = join( ', ', wp_list_pluck( $categories, 'name' ) );
                        $output .= '<span class="label">Genre: <span>'.wp_kses_post( $category_list ).'</span></span>';
                    $output .= '</div>';
                    $output .= '<div class="trailer-detail">';
                        $output .= '<a href="'.get_the_permalink().'" class="detail">Detail</a>';
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</a>';
        $output .= '</li>';
    }
    wp_reset_postdata();
    return '<div class="recent-custom"><ul>'. $output .'</ul></div>';
}
add_shortcode('recent_post_with_prams', 'shapeSpace_recent_posts_shortcode');