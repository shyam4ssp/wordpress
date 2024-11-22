<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Group_Control_Box_Shadow;

if(!defined('ABSPATH')) exit;


class WorkProcess extends Widget_Base{

	public function get_name(){
		return "workprocess";
	}
	
	public function get_title(){
		return "Work Process";
	}
	
	public function get_icon(){
		return "eicon-flow";
	}

	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'itsoft' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'image',
				[
					'label' => __( 'Choose Image', 'itsoft' ),
					'type' => Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					]
				]
			);
			$this->add_control(
				'number',
				[
					'label' => __( 'Number', 'itsoft' ),
					'type' => Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 100,
					'step' => 1,
					'default' => 1,
				]
			);
			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Default title', 'itsoft' ),
					'placeholder' => __( 'Type your title here', 'itsoft' ),
				]
			);
			$this->add_control(
				'description',
				[
					'label' => __( 'Description', 'itsoft' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => __( 'Default Description', 'itsoft' ),
					'placeholder' => __( 'Type your Description here', 'itsoft' ),
				]
			);
			$this->add_control(
				'icon',
				[
					'label' => __( 'Icon', 'itsoft' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-star',
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
						'three' => __( 'Three', 'itsoft' ),
					],
					'default' => 'one',
					
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'color_section',
			[
				'label' => __( 'Color', 'itsoft' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'color',
				[
					'label' => __( 'Color', 'itsoft' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .work_progress:hover .wrok_process_thumb, .work_progress-number span, .work_progress-number span::before, .work_progress-number span::after, .style-two .work_progress-number span' => 'background: {{VALUE}};',
						'{{WRAPPER}} .work_progress:hover .wrok_process_thumb' => 'border-color: {{VALUE}};',
					],
				]
			);
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		?>

		<?php if($settings['select_style']=='one'){ ?>

		<div class="work_progress">
			<div class="wrok_process_thumb">
				<img src="<?php echo $settings['image']['url']; ?>" alt="">
				<div class="work_progress-number">
					<span><?php echo $settings['number']; ?></span>
				</div>
			</div>
			<div class="progress_content">

				<div class="work_progress-title">
					<h2>
						<?php echo $settings['title']; ?>
					</h2>
				</div>
				<div class="work_progress-desc">
					<p>
						<?php echo $settings['description']; ?>
					</p>
				</div>
			</div>
		</div>

		<?php }elseif($settings['select_style']=='two'){ ?>

		<div class="work_progress style-two">
			
				<div class="em_process-icon">

					<span><?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></span>

					<div class="work_progress-number">
						<span><?php echo $settings['number']; ?></span>
					</div>
				</div>			
			
			<div class="progress_content">

				<div class="work_progress-title">
					<h2>
						<?php echo $settings['title']; ?>
					</h2>
				</div>
				<div class="work_progress-desc">
					<p>
						<?php echo $settings['description']; ?>
					</p>
				</div>
			</div><!-- .progress_content -->
		</div>

		<?php }elseif($settings['select_style']=='three'){ ?>

		<div class="work_progress">
			<div class="wrok_process_thumb">
				<img src="<?php echo $settings['image']['url']; ?>" alt="">
				<div class="work_progress-number">
					<span><?php echo $settings['number']; ?></span>
				</div>
			</div>
			<div class="progress_content">

				<div class="work_progress-title">
					<h2>
						<?php echo $settings['title']; ?>
					</h2>
				</div>
				<div class="work_progress-desc">
					<p>
						<?php echo $settings['description']; ?>
					</p>
				</div>
			</div><!-- .progress_content -->
		</div>

		<?php } ?>

		<?php
	}
}