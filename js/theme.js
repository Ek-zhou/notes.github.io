/*
 * Title:   Exort | Responsive Multi-Purpose WordPress Theme - Main Javascript
 * Author:  http://themeforest.net/user/soaptheme
 */

"use strict";

var stGlobals = {};
stGlobals.isMobile  = (/(Android|BlackBerry|iPhone|iPod|iPad|Palm|Symbian)/.test(navigator.userAgent));
stGlobals.isSafari = (/(Safari)/.test(navigator.userAgent)) && (!(/(Chrome)/.test(navigator.userAgent)));
stGlobals.isMobileWebkit = /WebKit/.test(navigator.userAgent) && /Mobile/.test(navigator.userAgent);
stGlobals.isiPad = (navigator.userAgent.match(/ipad/i) !== null);
stGlobals.isiPhone = (navigator.userAgent.match(/iphone/i) !== null);
stGlobals.isiOS = stGlobals.isiPhone || stGlobals.isiPad;
stGlobals.isAndroid = (navigator.userAgent.match(/android/i) !== null);

jQuery(document).ready(function($) {

    "use strict";

    $(".page-loader .loader").delay(0).fadeOut();
    $(".page-loader").delay(500).fadeOut("slow");

    //Youtube Video Background
    $(function() {
        $(".video-player").YTPlayer();
    });


    // scroll to
    $('.one-page nav a').on('click', function() {
        $('html, body').animate({
            scrollTop: $(this.hash).offset().top
        }, 1000);
        return false;
    });

    //Side Menu
    $("#menu-toggle").on('click', function(e) {
        e.preventDefault();
        $(".side-nav").toggleClass("toggled");
    });

    $('.side-nav .sidebar-inner li.menu-item-has-children').children('ul').hide();

    $('.side-nav .sidebar-inner li a').click(function(event) {
        event.stopPropagation();
        $(this).find(".side-nav .sidebar-inner li a").removeClass('menu-open');
        $(this).parents(".side-nav .sidebar-inner li a").addClass('menu-open');
        $(this).toggleClass('menu-open');
        $(this).parent().children('ul.sub-menu').toggle(200);
    });

    //ShowCase
    function ShowcaseLoading() {
        var ShowcaseCreated = false;
        Showcase();

        $(window).on('load resize', function() {
            if ($(this).width() < 992) {
                ShowcaseCreated = true;
                $.fn.fullpage.destroy('all');
            } else {
                Showcase();
            }
        });

        function Showcase() {
            $('.showcase').each(function() {
                var $this = $(this);
                if (ShowcaseCreated === false) {
                    ShowcaseCreated = true;
                    $this.fullpage({
                        anchors: ['Home', 'About', 'Services', 'Portfolio', 'Contact'],
                        navigation: true,
                        navigationPosition: 'right',
                        scrollBar: true,
                    });
                }
            });
        }
    }

    if ($('.showcase').length > 0) {
        ShowcaseLoading();
    }

    // Rainyday effect
    if ($('#rainyday').length > 0) {
        run();
    }

    function run() {
        var image = document.getElementById('rainyday');
        image.onload = function() {
            var engine = new RainyDay({
                image: this
            });

            engine.rain([
                [3, 3, 0.88],
                [5, 5, 0.9],
                [6, 2, 1]
            ], 100);
        };
        image.crossOrigin = 'anonymous';
        image.src = 'http://soaptheme.net/wordpress/exort/wp-content/themes/exort/images/rainyday-bg5.jpg';
    }

    // Owl-carousel

    // Single Item
    // Basic Single Slide no pagination & navigation
    $(".owl-single").owlCarousel({
        singleItem: true,
        slideSpeed: 300,
        autoPlay: 10000,
        transitionStyle: "fade",
        pagination: false,
        navigation: false,
    });

    // Single slide with navigation only
    $(".owl-single-nav").owlCarousel({
        navigation: true,
        slideSpeed: 300,
        singleItem: true,
        transitionStyle: "fade",
        pagination: false,
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ],
    });

    // Single slide with pagination only
    $(".owl-single-pag").owlCarousel({
        slideSpeed: 300,
        singleItem: true,
        pagination: true,
        transitionStyle: "fade",
    });

    // Single slide with all controls
    $(".owl-single-all").owlCarousel({
        slideSpeed: 300,
        singleItem: true,
        pagination: true,
        navigation: true,
        transitionStyle: "fade",
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ],
    });

    // 2 Item
    // Basic Owl-carousel 2 item
    $(".owl-2").owlCarousel({
        items: 2,
        slideSpeed: 300,
        itemsDesktop: [1199, 2],
        itemsMobile: [479, 1],
        pagination: false,
        navigation: false,
        autoPlay: 10000,
    });

    // Owl-carousel 2 item with navigation
    $(".owl-2-nav").owlCarousel({
        items: 2,
        slideSpeed: 300,
        navigation: true,
        pagination: false,
        itemsDesktop: [1199, 2],
        itemsMobile: [479, 1],
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ]
    });

    // Owl-carousel 2 item with pagination
    $(".owl-2-pag").owlCarousel({
        navigation: false,
        items: 2,
        pagination: true,
        itemsDesktop: [1199, 2],
        itemsMobile: [479, 1],
    });

    // Owl-carousel 2 item with all control
    $(".owl-2-all").owlCarousel({
        items: 2,
        slideSpeed: 300,
        navigation: true,
        pagination: true,
        itemsDesktop: [1199, 2],
        itemsMobile: [479, 1],
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ]
    });

    // 3 Item
    // Basic Owl-carousel 3 item
    $(".owl-3").owlCarousel({
        items: 3,
        slideSpeed: 300,
        itemsDesktop: [1199, 3],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        pagination: false,
        navigation: false,
        autoPlay: 10000,
    });

    // Owl-carousel 3 item with navigation
    $(".owl-3-nav").owlCarousel({
        items: 3,
        slideSpeed: 300,
        navigation: true,
        pagination: false,
        itemsDesktop: [1199, 3],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ]
    });

    // Owl-carousel 3 item with pagination
    $(".owl-3-pag").owlCarousel({
        navigation: false,
        items: 3,
        pagination: true,
        itemsDesktop: [1199, 3],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
    });

    // Owl-carousel 3 item with all control
    $(".owl-3-all").owlCarousel({
        items: 3,
        slideSpeed: 300,
        navigation: true,
        pagination: true,
        itemsDesktop: [1199, 3],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ]
    });

    // 4 Item
    // Basic Owl-carousel 4 item
    $(".owl-4").owlCarousel({
        items: 4,
        slideSpeed: 300,
        itemsDesktop: [1199, 4],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        pagination: false,
        navigation: false,
        autoPlay: 10000,
    });

    // Owl-carousel 4 item with navigation
    $(".owl-4-nav").owlCarousel({
        items: 4,
        slideSpeed: 300,
        navigation: true,
        pagination: false,
        itemsDesktop: [1199, 4],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ]
    });

    // Owl-carousel 4 item with pagination
    $(".owl-4-pag").owlCarousel({
        navigation: false,
        items: 4,
        pagination: true,
        itemsDesktop: [1199, 4],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
    });

    // Owl-carousel 4 item with all control
    $(".owl-4-all").owlCarousel({
        items: 4,
        slideSpeed: 300,
        navigation: true,
        pagination: true,
        itemsDesktop: [1199, 4],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ]
    });

    // 5 Item
    // Basic Owl-carousel 5 item
    $(".owl-5").owlCarousel({
        items: 5,
        slideSpeed: 300,
        itemsDesktop: [1199, 5],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        pagination: false,
        navigation: false,
        autoPlay: 10000,
    });

    // Owl-carousel 5 item with navigation
    $(".owl-5-nav").owlCarousel({
        items: 5,
        slideSpeed: 300,
        navigation: true,
        pagination: false,
        itemsDesktop: [1199, 5],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ]
    });

    // Owl-carousel 5 item with pagination
    $(".owl-5-pag").owlCarousel({
        navigation: false,
        items: 5,
        pagination: true,
        itemsDesktop: [1199, 5],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
    });

    // Owl-carousel 5 item with all control
    $(".owl-5-all").owlCarousel({
        items: 5,
        slideSpeed: 300,
        navigation: true,
        pagination: true,
        itemsDesktop: [1199, 5],
        itemsTablet: [992, 2],
        itemsMobile: [479, 1],
        navigationText: [
            "<i class='ti-angle-left prev'></i>",
            "<i class='ti-angle-right next'></i>"
        ]
    });

    //Portfolio Isotope
    if ($.fn.isotope && $.fn.imagesLoaded && ($('.portfolio').length > 0)) {

        $('.portfolio-isotope').imagesLoaded(function() {

            $('.iso-button').on("click", function() {
                $('.iso-button').removeClass('iso-active');
                $(this).addClass('iso-active');

                var selector = $(this).attr('data-filter');
                container.isotope({
                    filter: selector
                });

                return false;
            });

            $(window).resize(function() {
                container.isotope({});

            });
        });
    }

    var container = $('.portfolio-isotope');

    container.isotope({
        itemSelector: '.folio-item',
        transitionDuration: '0.5s',
        layoutMode: 'fitRows'

    });

    container.imagesLoaded(function() {
        $('.portfolio-isotope.masonry').isotope({
            layoutMode: 'masonry'
        });
    });

    //Blog Masonry
    $('.blog-post.masonry, .layout-masonry').imagesLoaded(function() {
        $('.blog-post.masonry, .layout-masonry').isotope({
            layoutMode: 'masonry',
            transitionDuration: '0.3s'
        });
    });

    // Works Item Lightbox
    $(".lightbox-image").magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
        mainClass: "mfp-fade"
    });

    $(".individual-gallery").magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
        mainClass: "mfp-fade"
    });

    $('.lightbox-video').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    // Counter Timer
    $().ready(function() {
        var endDate = "2018/01/01 00:00:00";
        $('.countdown').countdown(endDate, function(data) {
            $(this).html(data.strftime("<div>%D <span>days</span></div><div>%H <span>hrs</span></div><div>%M <span>min</span></div><div>%S <span>sec</span></div>"));
        });
    });

    // Progress bars
    $(".progress-bar").appear(function(indx) {
        $(this).css("width", $(this).attr("aria-valuenow") + "%");
    });

    // body parallax
    if ($("body").hasClass("parallax") && $("body").hasClass("skrollable-between")) {
        $("body").attr("data-bottom-top", "background-position:50% 0px");
        $("body").attr("data-top-bottom", "background-position:50% -100px");
    }

    function exort_is_mobile() {
        var $obj = $("<div></div>").addClass("visible-mobile");
        var result = $obj.appendTo("body").is(":visible");
        $obj.remove();
        return result;
    }

    // back to top
    $("body").on("click", ".exort-back-to-top", function(e) {
        e.preventDefault();
        $("html,body").animate({scrollTop: 0}, 800);
    });
    if ($(window).scrollTop() > $(window).height() * 0.6) {
        $(".exort-back-to-top").addClass("in");
    } else {
        $(".exort-back-to-top").removeClass("in");
    }
    $(window).scroll(function() {
        if ($(window).scrollTop() > $(window).height() * 0.6) {
            $(".exort-back-to-top").addClass("in");
        } else {
            $(".exort-back-to-top").removeClass("in");
        }
    });

    // go to content
    $("body").on("click", ".go-to-content", function(e) {
        e.preventDefault();
        if ($("#content").length > 0) {
            var offset = 0;
            if ($("#header.header-sticky").length > 0) {
                offset += $("#header.header-sticky").height();
            } else if (!$("body").hasClass("no-sticky-menu")) {
                var $header_cloned_obj = $("#header").clone();
                $header_cloned_obj.addClass("header-sticky").css("left", "-9999px").appendTo("body");
                offset += $header_cloned_obj.height();
                $header_cloned_obj.remove();
            }
            if ($("#wpadminbar").length > 0) {
                offset += $("#wpadminbar").height();
            }
            $("html,body").animate({scrollTop: $("#content").offset().top - offset}, 800);
        }
    });

    // parallax
    if (!stGlobals.isMobileWebkit && $(".parallax").length > 0 && $(".parallax-elem").length < 1) {
        $.stellar({
            responsive: true,
            horizontalScrolling: false
        });
    }

    // parallax for wekbit mobile
    if (stGlobals.isMobileWebkit) {
        $(".parallax, .skrollable.skrollable-between").css("background-attachment", "scroll");
    }

    // top search bar
    $("#header .header-search-btn a").on("click", function(e) {
        e.preventDefault();
        $("#header .top-search-bar").fadeIn("fast");
        $("#header .top-search-bar input[type=text]").focus();
    });
    $("#header .toggle-close").on("click", function(e) {
        $("#header .top-search-bar").fadeOut("fast");
        return false;
    });

    // toggle menu
    $("#header .header-btn-navbar").on("click", function(e) {
        if ($("body").hasClass("header-side-menu") && !exort_is_mobile()) {
            $("#header .menu-wrapper").toggleClass("active");
        } else if ( exort_is_mobile() ) {
            $("#header .mobile-menu-wrapper").slideToggle();
        }
        return false;
    });

    // mobile menu
    $(".menu-mobile .open-submenu, .menu-mobile .open-submenu + a").on("click", function() {
        $(this).parent().toggleClass("opened");
        $(this).parent().children(".sub-menu").stop().slideToggle(400);
        return false;
    });

    $("#main-menu, .menu-mobile").find("a[href='#']").on("click", function(e) {
        e.preventDefault();
    });

    // sticky menu
    function exort_sticky_header() {
        if (Modernizr.mq('only all and (max-width: ' + parseInt(exortLocal.mobileWidth, 10) + 'px)')) {
            $("#header").removeClass("header-sticky");
            $("#header-wrapper").removeClass("header-sticky-wrapper");
            $("#header-wrapper").css('margin-top', 0);
            $("#header").stop().css('top', '0');
            return;
        }
        var adminbarHeight = $("#wpadminbar").length > 0 ? $("#wpadminbar").outerHeight() : 0;
        if ($(window).scrollTop() > sticky_header_offset_top) {
            if ( !$("#header").hasClass("header-sticky") ) {
                $("#header").css('top', adminbarHeight - 60 + "px");
                $("#header").addClass("header-sticky");
                $("#header-wrapper").addClass("header-sticky-wrapper");
                $("#header-wrapper").css('margin-top', $("#header").outerHeight() + "px");
                $("#header").stop().animate({'top': adminbarHeight + 'px'}, 500);
            }
        } else {
            $("#header").removeClass("header-sticky");
            $("#header-wrapper").removeClass("header-sticky-wrapper");
            $("#header-wrapper").css('margin-top', 0);
            $("#header").stop().css('top', adminbarHeight);
        }
    }
    var sticky_header_offset_top = ($(".header-logo-center-top").length > 0 || $(".header-logo-center-top-transparent").length > 0) ? $("#header .logo").height() : $("#header").height();
    if (!$("body").hasClass("no-sticky-menu") && !stGlobals.isMobile && $("#header .menu-wrapper").length >= 1) {
        $(window).scroll(function() {
            exort_sticky_header();
        });
        $(window).resize(function() {
            sticky_header_offset_top = $("#header").height();
            exort_sticky_header();
        });
        exort_sticky_header();
    }

    // tooltip
    if ( $.fn.tooltip ) {
        $("[data-toggle=tooltip]").tooltip();
    }

    // UI design
    // checkbox
    $(".checkbox input[type='checkbox'], .radio input[type='radio']").each(function() {
        if ($(this).is(":checked")) {
            $(this).closest(".checkbox").addClass("checked");
            $(this).closest(".radio").addClass("checked");
        }
    });
    $(".checkbox input[type='checkbox']").bind("change", function() {
        if ($(this).is(":checked")) {
            $(this).closest(".checkbox").addClass("checked");
        } else {
            $(this).closest(".checkbox").removeClass("checked");
        }
    });
    // radio
    $("body").on("change", ".radio input[type='radio']", function(event, ui) {
        if ($(this).is(":checked")) {
            var name = $(this).prop("name");
            if (typeof name != "undefined") {
                $(".radio input[name='" + name + "']").closest('.radio').removeClass("checked");
            }
            $(this).closest(".radio").addClass("checked");
        }
    });
    // placeholder for ie8, 9
    try {
        $('input, textarea').placeholder();
    } catch (e) {}

    $("html").on("click", function(e) {
        var target = $(e.target);
        if(!target.is("#header .top-search-bar *") && !target.is("#header .header-search-btn *")) {
            $("#header .top-search-bar").fadeOut("fast");
        }
        if (!target.is("#header .menu-wrapper") && !target.is("#header .menu-wrapper *") && !target.is("#header .header-btn-navbar") && !target.is("#header .header-btn-navbar *")) {
            $("#header .menu-wrapper").removeClass("active");
        }
    });

    // overlay menu
    $("body.header-fullscreen-menu #header .header-btn-navbar").on("click", function(e) {
        $("body.header-fullscreen-menu #header .overlay").fadeIn();
    });
    $("body.header-fullscreen-menu #header .overlay-close").on("click", function(e) {
        e.preventDefault();
        $("body.header-fullscreen-menu #header .overlay").fadeOut();
    });
    $("#header .overlay, .exort-filters-wrap .portfolio-filters .container").niceScroll({
        autohidemode        : false,
        cursorborder        : 0,
        cursorborderradius  : 5,
        cursorcolor         : '#222222',
        cursorwidth         : 0,
        horizrailenabled    : false,
        mousescrollstep     : 40,
        scrollspeed         : 60
    });

    // footer
    $("#footer .exort-footer-collapse .collapse").on("click", function(e) {
        e.preventDefault();
        $(this).addClass("active");
        $(this).siblings(".expand").removeClass("active");
        $("#footer .widget-wrapper").slideUp();
    });
    $("#footer .exort-footer-collapse .expand").on("click", function(e) {
        e.preventDefault();
        $(this).addClass("active");
        $(this).siblings(".collapse").removeClass("active");
        $("#footer .widget-wrapper").slideDown();
    });

    // toggle
    $(".st-panel-group .st-panel.active .st-panel-content").show();
    $("body").on("click", ".st-panel-group .st-panel-title", function() {
        var panel = $(this).closest(".st-panel");
        if (!panel.hasClass("active") && panel.parent().hasClass("accordion")) {
            panel.parent().find(".st-panel.active .st-panel-content").slideUp();
            panel.parent().find(".st-panel.active").removeClass("active");
        }
        if (panel.hasClass("active")) {
            panel.find(".st-panel-content").slideUp();
            panel.removeClass("active");
        } else {
            panel.find(".st-panel-content").slideDown();
            panel.addClass("active");
        }
    });

    // alert
    $("body").on("click", ".alert > .close", function() {
        $(this).parent().fadeOut(300);
    });

    // tab
    function stInitVerticalTab() {
        $(".tab-container.tab-vertical-1").each(function() {
            if ($(this).children(".tabs").css("float") == "left") {
                var minheight = $(this).children(".tabs").height();
                $(this).find(".tab-pane").css("min-height", minheight + "px");
            } else {
                $(this).find(".tab-pane").css("min-height", "0");
            }
        });
    }
    stInitVerticalTab();

    function css3animationEffect() {
        if($().waypoint && Modernizr.mq('only all and (min-width: 768px)')) {
            // animation effect
            $('.animated').waypoint(function() {
                var type = $(this).data("animation-type");
                if (typeof type == "undefined" || type == false) {
                    type = "fadeIn";
                }
                $(this).addClass(type);
                
                var duration = $(this).data("animation-duration");
                if (typeof duration == "undefined" || duration == false) {
                    duration = "1";
                }
                $(this).css("animation-duration", duration + "s");
                
                var delay = $(this).data("animation-delay");
                if (typeof delay != "undefined" && delay != false) {
                    $(this).css("animation-delay", delay + "s");
                }
                
                $(this).css("visibility", "visible");

                setTimeout(function() {
                  $.waypoints('refresh');
                }, 1000);
            }, {
                triggerOnce: true,
                offset: 'bottom-in-view'
            });
        }
    }
    css3animationEffect();

    // Progress bar & counter
    $(".progress-bar").each(function() {
        if (stGlobals.isMobile || !$(this).hasClass("animate-progress")) {
            var percent = $(this).find(".progress-inner").data("percent");
            $(this).find(".progress-inner").width(percent + "%");
            $(this).find(".progress-percent > span").text(percent + "%");
        }
    });
    function stDisplayAnimateProgress() {
        $(".progress-bar.animate-progress .progress-percent > span").html('');
        $(".progress-bar.animate-progress").each(function() {
            $(this).find(".progress-inner").width(0);
            $(this).find(".progress-percent").css("visibility", "hidden");
        });

        $(".progress-bar.animate-progress").waypoint(function() {
            if ($(this).find(".progress-inner").length > 0) {
                var innerObj = $(this).find(".progress-inner"),
                    width = innerObj.data("percent");
                if (typeof width != "undefined") {
                    var $_this = $(this)
                        ,index = 0;
                    if ($_this.closest(".progress-bar-list").length > 0) {
                        index = $_this.index();
                    }
                    setTimeout(function() {
                        var current_progress = 0
                            ,progress = null;
                        $_this.find(".progress-percent").css("visibility", "visible");
                        progress = setInterval(function() {
                            if (current_progress >= width || current_progress >= 100) {
                                clearInterval(progress);
                                return;
                            }
                            current_progress += 1;
                            innerObj.css("width", current_progress + "%");
                            $_this.find(".progress-percent > span").text(current_progress + "%");
                        }, 10);
                    }, 100 * index);
                }
            }
            setTimeout(function() { $.waypoints('refresh'); }, 1000);
        }, {
            triggerOnce: true,
            offset: 'bottom-in-view'
        });
    }
    if ( !stGlobals.isMobile ) {
        stDisplayAnimateProgress();

        // display counter
        $('.counters-box').waypoint(function() {
            $(this).find('.display-counter').each(function() {
                var value = $(this).data('value');
                $(this).countTo({from: 0, to: value, speed: 3000, refreshInterval: 10});
            });
            setTimeout(function() { $.waypoints('refresh'); }, 1000);
        }, {
            triggerOnce: true,
            offset: '100%'
        });
    }
    // circular progress
    if ($(".circle-progress").length) {
        $(".circle-progress").circliful();
    }

    // Parallax
    if ( !stGlobals.isMobile && typeof skrollr === 'object') {
        window.exortParallaxSkroll = skrollr.init({
            forceHeight: false,
            smoothScrolling: false,
            mobileCheck: function () {
                return false;
            }
        });
    }

    // Tab
    $("body").on("click", ".team.team-slider .team-member-thumbnails > a", function(e) {
        e.preventDefault();
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        if ($(this).closest(".team").find(".team-member").eq(index).length > 0) {
            //$(this).closest(".team").find(".team-member").hide();
            $(this).closest(".team").find(".team-member").removeClass("active");
            $(this).closest(".team").find(".team-member").eq(index).addClass("active");
            $(this).closest(".team").find(".team-member").eq(index).equalHeights();
        }
    });
    function stInitTeamSliderThumb() {
        if (Modernizr.mq('only all and (max-width: 991px)')) {
            if ($(".team.team-slider .team-member:visible .image-container").length > 0) {
                var imgHeight = $(".team.team-slider .team-member:visible .image-container").height();
                $(".team.team-slider .team-member-thumbnails").css("margin-top", imgHeight - $(".team.team-slider .team-member-thumbnails > a").outerHeight() / 2);
            }
        } else {
            $(".team.team-slider .team-member-thumbnails").css("margin-top", "0");
        }
    }

    // Image Gallery
    function stAddOwlCarouselCaptionAnimated(elem, isInit) {
        if (typeof isInit == "undefined") {
            isInit = 0;
        }
        var totalItems = 0, currentItem = 0;
        if (isInit) {
            totalItems = elem.find(".owl-item").length;
        } else {
            var owlData = elem.data('owlCarousel');
            totalItems = owlData.$owlItems.length;
            currentItem = owlData.currentItem;
        }

        if (elem.hasClass("gallery-style1")) { // gallery style 1
            elem.find(".owl-prev").html('');
            $("<span></span>").text(((totalItems + currentItem - 1) % totalItems) + 1 + " / " + totalItems).appendTo(elem.find(".owl-prev"));
            elem.find(".owl-next").html('');
            $("<span></span>").text(((totalItems + currentItem + 1) % totalItems) + 1 + " / " + totalItems).appendTo(elem.find(".owl-next"));
        }
    }
    function stGallerySyncPosition(elem){
        var sync2 = elem.next(".image-gallery-thumbs.owl-carousel");
        if (sync2.length < 1) {
            sync2 = elem.prev(".image-gallery-thumbs.owl-carousel");
        }
        if (sync2.length > 0 && sync2.data("owlCarousel") !== undefined) {
            var current = elem.data("owlCarousel").currentItem;
            sync2.find(".owl-item").removeClass("synced").eq(current).addClass("synced");
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems,
                num = current,
                found = false;
            for (var i in sync2visible) {
                if (num === sync2visible[i]) {
                    var found = true;
                }
            }

            if (found===false){
                if (num > sync2visible[sync2visible.length-1]) {
                    sync2.trigger("owl.goTo", num - sync2visible.length+2)
                } else {
                    if(num - 1 === -1){
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if (num === sync2visible[sync2visible.length-1]) {
                sync2.trigger("owl.goTo", sync2visible[1])
            } else if (num === sync2visible[0]) {
                sync2.trigger("owl.goTo", num-1)
            }
        }
    }
     
    $(".image-gallery-thumbs.owl-carousel").on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).data("owlItem"), sync1 = $(this).closest(".owl-carousel").prev(".owl-carousel");
        if (sync1.length < 1) {
            sync1 = $(this).closest(".owl-carousel").next(".owl-carousel");
        }
        if (sync1.length > 0) {
            sync1.trigger("owl.goTo", number);
        }
    });

    // hover effect
    $('.image.hover-style3').each( function() { $(this).hoverdir(); } );

    // Magnific popup
    var exortMfpZoomVar = {
        removalDelay: 300,
        mainClass: 'mfp-fade'
    };
    $(".iso-container:not(.portfolio-container) a.st-mfp-popup, .blog-posts a.st-mfp-popup").each(function() {
        $(this).magnificPopup({ 
            type: 'image',
            gallery: { enabled:true }
            // other options
        });
    });
    $(".portfolio-container").each(function() {
        $(this).magnificPopup({ 
            delegate: 'a.st-mfp-popup',
            type: 'image',
            gallery: { enabled:true }
            // other options
        });
    });
    $(".image-gallery").each(function() {
        $(this).magnificPopup({ 
            delegate: 'a.st-mfp-popup',
            type: 'image',
            gallery: { enabled:true }
            // other options
        });
    });
    $(".image-box").magnificPopup({ 
        delegate: 'a.image',
        type: 'image',
        gallery: { enabled:true }
    });
    $(".single a.st-mfp-popup").each(function() {
        if ($(this).closest(".related-posts").length < 1 && $(this).closest(".image-gallery").length < 1) {
            $(this).magnificPopup({ 
                type: 'image',
                gallery: { enabled:true }
            });
        }
    });
    $(".single .related-posts").magnificPopup({
        delegate: 'a.st-mfp-popup',
        type: 'image',
        gallery: { enabled:true }
    });

    // Media
    $(".video-container").fitVids();
    function stInitMedia() {
        if (!$.fn.mediaelementplayer) {
            return;
        }
        $(".audio-container audio").mediaelementplayer();
        $(".video-container video").each(function() {
            $(this).mediaelementplayer({
                success: function(media, node, player) {
                    if (media.pluginType == 'youtube' && ( stGlobals.isiOS || stGlobals.isAndroid ) ) {
                        player.container.find('.mejs-poster').hide();
                    }
                }
            });
        });
    }
    stInitMedia();

    // min height for horizontal layout
    function initHorizontalContentHeight() {
        $(".image-box.style-horizontal, .image-box.style-offer").each(function() {
            if ($(this).find(".image-container").css("float") == "left") {
                var imgHeight = $(this).children(".image-container").height();
                $(this).children(".desc").css("min-height", imgHeight);
            }
        });

        $(".single-post .about-author").each(function() {
            if ($(this).children(".avatar-wrapper").css("float") == "left") {
                var minheight = $(this).children(".avatar-wrapper").height();
                $(this).find(".desc-wrapper").css("min-height", minheight + "px");
            } else {
                $(this).find(".desc-wrapper").css("min-height", "0");
            }
        });
        $(".blog-posts.style-list .post-item, .blog-posts.style-classic .post-item").each(function() {
            if ($(this).children(".post-image").css("float") == "left" && $(this).children(".post-image").is(":visible")) {
                var minheight = $(this).children(".post-image").height();
                $(this).find(".post-content").css("min-height", minheight + "px");
            } else {
                $(this).find(".post-content").css("min-height", "0");
            }
        });
        $(".portfolio-fancy .portfolio, .portfolio-list .portfolio").each(function() {
            if ($(this).children("figure").css("float") == "left" || $(this).children("figure").css("float") == "right") {
                var minheight = $(this).children("figure").height();
                $(this).find(".desc").css("min-height", minheight + "px");
            } else {
                $(this).find(".desc").css("min-height", "0");
            }
        });
    }

    // post like
    $('.post-like').on("click", function() {
        var el = $(this);
        if( el.hasClass('liked') ) return false;
        
        var post_data = {
            action: 'exort_post_like',
            post_id: el.data('id')
        };
        var original_count = el.find(".count").text();
        el.find(".count").text("...");
        $.post(exortLocal.ajaxurl, post_data, function(data){
            if (typeof data.count != "undefined") {
                el.find('.count').text(data.count);
                el.addClass('liked');
                el.attr("title", data.text);
                if ($.fn.tooltip) {
                    el.tooltip();
                }
            } else {
                el.find(".count").text(original_count);
            }
        }, "json");

        return false;
    });

    function initExortOwlCarousel($container) {
        var $parentObj = $container.hasClass("owl-carousel") ? $container : $container.find(".owl-carousel");
        $parentObj.each(function() {
            var transitionStyle = $(this).data("transitionstyle");
            if (typeof transitionStyle == "undefined") {
                transitionStyle = false;
            }
            var items = $(this).data("items"),
                isSingleItem = true,
                responsiveRate = 200;
            if (typeof items == "undefined") {
                items = 1;
            } else {
                items = parseInt(items, 10);
                if ( items > 1 ) {
                    isSingleItem = false;
                }
            }
            if (items > 1) {
                $(this).addClass("multiple-items");
            }
            if ($(this).hasClass("image-gallery-thumbs")) {
                responsiveRate = 100;
            }
            var options = {
                items: items,
                singleItem: isSingleItem,
                slideSpeed: 700,
                autoPlay: 5000,
                navigation: true,
                navigationText: false,
                pagination: true,
                stopOnHover: true,
                transitionStyle: transitionStyle,
                beforeMove: function(elem) {
                    stAddOwlCarouselCaptionAnimated(elem);
                },
                afterMove: function(elem) {

                },
                afterInit: function(elem) {
                    stAddOwlCarouselCaptionAnimated(elem, 1);
                    if (elem.hasClass("image-gallery-thumbs")) { // gallery with thumbnails
                        elem.find(".owl-item").eq(0).addClass("synced");
                        if (elem.hasClass("center-aligned")) {
                            elem.css("max-width", elem.find(".owl-item").outerWidth() * elem.find(".owl-item").length);
                        }
                    }
                    if (elem.hasClass("all-same-height")) {
                        elem.find(".owl-wrapper").equalHeights();
                        $(window).load(function() {
                            elem.find(".owl-wrapper").equalHeights();
                        });
                    }
                    if (elem.parent().parent().hasClass("testimonial-style2")) {
                        elem.parent().parent().find(".st-owl-controls").html(elem.find(".owl-controls").html());
                    }
                },
                beforeUpdate: function(elem) {
                    if (elem.hasClass("image-gallery-thumbs") && elem.hasClass("center-aligned")) {
                        elem.css("max-width", "none");
                    }
                },
                afterUpdate: function(elem) {
                    if (elem.hasClass("image-gallery-thumbs") && elem.hasClass("center-aligned")) {
                        elem.css("max-width", elem.find(".owl-item").outerWidth() * elem.find(".owl-item").length);
                    }
                    if (elem.hasClass("all-same-height")) {
                        elem.find(".owl-wrapper").equalHeights();
                    }
                    if (elem.closest(".iso-container").length > 0) {
                        elem.closest(".iso-container").isotope("layout");
                    }
                    if (elem.closest(".blog-posts.style-list").length > 0 || elem.closest(".blog-posts.style-list").length > 0) {
                        var $this = elem.closest(".post-item");
                        if ($this.children(".post-image").css("float") == "left" && $this.children(".post-image").is(":visible")) {
                            var minheight = $this.children(".post-image").height();
                            $this.find(".post-content").css("min-height", minheight + "px");
                        } else {
                            $this.find(".post-content").css("min-height", "0");
                        }
                    }
                },
                afterAction: function(elem) {
                    if ((elem.next(".image-gallery-thumbs.owl-carousel").length > 0 || elem.prev(".image-gallery-thumbs.owl-carousel").length > 0) && elem.data("owlCarousel") !== undefined) { // gallery with thumbnails
                        stGallerySyncPosition(elem);
                    }
                },
                responsiveRefreshRate: responsiveRate
            };

            var itemsCustom = $(this).data("items-custom");
            if (typeof itemsCustom != "undefined") {
                options.itemsCustom = eval(itemsCustom);
            } else if ( items < 5 && items >= 2 ) {
                options.itemsCustom = [[0,2], [479, items]];
            }
            var autoplay = $(this).data("autoplay");
            if (typeof autoplay != "undefined") {
                if (autoplay == false) {
                    options.autoPlay = false;
                } else {
                    options.autoPlay = parseInt(autoplay, 10);
                }
            }

            if ($(this).hasClass("image-gallery-thumbs")) {
                options.mouseDrag = false;
            }

            $(this).owlCarousel(options);
        });
    }


    // ajax pagination
    var ajax_loaded = false;
    $("body").on("click", ".load-more, .pager a", function(e) {
        var $this = $(this),
            loader = $.exort_loading(),
            $container = null,
            container_id;
        if ($this.closest(".pager").prev(".portfolio-container").length > 0) { //portfolio
            $container = $this.closest(".pager").prev(".portfolio-container");
        } else if ($this.closest(".pager").prev(".blog-posts").length > 0) { //portfolio
            $container = $this.closest(".pager").prev(".blog-posts");
        }
        container_id = '#' + $container.prop("id");
        if ($container == null || $container.length < 1 || typeof $container.data("pagination") == "undefined" || typeof $container.prop("id") == "undefined") {
            return true;
        }
        if (ajax_loaded) {
            return false;
        }
        e.preventDefault();
        ajax_loaded = true;
        var pagination_style = $container.data("pagination");
        function ajax_loaded_finished(new_items) {
            if ( new_items == null ) {
                ajax_loaded = false;
                loader.hide();
            } else {
                new_items.each(function(i) {
                    var times = stGlobals.isMobile ? 0 : i * 100,
                        obj = $(this);
                    setTimeout(function() {
                        obj.css({visibility:"visible", opacity:0}).removeClass("exort-ajax-post").animate({opacity:1}, 1500);
                        if (new_items.length - 1 == i) {
                            ajax_loaded = false;
                            loader.hide();
                        }
                    }, times);
                });
            }
            $this.trigger("blur");
        }

        $.ajax({
            url: $this.attr("href"),
            type: 'GET',
            beforeSend: function() {
                loader.show();
            },
            success: function(response) {
                var container = $($.parseHTML(response)).find(container_id),
                    btnLoad = $($.parseHTML(response)).find(container_id).next(".pager").find(".load-more"),
                    paginationObj = $($.parseHTML(response)).find(container_id).next(".pager");
                if (container.length < 1) {
                    ajax_loaded_finished(null);
                    return;
                }
                var items_container = $container.children(".iso-container").length > 0 ? $container.children(".iso-container") : $container;
                if (items_container.hasClass("iso-container")) {
                    var new_items = container.find(".iso-item").addClass("exort-ajax-post");
                    if (pagination_style == 'ajax') {
                        exortAjaxPaginationRemoveOldItems(items_container.find(".iso-item:not(.exort-ajax-post)"));
                        items_container.isotope("remove", items_container.find(".iso-item:not(.exort-ajax-post)")).append( new_items ).isotope( 'appended', new_items );
                    } else {
                        items_container.isotope("insert", new_items);
                    }
                    exortAjaxPaginationAddNewItems($container);
                    items_container.find(".exort-ajax-post").imagesLoaded(function() {
                        items_container.trigger("exort_ajax_post_added", [$(this)]);
                        setTimeout(function() { items_container.isotope("layout"); }, 150);
                        setTimeout(function() { ajax_loaded_finished(new_items); }, 800);
                    });
                } else {
                    var new_items = container.children(":not(.load-more)").addClass("exort-ajax-post");
                    if (pagination_style == 'ajax') {
                        var tempCloneObj = '';
                        if (items_container.children(".load-more").length > 0) {
                            tempCloneObj = items_container.children(".load-more").clone();
                        }
                        exortAjaxPaginationRemoveOldItems(items_container);
                        items_container.empty().append(new_items).append(tempCloneObj);
                    } else {
                        new_items.insertAfter(items_container.children(":not(.load-more)").last());
                    }
                    exortAjaxPaginationAddNewItems($container);
                    items_container.find(".exort-ajax-post").imagesLoaded(function() {
                        items_container.trigger("exort_ajax_post_added", [$(this)]);
                        setTimeout(function() { ajax_loaded_finished(new_items); }, 150);
                    });
                }
                if (btnLoad.length > 0 && pagination_style == 'load_more') {
                    $this.attr("href", btnLoad.attr("href"));
                } else if (pagination_style == 'load_more') {
                    $this.remove();
                }
                if (paginationObj.length > 0 && pagination_style == 'ajax') {
                    $this.closest(".pager").html(paginationObj.children());
                }
            }
        });
    });
    function exortAjaxPaginationRemoveOldItems($container) {
        var oldOwlCarousel = $container.find(".owl-carousel").data("owlCarousel");
        if (typeof oldOwlCarousel != "undefined") {
            oldOwlCarousel.destroy();
        }
    }
    function exortAjaxPaginationAddNewItems($container) {
        $container.find('.exort-ajax-post .video-container:not(.mejs-skin)').fitVids();
        $container.find(".exort-ajax-post .audio-container audio").mediaelementplayer();
        $container.find(".exort-ajax-post .video-container video").each(function() {
            $(this).mediaelementplayer({
                success: function(media, node, player) {
                    if (media.pluginType == 'youtube' && ( stGlobals.isiOS || stGlobals.isAndroid ) ) {
                        player.container.find('.mejs-poster').hide();
                    }
                }
            });
        });
        $container.find(".exort-ajax-post .audio-container audio").each(function() {
            $(this).mediaelementplayer();
        });
        $container.find(".exort-ajax-post .image.hover-style3").each( function() { $(this).hoverdir(); } );
        initExortOwlCarousel($container.find(".exort-ajax-post"));
        $container.find(".exort-ajax-post a.st-mfp-popup").each(function() {
            $(this).magnificPopup({ 
                type: 'image',
                gallery: { enabled:true }
            });
        });
        $container.find(".exort-ajax-post .image-gallery").each(function() {
            $(this).magnificPopup({ 
                delegate: 'a.st-mfp-popup',
                type: 'image',
                gallery: { enabled:true }
            });
        });
        if ($container.closest(".portfolio-fancy").length > 0 || $container.closest(".portfolio-list").length > 0) {
            var $parent_contaner = $container.closest(".portfolio-fancy") || $container.closest(".portfolio-list");
            $container.imagesLoaded(function() {
                $parent_contaner.find(".portfolio").each(function() {
                    if ($(this).children("figure").css("float") == "left" || $(this).children("figure").css("float") == "right") {
                        var minheight = $(this).children("figure").height();
                        $(this).find(".desc").css("min-height", minheight + "px");
                    } else {
                        $(this).find(".desc").css("min-height", "0");
                    }
                });
            });
        }
    }

    // relayout portfolios in fancy style
    function relayoutFancyPortfolios($container, filter) {
        if ($container.length < 1) {
            return;
        }
        var columns = $container.data("columns"), $itemsContainer;
        if (typeof columns == 'undefined') {
            return;
        }
        columns = parseInt(columns, 10);

        if (Modernizr.mq('only all and (max-width: 767px)')) {
            columns = 1;
        } else if (Modernizr.mq('only all and (max-width: 1199px)')) {
            if ( columns == 3 ) {
                columns = 2;
            }
        }

        if (typeof filter !== "undefined") {
            $itemsContainer = $container.find(".iso-item" + filter);
        } else {
            $itemsContainer = $container.find(".iso-item:visible");
        }
        $itemsContainer.each(function(index) {
            if (index % (2 * columns) >= columns) {
                $(this).find("figure").css("float", "right");
            } else {
                $(this).find("figure").css("float", "left");
            }
        });

    }
    $(".portfolio-fancy .portfolio-container").on("filterDone", function(e, options) {
        relayoutFancyPortfolios($(this), options.filter);
    });

    if ( $(".owl-carousel").length > 0 ) {
        if ($(".exort-filters-wrap .portfolio-filters").next(".portfolio-container.owl-carousel").length > 0) {
            var srcOwl = $(".exort-filters-wrap .portfolio-filters").next(".portfolio-container.owl-carousel");
            $(document.createElement("div")).addClass("portfolio-clone-container").hide().append(srcOwl.children().clone()).insertAfter(srcOwl);
        }
        initExortOwlCarousel($(".owl-carousel"));
    }

    $(".exort-filters-wrap .portfolio-filters a").each(function() {
        var selector = $(this).data('filter'),
            _container  = $(this).closest(".portfolio-filters").next(".portfolio-container.owl-carousel")
        if (_container.find(".iso-item." + selector).length < 1) {
            $(this).parent().hide();
        }
    });
    $(".exort-filters-wrap .portfolio-filters").on('click', 'a', function() {
        var current     = $(this),
            selector    = current.data('filter'),
            _container  = current.closest(".portfolio-filters").next(".portfolio-container.owl-carousel");
        if (_container.length < 1 || typeof _container.data('owlCarousel') == "undefined" || _container.next(".portfolio-clone-container").length < 1) {
            return false;
        }
        $(this).closest(".portfolio-filters").find(".active").removeClass('active');
        current.addClass('active');

        var owl = _container.data('owlCarousel'),
            nb = owl.itemsAmount;
        for (var i = 0; i < (nb - 1); i++) {
            owl.removeItem(1);
        }
        _container.next(".portfolio-clone-container").find(".iso-item." + selector).each(function () {
            owl.addItem($(this).clone());
        });
        owl.removeItem(0);
        _container.trigger("filterDone", selector);
        return false;
    });
    initHorizontalContentHeight();

    // full screen post
    function initFullScreenPost() {
        if ($(".single .post-image.full").length < 1) {
            return;
        }
        if (stGlobals.isMobileWebkit) {
            $(".single .post-image.full .post-media").addClass("no-parallax");
            return;
        }
        var offsetTop = $(".single .post-image.full").offset().top;
        var mediaFullHeight = $(window).height() - offsetTop,
            mediaHeight = $(".single .post-image.full .post-media > *").height();

        if (mediaHeight < mediaFullHeight * 1.3) {
            $(".single .post-image.full").height(mediaHeight);
            $(".single .post-image.full").css("max-height", mediaFullHeight);
            $(".single .post-image.full .post-media").addClass("no-parallax");
            if (mediaHeight > mediaFullHeight) {
                $(".single .post-image.full .post-media").css("margin-top", (mediaFullHeight - mediaHeight) / 2);
            } else {
                $(".single .post-image.full .post-media").css("margin-top", 0);
            }
        } else {
            $(".single .post-image.full").height(mediaFullHeight);
            $(".single .post-image.full .post-media").removeClass("no-parallax");
        }
    }
    if ($(".single .post-image.full").length > 0 && !stGlobals.isMobileWebkit) {
        $(".single .post-image.full .post-media").imagesLoaded(function() {
            initFullScreenPost();
        });
    }

    $(window).load(function() {
        $(".same-height").equalHeights();

        // portfolio filters
        if ($.fn.stIsotope) {
            var $isoContainer = $(".iso-container").stIsotope();
            $isoContainer.isotope('on', 'layoutComplete', function() {
                // layout complete
            });
        }

        var $scrollHeight;
        function initPortfolioSingleInfo() {
            var $window = $(window);
            var $this = $(".single-portfolio .portfolio-follow");
            if ($this.length > 0) {
                var offset = $this.offset()
                    ,$scrollOffset = $this.closest(".portfolio").offset();
                $scrollHeight = $this.closest(".portfolio").height();
                $window.scroll(function() {
                    var extraHeight = $("#header.header-sticky").length > 0 ? $("#header.header-sticky").height() : 0;
                    if ($("#wpadminbar").length > 0) {
                        extraHeight += $("#wpadminbar").height();
                    }
                    if ($this.parent().css("float") == "left") {
                        if ($window.scrollTop() + 3 + extraHeight > offset.top) {
                            if ($window.scrollTop() + $this.height() + 20 + extraHeight < $scrollOffset.top + $scrollHeight) {
                                var dist = $window.scrollTop() - offset.top + 20 + extraHeight;
                                if (dist > 0) {
                                    $this.stop().animate({
                                        marginTop: dist
                                    });
                                }
                            } else {
                                var dist = $scrollHeight - $this.height() - 20;
                                if (dist > 0) {
                                    $this.stop().animate({
                                        marginTop: dist
                                    });
                                }
                            }
                        } else {
                            $this.stop().animate({
                                marginTop: 0
                            });
                        }
                    } else {
                        $this.css("margin-top", 0);
                    }
                });
            }
        }
        setTimeout(function() { initPortfolioSingleInfo(); }, 1000);

        stInitTeamSliderThumb();

        initHorizontalContentHeight();

        if (!stGlobals.isMobile && window.exortParallaxSkroll) {
            window.exortParallaxSkroll.refresh();
        }
    });

});
