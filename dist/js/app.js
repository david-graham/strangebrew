/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

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
(function () {
  /* === Menu toggle. === */
  // Declare our variables at the top.
  var appContent;
  var overlay;
  var scroll;
  var menuButtons;
  var i;
  var isOpen;
  var menuPrimary; // Adds our overlay div.

  appContent = document.querySelector('.app-below__header');
  overlay = document.createElement('div');
  overlay.className = 'site__overlay';
  appContent.insertBefore(overlay, appContent.firstChild); // Assume the initial scroll position is 0.

  scroll = 0; // Wait for a click on one of our menu toggles.

  menuButtons = document.querySelectorAll('.menu__button');

  for (i = 0; i < menuButtons.length; i++) {
    menuButtons[i].onclick = menuToggle;
  }

  function menuToggle() {
    // Assign this (the button that was clicked) to a variable.
    var button = this; // Gets the actual menu (parent of the button that was clicked).

    var menu = button.closest('.menu').querySelector('.menu__items'); // Toggle the selected classes for this menu.

    button.classList.toggle('menu__button--selected');
    menu.classList.toggle('menu__items--visible'); // Is the menu in an open state?

    isOpen = menu.classList.contains('menu__items--visible'); // If the menu is open and there wasn't a menu already open when clicking.

    if (isOpen && !document.body.classList.contains('menu-open')) {
      // Get the scroll position if we don't have one.
      if (0 === scroll) {
        scroll = document.body.scrollTop;
      } // Add a custom body class.


      document.body.classList.add('menu-open'); // If we're closing the menu.
    } else if (!isOpen) {
      document.body.classList.remove('menu-open');
      document.body.scrollTop = scroll;
      scroll = 0;
    }
  } // Close menus when somewhere else in the document is clicked.


  document.onclick = function (event) {
    var button = document.querySelector('.menu__button--selected');
    var menu = document.querySelector('.menu__items--visible');
    document.body.classList.remove('menu-open');

    if (null !== button) {
      button.classList.remove('menu__button--selected');
    }

    if (null !== menu) {
      menu.classList.remove('menu__items--visible');
    }
  }; // Stop propagation if clicking inside of our main menu.


  menuPrimary = document.querySelector('.menu--primary');

  menuPrimary.onclick = function (event) {
    event.stopPropagation();
  };
})();

/***/ }),

/***/ "./resources/scss/customize-controls.scss":
/*!************************************************!*\
  !*** ./resources/scss/customize-controls.scss ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/scss/editor.scss":
/*!************************************!*\
  !*** ./resources/scss/editor.scss ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/scss/screen.scss":
/*!************************************!*\
  !*** ./resources/scss/screen.scss ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!**************************************************************************************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/scss/screen.scss ./resources/scss/editor.scss ./resources/scss/customize-controls.scss ***!
  \**************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Development\WPTheme\wp-content\themes\strangebrew\resources\js\app.js */"./resources/js/app.js");
__webpack_require__(/*! C:\Development\WPTheme\wp-content\themes\strangebrew\resources\scss\screen.scss */"./resources/scss/screen.scss");
__webpack_require__(/*! C:\Development\WPTheme\wp-content\themes\strangebrew\resources\scss\editor.scss */"./resources/scss/editor.scss");
module.exports = __webpack_require__(/*! C:\Development\WPTheme\wp-content\themes\strangebrew\resources\scss\customize-controls.scss */"./resources/scss/customize-controls.scss");


/***/ })

/******/ });
//# sourceMappingURL=app.js.map