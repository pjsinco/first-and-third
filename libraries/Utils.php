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

}

?>
