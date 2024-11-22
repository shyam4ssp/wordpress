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


class CallToAction extends Widget_Base{

	public function get_name(){
		return "calltoaction";
	}
	
	public function get_title(){
		return "Call To Action";
	}
	
	public function get_icon(){
		return "eicon-filter";
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
				'video_url',
				[
					'label' => __( 'Video URL', 'itsoft' ),
					'type' => Controls_Manager::URL,
					'label_block' => true,
					'default' => [
						'url' => '#',
					],
				]
			);
			$this->add_control(
				'video_icon',
				[
					'label' => __( 'Video Icon', 'itsoft' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-play',
					],
				]
			);
			$this->add_control(
				'subtitle',
				[
					'label' => __( 'Sub Title', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Default sub title', 'itsoft' ),
					'placeholder' => __( 'Type your sub title here', 'itsoft' ),
				]
			);
			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Default Title', 'itsoft' ),
					'placeholder' => __( 'Type your Title here', 'itsoft' ),
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
				'button-text',
				[
					'label' => __( 'Button Text', 'itsoft' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Click Here', 'itsoft' ),
					'placeholder' => __( 'Type your Button text', 'itsoft' ),
				]
			);
			$this->add_control(
				'button_url',
				[
					'label' => __( 'Link', 'itsoft' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', 'itsoft' ),
					'show_external' => true,
					'default' => [
						'url' => '',
						'is_external' => true,
						'nofollow' => true,
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
			'color_section',
			[
				'label' => __( 'Text', 'itsoft' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'title-color',
				[
					'label' => __( 'Title Color', 'itsoft' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .call-to-action-title h2' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'label' => __( 'Title Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .call-to-action-title h2',
				]
			);
			$this->add_control(
				'subtitle-color',
				[
					'label' => __( 'Sub Title Color', 'itsoft' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .call-to-action-title h3' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'subtitle_typography',
					'label' => __( 'Sub Title Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .call-to-action-title h3',
				]
			);
			$this->add_control(
				'description-color',
				[
					'label' => __( 'Description Color', 'itsoft' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .call-to-action-desc p' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'label' => __( 'Description Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .call-to-action-desc p',
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button', 'itsoft' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'label' => __( 'Typography', 'itsoft' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .call-to-action-btn a',
				]
			);

			$this->start_controls_tabs('style_tabs');
			$this->start_controls_tab(
				'style_normal_tab',
				[
					'label' => __( 'Normal', 'itsoft' ),
				]
			);
				$this->add_control(
					'button-color',
					[
						'label' => __( 'Button Color', 'itsoft' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .call-to-action-btn a' => 'background: {{VALUE}};',
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
					'button-hover-color',
					[
						'label' => __( 'Button Color', 'itsoft' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .call-to-action-btn a:hover' => 'background: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'i', 'class', $settings['video_icon'] );

		?>

		<div class="call-to-action">
			<div class="call-to-video">

				<?php if( !empty( $settings['video_url']['url'] ) ){ ?>
					<div class="call-video-link">

						<a class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true" href="<?php echo esc_url($settings['video_url']['url']); ?>"><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i></a>

					</div>
				<?php } ?>

			</div>

			<div class="single_call-to-action_text">
				<div class="call-to-action_top_text">
					<div class="call-to-action-title">
						<span class="subtitlespan"><h3><?php echo $settings['subtitle']; ?></h3></span>
						<h2><?php echo $settings['title']; ?></h2>
					</div>
				</div>
				<div class="call-to-action-inner">				
					<div class="call-to-action-desc">
						<p><?php echo $settings['description']; ?></p>
					</div>						
				</div>

				<?php if( !empty($settings['button-text']) ){ ?>
				<div class="call-to-action-btn">
					<a href="<?php echo esc_url($settings['button_url']['url']); ?>"><?php echo $settings['button-text']; ?></a>
				</div>
				<?php } ?>
			</div>
		</div>

		<?php
	}
}