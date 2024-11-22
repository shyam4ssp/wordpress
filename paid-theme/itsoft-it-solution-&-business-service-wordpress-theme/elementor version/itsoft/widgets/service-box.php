<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if(!defined('ABSPATH')) exit;


class ServiceBox extends Widget_Base{

	public function get_name(){
		return "service";
	}
	
	public function get_title(){
		return "Service Box";
	}
	
	public function get_icon(){
		return "eicon-info-box";
	}
	public function get_categories(){
		return ['my_category'];
	}
	
	protected function _register_controls(){

		$this->start_controls_section(
			'icon_section',
			[
				'label' => __( 'Icon', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
			'image_section',
			[
				'label' => __( 'Image', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'select_style' => 'three',
				]
			]
		);
			$this->add_control(
				'single_img',
				[
				    'label' => esc_html__('Image','dreamit-elementor-extension'),
				    'type'=>Controls_Manager::MEDIA,
				    'default' => [
					  'url' => \Elementor\Utils::get_placeholder_image_src(),
				    ],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'service_section',
			[
				'label' => __( 'Title & Description', 'dreamit-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'title_number',
				[
					'label' => __( 'Number', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter Number', 'dreamit-elementor-extension' ),
					'label_block' => true,
					'default' => __( '01', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'title_text',
				[
					'label' => __( 'Title', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::TEXT,
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
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your paragraph', 'dreamit-elementor-extension' ),
					'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'dreamit-elementor-extension' ),
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button', 'dreamit-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'button_text',
				[
					'label' => __( 'Button Text', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your button text', 'dreamit-elementor-extension' ),
					'label_block' => true,
					'default' => __( 'Button', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'link',
				[
					'label' => __( 'Link', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::URL,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'https://your-link.com', 'dreamit-elementor-extension' ),
				]
			);
			$this->add_control(
				'show_button',
				[
					'label' => __( 'Show Button', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'dreamit-elementor-extension' ),
					'label_off' => __( 'Hide', 'dreamit-elementor-extension' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'button_icon',
				[
					'label' => __( 'Button Icon', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fa fa-angle-right',
						'library' => 'solid',
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
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'one' => __( 'One', 'dreamit-elementor-extension' ),
						'two' => __( 'Two', 'dreamit-elementor-extension' ),
						'three' => __( 'Three', 'dreamit-elementor-extension' ),
						'four' => __( 'Four', 'dreamit-elementor-extension' ),
						'five' => __( 'Five', 'dreamit-elementor-extension' ),
						'six' => __( 'Six', 'dreamit-elementor-extension' ),
					],
					'default' => 'one',
					
				]
			);
			$this->add_responsive_control(
				'text_align',
				[
					'label' => __( 'Alignment', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'dreamit-elementor-extension' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'dreamit-elementor-extension' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'dreamit-elementor-extension' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'dreamit-elementor-extension' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .service-box' => 'text-align: {{VALUE}};',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'icon_section_style',
			[
				'label' => __( 'Icon', 'dreamit-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-icon i' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'icon_background_color',
				[
					'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-icon i' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'icon_border',
					'label' => __( 'Border', 'dreamit-elementor-extension' ),
					'selector' => '{{WRAPPER}} .service-box .service-box-icon i',
				]
			);
			$this->add_responsive_control(
				'icon_border_radius',
				[
					'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'hover_icon_color',
				[
					'label' => __( 'Icon Color', 'dreamit-elementor-extension' ),
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
					'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .service-box:hover .service-box-icon i' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'hover_icon_border',
					'label' => __( 'Border', 'dreamit-elementor-extension' ),
					'selector' => '{{WRAPPER}} .service-box:hover .service-box-icon i',
				]
			);
			$this->add_responsive_control(
				'hover_icon_border_radius',
				[
					'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .service-box:hover .service-box-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .service-box .service-box-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .service-box .service-box-icon i' => 'height: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .service-box .service-box-icon i' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'icon_typography',
					'selector' => '{{WRAPPER}} .service-box .service-box-icon i',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_section_style',
			[
				'label' => __( 'Title', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'title_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::COLOR,
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
			$this->add_responsive_control(
				'title_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-title h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'description_section_style',
			[
				'label' => __( 'Description', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'description_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::COLOR,
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
			$this->add_responsive_control(
				'description_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .service-box .service-box-desc p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'button_section_style',
			[
				'label' => __( 'Button', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			$this->start_controls_tabs(
				'button_style_tabs'
			);
				$this->start_controls_tab(
					'button_style_normal_tab',
					[
						'label' => __( 'Normal', 'dreamit-elementor-extension' ),
					]
				);
				
					$this->add_control(
						'button_text_color',
						[
							'label' => __( 'Text Color', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .service-box .service-btn a' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'button_background_color',
						[
							'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .service-box .service-btn a' => 'background-color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'button_border',
							'label' => __( 'Border', 'dreamit-elementor-extension' ),
							'selector' => '{{WRAPPER}} .service-box .service-btn a',
						]
					);
					$this->add_responsive_control(
						'button_border_radius',
						[
							'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .service-box .service-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
				$this->end_controls_tab();
				
				$this->start_controls_tab(
					'button_style_hover_tab',
					[
						'label' => __( 'Hover', 'dreamit-elementor-extension' ),
					]
				);

					$this->add_control(
						'hover_button_text_color',
						[
							'label' => __( 'Text Color', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .service-box .service-btn a:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'hover_button_background_color',
						[
							'label' => __( 'Background Color', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .service-box .service-btn a:hover' => 'background-color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'hover_button_border',
							'label' => __( 'Border', 'dreamit-elementor-extension' ),
							'selector' => '{{WRAPPER}} .service-box .service-btn a:hover',
						]
					);
					$this->add_responsive_control(
						'hover_button_border_radius',
						[
							'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .service-box .service-btn a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
				$this->end_controls_tab();
				
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'button_margin',
				[
					'label' => __( 'Margin', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .service-box .service-btn a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'button_height',
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
						'{{WRAPPER}} .service-box .service-btn a' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'button_width',
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
						'{{WRAPPER}} .service-box .service-btn a' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .service-box .service-btn a',
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
							'selector' => '{{WRAPPER}} .service-box',
						]
					);

					$this->add_responsive_control(
						'box_border_radius',
						[
							'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .service-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'box_shadow',
							'label' => __( 'Box Shadow', 'dreamit-elementor-extension' ),
							'selector' => '{{WRAPPER}} .service-box',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'box_background',
							'label' => __( 'Background', 'dreamit-elementor-extension' ),
							'types' => [ 'classic', 'gradient', 'video' ],
							'selector' => '{{WRAPPER}} .service-box',
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
							'selector' => '{{WRAPPER}} .service-box:hover',
						]
					);

					$this->add_responsive_control(
						'hover_box_border_radius',
						[
							'label' => __( 'Border Radius', 'dreamit-elementor-extension' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .service-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'hover_box_shadow',
							'label' => __( 'Box Shadow', 'dreamit-elementor-extension' ),
							'selector' => '{{WRAPPER}} .service-box:hover',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'hover_box_background',
							'label' => __( 'Background', 'dreamit-elementor-extension' ),
							'types' => [ 'classic', 'gradient', 'video' ],
							'selector' => '{{WRAPPER}} .service-box:hover',
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
						'{{WRAPPER}} .service-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .service-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();



		$this->add_render_attribute( 'title_text', 'class', 'service-box-title' );
		$this->add_render_attribute( 'description_text', 'class', 'service-box-desc' );

		$has_button_icon = ! empty( $settings['button_icon'] );
		if ( $has_button_icon ) {
			$this->add_render_attribute( 'j', 'class', $settings['button_icon'] );
		}
		
		?>

		<?php if($settings['select_style']=='one'){ ?>

			<div class="service-box <?php echo esc_attr( $siconealign ); ?>">	
				<div class="service-box-content ">
					<div class="single-service-text">
						<div class="service-top-text">
							
							<?php if($settings['icons_type'] == 'icon' ){ ?>
							<div class="service-box-icon">
								<i class="<?php echo esc_attr($settings['select_icon']); ?>"></i>
							</div>
							<?php } ?>
							
						</div>
						<div class="service-box-inner">

							<div <?php echo $this->get_render_attribute_string( 'title_text' ); ?> >
								<h2><?php echo $settings['title_text']; ?></h2>
							</div>

							<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
								<p><?php echo $settings['description_text']; ?></p>
							</div>

							<?php if( 'yes'===$settings['show_button'] ){ ?>
								<div class="service-btn">
									<a href="<?php echo esc_url($settings['link']['url']); ?>">
										<?php echo $settings['button_text']; ?>
										<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
									</a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

		<?php }elseif($settings['select_style']=='two'){ ?>


			<div class="service-box service-style-two">

				<?php if($settings['icons_type'] == 'icon' ){ ?>
				<div class="service-box-icon">
					<i class="<?php echo esc_attr($settings['select_icon']); ?>"></i>
				</div>
				<?php } ?>

				<div class="service-box-content">

					<div <?php echo $this->get_render_attribute_string( 'title_text' ); ?> >
						<h2><?php echo $settings['title_text']; ?></h2>
					</div>

					<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
						<p><?php echo $settings['description_text']; ?></p>
					</div>

					<?php if( 'yes'===$settings['show_button'] ){ ?>
					<div class="service-btn">
						<a href="<?php echo esc_url($settings['link']['url']); ?>">
							<?php echo $settings['button_text']; ?>
							<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
						</a>
					</div><!-- .service-btn	-->
					<?php } ?>

				</div><!-- .service-box-content -->
			</div><!-- .service-box .service-style-two -->


		<?php }elseif($settings['select_style']=='three'){ ?>

			<div class="service-box service-style-three">		
				<div class="service-box-thumb">

					<img src="<?php echo $settings['single_img']['url']; ?>" alt="">

					<div class="service-content-front">
						
							<?php if($settings['icons_type'] == 'icon' ){ ?>
							<div class="service-box-icon">
								<i class="<?php echo esc_attr($settings['select_icon']); ?>"></i>
							</div>
							<?php } ?>		
							
						<div class="service-box-title">
							<h2><?php echo $settings['title_text']; ?></h2>
						</div>

					</div>

					<div class="service-content-back">
						<div class="service-content-back-inner">
							
							<?php if($settings['icons_type'] == 'icon' ){ ?>
							<div class="service-box-icon">
								<i class="<?php echo esc_attr($settings['select_icon']); ?>"></i>
							</div>
							<?php } ?>			
							
							<div class="em_service_content">

								<div class="service-box-title">
									<h2><?php echo $settings['title_text']; ?></h2>
								</div>

								<div class="service-box-desc">
									<p><?php echo $settings['description_text']; ?></p>
								</div>

								<?php if( 'yes'===$settings['show_button'] ){ ?>
								<div class="service-btn">
									<a href="<?php echo esc_url($settings['link']['url']); ?>">
										<?php echo $settings['button_text']; ?>
										<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
									</a>
								</div>
								<?php } ?>

							</div>
						</div>
					</div>
				</div>
			</div>
					
		<?php }elseif($settings['select_style']=='four'){ ?>

				<div class="service-box style_4">

					<?php if($settings['icons_type'] == 'img' ){ ?>
					<div class="service-box-thumb">
						<img src="<?php echo $settings['select_img']['url'];?>" alt="" />
					</div>
					<?php } ?>

					<div class="em_service_content">
						<div class="em_single_service_text">
							<div class="service_top_text">
								<div <?php echo $this->get_render_attribute_string( 'title_text' ); ?> >
									<h2><?php echo $settings['title_text']; ?></h2>
								</div>
							</div>
							<div class="service-box-inner">				
								<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
									<p><?php echo $settings['description_text']; ?></p>
								</div>						
							</div>
							<?php if( 'yes'===$settings['show_button'] ){ ?>
							<div class="service-btn">
								<a href="<?php echo esc_url($settings['link']['url']); ?>">
									<?php echo $settings['button_text']; ?>
									<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
								</a>
							</div><!-- .service-btn	-->
							<?php } ?>
						</div>
					</div>
				</div>

		<?php }elseif($settings['select_style']=='five'){ ?>

				<div class="service-box style-five">		
					<div class="em_service_content d-flex">
						<div class="service-number">
							<span class="service-box-number"><?php echo $settings['title_number'];?></span>
						</div>
						
						<div class="service_box_text">	
								<div <?php echo $this->get_render_attribute_string( 'title_text' ); ?> >
									<h3>
									<?php echo $settings['title_text']; ?>
									</h3>
								</div>

							<div class="service-box-inner">				
								<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
									<p><?php echo $settings['description_text']; ?></p>
								</div>						
							</div>
							
							<?php if( 'yes'===$settings['show_button'] ){ ?>
							<div class="service-btn">
								<a href="<?php echo esc_url($settings['link']['url']); ?>">
									<?php echo $settings['button_text']; ?>
									<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
								</a>
							</div><!-- .service-btn	-->
							<?php } ?>
						</div>
					</div>
				</div>

		<?php }elseif($settings['select_style']=='six'){ ?>

				<div class="service-box service-style-six">

					<div class="service-box-content">

						<div <?php echo $this->get_render_attribute_string( 'title_text' ); ?> >
							<h2><?php echo $settings['title_text']; ?></h2>
						</div>
						<?php if($settings['icons_type'] == 'icon' ){ ?>
						<div class="service-box-icon">
							<i class="<?php echo esc_attr($settings['select_icon']); ?>"></i>
						</div>
						<?php } ?>
						<div <?php echo $this->get_render_attribute_string( 'description_text' ); ?> >
							<p><?php echo $settings['description_text']; ?></p>
						</div>

						<?php if( 'yes'===$settings['show_button'] ){ ?>
						<div class="service-btn">
							<a href="<?php echo esc_url($settings['link']['url']); ?>">
								<?php echo $settings['button_text']; ?>
								<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
							</a>
						</div><!-- .service-btn	-->
						<?php } ?>						
					</div>
				</div><!-- .service-box .service-style-six -->

		<?php }
	}
}


