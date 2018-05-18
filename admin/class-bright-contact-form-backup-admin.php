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
		add_submenu_page( 'edit.php?post_type=brightsubmissions', 'Instellingen', 'Instellingen', 'manage_options', 'bright-contact-form-backup', function() {
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
		register_setting( 'bright-form-backup-settings', 'bright_form_backup_input_fields' );

		$posts = get_posts(array(
			'post_type'   => 'brightsubmissions',
			'post_status' => 'private',
			'posts_per_page' => -1
			)
		);

		// Register a setting for each available meta key
		if ($posts) {
			$post_meta = get_post_meta( $posts[0]->ID, 'bright_form_data', true );

			foreach($post_meta as $key => $value) {
				if (!strpos($key, '-generated_key_bcfb')) {
					register_setting( 'bright-form-backup-settings', 'bright_form_backup_' . $key );
				}
			}
		}
	}



	// Register a private post type
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
			'menu_name'           => 'BCFB'
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'rewrite'             => array('slug' => ''),
			'description'         => '',
			'taxonomies'          => array('bright_form_name'),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 20,
			'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxhYWdfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA2NDYuNCA0MjAuOCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgNjQ2LjQgNDIwLjgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHN0eWxlPSJmaWxsOiNmZmY7Ij48Zz48cGF0aCBkPSJNMjQ3LjcsMTgzLjRsLTEsMS4yYy0wLjUsMC42LTEuOSwyLTMuOSwzLjljLTcuNSw3LjMtMjMsMjIuNi0yNi40LDI5LjdjLTIuMiw0LjYtMi45LDcuMi0zLjEsMTEuNmMtMC4yLDIuNCwwLjMsNC4zLDEuNCw1LjZjMS40LDEuNiwzLjksMi40LDcuMywyLjRjMi44LDAsNS40LTAuNiw2LjMtMC43YzEyLjgtMi43LDIzLTkuNywzMy4xLTE3LjJjMy40LTIuNiw2LjctNS40LDkuOS04LjFjMC45LTAuOCwxLjgtMS41LDIuNy0yLjNsMS41LTEuM2wtMC41LDEuOWMwLDAuMS0yLjMsOC4xLTMuMiwxMS43bDAsMC4yYy0wLjMsMS4yLDAsMi4xLDAuNCwyLjZjMC42LDAuOSwxLjUsMS4zLDIuMiwxLjRjMS4zLDAuMSwyLjgtMC44LDQuMi0xLjdjMC4xLTAuMSwwLjQtMC4yLDAuNy0wLjRjNy4zLTQuMSwxMC40LTcuOCw5LjMtMTEuMWMtMS0yLjksMC4zLTUuMywxLjctNy44bDAuMy0wLjVjMCwwLDMuNi02LjYsNS4yLTkuNGMxLjctMywzLjUtNi42LDUuMi05LjdsMC45LTEuNmMwLjctMS4zLDAuNC0zLjMtMC42LTQuNWMtMC43LTAuOS0zLjEtMi01LjYtMmMtMi4xLDAtMy45LDAuNy01LjQsMi4yYzAsMC0xNy4xLDE3LjctMjEuMSwyMS45Yy04LjQsOC44LTE4LjYsMTQuNC0yOC40LDE5LjFjLTEuOSwwLjktNC42LDIuMS02LjksMi4xaDBjLTEuNSwwLTIuNi0wLjUtMy4zLTEuNmMtMy4xLTQuOSw3LjQtMTUuMywxMy4xLTIwLjljMC45LTAuOCwxLjYtMS41LDItMmMxLjQtMS41LDQuNS00LjYsNy41LTcuNmMzLjItMy4yLDYuNS02LjUsNy4yLTcuM2MxLjgtMi4xLDMuNy00LjIsNS4xLTYuNGMxLjEtMS43LDEuMi0zLjUsMC40LTQuNmMtMC43LTEtMi0xLjUtMy45LTEuNWMtMS45LDAtNCwwLjQtNi4yLDAuOWMtMi4xLDAuNC00LjEsMC44LTUuOCwwLjhsLTAuMywwYy0xLjIsMC0yLjYtMC41LTQtMC45Yy0xLjUtMC41LTMuMS0xLTQuNy0xLjFjLTMuNC0wLjEtNS4yLDAuMS04LjMsMS41Yy0xMi44LDUuNS0yOC43LDMwLTI5LjcsMzEuNmMtMC40LDAuNy0wLjksMi4yLTEuMSwzLjFjLTAuMSwwLjgsMC4xLDIuOSwxLjMsMy41YzAuOSwwLjQsMS44LDAuNywyLjcsMC43YzQuOSwwLDkuNi02LDExLjctOC41bDAuNC0wLjVjMC41LTAuNiwxMS41LTE1LjIsMTcuNS0xOC43bDAuMi0wLjFjMC42LTAuMiwxLjYsMCwyLjksMC4yYzEuNSwwLjMsMy4zLDAuNiw1LjUsMC42YzAuOCwwLDEuNSwwLDIuMy0wLjFMMjQ3LjcsMTgzLjR6Ii8+PHBhdGggZD0iTTQ1OS40LDkuN2MtNy45LDAtMTUuNCwzLjQtMjIuNywxMC41Yy03LjksNy41LTMxLjgsMzAuNS01OS41LDEyOC42Yy0xLjYsNS41LTMuMiwxMS4xLTQuOSwxN2MtMi41LDguNy01LjEsMTcuNi03LjgsMjcuM2MtNS4zLDE5LjEtOS44LDM2LTEzLjksNTEuNmMtMi4yLDguMy00LjUsMjAuOC0zLDIyLjdjMC43LDEsMS43LDEuNSwyLjgsMS41YzQuOSwwLDEzLTkuMSwxNi45LTE3LjNjMjEuOC00NS4yLDI4LTQ2LjYsMzEuMy00Ny4zYzAuNi0wLjEsMS4xLTAuMiwxLjctMC4yYzQuOCwwLDcuMiw0LjksOS43LDEwYzIuOCw1LjgsNS43LDExLjcsMTIuMiwxMi4zYzEuMywwLjEsMi41LDAuMiwzLjcsMC4yYzYuOSwwLDEzLjMtMS44LDE5LjctNS41YzguMy00LjgsMTQuOC0xMC44LDIwLTE4LjNjMi40LTMuNSwyLjEtNy4yLDEuMS05LjJjLTAuNi0xLjItMS41LTItMi4zLTJjLTAuOCwwLTMuOCwzLTYuNCw1LjZjLTYuMiw2LjEtMTQuNiwxNC41LTIxLjMsMTQuNWwtMC4zLDBjLTUuNS0wLjItOS40LTIuNy0xMi41LTguMWMtMC4xLTAuMi0wLjMtMC41LTAuNS0wLjljLTIuMS00LTcuNy0xNC42LTE4LjktMTQuNmMtNiwwLTExLjIsMi4xLTE1LjksNi41Yy01LjcsNS4zLTEwLjcsMTEuMS0xNS4zLDE3LjdsLTEuOSwyLjhsMC45LTMuM0M0MDIsOTguNSw0MjEuOSw2MS42LDQyNS42LDU1LjNjMC40LTAuNyw0LjItNy40LDkuNy0xNC4xYzcuNy05LjMsMTQuNy0xNCwyMC45LTEzLjdjMTIsMC41LDE1LjIsMTEuNiwxNiwxOC4yYzEuNiwxMi45LTEuMywyNi4xLTkuMiw0MS40Yy02LjUsMTIuNi0xNC43LDI0LjMtMjQuMywzNC43Yy0xLjYsMS43LTQuOCw0LjgtOC42LDguNGMtOC42LDguMi0yNC42LDIzLjYtMjQuMSwyNi41YzAuNSwyLjgsMS4xLDMsMS42LDNjMSwwLDMuNCwwLDEwLTUuM2MxMi4yLTkuOCwyMy42LTIxLDM0LjktMzQuMmMxOC4zLTIxLjMsMzAuNi00OC4zLDMzLjItNTkuOWMzLTEzLjMsMi41LTI0LjItMS4zLTM0LjNjLTIuNy02LjktOC4yLTEyLjMtMTQuOC0xNC42QzQ2Ni4xLDEwLjQsNDYyLjcsOS43LDQ1OS40LDkuNyIvPjxwYXRoIGQ9Ik0zMDQuNiwyMjYuM2MtMy43LDAtNjIuNywyNy40LTc3LjcsMzljLTExLjgsOS4xLTE4LjUsMTguMS0yMi40LDI5LjhjLTUuMywxNS44LTYuNSwzMS4yLTMuNyw0Ni45YzQuNCwyNS40LDE1LjUsNDQuNiwzMi44LDU2LjhjMTMuMSw5LjIsMjcuNCwxMi41LDM1LjYsMTIuNWMwLjMsMCwwLjYsMCwwLjgsMGMxNS45LDAsMzMuNy0zLjksNDUuMS0zMi41YzguNC0yMS41LDE2LjItNjkuNCwyMS45LTEzNC45YzAuMS0xLjIsMC4yLTIuMSwwLjItMi43YzEuMy0xNC42LDQuNi0yNS43LDYuNi0zMi40YzAuOC0yLjgsMS40LTQuOSwxLjUtNS45YzAuMS0xLjQsMC4xLTIuNy0xLTRjLTEtMS4xLTIuMy0xLjQtNC41LTEuMWMtMS4zLDAuMi0yLjQsMC42LTMuNiwxYy0wLjksMC4zLTEuOCwwLjYtMi44LDAuOGMtNS43LDEuMy05LjUsMC45LTEwLjktMS4zYy0xLTEuNi0xLjItMy4zLTAuNi00LjljMS40LTMuOSw3LjItNy43LDE2LjgtMTEuMWwwLjMtMC4xYzAuNC0wLjIsMC45LTAuMywxLjMtMC41YzIuNy0wLjksNS41LTEuOSw2LjMtNGMxLTIuOCwwLjctNC42LTAuOS01LjhjLTAuNi0wLjQtMi4zLTEuNC02LjEtMS40Yy0zLjcsMC04LjIsMS0xMy4yLDIuOWMtMTcuNiw3LTIwLjQsMjMuNy0yMC44LDI4LjdjLTAuMywzLjUsMC45LDguOSwzLjcsMTJjMS43LDEuOCwzLjcsMi43LDYuMSwyLjVjMS41LTAuMSwzLjYtMC45LDUuMi0xLjVjMS4yLTAuNCwxLjctMC42LDIuMS0wLjZoMC4ybDAuMiwwLjFjMC40LDAuMywwLjUsMC40LTIsMzYuMWwtMC41LDcuMmMtMC44LDExLjMtMi4xLDI0LjEtMy40LDM3LjZjLTAuNyw3LjEtMS40LDE0LjUtMi4xLDIxLjZjLTEuMywxMy44LTQuMiwyOS4xLTkuMSw0Ni45Yy0zLjUsMTMtMTQuOSwyNC45LTI2LjQsMjcuOGMtMy40LDAuOC03LjEsMS42LTExLjYsMS42Yy0xMy44LDAtMjYuOS03LjgtMzktMjMuMWMtNS44LTcuNC0xOS45LTMyLjUtMTUuNy02MC40YzMuNS0yMy4yLDE3LjgtMzcuMSwyOS4yLTQ0LjZjMjIuMS0xNC43LDQxLjMtMjMuNiw1Mi43LTI5YzYuMy0yLjksMTEuNy01LjUsMTEuOS02LjRjMC0wLjMtMC4xLTEuNy0wLjktMi43QzMwNS44LDIyNi43LDMwNS4zLDIyNi40LDMwNC42LDIyNi4zIi8+PHBhdGggZD0iTTMwNy45LDE1NS40Yy0zLjIsMC01LjgsMC45LTcuNiwyLjhjLTMsMy0zLDcuNi0zLDcuNmMwLjEsMC45LDAuMywxLjYsMC44LDIuMWMxLjMsMS40LDQuMywyLjEsNi41LDIuMWMxLjEsMCwyLTAuMiwyLjctMC42YzMuOC0yLjIsNi44LTQuMSw5LjQtNS45YzEuMS0wLjcsMS44LTIuNCwxLjYtMy44Yy0wLjItMS4zLTMtMy40LTguNi00LjJDMzA5LjEsMTU1LjUsMzA4LjUsMTU1LjQsMzA3LjksMTU1LjQiLz48cGF0aCBkPSJNNTEzLjcsODQuOGMtMi44LDAtNywxLjQtMTAuOCw3LjljLTQuMiw3LjItMTEuMSwzMC4zLTE5LjQsNjVsLTAuNCwxLjdsLTAuNCwwLjFjLTcuNSwxLTEzLjksMS45LTE1LjEsNC4zYy0wLjEsMC40LTAuMSwwLjgsMC4yLDEuMWMxLjYsMi4zLDkuNiwzLjEsMTIuNSwzLjJsMC43LDBsLTAuMiwwLjdjLTEuMiw1LjMtMi4zLDEwLjEtMy4yLDE0LjhjLTIuNiwxMy00LjgsMjYuMi03LDM5Yy0yLjEsOC45LTQuMiwyMy42LTEuMiwyNS4yYzEsMC41LDEuOSwwLjgsMi44LDAuOGMyLjksMCw0LjktMi42LDYuNC00LjZsMC41LTAuNmM1LjQtNi44LDcuMS0yMi44LDguNy0zOC4zYzEuMS0xMC44LDIuMy0yMS45LDQuNy0zMGMwLjUtMS43LDEuNy03LDEuNy03LjFsMC4xLTAuNGwwLjQsMGMwLjYsMCw2My42LTQuNSw3NS4zLTUuMmMxMy42LTAuOCw1Mi41LTMuNCw1OC4yLTMuOWM1LjctMC41LDcuNi0xLjEsOC42LTIuM2MwLjUtMS40LDAuNS0yLjYtMS40LTQuM2MtMi0xLjgtNC43LTMuNS04LTVjLTMuMi0xLjUtNi43LTIuOS0xMC42LTMuN2MtMS40LTAuMy0zLjItMC40LTUuNC0wLjRjLTEwLjEsMC0yNi41LDMtMzYuMyw0LjdjLTEuOSwwLjMtMy42LDAuNy01LDAuOWMtMy42LDAuNi01LjcsMS03LjYsMS40Yy0zLjIsMC42LTUuNSwxLTEzLjQsMi4yYy05LjYsMS41LTMyLjgsNC4xLTUyLDYuM2wtMC45LDAuMWwwLjItMC44YzMuNy0xNS42LDcuNS0yOS44LDExLjUtNDMuNGMwLjEtMC41LDMuNC0xMiw5LjUtMTcuNmMyLjgtMi41LDQuMy00LjcsMy4zLTcuNUM1MjAuNyw4Ny40LDUxNy43LDg0LjgsNTEzLjcsODQuOCIvPjxwYXRoIGQ9Ik0yMDkuNyw1NC41Yy0yLjMsNC42LTEzLjYsMjAuMy0yNS45LDMyLjRjLTAuMiwwLjItMjAuNSwyMC4yLTMwLjcsMjkuNWMtMTMuMiwxMi0zOC41LDMxLjQtNDEuNiwzMmwtMSwwLjJsMC40LTFjMC4xLTAuMywwLjMtMC45LDAuNi0xLjhjMS43LTUuMSw1LjgtMTcsOS4xLTIyLjdjNy43LTEzLjEsMTkuMi0zMC4zLDM5LjItNDcuM2MyMC40LTE3LjIsMzUuNi0yNi40LDQ1LjEtMjcuMmMyLjktMC4yLDQuMiwwLjksNC44LDEuOEMyMTAuNCw1MS41LDIxMC40LDUzLjEsMjA5LjcsNTQuNSBNMTYyLjIsMTczLjRsMSwwYzE4LjQsMCwyOS40LDksMzAuNCwxNGMyLjgsMTQuNy00Ni4zLDM4LTY1LjQsNDQuM2MtMjAuNiw2LjktNDYuNCwxMC44LTUwLjgsMTAuOGMtMC41LDAtMC44LTAuMS0wLjktMC4xbC0wLjItMC4xbC0wLjEtMC4zYy0wLjEtMC40LTAuMy0xLjMsMTMuMy0zNy4yYzYuMy0xNi43LDEzLjUtMzUuNSwxMy42LTM1LjdsMC43LTAuM0MxMTUuOSwxNzMuMiwxNTQuNSwxNzMuNCwxNjIuMiwxNzMuNCBNMjI2LjYsMzQuMWMtNC4xLTQuNC0xMS42LTUuNC0yMS43LTIuOGMtMTQuMSwzLjYtMjUuMSwxMi4zLTM1LjcsMjAuNmMtMSwwLjgtMiwxLjYtMywyLjNjLTE2LjMsMTIuNy0zOS4zLDQxLjMtNDEuNiw0NC4ybDAuMiwwLjZsLTEtMC4xbC0wLjItMC4xYy0wLjktMC42LTMuMy0yLTUuOS0yYy0yLjcsMC05LDEuNy0xMC43LDE1LjljLTAuMSwxLjEtMi4zLDEyLjktNCwxNy4xYy0wLjgsMS45LTQuNywxMC05LjYsMjAuMmMtNy45LDE2LjMtMTguNiwzOC41LTIyLDQ2LjZjLTQuOSwxMS45LTExLjIsMjcuNi0xNi4yLDQ0LjFjLTEuMiwzLjktNC4yLDYtMTAuMiw2LjlsLTEuNiwwLjJsMS4xLTEuMmMxLTEuMSwyLTIuMywzLTMuNWwwLjctMC44YzUuMS01LjgsNC41LTYuNywzLjYtOC4xbC0wLjItMC4zYy0wLjQtMC43LTEuMy0xLTIuNS0xYy02LjQsMC0xOS45LDguMi0yNywxMy4xYy0xLjYsMS4xLTUuNSw0LTcuNyw3LjdjLTMuMiw1LjMtMy45LDEwLjItMiwxNGMwLjYsMS4yLDIuOCwyLDUuNSwyYzAuNSwwLDEsMCwxLjUtMC4xbDEuNS0wLjJjNy0wLjksMTMuNi0xLjcsMjIuNi0zLjJjMC43LTAuMSwxLjQtMC4yLDItMC4yYzEuNiwwLDIuNiwwLjQsMy4yLDEuM2MwLjgsMS4xLDAuMywyLjUsMC4zLDIuNmMwLDAuNC0wLjEsMC45LTAuMiwxLjRjLTAuMywxLjItMC41LDIuNC0wLjIsMy45YzAuNSwyLjMsMy41LDIuOSw0LjcsMi45bDAuMSwwLjZWMjc4YzIuMiwwLDYuOC0xLjcsMTIuNC0xMy4yYzAuOS0xLjksMS43LTIuOCw0LjktMy40YzAuMywwLDI1LjEtNC42LDM0LjItNi43YzE0LjktMy42LDMwLjgtOS4zLDQ4LjYtMTcuNGM0NC4xLTIwLjIsNTcuMS00OS42LDU3LjItNDkuOWMyLjUtNi44LDEuNy0xMi41LTIuNS0xNy41Yy0zLjItMy45LTcuMi02LjgtMTItOC42Yy0xMi45LTUtMjYuMy01LjgtMzkuMy02LjZjMCwwLTkuMi0wLjUtMTMtMC44Yy00LjgtMC4zLTE0LjUtMS4xLTE0LjYtMS4xbC0xLjQtMC4xbDEtMC45YzIuOC0yLjUsNS43LTQuOSw4LjUtNy40bDAuOS0wLjhjNS41LTQuNywxMS4yLTkuNiwxNi43LTE0LjdjMTEuNC0xMC42LDI2LjQtMjQuNyw0MS4zLTM5LjRjMTIuOS0xMi44LDIxLjUtMjMuNiwyNy45LTM0LjhsMC40LTAuN2MyLTMuNiw0LjYtOCw0LjktMTMuM0MyMjkuNSwzOS44LDIyOS4xLDM2LjgsMjI2LjYsMzQuMSIvPjwvZz48L3N2Zz4=',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => false,
			'can_export'          => true,
			'capability_type'			=> 'post',
			'supports' 						=> array(
				'title'
			)
		);

		register_post_type('brightsubmissions', $args);

		// Add filter and action to add new admin columns
		add_filter("manage_edit-brightsubmissions_columns", 'add_custom_admin_column' );
		add_action('manage_brightsubmissions_posts_custom_column', 'bright_add_custom_column', 10, 2);

		function add_custom_admin_column($columns) {
			$posts = get_posts(array(
		    'post_type'   => 'brightsubmissions',
		    'post_status' => 'private',
		    'posts_per_page' => -1
			  )
			);


			$post_meta = get_post_meta( $posts[0]->ID, 'bright_form_data', true );
			foreach ($post_meta as $key => $value) {
				if (!strpos($key, '-generated_key_bcfb')) {
					if (esc_attr( get_option('bright_form_backup_' . $key) ) === 'on') {
						$columns[$key] = $key;
					}
				}
			}

      return $columns;
		}

		function bright_add_custom_column($column, $post_id) {
			global $post;
			require_once plugin_dir_path( __FILE__ ) . 'class-bright-contact-form-backup-admin-cryption.php';

			$post_meta = get_post_meta( $post_id, 'bright_form_data', true );
			foreach($post_meta as $key => $value) {
				if (!strpos($key, '-generated_key_bcfb')) {
					$cryptor = new Bright_Contact_Form_Backup_Admin_Cryption;
					$decrypted = $cryptor->decrypt($value, $post_meta[$key . '-generated_key_bcfb']);

					if ($column === $key) {
						if (esc_attr( get_option('bright_form_backup_' . $key) ) === 'on') {
							if ($key === 'file_location') {
								$decrypted = '<a href="' . $decrypted . '" target="_blank">' . $decrypted . '</a>';
							}
							echo $decrypted;
						}
					}
				}

			}
		}
	}

	public static function bright_register_taxonomy () {

		$labels = array(
			'name'              => 'Formulier',
			'singular_name'     => 'Formulier',
			'search_items'      => 'Zoek Formulieren',
			'all_items'         => 'Alle Formulieren',
			'edit_item'         => 'Wijzig Formulier',
			'add_new_item'      => 'Nieuw Formulier',
			'new_item_name'     => 'Nieuw Formulier',
			'menu_name'         => 'Formulier',
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'public'            => false,
			'rewrite'			      => false
		);

		register_taxonomy( 'bright_form_name', array( 'brightsubmissions' ), $args );
	}

	public static function bright_create_meta_box() {
		require_once plugin_dir_path( __FILE__ ) . 'class-bright-contact-form-backup-admin-metabox.php';
		$metabox = new Bright_Contact_Form_Backup_Admin_Metabox();
	}

	// Hook triggered when form is submitted
	public static function bright_create_form_submission ($post) {
		$post = $_POST;

		require_once plugin_dir_path( __FILE__ ) . 'class-bright-contact-form-backup-admin-cryption.php';

		$post_content = array();

		$input_fields = esc_attr( get_option('bright_form_backup_input_fields') );

		$input_fields = ($input_fields !== '') ? explode(',', $input_fields) : array();

		foreach($input_fields as $key => $field) {
			if (isset( $_FILES[$field]['name'] ) && ! empty( $_FILES[$field]['name'] )) {
				if (file_exists( WP_CONTENT_DIR . '/uploads/tmp/' . $_FILES[$field]['name'] )) {
					$upload_dir = wp_upload_dir();
					$post['file_location'] = $upload_dir['baseurl'] . '/tmp/' . $_FILES[$field]['name'];
					$post['file_name'] = $_FILES[$field]['name'];
				} else {
					$post['file_location'] = '';
					$post['file_name'] = $_FILES[$field]['name'];
				}
			}
		}

		// // Check if a file is posted, and if the file excists, if so, set location as meta data
		// if (isset( $_FILES['bestand']['name'] ) && ! empty( $_FILES['bestand']['name'] )) {
		// 	if (file_exists( WP_CONTENT_DIR . '/uploads/tmp/' . $_FILES['bestand']['name'] )) {
		// 		$upload_dir = wp_upload_dir();
		// 		$post['file_location'] = $upload_dir['baseurl'] . '/tmp/' . $_FILES['bestand']['name'];
		// 		$post['file_name'] = $_FILES['bestand']['name'];
		// 	} else {
		// 		$post['file_location'] = '';
		// 		$post['file_name'] = $_FILES['bestand']['name'];
		// 	}
		// }
		//
		// // Check if a file is posted, and if the file excists, if so, set location as meta data
		// if (isset( $_FILES['bestand_2']['name'] ) && ! empty( $_FILES['bestand_2']['name'] )) {
		// 	if (file_exists( WP_CONTENT_DIR . '/uploads/tmp/' . $_FILES['bestand_2']['name'] )) {
		// 		$upload_dir = wp_upload_dir();
		// 		$post['file_location'] = $upload_dir['baseurl'] . '/tmp/' . $_FILES['bestand_2']['name'];
		// 		$post['file_name'] = $_FILES['bestand_2']['name'];
		// 	} else {
		// 		$post['file_location'] = '';
		// 		$post['file_name'] = $_FILES['bestand_2']['name'];
		// 	}
		// }
		//
		// // Check if a file is posted, and if the file excists, if so, set location as meta data
		// if (isset( $_FILES['bestand_3']['name'] ) && ! empty( $_FILES['bestand_3']['name'] )) {
		// 	if (file_exists( WP_CONTENT_DIR . '/uploads/tmp/' . $_FILES['bestand_3']['name'] )) {
		// 		$upload_dir = wp_upload_dir();
		// 		$post['file_location'] = $upload_dir['baseurl'] . '/tmp/' . $_FILES['bestand_3']['name'];
		// 		$post['file_name'] = $_FILES['bestand_3']['name'];
		// 	} else {
		// 		$post['file_location'] = '';
		// 		$post['file_name'] = $_FILES['bestand_3']['name'];
		// 	}
		// }

		// Cleanup the form data
		foreach ( $post as $key => $value ) {
			$clean = sanitize_text_field($value);
			$cryptor = new Bright_Contact_Form_Backup_Admin_Cryption;
			$uniqiv = bin2hex($cryptor->iv()) ? bin2hex($cryptor->iv()) : '';
			$post_content[$key . '-generated_key_bcfb'] = $uniqiv;
      $post_content[$key] = $cryptor->encrypt($clean, $uniqiv) ? $cryptor->encrypt($clean, $uniqiv) : '';
		}

		// Create tax term if does not exist yet
		$post['form_title'] = isset($post['form_title']) ? $post['form_title'] : 'onbekend';
		// $post['form_title'] = 'Onbekend';

		$tax = term_exists( $post['form_title'], 'bright_form_name' );

		if ( !$tax ) {
			$tax = wp_insert_term( $post['form_title'], 'bright_form_name' );
		}

		$new_post = array(
	    'post_title' => 'Inzending #' . uniqid(),
	    'post_status' => 'private',
	    'post_author' => 1,
	    'post_type' => 'brightsubmissions'
    );

		// Insert post and retrieve post_ID
		$post_id = wp_insert_post( $new_post );

		// Inset the post meta into the post
		if ($post_id !== 0) {
			add_post_meta( $post_id, 'bright_form_data', $post_content );
			wp_set_post_terms($post_id, array( $tax['term_taxonomy_id'] ), 'bright_form_name');
		}
	}

	// Remove the submit box
	public static function bright_remove_publish_box() {
		remove_meta_box( 'submitdiv', 'brightsubmissions', 'side' );
	}


}
