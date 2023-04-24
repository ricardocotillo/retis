<?php

use Timber\Timber;
use Timber\PostQuery;

$templates = array( 'archive-listing.twig' );
$context = Timber::context();

if (isset($_GET['type']) && $_GET['type'] != '') {
    $listing_cat = $_GET['type'];
    $context['posts'] = new PostQuery([
        'tax_query' => [
            [
                'taxonomy'  => 'listing_cat',
                'field'     => 'slug',
                'terms'     => $listing_cat,
            ],
        ]
    ]);
}

Timber::render( $templates, $context );
