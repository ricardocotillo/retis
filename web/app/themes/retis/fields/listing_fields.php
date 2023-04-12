<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', 'Especificaciones' )
  ->where('post_type', '=', 'listing')
  ->add_fields([
    Field::make('text', 'price')
      ->set_attribute('type', 'number'),
    Field::make('text', 'sq_ft', 'Square feet')
      ->set_attribute('type', 'number'),
    Field::make('text', 'bedrooms')
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