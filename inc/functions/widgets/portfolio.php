<?php
/**
 * Portfolio widget
 */

if ( ! class_exists( 'ExortPortfolioWidget') ) {

    class ExortPortfolioWidget extends WP_Widget {

        /* Widget defaults */
        public static $widget_defaults = array(
            'title'     => '',
            'order'     => 'DESC',
            'orderby'   => 'date',
            'count'     => 3,
            'category'  => '',
            'columns'   => 3,
        );

        function __construct() {
            $widget_ops = array( 'description' => esc_attr_x( 'Exort Recent Portfolio', 'widget', 'exort' ) );

            parent::__construct(
                'exort-portfolio-widget',
                esc_attr_x( 'Exort Portfolio', 'widget', 'exort' ),
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

            global $post;
            $html = '';

            $post_args['post_type'] = 'portfolio';
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

                $taxonomies = get_taxonomies( '', 'object' );
                $post_args['tax_query'] = array( 'relation' => 'OR' );
                foreach ( $taxonomies as $t ) {
                    if ( $t->object_type[0] == 'portfolio' ) {
                        $post_args['tax_query'][] = array(
                            'taxonomy' => $t->name, //'portfolio_category',
                            'terms' => $categories,
                            'field' => 'slug',
                        );
                    }
                }
            }
            unset($post_args['title']);
            $the_query = new WP_Query( $post_args );
            if ( $the_query->have_posts() ) {
                $html .= '<ul class="recent-portfolio st-columns-'. esc_attr( $instance['columns'] ) .'">';
                $image_size = 'thumbnail';
                if ( !empty( $instance['image_size'] ) ) {
                    $image_size = $instance['image_size'];
                }
                while ( $the_query->have_posts() ) { $the_query->the_post();
                    if ( $exort_portfolio_thumbnail = exort_portfolio_thumbnail( get_the_ID(), false, $image_size ) ) {
                        $html .= '<li>';
                            $html .= '<a href="' . esc_url( get_permalink() ) . '" class="portfolio-thumbnail image hover-layout2"><span>';
                                $html .= wp_kses_post( $exort_portfolio_thumbnail );
                            $html .= '</span><span class="image-extras"></span></a>';
                        $html .= '</li>';
                    }
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
            $instance['columns']    = esc_attr( $new['columns'] );
            $instance['image_size']    = esc_attr( $new['image_size'] );

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
                'menu_order'=> esc_html_x( 'Order by menu', 'widget', 'exort' )
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
                <label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php echo esc_html_x('Columns:', 'widget', 'exort'); ?></label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>">
                    <?php for ($i = 2; $i <= 6; $i++) { ?>
                        <option value="<?php echo esc_attr( $i ); ?>" <?php selected( $instance['columns'], $i ); ?>><?php echo esc_html( $i ); ?></option>
                    <?php } ?>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>"><?php echo esc_html_x('Image Size:', 'widget', 'exort'); ?></label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'image_size' ) ); ?>" value="<?php echo esc_attr($instance['image_size']); ?>" />
                <small><?php esc_html_e( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). If you want to use theme default size, please leave this field as blank.', 'exort' ); ?></small>
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
add_action( 'widgets_init', 'exort_load_portfolio_widget' );

function exort_load_portfolio_widget() {
    register_widget( 'ExortPortfolioWidget' );
}