<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     	https://docs.woocommerce.com/document/template-structure/
 * @author  	WooThemes
 * @package 	WooCommerce/Templates
 * @version 	3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' && isset($_GET['register']) ) : ?>

	<div class="bg-white pdd-horizon-70 pdd-vertical-70">

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<div class="col-sm-6">
				<h2 class="heading-left mrg-btm-70 mrg-left-15"><?php _e( 'Personal Info', 'woocommerce' ); ?></h2>
				<div class="col-xs-12 row mrg-btm-30">
					<div class="col-xs-4"><p>Name:</p></div>
					<div class="col-xs-8"><input type="text" class="form-control" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr( $_POST['billing_first_name'] ); ?>" /></div>
				</div>
				<div class="col-xs-12 row mrg-btm-30">
					<div class="col-xs-4"><p>Username:</p></div>
					<div class="col-xs-8"><input type="text" class="form-control" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" /></div>
				</div>
				<div class="col-xs-12 row mrg-btm-30">
					<div class="col-xs-4"><p>Email:</p></div>
					<div class="col-xs-8"><input type="email" class="form-control" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" /></div>
				</div>
				<div class="col-xs-12 row mrg-btm-30">
					<div class="col-xs-4"><p>Phone:</p></div>
					<div class="col-xs-8"><input type="text" class="form-control" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr( $_POST['billing_phone'] ); ?>" /></div>
				</div>
			</div>

			<div class="form-group col-sm-6">
				<h2 class="heading-left mrg-btm-70 mrg-left-15"><?php _e( 'Location Info', 'woocommerce' ); ?></h2>
				<div class="col-xs-12 row mrg-btm-30">
					<div class="col-xs-4"><p>Address:</p></div>
					<div class="col-xs-8"><input type="text" class="form-control" name="billing_address_1" id="reg_billing_address_1" value="<?php if ( ! empty( $_POST['billing_address_1'] ) ) esc_attr( $_POST['billing_address_1'] ); ?>" /></div>
				</div>
				<div class="col-xs-12 row mrg-btm-30">
					<div class="col-xs-4"><p>City:</p></div>
					<div class="col-xs-8"><input type="text" class="form-control" name="billing_city" id="reg_billing_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) echo esc_attr( $_POST['billing_city'] ); ?>" /></div>
				</div>
				<div class="col-xs-12 row mrg-btm-30">
					<div class="col-xs-4"><p>Postcode:</p></div>
					<div class="col-xs-8"><input type="text" class="form-control" name="billing_postcode" id="reg_billing_postcode" value="<?php if ( ! empty( $_POST['billing_postcode'] ) ) echo esc_attr( $_POST['billing_postcode'] ); ?>" /></div>
				</div>
				<div class="col-xs-12 row mrg-btm-30">
					<div class="col-xs-4"><p>Country:</p></div>
					<div class="col-xs-8">
					<?php
					$countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();
					$field = '<select name="billing_country" id="billing_country" class="country_to_state country_select form-control">'
							. '<option value="">'.__( 'Select a country&hellip;', 'woocommerce' ) .'</option>';

					foreach ( $countries as $ckey => $cvalue ) {
						$field .= '<option value="' . esc_attr( $ckey ) . '" '. selected( $value, $ckey, false ) . '>'. esc_attr( $cvalue ) .'</option>';
					}

					$field .= '</select>';

					$field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>';
					echo $field;
					?>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>

			<div class="pdd-top-30 pdd-btm-50">

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<h2 class="heading mrg-btm-70">Password</h2>
				<div class="col-md-offset-2 col-md-8 col-sm-12 row mrg-btm-100">
					<div class="col-xs-4">
						<p>Password:</p>
					</div>
					<div class="col-xs-8">
						<input type="password" class="form-control" name="password" id="password" />
					</div>
				</div>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

				<div class="form-group col-sm-12 text-center">
					<p class="mrg-btm-50">
						<input type="checkbox" name="agree-checkbox" id="agree-checkbox"> I have read and agree to the <a href="#"><b>Privacy Policy</b></a>
					</p>
					<input type="submit" class="woocommerce-Button btn btn-lg btn-style-2" name="register" value="<?php esc_attr_e( 'Submit', 'woocommerce' ); ?>" />
				</div>

				<div class="clearfix"></div>

			</div>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

<?php else : ?>

	<div class="col-md-offset-3 col-md-6 col-sm-12 bg-white pdd-horizon-70 pdd-vertical-70">

		<h1 class="mrg-btm-70 heading"><?php _e( 'Login', 'woocommerce' ); ?></h1>

		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="username"><?php _e( 'Username:', 'woocommerce' ); ?></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text form-control" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?></label>
				<input class="woocommerce-Input woocommerce-Input--text form-control" type="password" name="password" id="password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<label for="rememberme" class="inline">
					<input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
				</label>
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="pull-right"><?php _e( 'Forget Password?', 'woocommerce' ); ?></a>
			</p>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input type="submit" class="btn btn-block btn-style-2" name="login" value="<?php esc_attr_e( 'Sign In', 'woocommerce' ); ?>" />
			</p>

			<?php if (get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes') { ?>
				<p class="mrg-top-50 text-center">Don't have an account? <a href="?register"><b>Sign Up Now!</b></a></p>
			<?php } ?>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
