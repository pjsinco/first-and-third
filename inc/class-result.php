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
  //private $conditions = array(); // 2D array
  //private $condition_keys = array();
  private $board_xml;
  //private $xpath;
  public $des;
  public $outs;
  public $runs;
  public $state;
  public $type;

  /**
   * 
   */
  public function __construct( $board_val, $game_state ) {

    $this->game_state = $game_state;
    $this->board_val = (string) $board_val;
    $this->board_xml = simplexml_load_file( 'boards/game-board-5.xml' );

    $this->fetch_result( $board_val, $game_state );
  }
    
  private function fetch_result( $board_val, $game_state ) {

    $xpath = $this->format_xpath( $board_val );

    $conditions = $this->fetch_conditions( $xpath );

    $condition_keys = $this->isolate_condition_keys( $conditions );

    $xpath_final = $this->get_xpath_for_result( $xpath, $condition_keys );

    $result_xml = $this->board_xml->xpath( $xpath_final );

    $attrs = $this->get_result_attrs( $result_xml );

    $this->set_result_attrs( $attrs );

  }

  private function get_result_attrs( $result_xml ) {

    $attrs = (array) $result_xml[0]->attributes();

    return array(
      'des'   => $attrs['@attributes']['des'],
      'outs'  => $attrs['@attributes']['outs'],
      'runs'  => $attrs['@attributes']['runs'],
      'state' => $attrs['@attributes']['state'],
      'type ' => $attrs['@attributes']['type'],
    );
  }

  private function set_result_attrs( $attrs ) {

      foreach ($attrs as $key => $value) {
        $this->{$key} = $value;
      }
  }

  public function __toString() {
    

  }

  private function format_xpath( $board_val ) {
    $xpath = sprintf(
      '//play[@val=%1$s]/fielding[@val=%2$s]',
      $board_val, $this->game_state->fielding
    );

    return $xpath;
  }

  private function fetch_conditions( $xpath ) {

    $conds_avail = $this->board_xml->xpath( $xpath );
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
  private function isolate_condition_keys( $conditions ) {

    $condition_keys = array();
    
    foreach ( $conditions as $condition ) {

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

  public function get_xpath_for_result( $xpath, $condition_keys ) {

    // TODO
    if ( count( $condition_keys <= 1 ) ) {

      $q= null;

      foreach ($condition_keys as $condition_key) {
        $q = '/conditions';
        foreach ( $condition_key as $key ) {
          $q .= "[@$key=\"{$this->game_state->$key}\"]";
        }
      }
    }

    $xpath .= ( $q  ?  $q . '/result' : '/result' );
    k($xpath);
    return $xpath;
  }


} // eoc
?>
