<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if(!defined('ABSPATH')) exit;


class CounterBox extends Widget_Base{

	public function get_name(){
		return "counter";
	}
	
	public function get_title(){
		return "Counter";
	}
	
	public function get_icon(){
		return "eicon-counter";
	}

	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_counter',
			[
				'label' => __( 'Counter', 'dreamit-elementor-extension' ),
			]
		);

			$this->add_control(
				'content_position',
				[
					'label' => __( 'Content Position', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
					    'text-left' => __( 'Left', 'dreamit-elementor-extension' ),
					    'text-center' => __( 'Center', 'dreamit-elementor-extension' ),
					],
					'default' => 'text-left',
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => __( 'Icon', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::ICON,
				]
			);

			$this->add_control(
				'number',
				[
					'label' => __( 'Number', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 100,
				]
			);

			$this->add_control(
				'suffix',
				[
					'label' => __( 'Number Suffix', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => '+',
					'placeholder' => __( 'Plus', 'dreamit-elementor-extension' ),
				]
			);

			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic' => [
						'active' => true,
					],
					'default' => __( 'Cool Number', 'dreamit-elementor-extension' ),
					'placeholder' => __( 'Cool Number', 'dreamit-elementor-extension' ),
				]
			);

		$this->end_controls_section();

/*
==========
Style Tab
==========
*/

		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'icon_tabs'
		);
			$this->start_controls_tab(
				'icon_normal_tab',
				[
					'label' => __( 'Normal', 'dreamit-elementor-extension' ),
				]
			);
			
				$this->add_control(
					'icon_color',
					[
						'label' => __( 'Color', 'dreamit-elementor-extension' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .counter_icon i' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'typography_icon',
						'selector' => '{{WRAPPER}} .counter_icon i',
					]
				);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'icon_hover_tab',
				[
					'label' => __( 'Hover', 'dreamit-elementor-extension' ),
				]
			);

				$this->add_control(
					'icon_hover_color',
					[
						'label' => __( 'Color', 'dreamit-elementor-extension' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .single_counter:hover .counter_icon i' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'icon_hover_typography',
						'selector' => '{{WRAPPER}} .single_counter:hover .counter_icon i',
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
							'{{WRAPPER}} .counter_icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'separator' => 'before',
					]
				);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_number',
			[
				'label' => __( 'Number', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'number_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .countr_text h1, .countr_text h3' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_number',
					'selector' => '{{WRAPPER}} .countr_text h1',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'title_color',
				[
					'label' => __( 'Color', 'dreamit-elementor-extension' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .counter_title h4' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_title',
					'selector' => '{{WRAPPER}} .counter_title h4',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'box_section',
			[
				'label' => __( 'Box', 'dreamit-elementor-extension' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background',
                    'label' => __( 'Background', 'dreamit-elementor-extension' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .single_counter',
                ]
            );
			$this->add_responsive_control(
				'padding',
				[
					'label' => __( 'Padding', 'dreamit-elementor-extension' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .single_counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('i', 'class', $settings['icon']);

		?>
			<div class="single_counter default_style <?php echo $settings['content_position'] ?>">
				<div class="single_counter_inner">					
					
					<?php if( !empty($settings['icon']) ){ ?>
					<div class="counter_icon">			
						<i <?php echo $this->get_render_attribute_string('i'); ?>></i>		
					</div>
					<?php } ?>
					
					<div class="countr_text">
						<h1><?php echo $settings['number']; ?></h1>
						<h3><?php echo $settings['suffix']; ?></h3>
					</div>

					<div class="counter_title">
						<h4><?php echo $settings['title']; ?></h4>
					</div>	
					
				</div>
			</div>
		<?php
	}

}