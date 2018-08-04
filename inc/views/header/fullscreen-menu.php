<?php
/**
 * Header layout - Fullscreen menu
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div id="header">
    <div class="header-btn">
        <a href="#" class="header-btn-navbar"></a>
    </div>
    <div class="overlay">
        <div class="container">
            <div class="menu-wrapper">
                <?php exort_get_template( '_nav', 'header', 'header' ); ?>
            </div>
            <a href="#" class="overlay-close"></a>
        </div>
    </div>
</div>
