<?php
/**
 * Theme setup functions.
 *
 * This file holds basic theme setup functions executed on appropriate hooks
 * with some opinionated priorities based on theme dev, particularly working
 * with child theme devs/users, over the years. I've also decided to use
 * anonymous functions to keep these from being easily unhooked. WordPress has
 * an appropriate API for unregistering, removing, or modifying all of the
 * things in this file. Those APIs should be used instead of attempting to use
 * `remove_action()`.
 *
 * @package   Strangebrew
 * @author    David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      http://www.strangebrewdesign.com
 */

namespace Strangebrew;

/**
 * Set up theme support.  This is where calls to `add_theme_support()` happen.
 *
 * @link   https://developer.wordpress.org/reference/functions/add_theme_support/
 * @link   https://developer.wordpress.org/themes/basics/theme-functions/
 * @link   https://developer.wordpress.org/reference/functions/load_theme_textdomain/
 * @link   https://github.com/WordPress/gutenberg/blob/master/docs/extensibility/theme-support.md
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'after_setup_theme', function() {

	// Sets the theme content width. This variable is also set in the
	// `resources/scss/settings/_dimensions.scss` file.
	$GLOBALS['content_width'] = 750;

	// Load theme translations.
	load_theme_textdomain( 'strangebrew', get_parent_theme_file_path( 'resources/lang' ) );

	// Automatically add the `<title>` tag.
	add_theme_support( 'title-tag' );

	// Automatically add feed links to `<head>`.
	add_theme_support( 'automatic-feed-links' );

	// Adds featured image support.
	add_theme_support( 'post-thumbnails' );

	// Add selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Wide and full alignment. The styles for alignment is housed in the
	// `resources/scss/utilities/_alignment.scss` file.
	add_theme_support( 'align-wide' );

	// Outputs HTML5 markup for core features.
	add_theme_support( 'html5', [
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form'
	] );

	// Add custom logo support.
	add_theme_support( 'custom-logo', [
		'width'       => null,
		'height'      => null,
		'flex-width'  => null,
		'flex-height' => false,
		'header-text' => ''
	] );

	// Editor style sheet.
	add_theme_support('editor-styles');

	// Editor color palette. These colors are also defined in the
	// `resources/scss/settings/_colors.scss` file.
	add_theme_support( 'editor-color-palette', [
		[
			'name'  => __( 'Primary', 'strangebrew' ),
			'slug'  => 'primary',
			'color' => '#f26419'
		],
		[
			'name'  => __( 'Secondary', 'strangebrew' ),
			'slug'  => 'secondary',
			'color' => '#00375d',
		],
		[
			'name'  => __( 'Tertiary', 'strangebrew' ),
			'slug'  => 'tertiary',
			'color' => '#000a16',
		],
		[
			'name'  => __( 'Light Grey', 'strangebrew' ),
			'slug'  => 'light-grey',
			'color' => '#eeeeee',
		]
	] );

	// Editor block font sizes. These font sizes are also defined in the
	// `resources/scss/settings/_fonts.scss` file.
	add_theme_support( 'editor-font-sizes', [
		[
			'name'      => __( 'Small', 'strangebrew' ),
			'shortName' => __( 'S', 'strangebrew' ),
			'size'      => 12,
			'slug'      => 'small'
		],
		[
			'name'      => __( 'Regular', 'strangebrew' ),
			'shortName' => __( 'M', 'strangebrew' ),
			'size'      => 16,
			'slug'      => 'regular'
		],
		[
			'name'      => __( 'Large', 'strangebrew' ),
			'shortName' => __( 'L', 'strangebrew' ),
			'size'      => 24,
			'slug'      => 'large'
		],
		[
			'name'      => __( 'Larger', 'strangebrew' ),
			'shortName' => __( 'XL', 'strangebrew' ),
			'size'      => 36,
			'slug'      => 'larger'
		],
		[
			'name'      => __( 'Largest', 'strangebrew' ),
			'shortName' => __( 'XXL', 'strangebrew' ),
			'size'      => 48,
			'slug'      => 'largest'
		]
	] );

	/**
	 * Adds support for the Custom Content Portfolio Plugin.
	 *  
	 * @link https://wordpress.org/plugins/custom-content-portfolio/
	 */
	add_theme_support( 'custom-content-portfolio' );

}, 5 );

/**
 * Adds support for the custom background feature. This is in its own function
 * hooked to `after_setup_theme` so that we can give it a later priority.  This
 * is so that child themes can more easily overwrite this feature.  Note that
 * overwriting the background should be done *before* rather than after.
 *
 * @link   https://developer.wordpress.org/reference/functions/add_theme_support/#custom-background
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'after_setup_theme', function() {

	add_theme_support( 'custom-background', [
		'default-image'          => '',
		'default-preset'         => 'default',
		'default-position-x'     => 'left',
		'default-position-y'     => 'top',
		'default-size'           => 'auto',
		'default-repeat'         => 'repeat',
		'default-attachment'     => 'scroll',
		'default-color'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	] );

}, 15 );

/**
 * Adds support for the custom header feature. This is in its own function
 * hooked to `after_setup_theme` so that we can give it a later priority.  This
 * is so that child themes can more easily overwrite this feature.  Note that
 * overwriting the header should be done *before* rather than after.
 *
 * @link   https://developer.wordpress.org/reference/functions/add_theme_support/#custom-header
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'after_setup_theme', function() {

	add_theme_support( 'custom-header', [
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 750,
		'height'                 => 422,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
		'video'                  => true,
		'video-active-callback'  => 'is_front_page'
	] );

}, 15 );

/**
 * Register menus.
 *
 * @link   https://developer.wordpress.org/reference/functions/register_nav_menus/
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'init', function() {

	register_nav_menus( [
		'primary' => esc_html_x( 'Primary', 'nav menu location', 'strangebrew' )
	] );

	register_nav_menus( [
		'footer' => esc_html_x( 'Footer', 'nav menu location', 'strangebrew' )
	] );

	register_nav_menus( [
		'social' => esc_html_x( 'Social', 'nav menu location', 'strangebrew' )
	] );

}, 5 );

/**
 * Register image sizes. Even if adding no custom image sizes or not adding
 * "thumbnails," it's still important to call `set_post_thumbnail_size()` so
 * that plugins that utilize the `post-thumbnail` size will have a properly-sized
 * thumbnail that matches the theme design.
 *
 * @link   https://developer.wordpress.org/reference/functions/set_post_thumbnail_size/
 * @link   https://developer.wordpress.org/reference/functions/add_image_size/
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'init', function() {

	// Set the `post-thumbnail` size.
	set_post_thumbnail_size( 480, 300, true );

	// Register custom image sizes.
	add_image_size( 'strangebrew-large', 1000, 480, true );
	add_image_size( 'strangebrew-medium', 750, 360, true );
	add_image_size( 'strangebrew-small', 500, 240, true );
	add_image_size( 'strangebrew-thumbnail', 480, 360, true );

}, 5 );

/**
 * Register sidebars.
 * 
 *
 * @link   https://developer.wordpress.org/reference/functions/register_sidebar/
 * @link   https://developer.wordpress.org/reference/functions/register_sidebars/
 * @since  0.9.0
 * @access public
 * @return void
 */

/* 
add_action( 'widgets_init', function() {

	$args = [
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget__title">',
		'after_title'   => '</h3>'
	];

	register_sidebar( [
		'id'   => 'primary',
		'name' => esc_html_x( 'Primary', 'sidebar', 'strangebrew' )
	] + $args );

}, 5 );
*/

/**
 * Register page templates.
 *
 * @link   https://github.com/justintadlock/mythic/wiki/Page-Templates/
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'hybrid/templates/register', function( $templates ) {

	$templates->add( 'template-entry-content-only.php', [
		'label'      => __( 'No Entry Header/Footer', 'strangebrew' ),
		'post_types' => [
			'page',
			'post'
		]
	] );

	$templates->add( 'template-landing-page.php', [
			'label'      => __( 'Landing Page', 'strangebrew' ),
			'post_type'  => [ 'page' ]
	] );
} );
