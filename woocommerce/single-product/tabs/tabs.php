<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper tab-container tab-horizontal-1 block">
		<ul class="tabs wc-tabs nav custom-tabs tab-style-2">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content">
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<?php
			$class = '';
			if ($key == 'description') {
				$class = 'bg-gray mrg-top-15';
			} else if ($key == 'reviews') {
				$class = 'border btm left right';
			}

			$layout = get_post_meta( get_the_ID(), '_exort_product_page_layout', true );
			?>

			<div class="entry-content wc-tab tab-pane pdd-vertical-30 pdd-horizon-30 <?php echo $class; ?>" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php if ($layout == 'detail2' && $key == 'description') {
					do_action( 'woocommerce_single_product_summary' );
				} else {
					call_user_func( $tab['callback'], $key, $tab );
				} ?>
			</div>
		<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>
