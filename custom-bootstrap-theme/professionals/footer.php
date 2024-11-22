<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package professionals
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
	<div class="wrapper">
		<div class="row">
			<div class="col-sm-6 col-md-4 footer-1">
			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<div class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
			<?php endif; ?>
			</div>
			<div class="col-sm-6 col-md-2 footer-2">
			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<div class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>
			<?php endif; ?>
			</div>
			<div class="col-sm-6 col-md-2 footer-3">
			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<div class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>
			<?php endif; ?>
			</div>
			<div class="col-sm-6 col-md-4 footer-4">
			<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
				<div class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-4' ); ?>
				</div>
			<?php endif; ?>
			</div>
		</div>
	</div>
		<div class="text-center site-info">
		<div class="wrapper">
		<p>© Copyright @ 2019 Professionals.club All Rights Reserved | <a href="https://professionals.club/dev/terms-and-condition">Terms of Use</a> | <a href="https://professionals.club/dev/privacy-policy">Privacy Policy</a></p>
		</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
<script>
	jQuery('.search-menu').click(function(){
		jQuery('.search-wrap').fadeIn('slow');
	});
		jQuery('.close-search').click(function(){
			jQuery('.search-wrap').fadeOut('slow');
		});
	jQuery('.button-menu').click(function(){
		jQuery(this).toggleClass('open');
		jQuery('.header-right-nav').toggleClass('open');
		jQuery('.header-right-nav').animate({height:"toggle"});
	});
</script>
 <!--Lazy loading-->
 <script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
  var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));;

  if ("IntersectionObserver" in window && "IntersectionObserverEntry" in window && "intersectionRatio" in window.IntersectionObserverEntry.prototype) {
    let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          let lazyImage = entry.target;
          lazyImage.src = lazyImage.dataset.src;
          lazyImage.srcset = lazyImage.dataset.srcset;
          lazyImage.classList.remove("lazy");
          lazyImageObserver.unobserve(lazyImage);
        }
      });
    });

    lazyImages.forEach(function(lazyImage) {
      lazyImageObserver.observe(lazyImage);
    });
  }
});
</script>
<script>
// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("masthead");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > 70) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
} 
</script>
<script>
jQuery( '.main-navigation .menu-item-has-children' ).prepend( jQuery( '<span class="down"></span>' ) );
jQuery('.down').click(function(){
	jQuery(this).siblings('a + .sub-menu').animate({height:"toggle"});
});
</script>
<?php wp_footer(); ?>

</body>
</html>
