<?php

if(!function_exists('itsoft_blog_breadcrumb')){
	function itsoft_blog_breadcrumb(){?>
		<!-- BLOG BREADCUMB START -->
		<div class="breadcumb-area">
			<div class="container">				
				<div class="row">
					<div class="col-md-12">						
						<div class="breadcumb-inner">
							<h2><?php esc_html_e('Blog Standerd','itsoft'); ?></h2>
							<?php itsoft_breadcrumbs(); ?>								
						</div>	
					</div>
				</div>
			</div>
		</div>		
	<?php }	
}
 
if(!function_exists('itsoft_signle_blog_breadcrumb')){
	function itsoft_signle_blog_breadcrumb(){?>
		<!-- BLOG BREADCUMB START -->
		<div class="breadcumb-area">
			<div class="container">				
				<div class="row">
					<div class="col-md-12">						
						<div class="breadcumb-inner">
							<h2><?php esc_html_e('Single Blog','itsoft'); ?></h2>
							<?php itsoft_breadcrumbs(); ?>							
						</div>	
					</div>
				</div>
			</div>
		</div>		
	<?php }	
}

if(!function_exists('itsoft_signle_case_breadcrumb')){
	function itsoft_signle_case_breadcrumb(){?>
		<!-- BLOG BREADCUMB START -->
		<div class="breadcumb-area">
			<div class="container">				
				<div class="row">
					<div class="col-md-12">						
						<div class="breadcumb-inner">
							<h2><?php esc_html_e('Case Study Details','itsoft'); ?></h2>
							<?php itsoft_breadcrumbs(); ?>							
						</div>	
					</div>
				</div>
			</div>
		</div>		
	<?php }	
}


// itsoft breadcrumb
if(!function_exists('itsoft_breadcrumbs')){
	function itsoft_breadcrumbs() {
		echo '<ul>';
		//if (!is_home()) {
					echo '<li><a href="';
					echo esc_url( home_url( '/' ) );
					echo '">';
					echo esc_html__('Home','itsoft');
					echo "</a></li>";
					echo '<li><i class="fa fa-angle-right"></i></li>';		

			if (is_category()) {	
					echo "<li>";
					echo single_cat_title( '', false );
					echo '</li>';
			}
			elseif( is_archive() ) {
				the_archive_title( '<li>', '</li>' );
			}			
			elseif (is_page()) {			
					echo '<li>';
					echo get_the_title();
					echo '</li>';
			}
			elseif (is_single()) {	
					echo "<li>";
					the_title();
					echo '</li>';
			}		
			elseif (is_tag()) {
				single_tag_title();
			}

			elseif (is_day()) {
				echo"<li>";
					echo esc_html__('Archive for','itsoft');
				echo'</li>';				
			}
			elseif (is_month()) {
				echo"<li>";
					echo esc_html__('Archive for','itsoft');
				echo'</li>';				
			}
			elseif (is_year()) {
				echo"<li>";
					echo esc_html__('Archive for','itsoft');
				echo'</li>';				
			}
			elseif (is_author()) {
				echo"<li>";
					echo esc_html__('Author','itsoft');
				echo'</li>';			
			}
			elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
				echo"<li>";
					echo esc_html__('Blog Archives','itsoft');
				echo'</li>';			
			}
			elseif (is_search()) {
				echo"<li>";
					echo esc_html__('Search Results','itsoft');
				echo'</li>';
			}
			elseif (is_404()) {
				echo"<li>";
					echo esc_html__('404','itsoft');
				echo'</li>';
			}
		//}
		echo '</ul>';
	}
}
// end itsoft breadcrumb

