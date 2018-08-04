<?php
/**
 * Template Name: Layout - Full Width
 */

get_header();

$showcase = get_post_meta( exort_get_the_ID(), '_exort_page_settings_showcase', true);
?>

    <div id="content">
        <div class="content-wrapper full">
            <div id="main" role="main" class="entry-content">
                <?php if ($showcase) { echo '<div class="showcase">'; } ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( has_post_thumbnail() ) { ?>
                        <figure class="container block">
                            <?php the_post_thumbnail(); ?>
                        </figure>
                    <?php } ?>
                    <?php the_content(); ?>
                    <div class="container">
                        <?php exort_get_template( '_comments-template' ); ?>
                    </div>
                <?php endwhile; ?>
                <?php if ($showcase) { echo '</div>'; } ?>
            </div><!-- #main -->
        </div>
    </div><!-- #content -->

<?php get_footer();