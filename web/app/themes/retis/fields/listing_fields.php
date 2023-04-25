<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', 'Especificaciones' )
  ->where('post_type', '=', 'listing')
  ->add_fields([
    Field::make('text', 'city'),
    Field::make('text', 'type'),
    Field::make('text', 'price')
      ->set_attribute('type', 'number'),
    Field::make( 'text', 'built_in' ),
    Field::make('text', 'sq_ft', 'Area')
      ->set_attribute('type', 'number'),
    Field::make('text', 'built_sq_ft', 'Built Area')
      ->set_attribute('type', 'number'),
    Field::make('text', 'bedrooms')
      ->set_attribute('type', 'number'),
    Field::make('text', 'bathrooms')
      ->set_attribute('type', 'number'),
    Field::make('text', 'garages')
      ->set_attribute('type', 'number'),
    Field::make('text', 'stories')
      ->set_attribute('type', 'number'),
    Field::make('checkbox', 'pool'),
    Field::make('checkbox', 'featured',),
    Field::make('complex', 'retis_gallery', 'Galería')
      ->add_fields([
        Field::make('image', 'image', 'Imagen')
      ]),
  ]);