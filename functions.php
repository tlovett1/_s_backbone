<?php
/**
 * _s_backbone functions and definitions
 *
 * @package _s_backbone
 */

/**
 * Load util functions
 */
require get_template_directory() . '/inc/utils.php';

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( '_s_backbone_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _s_backbone_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s_backbone, use a find and replace
	 * to change '_s_backbone' to the name of your theme in all the template files
	 */
	load_theme_textdomain( '_s_backbone', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', '_s_backbone' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '_s_backbone_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // _s_backbone_setup
add_action( 'after_setup_theme', '_s_backbone_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function _s_backbone_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_s_backbone' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', '_s_backbone_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _s_backbone_scripts() {
	wp_enqueue_style( '_s_backbone-style', get_stylesheet_uri() );

	wp_enqueue_script( '_s_backbone-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( '_s_backbone-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	} elseif ( is_home() || is_front_page() || is_archive() || is_search() ) {
		global $wp_rewrite;

		wp_enqueue_script( '_s_backbone-loop', get_template_directory_uri() . '/js/loop.js', array( 'jquery', 'backbone', 'underscore', 'wp-api'  ), '1.0', true );

		$queried_object = get_queried_object();

		$local = array(
			'loopType' => 'home',
			'queriedObject' => $queried_object,
			'pathInfo' => array(
				'author_permastruct' => $wp_rewrite->get_author_permastruct(),
				'host' => preg_replace( '#^http(s)?://#i', '', untrailingslashit( get_option( 'home' ) ) ),
				'path' => _s_backbone_get_request_path(),
				'use_trailing_slashes' => $wp_rewrite->use_trailing_slashes,
				'parameters' => _s_backbone_get_request_parameters(),
			),
		);

		if ( is_category() || is_tag() || is_tax() ) {
			$local['loopType'] = 'archive';
			$local['taxonomy'] = get_taxonomy( $queried_object->taxonomy );
		} elseif ( is_search() ) {
			$local['loopType'] = 'search';
			$local['searchQuery'] = get_search_query();
		} elseif ( is_author() ) {
			$local['loopType'] = 'author';
		}
		
		//set the page we're on so that Backbone can load the proper state
		if ( is_paged() ) {
			$local['page'] = absint( get_query_var( 'paged' ) ) + 1;
		}

		wp_localize_script( '_s_backbone-loop', 'settings', $local );
	}
}
add_action( 'wp_enqueue_scripts', '_s_backbone_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

