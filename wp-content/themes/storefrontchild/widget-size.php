<?php

function size_register_widget() {
    register_widget( 'size_widget' );
}
add_action( 'widgets_init', 'size_register_widget' );


class size_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
// widget ID
            'size_filter_widget',
// widget name
            __('Size filter', 'Size_widget_domain'),
// widget description
            array( 'description' => __( 'Show size filter', 'Size_widget_domain' ), )
        );
    }

    public function widget( $args, $instance ) {
        $args = array(
            'status' => $_POST['status'],
            'limit' => -1,
            'post_type' => 'product',
            'posts_per_page' => -1
        );

        $products = new WP_Query($args);
        echo "<pre>";
        var_dump($products);
//        $attributes = $product->get_attributes();
//        var_dump($attributes);

        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
//if title is present
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
//output


        echo "<span class='gamma widget-title'>SIZE</span>
              <ul class='size_filter'>
                    
              </ul>
                ";
        echo $args['after_widget'];

    }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) )
            $title = $instance[ 'title' ];
        else
            $title = __( 'Standart title', 'Size_widget_domain' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input class="wid" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }



}
