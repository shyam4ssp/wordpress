<?php
/**
 * Custom functions for entry.
 *
 * @package Unero
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'unero_posted_on' ) ) :
	function unero_posted_on() {
		$time_string   = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		$time_string   = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
		$archive_year  = get_the_time( 'Y' );
		$archive_month = get_the_time( 'm' );
		$archive_day   = get_the_time( 'd' );

		$posted_on = sprintf(
			'<span class="entry-author entry-meta"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		$posted_on .= sprintf(
			'<a href="' . esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) . '" class="entry-meta" rel="bookmark">' . $time_string . '</a>'
		);

		ob_start();
		the_category( ', ' );
		$cats = ob_get_clean();
		if ( $cats ) {
			$posted_on .= '<span class="category-links entry-meta">' . $cats . '</span>';
		}

		echo '<div class="entry-metas">' . $posted_on . '</div>';
	}

endif;

/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_entry_footer' ) ) :
	function unero_entry_footer() {
		$tags_list = get_the_tag_list( '', ', ' );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span>' . esc_html__( 'Tags', 'unero' ) . ':</span> %s</span>', $tags_list );
		}

		if ( unero_get_option( 'post_share_box' ) ):
			printf( '<div class="footer-socials">' );
			printf( '<span>%s: </span>', esc_html__( 'Share', 'unero' ) );
			$image = unero_get_image(
				array(
					'size'     => 'full',
					'format'   => 'src',
					'meta_key' => 'image',
					'echo'     => false,
				)
			);
			unero_share_link_socials( get_the_title(), get_permalink(), $image );
			printf( '</div>' );
		endif;

	}

endif;

/**
 * Get or display limited words from given string.
 * Strips all tags and shortcodes from string.
 *
 * @since 1.0.0
 *
 * @param integer $num_words The maximum number of words
 * @param string  $more      More link.
 * @param bool    $echo      Echo or return output
 *
 * @return string|void Limited content.
 */
function unero_content_limit( $content, $num_words, $more = "&hellip;", $echo = true ) {

	// Strip tags and shortcodes so the content truncation count is done correctly
	$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'unero_content_limit_allowed_tags', '<script>,<style>' ) );

	// Remove inline styles / scripts
	$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

	// Truncate $content to $max_char
	$content = wp_trim_words( $content, $num_words );

	if ( $more ) {
		$output = sprintf(
			'<p>%s <a href="%s" class="more-link" title="%s">%s</a></p>',
			$content,
			get_permalink(),
			sprintf( esc_html__( 'Continue reading &quot;%s&quot;', 'unero' ), the_title_attribute( 'echo=0' ) ),
			esc_html( $more )
		);
	} else {
		$output = sprintf( '<p>%s</p>', $content );
	}

	if ( ! $echo ) {
		return $output;
	}

	echo ! empty( $output ) ? $output : '';
}


/**
 * Show entry thumbnail base on its format
 *
 * @since  1.0
 */

function unero_entry_thumbnail( $size = 'thumbnail' ) {
	$html = '';

	$css_post = '';

	if ( $post_format = get_post_format() ) {
		$css_post = 'format-' . $post_format;
	}

	switch ( get_post_format() ) {
		case 'gallery':
			$images = get_post_meta( get_the_ID(), 'images' );

			$thumb   = '';
			$gallery = array();
			if ( empty( $images ) ) {
				$thumb = get_the_post_thumbnail( get_the_ID(), $size );
			} else {
				$i = 0;
				foreach ( $images as $image ) {
					$thumb_src = wp_get_attachment_image_src( $image, 'full' );
					$thumb_src = $thumb_src ? $thumb_src[0] : '';
					$image_src = wp_get_attachment_image( $image, $size );
					if ( $thumb_src ) {
						if ( $i == 0 ) {
							$thumb = sprintf( '<a href="%s">%s</a>', esc_url( $thumb_src ), $image_src );
						} else {
							$gallery[] = sprintf( '<a class="hidden" href="%s"></a>', esc_url( $thumb_src ) );
						}
					}


					$i++;
				}
			}


			$html .= $thumb . implode( '', $gallery );
			break;

		case 'audio':

			$thumb = get_the_post_thumbnail( get_the_ID(), $size );
			if ( ! empty( $thumb ) ) {
				$html .= '<a class="entry-image" href="' . get_permalink() . '">' . $thumb . '</a>';
			}

			$audio = get_post_meta( get_the_ID(), 'audio', true );
			if ( ! $audio ) {
				break;
			}

			// If URL: show oEmbed HTML or jPlayer
			if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
				if ( $oembed = @wp_oembed_get( $audio, array( 'width' => 1170 ) ) ) {
					$html .= $oembed;
				} else {
					$html .= '<div class="audio-player">' . wp_audio_shortcode( array( 'src' => $audio ) ) . '</div>';
				}
			} else {
				$html .= $audio;
			}
			break;

		case 'video':
			$video = get_post_meta( get_the_ID(), 'video', true );
			if ( is_singular( 'post' ) ) {
				if ( ! $video ) {
					break;
				}

				// If URL: show oEmbed HTML
				if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $video, array( 'width' => 1170 ) ) ) {
						$html .= $oembed;
					} else {
						$atts = array(
							'src'   => $video,
							'width' => 1170,
						);

						if ( has_post_thumbnail() ) {
							$atts['poster'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						}
						$html .= wp_video_shortcode( $atts );
					}
				} // If embed code: just display
				else {
					$html .= $video;
				}
			} else {
				$image_src = get_the_post_thumbnail( get_the_ID(), $size );
				if ( $video ) {
					$html = sprintf( '<a href="%s">%s</a>', esc_url( $video ), $image_src );
				} else {
					$html = $image_src;
				}
			}

			break;

		default:
			$html = get_the_post_thumbnail( get_the_ID(), $size );
			if ( ! is_singular( 'post' ) ) {
				$html = sprintf( '<a href="%s">%s</a>', esc_url( get_the_permalink() ), $html );
			}

			break;
	}

	if ( $html ) {
		$html = sprintf( '<div  class="entry-format %s">%s</div>', esc_attr( $css_post ), $html );
	}

	echo apply_filters( __FUNCTION__, $html, get_post_format() );
}


/**
 * Get breadcrumbs
 *
 * @since  1.0.0
 *
 * @return string
 */

if ( ! function_exists( 'unero_get_breadcrumbs' ) ) :
	function unero_get_breadcrumbs() {
		ob_start();
		?>
		<nav class="breadcrumbs">
			<?php
			unero_breadcrumbs(
				array(
					'before'   => '',
					'taxonomy' => function_exists( 'is_woocommerce' ) && is_woocommerce() ? 'product_cat' : 'category',
				)
			);
			?>
		</nav>
		<?php
		echo ob_get_clean();
	}

endif;

/**
 * Share link socials
 *
 * @since  1.0
 */

if ( ! function_exists( 'unero_share_link_socials' ) ) :
	function unero_share_link_socials( $title, $link, $media ) {
		$socials = unero_get_option( 'product_social_icons' );
		if ( is_singular( 'post' ) ) {
			$socials = unero_get_option( 'post_social_icons' );
		} elseif ( is_singular( 'portfolio_project' ) ) {
			$socials = unero_get_option( 'portfolio_social_icons' );
		}

		$socials_html = '';
		if ( $socials ) {
			if ( in_array( 'facebook', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-facebook unero-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank"><i class="social_facebook"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
			}

			if ( in_array( 'twitter', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-twitter unero-twitter" href="http://twitter.com/share?text=%s&url=%s" title="%s" target="_blank"><i class="social_twitter"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
			}

			if ( in_array( 'pinterest', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-pinterest unero-pinterest" href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" title="%s" target="_blank"><i class="social_pinterest"></i></a>',
					urlencode( $media ),
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'google', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-google-plus unero-google-plus" href="https://plus.google.com/share?url=%s&text=%s" title="%s" target="_blank"><i class="social_googleplus"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'linkedin', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-twitter unero-linkedin" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" title="%s" target="_blank"><i class="social_linkedin"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'vkontakte', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-vkontakte unero-vkontakte" href="http://vk.com/share.php?url=%s&title=%s&image=%s" title="%s" target="_blank"><i class="fa fa-vk"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $media ),
					urlencode( $title )
				);
			}

		}

		if ( $socials_html ) {
			printf( '<div class="social-links">%s</div>', $socials_html );
		}
		?>
		<?php
	}

endif;

/**
 * show categories filter
 *
 * @return string
 */

if ( ! function_exists( 'unero_taxs_list' ) ) :
	function unero_taxs_list( $taxonomy = 'category' ) {

		if ( $taxonomy == 'category' ) {
			if ( ! intval( unero_get_option( 'show_blog_cats' ) ) ) {
				return '';
			}
		} elseif ( $taxonomy = 'portfolio_category' ) {
			if ( ! intval( unero_get_option( 'show_portfolio_cats' ) ) ) {
				return '';
			}
		}


		$cats   = '';
		$output = array();
		$number = intval( unero_get_option( 'blog_cats_number' ) );

		if ( $taxonomy == 'portfolio_category' ) {
			$number = intval( unero_get_option( 'portfolio_cats_number' ) );
		}

		$args = array(
			'number'  => $number,
			'orderby' => 'count',
			'order'   => 'DESC',

		);

		$term_id = 0;

		if ( is_tax( $taxonomy ) || is_category() ) {

			$queried_object = get_queried_object();
			if ( $queried_object ) {
				$term_id = $queried_object->term_id;
			}
		}


		$found      = false;
		$categories = get_terms( $taxonomy, $args );
		if ( ! is_wp_error( $categories ) && $categories ) {
			foreach ( $categories as $cat ) {
				$cat_selected = '';
				if ( $cat->term_id == $term_id ) {
					$cat_selected = 'selected';
					$found        = true;
				}
				$cats .= sprintf( '<li><a href="%s" class="%s">%s</a></li>', esc_url( get_term_link( $cat ) ), esc_attr( $cat_selected ), esc_html( $cat->name ) );
			}
		}

		$cat_selected = $found ? '' : 'selected';

		if ( $cats ) {
			$blog_url = get_page_link( get_option( 'page_for_posts' ) );
			if ( 'posts' == get_option( 'show_on_front' ) ) {
				$blog_url = home_url();
			}

			if ( $taxonomy == 'portfolio_category' ) {
				$blog_url = get_page_link( get_option( 'drf_portfolio_page_id' ) );
			}
			$output[] = sprintf(
				'<ul>
				<li><a href="%s" class="%s">%s</a></li>
				 %s
			</ul>',
				esc_url( $blog_url ),
				esc_attr( $cat_selected ),
				esc_html__( 'All', 'unero' ),
				$cats
			);
		}

		if ( $output ) {
			echo '<div class="unero-taxs-list">' . implode( "\n", $output ) . '</div>';
		}

	}

endif;

/**
 * Display products link
 *
 * @since 1.0
 */

if ( ! function_exists( 'unero_products_links' ) ) :
	function unero_products_links() {

		if ( ! function_exists( 'is_product' ) ) {
			return;
		}

		if ( ! is_product() ) {
			return;
		}

		$prev_link = '<span class="icon-arrow-left"></span>';
		$next_link = '<span class="icon-arrow-right"></span>';

		?>
		<div class="products-links">
			<?php
			previous_post_link( '<div class="nav-previous">%link</div>', $prev_link );
			next_post_link( '<div class="nav-next">%link</div>', $next_link );
			?>
		</div>
		<?php
	}

endif;

/**
 * Get product image use lazyload
 *
 * @since  1.0
 *
 * @return string
 */
function unero_get_image_html( $post_thumbnail_id, $image_size, $css_class = '', $attributes = false ) {
	global $post;
	$output = '';
	if ( intval( unero_get_option( 'lazyload' ) ) ) {
		$props = wc_get_product_attachment_props( $post_thumbnail_id, $post );
		$image = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );

		if ( $image ) {
			$image_trans = get_template_directory_uri() . '/images/transparent.png';

			if ( $attributes ) {
				$output = sprintf(
					'<img src="%s" data-original="%s" data-lazy="%s" alt="%s" class="lazy %s" width="%s" height="%s" data-large_image_width="%s" data-large_image_height="%s">',
					esc_url( $image_trans ),
					esc_url( $image[0] ),
					esc_url( $image[0] ),
					esc_attr( $props['alt'] ),
					esc_attr( $css_class ),
					esc_attr( $image[1] ),
					esc_attr( $image[2] ),
					esc_attr( $attributes['data-large_image_width'] ),
					esc_attr( $attributes['data-large_image_height'] )
				);
			} else {
				$output = sprintf(
					'<img src="%s" data-original="%s" data-lazy="%s" alt="%s" class="lazy %s" width="%s" height="%s">',
					esc_url( $image_trans ),
					esc_url( $image[0] ),
					esc_url( $image[0] ),
					esc_attr( $props['alt'] ),
					esc_attr( $css_class ),
					esc_attr( $image[1] ),
					esc_attr( $image[2] )
				);
			}

		}
	} else {
		$attributes['class'] = $css_class;
		$output              = wp_get_attachment_image( $post_thumbnail_id, $image_size, false, $attributes );
	}

	return $output;
}

/**
 * Get product size guide
 *
 * @since  1.0
 *
 * @return string
 */

if ( ! function_exists( 'unero_product_size_guide' ) ) :
	function unero_product_size_guide() {
		global $product;
		echo do_shortcode( get_post_meta( $product->get_id(), 'unero_product_size_guide', true ) );
	}

endif;


/**
 * Get product shipping
 *
 * @since  1.0
 *
 * @return string
 */
if ( ! function_exists( 'unero_product_shipping' ) ) :
	function unero_product_shipping() {
		global $product;
		echo do_shortcode( get_post_meta( $product->get_id(), 'unero_product_shipping', true ) );
	}
endif;
/**
 * Get blog meta
 *
 * @since  1.0
 *
 * @return string
 */
function unero_get_post_meta( $meta ) {

	if ( is_home() && ! is_front_page() ) {
		$post_id = get_queried_object_id();

		return get_post_meta( $post_id, $meta, true );
	}

	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$post_id = intval( get_option( 'woocommerce_shop_page_id' ) );

		return get_post_meta( $post_id, $meta, true );
	}

	if ( is_post_type_archive( 'portfolio_project' ) ) {
		$post_id = intval( get_option( 'drf_portfolio_page_id' ) );

		return get_post_meta( $post_id, $meta, true );
	}

	if ( ! is_singular() || is_singular( 'product' ) ) {
		return false;
	}

	return get_post_meta( get_the_ID(), $meta, true );

}

/**
 * Get shop page header
 *
 * @since  1.0
 *
 * @return string
 */
function unero_shop_page_header() {

	$show = true;
	if ( unero_is_catalog() ) {
		if ( function_exists( 'is_shop' ) && is_shop() ) {
			$post_id = intval( get_option( 'woocommerce_shop_page_id' ) );
			if ( get_post_meta( $post_id, 'hide_page_header', true ) ) {
				$show = false;
			}
		}
		if ( ! intval( unero_get_option( 'page_header_shop' ) ) ) {
			$show = false;
		}
	}

	return $show;

}

/**
 * Get current page URL for layered nav items.
 * @return string
 */
function unero_get_page_base_url() {
	if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
		$link = home_url();
	} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
		$link = get_post_type_archive_link( 'product' );
	} elseif ( is_product_category() ) {
		$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
	} elseif ( is_product_tag() ) {
		$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
	} else {
		$queried_object = get_queried_object();
		$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
	}

	return $link;
}

/**
 * Print HTML of currency switcher
 * It requires plugin WooCommerce Currency Switcher installed
 */
if ( ! function_exists( 'unero_currency_switcher' ) ) :
	function unero_currency_switcher( $show_desc = false ) {
		$currency_dd = '';
		if ( class_exists( 'WOOCS' ) ) {
			global $WOOCS;

			$key_cur = 'name';
			if ( $show_desc ) {
				$key_cur = 'description';
			}

			$flow_symbol = intval( unero_get_option( 'flag_symbol' ) );

			$currencies    = $WOOCS->get_currencies();
			$currency_list = array();
			foreach ( $currencies as $key => $currency ) {
				$flag = '';
				if ( $flow_symbol ) {
					$flag = sprintf( '<img src="%s" atl=""/>', esc_url( $currency['flag'] ) );
				}

				if ( $WOOCS->current_currency == $key ) {
					array_unshift(
						$currency_list, sprintf(
							'<li class="actived"><a href="#" class="woocs_flag_view_item woocs_flag_view_item_current" data-currency="%s">%s%s</a></li>',
							esc_attr( $currency['name'] ),
							$flag,
							esc_html( $currency[ $key_cur ] )
						)
					);
				} else {
					$currency_list[] = sprintf(
						'<li><a href="#" class="woocs_flag_view_item" data-currency="%s">%s%s</a></li>',
						esc_attr( $currency['name'] ),
						$flag,
						esc_html( $currency[ $key_cur ] )
					);
				}
			}

			$current_flag = $flow_symbol ? sprintf( '<img src="%s" atl=""/>', esc_url( $currencies[ $WOOCS->current_currency ]['flag'] ) ) : '';

			$currency_dd = sprintf(
				'<span class="current">%s%s%s<span class="toggle-children i-icon arrow_carrot-down"></span></span>' .
				'<ul>%s</ul>',
				unero_get_option( 'currency_flag_pos' ) == 'left' ? $current_flag : '',
				$currencies[ $WOOCS->current_currency ][ $key_cur ],
				unero_get_option( 'currency_flag_pos' ) == 'right' ? $current_flag : '',
				implode( "\n\t", $currency_list )
			);


		}

		return $currency_dd;
	}

endif;

/**
 * Print HTML of language switcher
 * It requires plugin WPML installed
 */
if ( ! function_exists( 'unero_language_switcher' ) ) :
	function unero_language_switcher( $type = 'code' ) {
		$language_dd = '';

		if ( function_exists( 'icl_get_languages' ) ) {
			$languages = icl_get_languages();

			if ( $languages ) {
				$lang_list = array();
				$current   = '';
				foreach ( (array) $languages as $code => $language ) {
					$lang = $code;
					if ( $type == 'name' && $language['translated_name'] ) {
						$lang = $language['translated_name'];
					} elseif ( $type == 'tag' && $language['tag'] ) {
						$lang = $language['tag'];
					}

					if ( ! $language['active'] ) {
						$lang_list[] = sprintf(
							'<li class="%s"><a href="%s">%s</a></li>',
							esc_attr( $code ),
							esc_url( $language['url'] ),
							$lang
						);
					} else {
						$current = $language;
						array_unshift(
							$lang_list, sprintf(
								'<li class="active %s"><a href="%s">%s</a></li>',
								esc_attr( $code ),
								esc_url( $language['url'] ),
								$lang
							)
						);
					}
				}

				$lang = esc_html( $current['language_code'] );
				if ( $type == 'name' && $current['translated_name'] ) {
					$lang = $current['translated_name'];
				} elseif ( $type == 'tag' && $current['tag'] ) {
					$lang = $current['tag'];
				}


				$language_dd = sprintf(
					'<span class="current">%s<span class="toggle-children i-icon arrow_carrot-down"></span></span>' .
					'<ul>%s</ul>',
					$lang,
					implode( "\n\t", $lang_list )
				);
			}
		}

		return $language_dd;
		?>

		<?php
	}

endif;

/**
 * Display socials in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'unero_get_socials_html' ) ) :
	function unero_get_socials_html( $socials_options, $label = false ) {
		$socials = unero_get_socials();
		if ( $socials_options ) {

			printf( '<div class="socials">' );
			if ( $label ) {
				printf( '<label>%s</label>', wp_kses( $label, wp_kses_allowed_html( 'post' ) ) );
			}
			foreach ( $socials_options as $social ) {
				foreach ( $socials as $name => $label ) {
					$link_url = $social['link_url'];
					if ( preg_match( '/' . $name . '/', $link_url ) ) {

						if ( $name == 'google' ) {
							$name = 'googleplus';
						}

						if ( $name == 'vk' ) {
							printf( '<a href="%s" target="_blank" class="font-fa"><i class="social fa fa-%s"></i></a>', esc_url( $link_url ), esc_attr( $name ) );
						} else {
							printf( '<a href="%s" target="_blank"><i class="social social_%s"></i></a>', esc_url( $link_url ), esc_attr( $name ) );
						}

						break;

					}

				}
			}
		}
		printf( '</div>' );
	}

endif;

/**
 * Comment callback function
 *
 * @param object $comment
 * @param array  $args
 * @param int    $depth
 */
function unero_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );

	$avatar = '';
	if ( $args['avatar_size'] != 0 ) {
		$avatar = get_avatar( $comment, $args['avatar_size'] );
	}

	$classes = get_comment_class( empty( $args['has_children'] ) ? '' : 'parent' );
	$classes = $classes ? implode( ' ', $classes ) : $classes;

	$comments = array(
		'comment_parent'      => 0,
		'comment_ID'          => get_comment_ID(),
		'comment_class'       => $classes,
		'comment_avatar'      => $avatar,
		'comment_author_link' => get_comment_author_link(),
		'comment_link'        => get_comment_link( get_comment_ID() ),
		'comment_date'        => get_comment_date(),
		'comment_time'        => get_comment_time(),
		'comment_approved'    => $comment->comment_approved,
		'comment_text'        => get_comment_text(),
		'comment_reply'       => get_comment_reply_link( array_merge( $args, array(
			'add_below' => 'comment',
			'depth'     => $depth,
			'max_depth' => $args['max_depth'],
		) ) ),

	);

	echo unero_comment_template( $comments );

}

/**
 * Comment Template function
 *
 * @param object $comment
 * @param array  $args
 * @param int    $depth
 */
function unero_comment_template( $comments ) {

	$output = array();

	$output[]  = sprintf( '<li id="comment-%s" class="%s">', esc_attr( $comments['comment_ID'] ), esc_attr( $comments['comment_class'] ) );
	$output[]  = sprintf( '<article id="div-comment-%s" class="comment-body">', $comments['comment_ID'] );
	$output [] = sprintf(
		'<header class="comment-meta">' .
		'<div class="comment-author vcard">%s</div>' .
		'</header>',
		$comments['comment_avatar']
	);
	$output[]  = '<div class="comment-content"><div class="comment-metadata">';
	$output[]  = sprintf( '<cite class="fn">%s - </cite>', $comments['comment_author_link'] );
	$date      = sprintf( esc_html__( '%1$s at %2$s', 'unero' ), $comments['comment_date'], $comments['comment_time'] );
	$output[]  = sprintf( '<a href="%s" class="date">%s</a>', esc_url( $comments['comment_link'] ), $date );
	$output[]  = '</div>';
	if ( $comments['comment_approved'] == '0' ) {
		$output[] = sprintf( '<em class="comment-awaiting-moderation">%s</em>', esc_html__( 'Your comment is awaiting moderation.', 'unero' ) );
	} else {
		$output[] = $comments['comment_text'];
	}

	$output[] = '<div class="reply">';
	$output[] = $comments['comment_reply'];

	if ( current_user_can( 'edit_comment', $comments['comment_ID'] ) ) {
		$output[] = sprintf( '<a class="comment-edit-link" href="%s">%s</a>', esc_url( admin_url( 'comment.php?action=editcomment&amp;c=' ) . $comments['comment_ID'] ), esc_html__( 'Edit', 'unero' ) );
	}

	$output[] = '</div></div></article>';

	return implode( ' ', $output );
}

/**
 * Get instagram photo
 *
 * @param string $hashtag
 * @param int    $numbers
 * @param string $title
 * @param string $columns
 */
function unero_instagram_photos( $hashtag, $numbers, $title, $columns, $autoplay, $instagram_access_token = false, $image_size = 'low_resolution' ) {
	global $post;

	if ( ! $instagram_access_token ) {
		$instagram_access_token = unero_get_option( 'unero_instagram_token' );
	}

	if ( empty( $instagram_access_token ) ) {
		return '';
	}


	$url = 'https://api.instagram.com/v1/users/self/media/recent?access_token=' . $instagram_access_token;

	$remote = wp_remote_get( $url );

	if ( is_wp_error( $remote ) ) {
		return esc_html__( 'Unable to communicate with Instagram.', 'unero' );
	}

	if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
		return esc_html__( 'Instagram did not return a 200.', 'unero' );
	}

	$insta_array = json_decode( $remote['body'], true );

	if ( ! $insta_array ) {
		return esc_html__( 'Instagram has returned invalid data.', 'unero' );
	}

	$results = array();

	if ( isset( $insta_array['data'] ) ) {
		$results = $insta_array['data'];
	} else {
		return esc_html__( 'Instagram has returned invalid data.', 'unero' );
	}

	if ( ! is_array( $results ) ) {
		return esc_html__( 'Instagram has returned invalid data.', 'unero' );
	}

	$columns = intval( $columns );

	$output   = array();
	$output[] = '<div class="unero-product-instagram">';
	$output[] = sprintf( '<h2>%s</h2>', wp_kses( $title, wp_kses_allowed_html( 'post' ) ) );
	$output[] = '<ul class="products" data-columns="' . esc_attr( $columns ) . '" data-auto="' . esc_attr( $autoplay ) . '">';

	$count = 0;

	if ( $results ) {

		foreach ( $results as $item ) {
			if ( ! empty( $hashtag ) && isset( $item['tags'] ) ) {
				if ( ! in_array( $hashtag, $item['tags'] ) ) {
					continue;
				}
			}

			$image_link = $item['images'][ $image_size ]['url'];
			$image_url  = $item['link'];

			$image_html  = '';
			$image_trans = get_template_directory_uri() . '/images/transparent.png';
			if ( intval( unero_get_option( 'lazyload' ) ) ) {
				$image_html = sprintf( '<img src="%s" data-original="%s" data-lazy="%s" alt="%s" class="lazy">', esc_url( $image_trans ), esc_url( $image_link ), esc_url( $image_link ), esc_attr( '' ) );
			} else {
				$image_html = sprintf( '<img src="%s" alt="%s">', esc_url( $image_link ), esc_attr( '' ) );
			}

			$output[] = '<li class="product">' . '<a class="insta-item" href="' . esc_url( $image_url ) . '" target="_blank">' . $image_html . '<i class="social_instagram"></i></a>' . '</li>' . "\n";
			$count++;
			$numbers = intval( $numbers );
			if ( $numbers > 0 ) {
				if ( $count == $numbers ) {
					break;
				}
			}
		}
	} else {
		$output[] = sprintf( '<li>%s</li>', esc_html__( 'No Result found.', 'unero' ) );
	}

	$output[] = '</ul></div>';

	return implode( ' ', $output );
}