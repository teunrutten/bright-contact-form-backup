<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/teunrutten/
 * @since      1.0.0
 *
 * @package    Bright_Contact_Form_Backup
 * @subpackage Bright_Contact_Form_Backup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bright_Contact_Form_Backup
 * @subpackage Bright_Contact_Form_Backup/admin
 * @author     Teun Rutten <teun@bureaubright.nl>
 */
class Bright_Contact_Form_Backup_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bright_Contact_Form_Backup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bright_Contact_Form_Backup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bright-contact-form-backup-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bright_Contact_Form_Backup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bright_Contact_Form_Backup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bright-contact-form-backup-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the options page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public static function bright_options_page() {
		add_options_page( 'Bright - Form Backup', 'Bright - Form Backup', 'manage_options', 'bright-contact-form-backup', function() {
			include(plugin_dir_path( __FILE__ ) . 'partials/bright-contact-form-backup-admin-display.php');
		} );
	}

	/**
	 * Register the settings.
	 *
	 * @since    1.0.0
	 */
	public static function bright_register_settings() {
		// Add the default settings
		register_setting( 'bright-form-backup-settings', 'bright_form_backup_period' );
	}

	public static function bright_register_post_type () {
		$labels = array(
			'name'                => 'Bright - Inzendingen',
			'singular_name'       => 'Inzending',
			'add_new'             => 'Nieuwe Inzending',
			'add_new_item'        => 'Nieuwe Inzending',
			'edit_item'           => 'Wijzig Inzending',
			'new_item'            => 'Nieuwe Inzending',
			'view_item'           => 'Bekijk Inzending',
			'search_items'        => 'Zoek Inzendingen',
			'not_found'           => 'Geen Inzending gevonden',
			'not_found_in_trash'  => 'Geen Inzending gevonden in prullenbak',
			'menu_name'           => 'Inzendingen'
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'rewrite'             => array('slug' => ''),
			'description'         => '',
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-archive',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true
		);

		register_post_type('bright_submissions', $args);
	}

	public static function bright_create_meta_box() {
		require_once plugin_dir_path( __FILE__ ) . 'class-bright-contact-form-backup-admin-metabox.php';
		$metabox = new Bright_Contact_Form_Backup_Admin_Metabox();
	}

	public static function bright_create_form_submission ($post) {
		foreach ( $post as $key => $value ) {
			// Do something here
		}
	}

}
