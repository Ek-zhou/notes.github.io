<?php
/**
 * Display Single post contenet according to its post format
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$id = get_the_ID();
$categories = get_the_category();
$post_layout = get_post_meta( $id, '_exort_page_settings_post_view', true );
$post_content_view = get_post_meta( $id, '_exort_page_settings_post_content_view', true );
if ( empty( $post_content_view ) ) {
    $post_content_view = 'default';
}

$post_format = get_post_format();
?>

<div class="blog-post single-post">
    <div class="blog-wrapper">
        <?php if (!$post_format || $post_format == 'image') { ?>
        <div class="blog-img">
            <?php
            $thumb_url = wp_get_attachment_image_url( get_post_thumbnail_id( $id ), 'full' );
            if ( $thumb_url )
                printf( '<img class="img-responsive" alt="" src="%s">', $thumb_url );
            ?>
        </div>
        <?php } else if ($post_format == 'gallery') {
            $gallery_ids = get_post_meta( $id, '_exort_post_gallery', false );
            if ( empty( $gallery_ids ) ) {
            }
            $post_html .= '<div class="blog-slider">';
            $code = '[slider nav_style="" pagi="" class="blog-post-slide"]';
            foreach ( $gallery_ids as $aID ) {
            $code .= '[slider_item img_id="' . $aID . '"]';
            }
            $code .= '[/slider]';
            $post_html .= do_shortcode($code);
            $post_html .= '</div>';
            echo $post_html;
        } ?>
        <div class="post-content">
            <div class="post-meta">
                <p>
                    By <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta( 'display_name' ); ?></a>
                    <span class="pdd-horizon-5">/</span>
                    <i class="ti-time pdd-right-5"></i>
                    <span><?php echo get_the_date("d M Y"); ?></span>
                    <span class="pdd-horizon-5">/</span>
                    <a href="<?php echo get_comments_link(); ?>"><i class="ti-comment pdd-right-5"></i> <?php echo get_comments_number(); ?> <?php _e('Comments', 'exort'); ?></a>
                </p>
            </div>
            <?php the_content(); ?>
            <div class="post-bottom">
                <?php
                $posttags = get_the_tags();
                if ( $posttags ) {
                ?>
                <div class="tag">
                    <h5 class="mrg-btm-15"><?php _e('Tag :', 'exort'); ?></h5>
                    <ul class="tag">
                    <?php
                        foreach( $posttags as $tag ) {
                            echo '<li><a href="'. get_tag_link($tag->term_id) .'">' . esc_html( $tag->name ) . '</a></li>';
                        }
                    ?>
                    </ul>
                </div>
                <?php } ?>
                <?php
                $buttons = exort_get_option('blog_post_sharing');
                $check = false;
                foreach ($buttons as $button) {
                    $check = $check || $button;
                }
                if ($check) {
                ?>
                <div class="share mrg-top-50">
                    <h5 class="mrg-btm-15"><?php _e('Share Post :', 'exort'); ?></h5>
                    <?php echo exort_display_share_buttons('div', 'mrg-top-15'); ?>
                </div>
                <?php } ?>
            </div>
            <?php exort_display_post_author('mrg-top-30'); ?>
        </div>
        <?php exort_get_template( '_comments-template' ); ?>
    </div>
</div>

<?php if ( exort_get_option( 'blog_prev_next_nav', 'show' ) != 'hide' ) : ?>
    <?php exort_next_prev_links(); ?>
<?php endif; ?>
