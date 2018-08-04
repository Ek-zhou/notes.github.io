<?php
/*
 * Define functions for meta box and initialize meta boxes
 */

if ( !function_exists( 'exort_register_meta_boxes' ) ) {
    function exort_register_meta_boxes( $meta_boxes ) {

        // Quote
        $meta_boxes[] = array(
            'id' => 'exort-metabox-quote',
            'title' => __( 'Quote Post Settings', 'exort' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __( 'The Quote', 'exort' ),
                    'desc' => __( 'Input your quote.', 'exort' ),
                    'id'   => '_exort_quote_quote',
                    'type' => 'textarea',
                    'std'  => ''
                ),
                array(
                    'name' => __( 'Author', 'exort' ),
                    'desc' => __( 'Input the name of author who originally said.', 'exort' ),
                    'id'   => '_exort_quote_cite',
                    'type' => 'text',
                    'std'  => ''
                )
            )
        );

        // Video
        $video_fields = array(
            array(
                'name' => __( 'Video Ratio', 'exort' ),
                'id'   => '_exort_video_ratio',
                'type' => 'select',
                'std'  => '',
                'options' => array(
                    '16:9' => '16:9',
                    '5:3' => '5:3',
                    '5:4' => '5:4',
                    '4:3' => '4:3',
                    '3:2' => '3:2',
                )
            ),
            array(
                'name' => __( 'MP4 File URL', 'exort' ),
                'id'   => '_exort_video_url',
                'type' => 'text',
                'size' => 60,
                'std'  => ''
            ),
            array(
                'name' => __( 'Embedded Video Code', 'exort' ),
                'desc' => __( 'If you want to use embedded video such as YouTube or Vimeo, write the embed code here.', 'exort' ),
                'id'   => '_exort_video_embed',
                'type' => 'textarea',
                'std'  => ''
            ),
        );
        $meta_boxes[] = array(
            'id' => 'exort-metabox-video',
            'title' => __( 'Video Post Settings', 'exort' ),
            'description' => __( 'This enables you to embed video into your post.', 'exort' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => $video_fields
        );

        // Audio
        $meta_boxes[] = array(
            'id'            => 'exort-metabox-audio',
            'title'         => __( 'Audio Post Settings', 'exort' ),
            'description'   => __( 'This enables you to embed audio into your post.', 'exort' ),
            'pages'         => array( 'post' ),
            'context'       => 'normal',
            'priority'      => 'high',
            'fields'        => array(
                array(
                    'name' => __( 'Audio URL', 'exort' ),
                    'id'   => '_exort_audio_mp3',
                    'type' => 'text',
                    'size' => 60,
                    'std'  => ''
                ),
                array(
                    'name' => __( 'Embedded Audio Code', 'exort' ),
                    'desc' => __( 'If you want to use embedded audio such as Soundcloud, write the embed code here.', 'exort' ),
                    'id'   => '_exort_audio_embed',
                    'type' => 'textarea',
                    'std'  => ''
                )
            )
        );

        // sidebar options
        $widget_areas = exort_get_registered_sidebars();
        if ( empty($widget_areas ) ) {
            $widget_areas = array('none' => __('None', 'exort'));
        }

        $page_sidebar_containers = array( 'page', 'post', 'portfolio' );
        foreach ( $page_sidebar_containers as $page ) {
            $meta_boxes[] = array(
                'id' => 'exort-metabox-page-sidebar',
                'title' => __( 'Page layout', 'exort' ),
                'pages' => array( $page ),
                'context' => 'side',
                'priority' => 'low',
                'fields' => array(
                    // Sidebar option
                    array(
                        'name' => __( 'Sidebar position:', 'exort' ),
                        'id' => '_exort_' . $page . '_sidebar_position',
                        'type' => 'radio',
                        'std' => exort_get_option( 'sidebar_' . $page . '_layout', 'full' ),
                        'options' => array(
                            'left' => __( 'Left', 'exort' ),
                            'right' => __( 'Right', 'exort' ),
                            'full' => __( 'No Sidebar', 'exort' )
                        )
                    ),

                    // Sidebar widget area
                    array(
                        'name' => __( 'Sidebar widget area:', 'exort' ),
                        'id' => '_exort_' . $page . '_sidebar_widget_area',
                        'type' => 'select',
                        'options' => $widget_areas,
                        'std' => exort_get_option( 'sidebar_' . $page . '_sidebar', 'sidebar-main' )
                    ),
                ),
            );
        }

        // Portfolio Item Settings
        $meta_boxes[] = array(
            'id' => 'exort-meta-box-portfolio-item',
            'title' => __( 'Portfolio Item Settings', 'exort' ),
            'description' => __( 'Select the appropriate options for your portfolio item.', 'exort' ),
            'pages' => array( 'portfolio' ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'      => __( 'Media Type', 'exort' ),
                    'id'        => '_exort_portfolio_item_media_type',
                    'type'      => 'select',
                    'options'   => array(
                        'image'     => __( 'Image', 'exort' ),
                        'gallery'   => __( 'Gallery', 'exort' ),
                        'video'     => __( 'Video', 'exort' )
                    ),
                    'std'       => 'image',
                ),
                array(
                    'name'      => __( 'Image Size for featured image', 'exort' ),
                    'id'        => '_exort_portfolio_item_image_size',
                    'desc'      => __( 'Size for Masonry Flat Style Portfolio', 'exort' ),
                    'type'      => 'select',
                    'options'   => array(
                        ''              => __( 'Default', 'exort' ),
                        'double-width'  => __( 'Big', 'exort' ),
                        'tall'          => __( 'Tall', 'exort' )
                    )
                ),
                array(
                    'name'      => __( 'Gallery View Style', 'exort' ),
                    'id'        => '_exort_portfolio_item_gallery_view_style',
                    'type'      => 'select',
                    'options'   => array(
                        'slider'    => __( 'Slider', 'exort' ),
                        'list'      => __( 'List', 'exort' ),
                    ),
                    'std'       => 'slider'
                ),
                array(
                    'name'      => __( 'Columns in Gallery View Style', 'exort' ),
                    'id'        => '_exort_portfolio_item_gallery_columns',
                    'desc'      => __( 'Select the columns of gallery.', 'exort' ),
                    'type'      => 'select',
                    'options'   => array(
                        '2' => 'Two',
                        '3' => 'Three',
                        '4' => 'Four',
                        '5' => 'Five',
                    ),
                    'std'       => '3'
                ),
                array(
                    'type'      => 'divider',
                    'id'        => '_exort_portfolio_item_settings_divider1'
                ),
                array(
                    'name'      => __( 'Project View Options', 'exort' ),
                    'id'        => '_exort_portfolio_item_view_options',
                    'desc'      => __( 'Select vertical if you want to display portfolio media content to the left and portfolio content to the right.', 'exort' ),
                    'type'      => 'select',
                    'options'   => array(
                        'wide'      => __( 'Wide', 'exort' ),
                        'vertical'  => __( 'Vertical', 'exort' )
                    ),
                    'std'       => 'wide'
                ),
                array(
                    'name'      => __( 'Remove Meta Fields?', 'exort' ),
                    'desc'      => __( 'Meta fields section is removed if this option is checked.', 'exort' ),
                    'id'        => '_exort_portfolio_remove_meta',
                    'type'      => 'checkbox',
                    'std'       => false
                ),
                array(
                    'type'      => 'divider',
                    'id'        => '_exort_portfolio_item_settings_divider2'
                ),
                array(
                    'name'      => __( 'Project Link', 'exort' ),
                    'id'        => '_exort_portfolio_item_project_link',
                    'desc'      => __( 'Provide an external link for this project.', 'exort' ),
                    'type'      => 'text',
                    'size'      => 60
                ),
                array(
                    'name'      => __( 'Client', 'exort' ),
                    'id'        => '_exort_portfolio_item_client',
                    'type'      => 'text',
                    'size'      => 60,
                ),
                array(
                    'type'      => 'divider',
                    'id'        => '_exort_portfolio_item_settings_divider3'
                ),
                array(
                    'name'      => __( 'Short Description', 'exort' ),
                    'id'        => "_exort_portfolio_item_desc",
                    'type'      => 'textarea',
                    'rows'       => 8
                ),
                array(
                    'name'      => __( 'Related Portfolios', 'exort' ),
                    'id'        => '_exort_portfolio_related_works',
                    'desc'      => __( 'Comma separated id array for related works.', 'exort' ),
                    'type'      => 'text',
                    'size'      => 40,
                ),
            )
        );

        $meta_boxes[] = array(
            'id' => 'exort-metabox-portfolio-video',
            'title' => __( 'Video Portfolio Item Settings', 'exort' ),
            'description' => __( 'This enables you to embed video into your portfolio.', 'exort' ),
            'pages' => array( 'portfolio' ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => $video_fields
        );

        // Portfolio page template
        $meta_boxes[] = array(
            'id'            => 'exort-meta-box-portfolio-page',
            'title'         => __( 'Portfolio Settings', 'exort' ),
            'description'   => __( 'Here you will find various options you can use to setup your portfolio.', 'exort' ),
            'pages'         => array( 'page' ),
            'context'       => 'normal',
            'priority'      => 'high',
            'fields'        => array(
                array(
                    'name'          => __( 'Category Select', 'exort' ),
                    'id'            => '_exort_portfolio_category_filters',
                    'type'          => 'taxonomy_advanced',
                    'placeholder'   => __( 'All Categories', 'exort' ),
                    'options'       => array(
                        'taxonomy'  => 'portfolio_category',
                        'type'      => 'select_advanced',
                    ),
                    'multiple'      => true
                ),
                array(
                    'type'      => 'divider',
                    'id'        => '_exort_portfolio_page_settings_divider1'
                ),
                array(
                    'name'      => __( 'Columns', 'exort' ),
                    'desc'      => __( 'Select how many columns you would like to display for your portfolio.', 'exort' ),
                    'id'        => '_exort_portfolio_columns',
                    'type'      => 'select',
                    'std'       => '2',
                    'options'   => array(
                        '1' => 'One',
                        '2' => 'Two',
                        '3' => 'Three',
                        '4' => 'Four',
                    )
                ),
                array(
                    'type'      => 'divider',
                    'id'        => '_exort_portfolio_page_settings_divider2'
                ),
                array(
                    'name'      => __( 'Full Width?', 'exort' ),
                    'desc'      => __( 'Sidebar is disabled if this option is checked.', 'exort' ),
                    'id'        => '_exort_portfolio_is_fullwidth',
                    'type'      => 'checkbox',
                    'std'       => false
                ),
                array(
                    'name'      => __( 'Posts Per Page', 'exort' ),
                    'desc'      => __( 'Select how many posts you would like to display per page for your portfolio.', 'exort' ),
                    'id'        => '_exort_portfolio_posts_per_page',
                    'type'      => 'number',
                    'std'       => '12',
                ),
                array(
                    'type'      => 'divider',
                    'id'        => '_exort_portfolio_page_settings_divider3'
                ),
                array(
                    'name'      => __( 'Style', 'exort' ),
                    'desc'      => __( 'Select the style of layout.', 'exort' ),
                    'id'        => '_exort_portfolio_style',
                    'type'      => 'select',
                    'std'       => 'flat',
                    'options'   => array(
                        'flat'         => __( 'Flat', 'exort' ),
                        'masonry'       => __( 'Masonry', 'exort' ),
                    )
                ),
                array(
                    'name'      => __( 'Hover Style', 'exort' ),
                    'desc'      => __( 'Select the hover style of layout.', 'exort' ),
                    'id'        => '_exort_portfolio_hover_style',
                    'type'      => 'select',
                    'std'       => 'flat',
                    'options'   => array(
                        '1'         => __( 'Style 1', 'exort' ),
                        '2'         => __( 'Style 2', 'exort' ),
                        '3'         => __( 'Style 3', 'exort' ),
                        '4'         => __( 'Style 4', 'exort' ),
                    )
                ),
                array(
                    'name'      => __( 'Space?', 'exort' ),
                    'desc'      => __( '20px spacing between items', 'exort' ),
                    'id'        => '_exort_portfolio_is_space',
                    'type'      => 'checkbox',
                    'std'       => false
                ),
                array(
                    'name'      => __( 'Display Content Area', 'exort' ),
                    'desc'      => __( 'If you don\'t want to display page content, please select No. Otherwise select the content area position to display page content.' , 'exort' ),
                    'id'        => '_exort_portfolio_content_area',
                    'type'      => 'select',
                    'std'       => 'no',
                    'options'   => array(
                        'no' => __( 'No', 'exort' ),
                        'before_items_first_page' => __( 'Before items on only first page', 'exort' ),
                        'before_items_all_page' => __( 'Before items on all pages', 'exort' ),
                        'after_items_first_page' => __( 'After items on only first page', 'exort' ),
                        'after_items_all_page' => __( 'After items on all pages', 'exort' ),
                    )
                ),
                array(
                    'name'      => __( 'Filtering Visibility', 'exort' ),
                    'desc'      => __( 'Hiding the portfolio filters will remove the ability to sort portfolio items by category.', 'exort' ),
                    'id'        => '_exort_portfolio_disable_filtering',
                    'type'      => 'select',
                    'std'       => 'hide',
                    'options'   => array(
                        'hide'      => __( 'Hide', 'exort' ),
                        '1'         => __( 'Style 1', 'exort' ),
                        '2'         => __( 'Style 2', 'exort' ),
                        '3'         => __( 'Style 3', 'exort' ),
                    )
                ),
                array(
                    'name'      => __( 'Loading Style', 'exort' ),
                    'id'        => '_exort_portfolio_loading_style',
                    'type'      => 'select',
                    'std'       => 'default',
                    'options'   => array(
                        'default'   => __( 'Default', 'exort' ),
                        'none'      => __( 'Disable Pagination', 'exort' ),
                        'ajax'      => __( 'Ajax Pagination', 'exort' ),
                        'load_more' => __( 'Ajax Load More', 'exort' ),
                    )
                ),
                array(
                    'type'      => 'divider',
                    'id'        => '_exort_portfolio_page_settings_divider4'
                ),
                array(
                    'name'      => __( 'Order By', 'exort' ),
                    'id'        => '_exort_portfolio_orderby',
                    'type'      => 'select',
                    'std'       => 'date',
                    'options' => array(
                        'date'      => __( 'Date', 'exort' ),
                        'name'      => __( 'Name', 'exort' )
                    )
                ),
                array(
                    'name'      => __( 'Order', 'exort' ),
                    'id'        => '_exort_portfolio_order',
                    'type'      => 'radio',
                    'std'       => 'DESC',
                    'options' => array(
                        'ASC' => __( 'ASC', 'exort' ),
                        'DESC' => __( 'DESC', 'exort' )
                    )
                ),
            )
        );

        // gallery post and portfolio
        $meta_boxes[] = array(
            'id'        => 'exort-metabox-post-gallery',
            'title'     => __( 'Post Gallery Items', 'exort' ),
            'pages'     => array( 'post', 'portfolio' ),
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'id'    => '_exort_post_gallery',
                    'type'  => 'image_advanced'
                )
            )
        );

        // Page Settings
        $fields = array();
        $fields[] = array(
            'type'      => 'checkbox',
            'id'        => '_exort_page_settings_action_bar',
            'name'      => __( 'Show Top Bar', 'exort' ),
            'std'       => false
        );
        $fields[] = array(
            'type'      => 'select',
            'id'        => '_exort_page_settings_menu_style',
            'name'      => __( 'Menu Style', 'exort' ),
            'options'   => array(
                'default-light'                 => __( 'Default Light', 'exort' ),
                'default-dark'                  => __( 'Default Dark', 'exort' ),
                'transparent-light'             => __( 'Transparent Light', 'exort' ),
                'transparent-dark'              => __( 'Transparent Dark', 'exort' ),
                'logo-center-top'               => __( 'Logo Center Top', 'exort' ),
                'logo-center-top-transparent'   => __( 'Logo Center Top Transparent', 'exort' ),
                'fullscreen-menu'               => __( 'Fullscreen Menu', 'exort' ),
                'side-menu'                     => __( 'Side Menu', 'exort' ),
            ),
            'std'       => 'default-light'
        );
        $fields[] = array(
            'type'      => 'checkbox',
            'id'        => '_exort_page_settings_fullwidth_menu',
            'name'      => __( 'Full Width Menu', 'exort' ),
            'std'       => false
        );
        $fields[] = array(
            'type'      => 'taxonomy_advanced',
            'id'        => '_exort_page_settings_custom_menu',
            'name'      => __( 'Custom Menu', 'exort' ),
            'options'   => array(
                'taxonomy'  => 'nav_menu',
                'type'      => 'select',
            ),
        );
        $fields[] = array(
            'type'      => 'checkbox',
            'id'        => '_exort_page_settings_one_page_nav',
            'name'      => __( 'One Page Navigation', 'exort' ),
            'std'       => '0'
        );
        $fields[] = array(
            'type'      => 'checkbox',
            'id'        => '_exort_page_settings_showcase',
            'name'      => __( 'Showcase Style', 'exort' ),
            'std'       => false
        );
        $fields[] = array(
            'type'      => 'divider',
            'id'        => '_exort_page_settings_divider1'
        );
        $fields[] = array(
            'type'      => 'checkbox',
            'id'        => '_exort_page_settings_subheader_hide',
            'name'      => __( 'Hide Sub Header', 'exort' ),
            'std'       => '0'
        );
        $fields[] = array(
            'type'      => 'select',
            'id'        => '_exort_page_settings_subheader_layout',
            'name'      => __( 'Sub Header Layout', 'exort' ),
            'options'   => array(
                'both-center'                   => __( 'Title & Breadcrumbs centered', 'exort' ),
                'title-left,breadcrumb-right'   => __( 'Title left & Breadcrumbs right', 'exort' ),
                'title-right,breadcrumb-left'   => __( 'Title right & Breadcrumbs left', 'exort' ),
            ),
            'std'       => __( 'Title & Breadcrumbs centered', 'exort' )
        );
        $fields[] = array(
            'type'      => 'text',
            'id'        => '_exort_page_settings_subtitle',
            'name'      => __( 'Page Sub Title', 'exort' ),
            'size'      => 80,
            'std'       => ''
        );
        $fields[] = array(
            'type'      => 'image_advanced',
            'id'        => '_exort_page_settings_subheader_background_image',
            'name'      => __( 'Sub Header Background Image', 'exort' ),
            'max_file_uploads' => 1,
            'std'       => ''
        );
        $fields[] = array(
            'type'      => 'checkbox',
            'id'        => '_exort_page_settings_subheader_parallax',
            'name'      => __( 'Parallax?', 'exort' ),
            'desc'      => __( 'This is useful for only background image.', 'exort' ),
            'std'       => ''
        );
        $fields[] = array(
            'type'      => 'select',
            'id'        => '_exort_page_settings_subheader_border',
            'name'      => __( 'Sub Header Border Style', 'exort' ),
            'desc'      => __( 'This is useful for only "Title & Breadcrumbs centered" layout.', 'exort' ),
            'options'   => array(
                'none'          => __( 'None', 'exort' ),
                'thin'          => __( 'Thin & Transparent Background', 'exort' ),
                'dark-thick'    => __( 'Thick & Dark', 'exort' ),
                'light-thick'   => __( 'Thick & Light', 'exort'),
            ),
            'std'       => 'none'
        );
        $fields[] = array(
            'type'      => 'text',
            'id'        => '_exort_page_settings_subheader_background_video',
            'name'      => __( 'Sub Header Background Video', 'exort' ),
            'size'      => 80,
            'std'       => ''
        );
        $fields[] = array(
            'type'      => 'divider',
            'id'        => '_exort_page_settings_divider2'
        );
        if ( class_exists( 'RevSlider' ) ) {
            $rev_slider = new RevSlider();
            $rev_sliders = $rev_slider->getArrSliders();
            $sliders = array( __( 'Deactivated', 'exort' ) );
            if ( ! empty( $rev_sliders ) ) {
                foreach ( $rev_sliders as $slider ) {
                    $sliders[$slider->getAlias()] = $slider->getAlias();
                }
            }
            $fields[] = array(
                'type'      => 'select',
                'id'        => '_exort_page_settings_rev_slider',
                'name'      => __( 'Revolution Slider', 'exort' ),
                'desc'      => __( 'To activate your slider, select an option from the dropdown. To deactivate your slider, set the dropdown back to "Deactivated."', 'exort' ),
                'options'   => $sliders,
                'std'       => 'Deactivated',
            );
        }
        $fields[] = array(
            'type'      => 'divider',
            'id'        => '_exort_page_settings_divider3'
        );
        $fields[] = array(
            'type'      => 'text',
            'id'        => '_exort_page_settings_bodyclass',
            'name'      => __( 'Custom Body Class', 'exort' ),
            'size'      => 80,
            'std'       => ''
        );
        $fields[] = array(
            'type'      => 'textarea',
            'id'        => '_exort_custom_css',
            'name'      => __( 'Custom CSS', 'exort' ),
            'desc'      => __( 'Enter custom css code here.', 'exort' ),
            'rows'      => 8
        );
        $meta_boxes[] = array(
            'id' => 'exort-metabox-page-settings',
            'title' => __( 'Page Settings', 'exort' ),
            'pages' => array( 'page', 'portfolio', 'product' ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => $fields
        );

        $fields = array();
        $fields[] = array(
            'name'      => __( 'Custom Layout', 'exort' ),
            'id'        => '_exort_product_page_layout',
            'type'      => 'select',
            'options'   => array(
                'detail1' => 'Detail 1',
                'detail2' => 'Detail 2'
            ),
            'std'       => 'detail1'
        );
        $meta_boxes[] = array(
            'id' => 'exort-metabox-product-page-layout',
            'title' => __( 'Product Page Layout', 'exort' ),
            'pages' => array( 'product' ),
            'context' => 'side',
            'priority' => 'default',
            'fields' => $fields
        );

        return $meta_boxes;
    }
}
add_filter( 'rwmb_meta_boxes', 'exort_register_meta_boxes' );

if ( !function_exists( 'exort_metabox_update_selectfield' ) ) {
    function exort_metabox_update_selectfield($value)
    {
        $value = str_replace("<option></option>", "", $value);
        $value = str_replace("<option value=''></option>", "", $value);
        return $value;
    }
}
add_filter( 'rwmb_select_html', 'exort_metabox_update_selectfield' );