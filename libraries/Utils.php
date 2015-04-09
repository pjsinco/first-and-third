<?php 

/**
 * 
 */
class Utils
{
  //const PATH_TO_ROOT = '/..';
  const DIR_DATA = 'data';
  const DIR_YEARS = 'years';
  const TEAM_FILE_PREFIX = 'TEAM';

  /**
   * Generates a path to the data directory
   *
   * @return string - the path to the data directory,
   *   without a trailing slash
   */
  public static function path_to_data_dir() {
    return dirname( __DIR__ ) . DIRECTORY_SEPARATOR . self::DIR_DATA;
  }

  /**
   * Generates a path to the years directory, which is
   * inside the data directory.
   *
   * File structure:
   *
   * [project-root]/
   *   ...
   *   data/
   *   └── years
   *       ├── 1969
   *       ├── ...
   *
   * @return string - the path to the data directory,
   *   without a trailing slash
   *
   */
  public static function path_to_years_dir() {
    return self::path_to_data_dir() . DIRECTORY_SEPARATOR . self::DIR_YEARS;
  }

  /**
   * Formats the name for the team file that Chadwick requires.
   * Ex. TEAM1969 
   * Ex. TEAM2013
   *
   * @param string $year - the year for the team file
   */
  public static function format_team_filename( $year ) {
    return self::TEAM_FILE_PREFIX . trim( $year );
  }
  

  /**
   * Determines if a game can be played in the given year.
   * A year is playable if a directory for it exists and
   * there is a TEAMYYYY file for that year in the year's directory.
   *
   * File structure:
   *  data/
   *  └── years
   *      ├── 1969
   *      │   ├── 1969BAL.EVA
   *      │   ├── BAL1969.ROS
   *      │   ├── BAL1969.csv
   *      │   └── TEAM1969
   *      ├── 1979
   *      └── 2014
   *
   * @return boolean - whether the game can be play in that year
   */
  public static function can_play_game_in_year( $year ) {

    if ( empty( $year ) === false ) {
      if ( $year_dirs = scandir( self::path_to_years_dir() ) ) {
        foreach ( $year_dirs as $dir ) {
          if ( $dir == trim( $year ) ) {
            if ( file_exists( self::path_to_years_dir() . 
              DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . 
              self::format_team_filename( $year ) ) ) {
                return true;
            }
          }
        }
      }
    }

    return false;
  }

  /**
   * Checks whether the team ID is valid for the given year
   *
   * @param string $year - the year to check
   * @param string $team_id - the team ID to check
   */
  public static function can_play_game_with_team( $year, $team_id ) {
    if ( empty( $year ) === false  && empty( $team_id ) === false ) {

      // TODO complete this function

    }
    return false;

  }

  /**
   * https://gist.github.com/jaywilliams/385876
   * Here is a quick and easy way to convert a CSV file to an associated 
   * array:
   */
  public static function csv_to_array( $filename = '', $delim = ',' ) {
  
    if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
      echo getcwd();
      echo 'file doesnt exist';
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
