<?php
/**
 * The template for displaying Comments.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( post_password_required() ) {
    return;
}
?>

<?php if ( have_comments() ) : ?>
    <div id="comments" class="comment-wrapper mrg-top-50">
        <h3 class="mrg-btm-40"><?php comments_number( __( 'No Comments', 'exort' ), __( 'One Comment', 'exort' ), __( 'Comments (%)', 'exort') );?></h3>
        <ul class="commentlist">
            <?php wp_list_comments('callback=exort_display_comment'); ?>
        </ul>
        <?php paginate_comments_links( array( 'type' => 'list' ) ); ?>
    </div>
<?php else : // this is displayed if there are no comments so far ?>
    
    <?php if ( comments_open() ) { ?>
        <!-- If comments are open, but there are no comments. -->

    <?php } elseif ( ! is_page() ) { // comments are closed ?>
        <!-- If comments are closed. -->
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'exort'); ?></p>

    <?php } ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>
    <?php
        $args = array(
            'title_reply'           => __( 'Leave a Comment', 'exort' ),
            'title_reply_before'    => '<h3 class="text-left mrg-btm-30 mrg-top-50">',
            'fields'                => apply_filters( 'comment_form_default_fields', array(
                'author' => '<div class="col-sm-6 form-group"> <input name="author" type="text" class="form-control" value="" placeholder="' . esc_attr__( 'Name', 'exort' ) . '"> </div>',
                'email' => '<div class="col-sm-6 form-group"> <input name="email" type="text" class="form-control" value="" placeholder="' . esc_attr__( 'E-Mail', 'exort' ) . '"> </div>'
            ) ),
            'comment_field'         => '<div id="comment-textarea" class="form-group"><textarea id="comment" name="comment" rows="6" aria-required="true" class="form-control" placeholder="' . esc_attr__( 'Comment', 'exort' ) . '"></textarea></div>',
            'comment_notes_before'  => '',
            'id_submit'             => 'comment-submit',
            'class_submit'          => 'btn btn-lg btn-style-2',
            'label_submit'          => __( 'Submit', 'exort' ),
        );
     ?>
    <?php comment_form($args); ?>
<?php endif;