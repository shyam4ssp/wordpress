<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) exit;


class PostTab extends Widget_Base{
	public function get_name(){
		return "posttab";
	}
	
	public function get_title(){
		return "Post Tab";
	}
	
	public function get_icon(){
		return "eicon-tabs";
	}

	public function get_categories(){
		return ['my_category'];
	}

	protected function _register_controls(){

        $this->start_controls_section(
            'tab_section', [
                'label' => __( 'Tab', 'itsoft' ),
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


	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$args = array(
			'post_type' => 'em_tab',
		);
		$post_query = new \WP_Query($args);

		?>	

						<div class="em_tab_inner ">
							<div class="col-md-12">
								<ul class="em_tab_pils nav nav-pills">
									<?php while ($post_query->have_posts()) : $post_query->the_post(); 	 ?>	
											<?php  $em_tab_menu  = get_post_meta( get_the_ID(),'_itsoft_em_tab_menu', true );?>
											<?php  $em_tab_active  = get_post_meta( get_the_ID(),'_itsoft_em_tab_active', true );?>
											<?php  $em_tab_icon  = get_post_meta( get_the_ID(),'_itsoft_em_tab_icon', true );?>
											<?php  $em_tab_image  = get_post_meta( get_the_ID(),'_itsoft_em_tab_image', true );?>	
									
											<li  <?php if($em_tab_active){?> class="<?php echo $em_tab_active;?>"  <?php }?> ><a <?php if($em_tab_image){?> style="background-image:url(<?php echo $em_tab_image; ?>);"  <?php } ?>   data-toggle="pill" href="#tab-<?php echo get_the_ID(); ?>"><i class="<?php echo $settings['icon']; ?>"></i><?php if($em_tab_menu){echo $em_tab_menu;   }?></a></li>
																	
											
									<?php endwhile; ?>	
								 </ul>		
							</div>



							
							<div class="em_tab_content tab-content">
							  <?php while ($post_query->have_posts()) : $post_query->the_post(); 		 ?>	
							  
							<?php  $em_tab_active  = get_post_meta( get_the_ID(),'_itsoft_em_tab_active', true );?>
								<div id="tab-<?php echo get_the_ID(); ?>" class="tab-pane  <?php if($em_tab_active){echo $em_tab_active;}?>">
								
								<?php if(has_post_thumbnail()){?> 
									<div class="col-md-6">
											<div class="em_post_tab_thumb">
												<?php the_post_thumbnail();?>
											</div>
									</div>
									
									<div class="col-md-6">	
										<div class="tab_pan_content">
											<h2><?php the_title();?></h2>
											<?php the_content();?>	
										</div>											
									</div>
									<?php }else{?>

										<div class="col-md-12">	
											<div class="tab_pan_content">
												<h2><?php the_title();?></h2>
												<?php the_content();?>
											</div>									
										</div>
									<?php } ?>	
								</div>
							
									<?php endwhile; ?>
							</div>											
							<?php wp_reset_query(); ?>	
							
						</div>	

		<?php
	}
}