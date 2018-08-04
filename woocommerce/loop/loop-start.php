<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

$class = 'products';
global $woocommerce_loop, $exort_shop_product_viewstyle;

$product_columns = 4;
if ( is_shop() || is_product_category() || is_product_tag() ) {
    $product_columns = exort_get_option( 'shop_columns', 4 );
} else if ( isset( $woocommerce_loop['columns'] ) ) {
    $product_columns = esc_attr( $woocommerce_loop['columns'] );
}

$products_atts = '';
if ( isset( $exort_shop_product_viewstyle ) && $exort_shop_product_viewstyle == 'carousel' ) {
    $class .= ' owl-carousel exort-product-slider';
    $exort_shop_product_viewstyle = '';
    unset( $exort_shop_product_viewstyle );

    $products_atts .= ' data-items="'. esc_attr( $product_columns ) . '"';
    switch ( (int)$product_columns ) {
        case 2:
            $products_atts .= ' data-items-custom="[[0, 1], [480, 1], [768, 1], [992, 2], [1200, 2]]"';
            break;
        case 3:
            $products_atts .= ' data-items-custom="[[0, 1], [480, 2], [768, 2], [992, 3], [1200, 3]]"';
            break;
        case 4:
            $products_atts .= ' data-items-custom="[[0, 1], [480, 2], [768, 2], [992, 3], [1200, 4]]"';
            break;
        case 5:
            $products_atts .= ' data-items-custom="[[0, 1], [480, 2], [768, 3], [992, 4], [1200, 5]]"';
            break;
        case 6:
            $products_atts .= ' data-items-custom="[[0, 1], [480, 2], [768, 3], [992, 4], [1200, 6]]"';
            break;
    }
} else {
    $class .= ' cols-' . esc_attr( $product_columns );
}
?>
<ul class="<?php echo esc_attr( $class ); ?>"<?php echo $products_atts; ?>>