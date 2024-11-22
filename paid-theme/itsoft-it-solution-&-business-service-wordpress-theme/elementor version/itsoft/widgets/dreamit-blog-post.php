<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) exit;


class BlogPost extends Widget_Base{

	public function get_name(){
		return "blogpost";
	}
	
	public function get_title(){
		return "Blog Post";
	}
	
	public function get_icon(){
		return "eicon-table-of-contents";
	}
	public function get_categories(){
		return ['my_category'];
	}
	
	protected function _register_controls(){

		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button', 'itsoft' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'button_text',
				[
					'label' => __( 'Button Text', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your button text', 'itsoft' ),
					'label_block' => true,
					'default' => __( 'Read More', 'itsoft' ),
				]
			);
			$this->add_control(
				'show_button',
				[
					'label' => __( 'Show Button', 'itsoft' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'itsoft' ),
					'label_off' => __( 'Hide', 'itsoft' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'button_icon',
				[
					'label' => __( 'Button Icon', 'itsoft' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon-right-arrow-3',
						'library' => 'solid',
					],
				]
			);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'description_section',
			[
				'label' => __( 'Description', 'itsoft' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
				'show_description',
				[
					'label' => __( 'Show/Hide Description', 'itsoft' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'itsoft' ),
					'label_off' => __( 'Hide', 'itsoft' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
$this->end_controls_section();
/*
==========
Style Tab
==========
*/

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'itsoft' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'select_style',
				[
					'label' => __( 'Select Style', 'itsoft' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'one' => __( 'One', 'itsoft' ),
						'two' => __( 'Two', 'itsoft' ),
					],
					'default' => 'two',
					
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'button_style',
			[
				'label' => __( 'Button Style', 'itsoft' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'btn_color',
				[
					'label' => __( 'Color', 'itsoft' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .itsoft-blog-readmore a' => 'color: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		?>
			
			
			
			
			
	<?php if($settings['select_style']=='one'){ ?>			
			
			<div class=" blog_style_default">				
				<div class="blog_wrap blog_carousel owl-carousel curosel-style">
					<?php $the_query = new \WP_Query( array( 'post_type' => 'post' ) ); ?>
					<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<!-- single blog -->
						<div class="col-md-12 col-xs-12 col-sm-12 " >
							<div class="single_blog_adn">
								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="itsoft-single-blog_adn ">

										<!-- BLOG THUMB -->
										
										<div class="itsoft-blog-thumb_adn ">
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('itsoft-blog-default'); ?></a>
											<div class="itsoft-blog-meta-top">
												<?php the_category();?>
											</div>
										</div>									
										
										<!-- BLOG CONTENT -->
										<div class="em-blog-content-area_adn ">

											<!-- BLOG META -->
											<div class="itsoft-blog-meta-left ">
												<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
												<span><?php echo get_the_time(get_option('date_format')); ?></span>
											</div>	

											<!-- BLOG TITLE -->
											<div class="blog-page-title_adn ">
												<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>			
											</div>

											
											<?php if('yes'===$settings['show_description']){?>
											<!-- BLOG CONTENT -->
											<div class="blog-inner_adn ">
												<div class="blog-content_adn ">					
													<p><?php echo wp_trim_words( get_the_content(), 12, ' ' ); ?></p>
												</div>
											</div>	
											<?php } ?>

											<!-- BLOG BUTTON -->
											<?php if( 'yes'===$settings['show_button'] ){ ?>
											<div class="itsoft-blog-readmore">
												<a href="#" class="learn_btn"><?php echo $settings['button_text']; ?><?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
											</div>
											<?php } ?>
											
										</div><!-- .em-blog-content-area_adn -->
										
									</div>
								
								</div> <!--  END SINGLE BLOG -->	
							</div>
						
						</div>
					<?php endwhile; ?>
					
				</div>
			</div>
		<?php }elseif($settings['select_style']=='two'){ ?>
			<div class=" blog_style_two">				
				<div class="blog_wrap blog_carousel owl-carousel curosel-style">
					<?php $the_query = new \WP_Query( array( 'post_type' => 'post' ) ); ?>
					<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<!-- single blog -->
						<div class="col-md-12 col-xs-12 col-sm-12 " >
							<div class="single_blog_adn">
								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="itsoft-single-blog_adn ">

										<!-- BLOG THUMB -->
										
										<div class="itsoft-blog-thumb_adn ">
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('itsoft-blog-default'); ?></a>
											<div class="itsoft-blog-meta-top">
												<?php the_category();?>
											</div>
										</div>									
										
										<!-- BLOG CONTENT -->
										<div class="em-blog-content-area_adn ">

											<!-- BLOG META -->
											<div class="itsoft-blog-meta-left ">
												<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
												<span><?php echo get_the_time(get_option('date_format')); ?></span>
											</div>	

											<!-- BLOG TITLE -->
											<div class="blog-page-title_adn ">
												<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>			
											</div>

											<!-- BLOG CONTENT -->
											<div class="blog-inner_adn ">
												<div class="blog-content_adn ">					
													<p><?php echo wp_trim_words( get_the_content(), 12, ' ' ); ?></p>
												</div>
											</div>	

											<!-- BLOG BUTTON -->
											<?php if( 'yes'===$settings['show_button'] ){ ?>
											<div class="itsoft-blog-readmore">
												<a href="#" class="learn_btn"><?php echo $settings['button_text']; ?><?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
											</div>
											<?php } ?>
											
										</div><!-- .em-blog-content-area_adn -->
										
									</div>
								
								</div> <!--  END SINGLE BLOG -->
	
									
							</div>
						
						</div>
					<?php endwhile; ?>
					
				</div>
			</div>
			<?php } ?>
	
		<?php
	}
}