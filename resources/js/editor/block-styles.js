/**
 * Editor block styles.
 *
 * This file handles the JavaScript for creating block styles in the editor.
 *
 * @package Strangebrew
 * @author David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link http://www.strangebrewdesign.com
 */

 // WordPress dependencies.
// const { __ } = wp.i18n;

wp.domReady( () => {

	// Passthrough translated labels.

	let labels = strangebrewEditor.labels;

	// Heading styles.

	wp.blocks.registerBlockStyle( 'core/heading', {
		name: 'default',
		label: labels.default,
		isDefault: true
	} );

	wp.blocks.registerBlockStyle( 'core/heading', {
		name: 'large',
		label: labels.large
	} );

	// Paragraph styles.

	wp.blocks.registerBlockStyle( 'core/paragraph', {
		name: 'default',
		label: labels.default,
		isDefault: true
	} );

	wp.blocks.registerBlockStyle( 'core/paragraph', {
		name: 'alternate',
		label: labels.alternate
	} );
} );
