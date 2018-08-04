<?php
/**
 * The Sidebar containing the default widget areas.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;

$sidebar = exort_check_sidebar();
?>

<?php if ( $sidebar && ( !isset($_GET['nosidebar']) || $_GET['nosidebar'] != 'true' ) ) : ?>
	<aside class="sidebar">
		<div class="sidebar-content">
		<?php do_action( 'exort_before_sidebar_widgets' ); ?>
		<?php if ( is_active_sidebar( $sidebar[1] ) ) : ?>
			<?php dynamic_sidebar( $sidebar[1] ); ?>
		<?php endif; ?>
		</div>
	</aside>
<?php endif; ?>