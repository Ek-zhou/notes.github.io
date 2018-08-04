<?php
/**
 * Internal CSS ouput for the site
 */
?>

/* Layout */
<?php
    $site_layout = exort_get_option( 'global_site_layout', 'full_width' );
?>

<?php if ( $site_layout == 'full_width' ) : ?>
#page-wrapper { margin-left: auto; margin-right: auto; }
.container { width: 100%; padding-left: 30px; padding-right: 30px; }
.half-container, .image-box.style-offer > .desc { width: 50%; padding-left: 15px; padding-right: 15px; }
.half-in-container { width: 100%; }
<?php endif; ?>

/* Header & Footer */
<?php
    $header_menu_bar_height = 90;
    $header_sticky_menu_bar_height = 75;
?>
#header .header-inner { height: <?php echo $header_menu_bar_height; ?>px; }
#header .logo img { max-height: <?php echo $header_menu_bar_height; ?>px; }
#header .menu > li > a,
#header .ubermenu-skin-exort-style .ubermenu-item-level-0 > .ubermenu-target,
#header .header-top-nav .wpml-languages > a,
#header .header-top-nav .header-mini-cart > a,
#header .header-top-nav .header-search-btn > a { height: <?php echo $header_menu_bar_height; ?>px; line-height: <?php echo $header_menu_bar_height; ?>px; }
#header.header-sticky .menu > li > a,
#header.header-sticky .ubermenu-skin-exort-style .ubermenu-item-level-0 > .ubermenu-target,
#header.header-sticky .header-top-nav .wpml-languages > a,
#header.header-sticky .header-top-nav .header-mini-cart > a,
#header.header-sticky .header-top-nav .header-search-btn > a { height: <?php echo $header_sticky_menu_bar_height; ?>px; line-height: <?php echo $header_sticky_menu_bar_height; ?>px; }
body.header-side-menu #sub-header .page-title-container { margin-top: <?php echo $header_menu_bar_height; ?>px; }

/* Responsive */
<?php
    $mobile_menu_screen_width = exort_get_option( 'header_show_mobile_menu_width', '992' );
    if ( empty( $mobile_menu_screen_width ) ) {
        $mobile_menu_screen_width = '992';
    }
?>
@media (max-width: <?php echo esc_html( (int)$mobile_menu_screen_width - 1 ); ?>px) {
    .hidden-mobile { display: none !important; }
    #header .menu-wrapper { padding-right: 50px; }
    #header .ubermenu { display: none !important; }
}
@media (min-width: <?php echo esc_html( $mobile_menu_screen_width ); ?>px) {
    .mobile-menu { display: none !important; }
    .visible-mobile { display: none !important; }
    #header .menu, #header .ubermenu { display: inline-block !important; }
}
@media (max-width: 767px) {
    .half-in-container { max-width: none; }
    .image-box.style-offer > .desc { float: none; clear: both; display: block; margin: 0 auto; }
}