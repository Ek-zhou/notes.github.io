<?php
/**
 * The main template file
 */

get_header(); ?>

<div id="content">
	<div class="<?php echo exort_get_content_classes(false, 'content-wrapper'); ?>">
		<div id="main" role="main">
			<?php exort_get_template( 'content', 'index' ); ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer();