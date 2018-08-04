<?php
/**
 * Outputs the branding
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$header_layout = exort_get_header_layout();
if ($page_header_layout = get_post_meta( exort_get_the_ID(), '_exort_page_settings_menu_style', true)) {
    $header_layout = $page_header_layout;
}

$exort_logo = exort_get_option( 'global_logo', array( 'url' => EXORT_URL . '/images/logo.png' ) );
if ($header_layout == 'default-dark' || $header_layout == 'transparent-dark') {
    $exort_logo = exort_get_option( 'global_logo_white', array( 'url' => EXORT_URL . '/images/logo-white.png' ) );
}
$exort_logo_text = exort_get_option( 'global_logo_text', '' );
$exort_sticky_logo = $exort_logo;
?>

<div class="logo">
    <a class="normal-logo" href="<?php echo esc_url( home_url('/') ); ?>" title="<?php bloginfo('name'); ?> - <?php esc_html_e( 'Home', 'exort' ); ?>">
        <img src="<?php echo esc_url($exort_logo['url']); ?>" alt="<?php bloginfo('name'); ?>"><?php echo empty( $exort_logo_text ) ? '' : esc_html( $exort_logo_text ); ?>
    </a>
    <a class="sticky-logo" href="<?php echo esc_url( home_url('/') ); ?>" title="<?php bloginfo('name'); ?> - <?php esc_html_e( 'Home', 'exort' ); ?>">
        <img src="<?php echo esc_url($exort_sticky_logo['url']); ?>" alt="<?php bloginfo('name'); ?>"><?php echo empty( $exort_logo_text ) ? '' : esc_html( $exort_logo_text ); ?>
    </a>
</div>