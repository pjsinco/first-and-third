<?php 

/**
 * GameState
 * Maintains a snapshop of current all game conditions
 *
 * @package First and Third
 * @author Patrick Sinco
 */
class GameState {

  //private $scorecard;

  private $event_count;

  // game
  private $inning;
  private $batting_team;
  private $outs;
  private $inning_score;

  private $runners;
  private $balls;
  private $strikes;
  private $zero_outs;
  private $two_outs;

  private $score = array();
  private $hits = array();
  private $errors = array();

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


  //public function __construct( $inning, $half, $home_team_runs, $away_team_runs ) {
  public function __construct( $batter, $args = array() ) {

    extract( $args );

    //$this->scorecard = $scorecard;
    $this->outs = ( $outs ? $outs : 0) ;
    //$this->inning = $scorecard->inning; // todo needed?
    //$this->half = $scorecard->half; // todo needed?
    $this->bases = ( $bases ? $bases : 0 );
    $this->zero_outs = $this->has_zero_outs();
    $this->two_outs = $this->has_two_outs();
    $this->home_team_runs = $scorecard->home_team_runs;
    $this->away_team_runs = $scorecard->away_team_runs;
    $this->p_sym = $scorecard->pitcher->p_sym;
    $this->against = $scorecard->pitcher->grade;
    $this->infield = ( $infield ? $infield : 'c' );
    $this->fielding = $scorecard->defense->get_fielding();
    $this->double_cols = $scorecard->at_bat->double_cols;
    $this->star14 = $scorecard->at_bat->star_14;
    $this->batter_speed = $scorecard->batter;
    $this->on_1b_speed = $scorecard->on_1b->speed;
    $this->on_2b_speed = $scorecard->on_2b->speed;
    $this->on_3b_speed = $scorecard->on_3b->speed;
    $this->play_it_safe = false;
  }

  // todo needed?
  public function get_fielding() {
    return $this->fielding;
  }

  public function has_zero_outs() {
    // body...
  }

  public function has_two_outs() {
    // body...
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
