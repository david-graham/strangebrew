/**
 * Primary front-end script.
 *
 * Primary JavaScript file. Any includes or anything imported should
 * be filtered through this file and eventually saved back into the
 * `/dist/js/app.js` file.
 *
 * @package   Strangebrew
 * @author    David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      http://www.strangebrewdesign.com
 */

/**
 * A simple immediately-invoked function expression to kick-start
 * things and encapsulate our code.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
(function() {

	/* === Menu toggle. === */

	// Declare our variables at the top.
	var appContent;
	var overlay;
	var scroll;
	var menuButtons;
	var i;
	var isOpen;
	var menuPrimary;

	// Adds our overlay div.
	appContent = document.querySelector( '.app-below__header' );
	overlay    = document.createElement( 'div' );

	overlay.className = 'site__overlay';

	appContent.insertBefore( overlay, appContent.firstChild );

	// Assume the initial scroll position is 0.
	scroll = 0;

	// Wait for a click on one of our menu toggles.
	menuButtons = document.querySelectorAll( '.menu__button' );

	for ( i = 0; i < menuButtons.length; i++ ) {

		menuButtons[ i ].onclick = menuToggle;
	}

	function menuToggle() {

		// Assign this (the button that was clicked) to a variable.
		var button = this;

		// Gets the actual menu (parent of the button that was clicked).
		var menu = button.closest( '.menu' ).querySelector( '.menu__items' );

		// Toggle the selected classes for this menu.
		button.classList.toggle( 'menu__button--selected' );
		menu.classList.toggle( 'menu__items--visible' );

		// Is the menu in an open state?
		isOpen = menu.classList.contains( 'menu__items--visible' );

		// If the menu is open and there wasn't a menu already open when clicking.
		if ( isOpen && ! document.body.classList.contains( 'menu-open' ) ) {

			// Get the scroll position if we don't have one.
			if ( 0 === scroll ) {
				scroll = document.body.scrollTop;
			}

			// Add a custom body class.
			document.body.classList.add( 'menu-open' );

		// If we're closing the menu.
		} else if ( ! isOpen ) {

			document.body.classList.remove( 'menu-open' );
			document.body.scrollTop = scroll;
			scroll = 0;
		}
	}

	// Close menus when somewhere else in the document is clicked.
	document.onclick = function( event ) {

		var button = document.querySelector( '.menu__button--selected' );
		var menu   = document.querySelector( '.menu__items--visible' );

		document.body.classList.remove( 'menu-open' );

		if ( null !== button ) {
			button.classList.remove( 'menu__button--selected' );
		}

		if ( null !== menu ) {
			menu.classList.remove( 'menu__items--visible' );
		}
	};

	// Stop propagation if clicking inside of our main menu.
	menuPrimary = document.querySelector( '.menu--primary' );

	menuPrimary.onclick = function( event ) {

		event.stopPropagation();
	};

})();
