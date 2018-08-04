<?php
/**
 * The template for displaying single portfolio
 */

get_header();

$is_full = false;

$post_layout = get_post_meta( get_the_ID(), '_exort_portfolio_item_view_options', true );
$is_full_media = ( $post_layout == 'full' && exort_has_post_thumbnail() );
?>

<?php if ( $is_full_media ) :
?>
    <div class="post-image full">
        <div class="post-media parallax skrollable skrollable-between no-parallax" data-bottom-top="top: -50%;" data-top-bottom="top: 0%;">
            <?php echo exort_portfolio_thumbnail( get_the_ID(), false, 'full' ); ?>
        </div>
        <div class="post-figure">
            <div class="post-header">
                <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
<?php endif; ?>
<div id="content">
    <div class="<?php echo exort_get_content_classes($is_full, 'content-wrapper'); ?>">
        <div id="main" role="main">
            <?php if ( have_posts() ) { while ( have_posts() ) : the_post(); ?>
                <?php exort_get_template( 'content-single', 'portfolio' ); ?>
            <?php endwhile; } ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>