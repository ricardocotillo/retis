<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'theme_options', 'Opciones' )
  ->set_icon( 'dashicons-carrot' )
  ->add_fields( array(
    Field::make('image', 'retis_icon_alt', 'Logo Alternativo' ),
    Field::make('rich_text', 'retis_address', 'Address'),
    Field::make('text', 'retis_phone', 'Phone'),
    Field::make('text', 'retis_phone_direct', 'Phone Direct'),
    Field::make('text', 'retis_fax', 'Fax'),
    Field::make('text', 'retis_whatsapp', 'Whatsapp'),
    Field::make('text', 'retis_email', 'Email')
      ->set_attribute( 'type', 'email' ),
    Field::make( 'association', 'retis_listings_page', 'Página de propiedades' )
      ->set_max( 1 )
      ->set_types( array(
          array(
            'type'      => 'post',
            'post_type' => 'page',
          )
      ) ),
    Field::make( 'association', 'retis_terms', 'Terms of service' )
      ->set_max( 1 )
      ->set_types( array(
          array(
            'type'      => 'post',
            'post_type' => 'page',
          )
      ) ),
  ) );