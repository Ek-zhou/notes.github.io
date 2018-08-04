<?php
/**
 * Set up the default widget area
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// register widget area
if ( !function_exists( 'exort_widgets_init' ) ) {
	function exort_widgets_init() {
		register_sidebar( array(
			'name'			=> __( 'Default Sidebar', 'exort' ),
			'id'			=> 'sidebar-main',
			'description'   => __( 'Sidebar primary widget area', 'exort' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

		$footer_columns = exort_get_option( 'footer_widget_areas', 'none' );
		if ( $footer_columns !== 'none' ) {
			$footer_columns = count(explode(",", $footer_columns));
			for ( $i = 1; $i <= $footer_columns; $i++ ) {
				register_sidebar(array(
					'name' 			=> 'Footer - column' . $i,
					'id'			=> 'sidebar-footer-' . $i,
					'before_widget'	=> '<div id="%1$s" class="widget %2$s">', 
					'after_widget'	=> '</div>', 
					'before_title'	=> '<div class="widget-title"><h4>',
					'after_title'	=> '</h4></div>',
				));
			}
		}
	}
}
add_action( 'widgets_init', 'exort_widgets_init' );