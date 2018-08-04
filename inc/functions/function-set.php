<?php
/**
 * Defines functions used in the theme
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* get social site names */
if ( !function_exists( 'exort_get_social_site_names' ) ) {
    function exort_get_social_site_names() {
        return array(
            'facebook'      => __('Facebook', 'exort'),
            'twitter'       => __('Twitter', 'exort'),
            'google'        => __('Google+', 'exort'),
            'instagram'     => __('Instagram', 'exort'),
            'linkedin'      => __('LinkedIn', 'exort'),
            'pinterest'     => __('Pinterest', 'exort'),
            'youtube'       => __('Youtube', 'exort'),
            'vimeo'         => __('Vimeo', 'exort'),
            'dribbble'      => __('Dribbble', 'exort'),
            'tumblr'        => __('Tumblr', 'exort')
        );
    }
}

/* get options value */
if ( !function_exists( 'exort_get_option' ) ) {
    function exort_get_option($option_name, $default = null) {
        global $exort_options;
        if (isset($exort_options[$option_name])) {
            return $exort_options[$option_name];
        }
        if ($default !== null) {
            return $default;
        }
        return false;
    }
}

/* get real page id */
if ( !function_exists( 'exort_get_the_ID' ) ) {
    function exort_get_the_ID() {
        $pageID = false;
        if (!is_404()) {
            if (function_exists('is_shop') && is_shop()) {
                $pageID = woocommerce_get_page_id('shop');
            } elseif (is_tax('portfolio_category')) {
                $pageID = exort_get_portfolio_page_ID();
            } elseif (get_post_type() == 'post' && !is_singular() && get_option('page_for_posts')) {
                $pageID = get_option('page_for_posts');
            } else {
                $pageID = get_the_ID();
            }
        }
        return $pageID;
    }
}

if ( !function_exists( 'exort_wpml_ID' ) ) {
    function exort_wpml_ID( $id, $type = 'page' ) {
        if( function_exists('icl_object_id') ) {
            return icl_object_id( $id, $type, true );
        } else {
            return $id;
        }
    }
}

if ( !function_exists( 'exort_get_portfolio_page_ID' ) ) {
    function exort_get_portfolio_page_ID() {
        $portfolio_page = exort_get_option('portfolio_page', false);
        if (!$portfolio_page) {
            $results = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'template-portfolio.php',
                'sort_order' => 'ASC',
                'sort_column' => 'ID'
            ));

            if (!empty($results)) {
                $portfolio_page = $results[0]->ID;
            }
        }
        if ($portfolio_page) {
            return exort_wpml_ID($portfolio_page);
        }
        return false;
    }
}

if ( !function_exists( 'exort_get_registered_sidebars' ) ) {
    function exort_get_registered_sidebars( $sidebars = array(), $exclude = array() ) {
        global $wp_registered_sidebars;
        foreach ( $wp_registered_sidebars as $sidebar ) {
            if ( !in_array($sidebar['id'], $exclude ) ) {
                $sidebars[$sidebar['id']] = $sidebar['name']; 
            }
        }
        return apply_filters( "exort_get_registered_sidebars", $sidebars );
    }
}

if ( !function_exists( 'exort_check_sidebar' ) ) {
    function exort_check_sidebar() {
        global $post;
        $sidebar_id = false;
        $sidebar_pos = 'full';
        if ( is_home() ) {
            if ( ( $sidebar_pos = exort_get_option( 'sidebar_blog_layout', 'full' ) ) !== 'full' ) {
                $sidebar_id = exort_get_option( 'sidebar_blog_sidebar', 'sidebar-main' );
            }
        } elseif ( is_archive() ) {
            if ( ( ( function_exists( 'is_shop' ) && is_shop() ) ||
                ( function_exists( 'is_product_category' ) && is_product_category() ) ||
                ( function_exists( 'is_product_tag' ) && is_product_tag() ) ) &&
                ( $sidebar_pos = exort_get_option('sidebar_shop_layout') ) != 'full' ) {
                $sidebar_id = exort_get_option( 'sidebar_shop_sidebar', 'sidebar-main' );
            } elseif ( ( $sidebar_pos = exort_get_option('sidebar_archive_layout') ) != 'full' ) {
                $sidebar_id = exort_get_option( 'sidebar_archive_sidebar', 'sidebar-main' );
            }
        } elseif ( is_search() ) {
            if ( ( $sidebar_pos = exort_get_option( 'sidebar_search_layout', 'full' ) ) != 'full' ) {
                $sidebar_id = exort_get_option( 'sidebar_search_sidebar', 'sidebar-main' );
            }
        } elseif ( is_singular() ) {
            $sidebar_pos = get_post_meta( $post->ID, '_exort_'. get_post_type() .'_sidebar_position', true );
            $sidebar_id = get_post_meta( $post->ID, '_exort_'. get_post_type() .'_sidebar_widget_area', true );
            if ( !empty( $sidebar_pos ) && $sidebar_pos !== 'full' && is_active_sidebar( $sidebar_id ) ) {
                //
            }
        }
        if ( !empty( $sidebar_pos ) && $sidebar_pos !== 'full' ) {
            if ( !$sidebar_id ) {
                $sidebar_id = apply_filters( 'exort_default_sidebar', 'sidebar-main' );
            }
            $result = array( $sidebar_pos, $sidebar_id );
            return apply_filters( 'exort_check_sidebar', $result );
        }
        return false;
    }
}

if ( !function_exists( 'exort_get_content_classes') ) {
    function exort_get_content_classes( $is_full = false, $class = '' ) {
        $classes = array();
        if ( !empty( $class ) ) {
            $classes[] = $class;
        }
        if ( !$is_full ) {
            $classes[] = 'container';
        }
        $sidebar = exort_check_sidebar();
        if ( $sidebar && ( !isset($_GET['nosidebar']) || $_GET['nosidebar'] != 'true' ) ) {
            if ( $sidebar[0] === 'left' ) {
                $classes[] = 'sidebar-left';
            }
        } else {
            $classes[] = 'full';
        }

        return esc_attr( implode(' ', $classes) );
    }
}

if ( !function_exists( 'exort_get_template' ) ) {
    function exort_get_template( $base, $extension = '', $stack = '' ) {
        if ( !empty( $stack ) ) {
            $stack .= '/';
        }
        get_template_part( 'inc/views/' . $stack . $base, $extension );
    }
}

if ( !function_exists( 'exort_get_header_layout' ) ) {
    function exort_get_header_layout() {
        $header_layout = exort_get_option( 'header_layout', 'default-light' );
        return $header_layout;
    }
}

if ( !function_exists( 'exort_display_page_title' ) ) {
    function exort_display_page_title() {
        if ( is_category() ) {
            single_cat_title();
        } elseif ( is_tag() ) {
            single_tag_title();
        } elseif ( is_author() ) {
            the_author_meta('display_name');
        } elseif ( is_date() ) {
            single_month_title( ' ' );
        } elseif ( is_search() ) {
            printf( __( 'Search Results for: %s', 'exort' ), '<span>'. get_search_query() .'</span>' );
        } elseif ( is_tax() ) {
            single_term_title();
        } elseif ( is_archive() && function_exists( 'is_shop' ) && is_shop() ) {
            echo exort_get_option( 'translate_shop_page_title', __( 'Shop', 'exort' ) );
        } elseif ( is_home() ) {
            echo exort_get_option( 'translate_blog_page_title', __( 'Blog', 'exort' ) );
        } elseif( is_single() ) {
            echo get_the_title( exort_get_the_ID() );
        } elseif ( get_post_taxonomies() ) {
            if ( single_cat_title('', false) ) {
                echo single_cat_title('', false);
            } else {
                echo get_the_title( exort_get_the_ID() );
            }
        } elseif ( is_page_template( 'template-portfolio.php' ) && $portfolio_page_id = exort_get_portfolio_page_ID() ) {
            echo get_the_title( $portfolio_page_id );
        } else {
            echo get_the_title( exort_get_the_ID() );
        }
    }
}

/* Breadcrumbs */
if ( ! function_exists( 'exort_breadcrumbs' ) ) {
    function exort_breadcrumbs($position = '', $extra_class = '') {
        $separator = '<span>'. do_shortcode( exort_get_option( 'subheader_breadcrumbs_separator', '<i class="ti-angle-right"></i>' ) ) .'</span>';
        if ( class_exists( 'woocommerce' ) && ( is_woocommerce() || is_account_page() || is_wc_endpoint_url() ) ) {
            $woo_crumbs_args = apply_filters( 'woocommerce_breadcrumb_defaults', array(
                'delimiter'   => false,
                'wrap_before' => '<ul class="breadcrumbs woocommerce-breadcrumb ' . $position . ' ' . $extra_class . '">',
                'wrap_after'  => '</ul>',
                'before'      => '<li>',
                'after'       => $separator . '</li>',
                'home'        => __( 'Home', 'exort' ),
            ) );
            woocommerce_breadcrumb( $woo_crumbs_args );
            return;
        }

        global $post;

        $breadcrumbs = array();
        $breadcrumbs[] =  '<a href="'. home_url('/') .'"><i class="ti-home mrg-right-10"></i>'. __( 'Home', 'exort' ) .'</a>';

        // Blog
        if ( get_post_type() == 'post' ) {
            $blogID = false;
            if ( get_option( 'page_for_posts' ) ) {
                $blogID = get_option( 'page_for_posts' );   // Setings / Reading
            }
            if ( $blogID && !is_home() ) {
                $breadcrumbs[] = '<a href="'. get_permalink( $blogID ) .'">'. get_the_title( $blogID ) .'</a>';
            } elseif ( $blogID ) {
                $breadcrumbs[] = '<span>'. get_the_title( $blogID ) .'</span>';
            }
        }

        // Plugin | Events Calendar
        if ( function_exists('tribe_is_month') && ( tribe_is_event_query() || tribe_is_month() || tribe_is_event() || tribe_is_day() || tribe_is_venue() ) ) {
            if ( function_exists('tribe_get_events_link') ) {
                $breadcrumbs[] = '<a href="'. tribe_get_events_link() .'">'. tribe_get_events_title() .'</a>';
            }

        } elseif ( is_front_page() ) {

        // Tag
        } elseif ( is_tag() ) {
            $breadcrumbs[] = '<span>'. single_tag_title('', false) .'</span>';

        // Category
        } elseif ( is_category() ) {
            $breadcrumbs[] = '<span>'. single_cat_title('', false) .'</span>';

        // 404
        } elseif ( is_404() ) {
            $breadcrumbs[] = '<span>'. __( '404 - Page not Found', 'exort') .'</span>';

        // Search page
        } elseif ( is_search() ) {
            $breadcrumbs[] = '<span>'. __( 'Search Results for ', 'exort' ) . '&#8220;' . get_search_query() . '&#8221;' .'</span>';

        // Author
        } elseif ( is_author() ) {
            $userdata = get_userdata(get_query_var( 'author' ));
            $breadcrumbs[] = '<span>'. __( 'Author:', 'exort' ) . ' ' . esc_html( $userdata->display_name ) .'</span>';

        // Day
        } elseif ( is_day() ) {
            $breadcrumbs[] = '<a href="'. get_year_link( get_the_time('Y') ) . '">'. get_the_time('Y') .'</a>';
            $breadcrumbs[] = '<a href="'. get_month_link( get_the_time('Y'), get_the_time('m') ) .'">'. get_the_time('F') .'</a>';
            $breadcrumbs[] = '<span>'. get_the_time('d') .'</span>';

        // Month
        } elseif ( is_month() ) {
            $breadcrumbs[] = '<a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a>';
            $breadcrumbs[] = '<span>'. get_the_time('F') .'</span>';

        // Year
        } elseif ( is_year() ) {
            $breadcrumbs[] = '<span>'. get_the_time('Y') .'</span>';

        // Single
        } elseif ( is_single() && ! is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                if ( get_post_type() == 'portfolio' && ( $portfolio_page_id = exort_get_portfolio_page_ID() ) ) {
                    $link  = get_page_link( $portfolio_page_id );
                    $title = get_the_title( $portfolio_page_id );
                    $breadcrumbs[] = '<a href="'. $link .'">'. $title .'</a>';
                }
                // Single Item
                $breadcrumbs[] = '<span>'. get_the_title().'</span>';

            // Single Post
            } else {
                $breadcrumbs[] = '<span>'. get_the_title() .'</span>';
            }
        } elseif ( get_post_taxonomies() && !is_home() ) {
            // Portfolio
            $post_type = get_post_type_object( get_post_type() );
            if ( $post_type->name == 'portfolio' && ( $portfolio_page_id = exort_get_portfolio_page_ID() ) ) {
                $link  = get_page_link( $portfolio_page_id );
                $title = get_the_title( $portfolio_page_id );
                $breadcrumbs[] = '<a href="'. $link .'">'. $title .'</a>';
            }
            if ( single_cat_title('', false) ) {
                $breadcrumbs[] = '<span>'. single_cat_title('', false) .'</span>';
            }

        // Child Page
        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $parents = array();

            while( $parent_id ) {
                $page = get_page( $parent_id );
                $parents[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $parents = array_reverse( $parents );
            $breadcrumbs = array_merge_recursive($breadcrumbs, $parents);
                
            $breadcrumbs[] = '<span>'. get_the_title() .'</span>';

        // Default
        } elseif ( !is_home() ) {
            $breadcrumbs[] = '<span>'. get_the_title() .'</span>';
        }

        echo '<ul class="breadcrumbs ' . $position . ' ' . $extra_class . '">';
            $count = count( $breadcrumbs );
            $i = 1;

            foreach( $breadcrumbs as $b ) {
                if ( strpos( $b , $separator ) ) {
                    echo '<li>'. $b .'</li>';
                } else {
                    if ( $i == $count ) {
                        if ( get_query_var( 'paged' ) ) {
                            $separator = '<span class="paged">' . '(' . __( 'Page', 'exort' ) . ' ' . get_query_var( 'paged' ) . ')' . '</span>';
                        } else {
                            $separator = '';
                        }
                    }
                    echo '<li>'. $b . $separator .'</li>';
                }
                $i++;
            }
        echo '</ul>';
    }
}

if ( !function_exists( 'exort_get_the_excerpt_max_charlength' ) ) {
    function exort_get_the_excerpt_max_charlength( $charlength ) {
        $excerpt = get_the_excerpt();
        $charlength++;
        $result = '';

        if ( mb_strlen( $excerpt ) > $charlength ) {
            $subex = mb_substr( $excerpt, 0, $charlength - 5 );
            $exwords = explode( ' ', $subex );
            $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
            if ( $excut < 0 ) {
                $result .= mb_substr( $subex, 0, $excut );
            } else {
                $result .= $subex;
            }
            $result .= '...';
        } else {
            $result .= $excerpt;
        }
        return $result;
    }
}

if ( !function_exists( 'exort_display_wpml_languages' ) ) {
    function exort_display_wpml_languages() {
        if( function_exists( 'icl_get_languages' ) ) {
            $languages = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
            if( is_array( $languages ) ){

                foreach ( $languages as $lang_k =>$lang ) {
                    if ( $lang['active'] ) {
                        $active_lang = $lang;
                        unset( $languages[$lang_k] );
                    }
                }

                if ( count( $languages ) ) {
                    echo '<div class="wpml-languages">';
                        echo '<a class="active" href="'. $active_lang['url'] .'" ontouchstart="this.classList.toggle(\'hover\');" onclick="return false;">';
                            echo '<img src="'. $active_lang['country_flag_url'] .'" alt="'. $active_lang['translated_name'] .'"/>';
                            echo esc_html( $active_lang['translated_name'] );
                        echo '</a>';

                        if ( count( $languages ) ) {
                            echo '<ul class="wpml-lang-dropdown">';
                                foreach( $languages as $lang ) {
                                    echo '<li><a href="'. $lang['url'] .'"><img src="'. $lang['country_flag_url'] .'" alt="'. $lang['translated_name'] .'"/>';
                                    echo esc_html( $lang['translated_name'] );
                                    echo '</a></li>';
                                }
                            echo '</ul>';
                        }
                    echo '</div>';
                }
            }
        }
    }
}

if ( !function_exists( 'exort_render_social_links' ) ) {
    function exort_render_social_links( $tag = 'div' ) {
        $site_social_links = array();
        $social_links = exort_get_social_site_names();
        foreach ( $social_links as $key => $name ) {
            $social_profile = exort_get_option( 'social_' . $key . '_url', '' );
            if ( !empty( $social_profile ) ) {
                $site_social_links[$key] = $social_profile;
            }
        }
        if ( !empty( $site_social_links ) ) {
            echo '<' . $tag . ' class="social-icon mrg-top-15 text-center">';
            foreach ( $site_social_links as $key => $profile ) {
                echo '<a class="btn btn-icon border no-border circle text-dark ' . esc_attr( $key ) . '" href="' . esc_url( $profile ) . '" title="' . esc_attr( $key ) . '" target="_blank">';
                echo '<i class="ti-' . esc_attr( $key ) . '"></i>';
                echo '</a>';
            }
            echo '</' . $tag . '>';
        }
    }
}

if ( ! function_exists( 'exort_post_format' ) ) {
    function exort_post_format( $postID ) {
        $format = false;
        $post_type = get_post_type( $postID );
        if ( $post_type == 'portfolio' && is_single( $postID ) ) {
            $media_type = get_post_meta( $postID, '_exort_portfolio_item_media_type', true );
            if ( $media_type == 'video' || $media_type == 'image' ) {
                $format = $media_type;
            } else { // gallery
                $view_style = get_post_meta( $postID, '_exort_portfolio_item_gallery_view_style', true );
                if ( $view_style == 'list' ) {
                    $format = 'image_list';
                } elseif ( $view_style == 'gallery' ) {
                    $format = 'image_gallery';
                } else {
                    $format = 'gallery';
                }
            }

            if ( $format == 'video' ) {
                $video_url = get_post_meta( $postID, '_exort_video_url', true );
                $video_embed_code = get_post_meta( $postID, '_exort_video_embed', true );
                if ( empty( $video_url ) && empty( $video_embed_code ) ) {
                    $format = 'image';
                }
            }
        } elseif ( $post_type == 'portfolio' ) {
            $format = get_post_meta(get_the_ID(), '_exort_portfolio_item_media_type', true);
        } elseif ( $post_type == 'post' ) {
            $format = get_post_format( $postID );
        } else {
            $format = get_post_format( $postID );
        }

        if ( $format == 'gallery' || $format == 'image_gallery' || $format == 'image_list' || !$format ) {
            $gallery = get_post_meta( $postID, '_exort_post_gallery', false );
            if ( empty( $gallery ) ) {
                $format = 'image';
            }
        }
        return $format;
    }
}

if ( !function_exists( 'exort_validate_gravatar' ) ) {
    function exort_validate_gravatar( $email ) {
        // Craft a potential url and test its headers
        $hash = md5(strtolower(trim($email)));
        $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
        $headers = @get_headers($uri);
        if ( !preg_match("|200|", $headers[0]) ) {
            $has_valid_avatar = FALSE;
        } else {
            $has_valid_avatar = TRUE;
        }
        return $has_valid_avatar;
    }
}

/* get avatar function */
if ( ! function_exists('exort_get_avatar') ) {
    function exort_get_avatar( $user_data = array(), $show_default_avatar = true ) {
        $size = empty($user_data['size']) ? 100 : $user_data['size'];
        $photo = '';
        if ( ! empty( $user_data['id'] ) ) {
            $photo_url = get_user_meta( $user_data['id'], 'photo_url', true );
            if ( ! empty( $photo_url ) ) {
                $photo = '<img width="' . $size . '" alt="" src="'. esc_url( $photo_url ) .'">';
            }
        }
        if ( empty( $photo ) ) {
            if ( exort_validate_gravatar( $user_data['email'], $size ) ) {
                $photo = get_avatar( $user_data['email'], $size );
            } elseif ( $show_default_avatar ) {
                $photo = '<img width="' . $size . '" height="' . $size . '" alt="" src="' . EXORT_IMAGE_URL . '/avatar.jpg' . '">';
            } else {
                return false;
            }
        }
        return wp_kses_post( $photo );
    }
}

/* Display share buttons */
if ( !function_exists( 'exort_display_share_buttons' ) ) {
    function exort_display_share_buttons( $wrap_tag = 'span', $wrap_class = '', $item_class = '', $icon_extra_class = '', $hover_title = 'right', $icon_classes = array() ) {
        global $post;
        $buttons = null;
        if ( get_post_type() == 'post' ) {
            $buttons = exort_get_option('blog_post_sharing');
        } elseif ( get_post_type() == 'portfolio' ) {
            $buttons = exort_get_option('portfolio_sharing');
        } elseif ( get_post_type() == 'product' ) {
            $buttons = exort_get_option('product_sharing');
        }
        if ( empty( $buttons ) ) {
            return;
        }

        $protocol = "http";
        if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) $protocol = "https";

        $html = '';
        $social_sites = exort_get_social_site_names();
        $post_title = $post->post_title;
        $post_url = get_permalink();

        if ( empty( $wrap_class ) ) {
            $wrap_class = 'social-icon';
        } else {
            $wrap_class .= ' social-icon';
        }
        $html .= '<' . $wrap_tag . ' class="' . esc_attr( $wrap_class ) . '">';

        if ( !isset( $buttons ) ) {
            $buttons = array();
        }

        foreach ( $social_sites as $button => $desc ) {
            if ( !in_array( $button, $buttons ) ) {
                continue;
            }
            $classes = array();
            $share_title = __( 'share', 'exort' );
            $custom = '';
            $url = '';
            if ( !empty( $icon_classes[$button] ) ) {
                $icon_class = esc_attr( $icon_classes[$button] );
            } else {
                $icon_class = esc_attr( 'ti-' . $button );
            }

            if ( $button == 'twitter' ) {
                $classes[] = 'twitter';
                $share_title = __( 'tweet', 'exort' );
                $url = add_query_arg( array('status' => urlencode($post_title . ' ' . $post_url) ), $protocol . '://twitter.com/home' );
            } elseif ( $button == 'facebook' ) {
                $url_args = array( 's=100', urlencode('p[url]') . '=' . esc_url($post_url), urlencode('p[title]') . '=' . urlencode($post_title) );
                if ( has_post_thumbnail() ) {
                    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    if ( $thumbnail ) {
                        $url_args[] = urlencode('p[images][0]') . '=' . esc_url($thumbnail[0]);
                    }
                }

                // mobile args
                $url_args[] = 't=' . urlencode($post_title);
                $url_args[] = 'u=' . esc_url($post_url);

                $classes[] = 'facebook';

                $url = $protocol . '://www.facebook.com/sharer.php?' . implode( '&', $url_args );
            } elseif ( $button == 'google' ) {
                $icon_class = 'ti-google';
                $post_title = str_replace(' ', '+', $post_title);
                $classes[] = 'google';
                $url = add_query_arg( array('url' => $post_url, 'title' => $post_title), $protocol . '://plus.google.com/share' );
            } elseif ( $button == 'pinterest' ) {
                $url = '//pinterest.com/pin/create/button/';
                $custom = ' data-pin-config="above" data-pin-do="buttonBookmark"';

                if ( wp_attachment_is_image() ) {
                    $image = wp_get_attachment_image_src($post->ID, 'full');

                    if ( !empty($image) ) {
                        $url = add_query_arg( array(
                            'url'           => $post_url,
                            'media'         => $image[0],
                            'description'   => $post_title
                            ), $url
                        );

                        $custom = '';
                    }
                }

                $classes[] = 'pinterest';
                $share_title = __( 'pin it', 'exort' );
            } elseif ( $button == 'linkedin' ) {
                $post_title = str_replace(' ', '+', $post_title);
                $classes[] = 'linkedin';
                $url = add_query_arg( array('mini'=> 'true', 'url' => urlencode($post_url), 'title' => $post_title, 'summary' => '', 'source' => str_replace(' ', '+', get_bloginfo('name'))), $protocol . '://www.linkedin.com/shareArticle' );
            }

            $desc = esc_attr($desc);
            $share_title = esc_attr($share_title);
            $url = esc_url( $url );
            if ( !empty( $item_class ) ) {
                $classes[] = $item_class;
            }
            if ( !empty( $icon_extra_class ) ) {
                $icon_class .= ' ' . esc_attr( $icon_extra_class );
            }

            $share_button = sprintf(
                '<a href="%s" class="btn btn-icon border no-border circle text-gray %s" target="_blank" title="%s"%s data-placement="' . esc_attr( $hover_title ) . '"><i class="%s"></i></a>',
                $url,
                esc_attr( implode(' ', $classes) ),
                $desc,
                $custom,
                $icon_class
            );

            $html .= apply_filters( 'exort_share_button', $share_button, $button, $classes, $url, $desc );
        }

        $html .= '</' . $wrap_tag . '>';
        $html = apply_filters( 'exort_display_share_buttons', $html );

        return $html;
    }
}

/* Displays a page pagination */
if ( !function_exists( 'exort_pagination' ) ) {
    function exort_shop_remove_add_cart_query_arg( $link, $is_shop = false ) {
        if ( $is_shop ) {
            return remove_query_arg( 'add-to-cart', $link );
        } else {
            return $link;
        }
    }
    function exort_pagination( $query = false, $is_shop = false, $pagination_style = false ) {

        global $paged, $wp_query;
        if ( !$query ) {
            $query = $wp_query;
        }

        if ( get_query_var('paged') ) {
            $paged = get_query_var('paged');
        } elseif ( get_query_var('page') ) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        if ( $pagination_style && $pagination_style == 'load_more' ) {
            return get_next_posts_link( '', $query->max_num_pages ) ? '<div class="pager"><a href="' . exort_shop_remove_add_cart_query_arg( get_pagenum_link( $paged + 1 ), $is_shop ) . '" class="button button-md style-border color-gray load-more"><span>' . __( 'Load More', 'exort' ) . '</span></a></div>' : '';
        }
        $output = "";
        $prev = $paged - 1;
        $next = $paged + 1;
        $range = 2;
        $showitems = ($range * 2) + 1;

        $total_pages = $query->max_num_pages;
        if ( !$total_pages ) {
            $total_pages = 1;
        }

        if ( 1 != $total_pages ) {
            $output .= '<div class="text-center"><ul class="pagination">';
            if ( $paged > 1 ) {
                $output .= '<li><a href="' . exort_shop_remove_add_cart_query_arg( get_pagenum_link($prev), $is_shop ) . '" class="nav-prev" data-pagenum="' . $prev . '"><i class="ti-arrow-left pdd-right-10 font-size-10"></i> ' . __('Prev', 'exort') . '</a></li>';
            }

            for ( $i = 1; $i <= $total_pages; $i++ ) {
                if ( 1 != $total_pages && ( ($i < $paged+$range+1 && $i > $paged-$range-1) || $total_pages <= $showitems ) ) {
                    if ( $paged == $i ) {
                        $output .= '<li class="active"><a href="#">' . $i .'</a></li>';
                    } else {
                        $output .= '<li><a href="' . exort_shop_remove_add_cart_query_arg( get_pagenum_link($i), $is_shop ) . '" class="page" data-pagenum="' . $i . '">' . $i . '</a></li>';
                    }
                }
            }

            if ( $paged < $total_pages ) {
                $output .= '<li><a href="'.exort_shop_remove_add_cart_query_arg( get_pagenum_link($next), $is_shop ) . '" class="nav-next" data-pagenum="' . $next . '">' . __('Next', 'exort') . ' <i class="ti-arrow-right pdd-left-10 font-size-10"></i></a></li>';
            }
            $output .= '</ul></div>';
        }

        return $output;
    }
}

if ( !function_exists( 'exort_get_post_video' ) ) {
    function exort_get_post_video( $video_url, $embed_code, $video_ratio = '16:9' ) {
        if ( empty( $video_url ) && empty( $embed_code ) ) {
            return false;
        }
        $output = '';
        if ( !empty( $video_url ) ) {
            $poster = "";
            if ( has_post_thumbnail() ) {
                $poster = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                $poster = ' poster="' . esc_url( $poster[0] ) . '"';
            }
            $output .= '<div class="video-container style-colored">';
            $output .= '<video preload="metadata" data-video-ratio="' . esc_attr( $video_ratio ) . '"' . $poster . '>';
            $output .= '<source src="' . esc_url( $video_url ) . '" type="video/mp4" />';
            $output .= '</video>';
            $output .= '</div>';
        } else {
            $output .= '<div class="video-container style-colored">';
            $output .= stripslashes( htmlspecialchars_decode( esc_html( $embed_code ) ) );
            $output .= '</div>';
        }
        return $output;
    }
}

if ( !function_exists( 'exort_get_post_audio' ) ) {
    function exort_get_post_audio( $audio_url, $embed_code, $class = '' ) {
        if ( empty( $audio_url ) && empty( $audio_code ) ) {
            return false;
        }
        $output = '';
        $classes = array( 'audio-container' );
        if ( $class ) {
            $classes[] = $class;
        }
        $output .= '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
        if ( !empty( $audio_url ) ) {
            $output .= '<audio src="' . esc_attr( $audio_url ) . '" data-mejsoptions=\'{"audioHeight": 40}\'></audio>';
        } else {
            $output .= stripslashes( htmlspecialchars_decode( esc_html( $embed_code ) ) );
        }
        $output .= '</div>';
        return $output;
    }
}

if ( !function_exists( 'exort_get_product_category_list' ) ) {
    function exort_get_product_category_list() {
        $output = '';

        $taxonomy     = 'product_cat';
        $orderby      = 'name';
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no
        $title        = '';
        $empty        = 0;

        $args = array(
            'taxonomy'     => $taxonomy,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $empty
        );
        $all_categories = get_categories( $args );
        foreach ($all_categories as $cat) {
            if ($cat->category_parent == 0) {
                $sub_output = exort_get_product_subcategory_list($args, $cat->term_id);
                if ($sub_output != '') {
                    $output .= '<li class="dropdown first-level"><a href="#">' . $cat->name . '</a>' . $sub_output;
                } else {
                    $output .= '<li><a href="' . get_term_link($cat->slug, 'product_cat') . '">' . $cat->name . '</a>';
                }
                $output .= '</li>';
            }
        }
        return $output;
    }

    function exort_get_product_subcategory_list($args, $parent_id) {
        $output = '';

        $args['child_of'] = 0;
        $args['parent'] = $parent_id;
        $sub_cats = get_categories( $args );
        if($sub_cats) {
            $output .= '<ul class="side-sub-menu">';
            foreach($sub_cats as $sub_category) {
                $sub_output = exort_get_product_subcategory_list($args, $sub_category->term_id);
                if ($sub_output != '') {
                    $output .= '<li class="dropdown second-level"><a href="#">' . $sub_category->name . '</a>' . $sub_output;
                } else {
                    $output .= '<li><a href="' . get_term_link($sub_category->slug, 'product_cat') . '">' . $sub_category->name . '</a>';
                }
                $output .= '</li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }
}

if ( !function_exists( 'exort_get_product_category' ) ) {
    function exort_get_product_category( $cat_ID ) {
        if ( empty( $cat_ID ) ) {
            return false;
        }
        $category = get_term( $cat_ID, 'product_cat' );
        $term_id = $category->term_id;
        $cat_img_id = get_term_meta($term_id, 'thumbnail_id');
        $cat_img_url = wp_get_attachment_image_url($cat_img_id[0], 'full');
        $cat_url = get_category_link( $cat_ID );

        $output = '<a href="%s" class="banner-categories">%s%s</a>';
        $img_tag = "";
        if ($cat_img_url)
            $img_tag = sprintf('<img class="img-responsive" src="%s" alt="">', $cat_img_url);
        $overlay = sprintf('<div class="overlay"><div class="overlay-content"><h3 class="no-margin-btm"><b>%s</b></h3><p class="droid-serif-italic">' . __('View product', 'exort') . ' <i class="ti-arrow-right font-size-10 pdd-left-10"></i></p></div></div>', $category->name);
        $output = sprintf($output, $cat_url, $img_tag, $overlay);

        return $output;
    }
}

if ( !function_exists( 'exort_get_product_thumb' ) ) {
    function exort_get_product_thumb( $product_ID ) {
        if ( empty( $product_ID ) ) {
            return false;
        }

        global $product;

        $product = wc_get_product($product_ID);
        $img_id = $product->get_image_id();
        $img_url = wp_get_attachment_image_url($img_id, 'full');
        $product_url = get_permalink($product_ID);
        $product_name = $product->post->post_title;
        $currency_symbol = get_woocommerce_currency_symbol();
        $price = get_post_meta( $product_ID, '_regular_price', true);
        $price = number_format((float)$price, 2, '.', '');
        $sale = get_post_meta( $product_ID, '_sale_price', true);
        $sale = number_format((float)$sale, 2, '.', '');
        $add_to_cart_url = $product->add_to_cart_url();
        if (function_exists('YITH_WCWL')) {
            $add_to_wishlist_url = YITH_WCWL()->get_addtowishlist_url();
        }

        $output = '<div class="product-thumb">%s%s</div>';
        $img_tag = "";
        if ($img_url)
            $img_tag = sprintf('<div class="product-img"><a href="%s"><img class="img-responsive" src="%s" alt=""></a></div>', $product_url, $img_url);
        $info_tag = '<div class="product-info">%s%s%s</div>';
        $name_tag = sprintf('<div class="product-name"><a href="%s"><span>%s</span></a></div>', $product_url, $product_name);
        $price_tag = sprintf('<div class="product-price"><span class="old-price">%s%s</span> <span>%s%s</span></div>', $currency_symbol, $price, $currency_symbol, $sale);
        $action_tag = sprintf('<div class="action"><a href="%s" class="btn btn-style-2"><i class="ti-shopping-cart"></i></a><a href="%s" class="btn btn-style-2"><i class="ti-heart"></i></a><a href="%s" class="btn btn-style-2"><i class="ti-zoom-in"></i></a><div class="clearfix"></div></div>', $add_to_cart_url, $add_to_wishlist_url, $product_url);
        $info_tag = sprintf($info_tag, $name_tag, $price_tag, $action_tag);
        $output = sprintf($output, $img_tag, $info_tag);

        return $output;
    }
}

if ( !function_exists( 'exort_post_thumbnail' ) ) {
    function exort_post_thumbnail( $postID, $type = false, $style = false, $post_index = 0, $columns = 1 ) {
        $output = '';
        $post_format = exort_post_format( $postID );
        $popup = true;
        $hover_style = '';
        if ($style) {
            $hover_style = 'hover-style3';
        }
        $image_size = 'full';

        $image_size = apply_filters( 'exort_custom_post_thumbnail', $image_size, $postID, $type, $style, $post_index, $columns );
        $popup = apply_filters( 'exort_custom_post_thumbnail_popup', $popup, $postID, $type, $style, $post_index, $columns );

        $full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'full' );
        $popup_url = $full_image_url[0];

        if ( $post_format == 'gallery' || $post_format == 'image_gallery' || $post_format == 'image_list' ) {
            $gallery_ids = get_post_meta( $postID, '_exort_post_gallery', false );
            if ( empty( $gallery_ids ) ) {
                $post_format = 'image';
            }
        }

        if ( $post_format == 'quote' && ( (int)$columns === 1 || $style == 'basic' ) && has_post_thumbnail() ) {
            $post_format = 'image';
        }
        switch ( $post_format ) {
            case 'quote':
                break;
            case 'audio':
                if ( has_post_thumbnail() ) {
                    if ( $popup ) {
                        $output .= '<a href="'. $popup_url .'" class="image st-mfp-popup '. $hover_style .' hover-layout1">';
                    }
                    $output .= get_the_post_thumbnail( $postID, $image_size, array( 'class'=>'', 'itemprop'=>'image' ) );
                    if ( $popup ) {
                        $output .= '<div class="image-extras"></div></a>';
                    }
                    $extra_class = '';
                } else {
                    $extra_class = 'style-colored';
                }

                $audio_url = esc_url( get_post_meta( $postID, '_exort_audio_mp3', true ) );
                $audio_embed_code = esc_html( get_post_meta( $postID, '_exort_audio_embed', true ) );

                if ( empty( $audio_url ) && !is_single() ) {
                    $media = get_attached_media( 'audio', $postID );
                    if ( !empty( $media ) ) {
                        $media = reset( $media );
                        if ( isset( $media->ID ) ) $audio_url = wp_get_attachment_url( $media->ID );
                    }
                }
                $output .= exort_get_post_audio( $audio_url, $audio_embed_code, $extra_class );
                break;
            case 'video':
                $video_url = get_post_meta( $postID, '_exort_video_url', true );
                $video_embed_code = get_post_meta( $postID, '_exort_video_embed', true );
                $video_ratio = get_post_meta( $postID, '_exort_video_ratio', true );
                $output .= exort_get_post_video( $video_url, $video_embed_code, $video_ratio );
                break;
            case 'gallery':
                $output .= '<div class="col-sm-12 mrg-top-30 mrg-btm-50"><div class="owl-single-pag owl-pagi-1 pagi-center pagi-overlay">';
                foreach ( $gallery_ids as $aID ) {
                    $output .= '<div class="item"><img class="img-responsive width-100" alt="" src="' . wp_get_attachment_image_url( $aID, 'full' ) . '"></div>';
                }
                $output .= '</div></div>';
                break;
            case 'image_gallery':
                $output .= '<div class="col-sm-12 mrg-top-30 mrg-btm-50"><div class="owl-single-pag owl-pagi-1 pagi-center pagi-overlay">';
                foreach ( $gallery_ids as $aID ) {
                    $output .= '<div class="item"><img class="img-responsive width-100" alt="" src="' . wp_get_attachment_image_url( $aID, 'full' ) . '"></div>';
                }
                $output .= '</div></div>';
                break;
            case 'image_list':
                foreach ( $gallery_ids as $aID ) {
                    $output .= '<img class="img-responsive width-100 mrg-btm-30" alt="" src="' . wp_get_attachment_image_url( $aID, 'full' ) . '">';
                }
                break;
            default:
                if ( exort_has_post_thumbnail() ) {
                    if ( $popup ) {
                        $popup_class = ' hover-layout1';
                        if ( $style == 'widget' ) {
                            $popup_class = ' hover-layout2';
                        }
                        $output .= '<a href="'. $popup_url .'" class="image st-mfp-popup '. $hover_style . $popup_class . '">';
                    }
                    $output .= exort_get_the_post_thumbnail( $postID, $image_size, array( 'class'=>'', 'itemprop'=>'image' ) );
                    if ( $popup ) {
                        $output .= '<div class="image-extras"></div></a>';
                    }
                }
        }

        return $output;
    }
}

if ( !function_exists( 'exort_get_post_meta' ) ) {
    function exort_get_post_meta( $layout = 'masonry', $show_comment = false ) {
        global $post;
        $output = '';

        $date_format = exort_get_option( 'blog_post_meta_date_format', false );
        if ( $date_format ) {
            $post_date = get_the_date( $date_format );
        } else {
            $post_date = get_the_date();
        }

        $output .= '<span class="vcard author post-author">';
        if ( $layout == 'list' ) {
            $output .= __( 'Posted by', 'exort' );
        } else {
            $output .= __( 'By', 'exort' );
        }
        $output .= ' <span class="fn"><a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">'. get_the_author_meta( 'display_name' ) .'</a></span></span>';
        $output .= ' <span class="date">';
        $post_title = get_the_title();
        if ( !is_single() && empty( $post_title ) ) {
            $output .= '<a href="'. esc_url( get_permalink() ) .'">';
        }
        $post_meta_date = '<time class="entry-date" datetime="'. get_the_date('c') .'" itemprop="datePublished" pubdate>'. $post_date .'</time>';
        if ( $layout == 'masonry' ) {
            $output .= '<span class="date-text-on">'. sprintf( __( 'on %s', 'exort' ), '</span>'. $post_meta_date );
        } else {
            $output .= $post_meta_date;
        }
        if ( !is_single() && empty( $post_title ) ) {
            $output .= '</a>';
        }
        $output .= '</span>';

        if ( comments_open() && $show_comment ) {
            $output .= ' <span class="post-comment"><a href="' . get_permalink() . '#comments">';
            $comment_number = get_comments_number( $post->ID );
            if ( $comment_number == 0 ) {
                $output .= __( 'No Comments', 'exort' );
            } elseif ( $comment_number == 1 ) {
                $output .= __( '1 Comment', 'exort' );
            } else {
                $output .= esc_html( $comment_number . ' ' );
                $output .= __( 'Comments', 'exort' );
            }
            $output .= '</a></span>';
        }

        return $output;
    }
}

if ( !function_exists( 'exort_has_post_thumbnail') ) {
    function exort_has_post_thumbnail() {
        $post_format = get_post_format();
        if ( $post_format == 'video' ) {
            $video_url = esc_url( get_post_meta( get_the_ID(), '_exort_video_url', true ) );
            $video_embed_code = esc_html( get_post_meta( get_the_ID(), '_exort_video_embed', true ) );
            if ( !empty( $video_url ) || !empty( $video_embed_code ) || has_post_thumbnail() ) {
                return true;
            }
        } elseif ( $post_format == 'gallery' ) {
            $gallery = get_post_meta( get_the_ID(), '_exort_post_gallery', false );
            if ( !empty( $gallery ) ) {
                return true;
            }
        } else {
            return has_post_thumbnail();
        }
        return false;
    }
}

if ( !function_exists( 'exort_get_content_post' ) ) {
    function exort_get_content_post( $query = false, $layout = 'masonry', $columns = 3, $pagination_style = false, $extra_class = '' ) {
        global $wp_query;
        $output = '';
        $columns = (int)$columns;

        $wrap_class = array( 'blog-post', $layout );
        if ( !$query ) $query = $wp_query;

        if ($layout == 'grid' || $layout == 'masonry') {
            if ($columns == 2) {
                $post_wrap = '<div class="col-sm-6"><div class="blog-wrapper">%s</div></div>';
            } else {
                $post_wrap = '<div class="col-sm-6 col-md-' . (12 / $columns) . '"><div class="blog-wrapper">%s</div></div>';
            }
        } elseif ($layout == 'classic') {
            $post_wrap = '<div class="blog-wrapper">%s</div>';
        }

        if ( $extra_class ) {
            $wrap_class[] = $extra_class;
        }

        if ( $query->have_posts() ) {
            $post_index = 0;
            $output .= '<div class="'. esc_attr( implode( ' ', $wrap_class ) ) .'">';
            while ( $query->have_posts() ) {
                $query->the_post();
                $id = get_the_ID();
                $post_format = get_post_format();
                $post_html = '';
                if (!$post_format || $post_format == 'image') {
                    $post_html .= '<div class="blog-img">';
                    $img_url = wp_get_attachment_image_url(get_post_thumbnail_id($id), 'full');
                    if ($img_url)
                        $post_html .= '<img class="img-responsive" alt="" src="' . $img_url . '">';
                    $post_html .= '<div class="post-date"><p class="no-margin">' . get_the_date("M") . '<br class="hide-mobile"><span>' . get_the_date("d") . '</span></p></div>';
                    $post_html .= '</div>';
                } elseif ($post_format == 'gallery') {
                    $gallery_ids = get_post_meta( $id, '_exort_post_gallery', false );
                    if ( empty( $gallery_ids ) ) {
                    }
                    $post_html .= '<div class="blog-slider">';
                    if ( class_exists( 'ExortShortcodes' ) ) $code = '[slider nav_style="" pagi="" class="blog-post-slide"]';
                    foreach ( $gallery_ids as $aID ) {
                        if ( !class_exists( 'ExortShortcodes' ) ) {
                            $img_url = wp_get_attachment_image_url($aID, 'full');
                            if ($img_url)
                                $post_html .= '<img class="img-responsive" alt="" src="' . $img_url . '">';
                        } else {
                            $code .= '[slider_item img_id="' . $aID . '"]';
                        }
                    }
                    if ( class_exists( 'ExortShortcodes' ) ) {
                        $code .= '[/slider]';
                        $post_html .= do_shortcode($code);
                    }
                    $post_html .= '<div class="post-date"><p class="no-margin">' . get_the_date("M") . '<br class="hide-mobile"><span>' . get_the_date("d") . '</span></p></div>';
                    $post_html .= '</div>';
                } elseif ($post_format == 'audio') {
                    $post_html .= '<div class="blog-aud">';
                    $val = get_post_meta( $id, '_exort_audio_embed', false );
                    if (is_array($val)) {
                        $post_html .= $val[0];
                    } else {
                        $post_html .= $val;
                    }
                    $post_html .= '<div class="post-date"><p class="no-margin">' . get_the_date("M") . '<br class="hide-mobile"><span>' . get_the_date("d") . '</span></p></div>';
                    $post_html .= '</div>';
                } elseif ($post_format == 'video') {
                    $post_html .= '<div class="blog-vid">';
                    $val = get_post_meta( $id, '_exort_video_embed', false );
                    if (is_array($val)) {
                        $post_html .= $val[0];
                    } else {
                        $post_html .= $val;
                    }
                    $post_html .= '<div class="post-date"><p class="no-margin">' . get_the_date("M") . '<br class="hide-mobile"><span>' . get_the_date("d") . '</span></p></div>';
                    $post_html .= '</div>';
                }
                $post_html .= '<div class="post-content">';
                $post_html .= '<div class="post-meta"><p>' . __('By', 'exort') . ' ';
                $post_html .= '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a>';
                $post_html .= '<span class="pdd-horizon-5">/</span><i class="ti-tag pdd-right-5"></i>';
                $posttags = get_the_tags();
                $first = true;
                if ( $posttags ) {
                    foreach( $posttags as $tag ) {
                        if (!$first) {
                            $post_html .= ', ';
                        } else {
                            $first = false;
                        }
                        $post_html .= '<a href="'. get_tag_link($tag->term_id) .'">';
                        $post_html .= esc_html( $tag->name );
                        $post_html .= '</a>';
                    }
                }
                if (comments_open()) {
                    $post_html .= '<span class="pdd-horizon-5">/</span>';
                    $comment_number = get_comments_number();
                    $cmt = '';
                    if ( $comment_number == 0 ) {
                        $cmt = __( 'No Comments', 'exort' );
                    } elseif ( $comment_number == 1 ) {
                        $cmt = __( '1 Comment', 'exort' );
                    } else {
                        $cmt = esc_html( $comment_number . ' ' ) . __( 'Comments', 'exort' );
                    }
                    $post_html .= '<a href="' . get_comments_link() . '"><i class="ti-comment pdd-right-5"></i>' . $cmt . '</a>';
                }
                $post_html .= '</p></div>';
                $post_html .= '<h3 class="post-title"><a href="' . get_permalink($id) . '">' . get_the_title() . '</a></h3>';
                $post_html .= '<p class="post-inner-content mrg-vertical-15">' . get_the_excerpt() .'</p>';
                $post_html .= '<div class="post-bottom"><span class="read-more"><a class="btn no-padding" href="' . get_permalink($id) . '">' . __('Read More', 'exort') . '<i class="ti-arrow-right"></i></a></span></div>';
                $post_html .= '</div>';
                $output .= sprintf( $post_wrap, $post_html );
                $post_index++;
            }
            $output .= '</div>';
            if ( $pagination_style ) {
                $output .= exort_pagination( $query, false, $pagination_style );
            }
            wp_reset_postdata();
        }
        return $output;
    }
}

if ( !function_exists( 'exort_get_the_post_thumbnail' ) ) {
    function exort_get_the_post_thumbnail( $postId, $image_size = 'full', $attrs = array() ) {
        if ( has_post_thumbnail( $postId ) ) {
            return get_the_post_thumbnail( $postId, $image_size, $attrs );
        }
        if ( get_post_format( $postId ) == 'gallery' ) {
            $gallery = get_post_meta( $postId, '_exort_post_gallery', false );
            if ( !empty( $gallery ) ) {
                return wp_get_attachment_image( $gallery[0], $image_size, false, $attrs );
            }
        }
        return false;
    }
}

if ( !function_exists( 'exort_next_prev_links' ) ) {
    function exort_next_prev_links() {
        $wrap = '<section class="pdd-vertical-30"><div class="container-fluid"><div class="col-xs-4">%s</div><div class="col-xs-4">%s</div><div class="col-xs-4">%s</div></div></section>';

        $in_same_term = ( exort_get_option( 'blog_prev_next_nav', 'show' ) == 'same_category' ) ? true : false;
        $prev_post = get_adjacent_post( $in_same_term, '', true );
        $prev_link = '';
        if ( !empty( $prev_post ) ) {
            $prev_link = sprintf('<a href="%s" class="text-left"><h5 class="mrg-top-15"><i class="ti-arrow-left pdd-right-10 font-size-10"></i> %s</h5></a>',
                esc_url( get_permalink( $prev_post ) ), __('Previous', 'exort'));
        }

        $blog_link = sprintf('<a href="%s" class="text-center"><h2 class="mrg-vertical-10"><i class="ti-view-grid pdd-right-5"></i></h2></a>', get_permalink( get_option( 'page_for_posts' ) ));

        $next_post = get_adjacent_post( $in_same_term, '', false );
        $next_link = '';
        if ( !empty( $next_post ) ) {
            $next_link = sprintf('<a href="%s" class="text-right"><h5 class="mrg-top-15">%s <i class="ti-arrow-right pdd-left-10 font-size-10"></i></h5></a>',
                esc_url( get_permalink( $next_post ) ), __('Next', 'exort'));
        }
        printf( $wrap, $prev_link, $blog_link, $next_link );
    }
}

if ( !function_exists( 'exort_display_post_tags' ) ) {
    function exort_display_post_tags() {
        $posttags = get_the_tags();
        if ( $posttags ) {
            echo '<div class="tags">';
            foreach( $posttags as $tag ) {
                echo '<a href="'. get_tag_link($tag->term_id) .'" class="tag">';
                echo esc_html( $tag->name ); 
                echo '</a>';
            }
            echo '</div>';
        }
    }
}

if ( !function_exists( 'exort_display_post_author' ) ) {
    function exort_display_post_author( $extra_class = '' ) {
        global $post;

        $desc = get_the_author_meta('description');
        if (!$desc)
            return;

        $class = 'about-author';
        if ( !empty( $extra_class ) ) {
            $class .= ' ' . esc_attr( $extra_class );
        }
        $author_name = get_the_author_meta( 'display_name', $post->post_author );
        $author_email = get_the_author_meta( 'user_email', $post->post_author );

        echo '<div class="' . $class . '">';
        
        $avatar = exort_get_avatar( array( 'id' => $post->post_author, 'email' => $author_email, 'size' => '100' ) );
        if ( $avatar ) {
            echo wp_kses_post( $avatar );
        }

        echo '<div class="author-info">';
        echo '<h3>' . esc_html( $author_name ) . '</h3>';
        echo '<p>' . $desc . '</p>';
        echo '</div>';
        echo '</div>';
    }
}

if ( !function_exists( 'exort_display_related_posts' ) ) {
    function exort_display_related_posts( $style = 'style1' ) {
        global $post;

        $args = '';
        $args = wp_parse_args($args, array(
            'post__not_in' => array($post->ID),
            'ignore_sticky_posts' => 0,
            'category__in' => wp_get_post_categories($post->ID),
            'posts_per_page' => intval( exort_get_option( 'blog_rel_posts_max', '6' ) )
        ));
        $query = new WP_Query($args);
        if ( $query->have_posts() ) {
            echo '<h3>' . __( 'Related Posts', 'exort' ) . '</h3>';
            echo '<div class="related-posts row same-height '. esc_attr( $style ) .'">';
            while($query->have_posts()): $query->the_post();
            ?>
                <div class="related-post col-sm-6 col-md-4">
                    <article>
                      <?php  if ( has_post_thumbnail() ) : ?>
                        <div class="post-image">
                            <div class="img">
                                <?php
                                    if ( $style == 'style1' ) {
                                        the_post_thumbnail( 'thumbnail' );
                                    } else {
                                        $full_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                                        echo '<a href="'. esc_url( $full_url[0] ) .'" class="image st-mfp-popup">';
                                            the_post_thumbnail( 'exort-gallery-sm' );
                                            echo '<div class="image-extras"></div>';
                                        echo '</a>';
                                    }
                                ?>
                            </div>
                        </div>
                      <?php endif; ?>
                        <div class="details">
                            <h4 class="post-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4>
                            <div class="post-meta">
                                <?php echo exort_get_post_meta( 'basic' ); ?>
                            </div>
                        </div>
                    </article>
                </div>
            <?php
            endwhile;
            echo '</div>';
        }
        wp_reset_postdata();
    }
}

/**
 * comment template
 */
if ( ! function_exists( 'exort_display_comment' ) ) {
    function exort_display_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment; ?>
        <li id="comment-<?php comment_ID() ?>">
            <div class="comment">
                <div class="avatar">
                    <?php echo exort_get_avatar( array( 'id' => $comment->user_id, 'email' => $comment->comment_author_email, 'size' => 60 ) ); ?>
                </div>
                <div class="comment-info">
                    <h4 class="name"><?php echo get_comment_author_link() ?></h4>
                    <span class="time"><?php comment_date(); ?></span>
                </div>
                <div class="content"><?php comment_text(); ?></div>
                <div class="reply">
                <?php $comment_reply_link = get_comment_reply_link(array_merge( $args, array('reply_text' => __('REPLY', 'exort'), 'depth' => $depth )));
                    echo exort_esc_post( $comment_reply_link );
                ?>
                </div>
            </div>
        </li>
    <?php }
}

if ( !function_exists( 'exort_portfolio_thumbnail' ) ) {
    function exort_portfolio_thumbnail( $postID, $style, $image_size = false, $columns = 1, $is_full = false ) {
        $image_size = 'full';
        //if ($style == 'flat') $image_size = 'exort_portfolio_flat';
        $image_size = apply_filters( 'exort_custom_portfolio_list_page_thumbnail', $image_size, $postID, $style, $columns, $is_full );
        $post_image = get_the_post_thumbnail( $postID , $image_size );
        if ( !empty( $post_image ) ) {
            return $post_image;
        }
        $media_type = get_post_meta( $postID, '_exort_portfolio_item_media_type', true );
        if ( $media_type == 'gallery' ) {
            $gallery = get_post_meta( $postID, '_exort_post_gallery', false );
            if ( !empty( $gallery ) ) {
                return wp_get_attachment_image( $gallery[0], $image_size );
            }
        } elseif ( $media_type == 'video' ) {
            $result = '';
            $video_url = esc_url( get_post_meta( $postID, '_exort_video_url', true ) );
            $video_embed_code = esc_html( get_post_meta( $postID, '_exort_video_embed', true ) );
            $video_ratio = esc_attr( get_post_meta( $postID, '_exort_video_ratio', true ) );
            $result .= '<div class="video-container">';
            $result .= exort_get_post_video( $video_url, $video_embed_code, $video_ratio );
            $result .= '</div>';
            return $result;
        }
        return false;
    }
}

if ( !function_exists( 'exort_get_portfolio_thumbnail_link' ) ) {
    function exort_get_portfolio_thumbnail_link( $postID ) {
        if ( has_post_thumbnail( $postID ) ) {
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'full' );
            return $post_image[0];
        }
        $media_type = get_post_meta( $postID, '_exort_portfolio_item_media_type', true );
        if ( $media_type == 'gallery' ) {
            $gallery = get_post_meta( $postID, '_exort_post_gallery', false );
            if ( !empty( $gallery ) ) {
                $post_image = wp_get_attachment_image_src( $gallery[0], 'full' );
                return $post_image[0];
            }
        }
        return false;
    }
}

if ( !function_exists( 'exort_get_content_portfolio' ) ) {
    function exort_get_content_portfolio( $query = false, $style = 'flat', $hover_style = '1', $columns = 2, $is_full = false ) {
        global $wp_query;

        $output = '';
        if ( !$query ) $query = $wp_query;
        if ( $query->have_posts() ) {
            while ($query->have_posts()) {
                $query->the_post();

                $categories = array();
                $cate_slugs = array();
                if ($hover_style == '1' || $hover_style == '3' || $hover_style == '4') {
                    $terms = get_the_terms(get_the_ID(), 'portfolio_category');
                    if (is_array($terms)) {
                        foreach ($terms as $term) {
                            $categories[] = $term->name;
                            $cate_slugs[] = $term->slug;
                        }
                    }
                }

                $output .= '<div class="folio-item ' . esc_attr(implode(' ', $cate_slugs)) . '">';
                $output .= '<div class="folio-style-' . $hover_style . '">';
                $output .= '<div class="folio-image">' . exort_portfolio_thumbnail(get_the_ID(), $style, false, $columns, ($style == "flat") ? "medium" : $is_full) . '</div>';
                if ($hover_style == '2') {
                    $output .= '<div class="overlay"><div class="overlay-caption"><div class="overlay-content">';
                } else {
                    $output .= '<div class="overlay"><a href="' . get_permalink( get_the_ID() ) . '"><div class="overlay-caption"><div class="overlay-content">';
                }
                $output .= '<div class="folio-info">';
                if ($hover_style == '1') {
                    $output .= '<h3 class="text-white">' . get_the_title() . '</h3>';
                } elseif ($hover_style == '2' || $hover_style == '3' || $hover_style == '4') {
                    $output .= '<h4 class="folio-title">' . get_the_title() . '</h4>';
                }
                if ($hover_style == '1' || $hover_style == '3' || $hover_style == '4') {
                    $output .= '<p class="droid-serif-italic">' . esc_attr(implode(',', $categories)) . '</p>';
                }
                $output .= '</div>'; //folio-info
                if ($hover_style == '1') {
                    $output .= '<div class="folio-links">';
                    $output .= '<a href="' . get_permalink( get_the_ID() ) . '" class="" title="' . get_the_title() . '"><i class="ti-search"></i></a>';
                    $output .= '<a href="' . get_post_meta( get_the_ID(), '_exort_portfolio_item_project_link', true ) . '"><i class="ti-link"></i></a>';
                    $output .= '</div>';
                } elseif ($hover_style == '2') {
                    $output .= '<div class="folio-links">';
                    $output .= '<a href="' . get_post_meta( get_the_ID(), '_exort_portfolio_item_project_link', true ) . '"><i class="ti-eye"></i></a>';
                    $output .= '<a href="' . get_permalink( get_the_ID() ) . '"><i class="ti-fullscreen"></i></a>';
                    $output .= '</div>';
                }
                if ($hover_style == '2') {
                    $output .= '</div></div></div>';
                } else {
                    $output .= '</div></div></a></div>';
                }
                $output .= '</div>';
                $output .= '</div>';
            }
            wp_reset_postdata();
        }
        return $output;
    }
}

if ( !function_exists( 'exort_display_portfolio_meta' ) ) {
    function exort_display_portfolio_meta( $wrap_tag = false, $wrap_class = false, $show_meta = true ) {
        do_action( 'exort_before_portfolio_meta' );

        if ( $show_meta ) {
            $categories_list = get_the_term_list( get_the_ID(), 'portfolio_category', '', ', ' );
            if ( $categories_list && !is_wp_error($categories_list) ) {
                $categories_list = str_replace( array( 'rel="tag"', 'rel="category tag"' ), '', $categories_list);
                $categories_list = trim($categories_list);
            }

            if ( $wrap_tag ) {
                echo '<' . $wrap_tag . ' class="' . esc_attr( $wrap_class ) . '"><div class="meta-item">';
            }
            echo '<h5>'. __( 'Author', 'exort' ) .'</h5>';
            echo '<p>'. sprintf( __( 'By %s', 'exort' ), sprintf( '<a href="%s" class="author vcard" title="%s" rel="author">%s</a>',
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        sprintf( esc_attr__( 'View all posts by %s', 'exort' ), get_the_author() ),
                        '<span class="fn">' . get_the_author() .'</span>'
                ) ) . '</p>';
            
            if ( $wrap_tag ) {
                echo '</div></'. $wrap_tag .'>';
                echo '<' . $wrap_tag . ' class="' . esc_attr( $wrap_class ) . '"><div class="meta-item">';
            }
            echo '<h5>'. __( 'Date', 'exort' ) .'</h5>';
            $exort_portfolio_single_date_format = exort_get_option( 'portfolio_date_format', 'j F Y' );
            echo '<p><span class="date"><time class="entry-date" datetime="'. get_the_date('c') .'" itemprop="datePublished" pubdate>' . get_the_date( $exort_portfolio_single_date_format ) . '</time></span></p>';

            if ( $wrap_tag ) {
                echo '</div></'. $wrap_tag .'>';
                echo '<' . $wrap_tag . ' class="' . esc_attr( $wrap_class ) . '"><div class="meta-item">';
            }
            echo '<h5>' . esc_html(__( 'Category', 'exort' )) . '</h5>';
            echo '<p>' . $categories_list . '</p>';

            if ( $wrap_tag ) {
                echo '</div></'. $wrap_tag .'>';
            }
        }

        if ( $client = get_post_meta( get_the_ID(), '_exort_portfolio_item_client', true ) ) {
            if ( $wrap_tag ) {
                echo '<' . $wrap_tag . ' class="' . esc_attr( $wrap_class ) . '"><div class="meta-item">';
            }
            echo '<h5>'. __( 'Client', 'exort' ) .'</h5>';
            echo '<p>'. esc_html( $client ) .'</p>';
            if ( $wrap_tag ) {
                echo '</div></'. $wrap_tag .'>';
            }
        }
        if ( $task = get_post_meta( get_the_ID(), '_exort_portfolio_item_task', true ) ) {
            if ( $wrap_tag ) {
                echo '<' . $wrap_tag . ' class="' . esc_attr( $wrap_class ) . '"><div class="meta-item">';
            }
            echo '<h5>'. __( 'Task', 'exort' ) .'</h5>';
            echo '<p>'. esc_html( $task ) .'</p>';
            if ( $wrap_tag ) {
                echo '</div></'. $wrap_tag .'>';
            }
        }

        do_action( 'exort_after_portfolio_meta' );
    }
}

if ( !function_exists( 'exort_check_show_subheader' ) ) {
    function exort_check_show_subheader() {
        $hide_subheader = false;
        if ( $page_id = exort_get_the_ID() ) {
            $hide_subheader = get_post_meta( $page_id, '_exort_page_settings_subheader_hide', true );
        }
        return ( !$hide_subheader );
    }
}

if ( !function_exists( 'exort_subheader_attrs' ) ) {
    function exort_subheader_attrs() {
        $show_subheader = exort_check_show_subheader();
        if ( $show_subheader ) {
            $id = exort_get_the_ID();
            $extra_class = '';
            $subheader_attrs = '';

            $subheader_background_image = exort_get_option( 'subheader_background' );
            if ($page_subheader_background_image = get_post_meta( $id, '_exort_page_settings_subheader_background_image', true)) {
                $subheader_background_image = $page_subheader_background_image;
                if ($subheader_background_image) {
                    $attachment = wp_get_attachment_image_src($subheader_background_image, 'full');
                    if (isset($attachment)) {
                        $img_src = $attachment[0];
                        $img_alt = '';
                        $img_width = $attachment[1];
                        $img_height = $attachment[2];
                    }
                }
                $subheader_attrs = ' style="background-image: url(' . $img_src . ')"';
            }

            $subheader_parallax = exort_get_option( 'subheader_parallax', 'false' );
            if ($page_subheader_parallax = get_post_meta( $id, '_exort_page_settings_subheader_parallax', true)) {
                $subheader_parallax = $page_subheader_parallax;
            }
            if ($subheader_parallax) {
                $extra_class = 'parallax';
            }

            if ( !empty( $extra_class ) ) {
                echo ' class="'. esc_attr( $extra_class ) .'"';
            }
            echo wp_kses_post( $subheader_attrs );
        }
    }
}

if ( !function_exists( 'exort_remove_wpautop' ) ) {
    function exort_remove_wpautop( $content ) {
        $content = trim($content);
        if ( strpos( $content, "</p>" ) === 0 ) {
            $content = substr($content, 4);
        }
        if ( strrpos( $content, "<p>" ) === strlen($content) - 3 ) {
            $content = substr($content, 0, -3);
        }
        return $content;
    }
}

if ( !function_exists( 'exort_blog_counter' ) ) {
    function exort_blog_counter() {
        static $exort_blogs_index = 0;
        return ++$exort_blogs_index;
    }
}

if ( !function_exists( 'exort_esc_post' ) ) {
    function exort_esc_post( $str ) {
        return $str;
    }
}