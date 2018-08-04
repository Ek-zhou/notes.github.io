<?php
/**
 * Exort Importer
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class exortImporter {

    public $error = array();

    function __construct() {
        add_action( 'admin_menu', array( &$this, 'init' ) );
    }

    function init() {
        add_theme_page(
            __( 'Import Demo Data', 'exort' ),
            __( 'Exort Demo', 'exort' ),
            'edit_theme_options',
            'exort_importer',
            array( &$this, 'importer' )
        );
        add_action( 'admin_init', array( &$this, 'increase_server_vars' ) );
    }

    function increase_server_vars() {
        if ( key_exists( 'exort_importer_nonce', $_POST ) ) {
            if ( wp_verify_nonce( $_POST['exort_importer_nonce'], 'exort_importer_notice_text' ) ) {
                if ( $_POST && key_exists('attachments', $_POST) && $_POST['attachments'] ) {
                    if ( !defined( 'WP_MEMORY_LIMIT' ) ) define('WP_MEMORY_LIMIT', '1024M');
                    set_time_limit(0);
                }
            }
        }
    }

    function exort_importer_error_handler() {
    }

    function importer() {
        if ( key_exists( 'exort_importer_nonce', $_POST ) ) {
            if ( wp_verify_nonce( $_POST['exort_importer_nonce'], 'exort_importer_notice_text' ) ) {
                if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) define( 'WP_LOAD_IMPORTERS', true );
                
                if ( ! class_exists( 'WP_Importer' ) ) {
                    require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
                }
                
                if ( ! class_exists( 'WP_Import' ) ) {
                    require_once EXORT_EXT_PATH . '/wordpress-importer/wordpress-importer.php';
                }
                
                if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {

                    if ( !class_exists( 'ReduxFrameworkInstances' ) ) {
                        $this->error[] = __('Please install required plugins before importing sample data.', 'exort');
                    } else {
                        switch ( $_POST['content'] ) {
                            case 'all':
                                $file = 'all.xml';
                                $this->import_content( $file );

                                //$file = 'menu.txt';
                                //$this->import_menu_location( $file );

                                $file = 'options.json';
                                $this->import_options( $file );

                                $file = 'widget_data.json';
                                $this->import_widget( $file );

                                // set home & blog page
                                $home = get_page_by_title( 'Home' );
                                $blog = get_page_by_title( 'Blog' );
                                if ( $home->ID ) {
                                    update_option('show_on_front', 'page');
                                    update_option('page_on_front', $home->ID);
                                }
                                if ( $blog->ID ) {
                                    update_option('page_for_posts', $blog->ID);
                                }

                                // set permalink to Post name
                                update_option('permalink_structure', '/%postname%/');

                                // import menus
                                global $wpdb;
                                $folder = EXORT_FUNC_PATH . "/importer/menus/";
                                $files = array('main-menu.txt', 'full-width-slider.txt', 'revolution-slider.txt', 'full-screen-slider.txt', 'image-parallax.txt', 'interactive-parallax.txt', 'side-menu.txt', 'showcase.txt', 'text-slider.txt', 'rainyday.txt', 'video-background.txt', 'agency-menu.txt');
                                foreach ($files as $file) {
                                    eval(str_replace("wp_redirect", "//wp_redirect", str_replace("#wpurl#", get_bloginfo("wpurl"), file_get_contents($folder . $file))));
                                }

                                // set primary menu
                                $menu = get_term_by('slug', 'main-menu', 'nav_menu');
                                $locations = get_theme_mod('nav_menu_locations');
                                $locations['primary'] = $menu->term_id;
                                set_theme_mod( 'nav_menu_locations', $locations );

                                break;
                            case 'pages':
                                $file = 'pages.xml';
                                $this->import_content( $file );
                                
                                // set home & blog page
                                $home = get_page_by_title( 'Home' );
                                $blog = get_page_by_title( 'Blog' );
                                if ( $home->ID ) {
                                    update_option('show_on_front', 'page');
                                    update_option('page_on_front', $home->ID);
                                }
                                if ( $blog->ID ) {
                                    update_option('page_for_posts', $blog->ID);
                                }

                                // set permalink to Post name
                                update_option('permalink_structure', '/%postname%/');
                                break;
                            case 'posts':
                                $file = 'posts.xml';
                                $this->import_content( $file );
                                break;
                            case 'portfolio':
                                $file = 'portfolio.xml';
                                $this->import_content( $file );
                                break;
                            case 'media':
                                $file = 'media.xml';
                                $this->import_content( $file );
                                break;
                            case 'options':
                                $file = 'options.json';
                                $this->import_options( $file );
                                break;
                            case 'widgets':
                                $file = 'widget_data.json';
                                $this->import_widget( $file );
                                break;
                            default:
                                $this->error[] = __('Please select data to import.', 'exort');
                                break;
                        }
                    }

                    if ( !empty( $this->error ) ) {
                        echo '<div class="error settings-error">';
                            foreach ( $this->error as $e ) {
                                echo '<p><strong>'. $e .'</strong></p>';
                            }
                        echo '</div>';
                    } else {
                        echo '<div class="updated settings-error">';
                            echo '<p><strong>'. __('All done. Have fun!', 'exort') .'</strong></p>';
                        echo '</div>';
                    }
                }
            }
        }
        ?>
        <div class="wrap">
            <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
            <p>Which content would you like to import?</p>
            <form action="<?php echo esc_url( remove_query_arg( 'step' ) ); ?>" method="post">
                <input type="hidden" name="exort_importer_nonce" value="<?php echo wp_create_nonce( 'exort_importer_notice_text' ); ?>" />
                <select name="content">
                    <option value="all" selected>-- All --</option>
                    <option value="pages">Pages</option>
                    <option value="posts">Posts</option>
                    <option value="portfolio">Portfolios</option>
                    <option value="media">Media</option>
                    <option value="options">Theme Options</option>
                    <option value="widgets">Widgets</option>
                </select>
                <input type="submit" name="submit" class="button button-primary" value="<?php esc_attr_e( 'Import', 'exort'); ?>" />
            </form>
        </div>
<?php
    }

    function import_content( $file = 'all.xml' ) {
        $importer = new WP_Import();
        $xml = EXORT_FUNC_PATH . '/importer/' . $file;
        $importer->fetch_attachments = true;

        ob_start();
        $importer->import( $xml ); 
        ob_end_clean();
    }

    function import_menu_location( $file = 'menu.txt' ) {
        $file_path  = EXORT_URL . '/inc/functions/importer/' . $file;
        $file_data  = wp_remote_get( $file_path );
        $data       = unserialize( $file_data['body'] );
        $menus      = wp_get_nav_menus();
        foreach ( $data as $key => $val ) {
            foreach ( $menus as $menu ) {
                if ( $val && $menu->slug == $val ) {
                    $data[$key] = absint( $menu->term_id );
                }
            }
        }
        set_theme_mod( 'nav_menu_locations', $data );
    }

    function import_options( $file = 'options.json' ) {
        $file_path = EXORT_URL . '/inc/functions/importer/' . $file;
        $file_data = wp_remote_get( $file_path );

        $data = array( 'import_code' => $file_data['body'] );

        set_error_handler(array($this, 'exort_importer_error_handler'));
        $redux = ReduxFrameworkInstances::get_instance( EXORT_OPTIONS_NAME );
        $redux->set_options( $redux->_validate_options( $data ) );
    }

    function import_widget( $file = 'widget_data.json' ) {
        $file_path = EXORT_URL . '/inc/functions/importer/' . $file;
        $file_data = wp_remote_get( $file_path );
        $data = $file_data['body'];
        $this->import_widget_data( $data );
    }

    function import_widget_data( $json_data ) {

        $json_data = json_decode( $json_data, true );
        $sidebar_data = $json_data[0];
        $widget_data = $json_data[1];
        $widgets = array();
        foreach ( $widget_data as $k_w => $widget_type ) {
            if ( $k_w ) {
                $widgets[ $k_w ] = array();
                foreach ( $widget_type as $k_wt => $widget ) {
                    if ( is_int( $k_wt ) ) $widgets[$k_w][$k_wt] = 1;
                }
            }
        }

        // sidebars
        foreach ( $sidebar_data as $title => $sidebar ) {
            $count = count( $sidebar );
            for ( $i = 0; $i < $count; $i++ ) {
                $widget = array();
                $widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
                $widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
                if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
                    unset( $sidebar_data[$title][$i] );
                }
            }
            $sidebar_data[$title] = array_values( $sidebar_data[$title] );
        }

        // widgets
        foreach ( $widgets as $widget_title => $widget_value ) {
            foreach ( $widget_value as $widget_key => $widget_value ) {
                $widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
            }
        }

        $sidebar_data = array( array_filter( $sidebar_data ), $widgets );
        $this->parse_importer_data( $sidebar_data );
    }

    function parse_importer_data( $importer_array ) {
        $sidebars_data = $importer_array[0];
        $widget_data = $importer_array[1];

        $redux = ReduxFrameworkInstances::get_instance(EXORT_OPTIONS_NAME);
        $redux->get_options();
        $current_options = $redux->options;
        if (!empty($current_options)) {
            global $exort_options;
            $exort_options = $current_options;
        }
        if (function_exists('exort_widgets_init')) {
            exort_widgets_init();
        }

        $exort_sidebars = array();
        foreach ($sidebars_data as $importer_sidebar => $import_widgets) {
            if (strpos($importer_sidebar, "exort-sidebar-") !== false) {
                $exort_sidebars[str_replace("exort-sidebar-", "", $importer_sidebar)] = ucfirst(str_replace("exort-sidebar-", "", $importer_sidebar));
            }
        }
        if (!empty($exort_sidebars)) {
            sidebar_generator::update_sidebars($exort_sidebars);
        }

        $current_sidebars = get_option('sidebars_widgets');
        $new_widgets = array();

        foreach ($sidebars_data as $importer_sidebar => $import_widgets) {
            foreach ($import_widgets as $import_widget) {

                if (!isset($current_sidebars[$importer_sidebar])) {
                    $current_sidebars[$importer_sidebar] = array();
                }

                $title = trim(substr($import_widget, 0, strrpos($import_widget, '-')));
                $index = trim(substr($import_widget, strrpos($import_widget, '-') + 1));
                $current_widget_data = get_option('widget_' . $title);
                $new_widget_name = $this->get_new_widget_name($title, $index);
                $new_index = trim(substr($new_widget_name, strrpos($new_widget_name, '-') + 1));

                if (!empty($new_widgets[$title]) && is_array($new_widgets[$title])) {
                    while (array_key_exists($new_index, $new_widgets[$title])) {
                        $new_index++;
                    }
                }
                $current_sidebars[$importer_sidebar][] = $title . '-' . $new_index;
                if (array_key_exists($title, $new_widgets)) {
                    $new_widgets[$title][$new_index] = $widget_data[$title][$index];

                    if (!key_exists('_multiwidget', $new_widgets[$title])) $new_widgets[$title]['_multiwidget'] = '';

                    $multiwidget = $new_widgets[$title]['_multiwidget'];
                    unset($new_widgets[$title]['_multiwidget']);
                    $new_widgets[$title]['_multiwidget'] = $multiwidget;
                } else {
                    $current_widget_data[$new_index] = $widget_data[$title][$index];

                    if (!key_exists('_multiwidget', $current_widget_data)) $current_widget_data['_multiwidget'] = '';

                    $current_multiwidget = $current_widget_data['_multiwidget'];
                    $new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
                    $multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
                    unset($current_widget_data['_multiwidget']);
                    $current_widget_data['_multiwidget'] = $multiwidget;
                    $new_widgets[$title] = $current_widget_data;
                }
            }
        }

        if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
            update_option( 'sidebars_widgets', $current_sidebars );

            foreach ( $new_widgets as $title => $content ) {
                update_option( 'widget_' . $title, $content );
            }
            return true;
        }
        return false;
    }

    function get_new_widget_name( $widget_name, $widget_index ) {
        $current_sidebars = get_option( 'sidebars_widgets' );
        $all_widget_array = array( );
        foreach ( $current_sidebars as $sidebar => $widgets ) {
            if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
                foreach ( $widgets as $widget ) {
                    $all_widget_array[] = $widget;
                }
            }
        }
        while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
            $widget_index++;
        }
        $new_widget_name = $widget_name . '-' . $widget_index;
        return $new_widget_name;
    }
}

$exort_importer = new exortImporter;