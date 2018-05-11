<?php
/**
 * Run a cron job to delete posts based on the settings.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/teunrutten/
 * @since      1.0.0
 *
 * @package    Bright_Contact_Form_Backup
 * @subpackage Bright_Contact_Form_Backup/admin/partials
 */

// make sure we can use wordpress function
require_once( __DIR__.'/../../../../wordpress/wp-load.php');

$period = esc_attr( get_option('bright_form_backup_period') );

// early return if invalid period
if ($period != 'week' && $period != 'month' && $period != 'year') {
  return;
}

// grab posts from a certain period ago
$args = array(
  'post_type' => 'brightsubmissions',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'date_query' => array(
    array(
      'column' => 'post_date_gmt',
      'before' => '1 '.$period.' ago',
    ),
  )
);

$posts = get_posts($args);

foreach($posts as $key => $post) {
  // double-check we're removing only submission posts
  if ( get_post_type( get_the_id() ) == 'brightsubmissions' ) {
    wp_delete_post( get_the_id() );
  }
}
