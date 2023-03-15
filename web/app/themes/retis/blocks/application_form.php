<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use Timber\Timber;

Block::make( 'Retis Application Form' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
    $ctx = [
      'fields'  => $fields,
      'attrs'   => $attributes,
      'inner'   => $inner_blocks,
    ];
		Timber::render( 'blocks/application_form.twig', $ctx );
	} );