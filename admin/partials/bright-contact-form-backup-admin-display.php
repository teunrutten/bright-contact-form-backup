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
   'post_status' => 'private',
   'posts_per_page' => -1
   )
);
if ($posts) {
  $admin_settings = array();

  foreach($posts as $key => $post) {
    $post_meta = get_post_meta( $post->ID, 'bright_form_data', true );

    foreach ($post_meta as $key => $value) {
      if (!strpos($key, '-generated_key_bcfb')) {
        $admin_settings[$key] = $key;
      }
    }
  }

  $admin_settings = array_unique($admin_settings);
} else {
   $admin_settings = array();
}

$periods = array(
  'week'  => 'een week',
  'month' => 'een maand',
  'year'  => 'een jaar',
  'eternal' => 'voor altijd'
);
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap bright-backup-form-wrap">

  <h1>Bright - Formulier backup instellingen</h1>

  <form method="post" action="options.php">
    <?php
    settings_fields( 'bright-form-backup-settings' );
    do_settings_sections( 'bright-form-backup-settings' );
    ?>

    <table class="form-table">
      <tbody>
        <tr>
            <td>
              <fieldset>
                <p>
                  <strong>Indien er bestanden geupload kunnen worden, plaats dan de volgende veldnamen komma gescheiden:</strong><br><br>
                  <input type="text" placeholder="bestand_1,bestand_2,bestand_3" name="bright_form_backup_input_fields" value="<?php echo esc_attr( get_option('bright_form_backup_input_fields') ); ?>" size="50" />
                </p>
              </fieldset>
            </td>
        </tr>

        <tr>
          <th scope="row">Toon deze kolommen:</th>
          <td>
            <fieldset>
              <?php
              foreach($admin_settings as $key => $value) :
                if (!strpos($key, '-generated_key_bcfb')) :
              ?>
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
              <?php
                endif;
              endforeach;
              ?>
            </fieldset>
          </td>
        </tr>

        <tr>
            <th scope="row">Bewaar elke inzending:</th>
            <td>
              <fieldset>
                <?php foreach($periods as $key => $value) : ?>
                  <p>
                    <label>
                      <input
                        type="radio"
                        name="bright_form_backup_period"
                        value="<?php echo $key; ?>"
                        <?php echo esc_attr( get_option('bright_form_backup_period') ) == $key ? 'checked="checked"' : ''; ?>
                      />
                      <?php echo $value; ?>
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
