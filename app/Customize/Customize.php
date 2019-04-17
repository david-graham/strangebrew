<?php
/**
 * Customize class.
 *
 * This file shows some basics on how to set up and work with the WordPress
 * Customization API. This is the place to set up all of your theme options for
 * the customizer.
 *
 * @package   Strangebrew
 * @author    David Graham <david.graham@strangebrewdesign.com>
 * @copyright 2018 David Graham
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      http://www.strangebrewdesign.com
 */

namespace Strangebrew\Customize;

use WP_Customize_Manager;
use Hybrid\Contracts\Bootable;
use function Strangebrew\asset;

/**
 * Handles setting up everything we need for the customizer.
 *
 * @link   https://developer.wordpress.org/themes/customize-api
 * @since  0.9.0
 * @access public
 */
class Customize implements Bootable {

	/**
	 * Adds actions on the appropriate customize action hooks.
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', [ $this, 'registerPanels'   ] );
		add_action( 'customize_register', [ $this, 'registerSections' ] );
		add_action( 'customize_register', [ $this, 'registerSettings' ] );
		add_action( 'customize_register', [ $this, 'registerControls' ] );
		add_action( 'customize_register', [ $this, 'registerPartials' ] );

		// Enqueue scripts and styles.
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'controlsEnqueue'] );
		add_action( 'customize_preview_init', [ $this, 'previewEnqueue' ] );
	}

	/**
	 * Callback for registering panels.
	 *
	 * @link   https://developer.wordpress.org/themes/customize-api/customizer-objects/#panels
	 * @since  0.9.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager  Instance of the customize manager.
	 * @return void
	 */
	public function registerPanels( WP_Customize_Manager $manager ) {}

	/**
	 * Callback for registering sections.
	 *
	 * @link   https://developer.wordpress.org/themes/customize-api/customizer-objects/#sections
	 * @since  0.9.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager  Instance of the customize manager.
	 * @return void
	 */
	public function registerSections( WP_Customize_Manager $manager ) {}

	/**
	 * Callback for registering settings.
	 *
	 * @link   https://developer.wordpress.org/themes/customize-api/customizer-objects/#settings
	 * @since  0.9.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager  Instance of the customize manager.
	 * @return void
	 */
	public function registerSettings( WP_Customize_Manager $manager ) {

		// Update the `transform` property of core WP settings.
		$settings = [
			$manager->get_setting( 'blogname' ),
			$manager->get_setting( 'blogdescription' ),
			$manager->get_setting( 'header_textcolor' ),
			$manager->get_setting( 'header_image' ),
			$manager->get_setting( 'header_image_data' )
		];

		array_walk( $settings, function( &$setting ) {
			$setting->transport = 'postMessage';
		} );

		// Adds the header icon setting.
		$manager->add_setting(
			'header_icon',
			array(
				'type'                 => 'theme_mod',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'esc_attr',
				'sanitize_js_callback' => 'esc_attr',
				'transport'            => 'postMessage',
			)
		);

		// Adds the sticky header setting
		$manager->add_setting(
			'sticky_header',
			array(
				'type'                 => 'theme_mod',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'sanitize_key',
				'sanitize_js_callback' => 'sanitize_key',
				'transport'            => 'postMessage',
			)
		);

		// Adds the sticky header setting
		$manager->add_setting(
			'boxed_layout',
			array(
				'type'                 => 'theme_mod',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'sanitize_key',
				'sanitize_js_callback' => 'sanitize_key',
				'transport'            => 'postMessage',
			)
		);
	}

	/**
	 * Callback for registering controls.
	 *
	 * @link   https://developer.wordpress.org/themes/customize-api/customizer-objects/#controls
	 * @since  0.9.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager  Instance of the customize manager.
	 * @return void
	 */
	public function registerControls( WP_Customize_Manager $manager ) {

		// Adds the header icon control.
		$manager->add_control(
			'header_icon',
			array(
				'label'    => __( 'Header Icon', 'strangebrew' ),
				'section'  => 'title_tagline',
				'type'     => 'select',
				'choices'  => \Strangebrew\get_font_icons_text()
			)
		);

		// Adds the sticky header control
		$manager->add_control(
			'sticky_header',
			array(
				'label'    => __( 'Sticky Header', 'strangebrew' ),
				'section'  => 'title_tagline',
				'type'     => 'checkbox'
			)
		);

		// Adds the sticky header control
		$manager->add_control(
			'boxed_layout',
			array(
				'label'    => __( 'Boxed Layout', 'strangebrew' ),
				'section'  => 'title_tagline',
				'type'     => 'checkbox'
			)
		);


	}

	/**
	 * Callback for registering partials.
	 *
	 * @link   https://developer.wordpress.org/themes/customize-api/tools-for-improved-user-experience/#selective-refresh-fast-accurate-updates
	 * @since  0.9.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager  Instance of the customize manager.
	 * @return void
	 */
	public function registerPartials( WP_Customize_Manager $manager ) {

		// If the selective refresh component is not available, bail.
		if ( ! isset( $manager->selective_refresh ) ) {
			return;
		}

		// Selectively refreshes the title in the header when the core
		// WP `blogname` setting changes.
		$manager->selective_refresh->add_partial( 'blogname', [
			'selector'        => '.app-header__title-link',
			'render_callback' => function() {
				return get_bloginfo( 'name', 'display' );
			}
		] );

		// Selectively refreshes the description in the header when the
		// core WP `blogdescription` setting changes.
		$manager->selective_refresh->add_partial( 'blogdescription', [
			'selector'        => '.app-header__description',
			'render_callback' => function() {
				return get_bloginfo( 'description', 'display' );
			}
		] );

		// Selectively refreshes the custom header if it doesn't support
		// videos. Core WP won't properly refresh output from its own
		// `the_custom_header_markup()` function unless video is supported.
		if ( ! current_theme_supports( 'custom-header', 'video' ) ) {

			$manager->selective_refresh->add_partial( 'header_image', [
				'selector'            => '#wp-custom-header',
				'render_callback'     => 'the_custom_header_markup',
				'container_inclusive' => true,
			] );
		}

		// Selectively refreshes the logo icon in the header
		$manager->selective_refresh->add_partial( 'header_icon', [
			'selector'       		=> '.app-header__icon-link',
			'render_callback'		=> 'Strangebrew\display_logo_icon',
			'container_inclusive' 	=> true
		] );
	}

	/**
	 * Register or enqueue scripts/styles for the controls that are output
	 * in the controls frame.
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	public function controlsEnqueue() {

		wp_enqueue_script(
			'strangebrew-customize-controls',
			asset( 'js/customize-controls.js' ),
			[ 'customize-controls' ],
			null,
			true
		);

		wp_enqueue_style(
			'strangebrew-customize-controls',
			asset( 'css/customize-controls.css' ),
			[],
			null
		);

		wp_enqueue_style( 'font-awesome',
			asset( 'css/font-awesome.min.css' ),
			[],
			null
		);
	}

	/**
	 * Register or enqueue scripts/styles for the live preview frame.
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	public function previewEnqueue() {

		wp_enqueue_script(
			'strangebrew-customize-preview',
			asset( 'js/customize-preview.js' ),
			[ 'customize-preview' ],
			null,
			true
		);
	}
}
