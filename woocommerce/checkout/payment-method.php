<?php
/**
 * Output a single payment method
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="payment_method_<?php echo $gateway->id; ?>">
	<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>" class="radio<?php if ( $gateway->chosen ) { echo ' checked'; } ?>">
		<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" name="payment_method" class="input-radio" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
		<?php echo esc_html( $gateway->get_title() ); ?> <?php echo ($gateway->get_icon()); ?>
	</label>
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo $gateway->id; ?>" <?php if ( ! $gateway->chosen ) : ?>style="display:none;"<?php endif; ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</li>