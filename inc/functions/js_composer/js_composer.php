<?php

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// ! Removing unwanted shortcodes
vc_remove_element('vc_icon');
vc_remove_element('vc_btn');
vc_remove_element('vc_cta');
vc_remove_element('vc_tta_accordion');
vc_remove_element('vc_tta_tabs');
vc_remove_element('vc_tta_tour');
vc_remove_element('vc_gallery');
vc_remove_element('vc_images_carousel');
vc_remove_element('vc_message');
vc_remove_element('vc_posts_slider');
vc_remove_element('vc_basic_grid');
vc_remove_element('vc_media_grid');
vc_remove_element('vc_masonry_grid');
vc_remove_element('vc_masonry_media_grid');
vc_remove_element('vc_progress_bar');
vc_remove_element('vc_pie');
vc_remove_element('vc_round_chart');
vc_remove_element('vc_line_chart');
vc_remove_element('vc_widget_sidebar');

// Replace rows and columns classes
function custom_css_classes_for_elements($class_string, $tag, $atts) {
    if ( $tag =='vc_row' || $tag =='vc_row_inner' ) {
        if ( strpos($class_string, 'inner-container') === false ) {
            $class_string = str_replace('vc_row-fluid', 'row', $class_string);
        }
    }
    if ( $tag == 'vc_row_inner' ) {
        if ( !empty( $atts['add_clearfix'] ) ) {
            $class_string .= ' add-clearfix';
        }
        if ( !empty( $atts['children_same_height'] ) ) {
            $class_string .= ' same-height';
        }
    }

    if ( $tag =='vc_column' || $tag =='vc_column_inner' ) {
        if ( !(function_exists('vc_is_inline') && vc_is_inline()) ) {
            $class_string = preg_replace('/vc_col-(\w{2})-(\d{1,2})/', 'col-$1-$2', $class_string);
            $class_string = preg_replace('/vc_hidden-(\w{2})/', 'hidden-$1', $class_string);
        }
    }

    return $class_string;
}
add_filter('vc_shortcodes_css_class', 'custom_css_classes_for_elements', 10, 3);

$content_area = array(
    'type' => 'textarea_html',
    'heading' => __( 'Content', 'exort' ),
    'param_name' => 'content',
    'description' => __( 'Enter your content.', 'exort' )
);

$extra_class = array(
    'type' => 'textfield',
    'heading' => __( 'Extra class name', 'exort' ),
    'param_name' => 'class',
    'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'exort' )
);

$post_fields = array(
    array(
        'type' => 'textfield',
        'heading' => __( 'Post IDs', 'exort' ),
        'param_name' => 'ids',
        'description' => __( 'Fill this field with page/posts IDs separated by commas (,), to retrieve only them. Use this in conjunction with \'Post types\' field.', 'exort' )
    ),
    array(
        'type' => 'exploded_textarea',
        'heading' => __( 'Categories', 'exort' ),
        'param_name' => 'category',
        'description' => __( 'If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter) . ', 'exort' )
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Order by', 'exort' ),
        'param_name' => 'orderby',
        'value' => array(
            '',
            __( 'Date', 'exort' ) => 'date',
            __( 'ID', 'exort' ) => 'ID',
            __( 'Author', 'exort' ) => 'author',
            __( 'Title', 'exort' ) => 'title',
            __( 'Modified', 'exort' ) => 'modified',
            __( 'Random', 'exort' ) => 'rand',
            __( 'Comment count', 'exort' ) => 'comment_count',
            __( 'Menu order', 'exort' ) => 'menu_order'
        ),
        'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'exort' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Order', 'exort' ),
        'param_name' => 'order',
        'value' => array(
            __( 'Descending', 'exort' ) => 'DESC',
            __( 'Ascending', 'exort' ) => 'ASC'
        ),
        'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'exort' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
    )
);

/* Container */
vc_map(
    array(
        'base'            => 'container',
        'name'            => __( 'Container', 'exort' ),
        'weight'          => 990,
        'class'           => '',
        'show_settings_on_create' => false,
        'icon'            => 'exort-js-composer',
        'category'        => __( 'by SoapTheme', 'exort' ),
        'description'     => __( 'Include a container in your content', 'exort' ),
        'is_container'    => true,
        'content_element' => true,
        'js_view'         => 'VcColumnView',
        'params'          => array(
            array(
                'type' => 'textfield',
                'heading' => __( 'Extra class name', 'exort' ),
                'param_name' => 'class',
                'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'exort' )
            )
        ),
    )
);

/* ROW */
vc_add_param('vc_row', array(
    'type' => 'checkbox',
    'class' => '',
    'heading' => __( 'Add clearfix', 'exort' ),
    'param_name' => 'add_clearfix',
    'value' => array(
        '' => 'false'
    )
));
vc_add_param('vc_row', array(
    'type' => 'checkbox',
    'class' => '',
    'heading' => __( 'Make children has same height', 'exort' ),
    'param_name' => 'children_same_height',
    'value' => array(
        '' => 'false'
    )
));
vc_add_param('vc_row', array(
    'type' => 'checkbox',
    'class' => '',
    'heading' => __( 'Inner Container', 'exort' ),
    'description' => __( 'Select to insert a container inside of element', 'exort' ),
    'param_name' => 'inner_container',
    'value' => array(
        '' => 'false'
    )
));

vc_add_param('vc_row_inner', array(
    'type' => 'checkbox',
    'class' => '',
    'heading' => __( 'Add clearfix', 'exort' ),
    'param_name' => 'add_clearfix',
    'value' => array(
        '' => 'false'
    )
));
vc_add_param('vc_row_inner', array(
    'type' => 'checkbox',
    'class' => '',
    'heading' => __( 'Make children has same height', 'exort' ),
    'param_name' => 'children_same_height',
    'value' => array(
        '' => 'false'
    )
));
vc_add_param('vc_row_inner', array(
    'type' => 'checkbox',
    'class' => '',
    'heading' => __( 'Inner Container', 'exort' ),
    'description' => __( 'Select to insert a container inside of element', 'exort' ),
    'param_name' => 'inner_container',
    'value' => array(
        '' => 'false'
    )
));

// Accordion Shortcode
vc_map( array(
    'name' => __( 'Accordion', 'exort' ),
    'base' => 'toggles',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_parent' => array( 'only' => 'toggle' ),
    'description' => __( 'Collapsible content panels', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Toggle Type', 'exort' ),
            'admin_label' => true,
            'param_name' => 'toggle_type',
            'value' => array(
                __( 'Accordion', 'exort' ) => 'accordion',
                __( 'Toggle', 'exort' ) => 'toggle'
            ),
            'std' => 'accordion',
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Color Theme', 'exort' ),
            'admin_label' => true,
            'param_name' => 'color',
            'value' => array(
                __( 'Transparent', 'exort' ) => 'transparent',
                __( 'Light', 'exort' ) => 'light',
                __( 'Dark', 'exort' ) => 'dark'
            ),
            'std' => 'light',
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Border', 'exort' ),
            'param_name' => 'border',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'true',
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Expansion Mark', 'exort' ),
            'admin_label' => true,
            'param_name' => 'mark',
            'value' => array(
                __( 'Arrow', 'exort' ) => 'arrow',
                __( 'Times', 'exort' ) => 'times'
            ),
            'std' => 'arrow',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Active Toggle Index', 'exort' ),
            'param_name' => 'active_tab',
            'value' => '1'
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[toggle][/toggle][toggle][/toggle]'
) );
vc_map( array(
    'name' => __( 'Accordion Item', 'exort' ),
    'base' => 'toggle',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_child' => array( 'only' => 'toggles' ),
    'description' => __( 'Accordion item in a accordion', 'exort' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'param_name' => 'title',
            'admin_label' => true,
            'description' => __( 'Title for this slider', 'exort' )
        ),
        $content_area
    ),
) );

// Blog Posts Shortcode
vc_map( array(
    'name' => __( 'Blog Posts', 'exort' ),
    'base' => 'blog_posts',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Posts', 'exort' ),
    'params' => array_merge(
        array(
            array(
                'type' => 'dropdown',
                'heading' => __( 'Style', 'exort' ),
                'param_name' => 'style',
                'admin_label' => true,
                'value' => array(
                    __( 'Masonry', 'exort' ) => 'masonry',
                    __( 'Grid', 'exort' ) => 'grid',
                    __( 'Classic', 'exort' ) => 'classic',
                ),
                'std' => 'masonry'
            )
        ),
        $post_fields,
        array(
            array(
                'type' => 'textfield',
                'heading' => __( 'Number of posts to show per page', 'exort' ),
                'param_name' => 'count'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Columns', 'exort' ),
                'param_name' => 'columns',
                'value' => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'std' => '3',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array( 'masonry', 'grid' )
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Pagination', 'exort' ),
                'param_name' => 'pagination',
                'admin_label' => true,
                'description' => __( 'Should a pagination be displayed?', 'exort' ),
                'value' => array(
                    __( 'Yes', 'exort' ) => 'yes',
                    __( 'No', 'exort' ) => 'no'
                ),
                'std' => 'no'
            ),
            $extra_class
        )
    )
) );

// Button
vc_map( array(
    'name' => __( 'Button', 'exort' ),
    'base' => 'button',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Link Button', 'exort' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'title',
            'description' => __( 'Button text', 'exort' )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Link', 'exort' ),
            'admin_label' => true,
            'param_name' => 'link',
            'description' => __( 'Link of Button', 'exort' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'exort' ),
            'param_name' => 'style',
            'value' => array(
                __( 'Border', 'exort' ) => 'border',
                __( 'Fill', 'exort' ) => 'fill'
            ),
            'std' => 'border'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Color', 'exort' ),
            'param_name' => 'color',
            'value' => array(
                __( 'Light color', 'exort' ) => 'light',
                __( 'Dark color', 'exort' ) => 'dark',
                __( 'Skin color', 'exort' ) => 'skin',
                __( 'Gray color', 'exort' ) => 'gray',
            ),
            'std' => 'skin'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Size', 'exort' ),
            'param_name' => 'size',
            'value' => array(
                __( 'Extra Small', 'exort' ) => 'xsm',
                __( 'Small', 'exort' ) => 'sm',
                __( 'Medium', 'exort' ) => 'md',
                __( 'Large', 'exort' ) => 'lg',
            ),
            'std' => 'md'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Target', 'exort' ),
            'param_name' => 'target',
            'value' => array(
                '_self' => '',
                '_blank' => '_blank',
                '_top' => '_top',
                '_parent' => '_parent'
            ),
            'std' => ''
        ),
        $extra_class
    )
) );

// Social Button
vc_map( array(
    'name' => __( 'Social Button', 'exort' ),
    'base' => 'social_button',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Social Button', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Button Style', 'exort' ),
            'param_name' => 'icon',
            'value' => array(
                __( 'Icon', 'exort' ) => 'btn-icon',
                __( 'Button', 'exort' ) => 'btn-md'
            ),
            'std' => 'btn-icon'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Background Style', 'exort' ),
            'param_name' => 'style',
            'value' => array(
                __( 'Fill', 'exort' ) => 'bg',
                __( 'Border', 'exort' ) => 'border',
                __( 'No Border', 'exort' ) => 'border no-border'
            ),
            'std' => 'bg'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Button type', 'exort' ),
            'param_name' => 'type',
            'value' => array(
                __( 'Square', 'exort' ) => '',
                __( 'Round', 'exort' ) => 'round',
                __( 'Circle', 'exort' ) => 'circle'
            ),
            'std' => '',
            'dependency' => array(
                'element' => 'icon',
                'value' => array( 'btn-icon' )
            )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Social', 'exort' ),
            'param_name' => 'social',
            'value' => array(
                __( 'Facebook', 'exort' ) => 'facebook',
                __( 'Twitter', 'exort' ) => 'twitter',
                __( 'Instagram', 'exort' ) => 'instagram',
                __( 'Google', 'exort' ) => 'google',
                __( 'Pinterest', 'exort' ) => 'pinterest',
                __( 'Skype', 'exort' ) => 'skype',
                __( 'Linkedin', 'exort' ) => 'linkedin',
                __( 'Youtube', 'exort' ) => 'youtube',
                __( 'Yahoo', 'exort' ) => 'yahoo',
                __( 'RSS', 'exort' ) => 'rss',
                __( 'Dropbox', 'exort' ) => 'dropbox',
                __( 'Soundcloud', 'exort' ) => 'soundcloud',
                __( 'Vimeo', 'exort' ) => 'vimeo',
                __( 'Android', 'exort' ) => 'android'
            ),
            'std' => 'facebook'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'title',
            'description' => __( 'Button title', 'exort' )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Link', 'exort' ),
            'admin_label' => true,
            'param_name' => 'link',
            'description' => __( 'Link of Button', 'exort' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Target', 'exort' ),
            'param_name' => 'target',
            'value' => array(
                '_self' => '',
                '_blank' => '_blank',
                '_top' => '_top',
                '_parent' => '_parent'
            ),
            'std' => ''
        ),
        $extra_class
    )
) );

// Popup Button
vc_map( array(
    'name' => __( 'Popup Button', 'exort' ),
    'base' => 'popup_button',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Popup Button', 'exort' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Icon Class', 'exort' ),
            'param_name' => 'icon',
            'description' => 'e.g. fa fa-coffee'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Type', 'exort' ),
            'param_name' => 'type',
            'value' => array(
                __( 'Image', 'exort' ) => 'lightbox-image',
                __( 'Gallery', 'exort' ) => 'individual-gallery',
                __( 'Video', 'exort' ) => 'lightbox-video'
            ),
            'std' => 'lightbox-image'
        ),
        array(
            'type' => 'attach_image',
            'heading' => __( 'Image', 'exort' ),
            'param_name' => 'img_id',
            'dependency' => array(
                'element' => 'type',
                'value' => array( 'lightbox-image' )
            )
        ),
        array(
            'type' => 'attach_images',
            'heading' => __( 'Images', 'exort' ),
            'param_name' => 'img_ids',
            'dependency' => array(
                'element' => 'type',
                'value' => array( 'individual-gallery' )
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Video url', 'exort' ),
            'param_name' => 'video_url',
            'dependency' => array(
                'element' => 'type',
                'value' => array( 'lightbox-video' )
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'title',
            'description' => __( 'Link title', 'exort' )
        ),
        $content_area,
        $extra_class
    )
) );

// Call to Action
vc_map( array(
    'name' => __( 'Call to Action', 'exort' ),
    'base' => 'call_to_action',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Catch visitors attention with CTA block', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'exort' ),
            'param_name' => 'layout',
            'value' => array(
                __( 'Boxed', 'exort' ) => 'boxed',
                __( 'Fullwidth', 'exort' ) => 'fullwidth'
            ),
            'std' => 'boxed'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'exort' ),
            'param_name' => 'style',
            'value' => array(
                __( 'Bar', 'exort' ) => 'bar',
                __( 'Centered', 'exort' ) => 'centered'
            ),
            'std' => 'bar'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Theme', 'exort' ),
            'param_name' => 'theme',
            'value' => array(
                __( 'Light', 'exort' ) => '',
                __( 'Gray', 'exort' ) => 'bg-gray',
                __( 'Dark', 'exort' ) => 'bg-dark',
                __( 'Parallax', 'exort' ) => 'parallax'
            ),
            'std' => ''
        ),
        array(
            'type' => 'attach_image',
            'heading' => __( 'Background image', 'exort' ),
            'param_name' => 'img_id',
            'dependency' => array(
                'element' => 'theme',
                'value' => array( 'parallax' )
            )
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Border', 'exort' ),
            'param_name' => 'border',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'false'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Title Style', 'exort' ),
            'param_name' => 'title_style',
            'value' => array(
                __( 'Style1', 'exort' ) => 'style1',
                __( 'Style2', 'exort' ) => 'style2'
            ),
            'std' => 'style1'
        ),
        array(
            'type' => 'textfield',
            'class' => '',
            'heading' => __( 'Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'title'
        ),
        array(
            'type' => 'textfield',
            'class' => '',
            'heading' => __( 'Sub Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'subtitle',
        ),
        array(
            'type' => 'textfield',
            'class' => '',
            'heading' => __( 'Button Text', 'exort' ),
            'admin_label' => true,
            'param_name' => 'button_text',
        ),
        array(
            'type' => 'textfield',
            'class' => '',
            'heading' => __( 'Button Link', 'exort' ),
            'admin_label' => true,
            'param_name' => 'button_link',
        ),
        array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => __( 'Button Target', 'exort' ),
            'param_name' => 'button_target',
            'value' => array(
                '_self' => '',
                '_blank' => '_blank',
                '_top' => '_top',
                '_parent' => '_parent'
            ),
            'std' => ''
        ),
        $extra_class,
    )
) );

// Subscribe
vc_map( array(
    'name' => __( 'Subscribe', 'exort' ),
    'base' => 'subscribe',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Subscribe our newsletter', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'exort' ),
            'param_name' => 'layout',
            'value' => array(
                __( 'Layout 1', 'exort' ) => 'layout1',
                __( 'Layout 2', 'exort' ) => 'layout2'
            ),
            'std' => 'layout1'
        ),
        array(
            'type' => 'textfield',
            'class' => '',
            'heading' => __( 'Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'title'
        ),
        array(
            'type' => 'textfield',
            'class' => '',
            'heading' => __( 'Sub Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'subtitle',
            'dependency' => array(
                'element' => 'layout',
                'value' => array( 'layout2' )
            ),
        ),
        $extra_class,
    )
) );

// Counter
vc_map( array(
    'name' => __( 'Counter', 'exort' ),
    'base' => 'counter',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Incremental Timer', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'exort' ),
            'admin_label' => true,
            'param_name' => 'style',
            'value' => array(
                __( 'Style 1', 'exort' ) => 'style1',
                __( 'Style 2', 'exort' ) => 'style2'
            ),
            'std' => 'style1',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Label', 'exort' ),
            'admin_label' => true,
            'param_name' => 'label',
            'value' => '',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Number', 'exort' ),
            'admin_label' => true,
            'param_name' => 'number',
            'value' => '',
            'description' => __( 'Input the number to count', 'exort' )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Icon Class', 'exort' ),
            'param_name' => 'icon_class',
            'value' => '',
            'description' => 'e.g. fa fa-coffee'
        ),
        $extra_class
    )
) );

// Counter Timer
vc_map( array(
    'name' => __( 'Counter Timer', 'exort' ),
    'base' => 'counter_timer',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Countdown Timer', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Size', 'exort' ),
            'admin_label' => true,
            'param_name' => 'size',
            'value' => array(
                __( 'Large', 'exort' ) => 'lg',
                __( 'Medium', 'exort' ) => 'md',
                __( 'Small', 'exort' ) => 'sm'
            ),
            'std' => 'md',
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Border', 'exort' ),
            'param_name' => 'border',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'false'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Date Time', 'exort' ),
            'param_name' => 'datetime',
            'value' => '',
            'description' => 'e.g. June 7, 2017 15:03:25'
        ),
        $extra_class
    )
) );

// Icon Box
vc_map( array(
    'name' => __( 'Icon Box', 'exort' ),
    'base' => 'icon_box',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Icon and text contents', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'exort' ),
            'param_name' => 'style',
            'value' => array(
                __( 'Style 1', 'exort' ) => 'style-1',
                __( 'Style 2', 'exort' ) => 'style-2',
                __( 'Style 3', 'exort' ) => 'style-3',
                __( 'Style 4', 'exort' ) => 'style-4',
                __( 'Style 5', 'exort' ) => 'style-5',
                __( 'Style 6', 'exort' ) => 'style-6',
                __( 'Style 7', 'exort' ) => 'style-7',
                __( 'Style 8', 'exort' ) => 'style-8',
            ),
            'std' => 'style-1',
            'description' => ''
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Class for icon', 'exort' ),
            'admin_label' => true,
            'param_name' => 'icon_class',
            'description' => 'e.g. fa fa-coffee, or just 01, 02 to show as number'
        ),
        array(
            'type' => 'attach_image',
            'heading' => __( 'Image', 'exort' ),
            'param_name' => 'img_id',
            'dependency' => array(
                'element' => 'style',
                'value' => array( 'style-4', 'style-8' )
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'title',
            'description' => ''
        ),
        $content_area,
        $extra_class,
    )
) );

// Message Box
vc_map( array(
    'name' => __( 'Message Box', 'exort' ),
    'base' => 'alert',
    'icon' => 'exort-js-composer',
    'class' => 'Alert Message',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Alert Message', 'exort' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'param_name' => 'title',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Message', 'exort' ),
            'param_name' => 'message',
            'admin_label' => true
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Type', 'exort' ),
            'param_name' => 'type',
            'value' => array(
                __( 'Success', 'exort' ) => 'success',
                __( 'Info', 'exort' ) => 'info',
                __( 'Warning', 'exort' ) => 'warning',
                __( 'Danger', 'exort' ) => 'danger'
            ),
            'admin_label' => true,
            'std' => 'success'
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Border', 'exort' ),
            'param_name' => 'border',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'false',
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Close Button', 'exort' ),
            'param_name' => 'close',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'false',
        ),
        $extra_class
    )
) );

// Portfolio
vc_map( array(
    'name' => __( 'Portfolio', 'exort' ),
    'base' => 'portfolio',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Portfolio List', 'exort' ),
    'params' => array_merge(
        array(
            array(
                'type' => 'dropdown',
                'heading' => __( 'Style', 'exort' ),
                'param_name' => 'style',
                'admin_label' => true,
                'value' => array(
                    __( 'Flat', 'exort' ) => 'flat',
                    __( 'Masonry', 'exort' ) => 'masonry',
                ),
                'std' => 'flat'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Hover Style', 'exort' ),
                'param_name' => 'hover_style',
                'admin_label' => true,
                'value' => array(
                    __( 'Style 1', 'exort' ) => '1',
                    __( 'Style 2', 'exort' ) => '2',
                    __( 'Style 3', 'exort' ) => '3',
                    __( 'Style 4', 'exort' ) => '4',
                ),
                'std' => '1'
            )
        ),
        $post_fields,
        array(
            array(
                'type' => 'textfield',
                'heading' => __( 'Number of portfolio items to show per page', 'exort' ),
                'param_name' => 'count'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Columns', 'exort' ),
                'param_name' => 'columns',
                'value' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'std' => '3',
            ),
            array(
                'type' => 'checkbox',
                'heading' => __( 'Space?', 'exort' ),
                'param_name' => 'is_space',
                'value' => array(
                    '' => 'true'
                ),
                'std' => 'true',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Pagination', 'exort' ),
                'param_name' => 'pagination',
                'description' => __( 'Should a pagination be displayed?', 'exort' ),
                'value' => array(
                    __( 'Yes', 'exort' ) => 'yes',
                    __( 'No', 'exort' ) => 'no'
                ),
                'std' => 'no'
            ),
            array(
                'type' => 'checkbox',
                'heading' => __( 'Enable Filtering', 'exort' ),
                'param_name' => 'enable_filtering',
                'value' => array(
                    '' => 'true'
                ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => __( 'Is Full Width?', 'exort' ),
                'param_name' => 'is_full',
                'value' => array(
                    '' => 'true'
                ),
                'std' => 'true',
            ),
            $extra_class
        )
    )
) );

// Food Menu
vc_map( array(
    'name' => __( 'Food Menu', 'exort' ),
    'base' => 'food_menu',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_parent' => array( 'only' => 'food' ),
    'description' => __( 'Food Menu', 'exort' ),
    'params' => array(
        array(
            'type' => 'checkbox',
            'heading' => __( 'Image Left?', 'exort' ),
            'param_name' => 'left',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'true',
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[food][food]'
) );
vc_map( array(
    'name' => __( 'Food', 'exort' ),
    'base' => 'food',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_child' => array( 'only' => 'food_menu' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'param_name' => 'title',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Description', 'exort' ),
            'param_name' => 'desc',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Price Text', 'exort' ),
            'param_name' => 'price',
            'admin_label' => true,
            'description' => 'e.g. $11.50'
        ),
        array(
            'type' => 'attach_image',
            'heading' => __( 'Image', 'exort' ),
            'param_name' => 'img_id',
            'value' => '',
            'description' => __( 'Select image from media library.', 'exort' )
        ),
    )
) );

// Pricing Table
vc_map( array(
    'name' => __( 'Pricing Table', 'exort' ),
    'base' => 'pricing_table_container',
    'icon' => 'exort-js-composer',
    'as_parent' => array( 'only' => 'pricing_table' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Pricing table wrapper which contains Pricing tables', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'exort' ),
            'admin_label' => true,
            'param_name' => 'style',
            'value' => array(
                __( 'Style 1', 'exort' ) => 'pricing-table-1',
                __( 'Style 2', 'exort' ) => 'pricing-table-2',
                __( 'Style 3', 'exort' ) => 'pricing-table-3',
            ),
            'std' => 'pricing-table-1',
            'description' => ''
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Columns', 'exort' ),
            'param_name' => 'columns',
            'value' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '6' => '6'
            ),
            'std' => '3',
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[pricing_table][/pricing_table]'
) );
vc_map( array(
    'name' => __( 'Pricing Table', 'exort' ),
    'base' => 'pricing_table',
    'icon' => 'exort-js-composer',
    'as_child' => array( 'only' => 'pricing_table_container' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Pricing Table', 'exort' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Pricing Table Name', 'exort' ),
            'admin_label' => true,
            'param_name' => 'pricing_type'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Role Description', 'exort' ),
            'admin_label' => true,
            'param_name' => 'pricing_desc'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Icon Class', 'exort' ),
            'admin_label' => true,
            'param_name' => 'title_icon'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Recommend', 'exort' ),
            'admin_label' => true,
            'param_name' => 'active',
            'value' => array(
                __( 'Yes', 'exort' ) => 'true',
                __( 'No', 'exort' ) => 'false'
            ),
            'std' => 'false',
            'description' => 'This is useful for style 1.'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Currency Symbol', 'exort' ),
            'admin_label' => true,
            'param_name' => 'currency_symbol',
            'value' => '$'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Price', 'exort' ),
            'admin_label' => true,
            'param_name' => 'price'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Interval', 'exort' ),
            'admin_label' => true,
            'param_name' => 'unit_text',
            'value' => __( 'Month', 'exort' )
        ),
        $content_area,
        array(
            'type' => 'textfield',
            'heading' => __( 'Button Title', 'exort' ),
            'param_name' => 'btn_title'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Button Url', 'exort' ),
            'param_name' => 'btn_url'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Target', 'exort' ),
            'param_name' => 'btn_target',
            'value' => array(
                '_self' => '',
                '_blank' => '_blank',
                '_top' => '_top',
                '_parent' => '_parent'
            ),
            'std' => '',
            'description' => ''
        ),
        $extra_class
    )
) );

// Progress Bar
vc_map( array(
    'name' => __( 'Progress Bars', 'exort' ),
    'base' => 'progress_bars',
    'icon' => 'exort-js-composer',
    'as_parent' => array( 'only' => 'progress_bar' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Progress bars with animation', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'exort' ),
            'admin_label' => true,
            'param_name' => 'style',
            'value' => array(
                __( 'Normal', 'exort' ) => 'normal',
                __( 'Thin', 'exort' ) => 'thin'
            ),
            'std' => 'normal'
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[progress_bar][progress_bar]'
) );
vc_map( array(
    'name' => __( 'Progress Bar', 'exort' ),
    'base' => 'progress_bar',
    'icon' => 'exort-js-composer',
    'as_child' => array( 'only' => 'progress_bars' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Label', 'exort' ),
            'admin_label' => true,
            'param_name' => 'label',
            'value' => '',
            'description' => ''
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Percent', 'exort' ),
            'admin_label' => true,
            'param_name' => 'percent',
            'value' => '',
            'description' => '0 ~ 100'
        ),
        $extra_class
    )
) );

// Slider
vc_map( array(
    'name' => __( 'Slider', 'exort' ),
    'base' => 'slider',
    'icon' => 'exort-js-composer',
    'as_parent' => array( 'only' => 'slider_item' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Owl Slider', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Columns', 'exort' ),
            'param_name' => 'columns',
            'value' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ),
            'std' => '1',
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Navigation?', 'exort' ),
            'param_name' => 'nav',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'true',
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Navigation Overlay', 'exort' ),
            'param_name' => 'nav_over',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'true',
            'dependency' => array(
                'element' => 'nav',
                'value' => 'true'
            )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Navigation Style', 'exort' ),
            'admin_label' => true,
            'param_name' => 'nav_style',
            'value' => array(
                __( 'Style 1', 'exort' ) => '1',
                __( 'Style 2', 'exort' ) => '2',
                __( 'Style 3', 'exort' ) => '3',
                __( 'Style 4', 'exort' ) => '4',
            ),
            'std' => '1',
            'dependency' => array(
                'element' => 'nav',
                'value' => 'true'
            )
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Pagination?', 'exort' ),
            'param_name' => 'pagi',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'true',
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Pagination Overlay', 'exort' ),
            'param_name' => 'pagi_over',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'true',
            'dependency' => array(
                'element' => 'pagi',
                'value' => 'true'
            )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Pagination Position', 'exort' ),
            'admin_label' => true,
            'param_name' => 'pagi_pos',
            'value' => array(
                __( 'Left', 'exort' ) => 'left',
                __( 'Center', 'exort' ) => 'center',
                __( 'Right', 'exort' ) => 'right',
            ),
            'std' => 'left',
            'dependency' => array(
                'element' => 'pagi',
                'value' => 'true'
            )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Pagination Style', 'exort' ),
            'admin_label' => true,
            'param_name' => 'pagi_style',
            'value' => array(
                __( 'Style 1', 'exort' ) => '1',
                __( 'Style 2', 'exort' ) => '2',
                __( 'Style 3', 'exort' ) => '3',
            ),
            'std' => '1',
            'dependency' => array(
                'element' => 'pagi',
                'value' => 'true'
            )
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[slider_item][/slider_item]'
) );
vc_map( array(
    'name' => __( 'Slider item', 'exort' ),
    'base' => 'slider_item',
    'icon' => 'exort-js-composer',
    'as_child' => array( 'only' => 'slider' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'params' => array(
        array(
            'type' => 'attach_image',
            'heading' => __( 'Image', 'exort' ),
            'param_name' => 'img_id',
        ),
        $content_area
    )
) );

// Tabs
vc_map( array(
    'name' => __( 'Tabs', 'exort' ),
    'base' => 'tabs',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_parent' => array( 'only' => 'tab' ),
    'description' => __( 'Tabbed content', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'exort' ),
            'param_name' => 'style',
            'value' => array(
                __( 'Style 1', 'exort' ) => 'style-1',
                __( 'Style 2', 'exort' ) => 'style-2',
                __( 'Style 3', 'exort' ) => 'style-3',
                __( 'Style 4', 'exort' ) => 'style-4',
                __( 'Feature 1', 'exort' ) => 'features-1',
                __( 'Feature 2', 'exort' ) => 'features-2'
            ),
            'std' => 'style-1',
            'admin_label' => true,
            'description' => ''
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Tab Count', 'exort' ),
            'param_name' => 'tab_count',
            'value' => array(
                __( '2', 'exort' ) => '2',
                __( '3', 'exort' ) => '3',
                __( '4', 'exort' ) => '4',
                __( '6', 'exort' ) => '6',
            ),
            'std' => '4',
            'admin_label' => true,
            'dependency' => array(
                'element' => 'style',
                'value' => array( 'features-1' )
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'param_name' => 'title',
            'value' => '',
            'dependency' => array(
                'element' => 'style',
                'value' => array( 'features-2' )
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Sub Title', 'exort' ),
            'param_name' => 'subtitle',
            'value' => '',
            'dependency' => array(
                'element' => 'style',
                'value' => array( 'features-2' )
            )
        ),
        array(
            'type' => 'attach_image',
            'heading' => __( 'Back Image', 'exort' ),
            'param_name' => 'img_id',
            'dependency' => array(
                'element' => 'style',
                'value' => array( 'features-2' )
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Active Tab Index', 'exort' ),
            'param_name' => 'active_tab_index',
            'value' => '1'
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[tab][/tab][tab][/tab]'
) );
vc_map( array(
    'name' => __( 'Tab', 'exort' ),
    'base' => 'tab',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_child' => array( 'only' => 'tabs' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'param_name' => 'title',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Icon Class', 'exort' ),
            'param_name' => 'icon_class',
            'description' => 'e.g. fa fa-coffee for features style'
        ),
        $extra_class,
        $content_area
    )
) );

// Team Member
vc_map( array(
    'name' => __( 'Team', 'exort' ),
    'base' => 'team',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_parent' => array( 'only' => 'team_member' ),
    'description' => __( 'Person list', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => __( 'Style', 'exort' ),
            'param_name' => 'style',
            'value' => array(
                __( 'Style 1', 'exort' ) => 'team-style-1',
                __( 'Style 2', 'exort' ) => 'team-style-2',
                __( 'Style 3', 'exort' ) => 'team-style-3',
                __( 'Style 4', 'exort' ) => 'team-style-4',
                __( 'Style 5', 'exort' ) => 'team-style-5',
            ),
            'std' => 'team-style-1',
            'admin_label' => true
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Carousel Count', 'exort' ),
            'param_name' => 'count',
            'value' => array(
                __( '2', 'exort' ) => '2',
                __( '3', 'exort' ) => '3',
                __( '4', 'exort' ) => '4',
                __( '5', 'exort' ) => '5',
            ),
            'std' => '3',
            'admin_label' => true,
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[team_member][team_member]'
) );
vc_map( array(
    'name' => __( 'Team Member', 'exort' ),
    'base' => 'team_member',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_child' => array( 'only' => 'team' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Name', 'exort' ),
            'param_name' => 'name',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Job', 'exort' ),
            'param_name' => 'job'
        ),
        array(
            'type' => 'attach_image',
            'heading' => __( 'Photo', 'exort' ),
            'param_name' => 'photo_id'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Image size', 'exort' ),
            'param_name' => 'img_size',
            'description' => __( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). If you want to use theme default size, please leave this field as blank.', 'exort' ),
            'std' => 'full',
            'dependency' => array(
                'element' => 'photo_id',
                'not_empty' => true
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Facebook Link', 'exort' ),
            'param_name' => 'facebook',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Twitter Link', 'exort' ),
            'param_name' => 'twitter',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Google+ Link', 'exort' ),
            'param_name' => 'google',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Pinterest Link', 'exort' ),
            'param_name' => 'pinterest',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'LinkedIn Link', 'exort' ),
            'param_name' => 'linkedin',
        ),
        $content_area,
        $extra_class
    )
) );

// Testimonial
vc_map( array(
    'name' => __( 'Testimonials', 'exort' ),
    'base' => 'testimonials',
    'icon' => 'exort-js-composer',
    'as_parent' => array( 'only' => 'testimonial' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Testimonial wrapper', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => __( 'Style', 'exort' ),
            'param_name' => 'style',
            'value' => array(
                __( 'Style 1', 'exort' ) => 'testimonial-1',
                __( 'Style 2', 'exort' ) => 'testimonial-2',
            ),
            'std' => 'testimonial-1',
        ),
        array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => __( 'Column', 'exort' ),
            'param_name' => 'column',
            'value' => array(
                __( '1', 'exort' ) => '1',
                __( '2', 'exort' ) => '2',
                __( '3', 'exort' ) => '3',
            ),
            'std' => '1',
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[testimonial][/testimonial]'
) );
vc_map( array(
    'name' => __( 'Testimonial', 'exort' ),
    'base' => 'testimonial',
    'icon' => 'exort-js-composer',
    'category' => __( 'by SoapTheme', 'exort' ),
    'as_child' => array( 'only' => 'testimonials' ),
    'description' => __( 'Testimonial Content', 'exort' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Author Name', 'exort' ),
            'param_name' => 'author_name',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Author Job', 'exort' ),
            'param_name' => 'author_job',
            'admin_label' => true
        ),
        array(
            'type' => 'attach_image',
            'heading' => __( 'Photo of Author', 'exort' ),
            'param_name' => 'author_img_id'
        ),
        $content_area,
        $extra_class
    )
) );

// Workflow
vc_map( array(
    'name' => __( 'Workflow', 'exort' ),
    'base' => 'process',
    'icon' => 'exort-js-composer',
    'as_parent' => array( 'only' => 'process_item' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'description' => __( 'Display workflow list', 'exort' ),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'exort' ),
            'admin_label' => true,
            'param_name' => 'style',
            'value' => array(
                __( 'Style 1', 'exort' ) => 'work-flow-1',
                __( 'Style 2', 'exort' ) => 'work-flow-2',
            ),
            'std' => 'work-flow-1',
            'description' => ''
        ),
        $extra_class
    ),
    'js_view' => 'VcColumnView',
    'default_content' => '[process_item][/process_item]'
) );
vc_map( array(
    'name' => __( 'Workflow Item', 'exort' ),
    'base' => 'process_item',
    'icon' => 'exort-js-composer',
    'as_child' => array( 'only' => 'process_item' ),
    'category' => __( 'by SoapTheme', 'exort' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', 'exort' ),
            'admin_label' => true,
            'param_name' => 'title',
            'description' => 'This is useful for style 1'
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Left Image', 'exort' ),
            'param_name' => 'left',
            'value' => array(
                '' => 'true'
            ),
            'std' => 'true',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Class for icon', 'exort' ),
            'admin_label' => true,
            'param_name' => 'icon_class',
            'description' => 'e.g. fa fa-coffee, or just 01, 02 to show as number<br>This is useful for style 1'
        ),
        array(
            'type' => 'attach_image',
            'heading' => 'Image',
            'param_name' => 'img_id',
            'description' => ''
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Image size', 'exort' ),
            'param_name' => 'img_size',
            'description' => __( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). If you want to use theme default size, please leave this field as blank.', 'exort' ),
            'std' => 'full',
            'dependency' => array(
                'element' => 'img_id',
                'not_empty' => true
            )
        ),
        $content_area,
        $extra_class
    )
) );


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

    class WPBakeryShortCode_Container extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Toggles extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Food_Menu extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Pricing_Table_Container extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Process extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Progress_Bars extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Slider extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Tabs extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Team extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Testimonials extends WPBakeryShortCodesContainer {}

    class WPBakeryShortCode_Carousel extends WPBakeryShortCodesContainer {}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

    class WPBakeryShortCode_Toggle extends WPBakeryShortCode {}

    class WPBakeryShortCode_Food extends WPBakeryShortCode {}

    class WPBakeryShortCode_Pricing_Table extends WPBakeryShortCode {}

    class WPBakeryShortCode_Process_Item extends WPBakeryShortCode {}

    class WPBakeryShortCode_Progress_Bar extends WPBakeryShortCode {}

    class WPBakeryShortCode_Slider_Item extends WPBakeryShortCode {}

    class WPBakeryShortCode_Tab extends WPBakeryShortCode {}

    class WPBakeryShortCode_Team_Member extends WPBakeryShortCode {}

    class WPBakeryShortCode_Slide extends WPBakeryShortCode {}
}
