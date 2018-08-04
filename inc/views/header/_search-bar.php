<?php
/**
 * Top Search Bar
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div class="top-search-bar display-none">
    <form action='<?php echo esc_url( home_url( '/' ) ); ?>' id='search' method='get'>
        <div class="input">
            <div class="container">
                <input type='text' class="search" name="s" placeholder='Search...'>
                <button class="submit ti-search" type="submit" value="close"></button>
            </div>
        </div>
        <button class="ti-close toggle-close" id="close" type="reset"></button>
    </form>
</div>
