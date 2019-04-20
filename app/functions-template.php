<?php
/**
 * Template tags.
 *
 * This file holds template tags for the theme. Template tags are PHP functions
 * meant for use within theme templates.
 *
 * @package   Strangebrew
 * @author    David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      http://www.strangebrewdesign.com
 */

namespace Strangebrew;

/**
 * Returns the metadata separator.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $sep  String to separate metadata.
 * @return string
 */
function sep( $sep = '' ) {

	return apply_filters(
		'strangebrew/sep',
		sprintf(
			' <span class="sep">%s</span> ',
			$sep ?: esc_html_x( '&middot;', 'meta separator', 'strangebrew' )
		)
	);
}

/**
 * Displays the featured image.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
function display_featured_image( $args = [] ) {

	echo get_featured_image( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Returns the featured image.
 *
 * @since  0.9.0
 * @access public
 * @param  array $args
 * @return string
 */
function get_featured_image( $args = [] ) {

	$args = wp_parse_args( $args, [
		'size' 		=> ( ! is_singular() ) ? 'post-thumbnail' : 'strangebrew-medium',
		'class' 	=> 'entry__image',
		'before' 	=> ( is_singular() ) ? null : '<a href="' . get_permalink() . '">',
		'after' 	=> ( is_singular() ) ? null : '</a>'
	] );

	$image = get_the_post_thumbnail( 
		get_the_ID(), 
		esc_attr( $args['size'] ), 
		[ 'class' => esc_attr( $args['class'] ) ] 
	);

	if ( empty( $image ) ) {
		$image = get_featured_fallback();
	}
    
	return $args['before'] . $image . $args['after'];
}

/**
 * Returns a SVG icon fallback.  Used when there is no featured image.
 *
 * @since  0.9.0
 * @access public
 * @return string
 */
function get_featured_fallback() {

	if ( is_singular() )
		return;

    $svg = sprintf(
		'<?xml version="1.0"?>
		<svg class="svg-featured" width="480" height="300" viewBox="0 0 480 360">
			<rect class="svg-shape" x="180" y="120" width="120" height="120" transform="rotate(45 240 180)" />
			<text class="svg-icon" x="240" y="180" text-anchor="middle" alignment-baseline="central" dominant-baseline="central">%s</text>
		</svg>',
		get_featured_icon()
	);

	return apply_filters( 'strangebrew/get_featured_fallback', $svg );
}

/**
 * Returns the featured image fallback icon.
 *
 * @since  0.9.0
 * @access public
 * @return string
 */
function get_featured_icon() {

	$options   = map_featured_icons();
	$icon      = $options['standard'];
    $type      = get_post_type();
    
    $icon_keys = array( $type );
    
	if ( post_type_supports( $type, 'post-formats' ) ) {

        $format = get_post_format() ? : 'standard';
        
		$icon_keys[] = "{$type}-{$format}";
		$icon_keys[] = $format;
    }
    
	foreach ( $icon_keys as $i ) {

		if ( isset( $options[ $i ] ) ) {

			$icon = $options[ $i ];
			break;
		}
	}
	
	return apply_filters( 'strangebrew/get_featured_icon', get_font_icon_text( $icon ) );
}

/**
 * Displays the content before the <!--more--> tag.
 *
 * @since  0.9.0
 * @access public
 * @param  array  $args
 * @return void
 */
function display_content_before_more( array $args = [] ) {

	echo render_content_before_more( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Renders the content before the <!--more--> tag.
 *
 * @since  0.9.0
 * @access public
 * @param  array  $args
 * @return string
 */
function render_content_before_more( array $args = [] ) {
	
	// We only need this on single posts.
	if ( ! is_singular() )
		return;

	// Get current post.
	$post = get_post();

	// Wrap output in HTML. 
	$args = wp_parse_args( $args, [
		'before' => '<div class="entry__summary">',
		'after'  => '</div>'
	] );

	// Check the tag is in the content.
	if ( strpos( $post->post_content, '<!--more-->' ) ) {
	
		// Split the content into $content['main] and $content['extended'].
		$content = get_extended( $post->post_content );

		// Apply `the_content()` filter to add p tags etc.
		$content = apply_filters( 'the_content', $content['main'] );
	
		return $args['before'] . $content . $args['after'];
	}
}
