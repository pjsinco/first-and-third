<?php 

namespace troutx\yaz;

require_once( './vendor/autoload.php' );

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
   *   └── years/
   *       ├── 1969/
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
   * Generates the path to a specific year directory.
   *
   * Expected file structure:
   *
   *   data/
   *   └── years/
   *       ├── 1969/
   *       ├── 1973/
   *
   * @return string - the path to the directory for that year
   */
  public static function path_to_year_dir( $year ) {
    return self::path_to_years_dir() . DIRECTORY_SEPARATOR . 
      trim( $year );
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
   *  └── years/
   *      ├── 1969/
   *      │   ├── 1969BAL.EVA
   *      │   ├── BAL1969.ROS
   *      │   ├── BAL1969.csv
   *      │   └── TEAM1969
   *      ├── 1979/
   *      └── 2014/
   *
   * @return boolean - whether the game can be play in that year
   */
  public static function can_play_game_in_year( $year ) {

    if ( empty( $year ) === false ) {
      if ( $year_dirs = scandir( self::path_to_years_dir() ) ) {
        foreach ( $year_dirs as $dir ) {
          if ( $dir == trim( $year ) ) {
            if ( file_exists( self::path_to_years_dir() . 
              DIRECTORY_SEPARATOR . trim( $year ) . DIRECTORY_SEPARATOR . 
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

    if ( empty( $year ) === false && empty( $team_id ) === false &&
      self::can_play_game_in_year( $year ) ) {
    
        return self::team_exists( $year, $team_id );

    }
    return false;

  }

  /**
   * Checks whether a team exists in a given year.
   *
   * @param string $year - the year to check
   * @param string $team_id - the retrosheet team ID
   * @return boolean - whether the team exists that year
   */
  public static function team_exists( $year, $team_id ) {

    $year = trim( $year );
    $team_id = trim( $team_id );
    $path = self::path_to_year_dir( $year ) .
      DIRECTORY_SEPARATOR . self::format_team_filename( $year );
    
    // header row for TEAMYYYY file
    $header = array( 'id', 'league', 'city', 'nickname' );
    $teams = self::csv_to_array( $path, ',', $header );

    foreach ($teams as $team) {
      if ( $team['id'] == $team_id ) {
        return true;
      }
    }

    return false;
  }

  /**
   * Generates an associated array from a CSV file.
   * https://gist.github.com/jaywilliams/385876
   *
   * @param $filename string - the name of the CSV file
   * @param $delim string - the delimiter for the file
   * @param $header array - an array of headers for the file; 
   *     include this array if the file has no header row
   * @return array - the CSV file as an associative array
   */
  public static function csv_to_array( $filename = '', $delim = ',', $header = null ) {
  
    if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
      return FALSE;
    }
  
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
