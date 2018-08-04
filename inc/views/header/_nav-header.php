<?php
/**
 * Outputs the main menu
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = exort_get_the_ID();

$header_layout = exort_get_header_layout();
if ($page_header_layout = get_post_meta( $page_id, '_exort_page_settings_menu_style', true)) {
    $header_layout = $page_header_layout;
}

$has_primary_menu = has_nav_menu( 'primary' );
$args = array();
if ( $custom_menu = get_post_meta( $page_id, '_exort_page_settings_custom_menu', true ) ) {
    $args['menu'] = $custom_menu;
} else {
    $args['theme_location'] = 'primary';
}

$one_page_nav = get_post_meta( $page_id, '_exort_page_settings_one_page_nav', true );

$menu_class = 'menu';
if ( $one_page_nav ) {
    $args['depth'] = 1;
    $menu_class .= ' nav';
}
$container_class = 'exort-menu';
if ( $header_layout == 'default-light' || $header_layout == 'default-dark' || $header_layout == 'transparent-light' || $header_layout == 'transparent-dark' || $header_layout == 'logo-center-top' || $header_layout == 'logo-center-top-transparent' ) {
    $container_class .= ' hidden-mobile';
}

if ( $custom_menu || $has_primary_menu ) {
    if ( $page_id && $header_layout == 'side-menu' ) {
        wp_nav_menu( array(
                'container'         => '',
                'container_class'   => '',
                'container_id'      => '',
                'link_before'       => '',
                'link_after'        => '',
                'menu_class'        => 'sidebar-menu',
            ) + $args );
    } elseif ( !$one_page_nav && class_exists( 'ubermenu' ) && $header_layout != 'fullscreen-menu' && $header_layout != 'side-menu') {
        ubermenu( 'main', $args );
    } else {
        wp_nav_menu( array(
                'container'         => 'nav',
                'container_class'   => $container_class,
                'container_id'      => 'main-menu',
                'link_before'       => '<span>',
                'link_after'        => '</span>',
                'menu_class'        => $menu_class,
            ) + $args );
    }
} else {
     echo '<nav class="'. esc_attr( $container_class ) .'" id="main-menu"><ul class="' . esc_attr( $menu_class ) . '"><li><a href="' . home_url( '/' ) . 'wp-admin/nav-menus.php"><span>' . __( 'Assign a Menu', 'exort' ) . '</span></a></li></ul></nav>';
}
