<?php

use Timber\Timber;
use Timber\PostQuery;

$templates = array( 'archive-listing.twig' );

$context = Timber::context();
$context['posts'] = new PostQuery();

Timber::render( $templates, $context );
