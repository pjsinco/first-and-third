<?php 

namespace troutx\yaz;

require 'vendor/autoload.php';

// TODO
// * needs refactoring
// * board value 1-11 does not have fielding, so check before looking up

/**
 * ResultQuery
 */
class Result {

  const FIELDING_PHASE_START = 12 ;
  private $sac;
  private $game_state;
  private $lookup;
  private $board_xml;
  public $des;
  public $outs;
  public $runs;
  public $state;
  public $type;

  /**
   * 
   */
  public function __construct( $lookup, $game_state, $sac = FALSE ) {
    $this->sac_booklet = $sac_booklet;
    $this->game_state = $game_state;
    $this->lookup = (string) $lookup;
    $this->board_xml = simplexml_load_file( 'boards/game-board-5.xml' );

    $this->fetch_result( $lookup, $game_state );
  }

  private function is_fielding_phase( $lookup ) {
    return $lookup >= self::FIELDING_PHASE_START;
  }
    
  private function fetch_result( $lookup, $game_state ) {
    $xpath = $this->format_xpath( $lookup );
    $conditions = $this->fetch_conditions( $xpath );
    $condition_keys = $this->isolate_condition_keys( $conditions );
    $xpath_final = $this->get_xpath_for_result( $xpath, $condition_keys );
    $result_xml = $this->board_xml->xpath( $xpath_final );
    $attrs = $this->get_result_attrs( $result_xml );
    $this->set_result_attrs( $attrs );
  }

  private function format_xpath( $lookup ) {
    if ( $this->is_fielding_phase( $lookup ) ) {
      $xpath = sprintf(
        '//play[@val=%1$s]/fielding[@val=%2$s]',
        $lookup, $this->game_state->get_fielding()
      );
    } else { // we're in eh hitt
      $xpath = sprintf( '//play[@val=%1$s]', $lookup );
    }

    return $xpath;
  }

  private function get_result_attrs( $result_xml ) {
    $attrs = (array) $result_xml[0]->attributes();

    return array(
      'des'   => $attrs['@attributes']['des'],
      'outs'  => $attrs['@attributes']['outs'],
      'runs'  => $attrs['@attributes']['runs'],
      'state' => $attrs['@attributes']['state'],
      'type' => $attrs['@attributes']['type'],
    );
  }

  private function set_result_attrs( $attrs ) {
    foreach ($attrs as $key => $value) {
      $this->{$key} = $value;
    }
  }

  /**
   * Find all possible conditions for this play.
   *
   * @return 2D array of conditions sets
   */
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

  private function get_xpath_for_result( $xpath, $condition_keys ) {
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
    //k($xpath);
    return $xpath;
  }

  public function __toString() { }


} // eoc
?>
