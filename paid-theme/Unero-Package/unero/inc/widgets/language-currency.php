<?php
/**
 * Widget API: WP_Widget_Text class
 *
 * @package    WordPress
 * @subpackage Widgets
 * @since      4.4.0
 */


if ( ! class_exists( 'Unero_Language_Currency_Widget' ) ) {
	/**
	 * Core class used to implement a Text widget.
	 *
	 * @since 2.8.0
	 *
	 * @see   WP_Widget
	 */
	class Unero_Language_Currency_Widget extends WP_Widget {

		/**
		 * Sets up a new Text widget instance.
		 *
		 * @since  2.8.0
		 * @access public
		 */
		public function __construct() {
			$widget_ops  = array(
				'classname'   => 'widget_text unero-language-currency',
				'description' => esc_html__( 'Shows language list by WPML plugin and currency list by WooCommerce Currency Switcher plugin', 'unero' ),
			);
			$control_ops = array( 'width' => 400, 'height' => 350 );
			parent::__construct( 'unero-language-currency', esc_html__( 'Unero Language & Currency', 'unero' ), $widget_ops, $control_ops );
		}

		/**
		 * Outputs the content for the current Text widget instance.
		 *
		 * @since  2.8.0
		 * @access public
		 *
		 * @param array $args Display arguments including 'before_title', 'after_title',
		 *                        'before_widget', and 'after_widget'.
		 * @param array $instance Settings for the current Text widget instance.
		 */
		public function widget( $args, $instance ) {


			echo wp_kses_post( $args['before_widget'] );
			if ( ! empty( $title ) ) {
				echo wp_kses_post( $args['before_title'] ) . $title . wp_kses_post( $args['after_title'] );
			}

			$css_class = $instance['style'] . '-layout';

			$show_name = 'code';
			if ( $instance['style'] == 'horizontal' ) {
				$show_name = 'name';
			}
			?>
            <div class="widget-language widget-lan-cur <?php echo esc_attr( $css_class ); ?>">
				<?php
				if ( $instance['language'] ) {
					echo '<h4 class="widget-title">' . $instance['language'] . '</h4>';
				}
				echo apply_filters( 'unero_language_switcher_widget', unero_language_switcher( $show_name ), $show_name );
				?>
            </div>
            <div class="widget-currency widget-lan-cur <?php echo esc_attr( $css_class ); ?>">
				<?php
				if ( $instance['currency'] ) {
					echo '<h4 class="widget-title">' . $instance['currency'] . '</h4>';
				}
				echo unero_currency_switcher( $show_name );
				?>
            </div>
			<?php
			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for the current Text widget instance.
		 *
		 * @since  2.8.0
		 * @access public
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            WP_Widget::form().
		 * @param array $old_instance Old settings for this instance.
		 *
		 * @return array Settings to save or bool false to cancel saving.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance             = $old_instance;
			$instance['style']    = sanitize_title( $new_instance['style'] );
			$instance['language'] = sanitize_text_field( $new_instance['language'] );
			$instance['currency'] = sanitize_text_field( $new_instance['currency'] );


			return $instance;
		}

		/**
		 * Outputs the Text widget settings form.
		 *
		 * @since  2.8.0
		 * @access public
		 *
		 * @param array $instance Current settings.
		 */
		public function form( $instance ) {
			$instance   = wp_parse_args( (array) $instance, array(
				'style'    => '',
				'language' => '',
				'currency' => ''
			) );
			$style      = sanitize_title( $instance['style'] );
			$language   = sanitize_text_field( $instance['language'] );
			$currency   = sanitize_text_field( $instance['currency'] );
			$horizontal = $style == 'horizontal' ? 'selected' : '';
			$vertical   = $style == 'vertical' ? 'selected' : '';
			?>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'language' ) ); ?>"><?php esc_html_e( 'Language Text:', 'unero' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'language' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'language' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $language ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'currency' ) ); ?>"><?php esc_html_e( 'Currency Text:', 'unero' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'currency' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'currency' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $currency ); ?>"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style:', 'unero' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"
                        name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
                    <option value="horizontal" <?php echo esc_attr( $horizontal ); ?>><?php esc_html_e( 'Horizontal', 'unero' ); ?></option>
                    <option value="vertical" <?php echo esc_attr( $vertical ); ?>><?php esc_html_e( 'Vertical', 'unero' ); ?></option>
                </select>
            </p>


			<?php
		}
	}
}