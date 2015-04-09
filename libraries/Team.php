<?php 

/**
 * Team
 */
class Team
{

  public $player_ids = array();
  public $batting_order;
  public $defense = array();
  public $reserves = array(); 
  
  /**
   * 
   */
  public function __construct( $year, $team_id ) {
    $filename = $this->get_team_filename( $year, $team_id );

    $this->batting_order = array();
    $this->defense = array( null, );
    $this->reserves = array(); 
  }

  private function get_team_filename( $year, $team_id ) {

    if ( Utils::valid_year( $year ) && Utils::valid_team( $year, $team_id ) ) {
      return strtoupper( $team_id . $year );
    }
  }

  $th

  private function fetch_team( $team ) {

  }

  public function get_fielding() {
    return $this->fielding;
  }



}


?>
