/**
 * Customize preview script.
 *
 * This file handles the JavaScript for the live preview frame in the customizer.
 * Any includes or imports should be handled in this file. The final result gets
 * saved back into `dist/js/customize-preview.js`.
 *
 * @package   Strangebrew
 * @author    David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      http://www.strangebrewdesign.com
 */

import { customHeader } from './customize-preview/custom-header';

jQuery( document ).ready( function() {

	// Handles the sticky header.

	wp.customize( 'sticky_header', function( value ) {

		value.bind( function( to ) {

			if ( false === to ) {
				jQuery( 'body' ).removeClass( 'sticky-header' );
			}

			if ( true === to ) {
				jQuery( 'body' ).addClass( 'sticky-header' );
			}

		} ); // value.bind

	} ); // wp.customize

	// Handles the boxed layout option.

	wp.customize( 'boxed_layout', function( value ) {

		value.bind( function( to ) {

			if ( false === to ) {
				jQuery( 'body' ).removeClass( 'layout-boxed' );
			}

			if ( true === to ) {
				jQuery( 'body' ).addClass( 'layout-boxed' );
			}

		} ); // value.bind

	} ); // wp.customize

} ); // jQuery( document ).ready
