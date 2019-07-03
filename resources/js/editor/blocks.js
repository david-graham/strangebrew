/**
 * Editor blocks js.
 *
 * This file handles the JavaScript for creating blocks in the editor.
 *
 * @package   Strangebrew
 * @author    David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      http://www.strangebrewdesign.com
 */

const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.editor;

var el = wp.element.createElement;

registerBlockType( 'strangebrew/icon-box', {

	title: 'Icon Box',
	icon: 'lightbulb',
	category: 'common',

	attributes: {

		icon: {
			type: 'string',
			default: 'fa-check fa-3x'
		}
	},

	edit: function( props ) {

		function updateIcon( event ) {
			props.setAttributes( { icon: event.target.value } );
		}

		return el( 'div',
			{
				className: props.className
			},

			el(
				'input', {
					type: 'text',
					placeholder: 'Enter icon here...',
					value: props.attributes.icon,
					onChange: updateIcon,
					style: { width: '100%' }
				}
			),

			el(
				'i', {
					className: 'fa ' + props.attributes.icon,
					'aria-hidden': 'true'
				}
			),

			el( InnerBlocks )
		);
	},

	save: function( props ) {

		return el( 'div', null,

			el(
				'i', {
					className: 'fa ' + props.attributes.icon,
					'aria-hidden': 'true'
				}
			),

			el( InnerBlocks.Content )
		);
	}
});

registerBlockType( 'strangebrew/container', {

	title: 'Container',
	icon: 'editor-table',
	category: 'layout',

	supports: {
		align: [ 'wide', 'full' ]
	},

	edit: function( props ) {

		return el( 'div',
			{
				className: props.className
			},

			el( InnerBlocks )
		);
	},

	save: function( props ) {

		return el( 'div', null,	el( InnerBlocks.Content ) );
	}
});
