<?php 

/**
 * 
 */
class Utils
{
  
  /**
   * Change to the directory that contains the event files,
   * which should be 'data'
   *
   * @return boolean indicating success
   *
   */
  public static function change_to_data_dir() {
    if ( basename( getcwd() ) != 'data' ) {
      return chdir( 'data' );
    } else {
      return true;
    }
  }

  /**
   * https://gist.github.com/jaywilliams/385876
   * Here is a quick and easy way to convert a CSV file to an associated 
   * array:
   */
  public static function csv_to_array( $filename = '', $delim = ',' ) {
  
    if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
      return FALSE;
    }
  
    $header = NULL;
    $data = array();
  
    $handle = fopen( $filename, 'r' );
  
    if ( $handle !== FALSE ) {
  
      while ( $row = fgetcsv( $handle, 1000, $delim ) ) {
        if ( !$header ) {
          $header = $row;
        } else {
          $id = $row[0];
          $data[$id] = array_combine( $header, $row );
        }
      }
    }
  
    fclose( $handle );
  
    return $data;
  }

} // eoc

?>
