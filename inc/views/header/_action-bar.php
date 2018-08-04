<?php
/**
 * Top Action Bar
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$actionbar_phone = exort_get_option( 'site_phone', '' );
$actionbar_email = exort_get_option( 'site_email', '' );
?>

<div class="top-nav">
    <div class="container-fluid">
    <?php if ( !empty( $actionbar_phone ) ) : ?>
        <div class="topnav-item bordered">
            <span><i class="fa fa-phone mrg-right-5"></i><b class="mrg-right-10"> Phone :</b><?php echo esc_html( $actionbar_phone ); ?></span>
        </div>
    <?php endif; ?>
    <?php if ( !empty( $actionbar_email ) ) : ?>
        <div class="topnav-item bordered">
            <span><i class="fa fa-envelope mrg-right-5"></i><b class="mrg-right-10"> Email :</b><a class="droid-serif-italic" href="mailto:<?php echo esc_html( $actionbar_email ); ?>"><?php echo esc_html( $actionbar_email ); ?></a></span>
        </div>
    <?php endif; ?>

        <div class="topnav-item bordered pull-right">
            <span><a href="<?php echo get_home_url(); ?>/wp-login.php"><i class="ti-user mrg-right-5"></i> Login</a></span>
        </div>

        <!--div class="topnav-item bordered pull-right">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown">USD <i class="ti-angle-down font-size-10"></i></a>
                <ul class="dropdown-menu">
                    <li class="selected"><a href="#"><i class="fa fa-usd mrg-right-10"></i> USD</a></li>
                    <li><a href="#"><i class="fa fa-euro mrg-right-10"></i> EUR</a></li>
                </ul>
            </div>
        </div>

        <div class="topnav-item bordered pull-right">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown">English <i class="ti-angle-down font-size-10"></i></a>
                <ul class="dropdown-menu">
                    <li class="selected"><a href="#">English</a></li>
                    <li><a href="#">Germany</a></li>
                </ul>
            </div>
        </div-->
    </div>
</div>
