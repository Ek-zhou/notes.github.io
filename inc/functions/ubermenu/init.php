<?php
/**
 *  Ubermenu related actions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function exort_add_ubermenu_custom_skin() {
    $stylesheet_src = EXORT_URL . '/css/exort-ubermenu.css';
    ubermenu_register_skin('exort-style', __( 'Exort skin', 'exort' ), $stylesheet_src);
}
add_action( 'init', 'exort_add_ubermenu_custom_skin', 16 );

function exort_ubermenu_set_default_skin( $fields ) {
    $fields['ubermenu_main'][70]['default'] = 'exort-style';
    return $fields;
}
add_filter( 'ubermenu_settings_panel_fields', 'exort_ubermenu_set_default_skin' );
