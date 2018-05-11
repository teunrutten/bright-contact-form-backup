<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/teunrutten/
 * @since      1.0.0
 *
 * @package    Bright_Contact_Form_Backup
 * @subpackage Bright_Contact_Form_Backup/admin/partials
 */

 $posts = get_posts(array(
   'post_type'   => 'brightsubmissions',
   'post_status' => 'publish',
   'posts_per_page' => -1
   )
 );
 if ($posts) {
   $post_meta = get_post_meta( $posts[0]->ID, 'bright_form_data', true );
 } else {
   $post_meta = array();
 }

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap bright-backup-form-wrap">

  <h1>Bright - Formulier backup instellingen</h1>

  <form method="post" action="options.php">
    
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row">Toon deze kolommen:</th>
          <td>
            <fieldset>
              <?php
              settings_fields( 'bright-form-backup-settings' );
              do_settings_sections( 'bright-form-backup-settings' );
              foreach($post_meta as $key => $value) : ?>
                <p>
                  <label>
                    <input
                      type="checkbox"
                      name="bright_form_backup_<?php echo $key; ?>"
                      <?php echo esc_attr( get_option('bright_form_backup_' . $key) ) == 'on' ? 'checked="checked"' : ''; ?>
                    />
                    <?php echo $key; ?>
                  </label>
                </p>
              <?php endforeach; ?>
            </fieldset>
          </td>
        </tr>
      </tbody>
    </table>

    <p class="submit">
      <?php submit_button(); ?>
    </p>

  </form>

</div>
