<?php

use Carbon_Fields\Block;
use Timber\Timber;
use Timber\Post;

Block::make( 'Retis Application Form' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
    $pages = carbon_get_theme_option('retis_listings_page');
    $action = '';
    if (count($pages) > 0) {
      $listings_page = new Post(carbon_get_theme_option('retis_listings_page')[0]['id']);
      $action = $listings_page->link();
    }
    
    $ctx = [
      'fields'  => $fields,
      'attrs'   => $attributes,
      'inner'   => $inner_blocks,
      'action'    => $action,
    ];
		Timber::render( 'blocks/application_form.twig', $ctx );
	} );