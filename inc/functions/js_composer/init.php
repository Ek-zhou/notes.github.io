<?php
/**
 * Initialize Visual Composer
 */

if ( class_exists( 'Vc_Manager', false ) ) {
    function exort_vcSetAsTheme() {
        vc_set_as_theme(true);
    }
    add_action( 'vc_before_init', 'exort_vcSetAsTheme' );

    if ( function_exists( 'vc_disable_frontend' ) ) {
        vc_disable_frontend();
    }

    function exort_load_js_composer() {
        require_once EXORT_FUNC_PATH . '/js_composer/js_composer.php';
    }
    add_action( 'vc_before_init', 'exort_load_js_composer' );

    if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
        vc_set_shortcodes_templates_dir( EXORT_FUNC_PATH . '/js_composer/vc_templates' );
    }
}
