<?php
/**
 * Include all styles
 */

if ( ! function_exists( 'exort_enqueue_frontend_styles' ) ) {
    function exort_enqueue_frontend_styles()
    {
        if (!is_admin()) {
            // Internet Explorer HTML5 support 
            wp_enqueue_script('exort-js-html5shiv', get_template_directory_uri() . '/js/html5.js', array(), '3.7.0', false);
            wp_script_add_data('exort-js-html5shiv', 'conditional', 'lt IE 9');

            // Internet Explorer 8 media query support
            wp_enqueue_script('exort-js-respond', get_template_directory_uri() . '/js/respond.js', array(), '1.4.2', false);
            wp_script_add_data('exort-js-respond', 'conditional', 'lt IE 9');

            wp_register_style('magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css');
            wp_register_style('exort-css-fonts-plugins', get_template_directory_uri() . '/css/exort-fonts-plugins.css');

            $depends = array();
            if (class_exists('Vc_Manager', false)) {
                $depends[] = 'js_composer_front';
            }
            wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', $depends);
            wp_register_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', $depends);
            wp_register_style('exort-css-main', get_template_directory_uri() . '/css/main.css', $depends);

            wp_register_style('exort-css-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array('exort-css-main'), null);
            wp_register_style('exort-css-responsive', get_template_directory_uri() . '/css/responsive.css', array('exort-css-main'), null);

            wp_enqueue_style('magnific-popup');
            wp_enqueue_style('exort-css-fonts-plugins');

            $font_url = add_query_arg( 'family', urlencode( 'Montserrat|Open Sans|Droid Serif:300,400,400italic,700,700italic&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
            wp_enqueue_style( 'google-fonts', $font_url, array(), null );

            wp_enqueue_style('bootstrap');
            wp_enqueue_style('owl-carousel');
            wp_enqueue_style('exort-css-main');

            if (class_exists('Woocommerce')) {
                wp_enqueue_style('exort-css-woocommerce');
            }

            wp_enqueue_style('exort-css-responsive');

            /**
             * Load our IE specific stylesheet for a range of older versions:
             * <!--[if lte IE 9]>
             * NOTE: You can use the 'less than' or the 'less than or equal to' syntax here interchangeably.
             */
            wp_enqueue_style('exort-css-old-ie', get_template_directory_uri() . '/css/ie.css', array('exort-css-main', 'exort-css-responsive'));
            wp_style_add_data('exort-css-old-ie', 'conditional', 'lte IE 9');
        }
    }

    add_action('wp_enqueue_scripts', 'exort_enqueue_frontend_styles');
}

if ( !function_exists( 'exort_deregister_duplicated_styles' ) ) {
    function exort_deregister_duplicated_styles()
    {
        wp_dequeue_style('yith-wcwl-font-awesome');
        wp_dequeue_style('ubermenu-font-awesome');
    }

    add_action('wp_enqueue_scripts', 'exort_deregister_duplicated_styles', 200);
}

if ( !function_exists( 'exort_enqueue_backend_styles' ) ) {
    function exort_enqueue_backend_styles()
    {
        if (is_admin()) {
            wp_register_style('exort-css-fonts-plugins', get_template_directory_uri() . '/css/exort-fonts-plugins.css');
            wp_enqueue_style('exort-css-fonts-plugins');
            wp_register_style('exort-admin-css', get_template_directory_uri() . '/css/admin.css');
            wp_enqueue_style('exort-admin-css');
        }
    }

    add_action('admin_enqueue_scripts', 'exort_enqueue_backend_styles');
}

/* deregister woocommerce styles */
if ( class_exists( 'WC_API' ) ) {
    if (!function_exists('exort_deregister_woocommerce_styles')) {
        function exort_deregister_woocommerce_styles()
        {
            wp_deregister_style('woocommerce-layout');
            wp_deregister_style('woocommerce-general');
            wp_deregister_style('woocommerce-smallscreen');
            wp_dequeue_script('prettyPhoto-init');
        }

        add_action('wp_enqueue_scripts', 'exort_deregister_woocommerce_styles');
    }

    if (!function_exists('exort_deregister_woocommerce_backend_styles')) {
        function exort_deregister_woocommerce_backend_styles()
        {
            if (is_admin() && isset($_GET['page']) && $_GET['page'] == 'exort_options') {
                wp_dequeue_style('jquery-ui-style');
                wp_dequeue_style('yit-jquery-ui-style');
                wp_dequeue_style('jquery-ui-overcast');
                wp_dequeue_style('woocommerce_admin_styles');
                wp_dequeue_style('ubermenu-font-awesome');
            }
        }

        add_action('admin_enqueue_scripts', 'exort_deregister_woocommerce_backend_styles', 200);
    }
}