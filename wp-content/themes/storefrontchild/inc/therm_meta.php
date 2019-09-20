<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'term_meta', __( 'Category Properties' ) )
    ->where( 'term_taxonomy', '=', 'category' )
    ->add_fields( array(
        Field::make( 'color', 'crb_title_color', __( 'Title Color' ) ),
        Field::make( 'image', 'crb_thumb', __( 'Thumbnail' ) ),
    ) );

