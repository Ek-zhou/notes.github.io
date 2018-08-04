<?php
/**
 * Taxanomy Portfolio Category
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$page_id = exort_get_the_ID();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

if ( $page_id ) {
    $cols = get_post_meta( $page_id, '_exort_portfolio_columns', true );
    $is_fullwidth = get_post_meta( $page_id, '_exort_portfolio_is_fullwidth', true );
    $count = get_post_meta( $page_id, '_exort_portfolio_posts_per_page', true );
    $style = get_post_meta( $page_id, '_exort_portfolio_style', true );
    $content_area = get_post_meta( $page_id, '_exort_portfolio_content_area', true );
    $filtering_visibility = get_post_meta( $page_id, '_exort_portfolio_disable_filtering', true );

    $pagination_style = get_post_meta( $page_id, '_exort_portfolio_loading_style', true );
    $orderby = get_post_meta( $page_id, '_exort_portfolio_orderby', true );
    $order = get_post_meta( $page_id, '_exort_portfolio_order', true );
} else { // default values
    $style = 'flat1';
    $cols = 3;
    $count = 12;
    $is_fullwidth = false;
	$pagination_style = 'default';
}

if ( $style == 'fancy' && (int)$cols > 3 ) {
    $cols = '3';
}
?>

<div id="content">
    <div class="<?php echo exort_get_content_classes($is_fullwidth, 'content-wrapper'); ?>">
        <div id="main" role="main">
			<div class="portfolio-list">
			<?php
				if ( $filtering_visibility != 'hide' ) :

					$terms = get_term_children( get_queried_object()->term_id, 'portfolio_category' );
					if ( !empty( $terms ) ) {
						$terms = get_terms( 'portfolio_category', array( 'include' => $terms ) );
					}

					$translated_portfolio = exort_get_option( 'translate_portfolio_name', __( 'Portfolio', 'exort' ) );
					$translated_pl_portfolio = exort_get_option( 'translate_portfolio_pl_name', __( 'All Portfolio', 'exort' ) );
					if ( $filtering_visibility == 'style1' || ( $style != 'flat1' && $is_fullwidth ) ) {
						$wrap = '<div class="portfolio-filters style1">%s<h5 class="filter-title">'. esc_html( $translated_pl_portfolio ) .'</h5><h5>'. __( 'Sort', 'exort' ) .':</h5>%s%s</div>';
					} else {
						$wrap = '<div class="portfolio-filters">%s<h5>'. sprintf( __( 'Sort %s:', 'exort' ), $translated_portfolio ) .'</h5>%s%s</div>';
					}
					if ( $is_fullwidth ) {
						$wrap = sprintf( $wrap, '<div class="container">', '%s', '</div>' );
					} else {
						$wrap = sprintf( $wrap, '', '%s', '' );
					}

					$filters_html = '<ul><li><a href="#" class="active" data-filter="filter-all" title="'. esc_attr( $translated_pl_portfolio ) .'">'. __( 'All', 'exort' ) .'</a></li>';
					foreach ( $terms as $term ) {
						$filters_html .= '<li><a href="#" data-filter="filter-'. md5( $term->slug ) .'">'. esc_html( $term->name ) .'</a></li>';
					}
					$filters_html .= '</ul>';

					printf( $wrap, $filters_html );
				endif;

				global $wp_query;

				$portfolio_class = array( 'portfolio-container' );
				if ( $style != "list" ) {
					$portfolio_class[] = 'iso-container';
					$portfolio_class[] = 'iso-col-' . $cols;
					$portfolio_class[] = 'iso-grid';
					if ( $style == 'grid' ) {
						$portfolio_class[] = 'column-width-30';
					} else {
						$portfolio_class[] = 'iso-nospace';
					}
				}
				$portfolio_attr = '';
				$portfolio_attr .= ' id="exort-portfolio-'. exort_blog_counter() .'"';
				if ( $pagination_style == 'ajax' || $pagination_style == 'load_more' ) {
					$portfolio_attr .= ' data-pagination="'. esc_attr( $pagination_style ) .'"';
				}
				if ( $cols ) {
					$portfolio_attr .= ' data-columns="'. esc_attr( $cols ) .'"';
				}
				printf( '<div class="%s"%s>', esc_attr( implode( ' ', $portfolio_class ) ), $portfolio_attr );
					echo exort_get_content_portfolio( false, $style, $cols, $is_fullwidth );
				echo '</div>';

				echo exort_pagination( false, false, $pagination_style );

			?>
			</div>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>


<?php get_footer(); ?>

