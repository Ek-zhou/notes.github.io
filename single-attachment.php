<?php
/**
 * Single Attachment
 */

get_header(); 
?>

<div id="content">
    <div class="<?php echo exort_get_content_classes(false, 'content-wrapper'); ?>">
        <div id="main" role="main">
            <?php while ( have_posts() ) { the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
                    <?php the_content( false ); ?>
                </article>
            <?php } ?>
            <?php exort_pagination(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>