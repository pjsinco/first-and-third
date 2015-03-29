<?php

/**
 * 
 */
class Game
{
  public $home_team;
  public $away_team;
  //public $home_team_runs;
  //public $away_team_runs;
  //public $home_id;
  //public $away_id;
  public $venue_name;
  //public $venue_id;
  public $game_date;
  //public $home_wins;
  //public $away_wins;
  //public $home_losses;
  //public $away_losses;
  public $linescore;
  public $scorecard;
  public $game_over;

  /**
   * 
   */
  public function __construct( $away_team, $home_team ) {
    $this->home_team = $home_team;
    $this->away_team = $away_team;
    $this->scorecard = new Scorecard( $away_team, $home_team );
    $this->game_over = false;
  }

  public function play_game() {
    while ( $this->game_over ) {
      $this->scorecard->play();
    }
  }

  public function game_over() {
    return $this->game_over;
  }
}

?>
