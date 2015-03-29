<?php 

/**
 * TeamInning
 */
class TeamInning
{
  public $team_atbat;
  public $outs;
  /**
   * 
   */
  public function __construct( $team_atbat ) {
    $this->team_atbat = $team_atbat;
    $this->outs = 0;
    
  }
}

?>
