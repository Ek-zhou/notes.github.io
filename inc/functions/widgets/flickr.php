<?php
/**
 * Flickr widget
 */

if ( ! class_exists( 'ExortFlickrWidget') ) :
class ExortFlickrWidget extends WP_Widget {

  function __construct() {
    $widget_ops  = array( 'classname' => 'exort-flickr-widget', 'description' =>  __( 'Display your latest Flickr photos', 'exort' ) );
    $control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'exort-flickr-widget' );
    parent::__construct( 'exort-flickr-widget', __( 'Exort Flickr Widget', 'exort' ), $widget_ops, $control_ops );
  }

  function widget( $args, $instance ) {
    extract( $args );
    $flickr_title = apply_filters( 'widget_title', $instance['flickr_title'] );
    $flickr_id    = $instance['flickr_id'];
    $flickr_count = $instance['flickr_count'];
    $flickr_columns = $instance['flickr_columns'];
    echo wp_kses_post( $before_widget );
    if ( empty( $flickr_columns ) ) {
      $flickr_columns = 1;
    } elseif ( (int)$flickr_columns > 6 ) {
      $flickr_columns = 6;
    }
    ?>

    <div class="flickr-widget">
      <?php if ( $flickr_title ) {
       echo "<h4>" . $before_title . $flickr_title . $after_title . "</h4>"; 
      } ?>
      <div class="exort-flickr-wrapper">
        <ul id="flickr-<?php echo esc_attr( $args['widget_id'] ); ?>" class="flickr-feeds st-columns-<?php echo esc_attr( $flickr_columns ); ?>">
        <?php

        if ( $flickr_id != '' ) {

          $images      = array();
          $regx        = "/<img(.+)\/>/";
          $rss_url     = 'http://api.flickr.com/services/feeds/photos_public.gne?ids=' . $flickr_id . '&lang=en-us&format=rss_200';
          $flickr_feed = simplexml_load_file( $rss_url );

          foreach( $flickr_feed->channel->item as $item ) {
            preg_match( $regx, $item->description, $matches );
            $images[] = array(
              'link'  => $item->link,
              'thumb' => $matches[ 0 ]
            );
          }

          $image_count = 0;
          if ( $flickr_count == '' ) $flickr_count = 5;

          foreach( $images as $img ) {
            if ( $image_count < $flickr_count ) {
              $img_tag = str_replace( '_m', '_q', $img[ 'thumb' ] );
              echo '<li><a href="' . $img[ 'link' ] . '">' . $img_tag . '</a></li>';
              $image_count++;
            }
          }

        }

        ?>
        </ul>
      </div>
    </div>
    <?php
    echo wp_kses_post( $after_widget );
  }

  function update( $new_instance, $old_instance ) {
    $instance                 = $old_instance;
    $instance['flickr_title'] = strip_tags( $new_instance['flickr_title'] );
    $instance['flickr_id']    = strip_tags( $new_instance['flickr_id'] );
    $instance['flickr_count'] = strip_tags( $new_instance['flickr_count'] );
    $instance['flickr_columns'] = strip_tags( $new_instance['flickr_columns'] );
    return $instance;
  }

  function form( $instance ) {
    $idgettr = 'http://idgettr.com/';
    ?>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'exort' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr_title' ) ); ?>" value="<?php if ( isset( $instance['flickr_title'] ) ) echo esc_attr( $instance['flickr_title'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'flickr_id' ) ); ?>"><?php esc_html_e( 'Your Flickr User ID:', 'exort' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr_id' ) ); ?>" value="<?php if ( isset( $instance['flickr_id'] ) ) echo esc_attr( $instance['flickr_id'] ); ?>" />
      <small>Not sure what to put here? Try <a href="<?php echo esc_url( $idgettr ); ?>" target="_blank">idGettr</a>.</small>
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'flickr_columns' ) ); ?>"><?php esc_html_e( 'Columns:', 'exort' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr_columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr_columns' ) ); ?>" value="<?php if ( isset( $instance['flickr_columns'] ) ) echo esc_attr( $instance['flickr_columns'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'flickr_count' ) ); ?>"><?php esc_html_e( 'No. of Photos:', 'exort' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr_count' ) ); ?>" value="<?php if ( isset( $instance['flickr_count'] ) ) echo esc_attr( $instance['flickr_count'] ); ?>" />
    </p>

    <?php
  }
}
endif;

/* Register Widget */
add_action( 'widgets_init', 'exort_load_flickr_widget' );

function exort_load_flickr_widget() {
  register_widget( 'ExortFlickrWidget' );
}