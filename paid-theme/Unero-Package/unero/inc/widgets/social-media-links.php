<?php

if ( ! class_exists( 'Unero_Social_Links_Widget' ) ) {

	class Unero_Social_Links_Widget extends WP_Widget {
		protected $default;
		protected $socials;

		/**
		 * Constructor
		 */
		function __construct() {
			$this->socials = array(
				'facebook'   => esc_html__( 'Facebook', 'unero' ),
				'twitter'    => esc_html__( 'Twitter', 'unero' ),
				'googleplus' => esc_html__( 'Google Plus', 'unero' ),
				'youtube'    => esc_html__( 'Youtube', 'unero' ),
				'tumblr'     => esc_html__( 'Tumblr', 'unero' ),
				'linkedin'   => esc_html__( 'Linkedin', 'unero' ),
				'pinterest'  => esc_html__( 'Pinterest', 'unero' ),
				'flickr'     => esc_html__( 'Flickr', 'unero' ),
				'instagram'  => esc_html__( 'Instagram', 'unero' ),
				'dribbble'   => esc_html__( 'Dribbble', 'unero' ),
				'skype'      => esc_html__( 'Skype', 'unero' ),
				'rss'        => esc_html__( 'RSS', 'unero' )

			);
			$this->default = array(
				'title' => '',
			);
			foreach ( $this->socials as $k => $v ) {
				$this->default["{$k}_title"] = $v;
				$this->default["{$k}_url"]   = '';
			}

			parent::__construct(
				'social-links-widget',
				esc_html__( 'Unero - Social Links', 'unero' ),
				array(
					'classname'   => 'social-links-widget social-links',
					'description' => esc_html__( 'Display links to social media networks.', 'unero' ),
				),
				array( 'width' => 600, 'height' => 350 )
			);
		}

		/**
		 * Outputs the HTML for this widget.
		 *
		 * @param array $args An array of standard parameters for widgets in this theme
		 * @param array $instance An array of settings for this widget instance
		 *
		 * @return void Echoes it's output
		 */
		function widget( $args, $instance ) {
			$instance = wp_parse_args( $instance, $this->default );

			extract( $args );
			echo wp_kses_post($before_widget);

			if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
				echo wp_kses_post($before_title) . $title . wp_kses_post($after_title);
			}

			echo '<div class="social-links-list">';

			foreach ( $this->socials as $social => $label ) {
				if ( ! empty( $instance[ $social . '_url' ] ) ) {
					printf(
						'<a href="%s" class="share-%s tooltip-enable social" rel="nofollow" title="%s" data-toggle="tooltip" data-placement="top" target="_blank"><i class="social social_%s"></i></a>',
						esc_url( $instance[ $social . '_url' ] ),
						esc_attr( $social ),
						esc_attr( $instance[ $social . '_title' ] ),
						esc_attr( $social )
					);
				}
			}

			echo '</div>';

			echo wp_kses_post($after_widget);
		}

		/**
		 * Displays the form for this widget on the Widgets page of the WP Admin area.
		 *
		 * @param array $instance
		 *
		 * @return array
		 */
		function form( $instance ) {
			$instance = wp_parse_args( $instance, $this->default );
			?>

            <p>
                <label
                        for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'unero' ); ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                       value="<?php echo esc_attr( $instance['title'] ); ?>"/>
            </p>
			<?php
			foreach ( $this->socials as $social => $label ) {
				printf(
					'<div class="mr-recent-box">
					<label>%s</label>
					<p><input type="text" class="widefat" name="%s" placeholder="%s" value="%s"></p>
				</div>',
					$label,
					$this->get_field_name( $social . '_url' ),
					esc_html__( 'URL', 'unero' ),
					$instance[ $social . '_url' ]
				);
			}
		}
	}
}