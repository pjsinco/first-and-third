<?php 
// TODO
// * needs refactoring
// * board value 1-11 does not have fielding, so check before looking up

/**
 * ResultQuery
 */
class Result {

  private $game_state;
  private $board_val;
  private $conditions = array(); // 2D array
  private $condition_keys = array();
  private $board;
  private $xpath;
  public $des;
  public $outs;
  public $runs;
  public $state;
  public $type;

  /**
   * 
   */
  public function __construct( $board_val, $game_state ) {

    // TODO break these out
    $this->game_state = $game_state;
    $this->board_val = (string) $board_val;
    $this->board = simplexml_load_file( 'boards/game-board-5.xml' );
    $this->xpath = $this->format_xpath( $board_val );
    $this->conditions = $this->fetch_conditions();
    $this->condition = $this->fetch_conditions();
    $this->condition_keys = $this->isolate_condition_keys();
    $this->get_xpath_for_result();

    $this->get_result();
  }
    
  public function __toString() {
    

  }

  private function format_xpath( ) {

    $xpath = sprintf(
      '//play[@val=%1$s]/fielding[@val=%2$s]',
      $this->board_val, $this->game_state->fielding
    );

    return $xpath;
  }

  private function fetch_conditions() {

    $conds_avail = $this->board->xpath( $this->xpath );
    $conditions = array();

    if ( $conds_avail ) {
      foreach ($conds_avail[0] as $condition ) {

        // make sure we've got a <conditions> elem
        if ( $condition->getName() == 'conditions' ) {

          // get an array of attrs of this <conditions> elem
          $atts = (array) $condition->attributes();

          // store them in our array
          $conditions[] = $atts['@attributes'];

        }
      }
    }

    return $conditions;
  }

  /**
   * Now that we have a 2D array of <conditions> attributes,
   * let's check each attr set for matches against our $input.
   *
   * We should emerge with a single, possibly empty, array, 
   * which we can then use to build the final query for 
   * the play result.
   */
  private function isolate_condition_keys() {

    $condition_keys = array();
    
    foreach ( $this->conditions as $condition ) {

      foreach ( $condition as $key => $value ) {

        if ( $this->game_state->$key === $value ) {
          $matches = true;
        } else {
          $matches = false; // TODO needed?
          break; // we're done here
        }
      }

      if ( $matches ) {

        // $condition_keys is a 2D array for now so that 
        // we can easily test it by counting its length
        $condition_keys[] = array_keys( $condition );
        
        // We're turning off the break for now so we can see if we
        // ever get more than one array in $condition_keys

        //break; // we've got our condition so let's hit the road

      }
    }

    return $condition_keys;
  }

  public function get_xpath_for_result() {

    // TODO
    if ( count( $this->condition_keys <= 1 ) ) {

      $q= null;

      foreach ($this->condition_keys as $condition_key) {
        $q = '/conditions';
        foreach ( $condition_key as $key ) {
          $q .= "[@$key=\"{$this->game_state->$key}\"]";
        }
      }
    }

    $this->xpath .= ( $q  ?  $q . '/result' : '/result' );
    k($this->xpath);
  }

  private function get_result() {
    $result = $this->board->xpath( $this->xpath );

    $atts = (array) $result[0]->attributes();

    $this->des = $atts['@attributes']['des'];
    $this->outs = $atts['@attributes']['outs'];
    $this->runs = $atts['@attributes']['runs'];
    $this->state = $atts['@attributes']['state'];
    $this->type = $atts['@attributes']['type'];

    k($this->des);
  }

} // eoc
?>
