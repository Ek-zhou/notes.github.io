<?php
/**
 * The footer
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

do_action( 'exort_hook_after_content' );

$footer_color = exort_get_option( 'footer_color_theme', 'dark' );
?>
		<footer id="footer" class="bg-<?php echo $footer_color; ?>">
			<?php exort_get_template( 'layout', 'default', 'footer' ); ?>
		</footer>
    <?php if ( exort_get_option( 'footer_show_back_to_top_button', true ) ) : ?>
        <a href="#top" class="exort-back-to-top" title="<?php esc_attr_e( 'Back to Top', 'exort' ); ?>"></a>
    <?php endif; ?>

	</div> <!-- end page wrapper -->

<?php do_action( 'exort_hook_bottom' ); ?>

<?php wp_footer(); ?>
</body>
</html>