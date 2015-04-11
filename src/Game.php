<?php

namespace troutx\yaz;

require 'vendor/autoload.php';

/**
 * 
 */
class Game
{
  public $home;
  public $away;
  public $venue_name;
  public $linescore;
  public $game_result;
  public $board_game;

  /**
   * 
   */
  public function __construct( $away, $home, $venue_name ) {
    $this->home = $home;
    $this->away = $away;
    $this->venue_name = $venue_name;
    //$this->scorecard = new Scorecard( $this );
    $this->board_game = new BoardGame( $this );
  }

  public function play_game() {

    $this->board_game->play();

    return $this->board_game;
  }

  public function __get( $prop ) {
    if ( property_exists( 'Game', $prop ) ) {
      return $this->$prop;
    }
  }

  public function __set( $prop, $val ) {
    if ( property_exists( 'Game', $prop ) ) {
      $this->$prop = $val;
    }
  }

} // eoc

?>
