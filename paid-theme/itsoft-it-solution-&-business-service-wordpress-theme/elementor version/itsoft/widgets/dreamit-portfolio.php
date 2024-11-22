<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) exit;


class Portfolio extends Widget_Base{

	public function get_name(){
		return "portfolio";
	}
	
	public function get_title(){
		return "Portfolio";
	}
	
	public function get_icon(){
		return "eicon-star-o";
	}

	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls(){

		$this->start_controls_section(
			'tab_section',
			[
				'label' => __( 'Tab', 'itsoft' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'all_works_text',
				[
					'label' => __( 'All Works Text', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter All Works text', 'itsoft' ),
					'label_block' => true,
					'default' => __( 'All Works', 'itsoft' ),
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'itsoft' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'select_column',
				[
					'label' => __( 'Select Column', 'itsoft' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'12' => __( '1 Column', 'itsoft' ),
						'6'	=> __( '2 Column', 'itsoft' ),
						'4'	=> __( '3 Column', 'itsoft' ),
						'3'	=> __( '4 Column', 'itsoft' )
					],
					'default' => '3',
				]
			);
		$this->end_controls_section();

/*
==========
Style Tab
==========
*/

		$this->start_controls_section(
			'tab_style_section',
			[
				'label' => __( 'Tab', 'itsoft' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'tab_color',
				[
					'label' => __( 'Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .current_menu_item' => 'background: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => __( 'Border', 'itsoft' ),
					'selector' => '{{WRAPPER}} .portfolio_nav ul li',
				]
			);
		$this->end_controls_section();

	}

	protected function render(){

		$settings = $this->get_settings_for_display();

		$args = array(
			'post_type' => 'em_portfolio',
		);
		$the_query = new \WP_Query($args);

		?>

		<div class="clearfix kicuakta">
			<div class="col-md-12">
				<div class="portfolio_nav   <?php echo esc_attr( $extra_class ); ?>">
					<ul id="filter" class="filter_menu ">
						<li class="current_menu_item" data-filter="*" ><?php echo $settings['all_works_text'];?></li>
					<?php 	
					$categories = get_terms('em_portfolio_cat');
						foreach ( $categories as $single_category ) {?>										
							<li   data-filter=".<?php echo esc_attr( $single_category->slug );?>"><?php echo esc_html( $single_category->name );?></li>
						<?php }?>
					</ul>
				</div>

			</div>				
		</div>

			<div class=" em_load pstyle_1 em_port_container">					
				<div class="prot_wrap">				
					<?php while ($the_query->have_posts()) : $the_query->the_post(); 						
						$terms = get_the_terms(get_the_ID(), 'em_portfolio_cat');
						$saloption  = get_post_meta( get_the_ID(),'_itsoft_saloption', true ); 
						$siimagepop  = get_post_meta( get_the_ID(),'_itsoft_siimagepop', true ); 
						$sllink  = get_post_meta( get_the_ID(),'_itsoft_sllink', true ); 
						$shyoutub  = get_post_meta( get_the_ID(),'_itsoft_shyoutub', true ); 
						$pyoutube  = get_post_meta( get_the_ID(),'_itsoft_pyoutube', true ); 
						$svvimeo  = get_post_meta( get_the_ID(),'_itsoft_svvimeo', true ); 
						$pvimeo  = get_post_meta( get_the_ID(),'_itsoft_pvimeo', true );
						$pshow_cat  = get_post_meta( get_the_ID(),'_itsoft_pshow_cat', true ); 
						$pshow_title  = get_post_meta( get_the_ID(),'_itsoft_pshow_title', true );
					?>
						<!-- single portfolio -->
						<div class=" <?php if( $gutter == 'yes' ){echo 'nospace';}?>col-md-6 col-sm-12  col-lg-<?php echo $settings['select_column']; ?> grid-item col-xs-12 col-sm-6 <?php foreach( $terms as $single_slug){echo $single_slug->slug. ' ';}	?>" >

					<div class="single_protfolio  <?php echo esc_attr( $extra_class ); ?>">
					<?php $m_g_image_pop  = get_post_meta( get_the_ID(),'_itsoft_m_g_image_pop', true ); 
						if($m_g_image_pop =="m_gshow"){?>
						<div class="prot_thumb">
							<div class="owl-carousel portfolio_gallery_post  curosel-style">	
									<?php
										itsoft_slider_o('_itsoft_pgellaryu',array(1000,570));									
									?>										
							</div>	


								<div class="prot_content multi_gallery">
									<div class="prot_content_inner">
									<?php if($saloption=='m_alshow'): ?>										
											<div class="picon">								
																									
											<a class="portfolio-icon venobox" data-gall="myGallery" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );?>"><i class="fa fa-photo"></i></a>

											<a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>	
																		
											<a class="video-vemo-icon venobox" data-vbtype="youtube" data-autoplay="true" data-gall="gall-video" href="<?php echo esc_url($pyoutube ); ?>">
											<i class="fa fa-youtube-play"></i></a>			
																	
											<a class="video-vemo-icon venobox" data-vbtype="vimeo" data-autoplay="true" data-gall="gall-video" href="<?php echo esc_url($pvimeo ); ?>"><i class="fa fa-vimeo"></i>
											</a>									

											</div>

									<?php else: //or ?>

									<div class="picon">
																		
																
										<?php if($siimagepop=='m_ishow'): ?>									
										<a class="portfolio-icon venobox" data-gall="myportfolio" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );?>"><i class="fa fa-photo"></i></a>
										<?php endif; ?>

										<?php if($sllink=='m_lshow'): ?>	
										<a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>	
										<?php endif; ?>

										<?php if($shyoutub=='m_yshow'): ?>	

										<?php if($pyoutube): ?>								
										<a class="video-vemo-icon venobox" data-vbtype="youtube" data-autoplay="true" data-gall="gall-video" href="<?php echo esc_url($pyoutube ); ?>">
										<i class="fa fa-youtube-play"></i></a>		
										<?php endif; ?>

										<?php endif; ?>

										<?php if($svvimeo=='m_vshow'): ?>

										<?php if($pvimeo): ?>									
										<a class="video-vemo-icon venobox" data-vbtype="vimeo" data-autoplay="true" data-gall="gall-video" href="<?php echo esc_url($pvimeo ); ?>"><i class="fa fa-vimeo"></i>
										</a>									
										<?php endif; ?>

										<?php endif; ?>

									</div>
																				
									<?php endif; ?>											
																																								
									</div>
									
									<?php if($pshow_title=='ptitle_show'){ ?>
									<div class="porttitle_inner">
										
										<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
										<?php } ?>
										
										<?php if($pshow_cat=='pcat_show'){ ?>
										<p>
											<?php if( $terms ){
												
											foreach( $terms as $single_slugs ){?>
												<span class="category-item-p">
												   <?php echo $single_slugs->name ;?>
												</span>																			
											<?php }}?>
										</p>
																					
									
									</div>												
									<?php } ?>
								</div>

						</div>			

						<?php }else{ ?>
							
							<div class="prot_thumb">
								
									<?php the_post_thumbnail();?>
									<div class="prot_icon">
									
									<?php if($saloption=='m_alshow'): ?>										
										<div class="picon">
										<a class="portfolio-icon venobox" data-gall="myGallery" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );?>"><i class="fa fa-photo"></i></a>
											<a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>	
																		
											<a class="video-vemo-icon venobox" data-vbtype="youtube" data-autoplay="true" data-gall="gall-video" href="<?php echo esc_url($pyoutube ); ?>">
											<i class="fa fa-youtube-play"></i></a>			
																	
											<a class="video-vemo-icon venobox" data-vbtype="vimeo" data-autoplay="true" data-gall="gall-video" href="<?php echo esc_url($pvimeo ); ?>"><i class="fa fa-vimeo"></i>
											</a>									
										</div>
									<?php else: //or ?>
									<div class="picon">				
										<?php if($siimagepop=='m_ishow'): ?>									
										<a class="portfolio-icon venobox" data-gall="myportfolio" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );?>"><i class="fa fa-photo"></i></a>
										<?php endif; ?>

										<?php if($sllink=='m_lshow'): ?>	
										<a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>	
										<?php endif; ?>

										<?php if($shyoutub=='m_yshow'): ?>	

										<?php if($pyoutube): ?>								
										<a class="video-vemo-icon venobox" data-vbtype="youtube" data-autoplay="true" data-gall="gall-video" href="<?php echo esc_url($pyoutube ); ?>">
										<i class="fa fa-youtube-play"></i></a>		
										<?php endif; ?>

										<?php endif; ?>

										<?php if($svvimeo=='m_vshow'): ?>

										<?php if($pvimeo): ?>									
										<a class="video-vemo-icon venobox" data-vbtype="vimeo" data-autoplay="true" data-gall="gall-video" href="<?php echo esc_url($pvimeo ); ?>"><i class="fa fa-vimeo"></i>
										</a>									
										<?php endif; ?>

										<?php endif; ?>
									</div>										
									<?php endif; ?>											
									</div>
								<div class="prot_content em_port_content ">
									<div class="prot_content_inner">							
									<?php if($pshow_title=='ptitle_show'){ ?>
									<div class="porttitle_inner">
										<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
										<?php if($pshow_cat=='pcat_show'){ ?>
										<p>
											<?php if( $terms ){
											foreach( $terms as $single_slugs ){?>
												<span class="category-item-p">
												   <?php echo $single_slugs->name ;?>
												</span>		
											<?php }}?>
										</p>
									</div>
									<?php } ?>
									<?php } ?>
									</div>
								</div>		
							</div>				
	
						<?php } ?>					
																	
							</div>
						</div>
					<?php endwhile; ?>	
					<?php wp_reset_query(); ?>
				</div>
			</div>

		<?php

	}
}