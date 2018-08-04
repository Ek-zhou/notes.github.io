<?php
/**
 * WordPress link pages
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

wp_link_pages( array(
    'before'        => '<div class="pager"><div class="page-links">' . __( 'Pages:', 'exort' ) . '&nbsp;&nbsp;',
    'after'         => '</div></div>',
    'link_before'   => '<span class="page">',
    'link_after'    => '</span>',
    'pagelink'      => '%'
) );