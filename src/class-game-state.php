<?php 

/**
 * GameState
 *
 * @package First and Third
 * @author Patrick Sinco
 */
class GameState {

  // game
  private $outs;
  private $inning;
  private $half;
  private $bases;
  private $zero_outs;
  private $two_outs;
  private $home_team_runs;
  private $away_team_runs;

  // pitcher
  private $p_sym;
  private $against;

  // defense
  private $infield;
  private $fielding;

  // batter
  private $double_cols;
  private $star14;
  private $batter_speed;

  // offense
  private $on_1b_speed;
  private $on_2b_speed;
  private $on_3b_speed;
  private $play_it_safe;


  public function __construct() {

  }

  public function get_fielding() {
    return $this->fielding;
  }

  public function __get( $prop ) {
    if ( property_exists( 'GameState', $prop ) ) {
      return $this->$prop;
    }
  }
  
  public function __set( $prop, $val ) {
    if ( property_exists( 'GameState', $prop ) ) {
      $this->$prop = $val;
    }
  }


} // END class GameState


?>
