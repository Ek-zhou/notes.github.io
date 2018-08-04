<?php
/**
 * Hooks
 */

if ( !function_exists( 'exort_body_classes' ) ) {

    function exort_body_classes($classes)
    {
        $page_id = exort_get_the_ID();

        $page_bg_repeat = '';
        if ($page_bg_repeat == 'parallax') {
            $classes[] = 'parallax';
            $classes[] = 'skrollable';
            $classes[] = 'skrollable-between';
        }

        // header layout
        $header_layout = exort_get_header_layout();
        if ($page_header_layout = get_post_meta( $page_id, '_exort_page_settings_menu_style', true)) {
            $header_layout = $page_header_layout;
        }
        $classes[] = 'header-' . esc_attr($header_layout);

        // footer layout
        $classes[] = 'footer-' . 'style3';

        // one page
        if (get_post_meta($page_id, '_exort_page_settings_one_page_nav', true)) {
            $classes[] = 'one-page';
        }

        // portfolio page
        $is_portfolio = is_page_template('template-portfolio.php') || is_tax('portfolio_category');
        if ($is_portfolio && $portfolio_style = get_post_meta($page_id, '_exort_portfolio_style', true)) {
            $classes[] = 'portfolio-' . esc_attr($portfolio_style);
        } elseif ($is_portfolio) {
            $classes[] = 'portfolio-flat1';
        }

        if ($is_portfolio && $portfolio_fullwidth = get_post_meta($page_id, '_exort_portfolio_is_fullwidth', true)) {
            $classes[] = 'portfolio-full';
        }

        // page settings body class
        if ($page_id && ($body_extra_class = get_post_meta($page_id, '_exort_page_settings_bodyclass', true))) {
            $classes[] = esc_attr($body_extra_class);
        }

        return $classes;
    }
}
add_filter( 'body_class', 'exort_body_classes' );

/* Header */
if ( !function_exists( 'exort_display_rev_slider' ) ) {
    function exort_display_rev_slider() {
        if ( !class_exists( 'RevSlider' ) ) {
            return;
        }
        if ( $slider_id = get_post_meta( exort_get_the_ID(), '_exort_page_settings_rev_slider', true ) ) {
            echo '<div id="slideshow">';
            do_action( 'exort_display_slider_html' );
            echo '<div class="revolution-slider rev_slider fullscreenbanner">';
            putRevSlider( $slider_id );
            echo '</div></div>';
        }
    }
}
add_action( 'exort_hook_before_content', 'exort_display_rev_slider' );

/* Content */
function exort_custom_get_registered_sidebars($sidebar) {
    if ( !empty( $sidebar ) ) {
        return $sidebar;
    }
    $widget_areas = array( 'sidebar-main' => __( 'Default Sidebar', 'exort' ) );
    $sidebars = get_option('sbg_sidebars');
    if ( is_array( $sidebars ) ) {
        foreach ($sidebars as $sidebar) {
            $sidebar_class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$sidebar);
            $widget_areas['exort-sidebar-'.strtolower($sidebar_class)] = $sidebar;
        }
    }
    return $widget_areas;
}
add_filter( 'exort_get_registered_sidebars', 'exort_custom_get_registered_sidebars' );

/* Custom */
function exort_hook_top() {
    echo do_shortcode( exort_get_option( 'global_hook_top', '' ) );
}
add_action( 'exort_hook_top', 'exort_hook_top' );


function exort_hook_before_content() {
    echo do_shortcode( exort_get_option( 'global_hook_before_content', '' ) );
}
add_action( 'exort_hook_before_content', 'exort_hook_before_content' );


function exort_hook_after_content() {
    echo do_shortcode( exort_get_option( 'global_hook_after_content', '' ) );
}
add_action( 'exort_hook_after_content', 'exort_hook_after_content' );


function exort_hook_bottom() {
    echo do_shortcode( exort_get_option( 'global_hook_bottom', '' ) );
}
add_action( 'exort_hook_bottom', 'exort_hook_bottom' );

if ( ! function_exists( 'exort_blog_title' ) ) {
    /* Display blog title */
    function exort_blog_title( $title, $sep ) {
        if ( is_feed() ) {
            return $title;
        }
        
        global $page, $paged;

        // Add the blog name
        $title .= get_bloginfo( 'name', 'display' );

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title = "$title $sep $site_description";
        }

        // Add a page number if necessary:
        if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
            $title = "$title $sep " . sprintf( __( 'Page %s', 'exort' ), max( $paged, $page ) );
        }

        return $title;
    }
}

/* excerpt */
if ( ! function_exists( 'exort_excerpt_length' ) ) {
    function exort_excerpt_length($length)
    {
        $result = $length;
        if (is_archive() && get_post_type() != 'portfolio') {
            $result = exort_get_option('blog_archive_excerpt_length', 25);
        } elseif (is_search()) {
            $result = exort_get_option('blog_search_excerpt_length', 25);
        } elseif (is_page_template('template-portfolio.php') || is_tax('portfolio_category') || get_post_type() == 'portfolio') { // portfolio
            $result = exort_get_option('portfolio_excerpt_length', 12);
        } else {
            $result = exort_get_option('blog_excerpt_length', 25);
        }
        global $exort_excerpt_length;
        if ($exort_excerpt_length) {
            return $exort_excerpt_length;
        }
        return $result;
    }

    add_filter('excerpt_length', 'exort_excerpt_length');
}

/* excerpt more string */
if ( ! function_exists( 'exort_excerpt_string' ) ) {
    function exort_excerpt_string( $more ) {
        return ' ...';
    }
    add_filter( 'excerpt_more', 'exort_excerpt_string' );
}

/* Flush rewrite rules */
function exort_flush_rewrite_rules() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'exort_flush_rewrite_rules' );

// Ouputs Generated CSS
function exort_output_generated_css() {

    ob_start();
    echo '<style id="exort-generated-css-output" type="text/css">';

    require_once( EXORT_FUNC_PATH . '/enqueue/internal-styles.php' );

    do_action( 'exort_head_css' );

    echo '</style>';

    $css = ob_get_contents(); ob_end_clean();

    $output = preg_replace( '#/\*.*?\*/#s', '', $css );
    $output = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $output );
    $output = preg_replace( '/\s\s+(.*)/', '$1', $output );

    echo ( $output );
}
add_action( 'wp_head', 'exort_output_generated_css', 9998, 0 );

/* Outputs Custom CSS */
function exort_output_custom_css() {

    $custom_css = exort_get_option( 'custom_css', '' );

    if ( $entry_id = exort_get_the_ID() ) {
        $custom_css .= get_post_meta( $entry_id, '_exort_custom_css', true );
    }
    if ( $custom_css ) : ?>

        <style id="exort-custom-css-output" type="text/css">
            <?php echo exort_esc_post( $custom_css ); ?>
        </style>

    <?php endif;
}
add_action( 'wp_head', 'exort_output_custom_css', 9999, 0 );

/* Outputs Custom Javascript */
function exort_output_custom_javascript() {
    $custom_scripts = exort_get_option( 'custom_javascript', '' );
    if ( !empty( $custom_scripts ) ) {
        echo '<script>'."\n";
            echo '//<![CDATA['."\n";
                echo $custom_scripts ."\n";
            echo '//]]>'."\n";
        echo '</script>'."\n";
    }
}
add_action( 'wp_footer', 'exort_output_custom_javascript', 9999, 0 );

// Enable comments status for pages
add_filter( 'get_default_comment_status', 'exort_open_comments_for_pages', 10, 3 );
if ( ! function_exists( 'exort_open_comments_for_pages' ) ) {
    function exort_open_comments_for_pages( $status, $post_type, $comment_type ) {
        if ( 'page' !== $post_type ) {
            return $status;
        }
        return 'open';
    }
}

// comments
if ( ! function_exists( 'exort_comment_form_before_fields' ) ) {
    function exort_comment_form_before_fields( $fields ) {
        if ( get_post_type() != 'product' ) { 
            echo '<div class="row">';
        }
    }
}
if ( ! function_exists( 'exort_comment_form_after_fields' ) ) {
    function exort_comment_form_after_fields( $fields ) {
        if ( get_post_type() != 'product' ) { 
            echo '</div>';
        }
    }
}
add_action( 'comment_form_before_fields', 'exort_comment_form_before_fields' );
add_action( 'comment_form_after_fields', 'exort_comment_form_after_fields' );

// portfolio sidebar
if ( !function_exists( 'exort_portfolio_check_sidebar' ) ) {
    function exort_portfolio_check_sidebar( $sidebar ) {
        $is_portfolio = is_page_template( 'template-portfolio.php' ) || is_tax( 'portfolio_category' );
        if ( is_page_template( 'template-full-width.php' ) || ( $is_portfolio && $portfolio_fullwidth = get_post_meta( exort_get_the_ID(), '_exort_portfolio_is_fullwidth', true ) ) ) {
            return false;
        }
        return $sidebar;
    }
}
add_filter( 'exort_check_sidebar', 'exort_portfolio_check_sidebar', 10, 1 );

if ( !function_exists( 'exort_print_media_templates' ) ) {
    function exort_print_media_templates() {
    ?>
        <script type="text/html" id="tmpl-gallery-type-setting-mode">
            <label class="setting">
                <span><?php esc_html_e('Mode', 'exort'); ?></span>
                <select data-setting="mode">
                    <option value=""> Default </option>
                    <option value="metro"> Metro Slider </option>
                    <option value="slideshow" selected="selected"> Slideshow </option>
                </select>
            </label>
        </script>

        <script type="text/html" id="tmpl-exort-gallery-setting-mode">
            <h3>Gallery Settings</h3>
            <label class="setting">
                <span><?php esc_html_e('Mode', 'exort'); ?></span>
                <select data-setting="mode">
                    <option value="slider"> Simple slider 1 </option>
                    <option value="slider2"> Simple slider 2 </option>
                    <option value="slider_thumb1"> Slider with thumbnail 1 </option>
                    <option value="slider_thumb2"> Slider with thumbnail 2 </option>
                    <option value="masonry"> Masonry </option>
                    <option value="metro"> Metro </option>
                    <option value="grid1"> Grid 1 </option>
                    <option value="grid2"> Grid 2 </option>
                    <option value="grid3"> Grid 3 </option>
                    <option value="logo"> Logo </option>
                </select>
            </label>
            <label class="setting display-none">
                <span><?php esc_html_e('Columns', 'exort'); ?></span>
                <select data-setting="columns">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3" selected="selected"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                </select>
            </label>
        </script>

        <script>
            jQuery(document).ready(function() {

                // add your shortcode attribute and its default value to the
                // gallery settings list; $.extend should work as well...
                _.extend(wp.media.gallery.defaults, {
                    mode: '',
                    columns: '3'
                });
                // merge default gallery settings template with yours
                wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
                    template: function(view){
                        if (wp.media.is_shortcode) {
                            delete wp.media.is_shortcode;
                            return wp.media.template('exort-gallery-setting-mode')(view);
                        }
                        return wp.media.template('gallery-settings')(view)
                            + wp.media.template('gallery-type-setting-mode')(view);
                    }
                });
            });
        </script>
    <?php
    }
}
add_action( 'print_media_templates', 'exort_print_media_templates' );

/* Tags Widget */
if ( !function_exists( 'exort_change_tag_cloud' ) ) {
    function exort_change_tag_cloud( $return, $args ) {
        $wrap = '<div class="tags">%s</div>';
        $return = str_replace('tag-link-', 'tag tag-link-', $return);
        return sprintf( $wrap, $return );
    }
}
add_filter( 'wp_tag_cloud', 'exort_change_tag_cloud', 10, 2 );