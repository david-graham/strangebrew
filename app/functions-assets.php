<?php
/**
 * Asset-related functions and filters.
 *
 * This file holds some setup actions for scripts and styles as well as a helper
 * functions for work with assets.
 *
 * @package   Strangebrew
 * @author    David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      http://www.strangebrewdesign.com
 */

namespace Strangebrew;

use Hybrid\App;

/**
 * Enqueue scripts/styles for the front end.
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link   https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'wp_enqueue_scripts', function() {

	// Disable core block styles.
	wp_dequeue_style( 'wp-block-library' );

	// Load WordPress' comment-reply script where appropriate.
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue theme scripts.
	wp_enqueue_script( 'strangebrew-app', asset( 'js/app.js' ), null, null, true );

	// Enqueue theme styles.
	wp_enqueue_style( 'strangebrew-screen', asset( 'css/screen.css' ), null, null );
	
	// Enqueue font awesome.
	wp_enqueue_style( 'strangebrew-font-awesome', asset( 'css/font-awesome.min.css' ), null, null );

	// Enqueue theme fonts.
	\Hybrid\Font\enqueue( 'strangebrew', [
		'family' => [
			'roboto'      => 'Roboto:300,400,500,700',
			'roboto-slab' => 'Roboto+Slab:300,400,700'
		],
		'subset' => [
			'latin'
		]
	] );

} );

/**
 * Unregisters the core block editor assets on the front end and admin.
 *
 * @link https://github.com/WordPress/gutenberg/issues/15007
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'enqueue_block_assets', function() {

	// Unregister core block and theme styles.
	wp_deregister_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library-theme' );

	// Re-register core block and theme styles with an empty string. This is
	// necessary to get styles set up correctly.
	wp_register_style( 'wp-block-library', '' );
	wp_register_style( 'wp-block-library-theme', '' );
} );


/**
 * Enqueue scripts/styles for the editor.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
add_action( 'enqueue_block_editor_assets', function() {
	
	$deps = [
		'wp-i18n',
		'wp-blocks',
		'wp-dom-ready',
		'wp-edit-post',
	];

	// Enqueue theme editor scripts.
	wp_enqueue_script( 'strangebrew-editor', asset( 'js/editor.js'), $deps, null, true );

	// For now, we're adding translations via PHP. In the future, when our
	// tools catch up, we'll internationalize in the JS files.
	wp_localize_script( 'strangebrew-editor', 'strangebrewEditor', [
		'labels' => [
			'default'      => __( 'Default',   'strangebrew' ),
			'highlight'    => __( 'Highlight', 'strangebrew' )
		]
	] );

	// Enqueue theme editor styles.
	wp_enqueue_style( 'strangebrew-editor', asset( 'css/editor.css' ), null, null );
} );

/**
 * Helper function for outputting an asset URL in the theme. This integrates
 * with Laravel Mix for handling cache busting. If used when you enqueue a script
 * or style, it'll append an ID to the filename.
 *
 * @link   https://laravel.com/docs/5.6/mix#versioning-and-cache-busting
 * @since  0.9.0
 * @access public
 * @param  string  $path  A relative path/file to append to the `dist` folder.
 * @return string
 */
function asset( $path ) {

	// Get the Laravel Mix manifest.
	$manifest = App::resolve( 'strangebrew/mix' );

	// Make sure to trim any slashes from the front of the path.
	$path = '/' . ltrim( $path, '/' );

	if ( $manifest && isset( $manifest[ $path ] ) ) {
		$path = $manifest[ $path ];
	}

	return get_theme_file_uri( 'dist' . $path );
}
