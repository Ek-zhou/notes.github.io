<?php
class ExortPostLike {

	private static $instance = null;

	private function __construct() { }

	function init() {
		add_action( 'wp_ajax_exort_post_like', array( &$this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_exort_post_like', array( &$this, 'ajax' ) );
	}

	public static function get_instance() {
		if ( !self::$instance ) {
			self::$instance = new ExortPostLike();
		}

		return self::$instance;
	}

	function ajax( $post_id ) {

		if ( isset( $_POST['post_id'] ) ) {
			$count = $this->like( intval($_POST['post_id']), 'update' );
		}
		else {
			$count = $this->like( intval($_POST['post_id']), 'get' );
		}
		echo json_encode( array( 'count' => $count, 'text' => __( 'You liked this post', 'exort' ) ) );

		exit;
	}

	function like( $post_id, $action = 'get' ) {
		if ( ! is_numeric( $post_id ) ) return;

		switch ( $action ) {

		case 'get':
			$like_count = get_post_meta( $post_id, 'exort-post-like', true );
			if ( !$like_count ) {
				$like_count = 0;
				add_post_meta( $post_id, 'exort-post-like', $like_count, true );
			}

			return $like_count;
			break;

		case 'update':
			$like_count = get_post_meta( $post_id, 'exort-post-like', true );
			if ( isset( $_COOKIE['exort-post-like-'. $post_id] ) ) return $like_count;

			$like_count++;
			update_post_meta( $post_id, 'exort-post-like', $like_count );
			setcookie( 'exort-post-like-'. $post_id, $post_id, time() + 360*24*60*60, '/' );

			return $like_count;
			break;
		}
	}

	function get( $extra_class = false ) {
		global $post;

		$output = $this->like( $post->ID );
		$output = sprintf( wp_kses( __( '%s <span class="label">Likes</span>', 'exort' ), array( 'span' => array( 'class' => array() ) ) ), '<span class="count">'. $output .'</span>' );
		$class = array( 'post-like' );
		$attrs = '';
		if ( isset( $_COOKIE['exort-post-like-'. $post->ID] ) ) {
			$class[] = 'liked';
			$attrs = ' title="'. esc_attr__( 'You liked this post', 'exort' ) .'" data-toggle="tooltip"';
		}
		if ( $extra_class ) {
			$class[] = $extra_class;
		}

		return '<a href="#" class="'. esc_attr( implode( ' ', $class ) ) .'" data-id="'. $post->ID .'"'. $attrs .'><i class="ti-heart"></i>'. $output .'</a>';
	}

}

ExortPostLike::get_instance()->init();

function exort_post_like( $extra_class = false ) {
	return ExortPostLike::get_instance()->get( $extra_class );
}