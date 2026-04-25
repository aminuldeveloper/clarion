<?php
/**
 * Luminary functions and definitions
 *
 * @package Clarion
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme version constant.
 */
define( 'CLARION_VERSION', '1.0.4' );

/**
 * Required files.
 */
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';

/**
 * Theme setup.
 */
function clarion_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'clarion', get_template_directory() . '/languages' );

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

	// Register custom image sizes.
	add_image_size( 'clarion-featured', 1200, 675, true );
	add_image_size( 'clarion-card', 600, 400, true );
	add_image_size( 'clarion-wide', 1600, 900, true );

	// This theme uses wp_nav_menus() in multiple locations.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'clarion' ),
			'footer'  => esc_html__( 'Footer Menu', 'clarion' ),
			'social'  => esc_html__( 'Social Links Menu', 'clarion' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Add support for Post Formats.
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

	// Add support for custom header.
	add_theme_support(
		'custom-header',
		array(
			'default-image'      => '',
			'width'              => 1600,
			'height'             => 400,
			'flex-height'        => true,
			'flex-width'         => true,
			'uploads'            => true,
			'default-text-color' => '222222',
		)
	);

	// Add support for custom background.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'FAF9F7',
			'default-image' => '',
		)
	);
}
add_action( 'after_setup_theme', 'clarion_setup' );

/**
 * Register block patterns.
 */
function clarion_register_block_patterns() {
	register_block_pattern(
		'clarion/hero-with-intro',
		array(
			'title'       => __( 'Hero with Intro Text', 'clarion' ),
			'description' => __( 'A hero section with a heading and intro paragraph.', 'clarion' ),
			'categories'  => array( 'featured' ),
			'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}}} --><div class="wp-block-group alignfull"><!-- wp:heading {"level":1,"textAlign":"center"} --><h1 class="wp-block-heading has-text-align-center">' . esc_html__( 'Welcome to My Blog', 'clarion' ) . '</h1><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">' . esc_html__( 'Stories, ideas, and thoughts worth sharing.', 'clarion' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'clarion_register_block_patterns' );

/**
 * Register block styles.
 */
function clarion_register_block_styles() {
	register_block_style(
		'core/quote',
		array(
			'name'  => 'clarion-pull-quote',
			'label' => __( 'Pull Quote', 'clarion' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'clarion-outline',
			'label' => __( 'Outline', 'clarion' ),
		)
	);
}
add_action( 'init', 'clarion_register_block_styles' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function clarion_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'clarion_content_width', 780 );
}
add_action( 'after_setup_theme', 'clarion_content_width', 0 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function clarion_widgets_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'clarion' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in the sidebar.', 'clarion' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 1', 'clarion' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here to appear in the first footer column.', 'clarion' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 2', 'clarion' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here to appear in the second footer column.', 'clarion' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 3', 'clarion' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here to appear in the third footer column.', 'clarion' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'clarion_widgets_init' );
