<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) exit;


class Brand extends Widget_Base{

	public function get_name(){
		return "brand";
	}
	
	public function get_title(){
		return "Brand";
	}
	
	public function get_icon(){
		return "eicon-star-o";
	}
	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls(){
/*
==========
Style Tab
==========
*/

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'itsoft' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'select_style',
				[
					'label' => __( 'Select Style', 'itsoft' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'one' => __( 'One', 'itsoft' ),
						'two' => __( 'Two', 'itsoft' ),
					],
					'default' => 'one',
					
				]
			);
		$this->end_controls_section();
	}

	protected function render(){

		$settings = $this->get_settings_for_display();
		
		?>

			<?php if($settings['select_style']=='one'){ ?>

			<div class=" em_load_adn bgimgload blog_style_adn_1">					
				<div class="blog_wrap blog-messonary">

					<?php $the_query = new \WP_Query( array( 'post_type' => 'em_brand' ) ); ?>
					<?php while ($the_query->have_posts()) : $the_query->the_post(); 						
						
					?>
						<!-- single brand -->
						<div class=" <?php if( $gutter == 'yes' ){echo 'blog_nospace_adn';}?>  col-md-<?php if( !empty( $set_column ) ){echo $set_column;}?> grid-item col-xs-12 col-sm-6" >
							<div class="single_brand <?php echo esc_attr( $extra_class ); ?>">
							
	
								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="itsoft-single-brand ">					
										
										<!-- BRAND THUMB -->
										<?php if(has_post_thumbnail()){?>
											<div class="brand-thumb ">
												<?php the_post_thumbnail();?>
											</div>									
										<?php } ?>
													
									</div>
								</div> <!--  END SINGLE BRAND -->
	
									
							</div>
						
						</div>
					<?php endwhile; ?>	
					<?php wp_reset_query(); ?>
				</div>
			</div>

			<?php }elseif($settings['select_style']=='two'){ ?>

			<div class=" blog_style_adn_2">				
				<div class="blog_wrap brand_carousel owl-carousel curosel-style">
				
					<?php $the_query = new \WP_Query( array( 'post_type' => 'em_brand' ) ); ?>
					<?php while ($the_query->have_posts()) : $the_query->the_post(); 											

					?>
						<!-- single blog -->
						<div class=" <?php if( $gutter == 'yes' ){echo 'blog_nospace_adn';}?>  col-md-12 col-xs-12 col-sm-12 " >
							<div class="single_brand <?php echo esc_attr( $extra_class ); ?>">
							
	
								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="itsoft-single-brand ">					
										
										<!-- BLOG THUMB -->
										<?php if(has_post_thumbnail()){?>
											<div class="brand-thumb ">
												<?php the_post_thumbnail();?>
											</div>									
										<?php } ?>
													
									</div>
								</div> <!--  END SINGLE BLOG -->
	
									
							</div>
						
						</div>
					<?php endwhile; ?>	
					<?php wp_reset_query(); ?>

					
				</div>
			</div>
			<?php } ?>

		<?php
	}
}