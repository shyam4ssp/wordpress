<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */


/**
 * Enqueue script for handling actions with meta boxes
 *
 * @since 1.0
 *
 * @param string $hook
 */
function unero_meta_box_scripts( $hook ) {
	wp_enqueue_style( 'unero-admin', get_template_directory_uri() . '/css/backend/admin.css', array(), '20170106' );
	// Detect to load un-minify scripts when WP_DEBUG is enable
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_script( 'unero-meta-boxes', get_template_directory_uri() . "/js/backend/meta-boxes.js", array( 'jquery' ), '20181214', true );
	}
}

add_action( 'admin_enqueue_scripts', 'unero_meta_box_scripts' );

/**
 * Registering meta boxes
 *
 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
 *
 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 *
 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
 *
 * @return array All registered meta boxes
 */
function unero_register_meta_boxes( $meta_boxes ) {
	// Post format's meta box
	$meta_boxes[] = array(
		'id'       => 'post-format-settings',
		'title'    => esc_html__( 'Format Details', 'unero' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Gallery', 'unero' ),
				'id'    => 'images',
				'type'  => 'image_advanced',
				'class' => 'gallery',
			),
			array(
				'name'  => esc_html__( 'Audio', 'unero' ),
				'id'    => 'audio',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'audio',
			),
			array(
				'name'  => esc_html__( 'Video', 'unero' ),
				'id'    => 'video',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'video',
			),
		),
	);

	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'display-settings',
		'title'    => esc_html__( 'Display Settings', 'unero' ),
		'pages'    => array( 'post', 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Layout', 'unero' ),
				'id'   => 'heading_layout',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Custom Sidebar', 'unero' ),
				'id'   => 'custom_sidebar',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'    => esc_html__( 'Sidebar', 'unero' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'class'   => 'custom-layout',
				'options' => array(
					'full-content'    => get_template_directory_uri() . '/images/sidebars/empty.png',
					'sidebar-content' => get_template_directory_uri() . '/images/sidebars/single-left.png',
					'content-sidebar' => get_template_directory_uri() . '/images/sidebars/single-right.png',
				),
			),
		),
	);

	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'page-header-settings',
		'title'    => esc_html__( 'Page Header Settings', 'unero' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Page Header', 'unero' ),
				'id'    => 'heading_page_header',
				'type'  => 'heading',
				'class' => 'hide-homepage',
			),
			array(
				'name'  => esc_html__( 'Hide Page Header', 'unero' ),
				'id'    => 'hide_page_header',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name'  => esc_html__( 'Hide Page Title', 'unero' ),
				'id'    => 'hide_page_title',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name'  => esc_html__( 'Hide Breadcrumb', 'unero' ),
				'id'    => 'hide_breadcrumb',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name' => esc_html__( 'Custom Page Header', 'unero' ),
				'id'   => 'custom_page_header',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'    => esc_html__( 'Page Header Layout', 'unero' ),
				'id'      => 'page_header_layout',
				'type'    => 'select',
				'options' => array(
					1 => esc_html__( 'Layout 1', 'unero' ),
					2 => esc_html__( 'Layout 2', 'unero' ),
				),
			),
			array(
				'name'             => esc_html__( 'Background Image', 'unero' ),
				'id'               => 'page_bg',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'std'              => false,
				'class'            => 'show-page-header-2',
			),
			array(
				'name'  => esc_html__( 'Parallax', 'unero' ),
				'id'    => 'page_parallax',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'show-page-header-2',
			),
		),
	);

	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'portfolio-display-settings',
		'title'    => esc_html__( 'Display Settings', 'unero' ),
		'pages'    => array( 'portfolio_project' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Page Header', 'unero' ),
				'id'   => 'heading_page_header',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Hide Page Header', 'unero' ),
				'id'   => 'hide_page_header',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name' => esc_html__( 'Custom Page Header', 'unero' ),
				'id'   => 'custom_page_header',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'    => esc_html__( 'Page Header Layout', 'unero' ),
				'id'      => 'page_header_layout',
				'type'    => 'select',
				'options' => array(
					1 => esc_html__( 'Layout 1', 'unero' ),
					2 => esc_html__( 'Layout 2', 'unero' ),
				),
			),
			array(
				'name'             => esc_html__( 'Background Image', 'unero' ),
				'id'               => 'portfolio_bg',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'std'              => false,
				'class'            => 'show-page-header-2',
			),
			array(
				'name'  => esc_html__( 'Parallax', 'unero' ),
				'id'    => 'portfolio_parallax',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'show-page-header-2',
			),
			array(
				'name'  => esc_html__( 'Hide Breadcrumb', 'unero' ),
				'id'    => 'hide_breadcrumb',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'show-page-header-1',
			),
		),
	);

	$product_custom_tab1 = get_theme_mod( 'custom_product_tab_1', esc_html__( 'Size Guide', 'unero' ) );
	$meta_boxes[]        = array(
		'id'       => 'product-size-guide',
		'title'    => $product_custom_tab1,
		'pages'    => array( 'product' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'name' => '',
				'id'   => 'unero_product_size_guide',
				'type' => 'WYSIWYG',
				'std'  => '',
			),
		)
	);

	$product_custom_tab2 = get_theme_mod( 'custom_product_tab_2', esc_html__( 'Shipping', 'unero' ) );
	$meta_boxes[]        = array(
		'id'       => 'product-shipping',
		'title'    => $product_custom_tab2,
		'pages'    => array( 'product' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'name' => '',
				'id'   => 'unero_product_shipping',
				'type' => 'WYSIWYG',
				'std'  => '',
			),
		)
	);

	$meta_boxes[] = array(
		'id'       => 'product-videos',
		'title'    => esc_html__( 'Product Video', 'unero' ),
		'pages'    => array( 'product' ),
		'context'  => 'side',
		'priority' => 'low',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Video URL', 'unero' ),
				'id'   => 'video_url',
				'type' => 'oembed',
				'std'  => false,
				'desc' => esc_html__( 'Enter URL of Youtube or Vimeo or specific filetypes such as mp4, m4v, webm, ogv, wmv, flv.', 'unero' ),
			),
			array(
				'name' => esc_html__( 'Video Width(px)', 'unero' ),
				'id'   => 'video_width',
				'type' => 'number',
				'desc' => esc_html__( 'Enter the width of video.', 'unero' ),
				'std'  => 1024
			),
			array(
				'name' => esc_html__( 'Video Height(px)', 'unero' ),
				'id'   => 'video_height',
				'type' => 'number',
				'desc' => esc_html__( 'Enter the height of video.', 'unero' ),
				'std'  => 768
			),
			array(
				'id'   => 'video_urls_custom_html',
				'type' => 'custom_html',
				'std'  => '<div style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px"></div>',
			),
			array(
				'name'             => esc_html__( 'Video Thumbnail', 'unero' ),
				'id'               => 'video_thumbnail',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'std'              => false,
				'desc'             => esc_html__( 'Add video thumbnail', 'unero' )
			),
			array(
				'id'   => 'video_urls_custom_html2',
				'type' => 'custom_html',
				'std'  => '<div style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px"></div>',
			),
			array(
				'name' => esc_html__( 'Video Position', 'unero' ),
				'id'   => 'video_position',
				'type' => 'number',
				'desc' => esc_html__( 'Enter video position in product gallery.', 'unero' ),
				'std'  => 2,
				'min'  => 2,
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'unero_register_meta_boxes' );

function unero_admin_notice__success() {

	if ( ! function_exists('unero_vc_addons_init') ) {
		return;
	}

	$versions = get_plugin_data( WP_PLUGIN_DIR . '/unero-vc-addons/unero-vc-addons.php' );
	if ( version_compare( $versions['Version'], '1.1.3', '>' ) ) {
	    return;
	}
	?>
    <div class="notice notice-info is-dismissible">
        <p>
            <strong><?php esc_html_e( 'The Unero Addons plugin needs to be updated to 1.1.4 to ensure maximum compatibility with this theme. Go to Plugins > Unero Addons to update it.', 'unero' ); ?></strong>
        </p>
    </div>
	<?php
}

add_action( 'admin_notices', 'unero_admin_notice__success' );