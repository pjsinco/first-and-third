<?php 


/**
 * Wrapper for Chadwick processes
 *
 */
class Chadwick
{
  
  /**
   * Returns the entire event file as a string
   *
   * @return string - the event file,
   *    boolean false if there's a problem
   *
   */
  public static function get_event_string( $year, $file ) {

    if ( self::change_to_data_dir() ) {
      $event_str = `cwevent -q -y $year $file`;

      if ( $event_str != '' ) {
        return $event_str;
      } 
    }

    return false;

  }

  /**
   * Retrieves the last play event 
   *
   * @return string - the last play event,
   *    boolean false if there's a problem
   */
  public static function get_last_play( $year, $file ) {
    if ( self::change_to_data_dir() ) {

      if ( !file_exists( $file ) ) {
        return false;
      }

      $fp = fopen( $file, 'r' );

      $play = null;
      while ( !feof( $fp ) ) {
        $string = trim( fgets( $fp ) );
        if ( strpos( $string, 'play' ) === 0 ) {
          $play = $string;
        }
      }
      return ( $play != null ? $play : false );

    } else {
      return false;
    }
  }


  /**
   * Retrieves the the most recent event number to be recorded
   *
   * @return 
   *    string - the last event number,
   *    boolean - false if there's a problem
   *
   */
  public static function last_play_event_num( $year, $file ) {
    if ( self::change_to_data_dir() ) {
      $event_num = `cwevent -q -y $year -f 96 $file | tail -n 1`;
      $event_num = self::clean_string( $event_num );
      return ( $event_num != '' ? $event_num : false );
    } else {
      return false;
    }
  }

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
   * Retrieves the id of the runner on first base
   *
   * @return string - the id of the runner
   *    boolean false if there's a problem
   *
   */
  public static function first_runner( $year, $file ) {
    $runners = self::runners( $year, $file );
    return ( $runners[1] != '' ? $runners[1] : false );
  }

  public static function second_runner( $year, $file ) {
    $runners = self::runners( $year, $file );
    return ( $runners[2] != '' ? $runners[2] : false );
  }

  public static function third_runner( $year, $file ) {
    $runners = self::runners( $year, $file );
    return ( $runners[3] != '' ? $runners[3] : false );
  }

  private static function runners( $year, $file ) {

    if ( self::change_to_data_dir() ) {
      // the last line is the most recent event
      $runners = `cwevent -q -y $year -f 26-28 $file | tail -n 1`;
      return self::make_bases_array( $runners );
    } 

    return false;
  }

  public static function first_runner_dest( $year, $file ) {
    $dests = self::runners_dests( $year, $file );
    return ( $dests[1] != '' ? $dests[1] : false );
  }

  public static function second_runner_dest( $year, $file ) {
    $dests = self::runners_dests( $year, $file );
    return ( $dests[2] != '' ? $dests[2] : false );
  }

  public static function third_runner_dest( $year, $file ) {
    $dests = self::runners_dests( $year, $file );
    return ( $dests[3] != '' ? $dests[3] : false );
  }

  /**
   * Retrieves the batter's destination
   * 
   * @return string - batter's destination,
   *    boolean - false if there's a problem
   */
  public static function batter_dest( $year, $file ) {
    if ( self::change_to_data_dir() ) {
      $dest = `cwevent -q -y $year -f 58 $file | tail -n 1`;
      $dest = self::clean_string( $dest );
      return  ( $dest != '' ? $dest : false ) ;
    } else {
      return false;
    }
  }

  private static function runners_dests( $year, $file ) {
    
    if ( self::change_to_data_dir() ) {
      $dests = `cwevent -q -y $year -f 59-61 $file | tail -n 1`;
      return self::make_bases_array( $dests );
    } else {
      return false;
    }
  }

  /**
   * Trims whitespace, removes " from string
   */
  private static function clean_string( $str ) {
    return trim( str_replace( '"', '', $str ) );
  }

  /**
   * Converts string in an array, with: 
   *   item[1] representing 1b, 
   *   item[2] representing 2b, 
   *   item[3] representing 3b, 
   */
  private static function make_bases_array( $str ) {
    if ( $str == '' ) {
      return false;
    }
    $runners = ',' . self::clean_string( $str );
    return explode( ',', $runners );
  }

} // eoc


?>
