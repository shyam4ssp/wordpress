// get sub category list
add_action('woocommerce_archive_description', 'display_subcategories_list', 12 ); 
function display_subcategories_list() {
    if ( is_product_category() ) {
        $term_id  = get_queried_object_id();
        $taxonomy = 'product_cat';
        // Get subcategories of the current category
        $args = array(
            'hierarchical' => 1,
            'show_option_none' => '',
            'hide_empty' => 0,
            'parent' => $term_id,
            'taxonomy' => 'product_cat'
        );
        $subcats = get_categories($args);
        //echo "<pre>";print_r($subcats);die;
        echo '<ul class="wooc_sclist">';
        foreach ($subcats as $sc) {
            //echo "<pre>";print_r($sc);die;
            $link = get_term_link( $sc->slug, $sc->taxonomy );  
            $query = new WP_Query( array(
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tax_query'      => array( array(
                    'taxonomy'   => 'product_cat',
                    'field'      => 'term_id',
                    'terms'      => $sc->term_id,
                ) )
            ) );
            echo '<li class="'.$sc->slug.'"><a href="'. $link .'">'.$sc->name.'</a>';
            /*if ($sc->description) {
                echo '<div class="list-products">';
                    echo substr_replace($sc->description, "...", 500);
                echo '</div>';
            }*/
            while ( $query->have_posts() ) : $query->the_post();
                echo '<div class="list-products">
                    <div class="prod-image">
                        <a href="'. get_permalink() .'">
                            <img src="' . get_the_post_thumbnail_url() . '">
                        </a>
                    </div>
                    <div class="prod-desc">
                        <span>' . get_the_title() . '</span>
                        <div class="desc">'.get_the_excerpt().'</div>
                    </div>
                </div>';
            endwhile;
            wp_reset_postdata();
            echo '</li>';
        }
        echo '</ul>';
    }
    
}