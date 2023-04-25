<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', 'Información de solicitud' )
  ->where('post_type', '=', 'request')
  ->add_fields([
    Field::make('text', 'property'),
    Field::make('text', 'first_name'),
    Field::make('text', 'last_name'),
    Field::make('text', 'email')
      ->set_attribute('type', 'email'),
    Field::make('text', 'phone')
      ->set_attribute('type', 'tel'),
    Field::make('radio', 'phone_preference')
      ->set_options([
        'txt'   => 'Prefiere un TXT',
        'call'  => 'Prefiere una llamada',
      ]),
    Field::make('textarea', 'message'),
  ]);