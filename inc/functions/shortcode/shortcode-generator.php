<?php
/**
 * Add Shortcode Generator Button
 */

if ( class_exists( 'ExortShortcodes' ) ) {

    class ExortShortcodeGenerator {

        function __construct() {
            $exort_shortcodes = new ExortShortcodes();
            add_action( 'init', array( $this, 'init' ) );
        }

        function init() {
            if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
                return;
            }

            if ( get_user_option('rich_editing') == 'true' ) {
                add_filter( 'mce_external_plugins', array( $this, 'shortcodes_plugin' ) );
                add_filter( 'mce_buttons', array( $this,'shortcodes_register' ) );
            }
        }

        function shortcodes_register( $buttons ) {
            array_push( $buttons, "|", "exort_shortcode_button" );
            return $buttons;
        }

        function shortcodes_plugin( $plugin_array ) {
            if ( floatval( get_bloginfo( 'version' ) ) >= 3.9 ) {
                $tinymce_js = EXORT_URL . '/inc/functions/shortcode/js/tinymce.js';
            } else {
                $tinymce_js = EXORT_URL . '/inc/functions/shortcode/js/tinymce-legacy.js';
            }
            $plugin_array['exort_shortcode'] = $tinymce_js;
            return $plugin_array;
        }
    }

    $exort_shortcodes = new ExortShortcodeGenerator();

}
