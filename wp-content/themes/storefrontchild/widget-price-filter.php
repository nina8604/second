<?php
///**
// * Price Range Filter Widget
// *
// * Generates a range slider to filter products by price.
// *
//// * @package WooCommerce/Widgets
// * @version 1.1.0
// */
//
//defined( 'ABSPATH' ) || exit;
//
///**
// * Widget price range filter class.
// */
//class WC_Widget_Price_Range_Filter extends WC_Widget {
//
//    /**
//     * Constructor.
//     */
//    public function __construct() {
//        $this->widget_cssclass    = 'woocommerce widget_price_range_filter';
//        $this->widget_description = __( 'Display a slider to filter products in your store by price.', 'woocommerce' );
//        $this->widget_id          = 'new_woocommerce_price_range_filter';
//        $this->widget_name        = __( 'Filter Products by Price Range', 'woocommerce' );
//        $this->settings           = array(
//            'title' => array(
//                'type'  => 'text',
//                'std'   => __( 'Filter by price range', 'woocommerce' ),
//                'label' => __( 'Title', 'woocommerce' ),
//            ),
//        );
//
////        wp_register_script('jquery-ui-slider', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), '1.0.0', true);
//
////        $suffix                   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
////        wp_register_script( 'accounting', WC()->plugin_url() . '/assets/js/accounting/accounting' . $suffix . '.js', array( 'jquery' ), '0.4.2', true );
////        wp_register_script( 'wc-jquery-ui-touchpunch', WC()->plugin_url() . '/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );
////        wp_register_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider', 'wc-jquery-ui-touchpunch', 'accounting' ), WC_VERSION, true );
////        wp_localize_script(
////            'wc-price-slider',
////            'woocommerce_price_slider_params',
////            array(
////                'currency_format_num_decimals' => 0,
////                'currency_format_symbol'       => get_woocommerce_currency_symbol(),
////                'currency_format_decimal_sep'  => esc_attr( wc_get_price_decimal_separator() ),
////                'currency_format_thousand_sep' => esc_attr( wc_get_price_thousand_separator() ),
////                'currency_format'              => esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format() ) ),
////            )
////        );
////
////        if ( is_customize_preview() ) {
////            wp_enqueue_script( 'wc-price-slider' );
////        }
//
//        parent::__construct();
//    }
//
//    /**
//     * Output widget.
//     *
////     * @see WP_Widget
////     *
////     * @param array $args     Arguments.
////     * @param array $instance Widget instance.
//     */
//     function widget( $args, $instance ) {
//        global $wp;
//
////        // Requires lookup table added in 3.6.
////        if ( version_compare( get_option( 'woocommerce_db_version', null ), '3.6', '<' ) ) {
////            return;
////        }
//
//        if ( ! is_shop() && ! is_product_taxonomy() ) {
//            return;
//        }
//
//        // If there are not posts and we're not filtering, hide the widget.
//        if ( ! WC()->query->get_main_query()->post_count && ! isset( $_GET['min_price'] ) && ! isset( $_GET['max_price'] ) ) { // WPCS: input var ok, CSRF ok.
//            return;
//        }
//
////        wp_enqueue_script('jquery-ui-slider', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), '1.0.0', true);
////        wp_enqueue_script( 'wc-price-slider' );
//
//        // Round values to nearest 10 by default.
//        $step = max( apply_filters( 'woocommerce_price_filter_widget_step', 10 ), 1 );
//
//        // Find min and max price in current result set.
//        $prices    = $this->get_filtered_price();
//        $min_price = $prices->min_price;
//        $max_price = $prices->max_price;
//
//        // Check to see if we should add taxes to the prices if store are excl tax but display incl.
//        $tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
//
//        if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === $tax_display_mode ) {
//            $tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
//            $tax_rates = WC_Tax::get_rates( $tax_class );
//
//            if ( $tax_rates ) {
//                $min_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $min_price, $tax_rates ) );
//                $max_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max_price, $tax_rates ) );
//            }
//        }
//
//        $min_price = apply_filters( 'woocommerce_price_filter_widget_min_amount', floor( $min_price / $step ) * $step );
//        $max_price = apply_filters( 'woocommerce_price_filter_widget_max_amount', ceil( $max_price / $step ) * $step );
//
//        // If both min and max are equal, we don't need a slider.
//        if ( $min_price === $max_price ) {
//            return;
//        }
//
//        $current_min_price = isset( $_GET['min_price'] ) ? floor( floatval( wp_unslash( $_GET['min_price'] ) ) / $step ) * $step : $min_price; // WPCS: input var ok, CSRF ok.
//        $current_max_price = isset( $_GET['max_price'] ) ? ceil( floatval( wp_unslash( $_GET['max_price'] ) ) / $step ) * $step : $max_price; // WPCS: input var ok, CSRF ok.
//
//        $this->widget_start( $args, $instance );
//
//        if ( '' === get_option( 'permalink_structure' ) ) {
//            $form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
//        } else {
//            $form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
//        }
//
//        echo '<form method="get" action="' . esc_url( $form_action ) . '">
//                <div class="price_label" style="display:none;">
//                    <span class="from"></span> &mdash; <span class="to"></span>
//                </div>
//                ' . wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true ) . '
//                <div class="price_slider_wrapper">
//                    <div class="price_slider" style="display:none;"></div>
//                    <div class="price_slider_amount" data-step="' . esc_attr( $step ) . '">
//                        <input type="text" id="min_price" name="min_price" value="' . esc_attr( $current_min_price ) . '" data-min="' . esc_attr( $min_price ) . '" placeholder="' . esc_attr__( 'Min price', 'woocommerce' ) . '" />
//                        <input type="text" id="max_price" name="max_price" value="' . esc_attr( $current_max_price ) . '" data-max="' . esc_attr( $max_price ) . '" placeholder="' . esc_attr__( 'Max price', 'woocommerce' ) . '" />
//                        <div class="price">
//                            <div class="floor-price">$0</div>
//                            <div class="ceil-price">$90</div>
//                        </div>
//
//                        <button type="submit" class="button">' . esc_html__( 'Filter', 'woocommerce' ) . '</button>
//
//                        <div class="clear"></div>
//                    </div>
//                </div>
//            </form>'; // WPCS: XSS ok.
//
////        echo '<form method="get" action="' . esc_url( $form_action ) . '">
////                <p>
////                  <label for="amount">Price range:</label>
////                  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
////                </p>
////
////                <div id="slider-range"></div>
////            </form>'; // WPCS: XSS ok.
//
//        $this->widget_end( $args );
//    }
//    /**
//     * Get filtered min price for current products.
//     *
//     * @return int
//     */
//    protected function get_filtered_price() {
//        global $wpdb;
//
//        $args       = WC()->query->get_main_query()->query_vars;
//        $tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
//        $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();
//
//        if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
//            $tax_query[] = WC()->query->get_main_tax_query();
//        }
//
//        foreach ( $meta_query + $tax_query as $key => $query ) {
//            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
//                unset( $meta_query[ $key ] );
//            }
//        }
//
//        $meta_query = new WP_Meta_Query( $meta_query );
//        $tax_query  = new WP_Tax_Query( $tax_query );
//        $search     = WC_Query::get_main_search_query_sql();
//
//        $meta_query_sql   = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
//        $tax_query_sql    = $tax_query->get_sql( $wpdb->posts, 'ID' );
//        $search_query_sql = $search ? ' AND ' . $search : '';
//
//        $sql = "
//			SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
//			FROM {$wpdb->wc_product_meta_lookup}
//			WHERE product_id IN (
//				SELECT ID FROM {$wpdb->posts}
//				" . $tax_query_sql['join'] . $meta_query_sql['join'] . "
//				WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
//				AND {$wpdb->posts}.post_status = 'publish'
//				" . $tax_query_sql['where'] . $meta_query_sql['where'] . $search_query_sql . '
//			)';
//
//        $sql = apply_filters( 'woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql );
//
//        return $wpdb->get_row( $sql ); // WPCS: unprepared SQL ok.
//    }
//
//    public function form( $instance ) {
//        if ( isset( $instance[ 'title' ] ) )
//            $title = $instance[ 'title' ];
//        else
//            $title = __( 'Стандартный Заголовок', 'woocommerce' );
//        ?>
<!--        <p>-->
<!--            <label for="--><?php //echo $this->get_field_id( 'title' ); ?><!--">--><?php //_e( 'Title:' ); ?><!--</label>-->
<!--            <input class="widefat" id="--><?php //echo $this->get_field_id( 'title' ); ?><!--" name="--><?php //echo $this->get_field_name( 'title' ); ?><!--" type="text" value="--><?php //echo esc_attr( $title ); ?><!--" />-->
<!--        </p>-->
<!--        --><?php
//    }
//    public function update( $new_instance, $old_instance ) {
//        $instance = array();
//        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
//        return $instance;
//    }
//}
