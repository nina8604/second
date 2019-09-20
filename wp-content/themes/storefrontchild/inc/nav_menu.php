<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'nav_menu_item', __( 'Menu Settings' ) )
    ->add_fields( array(
        Field::make( 'color', 'crb_color', __( 'Color' ) ),
        Field::make( 'select', 'select-collection', __( 'Choose Options' ) )
            ->set_options( array(
                'collection1' => __('collection1'),
                'collection2' => __('collection2'),
                'collection3' => __('collection3'),

            ) ),
    ));