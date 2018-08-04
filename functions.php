<?php
/**
 * Theme functions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! isset( $content_width ) ) {
    $content_width = 1170; /* pixels */
}

define( 'EXORT_COLUMNS', 12 );
define( 'EXORT_OPTIONS_NAME', 'exort_options' );

// set url and path
define( 'EXORT_URL', get_template_directory_uri() );
define( 'EXORT_IMAGE_URL', EXORT_URL . '/images' );

define( 'EXORT_PATH', get_template_directory() );
define( 'EXORT_FUNC_PATH', EXORT_PATH . '/inc/functions' );
define( 'EXORT_ADMIN_PATH', EXORT_PATH . '/inc/functions/admin' );
define( 'EXORT_EXT_PATH', EXORT_PATH . '/inc/lib' );
define( 'EXORT_VIEWS_PATH', EXORT_PATH . 'inc/views' );
define( 'EXORT_WIDGETS_PATH', EXORT_FUNC_PATH . '/widgets' );

require_once EXORT_FUNC_PATH . '/function-set.php';
require_once EXORT_FUNC_PATH . '/theme-hooks.php';
require_once EXORT_FUNC_PATH . '/init.php';

require_once EXORT_ADMIN_PATH . '/widgets.php';
require_once EXORT_ADMIN_PATH . '/metabox/init.php';
require_once EXORT_ADMIN_PATH . '/user-profile.php';

require_once EXORT_FUNC_PATH . '/shortcode/init.php';
require_once EXORT_FUNC_PATH . '/js_composer/init.php';

// required enqueue styles and scripts
require_once EXORT_FUNC_PATH . '/enqueue/styles.php';
require_once EXORT_FUNC_PATH . '/enqueue/javascripts.php';

// widgets
require_once EXORT_WIDGETS_PATH . '/flickr.php';
require_once EXORT_WIDGETS_PATH . '/tweet.php';
require_once EXORT_WIDGETS_PATH . '/blog-posts.php';
require_once EXORT_WIDGETS_PATH . '/portfolio.php';

// plugins
require_once EXORT_FUNC_PATH . '/importer/init.php';