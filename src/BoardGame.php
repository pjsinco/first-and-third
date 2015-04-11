<?php 

namespace troutx\yaz;

require 'vendor/autoload.php';

/**
 * BoardGame
 * 
 * Handles the mechanics of the game play;
 * controller-like?
 * 
 */
class BoardGame
{
  private $game;
  private $home_team;
  private $away_team;
  private $scorecard;
  private $game_over;

  
  /**
   * 
   */
  public function __construct( $game ) {
    $this->game = $game;
    $this->away_team = new Team( $game->away );
    $this->home_team = new Team( $game->home );
    $this->scorecard = new Scorecard( $game, $this->away_team, $this->home_team );
    $this->game_state = new GameState( $scorecard );
    $this->game_over = false;

    $this->play();
  }

  public function play() {
    while ( ! $this->game_over ) {
      $this->play_game();
    }
  }

  private function play_game() {
    //while ( $this->scorecard->
  }

  public function game_over() {
    return $this->game_over;
  }

  public function __get( $prop ) {
    if ( property_exists( 'BoardGame', $prop ) ) {
      return $this->$prop;
    }
  }

  public function __set( $prop, $val ) {
    if ( property_exists( 'BoardGame', $prop ) ) {
      $this->$prop = $val;
    }
  }

}

?>
