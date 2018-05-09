<?php

/**
 * The metabox for formsubmission data.
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
class Bright_Contact_Form_Backup_Admin_Metabox {

	public function __construct() {
    add_action( 'load-post.php', array( $this, 'init_metabox' ) );
    add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
	}

  /**
    * Meta box initialization.
    */
   public function init_metabox() {
     add_action( 'add_meta_boxes', array( $this, 'add_metabox'  ) );
     add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );
   }

   /**
     * Adds the meta box.
     */
    public function add_metabox() {
      add_meta_box(
        'bright_submissions_metabox',
        'Inzendingen veld',
        array( $this, 'render_metabox' ),
        'bright_submissions',
        'normal',
        'high'
      );
    }

    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {
      // Add nonce for security and authentication.
      wp_nonce_field( 'bright_submissions_nonce_action', 'bright_submissions_nonce' );
    }

    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {
      // Add nonce for security and authentication.
      $nonce_name   = isset( $_POST['bright_submissions_nonce'] ) ? $_POST['bright_submissions_nonce'] : '';
      $nonce_action = 'bright_submissions_nonce_action';

      // Check if nonce is set.
      if ( ! isset( $nonce_name ) ) {
        return;
      }

      // Check if nonce is valid.
      if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
        return;
      }

      // Check if user has permissions to save data.
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
      }

      // Check if not an autosave.
      if ( wp_is_post_autosave( $post_id ) ) {
        return;
      }

      // Check if not a revision.
      if ( wp_is_post_revision( $post_id ) ) {
        return;
      }
    }

}
