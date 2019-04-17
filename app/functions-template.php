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
function display_featured_image() {

	echo get_featured_image(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Returns the featured image.
 *
 * @since  0.9.0
 * @access public
 * @return string
 */
function get_featured_image() {

	$size = 'strangebrew-medium';

	if ( is_singular() )
		$size = 'featured';

	if ( is_singular( 'portfolio_project' ) )
		$size = 'portfolio-featured';

	$image = get_the_post_thumbnail( get_the_ID(), $size );
    
	return $image ? $image : get_featured_fallback();
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
		'<div class="featured-media"><a href="%s">
			<?xml version="1.0"?>
			<svg class="svg-featured" width="%s" height="%s" viewBox="0 0 748 420">
				<rect class="svg-shape" x="299" y="135" width="150" height="150" transform="rotate(45 374 210)" />
				<text class="svg-icon" x="374" y="210" text-anchor="middle" alignment-baseline="central" dominant-baseline="central">%s</text>
			</svg>
		</a></div>',
		esc_url( get_permalink() ),
		'748px',
		'420px',
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

	echo apply_filters( 'the_content', render_content_before_more( $args ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
	
		return wp_kses_post( $args['before'] ) . $content['main'] . wp_kses_post( $args['after'] );
	}
}
