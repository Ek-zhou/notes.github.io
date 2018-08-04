<?php
/**
 * Blog Posts widget
 */

if ( ! class_exists( 'ExortBlogPostsWidget') ) {

    class ExortBlogPostsWidget extends WP_Widget {

        /* Widget defaults */
        public static $widget_defaults = array(
            'title'     => '',
            'order'     => 'DESC',
            'orderby'   => 'date',
            'count'      => 3,
            'category'  => ''
        );

        function __construct() {
            $widget_ops = array( 'description' => esc_html_x( 'Exort Recent Posts', 'widget', 'exort' ) );

            parent::__construct(
                'exort-blog-posts-widget',
                esc_html_x( 'Exort Recent Posts', 'widget', 'exort' ),
                $widget_ops
            );
        }

        /* Display the widget  */
        function widget( $args, $instance ) {

            extract( $args );

            $instance = wp_parse_args( (array) $instance, self::$widget_defaults );

            $title = apply_filters( 'widget_title', $instance['title'] );

            $category = $instance['category'];
            if ( !empty( $category ) ) {
                $category = str_replace(PHP_EOL, ',', $category);
            }

            $post_args = $instance;
            $post_args['category'] = $category;

            global $post;
            $html = '';

            $post_args['post_type'] = 'post';
            $post_args['posts_per_page'] = $post_args['count'];
            $post_args['post_status'] = 'publish';
            if ( !empty( $category ) ) {
                $categories = explode( ",", $category );
                $gc = array();
                foreach ( $categories as $grid_cat ) {
                    array_push( $gc, $grid_cat );
                }
                $gc = implode( ",", $gc );
                $post_args['category_name'] = $gc;
            }
            $post_args['ignore_sticky_posts'] = 1;

            unset($post_args['title']);
            $the_query = new WP_Query( $post_args );
            if ( $the_query->have_posts() ) {
                $html .= '<ul class="recent-post">';
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $html .= '<li class="clearfix">';
                    $html .= '<a href="' . esc_url( get_permalink() ) . '">';
                    $widget_post_img = get_the_post_thumbnail_url();
                    if ( $widget_post_img ) {
                        $html .= '<img src="' . $widget_post_img . '" width="80" height="80" alt="">';
                    } else {
                        $html .= '<img src="' . EXORT_IMAGE_URL . '/no-thumb.jpg" width="80" height="80" alt="">';
                    }
                    $html .= '</a>';
                    $html .= '<div class="post-content">';
                    $html .= '<span class="title"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></span>';
                    $exort_option_blog_post_date_format = exort_get_option('blog_post_meta_date_format', 'j F Y');
                    $html .= '<span class="details">' . get_the_date( $exort_option_blog_post_date_format ) . '</span>';
                    $html .= '</div>';
                    $html .= '</li>';
                }
                $html .= '</ul>';
                wp_reset_postdata();
            }

            echo wp_kses_post( $before_widget );

            if ( $title ) echo wp_kses_post( $before_title . $title . $after_title );
            echo wp_kses_post( $html );

            echo wp_kses_post( $after_widget );

        }

        function update( $new, $old ) {
            $instance = $old;

            $instance['title']    = strip_tags( $new['title'] );
            $instance['order']    = esc_attr( $new['order'] );
            $instance['orderby']  = esc_attr( $new['orderby'] );
            $instance['category'] = esc_attr( $new['category'] );
            $instance['count']    = esc_attr( $new['count'] );

            return $instance;
        }

        function form( $instance ) {

            $instance = wp_parse_args( (array) $instance, self::$widget_defaults );
            $orderby_list = array(
                'ID'        => esc_html_x( 'Order by ID', 'widget', 'exort' ),
                'author'    => esc_html_x( 'Order by author', 'widget', 'exort' ),
                'title'     => esc_html_x( 'Order by title', 'widget', 'exort' ),
                'date'      => esc_html_x( 'Order by date', 'widget', 'exort' ),
                'modified'  => esc_html_x( 'Order by modified', 'widget', 'exort' ),
                'rand'      => esc_html_x( 'Order by rand', 'widget', 'exort' ),
                'menu_order'=> esc_html_x( 'Order by menu', 'widget', 'exort' ),
                'comment_count' => esc_html_x( 'Order by comment count', 'widget', 'exort' )
            );

            ?>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html_x('Title:', 'widget',  'exort'); ?></label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php echo esc_html_x('Category Names:', 'widget',  'exort'); ?></label>
                <textarea id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"  class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>"><?php echo esc_attr( $instance['category'] ); ?></textarea>
                <small><?php echo esc_html_x( 'If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter) .', 'widget', 'exort' ); ?></small>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php echo esc_html_x('Number of posts:', 'widget', 'exort'); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" value="<?php echo esc_attr($instance['count']); ?>" size="2" maxlength="2" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php echo esc_html_x('Sort by:', 'widget', 'exort'); ?></label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
                    <?php foreach( $orderby_list as $value=>$name ): ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $instance['orderby'], $value ); ?>><?php echo esc_html( $name ); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            </p>
                <label>
                    <input name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" value="ASC" type="radio" <?php checked( $instance['order'], 'ASC' ); ?> /><?php echo esc_html_x('Ascending', 'widget', 'exort'); ?>
                </label>
                <label>
                    <input name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" value="DESC" type="radio" <?php checked( $instance['order'], 'DESC' ); ?> /><?php echo esc_html_x('Descending', 'widget', 'exort'); ?>
                </label>
            </p>

        <?php
        }
    }
}

/* Register Widget */
add_action( 'widgets_init', 'exort_load_blog_posts_widget' );

function exort_load_blog_posts_widget() {
	register_widget( 'ExortBlogPostsWidget' );
}