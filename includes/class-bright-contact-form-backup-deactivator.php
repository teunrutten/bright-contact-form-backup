<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/teunrutten/
 * @since      1.0.0
 *
 * @package    Bright_Contact_Form_Backup
 * @subpackage Bright_Contact_Form_Backup/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Bright_Contact_Form_Backup
 * @subpackage Bright_Contact_Form_Backup/includes
 * @author     Teun Rutten <teun@bureaubright.nl>
 */
class Bright_Contact_Form_Backup_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if ( post_type_exists('bright_submissions') ) {
			unregister_post_type( 'bright_submissions' );
		}
		if ( taxonomy_exists('bright_form_name') ) {
			unregister_taxonomy( 'bright_form_name' );
		}
	}

}
