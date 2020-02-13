<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://mohiuddinabdulkader.website
 * @since      1.0.0
 *
 * @package    The_Shop_Rental
 * @subpackage The_Shop_Rental/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    The_Shop_Rental
 * @subpackage The_Shop_Rental/includes
 * @author     Mohiuddin Abdul Kader <muhin.cse.diu@gmail.com>
 */
class The_Shop_Rental_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'the-shop-rental',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
