<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

require_once __DIR__ . '/widget-price-range.php';
include_once WC()->plugin_path() . '/includes/walkers/class-wc-product-cat-list-walker.php';
include_once __DIR__ . '/walkers/walker-category-list.php';


add_action('carbon_fields_register_fields', 'crb_attach');
function crb_attach()
{
    include __DIR__ . '/inc/theme_options.php';
    include __DIR__ . '/inc/therm_meta.php';
    include __DIR__ . '/inc/nav_menu.php';
}

add_action('after_setup_theme', 'crb_load');
function crb_load()
{
    require_once('vendor/autoload.php');
    Carbon_Fields\Carbon_Fields::boot();
}

function storefrontchild_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'storefrontchild_add_woocommerce_support');


function enqueue_styles()
{
    wp_enqueue_style('storefrontchild-style', get_stylesheet_uri());


    wp_enqueue_style('slick_style', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.0.0');
//    wp_enqueue_style('icons_style','https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array(), '1.0.0');
    wp_enqueue_style('icons_style', 'https://use.fontawesome.com/releases/v5.9.0/css/all.css', array(), '1.1.0');
    wp_enqueue_style('icons_style', 'https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css', array(), '1.1.0');
    wp_enqueue_style('bootstrap_style', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), '3.3.7');
    wp_enqueue_style('main_style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    wp_enqueue_style('jquery_ui_style', get_stylesheet_directory_uri() . '/assets/css/jquery-ui.css', array(), '1.1.0');
}

add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_scripts()
{
    wp_enqueue_script('jquery');


    wp_enqueue_script('slick_scripts', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.0.0', true);

    wp_enqueue_script('theme_scripts', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), '1.1.0', true);
    wp_enqueue_script('jquery_ui_scripts', get_stylesheet_directory_uri() . '/assets/js/jquery-ui.js', array('jquery'), '1.1.0', true);
    wp_enqueue_script('bootstrap_scripts', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), '3.3.7', true);

}

add_action('wp_enqueue_scripts', 'enqueue_scripts');


add_action('wp_enqueue_scripts', 'myajax_data', 99);
function myajax_data()
{
    wp_localize_script('theme_scripts', 'myajax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );
}

function getThemeImg($id, $size = "full")
{
    return $id ? "<img src='" . wp_get_attachment_image_url($id, $size) . "'>" : false;
}

function getThemeImgBack($id)
{
    return $id ? "<div class='background' style='background-image: url(" . wp_get_attachment_image_url($id, 'full') . ");'></div>" : false;
}

function getBackgroundStyle($id)
{
    return $id ? "style='background-image: url(" . wp_get_attachment_image_url($id, 'full') . ");'" : false;
}


add_filter("wp_head", "counter_product_view");
function get_post_views($post_id = NULL)
{
    global $post;
    if ($post_id == NULL)
        $post_id = $post->ID;
    if (!empty($post_id)) {
        $views_key = 'views';
        $views = get_post_meta($post_id, $views_key, true);
        if (empty($views) || !is_numeric($views)) {
            delete_post_meta($post_id, $views_key);
            add_post_meta($post_id, $views_key, '0');
            return "0";
        } else if ($views == 1)
            return "1";
        return $views;
    }
}

function counter_product_view()
{
    global $post;

    if (is_singular()) {
        $views_key = 'wpds_post_views';
        $views = get_post_meta($post->ID, $views_key, true);
        if (empty($views) || !is_numeric($views)) {
            delete_post_meta($post->ID, $views_key);
            add_post_meta($post->ID, $views_key, '1');
        } else
            update_post_meta($post->ID, $views_key, ++$views);
    }
}

add_action('get_prods', 'get_products_cat');
function get_products_cat($category)
{
    $args = array(
        'category' => array($category),
        'limit' => 6,
    );

    $products = wc_get_products($args);
    foreach ($products as $product) {
        $name = $product->name;
        $price = $product->price;
        $comments_count = wp_count_comments($product->id);
        $img = wp_get_attachment_image($product->image_id, 'full');

        $output = "<div class='col-xs-6 col-sm-4 col-md-4'>
            <div class='thumbnail'>
               <div class='new_class'>
                    <div class='group_left'>
                        <span class='icon'><i class='fa fa-eye'></i></span>
                        <p class='count'>" . get_post_views($product->id) . "</p>
                    </div>
                    <div class='group_right'>
                        <img src='" . get_stylesheet_directory_uri() . "/images/comments.png' alt='' width='25' height='21'>
                        <p class='count'>$comments_count->total_comments</p>
                    </div>
                </div>
                <div>$img</div>
                <div class='caption'>
                    <h3>$name</h3>
                    <p class='price' >$ $price</p><p><a href='#' class='btn btn-primary' role='button'>Add to Cart</a></p>
                </div>
            </div>
        </div> ";

        echo $output;
    }
}


if (wp_doing_ajax()) {
    add_action('wp_ajax_choose_category', 'get_showcase');
    add_action('wp_ajax_nopriv_choose_category', 'get_showcase');
}

function get_showcase()
{
    $categorySlug = $_POST['categorySlug'];

    echo get_products_cat($categorySlug);

    wp_die();
}

register_nav_menus(array(
    'header' => 'header menu',
    'footer' => 'Footer menu'
));

add_filter('woocommerce_add_to_cart_fragments', 'header_add_to_cart_fragment');

function header_add_to_cart_fragment($fragments)
{
    global $woocommerce;
    ob_start();
    ?>
    <span class="basket-btn__counter"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?></span>
    <?php
    $fragments['.basket-btn__counter'] = ob_get_clean();
    return $fragments;
}

function deregister_styles()
{
    wp_dequeue_style('storefront-icons');
    wp_deregister_style('storefront-icons');
//    wp_dequeue_style('storefront-icons');
//    wp_deregister_style('storefront-icons');
//
}

add_action('wp_enqueue_scripts', 'deregister_styles', 20);

// delete pagination before shop loop /
add_action('wp_loaded', function () {
    remove_action('woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
//	remove_action( 'woocommerce_before_shop_loop', 'gridlist_toggle_button' , 30);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 30);
});

// choose quantity products per page
add_action('woocommerce_before_shop_loop', 'ps_selectbox', 25);
//remove_action( 'woocommerce_before_shop_loop', 'gridlist_toggle_button' , 26);

function ps_selectbox()
{
    $per_page = filter_input(INPUT_GET, 'perpage', FILTER_SANITIZE_NUMBER_INT);
    echo '<form class="woocommerce-perpage">';

    echo '<select class="choose-per-page" onchange="if (this.value) window.location.href=this.value">';
    $orderby_options = array(
        '-Select-' => 'SHOW: -Select-',
        '6' => 'SHOW: 6',
        '9' => 'SHOW: 9',
        '12' => 'SHOW: 12',
        '15' => 'SHOW: 15',

    );
    foreach ($orderby_options as $value => $label) {
        echo "<option " . selected($per_page, $value) . " value='?perpage=$value'>$label</option>";
    }
    echo '</select>';
    echo '</form>';
}


add_action('pre_get_posts', 'ps_pre_get_products_query');
function ps_pre_get_products_query($query)
{
    $per_page = filter_input(INPUT_GET, 'perpage', FILTER_SANITIZE_NUMBER_INT);
    if ($query->is_main_query() && !is_admin() && is_post_type_archive('product')) {
        $query->set('posts_per_page', $per_page);
    }
}

add_action('woocommerce_before_shop_loop', 'btn_view_all', 28);
function btn_view_all()
{
    echo "<div class='woocommerce-view-all'>";
    echo "<botton class='view-all'>VIEW ALL</botton></div>";

}

// for button view all
if (wp_doing_ajax()) {
    add_action('wp_ajax_show_all', 'get_show_all');
    add_action('wp_ajax_nopriv_show_all', 'get_show_all');
}
function get_show_all()
{
    $args = array(
        'status' => $_POST['status'],
        'limit' => -1,
        'post_type' => 'product',
        'posts_per_page' => -1
    );
    $products = new WP_Query($args);

    while ($products->have_posts()) {
        $products->the_post();
        /**
         * Hook: woocommerce_shop_loop.
         *
         * @hooked WC_Structured_Data::generate_product_data() - 10
         */
        do_action('woocommerce_shop_loop');

        wc_get_template_part('content', 'product');
    }
    wp_die();
}

add_action('woocommerce_sidebar', 'woocommerce_pagination', 20);


// filter for orderby
add_filter('woocommerce_catalog_orderby', 'new_orderby');
function new_orderby($args)
{

    $args = array(
        'menu_order' => __('DEFAULT SORTING', 'woocommerce'),
        'popularity' => __('SORT BY: popularity', 'woocommerce'),
        'rating' => __('SORT BY: average rating', 'woocommerce'),
        'date' => __('SORT BY: latest', 'woocommerce'),
        'price' => __('SORT BY: Price $ - $$', 'woocommerce'),
        'price-desc' => __('SORT BY: Price $$ - $', 'woocommerce'),
    );
    return $args;
}

// add icons elements to filter title
add_filter('storefront_sidebar_widget_tags', 'new_widget_args');

function new_widget_args($widget_tags)
{
    $widget_tags['before_title'] = '<div class="gamma">' . $widget_tags['before_title'];
    $widget_tags['after_title'] .= '<i class="fas fa-times"></i></div>';
    return $widget_tags;
}

// add id to category list
add_filter('woocommerce_product_categories_widget_args', 'new_walker');
function new_walker($list_args)
{

    if (class_exists('Walker_Category_list')) {

        $list_args['walker'] = new Walker_Category_list();

//        die();
    }
    return $list_args;
}


if (wp_doing_ajax()) {
    add_action('wp_ajax_choose_filter', 'choose_categories_filter');
    add_action('wp_ajax_nopriv_choose_filter', 'choose_categories_filter');
}
function choose_categories_filter()
{
    global $wp_query;
    $args = array(
        'limit' => 6,
        'post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'terms' => [$_POST['cat_id']],
                'field' => 'id',
                'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
            )
        )
//        'posts_per_page' => 6,
    );


    $wp_query = new WP_Query($args);


    while ($wp_query->have_posts()) {
        the_post();
        /**
         * Hook: woocommerce_shop_loop.
         *
         * @hooked WC_Structured_Data::generate_product_data() - 10
         */
        do_action('woocommerce_shop_loop');

        wc_get_template_part('content', 'product');
    }
    wp_die();
}

// reset category filter
if (wp_doing_ajax()) {
    add_action('wp_ajax_reset_cat_filter', 'reset_categories_filter');
    add_action('wp_ajax_nopriv_reset_cat_filter', 'reset_categories_filter');
}
function reset_categories_filter()
{
    $args = array(
        'status' => $_POST['status'],
        'limit' => -1,
        'post_type' => 'product',
        'category' => '',
        'posts_per_page' => 6,
    );
    $products = new WP_Query($args);
    while ($products->have_posts()) {
        $products->the_post();
        /**
         * Hook: woocommerce_shop_loop.
         *
         * @hooked WC_Structured_Data::generate_product_data() - 10
         */
        do_action('woocommerce_shop_loop');

        wc_get_template_part('content', 'product');
    }
    wp_die();
}

// price range filter
if (wp_doing_ajax()) {
    add_action('wp_ajax_choose_price_range', 'choose_price_range');
    add_action('wp_ajax_nopriv_choose_price_range', 'choose_price_range');
}
function choose_price_range()
{
    $args = array(
        'post_status' => 'publish',
        'post_type' => 'product',
        'posts_per_page' => 6,
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($_POST['range_min'], $_POST['range_max']),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
        )
    );
    $products = new WP_Query($args);
//    echo "<pre>";
//    var_dump($products);
    while ($products->have_posts()) {
        $products->the_post();
        /**
         * Hook: woocommerce_shop_loop.
         *
         * @hooked WC_Structured_Data::generate_product_data() - 10
         */
        do_action('woocommerce_shop_loop');

        wc_get_template_part('content', 'product');
    }
    wp_die();
}

// reset price range filter
if (wp_doing_ajax()) {
    add_action('wp_ajax_reset_price_range_filter', 'reset_price_range_filter');
    add_action('wp_ajax_nopriv_reset_price_range_filter', 'reset_price_range_filter');
}
function reset_price_range_filter()
{
    $args = array(
        'status' => $_POST['status'],
        'limit' => -1,
        'post_type' => 'product',
        'posts_per_page' => 6,
        array(
            'key' => '_price',
            'value' => array(0, 500),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        )
    );
    $products = new WP_Query($args);
    while ($products->have_posts()) {
        $products->the_post();
        /**
         * Hook: woocommerce_shop_loop.
         *
         * @hooked WC_Structured_Data::generate_product_data() - 10
         */
        do_action('woocommerce_shop_loop');

        wc_get_template_part('content', 'product');
    }
    wp_die();
}

// color and size filter
if (wp_doing_ajax()) {
    add_action('wp_ajax_choose_color_size_filter', 'choose_color_size_filter');
    add_action('wp_ajax_nopriv_choose_color_size_filter', 'choose_color_size_filter');
}
function choose_color_size_filter()
{
    $url = $_POST['url'];
//    var_dump($url);
    $query = parse_url($url, PHP_URL_QUERY);
//    var_dump($query);
    parse_str($query, $filters);
//    var_dump($filters);
    $args = array(
        'post_status' => 'publish',
        'post_type' => 'product',
        'posts_per_page' => 6,
        'tax_query' => [
            'relation' => 'OR',
            [
                'relation' => 'AND',
                [
                    'taxonomy' => 'pa_color',
                    'field'    => 'slug',
                    'terms'    => [ $filters['filter_color'] ]
                ],
                [
                    'taxonomy' => 'pa_size',
                    'field'    => 'slug',
                    'terms'    => $filters['filter_size']
                ]
            ],
            [
                [
                    'taxonomy' => 'pa_color',
                    'field'    => 'slug',
                    'terms'    => [ $filters['filter_color'] ]
                ]
            ],
            [
                [
                    'taxonomy' => 'pa_size',
                    'field'    => 'slug',
                    'terms'    => $filters['filter_size']
                ]
            ],
        ]
    );
    $products = new WP_Query($args);
//    echo "<pre>";
//    var_dump($products->posts);
    while ($products->have_posts()) {
        $products->the_post();
        /**
         * Hook: woocommerce_shop_loop.
         *
         * @hooked WC_Structured_Data::generate_product_data() - 10
         */
        do_action('woocommerce_shop_loop');

        wc_get_template_part('content', 'product');
    }
    wp_die();
}
// reset color filter
if (wp_doing_ajax()) {
    add_action('wp_ajax_reset_color_size_filter', 'reset_color_size_filter');
    add_action('wp_ajax_nopriv_reset_color_size_filter', 'reset_color_size_filter');
}
function reset_color_size_filter()
{
    $args = array(
        'status' => $_POST['status'],
        'limit' => -1,
        'post_type' => 'product',
        'posts_per_page' => 6,
    );
    $products = new WP_Query($args);
    while ($products->have_posts()) {
        $products->the_post();
        /**
         * Hook: woocommerce_shop_loop.
         *
         * @hooked WC_Structured_Data::generate_product_data() - 10
         */
        do_action('woocommerce_shop_loop');

        wc_get_template_part('content', 'product');
    }
    wp_die();
}