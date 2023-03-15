<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', 'Custom Data' )
  ->where( 'post_id', '=', get_option( 'page_on_front' ) )
  ->add_fields( [
    Field::make('file', 'retis_certificate', 'Certificado')
      ->set_value_type( 'url' ),
  ] );