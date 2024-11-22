<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if(!defined('ABSPATH')) exit;


class NivoSlider extends Widget_Base{

	public function get_name(){
		return "nivoslider";
	}
	
	public function get_title(){
		return "Nivo Slider";
	}
	
	public function get_icon(){
		return "eicon-media-carousel";
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
			'subtitle_section',
			[
				'label' => __( 'Subtitle', 'dreamit-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'subtitle_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .em-slider-sub-title' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'subtitle_typography',
					'selector' => '{{WRAPPER}} .em-slider-sub-title',
				]
			);
			$this->add_responsive_control(
				'subtitle_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .em-slider-sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'title_section',
			[
				'label' => __( 'Title', 'dreamit-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'title_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .em-slider-title' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .em-slider-title',
				]
			);
			$this->add_responsive_control(
				'title_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .em-slider-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'description_section',
			[
				'label' => __( 'Description', 'dreamit-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'description_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .em-slider-descript' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'selector' => '{{WRAPPER}} .em-slider-descript',
				]
			);
			$this->add_responsive_control(
				'description_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .em-slider-descript' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'style_tabs'
		);
			$this->start_controls_tab(
				'style_normal_tab',
				[
					'label' => __( 'Normal', 'dreamit-elementor-extension' ),
				]
			);
			
			$this->add_control(
				'background_color',
				[
					'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .em-button-button-area a' => 'background: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'text_color',
				[
					'label' => __( 'Text Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .em-button-button-area a' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'style_hover_tab',
				[
					'label' => __( 'Hover', 'dreamit-elementor-extension' ),
				]
			);

			$this->add_control(
				'hover_background_color',
				[
					'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .em-button-button-area:hover a' => 'background: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'hover_text_color',
				[
					'label' => __( 'Text Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .em-button-button-area:hover a' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			
		$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .em-button-button-area a',
				]
			);
			$this->add_responsive_control(
				'button_padding',
				[
					'label' => __( 'Padding', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .em-button-button-area a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'button_border',
					'label' => __( 'Border', 'dreamit-elementor-extension' ),
					'selector' => '{{WRAPPER}} .em-button-button-area a',
				]
			);
		$this->end_controls_section();
    }

    protected function render() {

	$args = array(
		'post_type' => 'em_slider',
	);
	$post_query = new \WP_Query($args);

    	?>
    <div class="main-slider-area">
        <div class="container-fluid">
            <div class="row">
                <div class="em-nivo-slider-wrapper <?php echo esc_attr($extra_class);?>">
                    <div id="mainSlider" class="nivoSlider em-slider-image">
					
					<?php while ( $post_query->have_posts() ) {
								$post_query->the_post(); 
								?>
								
								<?php $em_slider_caption = '#htmlcaption1_'.get_the_ID(); ?>								
									  <?php if(has_post_thumbnail() ) { ?>
									  
										  <?php the_post_thumbnail('em-thumb',array('title' => ''.$em_slider_caption.'')); ?>
										  
									  <?php } ?>	
					<?php } ?>

				   </div>
				   
					<?php while ( $post_query->have_posts() ) {
								$post_query->the_post();


								$em_slide_title  = get_post_meta( get_the_ID(),'_itsoft_em_slide_title', true );
								$em_slide_subtitle  = get_post_meta( get_the_ID(),'_itsoft_em_slide_subtitle', true );
								$em_slide_textarea  = get_post_meta( get_the_ID(),'_itsoft_em_slide_textarea', true );
								$em_slide_btn1  = get_post_meta( get_the_ID(),'_itsoft_em_slide_btn1', true );
								$em_slide_btn1utl  = get_post_meta( get_the_ID(),'_itsoft_em_slide_btn1utl', true );
								$em_slide_btn2  = get_post_meta( get_the_ID(),'_itsoft_em_slide_btn2', true );
								$em_slide_btn2url  = get_post_meta( get_the_ID(),'_itsoft_em_slide_btn2url', true );							
								$em_slider_posi  = get_post_meta( get_the_ID(),'_itsoft_em_slider_posi', true );
								
								
								$em_aimate_title  = get_post_meta( get_the_ID(),'_itsoft_em_aimate_title', true );
								$em_durations_title  = get_post_meta( get_the_ID(),'_itsoft_em_durations_title', true );
								$em_dealy_title  = get_post_meta( get_the_ID(),'_itsoft_em_dealy_title', true );
								
								
								$em_aimate_image  = get_post_meta( get_the_ID(),'_itsoft_em_aimate_image', true );
								$em_durations_image  = get_post_meta( get_the_ID(),'_itsoft_em_durations_image', true );
								$em_dealy_image  = get_post_meta( get_the_ID(),'_itsoft_em_dealy_image', true );
								
								
								$em_aimate_subtitle  = get_post_meta( get_the_ID(),'_itsoft_em_aimate_subtitle', true );
								$em_durations_subtitle  = get_post_meta( get_the_ID(),'_itsoft_em_durations_subtitle', true );
								$em_dealy_subtitle  = get_post_meta( get_the_ID(),'_itsoft_em_dealy_subtitle', true );

								$em_aimate_content  = get_post_meta( get_the_ID(),'_itsoft_em_aimate_content', true );
								$em_durations_content  = get_post_meta( get_the_ID(),'_itsoft_em_durations_content', true );
								$em_dealy_content  = get_post_meta( get_the_ID(),'_itsoft_em_dealy_content', true );

								$em_aimate_btn  = get_post_meta( get_the_ID(),'_itsoft_em_aimate_btn', true );
								$em_durations_btn  = get_post_meta( get_the_ID(),'_itsoft_em_durations_btn', true );
								$em_dealy_btn  = get_post_meta( get_the_ID(),'_itsoft_em_dealy_btn', true );
								$em_slide_image  = get_post_meta( get_the_ID(),'_itsoft_em_slide_img', true );
								$em_slide_video_icon  = get_post_meta( get_the_ID(),'_itsoft_youtube_video', true );

								



								?>				   
						<!-- em_slider style-1 start -->
						<div id="htmlcaption1_<?php the_ID(); ?>" class="nivo-html-caption em-slider-content-nivo">
							<div class="em_slider_inner container  <?php if($em_slider_posi){echo $em_slider_posi;}?>">
															
								<?php if($em_slide_title){?> 
								
									<div class="wow <?php if($em_aimate_title){ echo $em_aimate_title;} ?>" data-wow-duration="<?php if($em_durations_title){ echo $em_durations_title;} ?>s" data-wow-delay="<?php if($em_dealy_title){ echo $em_dealy_title;} ?>s">
									
										<h2 class="em-slider-title"><?php echo $em_slide_title;?></h2>
									
									</div>
									
								<?php } ?>								
						

								<?php if($em_slide_subtitle){?> 
								<div class="wow <?php if($em_aimate_subtitle){ echo $em_aimate_subtitle;} ?>" data-wow-duration="<?php if($em_durations_subtitle){ echo $em_durations_subtitle;} ?>s" data-wow-delay="<?php if($em_dealy_subtitle){ echo $em_dealy_subtitle;} ?>s">
								
										<h1 class="em-slider-sub-title"><?php echo $em_slide_subtitle;?> 
										</h1>
										
									</div>			
										
								<?php } ?>								

						
								<?php if($em_slide_textarea){?> 
									
									<div class="wow <?php if($em_aimate_content){ echo $em_aimate_content;} ?>" data-wow-duration="<?php if($em_durations_content){ echo $em_durations_content;} ?>s" data-wow-delay="<?php if($em_dealy_content){ echo $em_dealy_content;} ?>s">
									
										<p  class="em-slider-descript"><?php echo esc_html($em_slide_textarea);?></p>
									
									</div>
								
								<?php } ?>								
														
								<div class="em-slider-button wow  <?php if($em_aimate_btn){ echo $em_aimate_btn;} ?>  em-button-button-area" data-wow-duration="<?php if($em_durations_btn){ echo $em_durations_btn;} ?>s" data-wow-delay="<?php if($em_dealy_btn){ echo $em_dealy_btn;} ?>s">
								
									<?php if($em_slide_btn1utl){?> 
										<a class="em-active-button" href="<?php echo esc_url( $em_slide_btn1utl );?>"><?php echo esc_html( $em_slide_btn1 );?></a>
									<?php }?>
									
									<?php if($em_slide_btn2url){?> 
										<a class="withput-active" href="<?php echo esc_url( $em_slide_btn2url );?>"><?php echo esc_html( $em_slide_btn2 );?></a>
									<?php }?>
									
									
									
																	

								</div>
								<div class="single_slide_img">
									<?php if($em_slide_image){?> 
								
										<div class="wow <?php if($em_aimate_image){ echo $em_aimate_image;} ?>" data-wow-duration="<?php if($em_durations_image){ echo $em_durations_title;} ?>s" data-wow-delay="<?php if($em_dealy_image){ echo $em_dealy_image;} ?>s">
										
											<img src="<?php echo $em_slide_image ?>" alt="" />
											
										</div>

									<?php } ?>	
								</div>
							</div>
						</div>
						<!-- em_slider style-1 end -->
					<?php } ?>

			   </div>
            </div>
        </div>
    </div>
    	<?php
    }
}