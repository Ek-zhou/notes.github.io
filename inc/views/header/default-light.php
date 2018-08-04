<?php
/**
 * Header layout - Default Light
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = exort_get_the_ID();
$one_page_nav = get_post_meta( $page_id, '_exort_page_settings_one_page_nav', true );
$fullwidth_menu = get_post_meta( $page_id, '_exort_page_settings_fullwidth_menu', true );
?>

<div class="container<?php if ($fullwidth_menu) { echo '-fluid'; } ?>">
    <div class="header-inner">
        <?php exort_get_template( '_branding', '', 'header' ); ?>
        <div class="menu-wrapper <?php if ($one_page_nav) { echo 'one-page-nav'; } ?>">
            <?php exort_get_template( '_nav', 'header', 'header' ); ?>
            <div class="header-top-nav">
                <?php if ( class_exists( 'Woocommerce' ) && exort_get_option( 'cart_show_mini_cart', true ) ) : ?>
                <?php
                    global $woocommerce;
                    $cart_url = $woocommerce->cart->get_cart_url();
                    $cart_count = $woocommerce->cart->get_cart_contents_count();
                ?>
                    <div class="header-mini-cart hidden-mobile">
                        <a href="<?php echo esc_url( $cart_url ); ?>"><i class="ti-bag"></i><span class="notice-num"><?php echo $cart_count; ?></span></a>
                        <div class="cart-content">
                            <?php woocommerce_mini_cart(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="header-search-btn hidden-mobile">
                    <a href="#"><i class="fa fa-search"></i></a>
                </div>
                <?php exort_display_wpml_languages(); ?>
                <?php if ( !empty( $header_button_text ) ) : ?>
                <a href="<?php echo esc_url( $header_button_link ); ?>" class="<?php echo esc_attr( $header_button_class ); ?>"<?php echo exort_esc_post( $header_button_attrs ); ?>><span><?php echo esc_html( $header_button_text ); ?></span></a>
                <?php endif; ?>
            </div>
        </div>
        <a href="#" class="header-btn-navbar visible-mobile"><i class="ti-menu"></i></a>
    </div>
    <?php exort_get_template( '_nav', 'mobile', 'header' ); ?>
</div>
<?php exort_get_template( '_search', 'bar', 'header' ); ?>