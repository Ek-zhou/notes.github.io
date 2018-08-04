<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( class_exists( 'ReduxFramework' ) ) {
    require_once EXORT_ADMIN_PATH . '/option-config.php';
}
/*
 * setup theme defaults
 */
if ( ! function_exists( 'exort_init' ) ) {
    function exort_init() {
        load_theme_textdomain( 'exort', EXORT_PATH . '/languages' );
        add_editor_style();
        add_theme_support( 'post-thumbnails' );
        // register additional image sizes
        //add_image_size( 'exort_portfolio_flat', 300, 225, true );    // portfolio flat style
        wp_upload_dir();
        add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        register_nav_menus( array(
            'primary'   => __( 'Primary Menu', 'exort' ),
            'bottom'    => __( 'Bottom Menu', 'exort' ),
        ) );
        /* Include admin functions */
        if ( is_admin() ) {
            require_once EXORT_EXT_PATH . '/TGM-Plugin-Activation/class-tgm-plugin-activation.php';
        } else {
            get_template_part( '/inc/functions/classes/custom', 'mobile-menu' );
        }
        /* multiple sidebar */
        if ( !class_exists( 'sidebar_generator' ) ) {
            require_once EXORT_EXT_PATH . '/multiple_sidebars.php';
        }
        // plugins
        if ( class_exists( 'ubermenu' ) ) {
            require_once EXORT_FUNC_PATH . '/ubermenu/init.php';
        }
        require_once EXORT_FUNC_PATH . '/classes/post-like.php';
        if ( class_exists( 'Woocommerce' ) ) {
            require_once EXORT_FUNC_PATH . '/woocommerce/init.php';
        }
    }
}
add_action( 'after_setup_theme', 'exort_init', 15 );
/*
 * function to register required plugins
 */
if ( ! function_exists( 'exort_register_required_plugins' ) ) {
    function exort_register_required_plugins() {
        /**
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = array(
			// This is an example of how to include a plugin pre-packaged with a theme.
			array(
				'name'               => __( 'Exort Custom Post', 'exort' ), // The plugin name.
				'slug'               => 'exort-custom-post', // The plugin slug (typically the folder name).
				'source'             => esc_url( 'http://www.soaptheme.net/wordpress/exort/plugins/exort-custom-post.zip' ), // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'               => __( 'Redux Framework', 'exort' ),
				'slug'               => 'redux-framework',
				'required'           => true,
			),
			array(
				'name'               => __( 'Meta Box', 'exort' ),
				'slug'               => 'meta-box',
				'required'           => true,
			),
			array(
				'name'          	 => __('WPBakery Visual Composer', 'exort' ), // The plugin name
				'slug'          	 => 'js_composer', // The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://www.soaptheme.net/wordpress/exort/plugins/js_composer.zip' ), // The plugin source
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
				'version'            => '5.4.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => __('UberMenu', 'exort' ), // The plugin name.
				'slug'               => 'ubermenu', // The plugin slug (typically the folder name).
				'source'             => esc_url( 'http://www.soaptheme.net/wordpress/exort/plugins/ubermenu.zip'), // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '3.3.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'               => __('Contact Form 7', 'exort' ),
				'slug'               => 'contact-form-7',
				'required'           => false,
			),
			array(
				'name'               => __('Woocommerce', 'exort' ),
				'slug'               => 'woocommerce',
				'required'           => false,
			),
			array(
				'name'               => __('Revolution Slider', 'exort' ), // The plugin name.
				'slug'               => 'revslider', // The plugin slug (typically the folder name).
				'source'             => esc_url( 'http://www.soaptheme.net/wordpress/exort/plugins/revslider.zip' ), // The plugin source.
				'required'           => false, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '5.4.6.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			)
		);
        if ( class_exists( 'Woocommerce' ) ) {
            $plugins[] = array(
                'name'               => __('YITH WooCommerce Ajax Navigation', 'exort' ),
                'slug'               => 'yith-woocommerce-ajax-navigation',
                'required'           => false,
            );
            $plugins[] = array(
                'name'               => __('YITH WooCommerce Wishlist', 'exort' ),
                'slug'               => 'yith-woocommerce-wishlist',
                'required'           => false,
            );
        }
        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
			'page_title'                      => __( 'Install Required Plugins', 'exort' ),
			'menu_title'                      => __( 'Install Plugins', 'exort' ),
			'installing'                      => __( 'Installing Plugin: %s', 'exort' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'exort' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'exort'
			),
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'exort'
			),
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'exort'
			),
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'exort'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'exort'
			),
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'exort'
			),
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'exort'
			),
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'exort'
			),
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'exort'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'exort'
			),
			'update_link'                     => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'exort'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'exort'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'exort' ),
			'dashboard'                       => __( 'Return to the dashboard', 'exort' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'exort' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'exort' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'exort' ),
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'exort' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'exort' ),
			'dismiss'                         => __( 'Dismiss this notice', 'exort' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'exort' ),
		);
        tgmpa( $plugins, $config );
     
    }
}
add_action( 'tgmpa_register', 'exort_register_required_plugins' );
