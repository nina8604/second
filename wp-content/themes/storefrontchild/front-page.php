<?php
if ( is_front_page() ){
    get_header();
}
else get_header('product_catalog');
?>
<!--<div class="main-heading">-->
<!--	<h1>--><?php //the_title(); ?><!--</h1>-->
<!--</div>-->

<section id="bags">
    <div class="container" >
        <h1>Trendy Arrivals</h1>
        <div class="cont">
            <div class="flex-row row">
                <?php do_action('get_prods', 'bags');?>
            </div>
        </div>
    </div>
</section>

<section id="brands" >
    <div class="container" >
        <div id="row_brands" class="flex-row row row-brands" >
            <div>
                <h1>Our Brands</h1>
                <div>
                    <h3>Small Shoes 2017 new Arrivals mini </h3>
                    <h3>Messenger <a>Classic Shoes</a></h3>
                    <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam cupiditate earum eligendi enim ipsam molestias recusandae saepe ullam vel veniam. Alias corporis debitis est illum nobis recusandae tempora tempore totam?</span><span>Aliquid dolore dolores enim exercitationem fuga iste iusto natus nostrum odio optio perspiciatis porro quam quas reiciendis rem, tempore, vitae voluptatibus. Ab aperiam blanditiis debitis magnam maiores officiis sed soluta!</span></p>
                </div>

            </div>
            <div class="img_brand">
                <a href="/">
                    <?php echo getThemeImg(carbon_get_theme_option('img_brand'));?>
                </a>
            </div>

        </div>
    </div>

	<?php if (have_posts()): while (have_posts()): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>
</section>

<section id="showcase">
    <div class="container">
        <h1>Our Showcase</h1>
        <div class="category-list">
            <ul id="Category--List">
                <?php
                    $args = array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => 0,
                    );
                    $categories = get_categories( $args );
                    foreach ($categories as $category){
                        if ($category->name === 'Uncategorized'){
                            continue;
                        }

                        $active = ($category->slug == 'watches' ) ? 'active' : '';
//
                        echo "<li class='category_item $active' data-categorySlug='$category->slug'>$category->name</li>";
//
                    }
                ?>
            </ul>
        </div>
        <div class="cont">
            <div class="showcase-wrap flex-row" >
                <section class="preload">
                    <div class='sk-circle-bounce'>
                        <?php
                        for ($i = 1; $i <= 12; $i++){
                            echo "<div class='sk-child sk-circle-$i'></div>";}
                        ?>
                    </div>
                </section>

                <div id="category_list" class="row">
                    <?php do_action('get_prods', 'watches');?>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contact_form" <?php echo getBackgroundStyle(carbon_get_theme_option('img_contact_form'));?>>
    <div class="container-form">
<!--        --><?php //echo getThemeImgBack(carbon_get_theme_option('img_contact_form'));?>

        <h1>Newsletter</h1>

            <div>
                <input type="text" placeholder="Enter your email address..." aria-label="Enter your email address...">
                <button class="btn" type="submit">Submit</button>
            </div>


    </div>
</section>

<?php get_footer(); ?>
