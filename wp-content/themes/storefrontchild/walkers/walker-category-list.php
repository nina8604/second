<?php
if (class_exists('WC_Product_Cat_List_Walker')){

    class Walker_Category_list extends WC_Product_Cat_List_Walker {
        protected function get_current_page_url() {
            if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
                $link = home_url();
            } elseif ( is_shop() ) {
                $link = get_permalink( wc_get_page_id( 'shop' ) );
            } elseif ( is_product_category() ) {
                $link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
            } elseif ( is_product_tag() ) {
                $link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
            } else {
                $queried_object = get_queried_object();
                $link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
            }

            // Min/Max.
            if ( isset( $_GET['min_price'] ) ) {
                $link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
            }

            if ( isset( $_GET['max_price'] ) ) {
                $link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
            }

            // Order by.
            if ( isset( $_GET['orderby'] ) ) {
                $link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
            }

            /**
             * Search Arg.
             * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
             */
            if ( get_search_query() ) {
                $link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
            }

            // Post Type Arg.
            if ( isset( $_GET['post_type'] ) ) {
                $link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

                // Prevent post type and page id when pretty permalinks are disabled.
                if ( is_shop() ) {
                    $link = remove_query_arg( 'page_id', $link );
                }
            }

            // Min Rating Arg.
            if ( isset( $_GET['rating_filter'] ) ) {
                $link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
            }

            // All current filters.
            if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
                foreach ( $_chosen_attributes as $name => $data ) {
                    $filter_name = wc_attribute_taxonomy_slug( $name );
                    if ( ! empty( $data['terms'] ) ) {
                        $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                    }
                    if ( 'or' === $data['query_type'] ) {
                        $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                    }
                }
            }

            return apply_filters( 'woocommerce_widget_get_current_page_url', $link, $this );
        }

        public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
            $cat_id = intval( $cat->term_id );

            $output .= '<li class="cat-item cat-item-' . $cat_id;

            if ( $args['current_category'] === $cat_id ) {
                $output .= ' current-cat';
            }

            if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
                $output .= ' cat-parent';
            }

            if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat_id, $args['current_category_ancestors'], true ) ) {
                $output .= ' current-cat-parent';
            }
            $filter_name = $this->tree_type;
            $base_link          = $this->get_current_page_url();
            $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array(); // WPCS: input var ok, CSRF ok.
            $current_filter = array_map( 'sanitize_title', $current_filter );

            if ( ! in_array( $cat->slug, $current_filter, true ) ) {
                $current_filter[] = $cat->slug;
            }

            $link = remove_query_arg( $filter_name, $base_link );


            if ( ! empty( $current_filter ) ) {
                asort( $current_filter );
                $link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

            }

//            $output .= '"><a id="' . $cat_id . '" href="' . get_term_link( $cat_id, $this->tree_type ) . '">' . apply_filters( 'list_product_cats', $cat->name, $cat ) . '</a>';
//            $output .= '"><a href="' . get_term_link( $cat_id, $this->tree_type ) . '">' . apply_filters( 'list_product_cats', $cat->name, $cat ) . '</a>';
//            $output .= '"><a href="' . get_site_url(null, 'product-catalog', 'https' ) .'/?'.$this->tree_type .'='.$cat->slug.'">' . apply_filters( 'list_product_cats', $cat->name, $cat ) . '</a>';
            $output .= '"><a href="' . esc_url( $link ) .'">' . apply_filters( 'list_product_cats', $cat->name, $cat ) . '</a>';

            if ( $args['show_count'] ) {
                $output .= ' <span class="count">' . $cat->count . '</span>';
            }
        }
    }

}
