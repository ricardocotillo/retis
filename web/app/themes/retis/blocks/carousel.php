<?php

use Carbon_Fields\Block;
use Timber\Timber;
use Timber\Post;

Block::make( 'Retis Carousel' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		
        Timber::render( 'blocks/carousel.twig', $ctx );
	} );