<?php
/**
 * Defines an array of options used in ReduxFramework
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Redux' ) ) {
    return;
}

$opt_name = EXORT_OPTIONS_NAME;

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'              => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'          => $theme->get( 'Name' ),
    // Name that appears at the top of your panel
    'display_version'       => $theme->get( 'Version' ),
    // Version that appears at the top of your panel
    'menu_type'             => 'submenu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'        => true,
    // Show the sections below the admin menu item or not
    'menu_title'            => __( 'Theme Options', 'exort' ),
    'page_title'            => __( 'ExortTheme Options', 'exort' ),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'        => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly'  => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'      => false,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                  // Disable this in case you want to create your own google fonts loader
    'admin_bar'             => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon'        => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'    => 50,
    // Choose an priority for the admin bar menu
    'global_variable'       => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'              => false,
    // Show the time the page took to load, etc
    'update_notice'         => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'            => true,
    // Enable basic customizer support
    //'open_expanded'    => true,                   // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                  // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority'         => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'           => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'      => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'             => '',
    // Specify a custom URL to an icon
    'last_tab'              => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'             => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'             => 'exort_options',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'         => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'          => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'          => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'    => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'   => '',                // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'           => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'system_info'         => false,
    // REMOVE

    'compiler'           => true,

    // HINTS
    'hints'     => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'    => 'slide',
                'duration'  => '500',
                'event'     => 'mouseover',
            ),
            'hide' => array(
                'effect'    => 'slide',
                'duration'  => '500',
                'event'     => 'click mouseleave',
            ),
        ),
    )
);

Redux::setArgs( $opt_name, $args );


Redux::setSection( $opt_name, array(
    'title' => __( 'Global', 'exort' ),
    'icon'  => 'el el-home'
) );
Redux::setSection( $opt_name, array(
    'title'         => __( 'General', 'exort' ),
    'subsection'    => true,
    'fields'        => array(
        array(
            'title'     => __( 'Site Layout', 'exort' ),
            'id'        => 'global_site_layout',
            'type'      => 'image_select',
            'options'   => array(
                'full_width'    => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/icon/layout-full-width.png'
                ),
                'boxed'         => array(
                    'alt'   => __( 'Boxed', 'exort' ),
                    'title' => __( 'Boxed', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/icon/layout-boxed.png'
                )
            ),
            'default'   => 'boxed'
        ),
        array(
            'type'      => 'text',
            'id'        => 'site_phone',
            'title'     => __( 'Phone Number', 'exort' ),
            'desc'      => __( 'It appears on top action bar', 'exort' ),
        ),
        array(
            'type'      => 'text',
            'id'        => 'site_email',
            'title'     => __( 'Email', 'exort' ),
            'desc'      => __( 'It appears on top action bar', 'exort' ),
            'validate'  => 'email'
        ),
        array(
            'type'      => 'text',
            'id'        => 'site_address',
            'title'     => __( 'Address', 'exort' ),
            'desc'      => __( 'It appears on footer widget', 'exort' ),
        ),
        array(
            'type'      => 'text',
            'id'        => 'site_site',
            'title'     => __( 'Site', 'exort' ),
            'desc'      => __( 'It appears on footer widget', 'exort' ),
        ),
    )
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Branding', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'type'      => 'media',
            'id'        => 'global_favicon_icon',
            'title'     => __( 'Favicon Icon (32x32 or 16x16 px)', 'exort' ),
            'url'       => true,
            'default'   => array( 'url' => EXORT_URL . '/images/favicon.png' )
        ),
        array(
            'type'      => 'media',
            'id'        => 'global_logo',
            'title'     => __( 'Logo', 'exort' ),
            'url'       => true,
            'default'   => array( 'url' => EXORT_URL . '/images/logo.png' ),
        ),
        array(
            'type'      => 'media',
            'id'        => 'global_logo_white',
            'title'     => __( 'Logo for Dark', 'exort' ),
            'url'       => true,
            'default'   => array( 'url' => EXORT_URL . '/images/logo-white.png' ),
        ),
        array(
            'type'      => 'text',
            'id'        => 'global_logo_text',
            'title'     => __( 'Logo text', 'exort' ),
            'subtitle'  => __( 'optional', 'exort' ),
            'desc'      => __( 'Use text instead of graphic logo or to place right to the graphic logo.', 'exort' ),
            'default'   => ''
        )
    )
) );
Redux::setSection( $opt_name, array(
    'title'      => __( 'Hooks', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'type'      => 'ace_editor',
            'id'        => 'global_hook_top',
            'title'     => __( 'Top', 'exort' ),
            'subtitle'  => __( 'exort_hook_top', 'exort' ),
            'mode'      => 'html',
            'theme'     => 'chrome',
            'desc'      => __( 'Please use this field if you want to place contents after the &#60;body&#62; tag.', 'exort' ),
            'default'   => ''
        ),
        array(
            'type'      => 'ace_editor',
            'id'        => 'global_hook_before_content',
            'title'     => __( 'Before Content', 'exort' ),
            'subtitle'  => __( 'exort_hook_before_content', 'exort' ),
            'mode'      => 'html',
            'theme'     => 'chrome',
            'desc'      => __( 'Please use this field if you want to place contents before content section.', 'exort' ),
            'default'   => ''
        ),
        array(
            'type'      => 'ace_editor',
            'id'        => 'global_hook_after_content',
            'title'     => __( 'After Content', 'exort' ),
            'subtitle'  => __( 'exort_hook_after_content', 'exort' ),
            'mode'      => 'html',
            'theme'     => 'chrome',
            'desc'      => __( 'Please use this field if you want to place contents after content section.', 'exort' ),
            'default'   => ''
        ),
        array(
            'type'      => 'ace_editor',
            'id'        => 'global_hook_bottom',
            'title'     => __( 'Bottom', 'exort' ),
            'subtitle'  => __( 'exort_hook_bottom', 'exort' ),
            'mode'      => 'html',
            'theme'     => 'chrome',
            'desc'      => __( 'Please use this field if you want to place contents just before the closing &#60;&#47;body&#62; tag.', 'exort' ),
            'default'   => ''
        )
    )
) );

Redux::setSection( $opt_name, array(
    'title' => __( 'Header', 'exort' ),
    'icon'  => 'el el-list-alt'
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Header', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'type' => 'switch',
            'id' => 'header_show_action_bar',
            'title' => __( 'Show Top Bar', 'exort' ),
            'desc' => __( 'Show Top Bar above the header', 'exort' ),
            'default' => false
        ),
        array(
            'type' => 'image_select',
            'id' => 'header_layout',
            'title' => __( 'Header Layout', 'exort' ),
            'options'  => array(
                'default-light' => array(
                    'alt'   => __( 'Default Light', 'exort' ),
                    'title' => __( 'Default Light', 'exort' ),
                    'img'   => EXORT_IMAGE_URL . '/theme-options/header/ms-1.png'
                ),
                'default-dark' => array(
                    'alt'   => __( 'Default Dark', 'exort' ),
                    'title' => __( 'Default Dark', 'exort' ),
                    'img'   => EXORT_IMAGE_URL . '/theme-options/header/ms-2.png'
                ),
                'transparent-light' => array(
                    'alt'   => __( 'Transparent Light', 'exort' ),
                    'title' => __( 'Transparent Light', 'exort' ),
                    'img'   => EXORT_IMAGE_URL . '/theme-options/header/ms-3.png'
                ),
                'transparent-dark' => array(
                    'alt'   => __( 'Transparent Dark', 'exort' ),
                    'title' => __( 'Transparent Dark', 'exort' ),
                    'img'   => EXORT_IMAGE_URL . '/theme-options/header/ms-2.png'
                ),
                'logo-center-top' => array(
                    'alt'   => __( 'Logo Center Top', 'exort' ),
                    'title' => __( 'Logo Center Top', 'exort' ),
                    'img'   => EXORT_IMAGE_URL . '/theme-options/header/ms-7.png'
                ),
                'logo-center-top-transparent' => array(
                    'alt'   => __( 'Logo Center Top Transparent', 'exort' ),
                    'title' => __( 'Logo Center Top Transparent', 'exort' ),
                    'img'   => EXORT_IMAGE_URL . '/theme-options/header/ms-8.png'
                ),
                'fullscreen-menu' => array(
                    'alt'   => __( 'Fullscreen Menu', 'exort' ),
                    'title' => __( 'Fullscreen Menu', 'exort' ),
                    'img'   => EXORT_IMAGE_URL . '/theme-options/header/ms-10.png'
                ),
                'side-menu' => array(
                    'alt'   => __( 'Side Menu', 'exort' ),
                    'title' => __( 'Side Menu', 'exort' ),
                    'img'   => EXORT_IMAGE_URL . '/theme-options/header/ms-11.png'
                ),
            ),
            'default' => 'default-light'
        ),
    )
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Subheader', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'type'      => 'select',
            'id'        => 'subheader_layout',
            'title'     => __( 'Layout', 'exort' ),
            'options'   => array(
                'both-center'                           => __( 'Title & Breadcrumbs centered', 'exort' ),
                'title-left,breadcrumb-right'           => __( 'Title left & Breadcrumbs right', 'exort' ),
                'title-right,breadcrumb-left'           => __( 'Title right & Breadcrumbs left', 'exort' ),
            ),
            'default'   => 'both-center',
            'class'     => 'disable_empty_field'
        ),
        array(
            'id'        => 'subheader_breadcrumbs_separator',
            'type'      => 'text',
            'title'     => __( 'Breadcrumbs separator', 'exort' ),
            'default'   => '<i class="ti-angle-right"></i>'
        ),
        array(
            'type'      => 'background',
            'id'        => 'subheader_background',
            'output'    => array( '#sub-header' ),
            'title'     => __( 'Subheader background', 'exort' ),
            'subtitle'  => __( 'Subheader background with image, color, etc.', 'exort' ),
        ),
        array(
            'type'      => 'checkbox',
            'id'        => 'subheader_parallax',
            'title'     => __( 'Parallax?', 'exort' ),
            'desc'      => __( 'This is useful for only background image.', 'exort' ),
            'required'  => array('subheader_background', '!=', '')
        ),
        array(
            'id'        => 'subheader_background_video',
            'type'      => 'text',
            'title'     => __( 'Subheader video url', 'exort' ),
            'default'   => '',
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'     => __( 'Footer', 'exort' ),
    'icon'      => 'el el-photo',
    'fields'    => array(
        array(
            'type'      => 'switch',
            'id'        => 'footer_minimal',
            'title'     => __( 'Footer Minimal', 'exort' ),
            'default'   => false
        ),
        array(
            'type'      => 'select',
            'id'        => 'footer_color_theme',
            'title'     => __( 'Footer Color Theme', 'exort' ),
            'options'   => array(
                'dark'      => __( 'Dark', 'exort' ),
                'gray'      => __( 'Gray', 'exort' ),
                'light'     => __( 'Light', 'exort' ),
            ),
            'default'   => 'dark',
        ),
        array(
            'type'      => 'select',
            'id'        => 'footer_widget_areas',
            'title'     => __( 'Footer Widget Areas', 'exort' ),
            'options'   => array(
                'none'              => __( 'None (Disable)', 'exort' ),
                '4-1,4-1,4-1,4-1'   => '1/4 1/4 1/4 1/4',
                '2-1,4-1,4-1'       => '1/2 1/4 1/4',
                '4-1,2-1,4-1'       => '1/4 1/2 1/4',
                '4-1,4-1,2-1'       => '1/4 1/4 1/2',
                '3-1,3-1,3-1'       => '1/3 1/3 1/3',
                '3-2,3-1'           => '2/3 1/3',
                '3-1,3-2'           => '1/3 2/3',
                '2-1,2-1'           => '1/2 1/2',
                '1-1'               => '1/1'
            ),
            'default'   => 'none',
            'required'  => array( 'footer_minimal', '=', false ),
            'class'     => 'disable_empty_field'
        ),
        array(
            'type'      => 'textarea',
            'id'        => 'footer_copyright_content',
            'title'     => __( 'Copyright Content', 'exort' ),
            'default'   => ''
        ),
        array(
            'type'      => 'switch',
            'id'        => 'footer_show_back_to_top_button',
            'title'     => __( 'Show Back to Top Button', 'exort' ),
            'default'   => true
        )
    )
) );

$widget_areas = exort_get_registered_sidebars();

Redux::setSection( $opt_name, array(
    'title' => __( 'Sidebars', 'exort' ),
    'icon'  => 'el el-list',
    'fields'     => array(
        array(
            'title'     => __( 'Page Layout', 'exort' ),
            'subtitle'  => __( 'Use this option to set default layout for all pages', 'exort' ),
            'desc'      => __( 'You can override this layout in the page metabox.', 'exort' ),
            'id'        => 'sidebar_page_layout',
            'type' => 'image_select',
            'options' => array(
                'full' => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/full-width.jpg'
                ),
                'left' => array(
                    'alt'   => __( 'Left Sidebar', 'exort' ),
                    'title' => __( 'Left Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/left-sidebar.jpg'
                ),
                'right' => array(
                    'alt'   => __( 'Right Sidebar', 'exort' ),
                    'title' => __( 'Right Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/right-sidebar.jpg'
                )
            ),
            'default' => 'full'
        ),
        array(
            'title'     => __( 'Page Sidebar', 'exort' ),
            'subtitle'  => __( 'Use this option to set default sidebar for all pages', 'exort' ),
            'desc'      => __( 'You can override this option in the page metabox.', 'exort' ),
            'id'        => 'sidebar_page_sidebar',
            'type'      => 'select',
            'options'   => $widget_areas,
            'required'  => array( 'sidebar_page_layout', '!=', 'full' )
        ),
        array(
            'title'     => __( 'Blog Layout', 'exort' ),
            'subtitle'  => __( 'Use this option to set layout for blog', 'exort' ),
            'id'        => 'sidebar_blog_layout',
            'type' => 'image_select',
            'options' => array(
                'full' => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/full-width.jpg'
                ),
                'left' => array(
                    'alt'   => __( 'Left Sidebar', 'exort' ),
                    'title' => __( 'Left Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/left-sidebar.jpg'
                ),
                'right' => array(
                    'alt'   => __( 'Right Sidebar', 'exort' ),
                    'title' => __( 'Right Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/right-sidebar.jpg'
                )
            ),
            'default' => 'full'
        ),
        array(
            'title'     => __( 'Blog Sidebar', 'exort' ),
            'subtitle'  => __( 'Use this option to set sidebar for blog', 'exort' ),
            'id'        => 'sidebar_blog_sidebar',
            'type'      => 'select',
            'options'   => $widget_areas,
            'required'  => array( 'sidebar_blog_layout', '!=', 'full' ),
        ),
        array(
            'title'     => __( 'Archive Layout', 'exort' ),
            'subtitle'  => __( 'Use this option to set layout for archive page', 'exort' ),
            'id'        => 'sidebar_archive_layout',
            'type' => 'image_select',
            'options' => array(
                'full' => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/full-width.jpg'
                ),
                'left' => array(
                    'alt'   => __( 'Left Sidebar', 'exort' ),
                    'title' => __( 'Left Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/left-sidebar.jpg'
                ),
                'right' => array(
                    'alt'   => __( 'Right Sidebar', 'exort' ),
                    'title' => __( 'Right Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/right-sidebar.jpg'
                )
            ),
            'default' => 'full'
        ),
        array(
            'title'     => __( 'Archive Sidebar', 'exort' ),
            'subtitle'  => __( 'Use this option to set sidebar for archive page', 'exort' ),
            'id'        => 'sidebar_archive_sidebar',
            'type'      => 'select',
            'options'   => $widget_areas,
            'required'  => array( 'sidebar_archive_layout', '!=', 'full' )
        ),
        array(
            'title'     => __( 'Search Page Layout', 'exort' ),
            'subtitle'  => __( 'Use this option to set layout for search page', 'exort' ),
            'id'        => 'sidebar_search_layout',
            'type' => 'image_select',
            'options' => array(
                'full' => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/full-width.jpg'
                ),
                'left' => array(
                    'alt'   => __( 'Left Sidebar', 'exort' ),
                    'title' => __( 'Left Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/left-sidebar.jpg'
                ),
                'right' => array(
                    'alt'   => __( 'Right Sidebar', 'exort' ),
                    'title' => __( 'Right Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/right-sidebar.jpg'
                )
            ),
            'default' => 'full'
        ),
        array(
            'title'     => __( 'Search Page Sidebar', 'exort' ),
            'subtitle'  => __( 'Use this option to set sidebar for search page', 'exort' ),
            'id'        => 'sidebar_search_sidebar',
            'type'      => 'select',
            'options'   => $widget_areas,
            'required'  => array( 'sidebar_search_layout', '!=', 'full' )
        ),
        array(
            'title'     => __( 'Single Post Layout', 'exort' ),
            'subtitle'  => __( 'Use this option to set default layout for all posts', 'exort' ),
            'desc'      => __( 'You can override this layout in the post metabox.', 'exort' ),
            'id'        => 'sidebar_post_layout',
            'type' => 'image_select',
            'options' => array(
                'full' => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/full-width.jpg'
                ),
                'left' => array(
                    'alt'   => __( 'Left Sidebar', 'exort' ),
                    'title' => __( 'Left Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/left-sidebar.jpg'
                ),
                'right' => array(
                    'alt'   => __( 'Right Sidebar', 'exort' ),
                    'title' => __( 'Right Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/right-sidebar.jpg'
                )
            ),
            'default' => 'full'
        ),
        array(
            'title'     => __( 'Single Post Sidebar', 'exort' ),
            'subtitle'  => __( 'Use this option to set default sidebar for all posts', 'exort' ),
            'desc'      => __( 'You can override this option in the post metabox.', 'exort' ),
            'id'        => 'sidebar_post_sidebar',
            'type'      => 'select',
            'options'   => $widget_areas,
            'required'  => array( 'sidebar_post_layout', '!=', 'full' )
        ),
        array(
            'title'     => __( 'Single Portfolio Layout', 'exort' ),
            'subtitle'  => __( 'Use this option to set default layout for all portfolio pages', 'exort' ),
            'desc'      => __( 'You can override this layout in the portfolio metabox.', 'exort' ),
            'id'        => 'sidebar_portfolio_layout',
            'type' => 'image_select',
            'options' => array(
                'full' => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/full-width.jpg'
                ),
                'left' => array(
                    'alt'   => __( 'Left Sidebar', 'exort' ),
                    'title' => __( 'Left Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/left-sidebar.jpg'
                ),
                'right' => array(
                    'alt'   => __( 'Right Sidebar', 'exort' ),
                    'title' => __( 'Right Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/right-sidebar.jpg'
                )
            ),
            'default' => 'full'
        ),
        array(
            'title'     => __( 'Single Portfolio Sidebar', 'exort' ),
            'subtitle'  => __( 'Use this option to set default sidebar for all portfolio pages', 'exort' ),
            'desc'      => __( 'You can override this option in the portfolio metabox.', 'exort' ),
            'id'        => 'sidebar_portfolio_sidebar',
            'type'      => 'select',
            'options'   => $widget_areas,
            'required'  => array( 'sidebar_portfolio_layout', '!=', 'full' )
        ),
        array(
            'title'     => __( 'Shop Layout', 'exort' ),
            'subtitle'  => __( 'Use this option to set layout for shop page', 'exort' ),
            'id'        => 'sidebar_shop_layout',
            'type' => 'image_select',
            'options' => array(
                'full' => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/full-width.jpg'
                ),
                'left' => array(
                    'alt'   => __( 'Left Sidebar', 'exort' ),
                    'title' => __( 'Left Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/left-sidebar.jpg'
                ),
                'right' => array(
                    'alt'   => __( 'Right Sidebar', 'exort' ),
                    'title' => __( 'Right Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/right-sidebar.jpg'
                )
            ),
            'default' => 'full'
        ),
        array(
            'title'     => __( 'Shop Sidebar', 'exort' ),
            'subtitle'  => __( 'Use this option to set sidebar for shop', 'exort' ),
            'id'        => 'sidebar_shop_sidebar',
            'type'      => 'select',
            'options'   => $widget_areas,
            'required'  => array( 'sidebar_shop_layout', '!=', 'full' )
        ),
        array(
            'title'     => __( 'Single Product Layout', 'exort' ),
            'subtitle'  => __( 'Use this option to set layout for all product pages', 'exort' ),
            'id'        => 'sidebar_product_layout',
            'desc'      => __( 'You can override this option in the product metabox.', 'exort' ),
            'type' => 'image_select',
            'options' => array(
                'full' => array(
                    'alt'   => __( 'Full Width', 'exort' ),
                    'title' => __( 'Full Width', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/full-width.jpg'
                ),
                'left' => array(
                    'alt'   => __( 'Left Sidebar', 'exort' ),
                    'title' => __( 'Left Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/left-sidebar.jpg'
                ),
                'right' => array(
                    'alt'   => __( 'Right Sidebar', 'exort' ),
                    'title' => __( 'Right Sidebar', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/sidebar/right-sidebar.jpg'
                )
            ),
            'default' => 'full'
        ),
        array(
            'title'     => __( 'Single Product Sidebar', 'exort' ),
            'subtitle'  => __( 'Use this option to set sidebar for all product pages', 'exort' ),
            'desc'      => __( 'You can override this option in the product metabox.', 'exort' ),
            'id'        => 'sidebar_product_sidebar',
            'type'      => 'select',
            'options'   => $widget_areas,
            'required'  => array( 'sidebar_product_layout', '!=', 'full' )
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title' => __( 'Blog', 'exort' ),
    'icon'  => 'fa fa-newspaper-o'
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Blog Layout', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'title' => __( 'Blog Style', 'exort' ),
            'id' => 'blog_style',
            'type' => 'image_select',
            'options' => array(
                'masonry' => array(
                    'alt'   => __( 'Masonry', 'exort' ),
                    'title' => __( 'Masonry', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/masonry.jpg'
                ),
                'list' => array(
                    'alt'   => __( 'List', 'exort' ),
                    'title' => __( 'List', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/list.jpg'
                ),
                'grid' => array(
                    'alt'   => __( 'Grid', 'exort' ),
                    'title' => __( 'Grid', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/grid.jpg'
                ),
                'basic' => array(
                    'alt'   => __( 'Basic', 'exort' ),
                    'title' => __( 'Basic', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/basic.jpg'
                )
            ),
            'default' => 'masonry'
        ),
        array(
            'title'     => __( 'Excerpt Length', 'exort' ),
            'subtitle'  => __( 'Numer of words', 'exort' ),
            'id'        => 'blog_excerpt_length',
            'type'      => 'text',
            'validate'  => 'numeric',
            'default'   => '25'
        ),
        array(
            'type'          => 'slider',
            'id'            => 'blog_columns',
            'title'         => __( 'Blog Columns', 'exort' ),
            'max'           => 6,
            'min'           => 1,
            'step'          => 1,
            'default'       => 3,
            'display_value' => 'text',
        ),
        array(
            'title' => __( 'Blog Pagination Style', 'exort' ),
            'id' => 'blog_pagination_style',
            'type' => 'button_set',
            'options' => array(
                'default' => __( 'Default', 'exort' ),
                'ajax' => __( 'Ajax Pagination', 'exort' ),
                'load_more' => __( 'Infinite Blog with load more button', 'exort' )
            ),
            'default' => 'default'
        )
    )
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Archives Layout', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'title' => __( 'Archive Style', 'exort' ),
            'id' => 'blog_archive_style',
            'type' => 'image_select',
            'options' => array(
                'masonry' => array(
                    'alt'   => __( 'Masonry', 'exort' ),
                    'title' => __( 'Masonry', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/masonry.jpg'
                ),
                'list' => array(
                    'alt'   => __( 'List', 'exort' ),
                    'title' => __( 'List', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/list.jpg'
                ),
                'grid' => array(
                    'alt'   => __( 'Grid', 'exort' ),
                    'title' => __( 'Grid', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/grid.jpg'
                ),
                'basic' => array(
                    'alt'   => __( 'Basic', 'exort' ),
                    'title' => __( 'Basic', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/basic.jpg'
                )
            ),
            'default' => 'masonry'
        ),
        array(
            'title'     => __( 'Excerpt Length', 'exort' ),
            'subtitle'  => __( 'Numer of words', 'exort' ),
            'id'        => 'blog_archive_excerpt_length',
            'type'      => 'text',
            'validate'  => 'numeric',
            'default'   => '25'
        ),
        array(
            'title' => __( 'Archive Blog Columns', 'exort' ),
            'id' => 'blog_archive_columns',
            'type' => 'slider',
            'default' => 3,
            'min'           => 1,
            'step'          => 1,
            'max'           => 6,
            'display_value' => 'text',
        ),
        array(
            'title' => __( 'Archive Blog Pagination Style', 'exort' ),
            'id' => 'blog_archive_pagination_style',
            'type' => 'button_set',
            'options' => array(
                'default' => __( 'Default', 'exort' ),
                'ajax' => __( 'Ajax Pagination', 'exort' ),
                'load_more' => __( 'Infinite Blog with load more button', 'exort' )
            ),
            'default' => 'default'
        )
    )
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Search Page Layout', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'title' => __( 'Search Page Style', 'exort' ),
            'id' => 'blog_search_style',
            'type' => 'image_select',
            'options' => array(
                'masonry' => array(
                    'alt'   => __( 'Masonry', 'exort' ),
                    'title' => __( 'Masonry', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/masonry.jpg'
                ),
                'list' => array(
                    'alt'   => __( 'List', 'exort' ),
                    'title' => __( 'List', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/list.jpg'
                ),
                'grid' => array(
                    'alt'   => __( 'Grid', 'exort' ),
                    'title' => __( 'Grid', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/grid.jpg'
                ),
                'basic' => array(
                    'alt'   => __( 'Basic', 'exort' ),
                    'title' => __( 'Basic', 'exort' ),
                    'img'   => EXORT_URL . '/images/theme-options/blog/basic.jpg'
                )
            ),
            'default' => 'masonry'
        ),
        array(
            'title'     => __( 'Excerpt Length', 'exort' ),
            'subtitle'  => __( 'Numer of words', 'exort' ),
            'id'        => 'blog_search_excerpt_length',
            'type'      => 'text',
            'validate'  => 'numeric',
            'default'   => '25'
        ),
        array(
            'title' => __( 'Search Page Columns', 'exort' ),
            'id' => 'blog_search_columns',
            'type' => 'slider',
            'default' => 3,
            'min'           => 1,
            'step'          => 1,
            'max'           => 6,
            'display_value' => 'text',
        ),
        array(
            'title' => __( 'Search Page Pagination Style', 'exort' ),
            'id' => 'blog_search_pagination_style',
            'type' => 'button_set',
            'options' => array(
                'default' => __( 'Default', 'exort' ),
                'ajax' => __( 'Ajax Pagination', 'exort' ),
                'load_more' => __( 'Infinite Blog with load more button', 'exort' )
            ),
            'default' => 'default'
        )
    )
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Blog Posts', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => __( 'Post Meta Date Format', 'exort' ),
            'id'        => 'blog_post_meta_date_format',
            'type'      => 'text',
            'default'   => 'j F Y'
        ),
        array(
            'title' => __( 'Sharing', 'exort' ),
            'id'    => 'blog_post_sharing',
            'type'  => 'button_set',
            'multi' => true,
            'options' => array(
                'facebook' => 'Facebook',
                'twitter' => 'Twitter',
                'google' => 'Google+',
                'linkedin' => 'LinkedIn',
                'pinterest' => 'Pinterest'
            ),
            'default' => array( 'facebook', 'twitter' )
        ),
        array(
            'title'     => __( 'Show Post Like Button', 'exort' ),
            'id'        => 'blog_show_post_like_button',
            'type'      => 'switch',
            'default'   => true
        ),
        array(
            'title'     => __( 'Show Post Share Button', 'exort' ),
            'id'        => 'blog_show_post_share_button',
            'type'      => 'switch',
            'default'   => true
        )
    )
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Single Post', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => __( 'Page View Option', 'exort' ),
            'subtitle'  => __( 'Use this option to set page view for single post pages', 'exort' ),
            'desc'      => __( 'You can override this layout in the post metabox.', 'exort' ),
            'id'        => 'blog_post_page_view',
            'type'      => 'button_set',
            'options'   => array(
                'default'   => __( 'Default', 'exort' ),
                'full'      => __( 'Full Width Media section', 'exort' )
            ),
            'default'   => 'default'
        ),
        array(
            'title'     => __( 'Show Post Like Button', 'exort' ),
            'id'        => 'blog_post_show_post_like_button',
            'type'      => 'switch',
            'default'   => true
        ),
        array(
            'title'     => __( 'Show Post Share Button', 'exort' ),
            'id'        => 'blog_post_show_post_share_button',
            'type'      => 'switch',
            'default'   => true
        ),
        array(
            'title' => __( 'Show Author info in posts', 'exort' ),
            'id' => 'blog_show_author_in_posts',
            'type' => 'switch',
            'default' => true
        ),
        array(
            'title' => __( 'Show Related posts', 'exort' ),
            'id' => 'blog_show_related_posts',
            'type' => 'switch',
            'default' => true
        ),
        array(
            'title' => __( 'Show Comments', 'exort' ),
            'id' => 'blog_show_comments',
            'type' => 'switch',
            'default' => true
        ),
        array(
            'title'     => __( 'Navigation Arrows', 'exort' ),
            'id'        => 'blog_prev_next_nav',
            'type'      => 'select',
            'subtitle'  => __( 'Show Prev/Next Navigation', 'exort' ),
            'options'   => array(
                'hide'          => __( 'Hide', 'exort' ),
                'show'          => __( 'Show', 'exort' ),
                'same_category' => __( 'Show Navigation in the same category', 'exort' ),
            ),
            'default'   => 'show',
            'class'     => 'disable_empty_field',
        ),
        array(
            'title' => __( 'Maximum number of related posts', 'exort' ),
            'id' => 'blog_rel_posts_max',
            'type' => 'text',
            'validate' => 'numeric',
            'default' => '6',
            'required' => array( 'blog_show_related_posts', '=', true )
        )
    )
) );

$portfolio_pages = get_pages( array(
    'meta_key'    => '_wp_page_template',
    'meta_value'  => 'template-portfolio.php',
    'sort_order'  => 'ASC',
    'sort_column' => 'ID'
) );
$portfolio_pages_arr = array();
foreach ( $portfolio_pages as $p ) {
    $portfolio_pages_arr[$p->ID] = $p->post_title;
}

Redux::setSection( $opt_name, array(
    'title' => __( 'Portfolio', 'exort' ),
    'icon'  => 'el el-tasks',
    'fields'     => array(
        array(
            'title'     => __( 'Portfolio Page', 'exort' ),
            'subtitle'  => __( 'Assign page for portfolio', 'exort' ),
            'id'        => 'portfolio_page',
            'type'      => 'select',
            'options'   => $portfolio_pages_arr
        ),
        array(
            'title'     => __( 'Excerpt Length', 'exort' ),
            'subtitle'  => __( 'Numer of words', 'exort' ),
            'id'        => 'portfolio_excerpt_length',
            'type'      => 'text',
            'validate'  => 'numeric',
            'default'   => '12'
        ),
        array(
            'title' => __( 'Portfolio Date Format', 'exort' ),
            'id' => 'portfolio_date_format',
            'type' => 'text',
            'default' => 'j F Y'
        ),
        array(
            'title' => __( 'Sharing', 'exort' ),
            'id' => 'portfolio_sharing',
            'type' => 'button_set',
            'multi' => true,
            'options' => array(
                'facebook' => 'Facebook',
                'twitter' => 'Twitter',
                'google' => 'Google+',
                'linkedin' => 'LinkedIn',
                'pinterest' => 'Pinterest'
            ),
            'default' => array(
                'facebook',
                'twitter'
            )
        ),
        array(
            'title'     => __( 'Portfolio Comments', 'exort' ),
            'subtitle'  => __( 'Show Comments', 'exort' ),
            'id'        => 'portfolio_show_comments',
            'type'      => 'switch',
            'default'   => false
        ),
        array(
            'title'     => __( 'Navigation Arrows', 'exort' ),
            'id'        => 'portfolio_prev_next_nav',
            'type'      => 'select',
            'subtitle'  => __( 'Show Prev/Next Navigation', 'exort' ),
            'options'   => array(
                'hide'          => __( 'Hide', 'exort' ),
                'show'          => __( 'Show', 'exort' ),
                'same_category' => __( 'Show Navigation in the same category', 'exort' ),
            ),
            'default'   => 'show',
            'class'     => 'disable_empty_field',
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title' => __( 'WooCommerce', 'exort' ),
    'icon'  => 'el el-shopping-cart'
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Shop', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'title' => __( 'Shop Columns', 'exort' ),
            'id' => 'shop_columns',
            'type' => 'button_set',
            'default' => '4',
            'options' => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            )
        ),
        array(
            'title' => __( 'Products Per Page', 'exort' ),
            'id' => 'shop_posts_count',
            'type' => 'text',
            'default' => '12'
        ),
        array(
            'title'     => __( 'Images', 'exort' ),
            'subtitle'  => __( 'Show secondary image on hover', 'exort' ),
            'id'        => 'shop_show_secondary_image',
            'type'      => 'switch',
            'default'   => true
        ),
    )
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Single Product', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'type' => 'switch',
            'id' => 'product_show_related_products',
            'title' => __( 'Show Related Products', 'exort' ),
            'subtitle' => __( 'If you want to show replated products in the single product page, please check this option.', 'exort' ),
            'default' => true,
        ),
        array(
            'type' => 'button_set',
            'id' => 'product_related_product_columns',
            'title' => __( 'Related Product Columns', 'exort' ),
            'default' => '4',
            'options' => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            )
        ),
        array(
            'type' => 'text',
            'id' => 'product_related_product_count',
            'title' => __( 'Related Product Count', 'exort' ),
            'default' => '4'
        ),
        array(
            'type' => 'switch',
            'id' => 'product_show_upsell_products',
            'title' => __( 'Show Upsells', 'exort' ),
            'subtitle' => __( 'If you want to show upsells in the single product page, please check this option.', 'exort' ),
            'default' => false,
        ),
        array(
            'type' => 'button_set',
            'id' => 'product_upsell_product_columns',
            'title' => __( 'Upsell Columns', 'exort' ),
            'default' => '4',
            'options' => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            )
        ),
        array(
            'type' => 'text',
            'id' => 'product_upsell_product_count',
            'title' => __( 'Upsell Product Count', 'exort' ),
            'default' => '4'
        ),
        array(
            'type' => 'button_set',
            'id' => 'product_sharing',
            'title' => __( 'Sharing', 'exort' ),
            'multi' =>  true,
            'options' => array(
                'facebook'  => 'Facebook',
                'twitter'   => 'Twitter',
                'google'    => 'Google+',
                'linkedin'  => 'LinkedIn',
                'pinterest' => 'Pinterest'
            ),
            'default' => array(
                'facebook',
                'twitter'
            )
        )
    )
) );
Redux::setSection( $opt_name, array(
    'title' => __( 'Cart', 'exort' ),
    'subtitle' => __( 'Shopping Cart', 'exort' ),
    'subsection' => true,
    'fields'     => array(
        array(
            'title' => __( 'Show Cross Sells', 'exort' ),
            'subtitle' => __( 'If you want to show cross sells in the cart page, please check this option.', 'exort' ),
            'id' => 'cart_show_cross_sells',
            'type' => 'switch',
            'default' => false,
        ),
        array(
            'title' => __( 'Cross Sell Columns', 'exort' ),
            'id' => 'cart_cross_sells_columns',
            'type' => 'button_set',
            'default' => '4',
            'options' => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' )
        ),
        array(
            'title' => __( 'Cross Sell Product Count', 'exort' ),
            'id' => 'cart_cross_sells_count',
            'type' => 'text',
            'default' => '4'
        ),
        array(
            'title' => __( 'Show Mini Cart', 'exort' ),
            'subtitle' => __( 'If you want to show mini cart in top bar, please check this option.', 'exort' ),
            'id' => 'cart_show_mini_cart',
            'type' => 'switch',
            'default' => true,
        )
    )
) );

Redux::setSection( $opt_name, array(
    'title' => __( 'Translate', 'exort' ),
    'icon' => 'el el-flag-alt',
    'fields' => array(
        array(
            'title'     => __( 'Enable Translate', 'exort' ),
            'desc'      => __( 'Turn this option off if you want to use language files for more complex translation.', 'exort' ),
            'id'        => 'translate_enable',
            'type'      => 'switch',
            'default'   => true
        ),
        array(
            'title'     => __( 'Blog Page Title', 'exort' ),
            'id'        => 'translate_blog_page_title',
            'type'      => 'text',
            'default'   => __( 'Blog', 'exort' )
        ),
        array(
            'title'     => __( 'Portfolio Name', 'exort' ),
            'id'        => 'translate_portfolio_name',
            'type'      => 'text',
            'default'   => __( 'Portfolio', 'exort' )
        ),
        array(
            'title'     => __( 'All Portfolio', 'exort' ),
            'id'        => 'translate_portfolio_pl_name',
            'type'      => 'text',
            'default'   => __( 'All Portfolio', 'exort' )
        ),
        array(
            'title'     => __( 'Selected Portfolio', 'exort' ),
            'id'        => 'translate_portfolio_selected_pl_name',
            'type'      => 'text',
            'default'   => __( 'Selected Work', 'exort' )
        ),
        array(
            'title'     => __( 'Shop Page Title', 'exort' ),
            'id'        => 'translate_shop_page_title',
            'type'      => 'text',
            'default'   => __( 'Shop', 'exort' )
        ),
        array(
            'title'     => __( 'Pricing Table Style 4 Active Text', 'exort' ),
            'id'        => 'translate_pt4_active_text',
            'type'      => 'text',
            'default'   => __( 'Most Popular', 'exort' )
        ),
    )
) );

$social_links = exort_get_social_site_names();
$exort_social_options = array();
foreach ( $social_links as $key => $name ) {
    $exort_social_options[] = array(
        'type'      => 'text',
        'id'        => 'social_' . $key . '_url',
        'title'     => sprintf(__( '%s Profile URL', 'exort' ), $name),
        'default'   => ''
    );
}
Redux::setSection( $opt_name, array(
    'title' => __( 'Social', 'exort' ),
    'icon'  => 'fa fa-recycle',
    'fields' => $exort_social_options
) );

Redux::setSection( $opt_name, array(
    'title'     => __( 'Custom', 'exort' ),
    'icon'      => 'el el-edit',
    'desc'      => __( 'Quickly add custom CSS or JavaScript to your site without any complicated setups.', 'exort' ),
    'fields'    => array(
        array(
            'type'      => 'ace_editor',
            'id'        => 'custom_css',
            'title'     => __( 'Custom CSS', 'exort' ),
            'mode'      => 'css',
            'theme'     => 'chrome'
        ),
        array(
            'type'      => 'ace_editor',
            'id'        => 'custom_javascript',
            'title'     => __( 'Custom Javascript', 'exort' ),
            'mode'      => 'javascript',
            'theme'     => 'chrome'
        )
    )
) );


function removeDemoModeLink($framework) {
    // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        remove_filter( 'plugin_row_meta', array(
            ReduxFrameworkPlugin::instance(),
            'plugin_metalinks'
        ), null, 2 );

        // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
        remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
    }

    remove_action( 'admin_notices', array( $framework, '_admin_notices' ), 99 );
}
add_action( 'redux/loaded', 'removeDemoModeLink', 10, 1 );

function exort_redux_update_current_version() {
    $saveVer = Redux_Helpers::major_version( get_option( 'redux_version_upgraded_from' ) );
    if ( empty( $saveVer ) ) {
        update_option( 'redux_version_upgraded_from', ReduxFramework::$_version );
    }
}
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
    add_action( 'redux/loaded', 'exort_redux_update_current_version', 1 );
}