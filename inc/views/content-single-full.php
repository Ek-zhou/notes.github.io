<?php
/**
 * Display Single post contenet according to its post format
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$post_content_view = get_post_meta( get_the_ID(), '_exort_page_settings_post_content_view', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'style-full' ) ); ?>>
    <div class="post-content">
        <?php if ( get_post_format() == 'quote' ) : ?>
        <?php 
            $quote = get_post_meta( get_the_ID(), '_exort_quote_quote', true );
            $cite = get_post_meta( get_the_ID(), '_exort_quote_cite', true );
        ?>
            <blockquote class="style2 box">
                <?php echo esc_html( $quote ); ?>
            <?php if ( $cite ) : ?>
                <cite><?php echo esc_html( $cite ); ?></cite>
            <?php endif; ?>
            </blockquote>
        <?php endif; ?>
        <div class="entry-content"><?php the_content(); ?></div>
        <?php exort_display_post_tags(); ?>
        <?php if ( exort_get_option( 'blog_show_author_in_posts', true ) ) : ?>
            <?php exort_display_post_author(); ?>
        <?php endif; ?>
    </div>
    <?php exort_get_template( '_wp_link_pages' ); ?>

    <?php if ( exort_get_option( 'blog_prev_next_nav', 'show' ) != 'hide' ) : ?>
        <?php exort_next_prev_links(); ?>
    <?php endif; ?>

    <?php
        if ( exort_get_option( 'blog_show_related_posts', true ) ) {
            exort_display_related_posts();
        }

        exort_get_template( '_comments-template' );
    ?>
</article>