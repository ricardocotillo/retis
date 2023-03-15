<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use Timber\Timber;

Block::make( 'Retis Hero' )
	->add_fields( array(
		Field::make( 'text', 'heading', 'Título' ),
		Field::make( 'text', 'subtitle', 'Subtitulo'),
		Field::make( 'image', 'bg', 'Imagen de fondo' ),
	) )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
    $ctx = [
      'fields'  => $fields,
      'attrs'   => $attributes,
      'inner'   => $inner_blocks,
    ];
		Timber::render( 'blocks/hero.twig', $ctx );
	} );