<?php 

namespace troutx\yaz;

require 'vendor/autoload.php';

/**
 * Class to manage creating, writing to, and reading from event files.
 *
 */
class EventFile
{
  public static function write( $event, $file ) {

    if ( Utils::change_to_data_dir()  ) {

      if ( ! file_exists( $file ) ) {
        touch ( $file );
      }

      if ( is_writable( $file ) ) {
        return file_put_contents( $file, $event . PHP_EOL, FILE_APPEND );
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
} // eoc
?>
