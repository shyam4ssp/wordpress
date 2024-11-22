<?php
// theme fallback menu
if(!function_exists('itsoft_fallback_menu')){
	
	function itsoft_fallback_menu(){?>

		<ul class="main-menu clearfix">
			<li><a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>"></a></li>
		</ul>	
	<?php }			
}

// theme main menu
if(!function_exists('itsoft_main_menu')){
	
	function itsoft_main_menu(){
		wp_nav_menu(array(
			 'theme_location' =>'menu-1',
			 'container'      => false,
			 'menu_class' =>'sub-menu',
			 'fallback_cb' =>'itsoft_fallback_menu',									
		));
	}
}


// theme main menu
if(!function_exists('itsoft_one_page_menu')){
	
	function itsoft_one_page_menu(){
		wp_nav_menu(array(
			 'theme_location' =>'one-pages',
			 'container'      => false,
			 'menu_class' =>'sub-menu nav_scroll',
			 'fallback_cb' =>'itsoft_fallback_menu',									
		));
	}
}



// theme main menu
if(!function_exists('itsoft_mobile_menu')){
	
	function itsoft_mobile_menu(){
		wp_nav_menu(array(
			 'theme_location' =>'menu-3',
			 'container'      => false,
			 'menu_class' =>'main-menu clearfix',
			 'fallback_cb' =>'itsoft_fallback_menu',									
		));
	}
}

// theme logo 1 setting 
if(!function_exists('itsoft_main_logo')){				
	function itsoft_main_logo(){
	 global $itsoft_opt;
	 if(is_ssl()){
	 	if(isset($itsoft_opt['itsoft_logo']['url']))
	 	{
		  $itsoft_opt['itsoft_logo']['url'] = str_replace('http:', 'https:', $itsoft_opt['itsoft_logo']['url']);
	      $itsoft_opt['itsoft_ts_logo']['url'] = str_replace('http:', 'https:', $itsoft_opt['itsoft_ts_logo']['url']);

	 	}
	 }
	 ?>

	  <?php if( isset($itsoft_opt['itsoft_logo']['url']) ){ ?>
	  
		<div class="logo">
			<a class="main_sticky_main_l standard-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<img src="<?php echo esc_url($itsoft_opt['itsoft_logo']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
			<a class="main_sticky_l" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<img src="<?php echo esc_url($itsoft_opt['itsoft_ts_logo']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>			
		</div>	  

	  <?php
	  
	  } else { ?>
	  
			<div class="logo_area">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1><?php 
	  			$description = get_bloginfo( 'description', 'display' );
				$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>			
			</div>	 					
	 
	<?php  }
	}
}
// theme logo 2 setting 
if(!function_exists('itsoft_onepage_logo')){				
	function itsoft_onepage_logo(){
	 global $itsoft_opt;
	 if(is_ssl()){
	  $itsoft_opt['itsoft_onepage_logo']['url'] = str_replace('http:', 'https:', $itsoft_opt['itsoft_onepage_logo']['url']);
	  $itsoft_opt['itsoft_ts_logo']['url'] = str_replace('http:', 'https:', $itsoft_opt['itsoft_ts_logo']['url']);
	 }
	 ?>

	  <?php if( isset($itsoft_opt['itsoft_onepage_logo']['url']) ){ ?>
	  
		<div class="logo">
			<a class="main_sticky_main_l"  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<img src="<?php echo esc_url($itsoft_opt['itsoft_onepage_logo']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
			<a class="main_sticky_l" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<img src="<?php echo esc_url($itsoft_opt['itsoft_ts_logo']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>			
		</div>	  

	  <?php
		}
	}
}

// theme logo 3 setting 
if(!function_exists('itsoft_ts_logo')){				
	function itsoft_ts_logo(){
	 global $itsoft_opt;
	 if(is_ssl()){
	  $itsoft_opt['itsoft_ts_logo']['url'] = str_replace('http:', 'https:', $itsoft_opt['itsoft_ts_logo']['url']);
	 }
	 ?>

	  <?php if( isset($itsoft_opt['itsoft_ts_logo']['url']) ){ ?>
	  
		<div class="logo">
			<a class="standard-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<img src="<?php echo esc_url($itsoft_opt['itsoft_ts_logo']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
			<a class="retina-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<img src="<?php echo esc_url($itsoft_opt['itsoft_retina_logo']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>	
		</div>	  

	  <?php
		}
	}
}
// theme logo 4 for mobile 
if(!function_exists('itsoft_mobile_top_logo')){				
	function itsoft_mobile_top_logo(){
	 global $itsoft_opt;
	 if(is_ssl()){
	  $itsoft_opt['itsoft_mobile_top_logo']['url'] = str_replace('http:', 'https:', $itsoft_opt['itsoft_mobile_top_logo']['url']);
	 }
	 ?>

	  <?php if( isset($itsoft_opt['itsoft_mobile_top_logo']['url']) ){ ?>
		<div class="mobile_menu_logo text-center">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<img src="<?php echo esc_url($itsoft_opt['itsoft_mobile_top_logo']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>		
		</div>
	  <?php
		}
	}
}



/* login option */

if(!function_exists('itsoft_search_code')){
	function itsoft_search_code(){
		?>
		<div class="em-quearys-top msin-menu-search">
			<div class="em-top-quearys-area">
			   <ul class="em-header-quearys">
					<li class="em-quearys-menu">
						<i class="fa fa-search t-quearys"></i>
						 <i class="fa fa-close  t-close em-s-hidden"></i>
					</li>
				</ul>
					<!--Search Form-->
					<div class="em-quearys-inner">
						<div class="em-quearys-form">
							<form class="top-form-control" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
								<input type="text" placeholder="<?php echo esc_attr( 'Type Your Keyword', 'itsoft' ) ?>" name="s" value="<?php the_search_query(); ?>" />
								<button class="top-quearys-style" type="submit">
									<i class="fa fa-search"></i>
								</button>
							</form>                                
						</div>
					</div>
					<!--End of Search Form-->									
			</div>
		</div>			
		
	<?php
	}
}

//itsoft comment form
add_filter('comment_form_default_fields','itsoft_comments_form');
if(!function_exists('itsoft_comments_form')){
    function itsoft_comments_form($default){
			$default['author'] = '<div  class="comment_forms from-area"><div  class="comment_forms_inner">
			
			<div class="comment_field"><div class="row"><div class="col-md-6 form-group">
				<input id="name" class="form-control" name="author" type="text" placeholder="'.esc_attr('Your Name','itsoft').'"/>
			</div>';

			$default['email'] = '
			<div class="col-md-6 form-group">
				<input id="email" class="form-control"  name="email" type="text" placeholder="'.esc_attr(' Email','itsoft').'"/>
			</div></div>';	
			$default['phone'] = '<div class="row">
			<div class="col-md-6 form-group">
				<input id="phone" class="form-control"  name="phone" type="text" placeholder="'.esc_attr('Phone','itsoft').'"/>
			</div>';

			$default['title'] = '
			<div class="col-md-6 form-group">
				<input id="title" class="form-control" name="url" type="text" placeholder="'.esc_attr('Your Website','itsoft').'"/>
			</div> </div></div>';	
			$default['url']='';
			$default['message'] ='<div class="comment_field"><div class="form-group"><textarea name="comment" id="comment" class="form-control" cols="30" rows="6" placeholder="'.esc_attr(' Your comment...','itsoft').'"></textarea></div></div></div></div>';																
 
        return $default;
    }
}

add_filter('comment_form_defaults','itsoft_form_default');

 if(!function_exists('itsoft_form_default')){
    function itsoft_form_default($default_info){
        if(!is_user_logged_in()){
            $default_info['comment_field'] = '';
        }else{
            $default_info['comment_field'] = '<div  class="comment_forms"><div  class="comment_forms_inner"> <div class="comment_field row"><div class="col-md-12 form-group"><label for="comment">'.esc_html__('Comment','itsoft').'<em>*</em></label><textarea name="comment" id="comment" class="form-control" cols="30" rows="6" placeholder="'.esc_attr('Your comment...','itsoft').'"></textarea></div></div> </div></div>';
        }
         
        $default_info['submit_button'] = '<button class="wpcf7-submit button" type="submit">'.esc_html__('Post Comment','itsoft').'</button>';
        $default_info['submit_field'] = '%1$s %2$s';
        $default_info['comment_notes_before'] = ' ';
        $default_info['title_reply'] = esc_html__('Leave Comment','itsoft');
        $default_info['title_reply_before'] = '<div class="commment_title"><h3> ';
        $default_info['title_reply_after'] = '</h3></div> ';
 
        return $default_info;
    }
 
 }
	
	
//itsoft comment show
if(! function_exists('itsoft_comment')){
	function itsoft_comment($comment,$arg, $depth){
		$GLOBALS ['comment'] = $comment;
		?>

		<!-- connent reply -->		
		<div class="post_comment">
			<div class="comment_inner">
				<div class="post_replay">
					<div class="post_replay_content">											
						<div class="post_replay_inner" id="comment-<?php comment_ID(); ?>">
							<div class="post_reply_thumb">
								 <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"> <?php echo get_avatar($comment,80); ?></a>
							</div>
							<div class="post_reply">
								<div class="st"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php echo get_comment_author(); ?></a></div>
								<div class="reply_date">
									<span class="span_left"><?php echo get_comment_date(get_option('date_format')); ?></span>
									<?php 
										comment_reply_link(
											array_merge($arg,array(
												'reply_text' => '<span class="span_right">'. esc_html__('Reply','itsoft').'</span>',
												'depth'    => $depth,
												'max_depth' => $arg['max_depth']
											))
									); ?>   
									
								</div>
								<p><?php comment_text(); ?></p>
								<div class="edit_comment"><?php edit_comment_link(esc_html__('(Edit)' , 'itsoft' ),'<small class="ecome">','</small>') ?></div>
							</div>
							
						</div>
					</div>																
				</div>
			</div>
		</div>		
	
		<?php
	}
}




/**
 * Add color styling from theme
 */
 
 if( !function_exists( 'itsoft_inline_styles' ) ) {
function itsoft_inline_styles() {
	 global $itsoft_opt;
	 $lheight=$logoheight=$lwidth=$logoweight=$linheight=$lmtop=$mobile_image=$mobile_image_sec='';
	
		if (!empty($itsoft_opt['itsoft_logo_height'])){
			$lheight=$itsoft_opt['itsoft_logo_height'];
			$logoheight="height:{$lheight}";
		}

		if (!empty($itsoft_opt['itsoft_line_height'])){
			$linheight=$itsoft_opt['itsoft_line_height'];
			$lmtop="margin-top:{$linheight}";
		}
		if (!empty($itsoft_opt['itsoft_mobile_image_logo'])){
			$mobile_image=$itsoft_opt['itsoft_mobile_image_logo'];
			$mobile_image_sec="content:{$mobile_image}";
		}		
		
			 
		wp_enqueue_style(
			'itsoft-breadcrumb',
			get_template_directory_uri() . '/assets/css/em-breadcrumb.css'
		);			
        $inlinewp_css = "
					.logo img {
						{$logoheight};
						{$logoweight};
					}
					.logo a{
						{$lmtop}
					}
					.mean-container .mean-bar::before{
						{$mobile_image_sec}						
					}											
               ";				
				
        wp_add_inline_style( 'itsoft-breadcrumb', $inlinewp_css );
	}
}
add_action( 'wp_enqueue_scripts', 'itsoft_inline_styles',200 );


/**
* Print pagination
*
* @param    array           $args           Arguments for this function, including 'query', 'range'
* @param    string         $wrapper        Type of html wrapper
* @param    string         $wrapper_class  Class of HTML wrapper
* @echo     string                          Post Meta HTML
*/
if( !function_exists( 'itsoft_pagination' ) ) {
	function itsoft_pagination( $args = NULL , $wrapper = 'div', $wrapper_class = 'paginations' ) {

		// Set up some globals
		global $wp_query, $paged;

		// Get the current page
		if( empty($paged ) ) $paged = ( get_query_var('page') ? get_query_var('page') : 1 );

		// Set a large number for the 'base' argument
		$big = 99999;

		// Get the correct post query
		if( !isset( $args[ 'query' ] ) ){
			$use_query = $wp_query;
		} else {
			$use_query = $args[ 'query' ];
		} ?>

		<<?php echo esc_html($wrapper); ?> class="<?php echo esc_html($wrapper_class); ?>">
			<?php echo paginate_links( array(
				'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
				'prev_next' => true,
				'mid_size' => ( isset( $args[ 'range' ] ) ? $args[ 'range' ] : 5 ) ,
				'prev_text' => '<i class="fa fa-angle-double-left"></i>',
				'next_text' => '<i class="fa fa-angle-double-right"></i>',
				'type' => 'list',
				'current' => $paged,
				'total' => $use_query->max_num_pages
			) ); ?>
		</<?php echo esc_html($wrapper); ?>>
	<?php }
} // itsoft_pagination


if( !function_exists( 'itsoft_slider_o' ) ) {
 function itsoft_slider_o( $file_list_meta_key, $img_size = 'full' ) {

  // Get the list of files
  $files = get_post_meta( get_the_ID(), $file_list_meta_key, 1 );

  // Loop through them and output an image
  foreach ( (array) $files as $attachment_id => $attachment_url ) {
			echo '<div class="gitem">';
			echo wp_get_attachment_image( $attachment_id, $img_size );
			echo '</div>';
		}
	}
}

