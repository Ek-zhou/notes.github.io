<?php
/**
 * Output footer widget areas
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$widget_layout = exort_get_option( 'footer_widget_areas', 'none' );
?>

<?php if ( $widget_layout !== 'none' ) : ?>
	<div class="widget-wrapper">
		<div class="container pdd-top-100 pdd-btm-100">
			<div class="row">
			  <?php
				$column_layout = explode( ",", $widget_layout );
				for ( $i = 0; $i < count( $column_layout ); $i++ ) {
					$column_width = explode( "-", $column_layout[$i] );
					$column_count_theme = floor( EXORT_COLUMNS / $column_width[0] * $column_width[1] );
					$column_count = 12 / $column_width[0] * $column_width[1];
					if ( $column_count == 3 ) {
						$column_class = 'col-sm-' . ($column_count_theme * 2) . ' col-md-' . $column_count_theme;
					} elseif ( $column_count == 4 ) {
						$column_class = 'col-sm-' . $column_count_theme;
					} elseif ( $column_count == 6 ) {
						$column_class = 'col-sm-' . ($column_count_theme * 2) . ' col-md-' . $column_count_theme;
					} elseif ( $column_count == 8 ) {
						$column_class = 'col-sm-' . $column_count_theme;
					} elseif ( $column_count == 12 ) {
						$column_class = 'col-sm-' . $column_count_theme;
					}
					if ( is_active_sidebar( 'sidebar-footer-' . ( $i + 1 ) ) ) {
						echo '<div class="' . $column_class . '">';
						dynamic_sidebar( 'sidebar-footer-' . ( $i + 1 ) );
						echo '</div>';
					}
				}
			  ?>
			</div>
		</div>
	</div>
<?php endif; ?>