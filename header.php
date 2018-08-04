<?php
/**
 * The Header
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
	<?php
    $exort_favicon_icon = exort_get_option( 'global_favicon_icon' );
    if ( ! empty( $exort_favicon_icon['url'] ) ) :
    ?>
<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
    <link rel="shortcut icon" href="<?php echo esc_url( $exort_favicon_icon['url'] ); ?>" type="image/x-icon" />
<?php endif; ?>
    <?php endif; ?>

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php do_action( 'exort_hook_top' ); ?>

    <!-- Pageloader -->
    <div class="page-loader">
        <div class="loader">
            <div class='loader-style-1 panelLoad'>
                <div class='cube-face cube-face-front'><?php _e( 'E', 'exort' ); ?></div>
                <div class='cube-face cube-face-back'><?php _e( 'R', 'exort' ); ?></div>
                <div class='cube-face cube-face-left'><?php _e( 'X', 'exort' ); ?></div>
                <div class='cube-face cube-face-right'><?php _e( 'O', 'exort' ); ?></div>
                <div class='cube-face cube-face-bottom'><?php _e( 'T', 'exort' ); ?></div>
                <div class='cube-face cube-face-top'><?php _e( 'T', 'exort' ); ?></div>
            </div>
            <!-- /Cube panelload -->
            <span class="cube-face"><?php _e( 'EXORT', 'exort' ); ?></span>
        </div>
        <!-- /loader -->
    </div>
    <!-- /Page-loader -->

<?php
$page_id = exort_get_the_ID();
$show_action_bar = exort_get_option( 'header_show_action_bar', false );
$page_show_action_bar = get_post_meta( $page_id, '_exort_page_settings_action_bar', true);
if ($page_show_action_bar != null) {
    $show_action_bar = $page_show_action_bar;
}
if ( $show_action_bar ) {
    exort_get_template( '_action-bar', '', 'header' );
}
$header_layout = exort_get_header_layout();
if ($page_header_layout = get_post_meta( $page_id, '_exort_page_settings_menu_style', true)) {
    $header_layout = $page_header_layout;
}
if ($header_layout != 'fullscreen-menu' && $header_layout != 'side-menu') {
    $header_layout = 'default-light';
}
?>

    <div id="page-wrapper" <?php if ($header_layout == 'side-menu') { echo 'class="side-nav"'; } ?>>

    <?php if ($page_id && $header_layout == 'side-menu') { ?>

        <nav class="sidebar-inner light sidebar-nav">
            <a href="#" class="brand-logo mrg-vertical-30 mrg-left-15">
                <img class="img-responsive" src="<?php echo esc_url(EXORT_IMAGE_URL); ?>/logo.png" alt="">
            </a>
            <?php exort_get_template( '_nav', 'header', 'header' ); ?>
            <div class="sidebar-bottom">
                <?php exort_render_social_links(); ?>
                <h6 class="text-center mrg-btm-50"><?php _e( '&copy; 2016 ALL RIGHT RESERVED.', 'exort' ); ?></h6>
            </div>
        </nav>

        <a class="sidebar-toggle" href="#menu-toggle" id="menu-toggle"><i class="ti-menu"></i></a>

    <?php } elseif ($page_id && $header_layout == 'fullscreen-menu') { ?>

    <?php exort_get_template( $header_layout, '', 'header' ); ?>

    <?php } else { ?>

        <div id="header-wrapper">
            <header id="header">
                <?php exort_get_template( $header_layout, '', 'header' ); ?>
            </header>

        <?php $show_subheader = exort_check_show_subheader(); ?>
        <?php if ( $show_subheader && !is_404() ) : ?>
            <div id="sub-header"<?php exort_subheader_attrs(); ?>>
                <?php
                $subheader_background_video = exort_get_option( 'subheader_background_video', 'false' );
                if ($page_subheader_background_video = get_post_meta( $page_id, '_exort_page_settings_subheader_background_video', true)) {
                    $subheader_background_video = $page_subheader_background_video;
                } ?>
                <?php if ($subheader_background_video) : ?>
                <div class="video-player" data-property="{videoURL:'<?php echo esc_url($subheader_background_video); ?>', containment:'#sub-header', autoPlay:true, mute:true, loop:true, showControls:false, startAt:0, opacity:1}"></div>
                <?php endif; ?>
                <div class="container">
                    <?php exort_get_template( '_subheader', '', 'header' ); ?>
                </div>
            </div>
        <?php endif; ?>
        </div>

    <?php } ?>

        <?php do_action( 'exort_hook_before_content' ); ?>