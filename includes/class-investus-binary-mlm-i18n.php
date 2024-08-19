<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://asecc2021.com/andrew-normore
 * @since      1.0.0
 *
 * @package    investus_binary_mlm
 * @subpackage investus_binary_mlm/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    investus_binary_mlm
 * @subpackage investus_binary_mlm/includes
 * @author     Andrew Normore <andy@asecc2021.com>
 */
class investus_binary_mlm_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'investus-binary-mlm',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
