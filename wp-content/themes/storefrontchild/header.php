<!doctype html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title('«', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="wrapper">
        <div class="container_nav_menu">
            <?php
            wp_nav_menu( array(
                'menu' => 'head_menu',
                'menu_class'=>'menu',
                'theme_location'=>'header',
            ) );
            ?>
            <div class="all-btn-group" role="group" aria-label="...">
                <div class="input-group" >
                    <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/images/search.png';?>" alt="">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <div class="btn-group" role="group">
                    <button id="btn-collection" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Collection
                    </button><i class="fa fa-angle-down"></i>
                    <ul class="dropdown-menu">
                        <li><a href="#">Collection 1</a></li>
                        <li><a href="#">Collection 2</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <span class="x-off-canvas-bg open-close-menu"></span>
        <div class="container-fluid">
            <div class="container-up">
                <div class="logo">
                    <a href="/">
                        <?php echo getThemeImg(carbon_get_theme_option('img_logo'));?>
                    </a>
                </div>

                <div class="all-btn-group" role="group" aria-label="...">
                    <div class="input-group" >
                        <img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/images/search.png';?>" alt="">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <div class="btn-group" role="group">
                        <button id="btn-collection" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Collection
                        </button><i class="fa fa-angle-down"></i>
                        <ul class="dropdown-menu">
                            <li><a href="#">Collection 1</a></li>
                            <li><a href="#">Collection 2</a></li>
                        </ul>
                    </div>
                </div>

                <div class="burger burger-slip open-close-menu">
                    <div class="burger-lines"></div>
                </div>
            </div>
            <div class="carousel-inner">

                <?php
                    $slides = carbon_get_theme_option('center_image');
                    if ( $slides ) {
                        foreach ( $slides as $slide ) {
                            echo "<div class='carousel-item'>"
                                    .getThemeImgBack($slide['crb_image'])."
                                    <div class='container-upd'>
                                        <div class='inside-text'>
                                            <h1>Summer</h1>
                                            <h1>Collection</h1>
                                            <h2>25 % <span>OFF</span></h2>
                                            <button class='btn btn-default' type='button'>Details <i class=\"fa fa-long-arrow-right\" aria-hidden=\"true\"></i></button>
                                        </div>
                                    </div>
                            </div>";
                        }
                    }
                ?>
            </div>
        </div>
