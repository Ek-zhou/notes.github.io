<?php
/**
 * @see 		https://docs.woocommerce.com/document/template-structure/
 * @author  	WooThemes
 * @package 	WooCommerce/Templates
 * @version 	3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

wc_print_notices();

?>

<div class="container">
    <div class="text-center mrg-btm-120">
        <h2 class="mrg-top-30"><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></h2>
        <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="btn btn-md btn-style-4 mrg-top-30"><?php _e( 'Return To Shop', 'woocommerce' ) ?></a>
    </div>
</div>
