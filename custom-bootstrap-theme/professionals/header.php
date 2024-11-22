<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package professionals
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<!--<a class="skip-link screen-reader-text" href="#content"><?php// esc_html_e( 'Skip to content', 'professionals' ); ?></a>-->

	<header id="masthead" class="site-header">
		<div class="wrapper">
		<ul class="float-right button-or-search">
		<li class="float-right button-menu">
			<span></span>
			<span></span>
			<span></span>
		</li>
			<li class="float-left top-search">
					<div class="search-menu">
					</div>
				</li>
		</ul>
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$professionals_description = get_bloginfo( 'description', 'display' );
			if ( $professionals_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $professionals_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
	<div class="float-right header-right-nav">
		<div class="header-right">
			<ul>
				<li class="top-search">
					<div class="search-menu">
					</div>
				</li>
				<li><a href="#">Log in</a></li>
				<li><a href="#">Sign up</a></li>
			</ul>
		</div>
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'professionals' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
		</div>
		</div><!---Wrapper-->
	</header><!-- #masthead -->
<div class="search-wrap">
					<div class="open-search">
					<span class="close-search">&times;</span>
						<?php get_search_form(); ?>
					</div>
					</div>
	<div id="content" class="site-content">
