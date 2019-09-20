<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">

    <div class='reset-filter'><a href='https://second.dev-test.pro/product-catalog/'>FILTER </a></div>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
