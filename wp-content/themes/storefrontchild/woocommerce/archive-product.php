<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'product_catalog' );
?>
<div class="container-up-product">
    <div class="container-bread">
        <?php
        if (carbon_get_theme_option('crb_category')){
        echo "<h1>".carbon_get_theme_option('crb_category')."</h1>";
        }
        ?>
        <p>Home</p>

    </div>
    <div class="container-down-product">
        <div class="banner">
            <div class="banner-left">
                <?php
                    echo getThemeImgBack(carbon_get_theme_option('img_catalog1'));
                ?>
                <div class="text-left">
                    <h4>LIFESTYLE</h4>
                    <h1>New Now: Striped cotton</h1>
                    <button class="more">More info</button>
                </div>
            </div>
            <div class="banner-right">
                <?php
                    echo getThemeImgBack(carbon_get_theme_option('img_catalog2'));
                ?>
                <div class="text-right">
                    <h4>LIFESTYLE</h4>
                    <h1>Fashion</h1>
                    <h1>Collection</h1>
                    <button class="more">More info</button>
                </div>
            </div>

        </div>

    <?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<!--<header class="woocommerce-products-header">-->
<!--	--><?php //if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
<!--		<h1 class="woocommerce-products-header__title page-title">--><?php //woocommerce_page_title(); ?><!--</h1>-->
<!--	--><?php //endif; ?>
<!---->
<!--	--><?php
//	/**
//	 * Hook: woocommerce_archive_description.
//	 *
//	 * @hooked woocommerce_taxonomy_archive_description - 10
//	 * @hooked woocommerce_product_archive_description - 10
//	 */
//	do_action( 'woocommerce_archive_description' );
//	?>
<!--</header>-->



<?php

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
    do_action( 'woocommerce_after_shop_loop' );


//    global $wp_query; // you can remove this line if everything works for you

//// don't display the button if there are not enough posts
//    if ($wp_query->max_num_pages > 1)
//        echo '<div class="load_more">Load more</div>'; // you can use <a> as well




} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
//?>
<!--<a href="https://second.dev-test.pro/product-catalog/">Сбросить фильтр</a>-->
<?php

do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );



?>
    </div>
</div>
<?php
get_footer( 'product_catalog' );
