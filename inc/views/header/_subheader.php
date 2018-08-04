<?php
/**
 * Outputs sub header
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$id = exort_get_the_ID();
$subtitle = get_post_meta( $id, '_exort_page_settings_subtitle', true );
$subheader_layout = exort_get_option( 'subheader_layout', 'both-center' );
if ($page_subheader_layout = get_post_meta( $id, '_exort_page_settings_subheader_layout', true)) {
    $subheader_layout = $page_subheader_layout;
}
$subheader_border = get_post_meta( $id, '_exort_page_settings_subheader_border', true );

$extra_class = '';
?>

<div class="page-title-container <?php if ($subheader_layout == 'both-center') { echo 'text-center'; } ?>">
    <?php
        if ($subheader_layout == 'both-center') {
            if ($subheader_border == 'thin') {
                echo '<div class="pdd-horizon-5 pdd-vertical-5 border">';
                echo '<div class="text-center bg-transparent-light pdd-horizon-50 pdd-top-30 pdd-btm-30">';
            } elseif ($subheader_border == 'dark-thick') {
                echo '<div class="text-center bg-transparent-light border border-dark thick-md pdd-vertical-30 pdd-horizon-30">';
            } elseif ($subheader_border == 'light-thick') {
                echo '<div class="text-center bg-transparent-dark border thick-md pdd-vertical-30 pdd-horizon-30">';
            }
        }
    ?>
    <div class="page-title <?php if ($subheader_layout == 'title-right,breadcrumb-left') { echo 'pull-right'; } elseif ($subheader_layout == 'title-left,breadcrumb-right') { echo 'pull-left'; } ?>">
        <h2 class="entry-title"><?php exort_display_page_title(); ?></h2>
        <?php if ( $subtitle ) : $extra_class = 'mrg-top-30'; ?>
            <p class="sub-title"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>
    </div>
    <?php
        if( $subheader_layout == 'title-left,breadcrumb-right') {
            exort_breadcrumbs('pull-right', $extra_class);
        } elseif ( $subheader_layout == 'title-right,breadcrumb-left') {
            exort_breadcrumbs('pull-left', $extra_class);
        } else {
            exort_breadcrumbs('');
        }
        if ($subheader_border != 'none' && $subheader_layout == 'both-center') {
            echo '</div>';
            if ($subheader_border == 'thin') {
                echo '</div>';
            }
        }
    ?>
</div>
