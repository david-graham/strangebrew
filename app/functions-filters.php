<?php
/**
 * Functions that hook into filters to modify default theme behaviour.
 *
 * @package   Strangebrew
 * @author    David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      http://www.strangebrewdesign.com
 */

namespace Strangebrew;

/**
 * Filter the body class for some of our theme options.
 *
 * @since  0.9.0
 * @access public
 * @param  array $classes
 * @return array
 */

add_filter( 'body_class', 'Strangebrew\filter_body_class' );

function filter_body_class( $classes ) {
	
	// Sticky header.
	if ( get_theme_mod( 'sticky_header' ) == true ) {
		$classes[] = 'sticky-header';
	}

	// Boxed layout.
	if ( get_theme_mod( 'boxed_layout' ) == true ) {
		$classes[] = 'layout-boxed';
	}

	// Wide & narrow content widths.
	if ( is_page_template( 'template-landing-page.php' ) || is_singular( 'portfolio_project') ) {
		$classes[] = 'layout-wide';
	} else {
		$classes[] = 'layout-narrow';
	}

	// Post meta overrides.
	if ( metadata_exists( 'post', get_the_id(), 'strangebrew_boxed_layout' ) ) {

		$classes = array_diff( $classes, array( 'layout-boxed' ) );

		( get_post_meta( get_the_id(), 'strangebrew_boxed_layout', true ) == true ) ? $classes[] = 'layout-boxed' : null;
	}
	
	return $classes;
}

/**
 * Filter the admin body class to add context to editor.
 *
 * @since  0.9.0
 * @access public
 * @param  string $classes
 * @return string
 */
add_filter( 'admin_body_class', 'Strangebrew\filter_admin_body_class' );

function filter_admin_body_class( $classes ) {

	// Declare the global post object.
	global $post;

	// Get $screen object.
	$screen = get_current_screen();

	// Make sure we're on the edit post screen.
	if ( $screen->parent_base != 'edit' )
		return;

	// Get template post meta.
	$template = get_post_meta( $post->ID, '_wp_page_template', true );

	// Wide & narrow content widths.
	if ( isset( $template ) && $template == 'template-landing-page.php' ) {
		$classes .= " page-template-landing-page";
	}

	return $classes;
}

/**
 * Wraps embeds with `.embed__wrapper` class.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $html
 * @return string
 */
function wrap_embed( $html ) {

	return $html && is_string( $html ) ? sprintf( '<div class="embed__wrapper">%s</div>', $html ) : $html;
}

/**
 * Checks embed URL patterns to see if they should be wrapped in some special HTML, particularly
 * for responsive videos.
 *
 * @author     Automattic
 * @link       http://jetpack.me
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @since  0.9.0
 * @access public
 * @param  string  $html
 * @param  string  $url
 * @return string
 */

add_filter( 'embed_oembed_html', 'strangebrew\detect_embed_video', 10, 2 );

function detect_embed_video( $html, $url ) {

	$post = get_post();
	$content = $post->post_content;

	if ( ! $html || ! is_string( $html ) || ! $url || strpos( $content, '<!-- wp:' ) !== false )
		return $html;

	$do_wrap = false;

	$patterns = array(
		'#http://((m|www)\.)?youtube\.com/watch.*#i',
		'#https://((m|www)\.)?youtube\.com/watch.*#i',
		'#http://((m|www)\.)?youtube\.com/playlist.*#i',
		'#https://((m|www)\.)?youtube\.com/playlist.*#i',
		'#http://youtu\.be/.*#i',
		'#https://youtu\.be/.*#i',
		'#https?://(.+\.)?vimeo\.com/.*#i',
		'#https?://(www\.)?dailymotion\.com/.*#i',
		'#https?://dai.ly/*#i',
		'#https?://(www\.)?hulu\.com/watch/.*#i',
		'#https?://wordpress.tv/.*#i',
		'#https?://(www\.)?funnyordie\.com/videos/.*#i',
		'#https?://vine.co/v/.*#i',
		'#https?://(www\.)?collegehumor\.com/video/.*#i',
		'#https?://(www\.|embed\.)?ted\.com/talks/.*#i'
	);

	$patterns = apply_filters( 'strangebrew/detect_embed_video_patterns', $patterns );

	foreach ( $patterns as $pattern ) {

		$do_wrap = preg_match( $pattern, $url );

		if ( $do_wrap )
			return wrap_embed( $html );
	}

	return $html;
}
