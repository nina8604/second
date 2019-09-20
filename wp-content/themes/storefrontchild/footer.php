
<section id="footer-menu">
    <div class="container-footer">
        <h1>Big Shop</h1>
        <?php
        wp_nav_menu( array(
            'menu' => 'footer_menu',
            'menu_class'=>'menu',
            'theme_location'=>'footer',
        ) );
        ?>
        <div class="social_icons">
            <?php

            if (carbon_get_theme_option('facebook_url')){
                echo "<a href='".carbon_get_theme_option('facebook_url')."' class='facebook'><i class='fa fa-facebook' aria-hidden='true'></i></a>";
            }
            if (carbon_get_theme_option('google_url')){
                echo "<a href='".carbon_get_theme_option('google_url')."'><i class='fa fa-google-plus' aria-hidden='true'></i></a>";
            }
            if (carbon_get_theme_option('insta_url')){
                echo "<a href='".carbon_get_theme_option('insta_url')."'><i class='fa fa-instagram' aria-hidden='true'></i></a>";
            }
            if (carbon_get_theme_option('twitter_url')){
                echo "<a href='".carbon_get_theme_option('twitter_url')."'><i class='fa fa-twitter' aria-hidden='true'></i></a>";
            }
            ?>
        </div>
    </div>
    <div class="copyright">
        <p>© Copyright 2017. Big Shop by Victor Themes</p>
    </div>
</section>
	<footer></footer>
	<?php wp_footer(); ?>
</div>
</body>
</html>