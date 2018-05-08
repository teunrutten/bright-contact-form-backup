<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/teunrutten/
 * @since      1.0.0
 *
 * @package    Bright_Contact_Form_Backup
 * @subpackage Bright_Contact_Form_Backup/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Bright_Contact_Form_Backup
 * @subpackage Bright_Contact_Form_Backup/includes
 * @author     Teun Rutten <teun@bureaubright.nl>
 */
class Bright_Contact_Form_Backup_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bright-contact-form-backup',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
