<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

if(!defined('ABSPATH')) exit;


class SectionTitle extends Widget_Base{

	public function get_name(){
		return "sectiontitle";
	}
	
	public function get_title(){
		return "Section Title";
	}
	
	public function get_icon(){
		return "eicon-t-letter";
	}
	public function get_categories(){
		return ['my_category'];
	}
	
	protected function _register_controls(){

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'itsoft' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			
			$this->add_control(
				'text_align',
				[
					'label' => __( 'Alignment', 'itsoft' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						't_left' => __('Text Left', 'itsoft'),
						't_center' => __('Text Center', 'itsoft'),
						't_right' => __('Text Right', 'itsoft'),
					],
					'default' => __( 't_left', 'itsoft' ),
				]
			);
			$this->add_control(
				'subtitle',
				[
					'label' => __( 'Subtitle', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter subtitle', 'itsoft' ),
					'label_block' => true,
					'default' => __( 'Section subtitle', 'itsoft' ),
				]
			);
			$this->add_control(
				'title_one',
				[
					'label' => __( 'Title One', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter title one', 'itsoft' ),
					'label_block' => true,
					'default' => __( 'Section title one', 'itsoft' ),
				]
			);
			$this->add_control(
				'title_two',
				[
					'label' => __( 'Title Two', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter title two', 'itsoft' ),
					'label_block' => true,
					'default' => __( 'Section title two', 'itsoft' ),
				]
			);
			$this->add_control(
				'highlight_text',
				[
					'label' => __( 'Highlight Text', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter highlight text', 'itsoft' ),
					'label_block' => true,
					'default' => __( 'Highlight text', 'itsoft' ),
				]
			);
			$this->add_control(
				'description',
				[
					'label' => __( 'Description', 'itsoft' ),
					'type' => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter description', 'itsoft' ),
					'label_block' => true,
					'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'itsoft' ),
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

		$this->start_controls_section(
			'content_section_style',
			[
				'label' => __( 'Content', 'itsoft' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'subtitle_heading',
				[
					'label' => __( 'Subtitle', 'itsoft' ),
					'type' => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'subtitle_color',
				[
					'label' => __( 'Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .section-title h5' => 'color: {{VALUE}}',
						'{{WRAPPER}} .title_tx h5' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'subtitle_typography',
					'label' => __( 'Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .section-title h5',
				]
			);
			$this->add_control(
				'title_one_heading',
				[
					'label' => __( 'Title One', 'itsoft' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'title_one_color',
				[
					'label' => __( 'Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .section-title h3' => 'color: {{VALUE}}',
						'{{WRAPPER}} .title_tx h3' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_one_typography',
					'label' => __( 'Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .section-title h3',
				]
			);
			$this->add_control(
				'title_two_heading',
				[
					'label' => __( 'Title Two', 'itsoft' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'title_two_color',
				[
					'label' => __( 'Title Two Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .section-title h2' => 'color: {{VALUE}}',
						'{{WRAPPER}} .title_tx h2' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_two_typography',
					'label' => __( 'Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .section-title h2',
				]
			);
			$this->add_control(
				'highlight_text_heading',
				[
					'label' => __( 'Highlight Text', 'itsoft' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'highlight_text_color',
				[
					'label' => __( 'Highlight Text Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .section-title span' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'highlight_text_typography',
					'label' => __( 'Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .section-title span',
				]
			);
			$this->add_control(
				'underline_heading',
				[
					'label' => __( 'Underline', 'itsoft' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'underline_color',
				[
					'label' => __( 'Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .bar.bar-big::before' => 'border-top-color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'underline_bottom_space',
				[
					'label' => __( 'Spacing', 'itsoft' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 30,
					],
					'selectors' => [
						'{{WRAPPER}} .bar-main' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'description_heading',
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
						'{{WRAPPER}} .section-title p' => 'color: {{VALUE}}',
						'{{WRAPPER}} .title_ptx p' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'label' => __( 'Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .section-title p',
				]
			);
		$this->end_controls_section();
	}

	protected function render(){

		$settings = $this->get_settings_for_display();

		?>

		<?php if($settings['select_style']=='one'){ ?>
		<div class="">

			<div class="section-title <?php echo $settings['text_align']; ?>">
				
				<h5><?php echo $settings['subtitle']; ?></h5>
				
				<h3><?php echo $settings['title_one']; ?></h3>

				<h2><?php echo $settings['title_two']; ?><span><?php echo $settings['highlight_text']; ?></span></h2>
				
							
				<div class="bar-main">
					<div class="bar bar-big"></div>
				</div>
				

				<p><?php echo $settings['description']; ?></p>

				
			</div>	

		</div>

		<?php }elseif($settings['select_style']=='two'){ ?>

		<div class="title_in_area">
		<div class="title_in">
			<div class="title_tx">
				
				<h5><?php echo $settings['subtitle']; ?></h5>
				
				<h3><?php echo $settings['title_one']; ?></h3>
				
				<h2><?php echo $settings['title_two']; ?><span><?php echo $settings['highlight_text']; ?></span></h2>
				
			</div>
		</div>
		<div class="title_p">

			<div class="title_ptx">

				<p><?php echo $settings['description']; ?></p>

			</div>
			
		</div>
		</div>

		<?php } ?>

		<?php 
	}

}