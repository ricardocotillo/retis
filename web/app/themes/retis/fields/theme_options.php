<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'theme_options', 'Opciones' )
  ->set_icon( 'dashicons-carrot' )
  ->add_fields( array(
    Field::make( 'image', 'retis_icon_alt', 'Logo Alternativo' ),
    Field::make( 'association', 'retis_listings_page', 'Página de propiedades' )
    ->set_max( 1 )
    ->set_types( array(
        array(
          'type'      => 'post',
          'post_type' => 'page',
        )
    ) )
  ) );