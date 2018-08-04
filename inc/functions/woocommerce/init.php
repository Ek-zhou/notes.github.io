<?php
/**
 * WooCommerce configuration
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

GLOBAL $pagenow;

// Image Sizes
function exort_woocommerce_image_dimensions() {
    $catalog = array(
        'width'  => '600',
        'height' => '675',
        'crop'   => 1
    );
    $single = array(
        'width'  => '862',
        'height' => '9999',
        'crop'   => 0
    );
    $thumbnail = array(
        'width'  => '154',
        'height' => '172',
        'crop'   => 1
    );

    update_option( 'shop_catalog_image_size', $catalog );
    update_option( 'shop_single_image_size', $single );
    update_option( 'shop_thumbnail_image_size', $thumbnail );
    update_option( 'woocommerce_single_image_crop', 'no' );
}
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
    add_action( 'init', 'exort_woocommerce_image_dimensions', 1 );
}

function exort_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'exort_add_woocommerce_support', 16 );

// main content
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function exort_woocommerce_before_main_content() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
    echo '<div id="content">';
    echo '<div class="'. exort_get_content_classes(false, 'content-wrapper') .'">';
    echo '<div id="main" role="main" class="entry-content">';
}
function exort_woocommerce_after_main_content() {
    echo '</div>';
}
function exort_woocommerce_sidebar() {
    echo '</div>';
    echo '</div>';
}
add_action( 'woocommerce_before_main_content', 'exort_woocommerce_before_main_content', 10 );
add_action( 'woocommerce_after_main_content', 'exort_woocommerce_after_main_content', 10 );

add_action( 'woocommerce_sidebar', 'exort_woocommerce_sidebar', 20 );


// Remove Product Sale Badge
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// Remove Add to cart
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

// Shop Columns
function exort_woocommerce_shop_columns() {
    return exort_get_option( 'shop_columns', 4 );
}
add_filter( 'loop_shop_columns', 'exort_woocommerce_shop_columns' );

// Shop Posts Per Page
function exort_woocommerce_shop_posts_per_page() {
    return exort_get_option( 'shop_posts_count', 12 );
}
add_filter( 'loop_shop_per_page', 'exort_woocommerce_shop_posts_per_page' );

// Shop thumbnail
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

function exort_woocommerce_shop_thumbnail() {
    $id = get_the_ID();
    $image_class = 'product-img';
    echo '<div class="'. esc_attr( $image_class ) .'">';
        echo get_the_post_thumbnail( $id ,'full' );
        echo '<div class="overlay"><div class="overlay-content"><div class="content-inner">';
            if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {
                woocommerce_template_loop_add_to_cart();
            } else {
                woocommerce_get_template( 'loop/add-to-cart.php' );
            }
            echo '<a href="' . get_permalink($id) . '" title="'. esc_attr__( 'Quick View', 'exort' ) .'"><i class="ti-zoom-in"></i> <span>'. __( 'Quick View', 'exort' ) .'</span></a>';
        echo '</div></div></div>';
    echo '</div>';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'exort_woocommerce_shop_thumbnail', 10 );

// Add shop product content wrap
add_action( 'woocommerce_before_shop_loop_item_title', 'exort_woocommerce_before_shop_loop_item_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'exort_woocommerce_after_shop_loop_item_title', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 4 );

function exort_woocommerce_before_shop_loop_item_title() {
    echo '<div class="product-info">';
}
function exort_woocommerce_after_shop_loop_item_title() {
    echo '</div>';
}

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'exort_woocommerce_template_loop_product_title', 10 );
function exort_woocommerce_template_loop_product_title() {
    echo '<h4 class="product-name"><a href="'. esc_url( get_the_permalink() ) .'">'. get_the_title() .'</a></h4>';
}

// remove page title
add_filter( 'woocommerce_show_page_title', 'exort_woocommerce_remove_page_title' );
function exort_woocommerce_remove_page_title() {
    return false;
}

// quick view
function exort_woocommerce_product_quick_view_thumbnails_columns() {
    return '5';
}
function exort_enqueue_ajax_product_quickview() {
    if ( wp_script_is( 'wc-add-to-cart-variation', 'registered' ) && !wp_script_is( 'wc-add-to-cart-variation' ) ) {
        wp_enqueue_script( 'wc-add-to-cart-variation' );
    }
}
add_action( 'wp_enqueue_scripts', 'exort_enqueue_ajax_product_quickview' );
function exort_ajax_product_quickview() {
    $nonce = $_POST['nonce'];
    $product_id = $_POST['productid'];
    $product = get_product($product_id);
    if ( !$nonce || !$product_id || !$product || !wp_verify_nonce( $nonce, 'exort-ajax' ) ) {
        $response = array( 'success' => false, 'reason' => 'Incorrect data' );
    } else {
        $response = array( 'success' => true );
        $post = get_post( $product_id );
        $GLOBALS['product'] = $product;
        $GLOBALS['post'] = $post;
        $GLOBALS['ajax_quick_view'] = true;
        setup_postdata( $post );

        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        remove_action( 'woocommerce_after_single_product_summary', 'exort_woocommerce_output_related_products', 20 );
        remove_action( 'woocommerce_after_single_product_summary', 'exort_woocommerce_output_upsells', 19 );
        add_filter( 'woocommerce_product_thumbnails_columns', 'exort_woocommerce_product_quick_view_thumbnails_columns' );
        if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
            add_action( 'woocommerce_after_add_to_cart_button', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ), 44 );
        }

        ob_start();
        wc_get_template_part( 'content', 'single-product' );
        wp_reset_postdata();
        $html = ob_get_contents();
        ob_end_clean();
        $response['html'] = $html;
    }
    header( "Content-Type: application/json" );
    echo json_encode( $response );
    exit;
}
add_action( 'wp_ajax_nopriv_exort_ajax_product_quickview', 'exort_ajax_product_quickview' );
add_action( 'wp_ajax_exort_ajax_product_quickview', 'exort_ajax_product_quickview' );


// Single Product
add_action( 'woocommerce_after_single_product_summary', 'exort_woocommerce_end_product_description', 1 );
function exort_woocommerce_end_product_description() {
    echo '</div>';
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );

add_filter( 'yith_wcwl_positions', 'exort_yith_wcwl_positions' );
function exort_yith_wcwl_positions( $positions ) {
    $positions['add-to-cart']['hook'] = 'woocommerce_after_add_to_cart_button';
    $positions['add-to-cart']['priority'] = 44;
    return $positions;
}

add_filter( 'yith_wcwl_add_to_wishlist_button_classes', 'exort_yith_wcwl_add_to_wishlist_button_classes' );
function exort_yith_wcwl_add_to_wishlist_button_classes( $class ) {
    if ( get_option( 'yith_wcwl_use_button' ) == 'yes' ) {
        $class .= ' style-border color-gray';
    }
    return $class;
}

add_filter( 'woocommerce_product_additional_information_heading', 'exort_woocommerce_remove_header' );
add_filter( 'woocommerce_product_description_heading', 'exort_woocommerce_remove_header' );
function exort_woocommerce_remove_header( $heading ) {
    return false;
}

// Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 10 );
add_action( 'woocommerce_after_single_product_summary', 'exort_woocommerce_output_related_products', 20 );
function exort_woocommerce_output_related_products() {

    if ( exort_get_option( 'product_show_related_products', true ) ) {
        $count   = exort_get_option( 'product_related_product_count', 4 );
        $columns = exort_get_option( 'product_related_product_columns', 4 );

        $args = array(
            'posts_per_page' => $count,
            'columns'        => $columns,
            'orderby'        => 'rand'
        );

        woocommerce_related_products( $args, true, true );
    }
}

// Upsells Output
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 10 );
add_action( 'woocommerce_after_single_product_summary', 'exort_woocommerce_output_upsells', 19 );
function exort_woocommerce_output_upsells() {

    if ( exort_get_option( 'product_show_upsell_products', false ) ) {
        $count  = exort_get_option( 'product_upsell_product_count', 4 );
        $columns = exort_get_option( 'product_upsell_product_columns', 4 );

        woocommerce_upsell_display( $count, $columns, 'rand' );
    }
}

// Single product review
add_filter( 'woocommerce_product_review_list_args', 'exort_woocommerce_product_reviews' );
function exort_woocommerce_product_reviews( $callback ) {
    return array( 'callback' => 'exort_woocommerce_comments' );
}

add_filter( 'woocommerce_product_review_comment_form_args', 'exort_woocommerce_product_comment_form_args', 10, 1 );
function exort_woocommerce_product_comment_form_args( $comment_form_passed ) {
    $commenter = wp_get_current_commenter();

    $comment_form = array(
        'title_reply'       => __( 'Leave a Review', 'exort' ),
        'title_reply_to'       => __( 'Leave a Reply to %s', 'exort' ),
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'label_submit'  => __( 'Submit', 'exort' ),
        'id_submit' => 'comment-submit',
        'class_submit' => 'btn btn-lg btn-style-2',
        'logged_in_as'  => '',
        'comment_field' => ''
    );

    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
        $comment_form['comment_field'] = '<div class="form-group"><label>' . __( 'Your Rating', 'exort' ) .'</label><input type="hidden" id="review_score"><span class="input-star-rating">
            <label class="radio"><input type="radio" value="1" name="rating" title="' . esc_attr__( 'Very Poor', 'exort' ) . '"></label>
            <label class="radio"><input type="radio" value="2" name="rating" title="' . esc_attr__( 'Not that bad', 'exort' ) . '"></label>
            <label class="radio"><input type="radio" value="3" name="rating" title="' . esc_attr__( 'Average', 'exort' ) . '"></label>
            <label class="radio"><input type="radio" value="4" name="rating" title="' . esc_attr__( 'Good', 'exort' ) . '"></label>
            <label class="radio"><input type="radio" value="5" name="rating" title="' . esc_attr__( 'Perfect', 'exort' ) . '"></label>
        </span></div>';
    }

    $comment_form['comment_field'] .= '<div class="form-group comment-form-author col-md-6 no-padding-left"><input id="author" name="author" type="text" class="input-text full-width form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="'. esc_attr__( 'Name', 'exort' ) .'" size="30" aria-required="true" /></div>'
        . '<div class="form-group comment-form-email col-md-6 no-padding-right"><input id="email" name="email" type="text" class="input-text full-width form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="'. esc_attr__( 'E-Mail', 'exort' ) .'" size="30" aria-required="true" /></div><div class="clearfix"></div>';
    $comment_form['comment_field'] .= '<div class="form-group"><textarea id="comment" name="comment" class="input-text full-width form-control" rows="6" placeholder="'. esc_attr__( 'Message', 'exort' ) .'" aria-required="true"></textarea></div>';
    return $comment_form;
}

function exort_woocommerce_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
?>
    <li id="comment-<?php comment_ID() ?>" class="comment clearfix">
        <div class="avatar">
            <?php echo exort_get_avatar( array( 'id' => $comment->user_id, 'email' => $comment->comment_author_email, 'size' => 88 ) ); ?>
        </div>
        <div class="comment-info">
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></p>

            <?php else : ?>
                <h4 itemprop="author" class="name"><?php comment_author(); ?></h4>
                <?php
                    if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
                        if ( wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $comment->comment_post_ID ) )
                            echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';

                ?>
                <?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

                    <span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php printf( esc_attr__( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
                        <span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"></span>
                    </span>

                <?php endif; ?>
                <time itemprop="datePublished" class="time" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php comment_date(); ?></time>
            <?php endif; ?>
        </div>
        <div itemprop="description" class="content"><?php comment_text(); ?></div>
    </li>
<?php
}

/* Cart */
remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
add_action( 'woocommerce_cart_actions', 'woocommerce_button_proceed_to_checkout', 10 );

/* Checkout */
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment', 10 );
