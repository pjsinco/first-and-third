<?php 

/**
 * ResultQuery
 */
class ResultQuery {

  private $game_state;
  private $board_val;
  private $qualifiers = array(); // 2D array
  private $board;
  private $xpath;

  /**
   * 
   */
  public function __construct( $board_val, $game_state ) {
    $this->game_state = $game_state;
    $this->board_val = $board_val;
    $this->board = simplexml_load_file( 'game-board-alt.xml' );
    $this->xpath = $this->format_xpath( $board_val );
    $this->qualifiers = $this->fetch_qualifiers();
    //print_r( $this->qualifiers );
  }

  private function format_xpath( ) {
    $xpath = sprintf(
      '//play[@val=%1$s]/fielding[@val=%2$s]',
      $this->board_val, $this->game_state->fielding
    );

    return $xpath;
  }

  private function fetch_qualifiers() {
    
    $q_elems = $this->board->xpath( $this->xpath );
    $qualifiers = array();

    foreach ($q_elems[0] as $q_elem ) {

      // get an array of attrs of this <qualifiers> elem
      $atts = (array) $q_elem->attributes();
      // store them in our array
      $qualifiers[] = $atts['@attributes'];
    }

    return $qualifiers;

  }

  public function available_qualifiers() {
  

  }

  public function isolate_qualifier_keys() {
    foreach ($this->qualifiers as $value) {
      
    }
  }

  public function __toString() {
    return $this->xpath;
  }
  


} // eoc
?>
