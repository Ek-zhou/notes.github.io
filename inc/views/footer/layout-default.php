<?php
/**
 * Footer Layout - Style 3
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$footer_copyright = exort_get_option( 'footer_copyright_content', '' );
$footer_color = exort_get_option( 'footer_color_theme', 'dark' );
$footer_bottom_color = '';
if ($footer_color == 'gray') {
    $footer_bottom_color = 'bg-white';
} elseif ($footer_color == 'light') {
    $footer_bottom_color = 'bg-gray';
}

if ($footer_minimal = exort_get_option( 'footer_minimal', false )) {
?>

<div class="container section-2">
    <div class="text-center">
        <?php
        if ($footer_color == 'dark') {
            $text_color = 'text-white';
            $img = 'logo-white.png';
        } else {
            $text_color = 'text-dark';
            $img = 'logo.png';
        }
        ?>
        <img class="img-responsive mrg-horizon-auto" src="<?php echo EXORT_IMAGE_URL; ?>/<?php echo $img; ?>" alt="">
        <div class="mrg-top-15">
            <?php
            $social_links = exort_get_social_site_names();
            foreach ( $social_links as $key => $name ) {
                $exort_option_social_url = exort_get_option('social_' . $key . '_url');
                if ( !empty( $exort_option_social_url ) ) {
                    echo '<a href="' . esc_url( $exort_option_social_url ) . '" class="btn btn-icon border no-border circle ' . $text_color . ' ' . esc_attr( $key ) . '" target="_blank">';
                    echo '<i class="ti-' . esc_attr( $key ) . '"></i>';
                    echo '</a>';
                }
            }
            ?>
        </div>
        <p class="font-weight-normal font-size-12 ls-2 mrg-top-30 <?php echo $text_color; ?>"><?php echo do_shortcode( $footer_copyright ); ?></p>
    </div>
</div>

<?php } else { ?>

<?php exort_get_template( '_widget-area', '', 'footer' ); ?>

<div class="footer-bottom <?php echo $footer_bottom_color; ?>">
    <div class="container">
    <?php if ( !empty( $footer_copyright ) ) : ?>
        <small class="copyright pull-left"><?php echo do_shortcode( $footer_copyright ); ?></small>
    <?php endif; ?>
        <div class="social-icon pull-right">
            <?php
                $social_links = exort_get_social_site_names();
                foreach ( $social_links as $key => $name ) {
                    $exort_option_social_url = exort_get_option('social_' . $key . '_url');
                    if ( !empty( $exort_option_social_url ) ) {
                        echo '<a href="' . esc_url( $exort_option_social_url ) . '" target="_blank">';
                        echo '<i class="fa fa-' . esc_attr( $key ) . '" title="' . esc_attr( $name ) . '" data-toggle="tooltip" data-placement="top"></i>';
                        echo '</a>';
                    }
                }
            ?>
        </div>
    </div>
</div>
<?php } ?>