<!doctype html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('«', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="wrapper">
        <div class="header_catalog">
            <div class="logo">
                <p>Be.Pro</p>
            </div>
            <div class="container_nav_menu_catalog">
                <?php
                wp_nav_menu( array(
                    'menu' => 'header_catalog_menu',
                    'menu_class'=>'menu',
                    'theme_location'=>'header',
                ) );
                ?>

            </div>

            <div class="container-header_icons">
                <div class="s-header__basket-wr woocommerce">
                    <?php
                    global $woocommerce; ?>
                    <a href="<?php echo $woocommerce->cart->get_cart_url() ?>" class="basket-btn basket-btn_fixed-xs">
                        <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/images/cart.png';?>" alt="">
                        <span class="basket-btn__counter"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?></span>
                    </a>
                </div>
                <div class="search_container">
                    <a href='#' class='search'><img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/images/search2.png';?>" alt=""></a>
                    <input type="text" class="search-form-control" placeholder="Search">
                </div>
                <div class="burger burger-slip open-close-menu">
                    <div class="burger-lines"></div>
                </div>
            </div>
        </div>
        <span class="x-off-canvas-bg open-close-menu"></span>