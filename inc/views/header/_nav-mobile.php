<?php
/**
 * Outputs the mobile menu
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$has_primary_nav = has_nav_menu( 'primary' );
$page_id = exort_get_the_ID();

$header_layout = exort_get_header_layout();
if ($page_header_layout = get_post_meta( $page_id, '_exort_page_settings_menu_style', true)) {
    $header_layout = $page_header_layout;
}

$args = array();
if ( $custom_menu = get_post_meta( $page_id, '_exort_page_settings_custom_menu', true ) ) {
    $args['menu'] = $custom_menu;
} else {
    $args['theme_location'] = 'primary';
}

$one_page_nav = get_post_meta( $page_id, '_exort_page_settings_one_page_nav', true );
if ( $one_page_nav ) {
    $args['depth'] = 1;
}
?>

<div class="mobile-menu-wrapper visible-mobile">
    <div class="container">
        <form method="get" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="text" class="input-text input-lg full-width" name="s" placeholder="Search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    <?php 
        if ( $custom_menu || $has_primary_nav ) {
            wp_nav_menu( array(
                'container'      => false,
                'menu_class'     => 'menu-mobile',
                'walker'         => new ExortMobileMenuWalker()
            ) + $args );
        } else {
             echo '<ul class="menu-mobile"><li><a href="' . home_url( '/' ) . 'wp-admin/nav-menus.php">' . __( 'Assign a Menu', 'exort' ) . '</a></li></ul>';
        }
    ?>
        <ul class="mobile-top-bar menu-mobile">
        <?php
            // WPML - Custom Languages Menu
            if( function_exists( 'icl_get_languages' ) ) {
                $languages = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
                if( is_array( $languages ) && !empty( $languages ) ){

                    foreach ( $languages as $lang_k =>$lang ) {
                        if ( $lang['active'] ) {
                            $active_lang = $lang;
                            unset( $languages[$lang_k] );
                        }
                    }

                    $lang_class = 'menu-item ';
                    if ( count( $languages ) ) {
                        $lang_class .= 'menu-item-has-children enabled';
                    } else {
                        $lang_class .= 'disabled';
                    }

                    echo '<li class="mobile-wpml-languages '. $lang_class .'">';
                    if ( count( $languages ) ) {
                        echo '<span class="open-submenu"></span>';
                    }
                        echo '<a href="'. $active_lang['url'] .'" onclick="return false;">';
                            echo '<i class="ti-world"></i>';
                            echo esc_html( $active_lang['translated_name'] );
                        echo '</a>';

                        if ( count( $languages ) ) {
                            echo '<ul class="sub-menu wpml-lang-dropdown">';
                                foreach( $languages as $lang ) {
                                    echo '<li><a href="'. $lang['url'] .'"><img src="'. $lang['country_flag_url'] .'" alt="'. $lang['translated_name'] .'"/>';
                                    echo esc_html( $lang['translated_name'] );
                                    echo '</a></li>';
                                }
                            echo '</ul>';
                        }
                    echo '</li>';

                }
            }
        ?>
        <?php if ( class_exists( 'Woocommerce' ) && exort_get_option( 'cart_show_mini_cart', true ) ) :
            global $woocommerce;
            $cart_url = $woocommerce->cart->get_cart_url();
        ?>
            <li class="menu-item">
                <span class="open-submenu"></span>
                <a href="<?php echo esc_url( $cart_url ); ?>"><i class="ti-bag"></i>Cart</a>
            </li>
        <?php endif; ?>
        </ul>
    </div>
</div>