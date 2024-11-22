<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) exit;


class FeatureBox extends Widget_Base{

	public function get_name(){
		return "feature";
	}
	
	public function get_title(){
		return "Feature Box";
	}
	
	public function get_icon(){
		return "eicon-icon-box";
	}

	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls(){

		$this->start_controls_section(
			'icon_section',
			[
				'label' => __( 'Icon', 'itsoft' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'icon',
				[
					'label' => __( 'Icon', 'itsoft' ),
					'type' => Controls_Manager::ICON,
					
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'feature_section',
			[
				'label' => __( 'Feature Content', 'itsoft' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'title_text',
				[
					'label' => __( 'Title', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your title', 'itsoft' ),
					'label_block' => true,
					'default' => __( 'This is the title', 'itsoft' ),
				]
			);
			$this->add_control(
				'description_text',
				[
					'label' => __( 'Description', 'itsoft' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your paragraph', 'itsoft' ),
					'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'itsoft' ),
				]
			);

		$this->end_controls_section();

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
					'default' => __( 'Button', 'itsoft' ),
				]
			);
			$this->add_control(
				'show_button',
				[
					'label' => __( 'Show Button', 'itsoft' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'itsoft' ),
					'label_off' => __( 'Hide', 'itsoft' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_control(
				'button_icon',
				[
					'label' => __( 'Button Icon', 'itsoft' ),
					'type' => Controls_Manager::ICONS,
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
				'label' => __( 'Style', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'select_style',
				[
					'label' => __( 'Select Style', 'elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'one' => __( 'One', 'elementor' ),
						'two' => __( 'Two', 'elementor' ),
						'three' => __( 'Three', 'elementor' ),
					],
					'default' => 'one',
					
				]
			);
		$this->end_controls_section();


		$this->start_controls_section(
			'icon_section_style',
			[
				'label' => __( 'Icon', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs(
			'style_tabs'
		);
		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);
			$this->add_control(
				'primary_color',
				[
					'label' => __( 'Primary Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box .feature-box-icon i' => 'color: {{VALUE}}',
					],
				]
			);
			
		$this->end_controls_tab();
		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);
			$this->add_control(
				'hover_primary_color',
				[
					'label' => __( 'Primary Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box:hover .feature-box-icon i' => 'color: {{VALUE}}',
					],
				]
			);
			
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_style',
			[
				'label' => __( 'Content', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'text_align',
				[
					'label' => __( 'Alignment', 'elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'elementor' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'elementor' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .feature-box' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'heading_title',
				[
					'label' => __( 'Title', 'elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'title_color',
				[
					'label' => __( 'Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box .feature-box-title h2' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .feature-box .feature-box-title h2, {{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a',
				]
			);
			$this->add_control(
				'heading_description',
				[
					'label' => __( 'Description', 'elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'description_color',
				[
					'label' => __( 'Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-desc p' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'selector' => '{{WRAPPER}} .feature-box-desc p',
				]
			);
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		
		$this->add_render_attribute( 'i', 'class', $settings['icon'] );
	
		

		?>



		<?php if($settings['select_style']=='one'){ ?>


			<div class="feature-box default-style">
				
				<div class="feature-box-icon">
					<span><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i></span>
				</div>			
				
				<div class="feature-box-content">

					<div class="feature-box-number">
						
					</div>

					<div class="feature-box-title">
						<h2><?php echo $settings['title_text']; ?></h2>
					</div>

					<div class="feature-box-desc">
						<p><?php echo $settings['description_text']; ?></p>
					</div>

					<?php if($settings['show_button']=='yes'){ ?>
					<div class="feature-btn">
						<a href="#">
						<?php echo $settings['button_text']; ?>
						<i class="<?php echo esc_attr($settings['button_icon']); ?>"></i>
						</a>
					</div>
					<?php } ?>

				</div>
			</div>

		<?php }elseif($settings['select_style']=='two'){ ?>

			<div class="feature-box style-two">
				
				<div class="feature-box-icon">
					<span><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i></span>
				</div>			
				
				<div class="feature-box-content">

					<div class="feature-box-number">
						
					</div>

					<div class="feature-box-title">
						<<?php echo $settings['title_size']; ?>><?php echo $settings['title_text']; ?></<?php echo $settings['title_size']; ?>>
					</div>

					<div class="feature-box-desc">
						<p><?php echo $settings['description_text']; ?></p>
					</div>

					<?php if( 'yes'===$settings['show_button'] ){ ?>
					<div class="feature-btn">
						<a href="#">
							<?php echo $settings['button_text']; } ?>
							<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
						</a>
					</div>
				</div>
			</div>

		<?php }elseif($settings['select_style']=='three'){ ?>


			<div class="feature-box style-three">
				
				<div class="feature-box-icon">
					<span><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i></span>
				</div>			
				
				<div class="feature-box-content">

					<div class="feature-box-number">
						
					</div>

					<div class="feature-box-title">
						<<?php echo $settings['title_size']; ?>><?php echo $settings['title_text']; ?></<?php echo $settings['title_size']; ?>>
					</div>

					<div class="feature-box-desc">
						<p><?php echo $settings['description_text']; ?></p>
					</div>

					<?php if( 'yes'===$settings['show_button'] ){ ?>
					<div class="feature-btn">
						<a href="#">
							<?php echo $settings['button_text']; } ?>
							<i <?php echo $this->get_render_attribute_string( 'j' ); ?>></i>
						</a>
					</div>
				</div>
			</div>
		<?php } ?>

	<?php
	}
}