<?php
/**
 * Hooks for importer
 *
 * @package Unero
 */


/**
 * Importer the demo content
 *
 * @since  1.0
 *
 */
function unero_importer() {
	return array(
		array(
			'name'       => 'Home Video Banner',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/video-banner/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/video-banner/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Video Banner',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio'
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Parallax',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/parallax/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/parallax/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Parallax',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio'
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Product Landing',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/landing/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/landing/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Product Landing',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio'
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Full Width',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/full-width/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/full-width/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Shop',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio'
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Best Selling',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/best-selling/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/best-selling/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/best-selling/widgets.wie',
			'pages'      => array(
				'front_page' => 'Shop',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Recent Products',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/recent/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/recent/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/recent/widgets.wie',
			'pages'      => array(
				'front_page' => 'Shop',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Boxed',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/boxed/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/boxed/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Boxed',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Carousel',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/carousel/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/carousel/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Carousel',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Category',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/category/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/category/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Category',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Grid Background',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/grid-background/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/grid-background/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/grid-background/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Grid Background',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),

		),
		array(
			'name'       => 'Home Minimal',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/minimal/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/minimal/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Minimal',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Modern',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/modern/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/modern/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Modern',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Slider',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/slider/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/slider/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Slider',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Instagram',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/instagram/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/instagram/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Instagram',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Collection',
			'preview'    => 'http://demo2.drfuri.com/soo-importer/unero/collection/preview.jpg',
			'content'    => 'http://demo2.drfuri.com/soo-importer/unero/demo-content.xml',
			'customizer' => 'http://demo2.drfuri.com/soo-importer/unero/collection/customizer.dat',
			'widgets'    => 'http://demo2.drfuri.com/soo-importer/unero/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Collection',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 480,
					'height' => 480,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),

	);
}

add_filter( 'soo_demo_packages', 'unero_importer', 30 );
