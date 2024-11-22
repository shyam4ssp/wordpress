<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if(!defined('ABSPATH')) exit;


class PricingTable extends Widget_Base{

	public function get_name(){
		return "pricingtable";
	}
	
	public function get_title(){
		return "Pricing Table";
	}
	
	public function get_icon(){
		return "eicon-price-table";
	}

	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			
			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Basic', 'dreamit-elementor-extension' ),
					'placeholder' => __( 'Enter Title', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'currency',
				[
					'label' => __( 'Currency', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( '$', 'dreamit-elementor-extension' ),
					'placeholder' => __( '$', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'price',
				[
					'label' => __( 'Price', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( '99', 'dreamit-elementor-extension' ),
					'placeholder' => __( '99', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'month',
				[
					'label' => __( 'Month', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Month', 'dreamit-elementor-extension' ),
					'placeholder' => __( 'Month', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'image',
				[
					'label' => __( 'Choose Pricing Icon', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::MEDIA,
				    'conditions' => [
				    	'relation' => 'or',
						'terms' => [
							[
					            'terms' => [
					                [
					                    'name' => 'select_style',
					                    'operator' => '==',
					                    'value' => 'two'
					                ],
					            ]
							],
							[
								'terms' => [
					                [
					                    'name' => 'select_style',
					                    'operator' => '==',
					                    'value' => 'three'
					                ],
					            ]
							]
						]
				    ]
				]
			);

			$this->add_control(
				'slides',
				[
					'label' => __( 'Add Features', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::REPEATER,
					'title_field' => '{{{item_field}}}',
					'fields' => [
						[
							'name' => 'item_field',
							'type' => Controls_Manager::TEXT,
							'label_block' => true,
							'default' => 'Buy this package'
						],
					],
				]
			);

			$this->add_control(
				'button_text',
				[
					'label' => __( 'Button Text', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Click Here', 'dreamit-elementor-extension' ),
					'placeholder' => __( 'Click Here', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'button_link',
				[
					'label' => __( 'Link', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'show_active',
				[
					'label' => __( 'Active Table', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'dreamit-elementor-extension' ),
					'label_off' => __( 'No', 'dreamit-elementor-extension' ),
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'change_curve',
				[
					'label' => __( 'Change Curve', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'dreamit-elementor-extension' ),
					'label_off' => __( 'No', 'dreamit-elementor-extension' ),
					'return_value' => 'yes',
				    'conditions' => [
				    	'relation' => 'and',
						'terms' => [
							[
					            'terms' => [
					                [
					                    'name' => 'select_style',
					                    'operator' => '==',
					                    'value' => 'two'
					                ],
					            ]
							],
							[
								'terms' => [
					                [
					                    'name' => 'show_active',
					                    'operator' => '!=',
					                    'value' => 'yes'
					                ],
					            ]
							]
						]
				    ]
				]
			);
		$this->end_controls_section();

/**
 * Style Tab
 */

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'select_style',
				[
					'label' => __( 'Select Style', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'one' => __( 'One', 'dreamit-elementor-extension' ),
						'two' => __( 'Two', 'dreamit-elementor-extension' ),
						'three' => __( 'Three', 'dreamit-elementor-extension' ),
					],
					'default' => 'one',
					
				]
			);

			$this->start_controls_tabs(
				'border_tabs',
				[
					'condition'=>[
						'select_style'=> 'one',
					]
				]
			);
				$this->start_controls_tab(
					'border_normal_tab',
					[
						'label' => __( 'Normal', 'dreamit-elementor-extension' ),
					]
				);
				
					$this->add_control(
						'border_color',
						[
							'label' => __( 'Border Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .single_pricing' => 'border-color: {{VALUE}}',
							],
						]
					);
				
				$this->end_controls_tab();
				
				$this->start_controls_tab(
					'border_hover_tab',
					[
						'label' => __( 'Hover', 'dreamit-elementor-extension' ),
					]
				);

					$this->add_control(
						'border_hover_color',
						[
							'label' => __( 'Border Hover Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .single_pricing:hover' => 'border-color: {{VALUE}}',
							],
						]
					);
				
				$this->end_controls_tab();
				
			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'header_section',
			[
				'label' => __( 'Table Header', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'background',
					'label' => __( 'Background', 'dreamit-elementor-extension' ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => '{{WRAPPER}} .style-two .pricing_top_bar',
					'condition'=>[
						'select_style'=> 'two',
					],
				]
			);
			$this->add_control(
				'icon_border_color',
				[
					'label' => __( 'Icon Border Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .style-two .pricing_img' => 'border-color: {{VALUE}}',
					],
					'condition'=>[
						'select_style'=> 'two',
					],
				]
			);
			$this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .pricing_title h3' => 'color: {{VALUE}}',
						'{{WRAPPER}} .style-two .pricing_title h3::after, .style-two .pricing_title h3::before' => 'background: {{VALUE}}',
					],
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'label' => __( 'Title Typography', 'dreamit-elementor-extension' ),
					'selector' => '{{WRAPPER}} .pricing_title h3',
				]
			);
			$this->add_control(
				'price_color',
				[
					'label' => __( 'Price Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .price_item .price_item_inner .price_item_inner_center .curencyp, 
						.price_item .price_item_inner .price_item_inner_center .tk, 
						.price_item .price_item_inner .price_item_inner_center .monthp .month_inner .bootmp' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'price_typography',
					'label' => __( 'Price Typography', 'dreamit-elementor-extension' ),
					'selector' => '{{WRAPPER}} .price_item .price_item_inner .price_item_inner_center span',
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'feature_section',
			[
				'label' => __( 'Features', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'feature_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .pricing_body .featur ul li' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'feature_typography',
					'label' => __( 'Typography', 'dreamit-elementor-extension' ),
					'selector' => '{{WRAPPER}} .pricing_body .featur ul li',
				]
			);

			$this->start_controls_tabs(
				'feature_tabs',
				[
					'condition'=>[
						'select_style'=> 'one',
					]
				]
			);
				$this->start_controls_tab(
					'feature_normal_tab',
					[
						'label' => __( 'Normal', 'dreamit-elementor-extension' ),
					]
				);
				
					$this->add_control(
						'feature_border_color',
						[
							'label' => __( 'Border Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .single_pricing .featur' => 'border-color: {{VALUE}}',
							],
						]
					);
				
				$this->end_controls_tab();
				
				$this->start_controls_tab(
					'feature_hover_tab',
					[
						'label' => __( 'Hover', 'dreamit-elementor-extension' ),
					]
				);

					$this->add_control(
						'feature_border_hover_color',
						[
							'label' => __( 'Border Hover Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .single_pricing:hover .featur' => 'border-color: {{VALUE}}',
							],
						]
					);
				
				$this->end_controls_tab();
				
			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
				'button_tabs'
			);
				$this->start_controls_tab(
					'button_normal_tab',
					[
						'label' => __( 'Normal', 'dreamit-elementor-extension' ),
					]
				);
				
					$this->add_control(
						'button_background_color',
						[
							'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .pricing_bottom .order_now a' => 'background: {{VALUE}}',
							],
						]
					);
					$this->add_control(
						'button_text_color',
						[
							'label' => __( 'Text Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .pricing_bottom .order_now a' => 'color: {{VALUE}}',
							],
						]
					);
					$this->add_control(
						'button_border_color',
						[
							'label' => __( 'Border Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .pricing_bottom .order_now a' => 'border-color: {{VALUE}}',
							],
						]
					);
				
				$this->end_controls_tab();
				
				$this->start_controls_tab(
					'button_hover_tab',
					[
						'label' => __( 'Hover', 'dreamit-elementor-extension' ),
					]
				);

					$this->add_control(
						'button_hover_background_color',
						[
							'label' => __( 'Background Hover Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .single_pricing:hover .pricing_bottom .order_now a' => 'background: {{VALUE}}',
							],
						]
					);
					$this->add_control(
						'button_hover_text_color',
						[
							'label' => __( 'Text Hover Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .single_pricing:hover .pricing_bottom .order_now a' => 'color: {{VALUE}}',
							],
						]
					);
					$this->add_control(
						'button_border_hover_color',
						[
							'label' => __( 'Border Hover Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .single_pricing:hover .pricing_bottom .order_now a' => 'border-color: {{VALUE}}',
							],
						]
					);
				
				$this->end_controls_tab();
				
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'padding',
				[
					'label' => __( 'Padding', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .pricing_bottom .order_now a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		?>

		<?php if($settings['select_style']=='one'){ ?>

			<div class="single_pricing <?php if('yes' === $settings['show_active']){echo esc_attr('active');}?>">
				<div class="pricing_content">
						
					<div class="pricing_top_bar">

						<div class="pricing_head">
								
							<div class="pricing_title">
								<h3><?php echo $settings['title']; ?></h3>
							</div>
								
						</div>
							
						<div class="price_item">
							<div class="price_item_inner">
								<div class="price_item_inner_center">
									
									<?php if( !empty($settings['currency']) ){ ?>
									<span class="curencyp"><?php echo $settings['currency']; ?></span>
									<?php } ?>
									
									<?php if( !empty($settings['price']) ){ ?>
									<span class="tk"><?php echo $settings['price']; ?></span>
									<?php } ?>
									
									<?php if( !empty($settings['month']) ){ ?>
									<span class="monthp">
										<span class="month_inner">
											<span class="bootmp"><?php echo $settings['month']; ?></span>
										</span>
									</span>
									<?php } ?>
								
								</div>
							</div>
						</div>
					</div>

					<div class="pricing_body">
					
						<div class="featur">
							<ul>																	
								<?php foreach (  $settings['slides'] as $item ) { ?>
									<li><?php echo $item['item_field']; ?></li>
								<?php } ?>														
							</ul>
						</div>									
						
						<div class="pricing_bottom">
							<div class="order_now">				
								<a href="<?php echo esc_url($settings['button_link']['url']); ?>" class="singinp"><?php echo $settings['button_text']; ?></a>		
							</div>
						</div>
						
					</div>
				</div>
			</div>

		<?php }elseif($settings['select_style']=='two'){ ?>

			<div class="single_pricing style-two <?php if('yes' === $settings['show_active']){echo esc_attr('active');}?>">
				<div class="pricing_content <?php if('yes' === $settings['change_curve']){echo esc_attr('pricing-3');}?>">
						
					<div class="pricing_top_bar">
						<div class="pricing_head">
								
							<div class="pricing_title">
								<h3><?php echo $settings['title']; ?></h3>
							</div>
								
						</div>
							
						<div class="price_item">
							<div class="price_item_inner">
								<div class="price_item_inner_center">
									
									<?php if( !empty($settings['currency']) ){ ?>
									<span class="curencyp"><?php echo $settings['currency']; ?></span>
									<?php } ?>
									
									<?php if( !empty($settings['price']) ){ ?>
									<span class="tk"><?php echo $settings['price']; ?></span>
									<?php } ?>
									
									<?php if( !empty($settings['month']) ){ ?>
									<span class="monthp">
										<span class="month_inner">
											<span class="bootmp"><?php echo $settings['month']; ?></span>
										</span>
									</span>
									<?php } ?>
									
								</div>
							</div>
						</div>
							
						<div class="pricing_img">
							<img src="<?php echo $settings['image']['url']; ?>" alt="" />
						</div>
							
					</div><!-- .pricing_top_bar -->

					<div class="pricing_body">
								
							<div class="featur">
								<ul>																	
									<?php foreach (  $settings['slides'] as $item ) { ?>
										<li><?php echo $item['item_field']; ?></li>
									<?php } ?>														
								</ul>
							</div>
																	
						
						<div class="pricing_bottom">
							<div class="order_now">				
								<a href="<?php echo esc_url($settings['button_link']['url']); ?>" class="singinp"><?php echo $settings['button_text']; ?></a>		
							</div>
						</div>
						
					</div><!-- .pricing_body -->
				</div>
			</div>

		<?php }elseif($settings['select_style']=='three'){ ?>

			<div class="single_pricing style-three <?php if('yes' === $settings['show_active']){echo esc_attr('active');}?>">
				<div class="pricing_content">
						
						<div class="pricing_img">
							<img src="<?php echo $settings['image']['url']; ?>" alt="" />
						</div>
							
					<div class="pricing_top_bar">
						<div class="pricing_head">
								
							<div class="pricing_title">
								<h3><?php echo $settings['title']; ?></h3>
							</div>
								
						</div>
							
						<div class="price_item">
							<div class="price_item_inner">
								<div class="price_item_inner_center">
								
									<?php if( !empty($settings['currency']) ){ ?>
									<span class="curencyp"><?php echo $settings['currency']; ?></span>
									<?php } ?>
									
									<?php if( !empty($settings['price']) ){ ?>
									<span class="tk"><?php echo $settings['price']; ?></span>
									<?php } ?>

									<?php if( !empty($settings['month']) ){ ?>
									<span class="monthp">
										<span class="month_inner">
											<span class="bootmp"><?php echo $settings['month']; ?></span>
										</span>
									</span>
									<?php } ?>
									
								</div>
							</div>
						</div>
					</div><!-- .pricing_top_bar -->

					<div class="pricing_body">
						
						<div class="featur">
							<ul>																	
								<?php foreach (  $settings['slides'] as $item ) { ?>
									<li><?php echo $item['item_field']; ?></li>
								<?php } ?>														
							</ul>
						</div>
						
						<div class="pricing_bottom">
							<div class="order_now">				
								<a href="<?php echo esc_url($settings['button_link']['url']); ?>" class="singinp"><?php echo $settings['button_text']; ?></a>		
							</div>
						</div>
						
					</div><!-- .pricing_body -->
				</div>
			</div>

		<?php } ?>

		<?php

	}
}