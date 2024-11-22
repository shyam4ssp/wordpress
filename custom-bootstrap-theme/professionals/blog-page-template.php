<?php /* Template Name: Blog Page */ ?>
 
<?php get_header(); ?>
 
<div id="primary" class="content-area">
   <div class="blog-banner">
	<h2>Professionals Club Blog</h2>
	<p>The Professionals Club Blog is the top hub for business, design, and technology talent, executives, and entrepreneurs, featuring key technology updates, tutorials, freelancer resources, and management insights. </p>
       </div>
       <div class="full_width blog-cate">
      <div class="wrapper">
      <div class="clear row">
      	<ul class="blog_verticals">
			<li class="col-md-4 col-sm-6 item">
				<a href="#">
					<div class="image_wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/image/computer.png" alt="" /></div>
					<h3>Professionals Club Engineering Blog</h3>
					<p>Development tutorials and technical resources.</p>
				</a>
			</li>
    		<li class="col-md-4 col-sm-6 item">
				<a href="#">
					<div class="image_wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/image/computer.png" alt="" /></div>
					<h3>Professionals Club Engineering Blog</h3>
					<p>Development tutorials and technical resources.</p>
				</a>
			</li>
    		<li class="col-md-4 col-sm-6 item">
				<a href="#">
					<div class="image_wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/image/computer.png" alt="" /></div>
					<h3>Professionals Club Engineering Blog</h3>
					<p>Development tutorials and technical resources.</p>
				</a>
			</li>
    		<li class="col-md-4 col-sm-6 item">
				<a href="#">
					<div class="image_wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/image/computer.png" alt="" /></div>
					<h3>Professionals Club Engineering Blog</h3>
					<p>Development tutorials and technical resources.</p>
				</a>
			</li>
    		<li class="col-md-4 col-sm-6 item">
				<a href="#">
					<div class="image_wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/image/computer.png" alt="" /></div>
					<h3>Professionals Club Engineering Blog</h3>
					<p>Development tutorials and technical resources.</p>
				</a>
			</li>
    		<li class="col-md-4 col-sm-6 item">
				<a href="#">
					<div class="image_wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/image/computer.png" alt="" /></div>
					<h3>Professionals Club Engineering Blog</h3>
					<p>Development tutorials and technical resources.</p>
				</a>
			</li>
    	
     	</ul>
			</div>
       </div>
	</div>
    <main id="main" class="site-main" role="main">
       <?php 
// the query
$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>
 
<?php if ( $wpb_all_query->have_posts() ) : ?>
     <?php wp_reset_postdata(); ?>
 
<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
       
       
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();
 
            // Include the page content template.
            get_template_part( 'template-parts/content', 'page' );
 
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
 
            // End of the loop.
        endwhile;
        ?>

<ul class="row">
    <!-- the loop -->
    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
        <li class="col-md-6 blog-list">
			<div class="width-100 blog-des">
			<div class="post-image">
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); }else{echo '<img src="'.get_stylesheet_directory_uri().'/image/default-none.jpg" />';} ?>
				<div class="post-avatar">
					<?php
						$user = wp_get_current_user();
						if ( $user ) :
							?>
							<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" />
					<?php endif; ?>
				</div>
			</div>
			<div class="post-inner">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<p class="post-by">By <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a> - Editor @ <a href="<?php echo get_site_url(); ?>">Professionals Club</a></p>
				<div class="post_excerpt"><?php the_excerpt(); ?></div>
				<div class="read-more">
					<a href="<?php the_permalink(); ?>">Continue Reading &rarr;</a>
				</div>
       		</div>
       		</div>
        </li>
    <?php endwhile; ?>
    <!-- end of the loop -->
</ul>
 
 
    </main><!-- .site-main -->
 
    <?php get_sidebar( 'content-bottom' ); ?>
 
</div><!-- .content-area -->

 
<?php get_sidebar(); ?>
<?php get_footer(); ?>