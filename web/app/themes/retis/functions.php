<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

use Timber\Timber;
use Timber\Menu;
use Timber\Site;
use Carbon_Fields\Carbon_Fields;
use PostTypes\PostType;
use PostTypes\Taxonomy;
use Timber\Post;

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		// add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_filter('use_block_editor_for_post', [ $this, 'retis_use_gutenberg' ], 10, 2);

		add_action( 'carbon_fields_register_fields', [ $this, 'retis_carbon_fields' ] );
		add_filter( 'render_block', [$this, 'retis_url_new_tab'], 10, 2 );

		$this->register_post_types();

		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {
		$listing_cat = new Taxonomy([
			'name'		=> 'listing_cat',
			'singular'	=> 'Category',
			'plural'	=> 'Categories',
			'slug'		=> 'listing_cat',
		]);

		$location = new Taxonomy([
			'name'		=> 'location',
			'singular'	=> 'Location',
			'plural'	=> 'Locations',
			'slug'		=> 'location',
		]);

		$listing_cat->register();
		$location->register();

		$listing = new PostType('listing');
		$listing->icon('dashicons-list-view');
		$listing->options([
			'supports'		=> [ 'title', 'editor', 'thumbnail' ],
			'show_in_rest' 	=> true,
			'has_archive' 	=> true,
		]);
		$listing->taxonomy( 'listing_cat' );
		$listing->taxonomy( 'location' );
		$listing->register();
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	public function retis_url_new_tab($content, $block) {
		if(!is_admin() && ! empty( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'target_blank' ) !== false  ) {
			$my_search='href="';
			$my_replace='target="_blank" href="';
			$new_content = str_replace($my_search, $my_replace, $content);
			return $new_content;
		}
		return $content;
	}

	/**
	 * @param bool $ok
	 * @param WP_Post $post
	 */
	public function retis_use_gutenberg($ok, $post) {
		if ($post->post_type == 'listing') return false;
		return $ok;
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$terms = carbon_get_theme_option('retis_terms');
		$context['menu']  = new Menu();
		$context['site']  = $this;
		$context['icon_alt'] = carbon_get_theme_option('retis_icon_alt');
		$context['address'] = carbon_get_theme_option('retis_address');
		$context['phone'] = carbon_get_theme_option('retis_phone');
		$context['phone_direct'] = carbon_get_theme_option('retis_phone_direct');
		$context['fax'] = carbon_get_theme_option('retis_fax');
		$context['whatsapp'] = carbon_get_theme_option('retis_whatsapp');
		$context['email'] = carbon_get_theme_option('retis_email');
		$context['terms_link'] = count($terms) ? (new Post($terms[0]['id']))->link() : '#';
		return $context;
	}

	public function retis_carbon_fields() {
		require_once __DIR__ . '/fields/theme_options.php';
		require_once __DIR__ . '/fields/front_page_fields.php';
		require_once __DIR__ . '/fields/listing_fields.php';
		require_once __DIR__ . '/blocks/hero.php';
		require_once __DIR__ . '/blocks/application_form.php';
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );

		Carbon_Fields::boot();
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	public function vite( $name ) {
		$dist_path = get_template_directory() . '/dist';
		$dist_uri = get_template_directory_uri() . '/dist';
		$manifest = json_decode( file_get_contents( $dist_path . '/manifest.json'), true );
		echo $dist_uri . '/' . $manifest[$name]['file'];
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param object $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		$twig->addFunction( new \Timber\Twig_Function( 'vite', array( $this, 'vite' ) ) );
		return $twig;
	}

}

new StarterSite();
