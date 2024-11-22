<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) exit;


class ServiceCarousel extends Widget_Base{

	public function get_name(){
		return "servicecarousel";
	}
	
	public function get_title(){
		return "Service Carousel";
	}
	
	public function get_icon(){
		return "eicon-info-box";
	}
	public function get_categories(){
		return ['my_category'];
	}
	
	protected function _register_controls(){

		$this->start_controls_section(
			'slider', [
				'label' => __( 'Slider', 'itsoft' ),
			]
		);
		$this->add_control(
			'slides', [
				'label' => __( 'Slide items', 'itsoft' ),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{title_text}}}',
				'fields' => [
					[
						'name' => 'select_img',
					    'label' => esc_html__('Image','tuchmocore'),
					    'type'=>Controls_Manager::MEDIA,
					    'default' => [
						  'url' => \Elementor\Utils::get_placeholder_image_src(),
					    ],
					],
					[
						'name' => 'icon',
						'label' => __( 'Icon', 'itsoft' ),
						'type' => Controls_Manager::ICON,
					],
					[
						'name' => 'title_text',
						'label' => __( 'Title', 'itsoft' ),
						'type' => Controls_Manager::TEXT,
						'dynamic' => [
							'active' => true,
						],
						'placeholder' => __( 'Enter your title', 'itsoft' ),
						'label_block' => true,
						'default' => __( 'This is the title', 'itsoft' ),
					],
					[
						'name' => 'description_text',
						'label' => __( 'Description', 'itsoft' ),
						'type' => Controls_Manager::TEXTAREA,
						'dynamic' => [
							'active' => true,
						],
						'placeholder' => __( 'Enter your paragraph', 'itsoft' ),
						'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'itsoft' ),
					],
					[
						'name' => 'link',
						'label' => __( 'Link', 'itsoft' ),
						'type' => Controls_Manager::URL,
						'dynamic' => [
							'active' => true,
						],
						'placeholder' => __( 'https://your-link.com', 'itsoft' ),
						'separator' => 'before',
					],
					
					[
						'name' => 'button_text',
						'label' => __( 'Button Text', 'itsoft' ),
						'type' => Controls_Manager::TEXT,
						'dynamic' => [
							'active' => true,
						],
						'placeholder' => __( 'Enter your button text', 'itsoft' ),
						'label_block' => true,
						'default' => __( 'Button', 'itsoft' ),
					],
					[
						'name' => 'show_button',
						'label' => __( 'Show Button', 'itsoft' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => __( 'Show', 'itsoft' ),
						'label_off' => __( 'Hide', 'itsoft' ),
						'return_value' => 'yes',
						'default' => 'yes',
					],
					[
						'name' => 'button_icon',
						'label' => __( 'Button Icon', 'itsoft' ),
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => 'fa fa-angle-right',
						],
					],

				],
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
						'three' => __( 'Three', 'itsoft' ),
						'four' => __( 'Four', 'itsoft' ),
					],
					'default' => 'one',
					
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'icon_section_style',
			[
				'label' => __( 'Icon', 'itsoft' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs(
			'style_tabs'
		);
		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => __( 'Normal', 'itsoft' ),
			]
		);
			$this->add_control(
				'primary_color',
				[
					'label' => __( 'Primary Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-icon i' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'background_color',
				[
					'label' => __( 'Background Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-icon i' => 'background-color: {{VALUE}};',
					],
				]
			);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => __( 'Hover', 'itsoft' ),
			]
		);
			$this->add_control(
				'hover_primary_color',
				[
					'label' => __( 'Primary Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box:hover .service-box-icon i' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'hover_background_color',
				[
					'label' => __( 'Background Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box:hover .service-box-icon i' => 'background-color: {{VALUE}};',
					],
				]
			);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_style',
			[
				'label' => __( 'Content', 'itsoft' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'text_align',
				[
					'label' => __( 'Alignment', 'itsoft' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'itsoft' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'itsoft' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'itsoft' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'itsoft' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .service-box' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'heading_title',
				[
					'label' => __( 'Title', 'itsoft' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'title_bottom_space',
				[
					'label' => __( 'Spacing', 'itsoft' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'title_color',
				[
					'label' => __( 'Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-title h2' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .service-box .service-box-title h2, {{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a',
				]
			);
			$this->add_control(
				'heading_description',
				[
					'label' => __( 'Description', 'itsoft' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'description_color',
				[
					'label' => __( 'Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box-desc p' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'selector' => '{{WRAPPER}} .service-box-desc p',
				]
			);
		$this->end_controls_section();
		
	}

	protected function render() {

		$settings = $this->get_settings_for_display();



		$slides = isset($settings['slides']) ? $settings['slides'] : '';







		$this->add_render_attribute( 'title_text', 'class', 'service-box-title' );
		$this->add_render_attribute( 'description_text', 'class', 'service-box-desc' );

		
		?>

		<?php if($settings['select_style']=='one'){ ?>

			<section class="service_cursousel_sliderr">

			<?php foreach ($slides as $slide) { 
				$this->add_render_attribute( 'i', 'class', $slide['icon'] );
				$this->add_render_attribute( 'j', 'class', $slide['button_icon'] );
			?>
			<div class="service-box">	
				<div class="service-box-content ">
					<div class="single-service-text">
						<div class="service-top-text">
							
								<div class="service-box-icon">
									<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
								</div>
							
						</div>
						<div class="service-box-inner">

							<div <?php echo $this->get_render_attribute_string( 'title_text' ); ?> >
								<h3><?php echo $slide['title_text']; ?></h3>
							</div>

							<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
								<p><?php echo $slide['description_text']; ?></p>
							</div>

							<?php if( 'yes'===$slide['show_button'] ){ ?>
								<div class="service-btn">
									<a href="<?php echo esc_url($slide['link']['url']); ?>">
										<?php echo $slide['button_text']; } ?>
										<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
									</a>
								</div>			
						</div>
					</div>
				</div>
			</div>
			<?php } ?>

			</section>

            <script>
                jQuery(document).ready(function() {
                    jQuery(".service_cursousel_sliderr").slick({
                        <?php
                        if(is_rtl()) { ?>
                            dots: true,
                            infinite: true,
                            autoplay: false,
                            autoplaySpeed: 7000,
                            centerPadding: '0',
                            arrows: false,
					        responsive: [
					            {
					                breakpoint: 1920,
					                settings: {
					                    slidesToShow: 3,
					                }
					            },
								 {
					                breakpoint: 1400,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
								
								
					            {
					                breakpoint: 991,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
					            {
					              breakpoint: 768,
					              settings: {
					                slidesToShow: 1
					              }
					            },
					            {
					              breakpoint: 600,
					              settings: {
					                arrows: false,
					                slidesToShow: 1
					              }
					            }
					        ]

                        <?php }else { ?>
                            dots: true,
                            infinite: true,
                            centerMode: true,
                            autoplay: true,
                            autoplaySpeed: 7000,
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            centerPadding: '0',
                            arrows: false,
					        responsive: [
					            {
					                breakpoint: 1920,
					                settings: {
					                    slidesToShow: 3,
					                }
					            },
								 {
					                breakpoint: 1400,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
								
								
					            {
					                breakpoint: 991,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
					            {
					              breakpoint: 768,
					              settings: {
					                slidesToShow: 1
					              }
					            },
					            {
					              breakpoint: 600,
					              settings: {
					                arrows: false,
					                slidesToShow: 1
					              }
					            }
					        ]

                        <?php } ?>
                    });
                });
            </script>

		<?php }elseif($settings['select_style']=='two'){ ?>

				<section class="service_cursousel_sliderr">

					<?php foreach ($slides as $slide) { 
						$this->add_render_attribute( 'i', 'class', $slide['icon'] );
						$this->add_render_attribute( 'j', 'class', $slide['button_icon'] );
					?>
					<div class="service-box service-style-two">

							<div class="service-box-icon">
								<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
							</div>

						<div class="service-box-content">

							<div <?php echo $this->get_render_attribute_string( 'title_text' ); ?> >
								<h3><?php echo $slide['title_text']; ?></h3>
							</div>

							<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
								<p><?php echo $slide['description_text']; ?></p>
							</div>

							<?php if( 'yes'===$slide['show_button'] ){ ?>
							<div class="service-btn">
								<a href="<?php echo esc_url($slide['link']['url']); ?>">
									<?php echo $slide['button_text']; } ?>
									<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
								</a>
							</div><!-- .service-btn	-->							
						</div>
					</div><!-- .service-box .service-style-two -->
					<?php } ?>
				</section>

            <script>
                jQuery(document).ready(function() {
                    jQuery(".service_cursousel_sliderr").slick({
                        <?php
                        if(is_rtl()) { ?>
                            dots: true,
                            infinite: true,
                            autoplay: false,
                            autoplaySpeed: 7000,
                            centerPadding: '0',
                            arrows: false,
					        responsive: [
					            {
					                breakpoint: 1920,
					                settings: {
					                    slidesToShow: 3,
					                }
					            },
								 {
					                breakpoint: 1400,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
								
								
					            {
					                breakpoint: 991,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
					            {
					              breakpoint: 768,
					              settings: {
					                slidesToShow: 1
					              }
					            },
					            {
					              breakpoint: 600,
					              settings: {
					                arrows: false,
					                slidesToShow: 1
					              }
					            }
					        ]

                        <?php }else { ?>
                            dots: true,
                            infinite: true,
                            centerMode: true,
                            autoplay: true,
                            autoplaySpeed: 7000,
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            centerPadding: '0',
                            arrows: false,
					        responsive: [
					            {
					                breakpoint: 1920,
					                settings: {
					                    slidesToShow: 3,
					                }
					            },
								 {
					                breakpoint: 1400,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
								
								
					            {
					                breakpoint: 991,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
					            {
					              breakpoint: 768,
					              settings: {
					                slidesToShow: 1
					              }
					            },
					            {
					              breakpoint: 600,
					              settings: {
					                arrows: false,
					                slidesToShow: 1
					              }
					            }
					        ]

                        <?php } ?>
                    });
                });
            </script>


		<?php }elseif($settings['select_style']=='three'){ ?>

				<section class="service_cursousel_sliderr">

					<?php foreach ($slides as $slide) { 
						$this->add_render_attribute( 'i', 'class', $slide['icon'] );
						$this->add_render_attribute( 'j', 'class', $slide['button_icon'] );
					?>
					<div class="service-box service-style-three">		

							<div class="service-box-icon">
								<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
							</div>

						<div class="service-box-content">

							<div <?php echo $this->get_render_attribute_string( 'title_text' ); ?> >
								<h3><?php echo $slide['title_text']; ?></h3>
							</div>

							<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
								<p><?php echo $slide['description_text']; ?></p>
							</div>

							<?php if( 'yes'===$slide['show_button'] ){ ?>
							<div class="service-btn">
								<a href="<?php echo esc_url($slide['link']['url']); ?>">
									<?php echo $slide['button_text']; } ?>
									<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
								</a>
							</div><!-- .service-btn	-->
						</div><!-- .service-box-content -->
					</div><!-- .service-box .service-style-three -->
					<?php } ?>
				</section>
            <script>
                jQuery(document).ready(function() {
                    jQuery(".service_cursousel_sliderr").slick({
                        <?php
                        if(is_rtl()) { ?>
                            dots: true,
                            infinite: true,
                            autoplay: false,
                            autoplaySpeed: 7000,
                            centerPadding: '0',
                            arrows: false,
					        responsive: [
					            {
					                breakpoint: 1920,
					                settings: {
					                    slidesToShow: 3,
					                }
					            },
								 {
					                breakpoint: 1400,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
								
								
					            {
					                breakpoint: 991,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
					            {
					              breakpoint: 768,
					              settings: {
					                slidesToShow: 1
					              }
					            },
					            {
					              breakpoint: 600,
					              settings: {
					                arrows: false,
					                slidesToShow: 1
					              }
					            }
					        ]

                        <?php }else { ?>
                            dots: true,
                            infinite: true,
                            centerMode: true,
                            autoplay: true,
                            autoplaySpeed: 7000,
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            centerPadding: '0',
                            arrows: false,
					        responsive: [
					            {
					                breakpoint: 1920,
					                settings: {
					                    slidesToShow: 3,
					                }
					            },
								 {
					                breakpoint: 1400,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
								
								
					            {
					                breakpoint: 991,
					                settings: {
					                    slidesToShow: 2,
					                }
					            },
					            {
					              breakpoint: 768,
					              settings: {
					                slidesToShow: 1
					              }
					            },
					            {
					              breakpoint: 600,
					              settings: {
					                arrows: false,
					                slidesToShow: 1
					              }
					            }
					        ]

                        <?php } ?>
                    });
                });
            </script>
					
		<?php }elseif($settings['select_style']=='four'){ ?>


			<section class="service_cursousel_sliderr">

			<?php foreach ($slides as $slide) { 
				
				$this->add_render_attribute( 'j', 'class', $slide['button_icon'] );
			?>
				<div class="service-box style_4">		
					<div class="service-box-thumb">

						<img src="<?php echo $slide['select_img']['url'] ?>" alt="">

						
						<div class="service-box-icon">
							<i class="<?php echo esc_attr($slide['icon']); ?>"></i>
						</div>


					</div>

					<div class="em_service_content">
						<div class="em_single_service_text">
							<div class="service_top_text">

								<div class="service-box-title">
									<h2><?php echo $slide['title_text']; ?></h2>
								</div>

							</div>
							<div class="service-box-inner">				
								<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
									<p><?php echo $slide['description_text']; ?></p>
								</div>						
							</div>

							<?php if( 'yes'===$slide['show_button'] ){ ?>
							<div class="service-btn">
								<a href="#">
									<?php echo $slide['button_text']; } ?>
									<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
								</a>
							</div><!-- .service-btn	-->
							

						</div>
					</div>
				</div>
			<?php } ?>
			</section>

	            <script>
	                jQuery(document).ready(function() {
	                    jQuery(".service_cursousel_sliderr").slick({
	                        <?php
	                        if(is_rtl()) { ?>
	                            dots: true,
	                            infinite: true,
	                            autoplay: false,
	                            autoplaySpeed: 7000,
	                            centerPadding: '0',
	                            arrows: false,
						        responsive: [
						            {
						                breakpoint: 1920,
						                settings: {
						                    slidesToShow: 3,
						                }
						            },
									 {
						                breakpoint: 1400,
						                settings: {
						                    slidesToShow: 2,
						                }
						            },
									
									
						            {
						                breakpoint: 991,
						                settings: {
						                    slidesToShow: 2,
						                }
						            },
						            {
						              breakpoint: 768,
						              settings: {
						                slidesToShow: 1
						              }
						            },
						            {
						              breakpoint: 600,
						              settings: {
						                arrows: false,
						                slidesToShow: 1
						              }
						            }
						        ]

	                        <?php }else { ?>
	                            dots: true,
	                            infinite: true,
	                            centerMode: true,
	                            autoplay: false,
	                            autoplaySpeed: 7000,
	                            slidesToShow: 3,
	                            slidesToScroll: 3,
	                            centerPadding: '0',
	                            arrows: false,
						        responsive: [
						            {
						                breakpoint: 1920,
						                settings: {
						                    slidesToShow: 3,
						                }
						            },
									 {
						                breakpoint: 1400,
						                settings: {
						                    slidesToShow: 2,
						                }
						            },
									
									
						            {
						                breakpoint: 991,
						                settings: {
						                    slidesToShow: 2,
						                }
						            },
						            {
						              breakpoint: 768,
						              settings: {
						                slidesToShow: 1
						              }
						            },
						            {
						              breakpoint: 600,
						              settings: {
						                arrows: false,
						                slidesToShow: 1
						              }
						            }
						        ]

	                        <?php } ?>
	                    });
	                });
	            </script>

		<?php } ?>

		<?php
	}
}

