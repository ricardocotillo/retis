<?php
/* Template Name: Listings */

use Timber\Timber;
use Timber\PostQuery;

function get_pool_value($s) {
  switch ($s) {
    case 'yes':
      return ['yes'];
      break;
    case 'no':
      return [''];
      break;
    default:
      return ['yes', ''];
      break;
  }
}

function get_btype_value($s) {
  return $s == 1 ? ['comprar'] : ($s == 2 ? ['rentar'] : ['comprar', 'rentar']);
}

function get_ptype_value($s) {
  return $s == 1 ? ['residencial'] : ($s == 2 ? ['comercial'] : ['residencial', 'comercial']);
}

$templates = array( 'listing-archive.twig' );

$context = Timber::context();

$context['title'] = 'Archive';
if ( is_day() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'D M Y' );
} elseif ( is_month() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'M Y' );
} elseif ( is_year() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} elseif ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} elseif ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

$business_type = isset($_GET['business_type']) ? (int)$_GET['business_type'] : false;
$property_type = isset($_GET['property_type']) ? (int)$_GET['property_type'] : false;

$price_min = isset($_GET['price_min']) ? $_GET['price_min'] : false;
$price_max = isset($_GET['price_max']) ? $_GET['price_max'] : false;
$size_min = isset($_GET['size_min']) ? $_GET['size_min'] : false;
$size_max = isset($_GET['size_max']) ? $_GET['size_max'] : false;
$bedrooms_min = isset($_GET['bedrooms_min']) ? $_GET['bedrooms_min'] : false;
$bedrooms_max = isset($_GET['bedrooms_max']) ? $_GET['bedrooms_max'] : false;
$garages_min = isset($_GET['garages_min']) ? $_GET['garages_min'] : false;
$garages_max = isset($_GET['garages_max']) ? $_GET['garages_max'] : false;
$stories_min = isset($_GET['stories_min']) ? $_GET['stories_min'] : false;
$stories_max = isset($_GET['stories_max']) ? $_GET['stories_max'] : false;
$pool = isset($_GET['pool']) ? get_pool_value($_GET['pool']) : false;

$tax_query = [
  'relation'  => 'AND',
  [
    'taxonomy'  => 'listing_cat',
    'field'     => 'slug',
    'terms'     => array_merge(get_btype_value($business_type), get_ptype_value($property_type)),
  ],
];

$meta_query = [];

if ($pool) {
  array_push($meta_query, [
    'key' => 'pool',
    'value' => $pool,
    'compare' => 'IN'
  ]);
}

if ($price_min && $price_max) {
  array_push($meta_query, [
    'key'     => 'price',
    'value'   => [$price_min, $price_max],
    'type'    => 'numeric',
    'compare' => 'BETWEEN',
  ]);
} else if ($price_min) {
  array_push($meta_query, [
    'key'     => 'price',
    'value'   => $price_min,
    'type'    => 'numeric',
    'compare' => '>=',
  ]);
} else if ($price_max) {
  array_push($meta_query, [
    'key'     => 'price',
    'value'   => $price_max,
    'type'    => 'numeric',
    'compare' => '<=',
  ]);
}

if ($size_min && $size_max) {
  array_push($meta_query, [
    'key'     => 'sq_ft',
    'value'   => [$size_min, $size_max],
    'type'    => 'numeric',
    'compare' => 'BETWEEN',
  ]);
} else if ($size_min) {
  array_push($meta_query, [
    'key'     => 'sq_ft',
    'value'   => $size_min,
    'type'    => 'numeric',
    'compare' => '>=',
  ]);
} else if ($size_max) {
  array_push($meta_query, [
    'key'     => 'sq_ft',
    'value'   => $size_max,
    'type'    => 'numeric',
    'compare' => '<=',
  ]);
}

if ($bedrooms_min && $bedrooms_max) {
  array_push($meta_query, [
    'key'     => 'bedrooms',
    'value'   => [$bedrooms_min, $bedrooms_max],
    'type'    => 'numeric',
    'compare' => 'BETWEEN',
  ]);
} else if ($bedrooms_min) {
  array_push($meta_query, [
    'key'     => 'bedrooms',
    'value'   => $bedrooms_min,
    'type'    => 'numeric',
    'compare' => '>=',
  ]);
} else if ($bedrooms_max) {
  array_push($meta_query, [
    'key'     => 'bedrooms',
    'value'   => $bedrooms_max,
    'type'    => 'numeric',
    'compare' => '<=',
  ]);
}

if ($garages_min && $garages_max) {
  array_push($meta_query, [
    'key'     => 'garages',
    'value'   => [$garages_min, $garages_max],
    'type'    => 'numeric',
    'compare' => 'BETWEEN',
  ]);
} else if ($garages_min) {
  array_push($meta_query, [
    'key'     => 'garages',
    'value'   => $garages_min,
    'type'    => 'numeric',
    'compare' => '>=',
  ]);
} else if ($garages_max) {
  array_push($meta_query, [
    'key'     => 'garages',
    'value'   => $garages_max,
    'type'    => 'numeric',
    'compare' => '<=',
  ]);
}

if ($stories_min && $stories_max) {
  array_push($meta_query, [
    'key'     => 'stories',
    'value'   => [$stories_min, $stories_max],
    'type'    => 'numeric',
    'compare' => 'BETWEEN',
  ]);
} else if ($stories_min) {
  array_push($meta_query, [
    'key'     => 'stories',
    'value'   => $stories_min,
    'type'    => 'numeric',
    'compare' => '>=',
  ]);
} else if ($stories_max) {
  array_push($meta_query, [
    'key'     => 'stories',
    'value'   => $stories_max,
    'type'    => 'numeric',
    'compare' => '<=',
  ]);
}

if (count($meta_query) > 1) {
  $meta_query['relation'] = 'AND';
}

$context['posts'] = new PostQuery([
  'post_type'   => 'listing',
  'post_status' => 'publish',
  'tax_query'   => $tax_query, 
  'meta_query'  => $meta_query,
]);

Timber::render( $templates, $context );