<?php
/**
 * The template for displaying all pages
 */

get_header();

$showcase = get_post_meta( exort_get_the_ID(), '_exort_page_settings_showcase', true);
?>

    <div id="content"<?php if (exort_check_sidebar()) { echo ' class="section-2"'; } ?>>
        <div class="<?php echo exort_get_content_classes(false, 'content-wrapper'); ?>">
            <div id="main" role="main" class="entry-content">
                <?php if ($showcase) { echo '<div class="showcase">'; } ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( has_post_thumbnail() ) { ?>
                        <figure class="container block">
                            <?php the_post_thumbnail(); ?>
                        </figure>
                    <?php } ?>
                    <?php the_content(); ?>
                    <?php exort_get_template( '_comments-template' ); ?>
                <?php endwhile; ?>
                <?php if ($showcase) { echo '</div>'; } ?>
            </div><!-- #main -->
            <?php get_sidebar(); ?>
        </div>
    </div><!-- #content -->

<?php get_footer();
