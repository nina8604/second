<?php

function price_range_register_widget() {
    register_widget( 'price_widget' );
}
add_action( 'widgets_init', 'price_range_register_widget' );


class price_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
// widget ID
            'price_range_widget',
// widget name
            __('Price range filter', 'price_widget_domain'),
// widget description
            array( 'description' => __( 'Show price range filter', 'price_widget_domain' ), )
        );
    }

    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );
// Round values to nearest 10 by default.
        $step =1;
        // Find min and max price in current result set.
        $prices    = $this->get_filtered_price();
        $min_price = $prices->min_price;
        $max_price = $prices->max_price;

        // Check to see if we should add taxes to the prices if store are excl tax but display incl.
        $tax_display_mode = get_option( 'woocommerce_tax_display_shop' );

        if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === $tax_display_mode ) {
            $tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
            $tax_rates = WC_Tax::get_rates( $tax_class );

            if ( $tax_rates ) {
                $min_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $min_price, $tax_rates ) );
                $max_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max_price, $tax_rates ) );
            }
        }

        $min_price = apply_filters( 'woocommerce_price_filter_widget_min_amount', floor( $min_price / $step ) * $step );
        $max_price = apply_filters( 'woocommerce_price_filter_widget_max_amount', ceil( $max_price / $step ) * $step );


        $current_min_price = isset( $_GET['min_price'] ) ? $_GET['min_price'] : $min_price; // WPCS: input var ok, CSRF ok.
        $current_max_price = isset( $_GET['max_price'] ) ? $_GET['max_price'] : $max_price; // WPCS: input var ok, CSRF ok.

        echo $args['before_widget'];
//if title is present
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
//output


        echo "<div class='gamma'>
                <span class='gamma widget-title'>PRICE RANGE</span>
                <i class='fas fa-times'></i>
              </div>
              <form method='GET' class='price-slider'>
                    <p>
                        
                        <input type='text' id='amount-floor' value='".$current_min_price."'>
                        <input type='text' id='amount-ceil' value='".$current_max_price."'>
                    </p>
                 
                    <div id='slider-range'></div>
                    <div class='floor-price'>$0</div>
                    <div class='ceil-price'>$100</div>
              </form>
                ";
        echo $args['after_widget'];

    }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) )
            $title = $instance[ 'title' ];
        else
            $title = __( 'Standart title', 'price_widget_domain' );
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
    protected function get_filtered_price() {
        global $wpdb;

        $args       = WC()->query->get_main_query()->query_vars;
        $tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
        $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

        if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
            $tax_query[] = WC()->query->get_main_tax_query();
        }

        foreach ( $meta_query + $tax_query as $key => $query ) {
            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                unset( $meta_query[ $key ] );
            }
        }

        $meta_query = new WP_Meta_Query( $meta_query );
        $tax_query  = new WP_Tax_Query( $tax_query );
        $search     = WC_Query::get_main_search_query_sql();

        $meta_query_sql   = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql    = $tax_query->get_sql( $wpdb->posts, 'ID' );
        $search_query_sql = $search ? ' AND ' . $search : '';

        $sql = "
			SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
			FROM {$wpdb->wc_product_meta_lookup}
			WHERE product_id IN (
				SELECT ID FROM {$wpdb->posts}
				" . $tax_query_sql['join'] . $meta_query_sql['join'] . "
				WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
				AND {$wpdb->posts}.post_status = 'publish'
				" . $tax_query_sql['where'] . $meta_query_sql['where'] . $search_query_sql . '
			)';

        $sql = apply_filters( 'woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql );

        return $wpdb->get_row( $sql ); // WPCS: unprepared SQL ok.
    }



}