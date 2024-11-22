(function ($) {
    'use strict';

    var unero = unero || {};
    unero.init = function () {
        unero.$body = $(document.body),
            unero.$window = $(window),
            unero.$header = $('#masthead'),
            unero.ajaxXHR = null;

        this.animationPage();
        this.mobileMenu();
        this.stickyHeader();
        this.fixedFooter();
        this.addToCartAjax();
        this.removeCartItem();
        this.blogLayout();
        this.loadingAjax();
        this.viewPort();
        this.fitVideo();
        this.postImagesLightbox();
        this.lazyLoad();
        this.toolTipIcon();
        this.productThumbnailSlick();
        this.productGallery();
        this.productQuantity();
        this.productVatiation();
        this.singleProductSlider();
        this.shopView();
        this.filterAjax();
        this.showFilterContent();
        this.shopLayout();
        this.pageHeader();
        this.canvasPanel();
        this.instanceSearch();
        this.toggleModal();
        this.menuSideBar();
        this.productQuickView();
        this.productAttribute();
        this.portfolioCarousel();
        this.instagramSlider();
        this.animationProduct();
        this.unSingleImage();
        this.backToTop();
        this.loginTab();
        this.updateCountWishlist();
        this.productCategoriesWidget();
        this.resizeProductThumbnail();
        this.productBigImageSlick();
    };

    // Back to top scroll
    unero.backToTop = function () {
        var $scrollTop = $('#scroll-top');
        unero.$window.scroll(function () {
            if (unero.$window.scrollTop() > unero.$window.height()) {
                $scrollTop.addClass('show-scroll');
            } else {
                $scrollTop.removeClass('show-scroll');
            }
        });

        // Scroll effect button top
        $scrollTop.on('click', function (event) {
            event.preventDefault();
            $('html, body').stop().animate({
                    scrollTop: 0
                },
                1200
            );
        });
    };

    unero.loginTab = function () {
        $('.unero-tabs').find('.tabs-nav').on('click', 'a', function (e) {
            e.preventDefault();

            var $tab = $(this),
                index = $tab.parent().index(),
                $tabs = $tab.closest('.unero-tabs'),
                $panels = $tabs.find('.tabs-panel');

            if ($tab.hasClass('active')) {
                return;
            }

            $tabs.find('.tabs-nav a').removeClass('active');
            $tab.addClass('active');
            $panels.removeClass('active');
            $panels.filter(':eq(' + index + ')').addClass('active');
        });
    };

    unero.animationProduct = function () {

        if (uneroData.animation_product == '0') {
            return;
        }

        var $elements = unero.$body.find('#un-shop-content .product-inner');

        $elements.removeAttr('data-sr-id').removeAttr('style');

        var config = {
            viewFactor: 0.15,
            duration: 1000,
            scale: 0.9,
            opacity: 1,
            easing: 'ease'
        };
        window.sr = new ScrollReveal(config);

        var block = {
            reset: true,
            viewOffset: {top: 64}
        };

        sr.reveal($elements, block)
    };


    // animation redirect page
    unero.animationPage = function () {
        var $unloader = $('#un-before-unloader'),
            without_link = false;
        unero.$body.on('click', 'a', function () {
            without_link = false;
            if ($(this).hasClass('un-without-preloader')) {
                without_link = true;
            }
        });

        unero.$window.on('beforeunload', function (e) {
            if (without_link) {
                return;
            }
            $unloader.removeClass('out').fadeIn(500, function () {
                $unloader.addClass('loading');
            });
        });
        unero.$window.on('pageshow', function () {
            $unloader.fadeOut(100, function () {
                $unloader.addClass('out loading');
            });
        });

    };

    // Mobile Menu
    unero.mobileMenu = function () {
        var $mobileMenu = $('#primary-mobile-nav');
        unero.$header.on('click', '#un-navbar-toggle', function (e) {
            e.preventDefault();
            $mobileMenu.toggleClass('open');
            unero.$body.toggleClass('open-canvas-panel');
        });

        $mobileMenu.find('.menu .menu-item-has-children > a').prepend('<span class="toggle-menu-children"><i class="icon-plus"></i> </span>');

        if (unero.$body.hasClass('submenus-mobile-icon')) {
            $mobileMenu.on('click', '.toggle-menu-children, .menu-item-has-children > span', function (e) {
                e.preventDefault();
                openSubMenus($(this));

            });
        } else {
            $mobileMenu.on('click', '.menu-item-has-children > a, .menu-item-has-children > span', function (e) {
                e.preventDefault();
                openSubMenus($(this));

            });
        }


        $mobileMenu.on('click', '.close-canvas-mobile-panel', function (e) {
            e.preventDefault();
            unero.closeCanvasPanel();
        });

        unero.$window.on('resize', function () {
            if (unero.$window.width() > 991) {
                if ($mobileMenu.hasClass('open')) {
                    $mobileMenu.removeClass('open');
                    unero.$body.removeClass('open-canvas-panel');
                }
            }
        });

        function openSubMenus($menu) {
            $menu.closest('li').siblings().find('ul').slideUp();
            $menu.closest('li').siblings().removeClass('active');
            $menu.closest('li').siblings().find('li').removeClass('active');

            $menu.closest('li').children('ul').slideToggle();
            $menu.closest('li').toggleClass('active');
        }
    };

    // Remove cart item
    unero.removeCartItem = function () {

        var $cartPanel = $('#cart-panel');

        $cartPanel.on('click', '.remove', function (e) {
            e.preventDefault();
            $cartPanel.addClass('loading');
            var currentURL = $(this).attr('href');
            $.ajax({
                url: uneroData.ajax_url,
                dataType: 'json',
                method: 'post',
                data: {
                    action: 'unero_remove_mini_cart_item',
                    nonce: uneroData.nonce,
                    item: $(this).data('item_key')
                },
                error: function (response) {
                    window.location = currentURL;
                },
                success: function (response) {

                    if (!response) {
                        window.location = currentURL;
                        return;
                    }

                    if (response.data == '0') {
                        window.location = currentURL;
                        return;
                    }

                    $(document.body).trigger('updated_wc_div');
                    $(document.body).on('wc_fragments_refreshed', function () {
                        $cartPanel.removeClass('loading');
                    });
                }
            });
        });


    };

    // Blog isotope
    unero.blogLayout = function () {
        if (!$('#unero-site-content').hasClass('blog-layout-masonry')) {
            return;
        }
        unero.$body.imagesLoaded(function () {
            $('#unero-site-content').find('.unero-post-list').isotope({
                itemSelector: '.un-post-item',
                layoutMode: 'masonry'
            });

        });
    };

    // Shop Layout
    unero.shopLayout = function () {

        if (!unero.$body.hasClass('catalog-board-content')) {
            return;
        }
        $('#un-shop-content').find('ul.products').imagesLoaded(function () {
            $('#un-shop-content').find('ul.products').isotope({
                itemSelector: 'li.product',
                layoutMode: 'masonry'
            });
        });

    };

    // Loading Ajax
    unero.viewPort = function () {
        unero.$window.on('scroll', function () {
            if (unero.$body.find('#unero-infinite-loading').is(':in-viewport')) {
                unero.$body.find('#unero-infinite-loading.nav-previous a').trigger('click');
            }

            if (unero.$body.find('#unero-shop-infinite-loading').is(':in-viewport')) {
                unero.$body.find('#unero-shop-infinite-loading a.next').trigger('click');
            }


            if (unero.$body.find('#un-shop-footer').is(':in-viewport')) {
                $('.shop-bottombar').find('.un-filter').addClass('not-viewport');
            } else {
                $('.shop-bottombar').find('.un-filter').removeClass('not-viewport');
            }

        }).trigger('scroll');
    };

    // Loading Ajax
    unero.loadingAjax = function () {

        // Blog page
        unero.$body.on('click', '#unero-infinite-loading a', function (e) {
            e.preventDefault();

            if ($(this).data('requestRunning')) {
                return;
            }

            $(this).data('requestRunning', true);


            var $posts = $(this).parents('.navigation').prev('#unero-site-content'),
                $postList = $posts.find('.unero-post-list'),
                $pagination = $(this).parents('.navigation');

            $.get(
                $(this).attr('href'),
                function (response) {
                    var content = $(response).find('.unero-post-list').children('.un-post-item'),
                        $pagination_html = $(response).find('.navigation').html();

                    $pagination.html($pagination_html);


                    if ($posts.hasClass('blog-layout-masonry')) {
                        content.imagesLoaded(function () {
                            $postList.append(content).isotope('insert', content);
                            $pagination.find('a').data('requestRunning', false);
                            unero.postImagesLightbox();
                        });
                    } else {
                        $postList.append(content);
                        $pagination.find('a').data('requestRunning', false);
                        unero.postImagesLightbox();
                    }

                }
            );
        });

        // Shop Page
        unero.$body.on('click', '#unero-shop-infinite-loading a.next', function (e) {
            e.preventDefault();

            if ($(this).data('requestRunning')) {
                return;
            }

            $(this).data('requestRunning', true);

            var $products = $(this).closest('.woocommerce-pagination').prev('.products'),
                $pagination = $(this).closest('.woocommerce-pagination');

            $.get(
                $(this).attr('href'),
                function (response) {
                    var content = $(response).find('ul.products').children('li.product'),
                        $pagination_html = $(response).find('.woocommerce-pagination').html();


                    $pagination.html($pagination_html);
                    if (unero.$body.hasClass('catalog-board-content')) {
                        content.imagesLoaded(function () {
                            $products.isotope('insert', content);
                            $pagination.find('.page-numbers.next').data('requestRunning', false);
                            $(document.body).trigger('unero_shop_ajax_loading_success');

                        });
                    } else {
                        $products.append(content);
                        $pagination.find('.page-numbers.next').data('requestRunning', false);
                        $(document.body).trigger('unero_shop_ajax_loading_success');
                    }

                    if (!$pagination.find('li .page-numbers').hasClass('next')) {
                        $pagination.addClass('loaded');
                    }
                }
            );
        });

        // Shop loading suceess
        $(document.body).on('unero_shop_ajax_loading_success', function () {
            unero.animationProduct();
            unero.lazyLoad();
            unero.toolTipIcon();

        });
    };

    // Product Attribute
    unero.productAttribute = function () {
        unero.$body.on('click', '.un-swatch-variation-image', function (e) {
            e.preventDefault();
            $(this).siblings('.un-swatch-variation-image').removeClass('selected');
            $(this).addClass('selected');
            var imgSrc = $(this).data('src'),
                imgSrcSet = $(this).data('src-set'),
                $mainImages = $(this).parents('li.product').find('.un-product-thumbnail > a'),
                $image = $mainImages.find('img').first(),
                imgWidth = $image.first().width(),
                imgHeight = $image.first().height();

            $mainImages.addClass('image-loading');
            $mainImages.css({
                width: imgWidth,
                height: imgHeight,
                display: 'block'
            });

            $image.attr('src', imgSrc);

            if (imgSrcSet) {
                $image.attr('srcset', imgSrcSet);
            }

            $image.load(function () {
                $mainImages.removeClass('image-loading');
                $mainImages.removeAttr('style');
            });
        });
    };

    /**
     * FitVideo
     */
    unero.fitVideo = function () {
        // Fit Video
        $('.entry-format.format-video').fitVids({customSelector: 'iframe'});

        $('.single .entry-content').fitVids({customSelector: 'iframe, video'});

    };

    /**
     * LazyLoad
     */
    unero.lazyLoad = function () {
        unero.$body.find('img.lazy').lazyload();
    };


    /**
     * Show photoSwipe lightbox for blog gallery
     */
    unero.postImagesLightbox = function () {

        // format gallery
        var $gallery = $('#unero-site-content, .single-post').find('.entry-format.format-gallery');
        $gallery.find('a').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        // format video
        var videos = $('#unero-site-content').find('.entry-format.format-video');
        videos.find('a').magnificPopup({
            type: 'iframe'
        });

    };

    // tooltip icon
    unero.toolTipIcon = function () {

        if (uneroData.tooltips == '0') {
            return;
        }

        $('.yith-wcwl-add-to-wishlist .add_to_wishlist').attr('data-original-title', $('.yith-wcwl-add-to-wishlist .add_to_wishlist').html()).attr('rel', 'tooltip');
        $('.yith-wcwl-wishlistaddedbrowse a').attr('data-original-title', $('.yith-wcwl-wishlistaddedbrowse a').html()).attr('rel', 'tooltip');
        $('.yith-wcwl-wishlistexistsbrowse a').attr('data-original-title', $('.yith-wcwl-wishlistexistsbrowse a').html()).attr('rel', 'tooltip');
        $('[rel=tooltip]').tooltip({offsetTop: -15});
    };

    // Product Thumbail Slick
    unero.productThumbnailSlick = function () {
        var $thumbnails = $('#product-thumbnails').find('.thumbnails'),
            $images = $('#product-images'),
            vertical = false;

        if (uneroData.product_zoom === '1') {
            $images.find('.photoswipe').each(function () {
                $(this).zoom({
                    url: $(this).attr('href'),
                    touch: false
                });

            });
        }

        if (unero.$body.hasClass('product-page-layout-6')) {
            return;
        }

        if (uneroData.thumbnail_carousel != '1') {
            $images.imagesLoaded(function () {
                $images.addClass('loaded');
            });

            return false;
        }

        if (uneroData.thumbnail_vertical == '1') {
            vertical = true;
        }

        // Product thumnails and featured image slider
        $images.not('.slick-initialized').slick({
            rtl: (uneroData.rtl === 'true'),
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: false,
            asNavFor: $thumbnails,
            prevArrow: '<span class="icon-chevron-left slick-prev-arrow"></span>',
            nextArrow: '<span class="icon-chevron-right slick-next-arrow"></span>'
        });

        var slidesToShow = parseInt(uneroData.thumbnail_columns);
        if (unero.$body.hasClass('product-page-layout-2')) {
            if ($thumbnails.find('img').length < slidesToShow) {
                slidesToShow = $thumbnails.find('img').length;
            }
        }

        $thumbnails.not('.slick-initialized').slick({
            rtl: (uneroData.rtl === 'true'),
            slidesToShow: slidesToShow,
            slidesToScroll: 1,
            asNavFor: $images,
            focusOnSelect: true,
            vertical: vertical,
            infinite: false,
            prevArrow: '<span class="icon-chevron-up slick-prev-arrow"></span>',
            nextArrow: '<span class="icon-chevron-down slick-next-arrow"></span>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 479,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
            ]
        });

        $images.imagesLoaded(function () {
            $images.addClass('loaded');
        });

        $(document).on('found_variation', 'form.variations_form', function (event, variation) {
            event.preventDefault();
            $('#product-images').slick('slickGoTo', 0, true);

            if (uneroData.product_zoom === '1') {
                $('#product-images').find('.photoswipe').each(function () {
                    $(this).zoom({
                        url: $(this).attr('href'),
                        touch: false
                    });

                });
            }

        }).on('reset_image', function () {
            $('#product-images').slick('slickGoTo', 0, true);

            if (uneroData.product_zoom === '1') {
                $('#product-images').find('.photoswipe').each(function () {
                    $(this).zoom({
                        url: $(this).attr('href'),
                        touch: false
                    });

                });
            }
        });
    };

    // Product Thumbail Slick
    unero.productBigImageSlick = function () {
        var $images = $('#product-images');

        if (!unero.$body.hasClass('product-page-layout-6')) {
            return;
        }

        // Product thumnails and featured image slider

        var slidesToShow = 3,
            imgCount = $images.find('.woocommerce-product-gallery__image').length;

        if (imgCount == 3) {
            slidesToShow = 2;
        } else if (imgCount <= 2) {
            slidesToShow = 1;
        }

        $images.not('.slick-initialized').slick({
            rtl: (uneroData.rtl === 'true'),
            slidesToShow: slidesToShow,
            slidesToScroll: 1,
            centerMode: true,
            variableWidth: true,
            infinite: false,
            prevArrow: '<span class="icon-chevron-left slick-prev-arrow"></span>',
            nextArrow: '<span class="icon-chevron-right slick-next-arrow"></span>',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerMode: false,
                        variableWidth: false
                    }
                }
            ]
        });

        $images.slick('slickGoTo', 1);

        $images.imagesLoaded(function () {
            $images.addClass('loaded');
        });

        $(document).on('found_variation', 'form.variations_form', function (event, variation) {
            event.preventDefault();
            $images.slick('slickGoTo', 0, true);

        }).on('reset_image', function () {
            $images.slick('slickGoTo', 0, true);
        });
    };

    /**
     * Show photoSwipe lightbox for unero single image
     */
    unero.productGallery = function () {
        var $images = $('#product-images');
        if (uneroData.product_images_lightbox == '0') {
            $images.on('click', 'a.photoswipe', function () {
                return false;
            });
            return;
        }

        if ('no' == uneroData.lightbox) {
            $images.on('click', 'a.photoswipe', function () {
                return false;
            });
            return;
        }

        if (!$images.length) {
            return;
        }

        var $links = $images.find('a.photoswipe');

        $images.on('click', 'a.photoswipe', function (e) {
            e.preventDefault();

            var items = [];

            $links.each(function () {
                var $a = $(this);
                if ($a.hasClass('video')) {
                    items.push({
                        html: $a.data('href')
                    });

                } else {
                    items.push({
                        src: $a.attr('href'),
                        w: $a.find('img').attr('data-large_image_width'),
                        h: $a.find('img').attr('data-large_image_height')
                    });
                }

            });

            var index = $links.index($(this)),
                options = {
                    index: index,
                    bgOpacity: 0.85,
                    showHideOpacity: true,
                    mainClass: 'pswp--minimal-dark',
                    barsSize: {top: 0, bottom: 0},
                    captionEl: false,
                    fullscreenEl: false,
                    shareEl: false,
                    tapToClose: true,
                    tapToToggleControls: false
                };

            var lightBox = new PhotoSwipe(document.getElementById('pswp'), window.PhotoSwipeUI_Default, items, options);
            lightBox.init();

            lightBox.listen('close', function () {
                $('#pswp .video-wrapper').find('iframe').each(function () {
                    $(this).attr('src', $(this).attr('src'));
                });

                $('#pswp .video-wrapper').find('video').each(function () {
                    $(this)[0].pause();
                });
            });
        });
    };


    /**
     * Show photoSwipe lightbox for product images
     */
    unero.unSingleImage = function () {
        var $images = $('.unero-single-image ');

        if (!$images.length) {
            return;
        }

        if ('no' == uneroData.lightbox) {
            $images.on('click', 'a.photoswipe', function () {
                return false;
            });
            return;
        }

        var $links = $images.find('a.photoswipe');
        var items = [];

        $links.each(function () {
            var $a = $(this);
            items.push({
                src: $a.attr('href'),
                w: $a.data('width'),
                h: $a.data('height')
            });

        });

        $images.on('click', 'a.photoswipe', function (e) {
            e.preventDefault();

            var index = $links.index($(this)),
                options = {
                    index: index,
                    bgOpacity: 0.85,
                    showHideOpacity: true,
                    mainClass: 'pswp--minimal-dark',
                    barsSize: {top: 0, bottom: 0},
                    captionEl: false,
                    fullscreenEl: false,
                    shareEl: false,
                    tapToClose: true,
                    tapToToggleControls: false
                };

            var lightBox = new PhotoSwipe(document.getElementById('pswp'), window.PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    };

    /**
     * Change product quantity
     */
    unero.productQuantity = function () {
        unero.$body.on('click', '.quantity .increase, .quantity .decrease', function (e) {
            e.preventDefault();

            var $this = $(this),
                $qty = $this.siblings('.qty'),
                current = parseInt($qty.val(), 10),
                min = parseInt($qty.attr('min'), 10),
                max = parseInt($qty.attr('max'), 10);

            min = min ? min : 1;
            max = max ? max : current + 1;

            if ($this.hasClass('decrease') && current > min) {
                $qty.val(current - 1);
                $qty.trigger('change');
            }
            if ($this.hasClass('increase') && current < max) {
                $qty.val(current + 1);
                $qty.trigger('change');
            }
        });
    };

    // Style Variation
    unero.productVatiation = function () {
        // soopas_variation_swatches_form
        unero.$body.on('tawcvs_initialized', function () {
            $('.variations_form').unbind('tawcvs_no_matching_variations');
            $('.variations_form').on('tawcvs_no_matching_variations', function (event, $el) {
                event.preventDefault();
                $el.addClass('selected');

                $('.variations_form').find('.woocommerce-variation.single_variation').show();
                if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                    $('.variations_form').find('.single_variation').slideDown(200).html('<p>' + wc_add_to_cart_variation_params.i18n_no_matching_variations_text + '</p>');
                }
            });

        });

        $('.variations_form').find('td.value').each(function () {
            if (!$(this).find('.variation-selector').hasClass('hidden')) {
                $(this).addClass('show-select');
            } else {
                $(this).prev().addClass('show-label');
            }
        });
    };

    // Add to cart ajax
    unero.addToCartAjax = function () {

        if (uneroData.product_add_to_cart_ajax == '0') {
            return;
        }

        if (unero.$body.find('div.product').hasClass('product-type-external')) {
            return;
        }


        unero.$body.find('form.cart').on('click', '.single_add_to_cart_button', function (e) {
            e.preventDefault();

            if ($(this).hasClass('disabled')) {
                return;
            }

            var $cartForm = $(this).closest('form.cart'),
                $singleBtn = $(this);
            $singleBtn.addClass('loading');

            if (!$singleBtn.hasClass('loading')) {
                return;
            }

            var formdata = $cartForm.serializeArray(),
                currentURL = window.location.href,
                valueID = $singleBtn.attr('value');

            if (typeof valueID !== "undefined" && valueID !== false) {
                var cartid = {
                    name: 'add-to-cart',
                    value: valueID
                };
                formdata.push(cartid);
            }

            $.ajax({
                url: window.location.href,
                method: 'post',
                data: formdata,
                error: function () {
                    window.location = currentURL;
                },
                success: function (response) {
                    if (!response) {
                        window.location = currentURL;
                    }


                    if (typeof wc_add_to_cart_params !== 'undefined') {
                        if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
                            window.location = wc_add_to_cart_params.cart_url;
                            return;
                        }
                    }

                    $(document.body).trigger('updated_wc_div');
                    $(document.body).on('wc_fragments_refreshed', function () {

                        $singleBtn.removeClass('loading');
                        if (uneroData.product_open_cart_mini == '1') {
                            unero.$body.toggleClass('display-cart');
                            unero.openCanvasPanel($('#cart-panel'));
                        }
                    });

                }
            });

        });

    };

    //related & upsell slider
    unero.singleProductSlider = function () {

        if (!unero.$body.hasClass('single-product')) {
            return;
        }
        var $upsells = unero.$body.find('.up-sells ul.products'),
            $related = unero.$body.find('.related.products ul.products');

        $related.find('.un-loop-thumbnail img.lazy').removeAttr('data-lazy');
        $upsells.find('.un-loop-thumbnail img.lazy').removeAttr('data-lazy');

        // Product thumnails and featured image slider
        $upsells.not('.slick-initialized').slick({
            rtl: (uneroData.rtl === 'true'),
            slidesToShow: parseInt(uneroData.upsells_products_columns),
            slidesToScroll: parseInt(uneroData.upsells_products_columns),
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 481,
                    settings: {
                        slidesToShow: parseInt(uneroData.product_columns_mobile),
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $upsells.on('afterChange', function () {
            unero.lazyLoad();
        });

        $related.not('.slick-initialized').slick({
            rtl: (uneroData.rtl === 'true'),
            slidesToShow: parseInt(uneroData.related_products_columns),
            slidesToScroll: parseInt(uneroData.related_products_columns),
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 481,
                    settings: {
                        slidesToShow: parseInt(uneroData.product_columns_mobile),
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $related.on('afterChange', function () {
            unero.lazyLoad();
        });

    };

    /**
     * Shop view toggle
     */
    unero.shopView = function () {

        unero.$body.on('click', '.un-shop-view', function (e) {
            e.preventDefault();
            var $el = $(this),
                view = $el.data('view');

            if ($el.hasClass('current')) {
                return;
            }

            unero.$body.find('.un-shop-view').removeClass('current');
            $el.addClass('current');
            unero.$body.removeClass('shop-view-grid shop-view-list').addClass('shop-view-' + view);

            document.cookie = 'shop_view=' + view + ';domain=' + window.location.host + ';path=/';

            $(document.body).trigger('unero_shop_view_after_change');

        });

        $(document.body).on('unero_shop_view_after_change', function () {
            unero.lazyLoad();
        });
    };

    // Show Filter widget
    unero.showFilterContent = function () {
        var $shopToolbar = $('#un-shop-toolbar'),
            $shopTopbar = $('#un-shop-topbar'),
            $catsFilter = $('#un-categories-filter'),
            $ordering = $shopToolbar.find('.woocommerce-ordering'),
            $catalogSideBar = $('.catalog-sidebar');

        unero.$window.on('resize', function () {
            if (unero.$window.width() < 991) {
                $shopToolbar.addClass('on-mobile');
                $shopTopbar.addClass('on-mobile');
                $catalogSideBar.addClass('on-mobile');
            } else {
                $catsFilter.removeAttr('style');
                $('#un-toggle-cats-filter').removeClass('active');
                $shopToolbar.removeClass('on-mobile');
                $shopTopbar.removeClass('on-mobile');
                $catalogSideBar.removeClass('on-mobile');
                $shopTopbar.find('.widget-title').next().removeAttr('style');
                $catalogSideBar.find('.widget-title').next().removeAttr('style');
            }
        }).trigger('resize');

        unero.$body.find('.shop-toolbar, .shop-bottombar').on('click', '.un-filter', function (e) {
            e.preventDefault();

            if ($(this).closest('.shop-toolbar').hasClass('on-mobile')) {
                $catsFilter.slideUp(200);
                $ordering.slideUp(200);
                $('#un-toggle-cats-filter').removeClass('active');
                $('#un-ordering').removeClass('active');
                setTimeout(function () {
                    $shopTopbar.slideToggle(200);
                }, 200);
            } else {
                $shopTopbar.slideToggle();
            }

            $shopTopbar.toggleClass('active');
            $(this).toggleClass('active');
            $shopTopbar.closest('.shop-bottombar').toggleClass('show');
            $('#un-filter-overlay').toggleClass('show');

            unero.$body.toggleClass('show-filters-content');
        });

        unero.$body.on('click', '#un-filter-overlay', function (e) {
            e.preventDefault();
            $shopTopbar.slideToggle();
            $('.un-filter').removeClass('active');
            $shopTopbar.closest('.shop-bottombar').toggleClass('show');
            $('#un-filter-overlay').toggleClass('show');
            $shopTopbar.removeClass('active');

            unero.$body.removeClass('show-filters-content');
        });

        unero.$body.on('click', '#un-toggle-cats-filter', function (e) {
            e.preventDefault();
            if ($(this).closest('.shop-toolbar').hasClass('on-mobile')) {

                $shopTopbar.slideUp(200);
                setTimeout(function () {
                    $catsFilter.slideToggle(200);
                }, 200);

                $(this).toggleClass('active');
                $('.un-filter').removeClass('active');
                $shopTopbar.removeClass('active');
            }
        });

        unero.$body.on('click', '#un-ordering', function (e) {
            e.preventDefault();
            if ($(this).closest('.shop-toolbar').hasClass('on-mobile')) {

                $shopTopbar.slideUp(200);
                setTimeout(function () {
                    $ordering.slideToggle(200);
                }, 200);

                $(this).toggleClass('active');
                $('.un-filter').removeClass('active');
                $shopTopbar.removeClass('active');
            }
        });

        $shopTopbar.on('click', '.widget-title', function (e) {
            if ($(this).closest('.shop-topbar').hasClass('on-mobile')) {
                e.preventDefault();

                $(this).closest('.widget').siblings().find('.widget-title').next().slideUp(200);
                $(this).closest('.widget').siblings().removeClass('active');

                $(this).next().slideToggle(200);
                $(this).closest('.widget').toggleClass('active');


            }
        });

        $catalogSideBar.on('click', '.widget-title', function (e) {
            if ($(this).closest('.catalog-sidebar').hasClass('on-mobile')) {
                e.preventDefault();

                $(this).closest('.widget').siblings().find('.widget-title').next().slideUp(200);
                $(this).closest('.widget').siblings().removeClass('active');

                $(this).next().slideToggle(200);
                $(this).closest('.widget').toggleClass('active');


            }
            ;
        });

    };

    // Filter Ajax
    unero.filterAjax = function () {

        if (!unero.$body.hasClass('catalog-ajax-filter')) {
            return;
        }

        $(document.body).on('price_slider_change', function (event, ui) {
            var form = $('.price_slider').closest('form').get(0),
                $form = $(form),
                url = $form.attr('action') + '?' + $form.serialize();

            $(document.body).trigger('unero_catelog_filter_ajax', url, $(this));
        });


        unero.$body.on('click', ' #remove-filter-actived', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $(document.body).trigger('unero_catelog_filter_ajax', url, $(this));
        });

        unero.$body.find('#un-shop-product-cats').on('click', '.cat-link', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $(document.body).trigger('unero_catelog_filter_ajax', url, $(this));
        });

        unero.$body.find('#un-shop-toolbar').find('.woocommerce-ordering').on('click', 'a', function (e) {
            e.preventDefault();
            $(this).addClass('active');
            var url = $(this).attr('href');
            $(document.body).trigger('unero_catelog_filter_ajax', url, $(this));
        });

        unero.$body.find('#un-categories-filter').on('click', 'a', function (e) {
            e.preventDefault();
            $(this).addClass('selected');
            var url = $(this).attr('href');
            $(document.body).trigger('unero_catelog_filter_ajax', url, $(this));
        });

        unero.$body.find('#un-shop-topbar, .catalog-sidebar').on('click', 'a', function (e) {
            var $widget = $(this).closest('.widget');
            if ($widget.hasClass('widget_product_tag_cloud') ||
                $widget.hasClass('widget_product_categories') ||
                $widget.hasClass('widget_layered_nav_filters') ||
                $widget.hasClass('widget_layered_nav') ||
                $widget.hasClass('product-sort-by') ||
                $widget.hasClass('unero-price-filter-list')) {
                e.preventDefault();
                $(this).closest('li').addClass('chosen');
                var url = $(this).attr('href');
                $(document.body).trigger('unero_catelog_filter_ajax', url, $(this));
            }

            if ($widget.hasClass('widget_product_tag_cloud')) {
                $(this).addClass('selected');
            }

            if ($widget.hasClass('product-sort-by')) {
                $(this).addClass('active');
            }
        });

        $(document.body).on('unero_catelog_filter_ajax', function (e, url, element) {

            var $container = $('#un-shop-content'),
                $container_nav = $('#primary-sidebar'),
                $categories = $('#un-categories-filter'),
                $shopTopbar = $('#un-shop-topbar'),
                $ordering = $('.shop-toolbar .woocommerce-ordering'),
                $found = $('.shop-toolbar .product-found'),
                $pageHeader = $('#un-catalog-page-header'),
                $productsHeader = $('.woocommerce-products-header');

            if ($('#un-shop-toolbar').length > 0) {
                var position = $('#un-shop-toolbar').offset().top - 200;
                $('html, body').stop().animate({
                        scrollTop: position
                    },
                    1200
                );
            }

            $('#un-shop-loading').addClass('show');
            if ('?' == url.slice(-1)) {
                url = url.slice(0, -1);
            }

            url = url.replace(/%2C/g, ',');

            history.pushState(null, null, url);

            $(document.body).trigger('unero_ajax_filter_before_send_request', [url, element]);

            if (unero.ajaxXHR) {
                unero.ajaxXHR.abort();
            }

            unero.ajaxXHR = $.get(url, function (res) {

                $container.replaceWith($(res).find('#un-shop-content'));
                $container_nav.html($(res).find('.catalog-sidebar').html());
                $categories.html($(res).find('#un-categories-filter').html());
                $shopTopbar.html($(res).find('#un-shop-topbar').html());
                $ordering.html($(res).find('.shop-toolbar .woocommerce-ordering').html());
                $found.html($(res).find('.shop-toolbar .product-found').html());
                $pageHeader.html($(res).find('#un-catalog-page-header').html());
                $productsHeader.html($(res).find('.woocommerce-products-header').html());

                unero.priceSlider();
                unero.lazyLoad();
                unero.shopLayout();
                unero.toolTipIcon();
                unero.animationProduct();
                unero.productCategoriesWidget();
                $('#un-shop-loading').removeClass('show');


                $(document.body).trigger('unero_ajax_filter_request_success', [res, url]);

            }, 'html');


        });

        $(document.body).on('unero_ajax_filter_before_send_request', function () {
            if ($('#un-shop-toolbar').hasClass('on-mobile') || $('#un-shop-topbar').hasClass('on-mobile')) {
                $('#un-categories-filter').slideUp();
                $('#un-shop-topbar').slideUp();

                $('#un-toggle-cats-filter').removeClass('active');
                $('.un-filter').removeClass('active');
            }
        });

    };

    // Page header slider
    unero.pageHeader = function () {

        if (!$('.page-header').hasClass('page-header-sliders')) {
            $('.page-header.parallax').parallax('50%', 0.6);
            return;
        }

        var $pageHeader = $('.page-header-sliders'),
            speed = $pageHeader.data('speed'),
            autoplay = $pageHeader.data('auto'),
            parallax = $pageHeader.data('parallax');
        $pageHeader.find('ul').not('.slick-initialized').slick({
            rtl: (uneroData.rtl === 'true'),
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            autoplaySpeed: speed,
            autoplay: autoplay,
            fade: true,
            cssEase: 'linear',
            prevArrow: '<span class="icon-chevron-left slick-prev-arrow"></span>',
            nextArrow: '<span class="icon-chevron-right slick-next-arrow"></span>'
        });

        var video = $pageHeader.find('ul').find('.unvideo-bg').find('video');
        if (video.length > 0) {
            video[0].play();
        }

        $pageHeader.find('ul').on('afterChange', function (event, slick, currentSlide) {
            var video = $pageHeader.find('ul').find('.slick-slide[data-slick-index="' + currentSlide + '"]').find('video');
            if (video.length > 0) {
                video[0].play();
            }
        });

        $pageHeader.find('ul').on('beforeChange', function (event, slick, currentSlide) {
            var video = $pageHeader.find('ul').find('.slick-slide[data-slick-index="' + currentSlide + '"]').find('video');
            if (video.length > 0) {
                video[0].pause();
            }
        });

        if (parallax == '0') {
            $('.page-header-sliders.parallax').find('.featured-img').parallax('50%', 0.6);

        } else {
            var hPageHeader = $pageHeader.height();
            if (unero.$body.hasClass('admin-bar')) {
                hPageHeader = hPageHeader - 32;
            }

            $('#content').css('margin-top', hPageHeader);

            $pageHeader.addClass('parallax-2');

            unero.$window.on('scroll', function () {
                var wScrollTop = unero.$window.scrollTop();
                if (wScrollTop > 0) {
                    $('.page-header-sliders.parallax-2').css({opacity: (hPageHeader - wScrollTop) / hPageHeader});
                } else {
                    $('.page-header-sliders.parallax-2').css({opacity: 1});
                }
            });

        }

    };

    // Off Canvas Panel
    unero.canvasPanel = function () {
        /**
         * Off canvas cart toggle
         */
        unero.$header.on('click', '.cart-contents', function (e) {
            e.preventDefault();
            unero.openCanvasPanel($('#cart-panel'));
        });

        if (uneroData.open_cart_mini == '1') {
            $(document.body).on('added_to_cart', function () {
                unero.openCanvasPanel($('#cart-panel'));
            });
        }

        unero.$header.on('click', '#icon-menu-sidebar', function (e) {
            e.preventDefault();
            unero.openCanvasPanel($('#menu-sidebar-panel'));
        });

        unero.$body.on('click', '#off-canvas-layer, .close-canvas-panel', function (e) {
            e.preventDefault();
            unero.closeCanvasPanel();
        });

    };

    unero.openCanvasPanel = function ($panel) {
        unero.$body.addClass('open-canvas-panel');
        $panel.addClass('open');
    };

    unero.closeCanvasPanel = function () {
        unero.$body.removeClass('open-canvas-panel');
        $('.unero-off-canvas-panel, #primary-mobile-nav').removeClass('open');
    };

    /**
     * Product instance search
     */
    unero.instanceSearch = function () {

        if (uneroData.ajax_search === '0') {
            return;
        }


        var xhr = null,
            searchCache = {},
            $modal = $('#search-modal'),
            $form = $modal.find('form'),
            $search = $form.find('input.search-field'),
            $results = $modal.find('.search-results');

        $modal.on('keyup', '.search-field', function (e) {
            var valid = false;

            if (typeof e.which == 'undefined') {
                valid = true;
            } else if (typeof e.which == 'number' && e.which > 0) {
                valid = !e.ctrlKey && !e.metaKey && !e.altKey;
            }

            if (!valid) {
                return;
            }

            if (xhr) {
                xhr.abort();
            }

            search();
        }).on('change', '.product-cats input', function () {
            if (xhr) {
                xhr.abort();
            }

            search();
        }).on('focusout', '.search-field', function () {
            if ($search.val().length < 2) {
                $results.find('.woocommerce, .buttons').slideUp(function () {
                    $modal.removeClass('searching searched actived found-products found-no-product invalid-length');
                });
            }
        });

        outSearch();

        /**
         * Private function for search
         */
        function search() {
            var keyword = $search.val(),
                cat = '';

            if ($modal.find('.product-cats').length > 0) {
                cat = $modal.find('.product-cats input:checked').val();
            }


            if (keyword.length < 2) {
                $modal.removeClass('searching found-products found-no-product').addClass('invalid-length');
                return;
            }

            $modal.removeClass('found-products found-no-product').addClass('searching');

            var keycat = keyword + cat;

            if (keycat in searchCache) {
                var result = searchCache[keycat];

                $modal.removeClass('searching');

                $modal.addClass('found-products');

                $results.find('.woocommerce').html(result.products);

                $(document.body).trigger('unero_ajax_search_request_success', [$results]);

                $results.find('.woocommerce, .buttons').slideDown(function () {
                    $modal.removeClass('invalid-length');
                });

                $modal.addClass('searched actived');
            } else {
                xhr = $.ajax({
                    url: uneroData.ajax_url,
                    dataType: 'json',
                    method: 'post',
                    data: {
                        action: 'unero_search_products',
                        nonce: uneroData.nonce,
                        term: keyword,
                        cat: cat
                    },
                    success: function (response) {
                        var $products = response.data;

                        $modal.removeClass('searching');


                        $modal.addClass('found-products');

                        $results.find('.woocommerce').html($products);

                        $results.find('.woocommerce, .buttons').slideDown(function () {
                            $modal.removeClass('invalid-length');
                        });

                        $(document.body).trigger('unero_ajax_search_request_success', [$results]);

                        // Cache
                        searchCache[keycat] = {
                            found: true,
                            products: $products
                        };


                        $modal.addClass('searched actived');
                    }
                });
            }

            $(document.body).on('unero_ajax_search_request_success', function (e, $results) {
                $results.find('img.lazy').lazyload({
                    threshold: 1000
                });
            });
        }

        /**
         * Private function for click out search
         */
        function outSearch() {
            var $modal = $('.header-layout-4').find('#search-modal'),
                $search = $modal.find('input.search-field');
            if ($modal.length <= 0) {
                return;
            }

            unero.$window.on('scroll', function () {
                if (unero.$window.scrollTop() > 10) {
                    $modal.removeClass('show found-products searched');
                }
            });

            $(document).on('click', function (e) {
                var target = e.target;
                if (!$(target).closest('.extra-menu-item').hasClass('menu-item-search')) {
                    $modal.removeClass('searching searched found-products found-no-product invalid-length');
                }
            });

            $modal.on('click', '.t-icon', function (e) {
                if ($modal.hasClass('actived')) {
                    e.preventDefault();
                    $search.val('');
                    $modal.removeClass('searching searched actived found-products found-no-product invalid-length');
                }

            });
        }
    };

    /**
     *  Toggle modal
     */
    unero.toggleModal = function () {
        unero.$body.on('click', '#menu-extra-search', function (e) {
            e.preventDefault();
            if ($('#menu-extra-login').hasClass('show')) {
                $('.unero-modal').removeClass('open');
                unero.$body.find('#menu-extra-login').removeClass('show');
            }

            unero.openModal($('#search-modal'));
            $(this).addClass('show');

            $('#search-modal').find('.search-field').focus();

        });

        unero.$body.on('click', '#menu-extra-login', function (e) {
            e.preventDefault();

            if ($('#menu-extra-search').hasClass('show')) {
                $('.unero-modal').removeClass('open');
                unero.$body.find('#menu-extra-search').removeClass('show');
            }

            unero.openModal($('#login-modal'));
            $(this).addClass('show');
        });

        unero.$body.on('click', '.close-modal', function (e) {
            e.preventDefault();
            unero.closeModal();
        });

    };

    /**
     * Open modal
     *
     * @param $modal
     * @param tab
     */
    unero.openModal = function ($modal) {
        unero.$body.addClass('modal-open');
        $modal.fadeIn();
        $modal.addClass('open');
    };

    /**
     * Close modal
     */
    unero.closeModal = function () {
        unero.$body.removeClass('modal-open');
        $('.unero-modal').fadeOut(function () {
            unero.$body.find('#menu-extra-search, #menu-extra-login').removeClass('show');
            $(this).removeClass('open');
        });
    };

    // Toggle Menu Sidebar
    unero.menuSideBar = function () {
        $('#menu-sidebar-panel').find('li.menu-item-has-children > a').on('click', function (e) {
            e.preventDefault();

            $(this).closest('li').siblings().find('ul.sub-menu').slideUp();
            $(this).closest('li').siblings().removeClass('active');

            $(this).closest('li').children('ul.sub-menu').slideToggle();
            $(this).closest('li').toggleClass('active');

        });
    };

    /**
     * Toggle product quick view
     */
    unero.productQuickView = function () {

        unero.$body.on('click', '.product-quick-view', function (e) {
            e.preventDefault();
            var $a = $(this);
            if (uneroData.quick_view_method == '1') {
                quickViewMethod1($a);
            } else {
                quickViewMethod2($a);
            }


        });

        function quickViewMethod1($a) {
            var id = $a.data('id'),
                $modal = $('#quick-view-modal'),
                $product = $modal.find('.unero-product-content'),
                $button = $modal.find('.modal-header .close-modal').first().clone();

            $product.hide().html('').addClass('invisible');
            $modal.addClass('loading');
            unero.openModal($modal);

            $.ajax({
                url: uneroData.ajax_url,
                dataType: 'json',
                method: 'post',
                data: {
                    action: 'unero_product_quick_view',
                    nonce: uneroData.nonce,
                    product_id: id
                },
                success: function (response) {
                    $product.show().append(response.data);
                    $modal.removeClass('loading').addClass('loaded');

                    var $summary = $product.find('.unero-single-product-detail'),
                        $product_thumbnails = $product.find('#product-thumbnails'),
                        $variations = $product.find('.variations_form'),
                        $carousel = $product.find('#product-images');

                    // Remove unused elements
                    $product_thumbnails.remove();

                    $product.find('div.product').prepend($button).addClass('q-view');

                    //Force height for images
                    $carousel.not('.slick-initialized').slick({
                        rtl: (uneroData.rtl === 'true'),
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: false,
                        prevArrow: '<span class="icon-chevron-left slick-prev-arrow"></span>',
                        nextArrow: '<span class="icon-chevron-right slick-next-arrow"></span>'
                    });

                    $modal.removeClass('loading');
                    $product.removeClass('invisible');

                    $carousel.find('.photoswipe').on('click', function (e) {
                        e.preventDefault();
                    });

                    if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                        $variations.wc_variation_form();
                        $variations.find('.variations select').change();
                    }

                    if (typeof $.fn.tawcvs_variation_swatches_form !== 'undefined') {
                        $variations.tawcvs_variation_swatches_form();
                    }

                    $carousel.imagesLoaded(function () {
                        $carousel.addClass('loaded');
                    });

                    unero.productVatiation();

                    unero.addToCartAjax();

                    $(document.body).trigger('unero_quick_view_request_success', [$summary]);

                }
            });
        }

        function quickViewMethod2($a) {
            var url = $a.attr('href'),
                $modal = $('#quick-view-modal'),
                $product = $modal.find('.product'),
                $product_sumary = $modal.find('.product-summary'),
                $product_images = $modal.find('.product-images-wrapper'),
                $button = $modal.find('.modal-header .close-modal').first().clone();

            $product.hide().addClass('invisible');
            $product_sumary.html('');
            $product_images.html('');
            $modal.addClass('loading');
            unero.openModal($modal);

            $.get(url, function (response) {
                var $html = $(response),
                    $response_summary = $html.find('#content').find('.entry-summary'),
                    $response_images = $html.find('#content').find('.product-images-content'),
                    $product_thumbnails = $response_images.find('#product-thumbnails'),
                    $variations = $response_summary.find('.variations_form'),
                    $carousel = $response_images.find('#product-images'),
                    productClasses = $html.find('.product').attr('class');

                // Remove unused elements
                $product_thumbnails.remove();
                $product.addClass(productClasses);
                $product_sumary.html($response_summary);
                $product_images.html($response_images);
                $product.show().prepend($button);

                //Force height for images
                $carousel.not('.slick-initialized').slick({
                    rtl: (uneroData.rtl === 'true'),
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: false,
                    prevArrow: '<span class="icon-chevron-left slick-prev-arrow"></span>',
                    nextArrow: '<span class="icon-chevron-right slick-next-arrow"></span>'
                });

                $modal.removeClass('loading');
                $product.removeClass('invisible');

                $carousel.find('.photoswipe').on('click', function (e) {
                    e.preventDefault();
                });

                if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                    $variations.wc_variation_form();
                    $variations.find('.variations select').change();
                }

                if (typeof $.fn.tawcvs_variation_swatches_form !== 'undefined') {
                    $variations.tawcvs_variation_swatches_form();
                }

                $carousel.imagesLoaded(function () {
                    $carousel.addClass('loaded');
                });

                unero.productVatiation();

                unero.addToCartAjax();

                $(document.body).trigger('unero_quick_view_request_success', [$response_summary]);
            }, 'html');
        }

        $('#quick-view-modal').on('click', function (e) {
            var target = e.target;
            if ($(target).closest('div.product').length <= 0) {
                unero.closeModal();
            }
        });
    };

    // Fixed Footer
    unero.fixedFooter = function () {

        if ($('#site-footer').length <= 0) {
            return;
        }

        unero.$window.on('resize', function () {

            var fHeight = $('#site-footer .footer-layout').outerHeight(true);

            unero.$body.css('padding-bottom', fHeight);

            if (unero.$body.hasClass('page-header-layout-3')) {
                if ($('.page-header').data('parallax') == '1') {
                    $('#site-footer').addClass('has-parallax');
                    var hHeader = $('.page-header').height();

                    unero.$window.on('scroll', function () {
                        if (unero.$window.scrollTop() > hHeader) {
                            $('#site-footer').addClass('active');
                        } else {
                            $('#site-footer').removeClass('active');
                        }
                    });
                }
            }
        }).trigger('resize');

    };

    // Sticky Header
    unero.stickyHeader = function () {

        if (!unero.$body.hasClass('sticky-header')) {
            return;
        }

        unero.$window.on('scroll', function () {
            var scrollTop = 5;

            if (unero.$body.hasClass('header-layout-3') ||
                unero.$body.hasClass('header-layout-4')) {
                scrollTop = 20;
            }

            if (unero.$window.scrollTop() > scrollTop) {
                unero.$header.addClass('minimized');
                $('#un-header-minimized').addClass('minimized');
            } else {
                unero.$header.removeClass('minimized');
                $('#un-header-minimized').removeClass('minimized');
            }
        });

        unero.$window.on('resize', function () {
            var wHeight = unero.$header.height();
            $('#un-header-minimized').height(wHeight);
        }).trigger('resize');

    };

    unero.updateCountWishlist = function () {
        // update wishlist count
        unero.$body.on('added_to_wishlist removed_from_wishlist', function () {
            $.ajax({
                url: uneroData.ajax_url,
                dataType: 'json',
                method: 'post',
                data: {
                    action: 'unero_update_wishlist_count'
                },
                success: function (data) {
                    unero.$header.find('.menu-item-wishlist .mini-cart-counter').html(data);
                }
            });
        });
    };

    // Portfolio Carousel
    unero.portfolioCarousel = function () {

        if (!unero.$body.hasClass('portfolio-layout-carousel')) {
            return;
        }

        var $wrap = $('#unero-site-content'),
            $frame = $wrap.find('.unero-post-frame'),
            start = uneroData.portfolio_carousel_slide,
            autoplay = uneroData.portfolio_carousel_autoplay,
            speed = 5000;

        if (start > 0) {
            start = start - 1;
        }

        if (autoplay > 0) {
            speed = autoplay;
            autoplay = 1;
        } else {
            autoplay = 0;
        }

        var options = {
            horizontal: 1,
            smart: 1,
            itemNav: 'forceCentered',
            activateOn: 'click',
            touchDragging: 1,
            mouseDragging: 1,
            releaseSwing: 1,
            startAt: start,
            scrollBar: $wrap.find('.scrollbar'),
            speed: 1000,
            elasticBounds: 1,
            dragHandle: 1,
            dynamicHandle: 1,
            clickBar: 1,

            // Cycling
            cycleBy: 'items',
            cycleInterval: speed,
            pauseOnHover: autoplay
        };

        var $sliders = new Sly($frame, options);

        $sliders.on('load move', function () {
            $wrap.addClass('loaded');
        });

        $sliders.init();

        $(window).resize(function () {
            var wWidth = $(window).width(),
                sWidth = wWidth - 60;

            if (unero.$body.hasClass('boxed')) {
                wWidth = $('.site').width();
            }

            if (wWidth < 1024) {
                sWidth = wWidth - 30;
            }


            if (wWidth < 1200) {
                $('.portfolio-layout-carousel').find('.portfolio-wapper').width(sWidth);
            } else {
                $('.portfolio-layout-carousel').find('.portfolio-wapper').removeAttr('style');
            }

            $sliders.reload();
        }).trigger('resize');

    };

    //Instagram slider
    unero.instagramSlider = function () {

        var $instagram = unero.$body.find('.unero-product-instagram ul.products'),
            columns = $instagram.data('columns'),
            autoplay = $instagram.data('auto'),
            infinite = false,
            speed = 1000;

        if (autoplay > 0) {
            infinite = true;
            speed = autoplay;
            autoplay = true;
        } else {
            autoplay = false;
        }

        $instagram.not('.slick-initialized').slick({
            rtl: (uneroData.rtl === 'true'),
            slidesToShow: columns,
            slidesToScroll: 1,
            autoplaySpeed: speed,
            autoplay: autoplay,
            infinite: infinite,
            dots: false,
            prevArrow: '<span class="icon-chevron-left slick-prev-arrow"></span>',
            nextArrow: '<span class="icon-chevron-right slick-next-arrow"></span>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    };

    // Product Categories
    unero.productCategoriesWidget = function () {
        var $categories = $('.un_widget_product_categories');

        if ($categories.length <= 0) {
            return;
        }

        $categories.find('ul.children').closest('li').prepend('<span class="cat-menu-close"><i class="icon-chevron-down"></i> </span>');

        $categories.find('li.current-cat-parent, li.current-cat').addClass('opened').children('.children').show();

        $categories.on('click', '.cat-menu-close', function (e) {
            e.preventDefault();
            $(this).closest('li').children('.children').slideToggle();
            $(this).closest('li').toggleClass('opened');

        })

    };

    unero.resizeProductThumbnail = function () {

        if (!unero.$body.hasClass('product-page-layout-3')) {
            return;
        }

        unero.$window.on('resize', function () {

            if (unero.$window.width() > 1200) {
                // sticky entry sumary
                var hHeader = 32;
                if (unero.$body.hasClass('header-sticky')) {
                    hHeader += unero.$header.outerHeight(true);
                }

                $('#unero-single-product-detail').find('.sticky-entry-summary').stick_in_parent({
                    parent: '#unero-single-product-detail',
                    offset_top: hHeader
                });

            } else {
                $('#unero-single-product-detail').find('.sticky-entry-summary').trigger('sticky_kit:detach');
            }

        }).trigger('resize');


    };

    // Get price js slider
    unero.priceSlider = function () {
        // woocommerce_price_slider_params is required to continue, ensure the object exists
        if (typeof woocommerce_price_slider_params === 'undefined') {
            return false;
        }

        if ($('.catalog-sidebar').find('.widget_price_filter').length <= 0 && $('#un-shop-topbar').find('.widget_price_filter').length <= 0) {
            return false;
        }

        // Get markup ready for slider
        $('input#min_price, input#max_price').hide();
        $('.price_slider, .price_label').show();

        // Price slider uses jquery ui
        var min_price = $('.price_slider_amount #min_price').data('min'),
            max_price = $('.price_slider_amount #max_price').data('max'),
            current_min_price = parseInt(min_price, 10),
            current_max_price = parseInt(max_price, 10);

        if ($('.price_slider_amount #min_price').val() != '') {
            current_min_price = parseInt($('.price_slider_amount #min_price').val(), 10);
        }
        if ($('.price_slider_amount #max_price').val() != '') {
            current_max_price = parseInt($('.price_slider_amount #max_price').val(), 10);
        }

        $(document.body).on('price_slider_create price_slider_slide', function (event, min, max) {
            if (woocommerce_price_slider_params.currency_pos === 'left') {

                $('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + min);
                $('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + max);

            } else if (woocommerce_price_slider_params.currency_pos === 'left_space') {

                $('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + ' ' + min);
                $('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + ' ' + max);

            } else if (woocommerce_price_slider_params.currency_pos === 'right') {

                $('.price_slider_amount span.from').html(min + woocommerce_price_slider_params.currency_symbol);
                $('.price_slider_amount span.to').html(max + woocommerce_price_slider_params.currency_symbol);

            } else if (woocommerce_price_slider_params.currency_pos === 'right_space') {

                $('.price_slider_amount span.from').html(min + ' ' + woocommerce_price_slider_params.currency_symbol);
                $('.price_slider_amount span.to').html(max + ' ' + woocommerce_price_slider_params.currency_symbol);

            }

            $(document.body).trigger('price_slider_updated', [min, max]);
        });
        if (typeof $.fn.slider !== 'undefined') {
            $('.price_slider').slider({
                range: true,
                animate: true,
                min: min_price,
                max: max_price,
                values: [current_min_price, current_max_price],
                create: function () {

                    $('.price_slider_amount #min_price').val(current_min_price);
                    $('.price_slider_amount #max_price').val(current_max_price);

                    $(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
                },
                slide: function (event, ui) {

                    $('input#min_price').val(ui.values[0]);
                    $('input#max_price').val(ui.values[1]);

                    $(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
                },
                change: function (event, ui) {

                    $(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
                }
            });
        }
    };

    /**
     * Document ready
     */
    $(function () {
        unero.init();
    });

})(jQuery);