<?php

/**
 * Encrypt and decrypt formsubmission data.
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
class Bright_Contact_Form_Backup_Admin_Cryption {

  protected static $key = AUTH_KEY;
  protected static $cipher = "aes-128-cbc";

  protected static function ivlen()
  {
    return openssl_cipher_iv_length(self::$cipher);
  }

  public static function iv()
  {
    $ivlen = self::ivlen();
    return openssl_random_pseudo_bytes($ivlen);
  }

  public function encrypt( $plain_data, $uniqiv )
  {
    if (in_array( self::$cipher, openssl_get_cipher_methods()) )
    {
      // $encrypted_data = openssl_encrypt( $plain_data, self::$cipher, self::$key, $options = 0, self::iv() );
      $encrypted_data = openssl_encrypt( $plain_data, self::$cipher, self::$key, $options = 0, hex2bin($uniqiv) );

      return $encrypted_data;
    }

    return 'encryption failed';
  }

  public function decrypt( $encrypted_data, $uniqiv )
  {
    if (in_array( self::$cipher, openssl_get_cipher_methods()) )
    {
      // $plain_data = openssl_decrypt( $encrypted_data, self::$cipher, self::$key, $options = 0, self::iv() );
      $plain_data = openssl_decrypt( $encrypted_data, self::$cipher, self::$key, $options = 0, hex2bin($uniqiv) );
      // if (openssl_decrypt( $encrypted_data, self::$cipher, self::$key, $options = 0, self::iv() )) {
      //   return 'no_error';
      // } else {
      //   return self::iv() . ' + ' . self::iv() . ' + ' . self::iv();
      // }
      return $plain_data;
    }

    return 'decryption failed';
  }

}
