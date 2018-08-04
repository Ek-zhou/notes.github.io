<?php
/**
 * Proceed to checkout button
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<a href="<?php echo esc_url( wc_get_checkout_url() );?>" class="checkout-button button alt wc-forward btn btn-style-4 btn-md alignright">
	<?php esc_html_e( 'Checkout', 'exort' ); ?>
</a>
<div class="clear"></div>
