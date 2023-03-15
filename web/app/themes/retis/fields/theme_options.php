<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'theme_options', 'Opciones' )
  ->set_icon( 'dashicons-carrot' )
  ->add_fields( array(
    Field::make( 'image', 'retis_icon_alt', 'Logo Alternativo' ),
  ) );