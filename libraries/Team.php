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
  public function __construct( $team ) {
    $this->batting_order = array();
    $this->defense = array( null, );
    $this->reserves = array(); 
  }

  private function fetch_team( $team ) {

  }

  public function get_fielding() {
    return $this->fielding;
  }



}


?>
