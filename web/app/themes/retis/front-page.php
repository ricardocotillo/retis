<?php
use Timber\Timber;
use Timber\Post;

$context = Timber::context();

$timber_post     = new Post();
$context['post'] = $timber_post;
Timber::render( 'front-page.twig', $context );