<?php

namespace WPC\Widgets;


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) exit;


class VideoBox extends Widget_Base{
	public function get_name(){
		return "videobox";
	}
	
	public function get_title(){
		return "Video Box";
	}
	
	public function get_icon(){
		return "eicon-icon-box";
	}

	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls(){

        $this->start_controls_section(
            'youtube_section', [
                'label' => __( 'Youtube', 'itsoft' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
	        $this->add_control(
	        	'youtube_video_url',
					[
						'label' => __( 'Video URL', 'itsoft' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
                        'default' => [
                            'url' => '#'
                        ]
					]
	        );
	        $this->add_control(
	        	'youtube_video_icon',
					[
						'label' => __( 'Video Icon', 'itsoft' ),
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => 'fas fa-play',
						],
					]
	        );
        $this->end_controls_section();

        $this->start_controls_section(
            'vimeo_section', [
                'label' => __( 'Vimeo', 'itsoft' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
	        $this->add_control(
	        	'vimeo_video_url',
					[
						'label' => __( 'Video URL', 'itsoft' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
					]
	        );
	        $this->add_control(
	        	'vimeo_video_icon',
					[
						'label' => __( 'Video Icon', 'itsoft' ),
						'type' => Controls_Manager::ICONS,
						'default' => [
							'value' => 'fas fa-play',
						],
					]
	        );
        $this->end_controls_section();

        $this->start_controls_section(
            'background_section', [
                'label' => __( 'Background', 'itsoft' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
			$this->add_control(
				'background_image',
				[
					'label' => __( 'Choose Image', 'itsoft' ),
					'type' => Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
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
					],
					'default' => 'one',
					
				]
			);
		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();



		?>


			<?php if($settings['select_style']=='one'){ ?>

			<div id="parallax-video" class="single-video">
			
				<?php if( !empty($settings['background_image']['url']) ){ ?>
				<div class="em-video-image">	
					<img src="<?php echo $settings['background_image']['url']; ?>" alt="" />
				</div>
				<?php } ?>
									
				
				<div class="choose-video-icon">	

					<div class="video-icon">
						
						<?php if( !empty($settings['youtube_video_url']['url']) ){ ?>
						<a class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true" href="<?php echo $em_youtube; ?>"><?php \Elementor\Icons_Manager::render_icon( $settings['youtube_video_icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
						<?php } ?>
						
						<?php if( !empty($settings['vimeo_video_url']['url']) ){ ?>
						<a class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true" href="<?php echo $em_vimeo; ?>"><?php \Elementor\Icons_Manager::render_icon( $settings['vimeo_video_icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
						<?php } ?>
						
					</div>
					
				</div>
			</div>

			<?php }elseif($settings['select_style']=='two'){ ?>

			<div id="parallax-video" class="single-video style-two">
				
				<div class="choose-video-icon">	

					<div class="video-icon">
						
						<?php if( !empty($settings['youtube_video_url']['url']) ){ ?>
						<a class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true" href="<?php echo $em_youtube; ?>"><?php \Elementor\Icons_Manager::render_icon( $settings['youtube_video_icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
						<?php } ?>
						
						<?php if( !empty($settings['vimeo_video_url']['url']) ){ ?>
						<a class="video-vemo-icon venobox vbox-item" data-vbtype="youtube" data-autoplay="true" href="<?php echo $em_vimeo; ?>"><?php \Elementor\Icons_Manager::render_icon( $settings['vimeo_video_icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
						<?php } ?>
						
					</div>
					
				</div>
			</div>

			<?php } ?>	



		<?php
	}
}
