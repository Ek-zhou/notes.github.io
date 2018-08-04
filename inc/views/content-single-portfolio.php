<?php
/**
 * Portfolio single template
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;

$portfolio_id = $post->ID;
$project_link = get_post_meta( $portfolio_id, '_exort_portfolio_item_project_link', true );
$media_type = get_post_meta( $portfolio_id, '_exort_portfolio_item_media_type', true );
$view_options = get_post_meta( $portfolio_id, '_exort_portfolio_item_view_options', true );
$media_gallery_type_style = get_post_meta( $portfolio_id, '_exort_portfolio_item_gallery_view_style', true );
$media_gallery_type_columns = (int)get_post_meta( $portfolio_id, '_exort_portfolio_item_gallery_columns', true );
$remove_meta = get_post_meta( $portfolio_id, '_exort_portfolio_remove_meta', true );
$desc = get_post_meta( $portfolio_id, '_exort_portfolio_item_desc', true );
$client = get_post_meta( $portfolio_id, '_exort_portfolio_item_client', true );
$related_works = get_post_meta( $portfolio_id, '_exort_portfolio_related_works', true );

$in_same_term = ( exort_get_option( 'portfolio_prev_next_nav' ) == 'same_category' ) ? true : false;
$prev_post = get_adjacent_post( $in_same_term, '', true, 'portfolio_category' );
$next_post = get_adjacent_post( $in_same_term, '', false, 'portfolio_category' );
$portfolio_page_link = get_page_link( exort_get_portfolio_page_ID() );

$portfolio_social_links_style = apply_filters( 'exort_single_portfolio_social_icon_style', 'style1' );
?>

<article id="portfolio-<?php the_ID(); ?>" class="section">
    <?php if ($view_options == 'wide') { ?>

        <div class="col-sm-5">
            <div class="work-single-detail mrg-top-75">
                <p><b><?php _e( 'Client', 'exort' ); ?> :</b> <?php echo $client; ?></p>
                <p><b><?php _e( 'Date', 'exort' ); ?> :</b> <?php echo get_the_date( 'j F, Y' ); ?></p>
                <p><b><?php _e( 'Live Site', 'exort' ); ?> :</b> <a href="<?php echo $project_link; ?>"><?php echo $project_link; ?></a></p>
            </div>
        </div>
        <div class="col-sm-7"><h3 class="mrg-btm-30"><?php the_title(); ?></h3><p><?php echo $desc; ?></p></div>
        <div class="clearfix"></div>
        <?php
        echo exort_post_thumbnail( get_the_ID() );
        the_content();
        if ($related_works && $related_works != '') { ?>
            <div class="col-sm-12 mrg-top-120">
                <h2 class="heading mrg-btm-70">Related Works</h2>
                <?php echo do_shortcode('[portfolio hover_style="3" ids="' . $related_works . '"]'); ?>
            </div>
        <?php } ?>
        <div class="clearfix"></div>

    <?php } else if ($view_options == 'vertical') { ?>

        <div class="col-md-4 col-sm-6">
            <div class="col-md-11 row">
                <div class="mrg-btm-50"><h3 class="mrg-btm-20"><?php echo get_the_title(); ?></h3><p class="font-size-13 font-weight-normal"><?php echo $desc; ?></p></div>
                <div class="mrg-btm-50"><h4><?php _e( 'Client', 'exort' ); ?> :</h4><p class="font-size-13 font-weight-normal"><?php echo $client; ?></p></div>
                <div class="mrg-btm-50"><h4><?php _e( 'Date', 'exort' ); ?> :</h4><p class="font-size-13 font-weight-normal"><?php echo get_the_date( 'j F, Y' ); ?></p></div>
                <div class="mrg-btm-70"><h4><?php _e( 'Live Site', 'exort' ); ?> :</h4><p class="font-size-13 font-weight-normal"><a href="<?php echo $project_link; ?>"><?php echo $project_link; ?></a></p></div>
                <div class="mrg-btm-50"><h4><?php _e( 'Description', 'exort' ); ?> :</h4><?php echo get_the_content(); ?></div>
                <div class="mrg-btm-50"><h4><?php _e( 'Share', 'exort' ); ?> :</h4><?php echo exort_display_share_buttons('div', 'mrg-top-15'); ?></div>
            </div>
        </div>
        <div class="col-md-8 col-sm-6">
            <?php echo exort_post_thumbnail( get_the_ID() ); ?>
        </div>
        <div class="clearfix"></div>

    <?php } ?>

</article>

<?php if ( exort_get_option( 'portfolio_show_comments', false ) ) {
    exort_get_template('_comments-template');
} ?>

<?php if ( exort_get_option( 'portfolio_prev_next_nav', 'show' ) != 'hide' ) : ?>
    <section class="pdd-vertical-30">
        <div class="container">
            <div class="col-xs-4">
            <?php if ( $prev_post ) : ?>
                <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="text-left">
                    <h5 class="mrg-top-15"><i class="ti-arrow-left pdd-right-10 font-size-10"></i> <?php _e( 'Previous', 'exort' ); ?></h5>
                </a>
            <?php endif; ?>
            </div>
            <div class="col-xs-4">
            <?php if ( exort_get_portfolio_page_ID() ) : ?>
                <a href="<?php echo esc_url( $portfolio_page_link ); ?>" class="text-center">
                    <h2 class="mrg-vertical-10"><i class="ti-view-grid pdd-right-5"></i></h2>
                </a>
            <?php endif; ?>
            </div>
            <div class="col-xs-4">
            <?php if ( $next_post ) : ?>
                <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="text-right">
                    <h5 class="mrg-top-15"><?php _e( 'Next', 'exort' ); ?> <i class="ti-arrow-right pdd-left-10 font-size-10"></i></h5>
                </a>
            <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

