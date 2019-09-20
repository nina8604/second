<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('theme_options', __('Theme Options'))
    ->add_fields(array(
        Field::make('complex', 'center_image', 'Slide Images')
            ->add_fields(array(
                Field::make('image', 'crb_image', __('Image')),
            ))
            ->set_layout('tabbed-horizontal'),

        Field::make( 'image', 'img_logo', 'Logo'),
        Field::make( 'image', 'img_logo_catalog', 'Logo_catalog'),
        Field::make( 'image', 'img_brand', 'Brand'),
        Field::make( 'image', 'img_contact_form', 'Contact_form'),
        Field::make( 'image', 'img_catalog1', 'Catalog1'),
        Field::make( 'image', 'img_catalog2', 'Catalog2'),
//        Field::make( 'image', 'img_bottom-slide', 'Bottom-slide'),
        Field::make('complex', 'center_bottom', 'Slide Bottom')
            ->add_fields(array(
                Field::make('image', 'bottom_image', __('Bottom slide')),
            ))

            ->set_layout('tabbed-horizontal'),
        Field::make('complex', 'brands_footer', 'Brands Footer')
            ->add_fields(array(
                Field::make('image', 'brands_image', __('Brands slide')),
            ))

            ->set_layout('tabbed-horizontal'),

        Field::make( 'text', 'crb_text', 'Text Field'),
        Field::make( 'text', 'crb_category', 'Text Category'),
        Field::make( 'text', 'facebook_url', 'Facebook'),
        Field::make( 'text', 'google_url', 'Google'),
        Field::make( 'text', 'insta_url', 'instagram'),
        Field::make( 'text', 'twitter_url', 'Twitter'),
        Field::make( 'text', 'linkedin_url', 'Linkedin'),
        Field::make( 'textarea', 'crb_text_content', 'Text content' ) )
    );


