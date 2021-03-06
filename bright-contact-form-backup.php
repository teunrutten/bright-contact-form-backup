<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/teunrutten/
 * @since             1.0.0
 * @package           Bright_Contact_Form_Backup
 *
 * @wordpress-plugin
 * Plugin Name:       Bright Contact Form Backup
 * Plugin URI:        https://github.com/teunrutten/bright-contact-form-backup
 * Description:       This plugin checks for all form submissions and backups the data, it also has an option to remove the data every week/month/year
 * Version:           1.0.0
 * Author:            Teun Rutten
 * Author URI:        https://github.com/teunrutten/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bright-contact-form-backup
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BRIGHT_CONTACT_FORM_BACKUP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bright-contact-form-backup-activator.php
 */
function activate_bright_contact_form_backup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bright-contact-form-backup-activator.php';
	Bright_Contact_Form_Backup_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bright-contact-form-backup-deactivator.php
 */
function deactivate_bright_contact_form_backup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bright-contact-form-backup-deactivator.php';
	Bright_Contact_Form_Backup_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bright_contact_form_backup' );
register_deactivation_hook( __FILE__, 'deactivate_bright_contact_form_backup' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bright-contact-form-backup.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bright_contact_form_backup() {

	$plugin = new Bright_Contact_Form_Backup();
	$plugin->run();

}
run_bright_contact_form_backup();
