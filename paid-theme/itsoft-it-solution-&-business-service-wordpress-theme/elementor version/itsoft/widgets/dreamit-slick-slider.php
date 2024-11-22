<?php


namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if(!defined('ABSPATH')) exit;


class SlickSlider extends Widget_Base{

	public function get_name(){
		return "slider";
	}
	
	public function get_title(){
		return "Slick Slider";
	}
	
	public function get_icon(){
		return "eicon-slider-push";
	}

	public function get_categories(){
		return ['my-category'];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'slider', [
				'label' => __( 'Slider', 'techno' ),
			]
		);
		$this->add_control(
			'slides', [
				'label' => __( 'Slide items', 'techno' ),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ subtitle }}}',
				'fields' => [
                    [
                        'name' => 'slider_style',
                        'label' => __( 'Slider style', 'techno' ),
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                            'style_01' => esc_html__('Style one', 'techno'),
                            'style_02' => esc_html__('Style two', 'techno'),
                            'style_03' => esc_html__('Style three', 'techno'),
                            'style_04' => esc_html__('Style Four', 'techno'),
                        ],
                        'default' => 'style_01'
                    ],

                    [
                        'name' => 'content_position',
                        'label' => __( 'Select Text Position', 'techno' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            'text-left' => __( 'Text Left', 'techno' ),
                            'text-center' => __( 'Text Center', 'techno' ),
                            'text-right' => __( 'Text Right', 'techno' ),
                        ],
                        'default' => 'text-left',
                        
                    ],

					[
						'name' => 'subtitle',
						'label' => __( 'Subtitle', 'techno' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => 'Welcome to techno'
					],

					[
						'name' => 'title',
						'label' => __( 'Title', 'techno' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => 'We are a creative <br>Design Agency',
					],

                    [
                        'name' => 'description',
                        'label' => __( 'Description', 'techno' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => 'Pellentesque at posuere tellus phasellus scelerisque porem.',
                    ],

					[
						'name' => 'btn1',
						'label' => __( 'Button 1', 'techno' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => __( 'Enter Button Name', 'techno' ),
						'default' => 'Get Started'
					],
					[
						'name' => 'btn1_url',
						'label' => __( 'Button URL', 'techno' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
                        'default' => [
                            'url' => '#'
                        ]
					],

					[
						'name' => 'btn2',
						'label' => __( 'Button 2', 'techno' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => __( 'Enter Button Name', 'techno' ),
						'default' => ''
					],
					[
						'name' => 'btn2_url',
						'label' => __( 'Button URL', 'techno' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
                        'default' => [
                            'url' => '#'
                        ]
					],

					[
						'name' => 'video_url',
						'label' => __( 'Video URL', 'techno' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
                        'default' => [
                            'url' => '#'
                        ]
					],

					[
						'name' => 'video_icon',
						'label' => __( 'Video Icon', 'text-domain' ),
						'type' => \Elementor\Controls_Manager::ICONS,
						'default' => [
							'value' => 'fas fa-play',
						],
					],

					[
						'name' => 'single_image',
						'label' => __( 'Choose Single Image', 'techno' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
					],


					[
						'name' => 'bg_image',
						'label' => __( 'Background image', 'techno' ),
						'type' => Controls_Manager::MEDIA,
					],
				],
			]
		);
		$this->end_controls_section();


/**
 * Style Tab
 */


        //------------------------------ Style Title ------------------------------
        $this->start_controls_section(
            'style_title', [
                'label' => __( 'Title', 'techno' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_title', [
                'label' => __( 'Text Color', 'techno' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hero-text h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .slider_two .hero-text h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .slider_five .new_hero_text .f_65' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-text h1, {{WRAPPER}} .slider_two .hero-text h1',
            ]
        );
        $this->end_controls_section();


        //------------------------------ Style subtitle ------------------------------
        $this->start_controls_section(
            'style_subtitle', [
                'label' => __( 'Subtitle', 'techno' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_subtitle', [
                'label' => __( 'Text Color', 'techno' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hero-text h4' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .slider_two .hero-text h3' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_subtitle',
                'selector' => '{{WRAPPER}} .hero-text h4, {{WRAPPER}} .slider_two .hero-text h3',
            ]
        );
        $this->end_controls_section();

        //------------------------------ Style Description ------------------------------
        $this->start_controls_section(
            'style_description', [
                'label' => __( 'Description', 'techno' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_description', [
                'label' => __( 'Text Color', 'techno' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hero-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_description',
                'selector' => '{{WRAPPER}} .hero-text p, {{WRAPPER}} .slider_two .hero-text h3',
            ]
        );
        $this->end_controls_section();


        //------------------------------ Style Button ------------------------------
        $this->start_controls_section(
            'style_button', [
                'label' => __( 'Button', 'techno' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'slider_style' => ['style_02', 'style_03']
                ]
            ]
        );
        $this->add_control(
            'btn_color', [
                'label' => esc_html__( 'Button accent color', 'techno' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .new_btn' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}} .new_btn:hover' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .slider_two .hero_call_btn .btn-md' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ],
                'default' => '#fc5c7d',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_btn',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .new_btn, {{WRAPPER}} .slider_two .hero_call_btn .btn-md',
            ]
        );
        $this->end_controls_section();

	}


    protected function render() {

        $settings = $this->get_settings();


        $slides = isset($settings['slides']) ? $settings['slides'] : '';
        wp_enqueue_script('slick');
        wp_enqueue_style('slick');

    ?>

        
            <section class="dreamit-slick-slider">
                <div class="default-slider slick">
                    
                    <?php if(is_array($slides)) {
                        foreach ($slides as $slide) {
                            $this->add_render_attribute( 'i', 'class', $slide['video_icon'] ); 
                    ?>

                        <?php if($slide['slider_style']=='style_01'){ ?>

						<div class="single-slick style-one align-items-center d-flex <?php echo $slide['content_position'] ?>">
                            <div class="container">
                                <div class="slide-img parallax-effect"
                                    <?php if(!empty($slide['bg_image']['url'])) : ?> style="background:url(<?php echo esc_url($slide['bg_image']['url']) ?>) center center / cover scroll no-repeat;" <?php endif; ?>>
                                </div>
                                <div class="hero-text-wrap">
                                    <div class="hero-text">
                                        <div class="container">
                                            <div class="white-color">
                                                <?php if(!empty($slide['subtitle'])) : ?> <h4> <?php echo esc_html_e($slide['subtitle']) ?> </h4> <?php endif; ?>
                                                <?php if(!empty($slide['title'])) : ?> <h1 class="font-600"> <?php echo $slide['title']; ?> </h1> <?php endif; ?>

                                                	<p><?php echo $slide['description']; ?></p>

                                                	<?php if( !empty($slide['btn1']) ){ ?>
                                                    <a class="btn btn-gradient btn-md btn-animated-none btn-one" href="<?php echo esc_url($slide['btn1_url']['url']); ?>" target="_blank">
                                                            <?php echo $slide['btn1']; ?>
                                                        <i class="flaticon-right-arrow-3"></i>
                                                    </a>
                                                    <?php } ?>

                                                    <?php if( !empty($slide['btn2']) ){ ?>
                                                    <a class="btn btn-gradient btn-md btn-animated-none btn-two" href="<?php echo esc_url($slide['btn2_url']['url']); ?>" target="_blank">
                                                            <?php echo $slide['btn2']; ?>
                                                        <i class="flaticon-right-arrow-3"></i>
                                                    </a>
                                                    <?php } ?>

                                                    <?php if( !empty($slide['video_url']['url']) ){ ?>
                                                    <div class="slider-video-icon">
                                                    	<a href="<?php echo esc_url($slide['video_url']['url']); ?>" class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true">
                                                    		<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
                                                    	</a>
                                                    </div>
                                                    <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider-single-image">
                                	<img src="<?php echo $slide['single_image']['url']; ?>" alt="">
                                </div>
							</div><!-- .container -->

                            <div class="slider-shape1 rotateme"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/circle-img.png'; ?>" alt="01"></div>
                            <div class="slider-shape2 rotateme"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/ractangle-img.png'; ?>" alt="01"></div>
                            <div class="slider-shape3"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/ractangle-img2.png'; ?>" alt="01"></div>

						</div><!-- .single-slick -->

                        <?php }elseif($slide['slider_style']=='style_02'){ ?>

                        <div class="single-slick style-two align-items-center d-flex <?php echo $slide['content_position'] ?>">
                            <div class="container">
                                <div class="slide-img parallax-effect"
                                    <?php if(!empty($slide['bg_image']['url'])) : ?> style="background:url(<?php echo esc_url($slide['bg_image']['url']) ?>) center center / cover scroll no-repeat;" <?php endif; ?>>
                                </div>
                                <div class="hero-text-wrap">
                                    <div class="hero-text">
                                        <div class="container">
										<?php if( !empty($slide['video_url']['url']) ){ ?>
											<div class="slider-video-icon">
													<a href="<?php echo esc_url($slide['video_url']['url']); ?>" class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true">
														<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
													</a>
												</div>
											<?php } ?>
                                            <div class="white-color">
                                                <?php if(!empty($slide['subtitle'])) : ?> <h4> <?php echo esc_html_e($slide['subtitle']) ?> </h4> <?php endif; ?>
                                                <?php if(!empty($slide['title'])) : ?> <h1 class="font-600"> <?php echo $slide['title']; ?> </h1> <?php endif; ?>

                                                    <p><?php echo $slide['description']; ?></p>

                                                    <?php if( !empty($slide['btn1']) ){ ?>
                                                    <a class="btn btn-gradient btn-md btn-animated-none btn-one" href="<?php echo esc_url($slide['btn1_url']['url']); ?>" target="_blank">
                                                            <?php echo $slide['btn1']; ?>
                                                        <i class="flaticon-right-arrow-3"></i>
                                                    </a>
                                                    <?php } ?>

                                                    <?php if( !empty($slide['btn2']) ){ ?>
                                                    <a class="btn btn-gradient btn-md btn-animated-none btn-two" href="<?php echo esc_url($slide['btn2_url']['url']); ?>" target="_blank">
                                                            <?php echo $slide['btn2']; ?>
                                                        <i class="flaticon-right-arrow-3"></i>
                                                    </a>
                                                    <?php } ?>
													

                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div><!-- .container -->

                        </div><!-- .single-slick -->

                        <?php }elseif($slide['slider_style']=='style_03'){ ?>
						<div class="single-slick style-three align-items-center d-flex <?php echo $slide['content_position'] ?>">
                            <div class="container">
                                <div class="slide-img parallax-effect"
                                    <?php if(!empty($slide['bg_image']['url'])) : ?> style="background:url(<?php echo esc_url($slide['bg_image']['url']) ?>) center center / cover scroll no-repeat;" <?php endif; ?>>
                                </div>
                                <div class="hero-text-wrap">
                                    <div class="hero-text">
                                        <div class="container">
                                            <div class="white-color">
                                                <?php if(!empty($slide['subtitle'])) : ?> <h4> <?php echo esc_html_e($slide['subtitle']) ?> </h4> <?php endif; ?>
                                                <?php if(!empty($slide['title'])) : ?> <h1 class="font-600"> <?php echo $slide['title']; ?> </h1> <?php endif; ?>

                                                	<p><?php echo $slide['description']; ?></p>

                                                	<?php if( !empty($slide['btn1']) ){ ?>
                                                    <a class="btn btn-gradient btn-md btn-animated-none btn-one" href="<?php echo esc_url($slide['btn1_url']['url']); ?>" target="_blank">
                                                            <?php echo $slide['btn1']; ?>
                                                        <i class="flaticon-right-arrow-3"></i>
                                                    </a>
                                                    <?php } ?>

                                                    <?php if( !empty($slide['btn2']) ){ ?>
                                                    <a class="btn btn-gradient btn-md btn-animated-none btn-two" href="<?php echo esc_url($slide['btn2_url']['url']); ?>" target="_blank">
                                                            <?php echo $slide['btn2']; ?>
                                                        <i class="flaticon-right-arrow-3"></i>
                                                    </a>
                                                    <?php } ?>

                                                    <?php if( !empty($slide['video_url']['url']) ){ ?>
                                                    <div class="slider-video-icon">
                                                    	<a href="<?php echo esc_url($slide['video_url']['url']); ?>" class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true">
                                                    		<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
                                                    	</a>
                                                    </div>
                                                    <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider-single-image">
                                	<img src="<?php echo $slide['single_image']['url']; ?>" alt="">
                                </div>
							</div><!-- .container -->

						</div><!-- .single-slick -->
                        <?php }
						elseif($slide['slider_style']=='style_04'){ ?>
						<div class="single-slick slider-style-four align-items-center d-flex <?php echo $slide['content_position'] ?>">
                            <div class="container">
                                <div class="slide-img parallax-effect"
                                    <?php if(!empty($slide['bg_image']['url'])) : ?> style="background:url(<?php echo esc_url($slide['bg_image']['url']) ?>) center center / cover scroll no-repeat;" <?php endif; ?>>
                                </div>
                                <div class="hero-text-wrap">
                                    <div class="hero-text">
                                        <div class="container">
                                            <div class="white-color">
                                                <?php if(!empty($slide['subtitle'])) : ?> <h4> <?php echo esc_html_e($slide['subtitle']) ?> </h4> <?php endif; ?>
                                                <?php if(!empty($slide['title'])) : ?> <h1 class="font-600"> <?php echo $slide['title']; ?> </h1> <?php endif; ?>

                                                	<p><?php echo $slide['description']; ?></p>

                                                	<?php if( !empty($slide['btn1']) ){ ?>
                                                    <a class="btn btn-gradient btn-md btn-animated-none btn-one" href="<?php echo esc_url($slide['btn1_url']['url']); ?>" target="_blank">
                                                            <?php echo $slide['btn1']; ?>
                                                        <i class="flaticon-right-arrow-3"></i>
                                                    </a>
                                                    <?php } ?>

                                                    <?php if( !empty($slide['btn2']) ){ ?>
                                                    <a class="btn btn-gradient btn-md btn-animated-none btn-two" href="<?php echo esc_url($slide['btn2_url']['url']); ?>" target="_blank">
                                                            <?php echo $slide['btn2']; ?>
                                                        <i class="flaticon-right-arrow-3"></i>
                                                    </a>
                                                    <?php } ?>

                                                    <?php if( !empty($slide['video_url']['url']) ){ ?>
                                                    <div class="slider-video-icon">
                                                    	<a href="<?php echo esc_url($slide['video_url']['url']); ?>" class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true">
                                                    		<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
                                                    	</a>
                                                    </div>
                                                    <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div><!-- .container -->
							<div class="shape20"><img class="" src="https://themes.envytheme.com/stike/wp-content/themes/stike/assets/img/shape/19.png" alt="Solve Business Challenges With IT"></div>
							<div class="shape21"><img class="" src="https://themes.envytheme.com/stike/wp-content/themes/stike/assets/img/shape/20.png" alt="Solve Business Challenges With IT"></div>
							<div class="shape19"><img class="" src="https://themes.envytheme.com/stike/wp-content/themes/stike/assets/img/shape/18.png" alt="Solve Business Challenges With IT"></div>
							<div class="shape22"><img class="" src="https://themes.envytheme.com/stike/wp-content/themes/stike/assets/img/shape/21.png" alt="Solve Business Challenges With IT"></div>
							<div class="shape23 rotateme"><img class="" src="https://themes.envytheme.com/stike/wp-content/themes/stike/assets/img/shape/22.svg" alt="Solve Business Challenges With IT"></div>
							<div class="shape24"><img class="" src="https://themes.envytheme.com/stike/wp-content/themes/stike/assets/img/shape/23.png" alt="Solve Business Challenges With IT"></div>	
						</div><!-- .single-slick -->
                        <?php } ?>

                    <?php }} ?>
                </div>
            </section>
            <script>
                jQuery(document).ready(function() {
                    jQuery(".default-slider").slick({
                        <?php
                        if(is_rtl()) { ?>
                            dots: false,
                            infinite: true,
                            autoplay: false,
                            autoplaySpeed: 7000,
                            centerPadding: '0',
                            arrows: false,
                        <?php }else { ?>
                            dots: false,
                            infinite: true,
                            centerMode: true,
                            autoplay: true,
                            autoplaySpeed: 7000,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '0',
                            arrows: false
                        <?php } ?>
                    });
                });
            </script>

        


        


	<?php }

}