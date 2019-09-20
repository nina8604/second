<div class="footer-catalog">
    <div class="footer-carousel-inner">
        <?php
        $slides = carbon_get_theme_option('center_bottom');
        if ( $slides ) {
            foreach ( $slides as $slide ) {
                echo "<div class='footer-carousel-item'>".getThemeImgBack($slide['bottom_image'])."</div>";
            }
        }
        ?>
    </div>
    <div class="brands-carousel-inner">
        <?php
        $slides = carbon_get_theme_option('brands_footer');
        if ( $slides ) {
            foreach ( $slides as $slide ) {
                echo "<div class='brands-carousel-item'>".getThemeImgBack($slide['brands_image'])."</div>";
            }
        }
        ?>
    </div>
    <div class="footer-bottom">
        <div class="footer-bottom-left">
            <div class="modax" >
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/modax.png';?>" alt="">
            </div>
            <div class="social_icons">
                <?php

                if (carbon_get_theme_option('facebook_url')){
                    echo "<a href='".carbon_get_theme_option('facebook_url')."' class='facebook'><i class='fab fa-facebook-f' aria-hidden='true'></i></a>";
                }
                if (carbon_get_theme_option('twitter_url')){
                    echo "<a href='".carbon_get_theme_option('twitter_url')."'><i class='fab fa-twitter' aria-hidden='true'></i></a>";
                }
                if (carbon_get_theme_option('insta_url')){
                    echo "<a href='".carbon_get_theme_option('insta_url')."'><i class='fab fa-instagram' aria-hidden='true'></i></a>";
                }
                if (carbon_get_theme_option('google_url')){
                    echo "<a href='".carbon_get_theme_option('google_url')."'><i class='fab fa-google-plus-g' aria-hidden='true'></i></a>";
                }
                if (carbon_get_theme_option('twitter_url')){
                    echo "<a href='".carbon_get_theme_option('linkedin_url')."'><i class='fab fa-linkedin-in' aria-hidden='true'></i></a>";
                }
                ?>
            </div>
        </div>
        <div class="right-bottom-right">
            <h1>CONTACT US</h1>
            <div>
                San Francisco, California <br>
                400 Castro St.San Francisco, CA <br>
                (+1) 686-868-9999
            </div>
            <div class="bank-cards">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/visa.png';?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/card2.png';?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/card3.png';?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/card4.png';?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/card5.png';?>" alt="">
            </div>
        </div>
        <div class="footer-bottom-center">

            <?php
            wp_nav_menu( array(
                'menu' => 'footer-2-menu',
                'menu_class'=>'menu',
                'theme_location'=>'footer',
            ) );
            ?>
            <div class="container-form">
              <h1>SUBSCRIBE TO NEWS</h1>
                <div>
                    <input type="text" placeholder="Email Address" aria-label="Enter your email address...">
                    <button class="btn btn-default" type="submit">Submit</button>
                </div>
            </div>
        </div>
        <div class="footer-bottom-right">
            <h1>CONTACT US</h1>
            <div>
                San Francisco, California <br>
                400 Castro St.San Francisco, CA <br>
                (+1) 686-868-9999
            </div>
            <div class="bank-cards">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/visa.png';?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/card2.png';?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/card3.png';?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/card4.png';?>" alt="">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/card5.png';?>" alt="">
            </div>
        </div>

    </div>
</div>
<footer>
</footer>
<?php wp_footer(); ?>

        </div>
    </body>
</html>