<?php
/**
 * Template Name: Layout - Portfolio
 */

get_header();

$page_id = exort_get_the_ID();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
$cols = get_post_meta( $page_id, '_exort_portfolio_columns', true );
$is_fullwidth = get_post_meta( $page_id, '_exort_portfolio_is_fullwidth', true );
$count = get_post_meta( $page_id, '_exort_portfolio_posts_per_page', true );
$style = get_post_meta( $page_id, '_exort_portfolio_style', true );
$hover_style = get_post_meta( $page_id, '_exort_portfolio_hover_style', true );
$is_space = get_post_meta( $page_id, '_exort_portfolio_is_space', true );
$content_area = get_post_meta( $page_id, '_exort_portfolio_content_area', true );
$filters = get_post_meta( $page_id, '_exort_portfolio_category_filters', true );
if ( empty( $filters ) ) {
    $filters = array( 'All Categories' );
} else {
    $filters = explode( ',', $filters );
}
$filtering_visibility = get_post_meta( $page_id, '_exort_portfolio_disable_filtering', true );

$pagination_style = get_post_meta( $page_id, '_exort_portfolio_loading_style', true );
$orderby = get_post_meta( $page_id, '_exort_portfolio_orderby', true );
$order = get_post_meta( $page_id, '_exort_portfolio_order', true );

if ( $style == 'fancy' && (int)$cols > 3 ) {
    $cols = '3';
}

if ( !empty( $_GET['pgnstyle'] ) ) { // demo site
    $pagination_style = $_GET['pgnstyle'];
}
?>

<div id="content">
    <div class="<?php echo exort_get_content_classes($is_fullwidth, 'content-wrapper'); ?>">
        <div id="main" role="main">
        <?php
            if ( $content_area == 'before_items_all_page' || 
                ( $content_area == 'before_items_first_page' && (int)$paged === 1 ) ) {
                echo '<div class="page-info box">';
                if ( have_posts() ) {
                    while ( have_posts() ) : the_post();
                        the_content();
                    endwhile;
                }
                echo '</div>';
            }
        ?>
            <div class="portfolio-list">
        <?php
            if ( $filtering_visibility != 'hide' ) {
                if (count($filters) == 1 && in_array('All Categories', $filters)) {
                    $terms = get_terms('portfolio_category');
                } elseif (count($filters) == 1 && !in_array('All Categories', $filters)) {
                    $terms = array();
                    foreach ($filters as $filter) {
                        $children = get_term_children($filter, 'portfolio_category');
                        $terms = array_merge($children, $terms);
                    }
                    $terms = get_terms('portfolio_category', array('include' => $terms));
                } else {
                    $terms = array();
                    foreach ($filters as $filter) {
                        $parent = array($filter);
                        $children = get_term_children($filter, 'portfolio_category');
                        $terms = array_merge($parent, $terms);
                        $terms = array_merge($children, $terms);
                    }
                    $terms = get_terms('portfolio_category', array('include' => $terms));
                }

                $wrap = '<div class="portfolio-filter-group folio-filter-' . $filtering_visibility . ' mrg-btm-50 mrg-vertical-30 text-center">%s</div>';
                $wrap = sprintf($wrap, '%s');

                $filters_html = '<a href="#" class="iso-button iso-active" data-filter="*">' . __('All', 'exort') . '</a>';
                foreach ($terms as $term) {
                    $filters_html .= '<a href="#" class="iso-button" data-filter=".' . $term->slug . '">' . esc_html($term->name) . '</a>';
                }

                printf($wrap, $filters_html);
            }

            $portfolio_args = array(
                'post_type'             => 'portfolio',
                'posts_per_page'        => $count,
                'paged'                 => $paged,
                'order'                 => $order,
                'orderby'               => $orderby,
                'ignore_sticky_posts'   => 1,
            );
            if ( count( $filters ) > 1 || !in_array( 'All Categories', $filters ) ) {
                $portfolio_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'portfolio_category',
                        'field' => 'id',
                        'terms' => $filters
                    )
                );
            }
            $portfolio_query = new WP_Query( $portfolio_args );

            $portfolio_class = array( 'portfolio', 'portfolio-isotope', 'col-' . $cols );
            if ($style == 'masonry') {
                $portfolio_class[] = 'masonry';
            }
            if ($is_space) {
                $portfolio_class[] = 'gutter';
            }
            printf( '<div class="%s">', esc_attr( implode( ' ', $portfolio_class ) ) );
            echo exort_get_content_portfolio( $portfolio_query, $style, $hover_style, $cols, $is_fullwidth );
            echo '</div>';

            if ( $pagination_style != 'none' ) {
                echo exort_pagination( $portfolio_query, false, $pagination_style );
            }

            if ( $content_area == 'after_items_all_page' ||
                ( $content_area == 'after_items_first_page' && (int)$paged === 1 ) ) {
                if ( have_posts() ) {
                    echo '<div class="box"></div><div class="page-info">';
                    while ( have_posts() ) {
                        the_post();
                        the_content();
                    }
                    echo '</div>';
                }
            }
        ?>
            </div>
            <div class="container">
                <?php exort_get_template( '_comments-template' ); ?>
            </div>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>


<?php get_footer(); ?>

