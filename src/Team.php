<?php 

namespace troutx\yaz;

require './vendor/autoload.php';
//require_once( 'libraries/Utils.php' );



/**
 * Team
 */
class Team
{
  const TEAM_FILE_EXT = 'csv';

  public $player_ids = array();
  public $batting_order;
  public $defense = array();
  public $reserves = array(); 
  
  /**
   * 
   */
  public function __construct( $year, $team_id ) {

    if ( empty( $year ) || empty( $team_id ) ) {
      throw new InvalidArgumentException();
    }

    $filename = $this->format_team_filename( $year, $team_id );

    $this->batting_order = array();
    $this->defense = array( null, );
    $this->reserves = array(); 
  }

  /**
   * Generates the name of the CSV file that contains the team data.
   * Ex.: BAL1979.csv
   * Ex.: CLE1969.csv
   *
   * @param string $year - the year of the team
   * @param string $team_id - the retrosheet team ID
   * @return string - the filename for the team,
   *   boolean false if there's a problem
   */
  private function format_team_filename( $year, $team_id ) {

    if ( Utils::can_play_game_with_team( $year, $team_id ) ) {
      return strtoupper( $team_id . $year ) . TEAM_FILE_EXT;
    }

    return false;
  }


  private function fetch_team( $team ) {

  }

  public function get_fielding() {
    return $this->fielding;
  }



}


?>
