<?php 

namespace troutx\yaz;

require 'vendor/autoload.php';

/**
 * Wrapper for Chadwick processes
 *
 */
class Chadwick
{
  /**
   * Each key for a value corresponds to its field number for that value in Chadwick.
   * So us array_search() to get the correct field number. Ex.:
   *      $field = array_search( 'event_num', self::fields );
   *
   * TODO
   *   Searching through an array each time maybe isn't a great practice.
   *   Should prolly make an associative array:
   *      ...
   *      'inning' => 2,
   *      'batting_team' => 3,
   *      ...
   *
   */
  public static $fields = array(
    'game_id',
    'visiting_team',
    'inning',
    'batting_team',
    'outs',
    'balls',
    'strikes',
    'pitch_sequence',
    'vis_score',
    'home_score',
    'batter',
    'batter_hand',
    'res_batter',
    'res_batter_hand',
    'pitcher',
    'pitcher_hand',
    'res_pitcher',
    'res_pitcher_hand',
    'catcher',
    'first_base',
    'second_base',
    'third_base',
    'shortstop',
    'left_field',
    'center_field',
    'right_field',
    'first_runner',
    'second_runner',
    'third_runner',
    'event_text',
    'leadoff_flag',
    'pinchhit_flag',
    'defensive_position',
    'lineup_position',
    'event_type',
    'batter_event_flag',
    'ab_flag',
    'hit_value',
    'sh_flag',
    'sf_flag',
    'outs_on_play',
    'double_play_flag',
    'triple_play_flag',
    'rbi_on_play',
    'wild_pitch_flag',
    'passed_ball_flag',
    'fielded_by',
    'batted_ball_type',
    'bunt_flag',
    'foul_flag',
    'hit_location',
    'num_errors',
    '1st_error_player',
    '1st_error_type',
    '2nd_error_player',
    '2nd_error_type',
    '3rd_error_player',
    '3rd_error_type',
    'batter_dest',         //(5 if scores and unearned, 6 if team unearned)
    'runner_on_1st_dest',  //(5 if scores and unearned, 6 if team unearned)
    'runner_on_2nd_dest',  //(5 if scores and unearned, 6 if team unearned)
    'runner_on_3rd_dest',  //(5 if scores and unearned, 6 if team unearned)
    'play_on_batter',
    'play_on_runner_on_first',
    'play_on_runner_on_second',
    'play_on_runner_on_third',
    'sb_for_runner_on_1st_flag',
    'sb_for_runner_on_2nd_flag',
    'sb_for_runner_on_3rd_flag',
    'cs_for_runner_on_1st_flag',
    'cs_for_runner_on_2nd_flag',
    'cs_for_runner_on_3rd_flag',
    'po_for_runner_on_1st_flag',
    'po_for_runner_on_2nd_flag',
    'po_for_runner_on_3rd_flag',
    'responsible_pitcher_for_runner_on_1st',
    'responsible_pitcher_for_runner_on_2nd',
    'responsible_pitcher_for_runner_on_3rd',
    'new_game_flag',
    'end_game_flag',
    'pinch-runner_on_1st',
    'pinch-runner_on_2nd',
    'pinch-runner_on_3rd',
    'runner_removed_for_pinch-runner_on_1st',
    'runner_removed_for_pinch-runner_on_2nd',
    'runner_removed_for_pinch-runner_on_3rd',
    'batter_removed_for_pinch-hitter',
    'position_of_batter_removed_for_pinch-hitter',
    'fielder_with_first_putout',
    'fielder_with_second_putout',
    'fielder_with_third_putout',
    'fielder_with_first_assist',
    'fielder_with_second_assist',
    'fielder_with_third_assist',
    'fielder_with_fourth_assist',
    'fielder_with_fifth_assist',
    'event_num',
  );

  /**
   * Change to the directory that contains the event files,
   * which should be 'data'. We need to be inside this directory
   * when calling many of our Chadwick:: functions.
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
      $field = array_search( 'event_num', self::$fields );
      $event_num = `cwevent -q -y $year -f $field $file | tail -n 1`;
      $event_num = self::clean_string( $event_num );
      return ( $event_num != '' ? $event_num : false );
    } else {
      return false;
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
      $fields = array();
      $fields[] = array_search( 'first_runner', self::$fields );
      $fields[] = array_search( 'second_runner', self::$fields );
      $fields[] = array_search( 'third_runner', self::$fields );
      $field = implode( ',', $fields );
      $runners = `cwevent -q -y $year -f $field $file | tail -n 1`;
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
      $field = array_search( 'batter_dest', self::$fields );
      $dest = `cwevent -q -y $year -f $field $file | tail -n 1`;
      $dest = self::clean_string( $dest );
      return  ( $dest != '' ? $dest : false ) ;
    } else {
      return false;
    }
  }

  private static function runners_dests( $year, $file ) {
    
    if ( self::change_to_data_dir() ) {
      $fields = array();
      $fields[] = array_search( 'runner_on_1st_dest', self::$fields );
      $fields[] = array_search( 'runner_on_2nd_dest', self::$fields );
      $fields[] = array_search( 'runner_on_3rd_dest', self::$fields );
      $field = implode( ',', $fields );
      $dests = `cwevent -q -y $year -f $field $file | tail -n 1`;
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

  public static function outs_on_play( $year, $file ) {
    if ( self::change_to_data_dir() ) {
      $field = array_search( 'outs_on_play', self::$fields );
      $outs_on_play = `cwevent -q -y $year -f $field $file | tail -n 1`;
      $outs_on_play = self::clean_string( $outs_on_play );
      return ( $outs_on_play != '' ? $outs_on_play : false );
    } else {
      return false;
    }
  }
} // eoc


?>
