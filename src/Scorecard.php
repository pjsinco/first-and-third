<?php 

namespace troutx\yaz;

require 'vendor/autoload.php';

/**
 * Scorecard
 */
class Scorecard
{
  //public $home_team;
  //public $away_team;
  private $game;
  public $home_team;
  public $away_team;

  public $offense;
  public $defense;
  public $pitcher;
  public $batter;
  public $ondeck;
  public $inthehole;

  public $on_1b;
  public $on_2b;
  public $on_3b;

  public $home_team_runs;
  public $away_team_runs;
  private $innings = array();

  public function __construct( $game, $away_team, $home_team ) {
    $this->game = $game;
    $this->home_team_runs = 0;
    $this->away_team_runs = 0;
  }

//  public function play_inning( $inning_num ) {
//
//    $inning = new Inning( $inning_num );
//
//    foreach ( array( $this->home_team, $this->away_team ) as $team ) {
//      $this->play_team_inning( $team, $inning );
//    }
//
//  }


  public function play_team_inning( $team, $game ) {

    $inning = new TeamInning( $team );
    $state = new GameState( $inning, $game );

    while ( $state->outs < 3 ) {

      

    }

  }

  /**
   * Determines what half of the inning we're in
   *
   */
  public function inning_half( $team ) {
    if ( $team == $this->away ) {
      return 'top';
    } else {
      return 'bottom';
    }
  }

  public function __get( $prop ) {
    if ( property_exists( 'Scorecard', $prop ) ) {
      return $this->$prop;
    }
  }

  public function __set( $prop, $val ) {
    if ( property_exists( 'Scorecard', $prop ) ) {
      $this->$prop = $val;
    }
  }
} // eoc


?>
