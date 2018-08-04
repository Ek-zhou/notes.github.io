<?php
/**
 * Include all Javascripts
 */

if ( ! function_exists( 'exort_enqueue_frontend_scripts' ) ) {
	function exort_enqueue_frontend_scripts() {
		if ( ! is_admin() ) {
			wp_register_script( 'jquery-no-conflict', get_template_directory_uri() . '/js/jquery.noconflict.js', array( 'jquery' ), NULL, false );
			wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.2.8.3.min.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/js/jquery-migrate-1.2.1.min.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'countdown', get_template_directory_uri() . '/js/jquery.countdown.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'appear', get_template_directory_uri() . '/js/jquery.appear.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'ytplayer', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'particleground', get_template_directory_uri() . '/js/jquery.particleground.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'fullpage', get_template_directory_uri() . '/js/jquery.fullPage.min.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'rainyday', get_template_directory_uri() . '/js/rainyday.js', array( 'jquery' ), NULL, true );

			wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'plugins', get_template_directory_uri() . '/js/jquery.plugins.min.js', array( 'jquery' ), NULL, true );

			wp_register_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), NULL, true );
			wp_register_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), NULL, true );
			
			wp_register_script( 'vimeo', 'http://f.vimeocdn.com/js/froogaloop2.min.js', array( 'jquery' ), NULL, true );

			wp_register_script( 'google-map', get_template_directory_uri() . '/js/google-map.js', array( 'jquery' ), NULL, true );

			$depends = array( 'jquery' );
            if ( class_exists( 'Vc_Manager', false ) ) {
                $depends[] = 'wpb_composer_front_js';
            }
			wp_register_script( 'exort-js-main', get_template_directory_uri() . '/js/theme.js', $depends, NULL, true );


			wp_enqueue_script( 'jquery-no-conflict' );

			global $post;
			$exort_mobile_width = exort_get_option( 'header_show_mobile_menu_width', '992' );
			if ( empty( $exort_mobile_width ) ) {
				$exort_mobile_width = '992';
			}
			$exort_local = array(
				'postID'    => empty( $post->ID ) ? null : $post->ID,
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				'ajaxNonce' => wp_create_nonce('exort-ajax'),
				'mobileWidth'=> $exort_mobile_width,
			);
			wp_localize_script( 'exort-js-main', 'exortLocal', $exort_local );

			wp_enqueue_script( 'modernizr' );
			wp_enqueue_script( 'jquery-migrate' );
			wp_enqueue_script( 'magnific-popup' );
			wp_enqueue_script( 'countdown' );
			wp_enqueue_script( 'appear' );
			wp_enqueue_script( 'ytplayer' );
			wp_enqueue_script( 'particleground' );
			wp_enqueue_script( 'fullpage' );
			wp_enqueue_script( 'rainyday' );

			wp_enqueue_script( 'bootstrap' );
			wp_enqueue_script( 'plugins' );
			wp_enqueue_script( 'owl-carousel' );
			wp_enqueue_script( 'waypoints' );
			wp_enqueue_script( 'vimeo' );
			wp_enqueue_script( 'exort-js-main' );

			wp_enqueue_script( 'google-maps', 'http://maps.google.com/maps/api/js' , array( 'jquery' ), null , true );
			wp_enqueue_script( 'google-map' );

			if ( is_singular() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			if ( class_exists( 'Woocommerce' ) ) {
				wp_enqueue_script( 'exort-js-wc-custom', get_template_directory_uri() . '/js/woocommerce-custom.js', array( 'jquery' ), NULL, true );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'exort_enqueue_frontend_scripts' );

if ( ! function_exists( 'exort_enqueue_backend_scripts' ) ) :
	function exort_enqueue_backend_scripts($page) {
		if ( $page != 'post.php' && $page != 'post-new.php' ) {
			return;
		}

		wp_register_script( 'exort-admin-js-post-meta', get_template_directory_uri() . '/js/admin/post-meta.js', array( 'jquery' ), NULL, true );
		wp_enqueue_script( 'exort-admin-js-post-meta' );
	}

	add_action( 'admin_enqueue_scripts', 'exort_enqueue_backend_scripts' );
endif;