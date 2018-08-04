<?php
/**
 * Includes all shortcode functions for exort theme
 */

function filter_eliminate_autop( $content ) {
	$content = do_shortcode( shortcode_unautop($content) );
	return $content;
}

function exort_clean_shortcodes( $content ) {
	$array = array (
	  '<p>['	=> '[',
	  ']</p>'   => ']',
	  ']<br />' => ']',
	);

	$content = strtr( $content, $array );
	$content = preg_replace( "/<br \/>.\[/s", "[", $content );
	return $content;
}
add_filter( 'the_content', 'exort_clean_shortcodes' );

require_once EXORT_FUNC_PATH . '/shortcode/shortcode-generator.php';
