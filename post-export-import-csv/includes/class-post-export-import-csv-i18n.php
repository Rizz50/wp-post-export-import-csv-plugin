<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.cmsminds.com
 * @since      1.0.0
 *
 * @package    Post_Export_Import_Csv
 * @subpackage Post_Export_Import_Csv/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Post_Export_Import_Csv
 * @subpackage Post_Export_Import_Csv/includes
 * @author     Rizwan Shaikh <rizwan@cmsminds.com>
 */
class Post_Export_Import_Csv_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'post-export-import-csv',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
