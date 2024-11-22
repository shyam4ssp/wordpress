<?php

namespace WPC;

class Widgets_Loader{

	private static $_instance = null;
	
	public static function instance(){
		if( is_null(self::$_instance) ){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	private function include_widgets_files(){
		require_once(__DIR__ . '/widgets/service-box.php');
		require_once(__DIR__ . '/widgets/dreamit-service-carousel.php');
		require_once(__DIR__ . '/widgets/dreamit-flip-box.php');
		require_once(__DIR__ . '/widgets/dreamit-feature-box.php');
		require_once(__DIR__ . '/widgets/dreamit-slick-slider.php');
		require_once(__DIR__ . '/widgets/team/dreamit-team.php');
		require_once(__DIR__ . '/widgets/dreamit-work-process.php');
		require_once(__DIR__ . '/widgets/dreamit-call-to-action.php');
		require_once(__DIR__ . '/widgets/dreamit-testimonial.php');
		require_once(__DIR__ . '/widgets/dreamit-blog-post.php');
		require_once(__DIR__ . '/widgets/dreamit-section-title.php');
		require_once(__DIR__ . '/widgets/dreamit-case-study.php');
		require_once(__DIR__ . '/widgets/dreamit-brand.php');
		require_once(__DIR__ . '/widgets/dreamit-counter-box.php');
		require_once(__DIR__ . '/widgets/dreamit-icon-box.php');
		require_once(__DIR__ . '/widgets/dreamit-video-box.php');
		require_once(__DIR__ . '/widgets/dreamit-portfolio.php');
		require_once(__DIR__ . '/widgets/dreamit-nivo-slider.php');
		require_once(__DIR__ . '/widgets/dreamit-post-tab.php');
		require_once(__DIR__ . '/widgets/dreamit-pricing-table.php');
	}
	
	public function register_widgets(){
	
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ServiceBox());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ServiceCarousel());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\FlipBox());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\FeatureBox());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\SlickSlider());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Team());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\WorkProcess());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\CallToAction());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Testimonial());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\BlogPost());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\SectionTitle());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\CaseStudy());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Brand());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\CounterBox());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\IconBox());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\VideoBox());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\NivoSlider());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PostTab());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Portfolio());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PricingTable());
	}
	
	public function __construct(){
		add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets'], 99 );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
		add_action( 'elementor/elements/categories_registered', [$this, 'add_category'] );
	}


	// Enqueue Stylesheet
	public function widget_styles() {

		wp_enqueue_style('widget-css', get_template_directory_uri() . '/widgets/css/widgets-style.css', [], '1.1' );

		wp_enqueue_script( 'script', get_template_directory_uri() . '/widgets/js/jquery.magnific-popup.min.js', array ( 'jquery' ), 1.1, true);

	}
	
	// Add Category
	public function add_category( $elements_manager ) {
        $elements_manager->add_category(
            'my_category',
            [
                'title' => __( 'Dream IT Addons', 'itsoft' ),
                'icon' => 'fa fa-smile-o',
            ],
			2
        );
    }
	
}
Widgets_Loader::instance();













