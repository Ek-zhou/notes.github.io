<?php
/**
 * Single variation cart button
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<div class="container-fluid no-padding-horizon pdd-vertical-15 border top">
		<div class="col-sm-6 no-padding-horizon">
			<h4>Quantity :</h4>
			<?php if ( ! $product->is_sold_individually() ) : ?>
				<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
			<?php endif; ?>
		</div>
		<div class="col-sm-6 no-padding-horizon">
			<button type="submit" class="single_add_to_cart_button alt btn btn-style-2 btn-lg pull-right float-none-xs mrg-top-30"><i class="ti-shopping-cart"></i> <?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
			<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
			<input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="0" />
		</div>
	</div>
</div>
