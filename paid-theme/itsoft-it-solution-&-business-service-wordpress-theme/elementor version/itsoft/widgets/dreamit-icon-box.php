<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if(!defined('ABSPATH')) exit;


class IconBox extends Widget_Base {

	public function get_name() {
		return 'iconbox';
	}

	public function get_title() {
		return __( 'Icon Box', 'dreamit-elementor-extension' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'icon_section',
			[
				'label' => __( 'Icons', 'dreamit-elementor-extension' ),
			]
		);
			$this->add_control(
				'icons_type',
				[
				    'label' => esc_html__('Icon Type','dreamit-elementor-extension'),
				    'type' => Controls_Manager::CHOOSE,
				    'options' =>[
					  'img' =>[
						'title' =>esc_html__('Image','dreamit-elementor-extension'),
						'icon' =>'fa fa-picture-o',
					  ],
					  'icon' =>[
						'title' =>esc_html__('Icon','dreamit-elementor-extension'),
						'icon' =>'fa fa-info',
					  ]
				    ],
				    'default' => 'icon',
				]
			 );
			 
			 $this->add_control(
				'select_icon',
				[
					'label' => esc_html__( 'Icon', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::ICON,
					'condition'=>[
						'icons_type'=> 'icon',
					],
					'label_block' => true,
				]
			);
			
			$this->add_control(
				'select_img',
				[
				    'label' => esc_html__('Image','dreamit-elementor-extension'),
				    'type'=>Controls_Manager::MEDIA,
				    'default' => [
					  'url' => \Elementor\Utils::get_placeholder_image_src(),
				    ],
				    'condition' => [
					  'icons_type' => 'img',
				    ]
				]
			);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Title & Description', 'dreamit-elementor-extension' ),
			]
		);
			$this->add_control(
				'title_text',
				[
					'label' => __( 'Title', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your title', 'dreamit-elementor-extension' ),
					'label_block' => true,
					'default' => __( 'This is the title', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'description_text',
				[
					'label' => __( 'Description', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your paragraph', 'dreamit-elementor-extension' ),
					'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'dreamit-elementor-extension' ),
				]
			);
		$this->end_controls_section();
/*
==========
Style Tab
==========
*/

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'dreamit-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
			$this->add_control(
				'text_align',
				[
					'label' => __( 'Alignment', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'dreamit-elementor-extension' ),
							'icon' => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'dreamit-elementor-extension' ),
							'icon' => 'fa fa-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'dreamit-elementor-extension' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => 'center',
					'toggle' => true,
					'selectors' => [
					'{{WRAPPER}} .icon-box.style-two' => 'text-align: {{VALUE}};',
					],
					'condition'=>[
						'select_style'=> 'two',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'icon_section_style',
			[
				'label' => __( 'Icon', 'dreamit-elementor-extension' ),
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
					'icon_color',
					[
						'label' => __( 'Icon Color', 'dreamit-elementor-extension' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .icon-box-icon .icon i' => 'color: {{VALUE}}',
						],
					]
				);
				$this->add_control(
					'icon_background_color',
					[
						'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .icon-box-icon .icon i' => 'background: {{VALUE}}',
						],
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'icon_border',
						'label' => __( 'Border', 'dreamit-elementor-extension' ),
						'selector' => '{{WRAPPER}} .icon-box-icon .icon i',
					]
				);
				$this->add_responsive_control(
					'icon_border_radius',
					[
						'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
							'{{WRAPPER}} .icon-box-icon .icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'icon_hover_color',
					[
						'label' => __( 'Hover Color', 'dreamit-elementor-extension' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .icon-box:hover .icon-box-icon .icon i' => 'color: {{VALUE}}',
						],
					]
				);
				$this->add_control(
					'hover_icon_background_color',
					[
						'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .icon-box:hover .icon-box-icon .icon i' => 'background: {{VALUE}}',
						],
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'hover_border',
						'label' => __( 'Hover Border', 'dreamit-elementor-extension' ),
						'selector' => '{{WRAPPER}} .icon-box:hover .icon-box-icon .icon i',
					]
				);
				$this->add_responsive_control(
					'hover_icon_border_radius',
					[
						'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
							'{{WRAPPER}} .icon-box:hover .icon-box-icon .icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
			$this->end_controls_tab();
			
		$this->end_controls_tabs();

			$this->add_responsive_control(
				'icon_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .icon-box .icon-box-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'height',
				[
					'label' => __( 'Height', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .icon-box-icon .icon i' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'width',
				[
					'label' => __( 'Width', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .icon-box-icon .icon i' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'icon_typography',
					'selector' => '{{WRAPPER}} .icon-box-icon .icon i',
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'title_section',
			[
				'label' => __( 'Title', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
				'title_style_tabs'
			);
				$this->start_controls_tab(
					'title_style_normal_tab',
					[
						'label' => __( 'Normal', 'dreamit-elementor-extension' ),
					]
				);
				
					$this->add_control(
						'title_color',
						[
							'label' => __( 'Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .icon-box-content h2' => 'color: {{VALUE}}',
							],
						]
					);
				
				$this->end_controls_tab();
				
				$this->start_controls_tab(
					'title_style_hover_tab',
					[
						'label' => __( 'Hover', 'dreamit-elementor-extension' ),
					]
				);

					$this->add_control(
						'hover_title_color',
						[
							'label' => __( 'Color', 'dreamit-elementor-extension' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .icon-box-content h2:hover' => 'color: {{VALUE}}',
							],
						]
					);
				
				$this->end_controls_tab();
				
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'title_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .icon-box-content h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_one_typography',
					'selector' => '{{WRAPPER}} .icon-box-content h2',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_section',
			[
				'label' => __( 'Description', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'description_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .icon-box-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'selector' => '{{WRAPPER}} .icon-box-content p',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'box_section_style',
			[
				'label' => __( 'Box', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
				'box_style_tabs'
			);
				$this->start_controls_tab(
					'box_style_normal_tab',
					[
						'label' => __( 'Normal', 'dreamit-elementor-extension' ),
					]
				);
				
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'box_border',
							'label' => __( 'Border', 'dreamit-elementor-extension' ),
							'selector' => '{{WRAPPER}} .icon-box',
						]
					);

					$this->add_responsive_control(
						'box_border_radius',
						[
							'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'box_shadow',
							'label' => __( 'Box Shadow', 'dreamit-elementor-extension' ),
							'selector' => '{{WRAPPER}} .icon-box',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'box_background',
							'label' => __( 'Background', 'dreamit-elementor-extension' ),
							'types' => [ 'classic', 'gradient', 'video' ],
							'selector' => '{{WRAPPER}} .icon-box',
						]
					);
				
				$this->end_controls_tab();
				
				$this->start_controls_tab(
					'box_style_hover_tab',
					[
						'label' => __( 'Hover', 'dreamit-elementor-extension' ),
					]
				);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'hover_box_border',
							'label' => __( 'Border', 'dreamit-elementor-extension' ),
							'selector' => '{{WRAPPER}} .icon-box:hover',
						]
					);

					$this->add_responsive_control(
						'hover_box_border_radius',
						[
							'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .icon-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'hover_box_shadow',
							'label' => __( 'Box Shadow', 'dreamit-elementor-extension' ),
							'selector' => '{{WRAPPER}} .icon-box:hover',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'hover_box_background',
							'label' => __( 'Background', 'dreamit-elementor-extension' ),
							'types' => [ 'classic', 'gradient', 'video' ],
							'selector' => '{{WRAPPER}} .icon-box:hover',
						]
					);
				
				$this->end_controls_tab();
				
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'box_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .icon-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'box_padding',
				[
					'label' => __( 'Padding', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		
		?>

		<?php if($settings['select_style']=='one'){ ?>

		<div class="icon-box d-flex style-one">

			<div class="icon-box-icon">

				<?php if($settings['icons_type'] == 'icon' ) : ?>
				<div class="icon">
					<i class="<?php echo esc_attr($settings['select_icon']); ?>"></i>
				</div>

				<?php else: ?>
				<div class="img-icon">
					<img src="<?php echo $settings['select_img']['url'];?>" alt="" />
				</div>
				<?php endif; ?>

			</div>

			<div class="icon-box-content">
				<div class="title">
					<h2><?php echo $settings['title_text']; ?></h2>
				</div>
				<div class="description">
					<p><?php echo $settings['description_text']; ?></p>
				</div>
			</div>
		</div>

		<?php }elseif($settings['select_style']=='two'){ ?>

		<div class="icon-box style-two">

			<div class="icon-box-icon">

				<?php if($settings['icons_type'] == 'icon' ) : ?>
				<div class="icon">
					<i class="<?php echo esc_attr($settings['select_icon']); ?>"></i>
				</div>

				<?php else: ?>
				<div class="img-icon">
					<img src="<?php echo $settings['select_img']['url'];?>" alt="" />
				</div>
				<?php endif; ?>

			</div>

			<div class="icon-box-content">
				<div class="title">
					<h2><?php echo $settings['title_text']; ?></h2>
				</div>
				<div class="description">
					<p><?php echo $settings['description_text']; ?></p>
				</div>
			</div>
		</div>
		<?php }elseif($settings['select_style']=='three'){ ?>

		<div class="icon-box style-three">

			<div class="icon-box-icon">

				<?php if($settings['icons_type'] == 'icon' ) : ?>
				<div class="icon">
					<i class="<?php echo esc_attr($settings['select_icon']); ?>"></i>
				</div>

				<?php else: ?>
				<div class="img-icon">
					<img src="<?php echo $settings['select_img']['url'];?>" alt="" />
				</div>
				<?php endif; ?>

			</div>

			<div class="icon-box-content">
				<div class="title">
					<h2><?php echo $settings['title_text']; ?></h2>
				</div>
				<div class="description">
					<p><?php echo $settings['description_text']; ?></p>
				</div>
			</div>
		</div>
		<?php } ?>

		<?php
	}
}