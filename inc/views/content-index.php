<?php
/**
 * Index Page output
 */

$pagination_style = false;
$layout = 'masonry';
$columns = 3;
if ( is_home() ) {
    $layout = exort_get_option( 'blog_style', 'masonry' );
    $columns = exort_get_option( 'blog_columns', 3 );
    $pagination_style = exort_get_option( 'blog_pagination_style', 'default' );
} else if ( is_archive() ) {
    $layout = exort_get_option( 'blog_archive_style', 'masonry' );
    $columns = exort_get_option( 'blog_archive_columns', 3 );
    $pagination_style = exort_get_option( 'blog_archive_pagination_style', 'default' );
} else if ( is_search() ) {
    $layout = exort_get_option( 'blog_search_style', 'masonry' );
    $columns = exort_get_option( 'blog_search_columns', 3 );
    $pagination_style = exort_get_option( 'blog_search_pagination_style', 'default' );
}

if ( have_posts() ) {
    echo exort_get_content_post(false, $layout, $columns, $pagination_style);
} else if ( is_search() ) { ?>
    <h5 class="hero-heading text-xform-none font-weight-bold ls-1"><?php _e( 'There are no search results.', 'exort' ); ?></h5>
<?php } else { ?>
    <div class="fs-img-parallax">
        <div class="hero-caption caption-center caption-height-center container">
            <i class="ti-face-sad font-size-100 text-white"></i>
            <h1 class="hero-heading text-xform-none font-weight-bold ls-1 mrg-top-30"><?php _e( '404', 'exort' ); ?></h1>
            <h3 class="hero-heading text-xform-none font-weight-bold ls-1"><?php _e( 'Pages Not Found', 'exort' ); ?></h3>
            <p class="hero-text-alt mrg-top-30"><?php _e( 'Ops! Something went wrong, this page does not exists', 'exort' ); ?></p>
            <div class="text-center mrg-top-30">
                <a href="javascript:history.back(1);" class="btn btn-md btn-style-4"><?php _e( 'Go back', 'exort' ); ?></a>
                <a href="mailto:<?php echo esc_attr(get_option( 'admin_email' )); ?>" class="btn btn-md btn-style-2"><?php _e( 'Contact us', 'exort' ); ?></a>
            </div>
        </div>
    </div>
<?php }
