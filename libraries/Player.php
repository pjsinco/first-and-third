<?php 

/**
 * Player
 */
class Player
{
  
  public $double_cols;
  public $star_14;
  public $has_11;
  public $speed;
  public $bats;
  public $throws;
  public $defense = array();
  public $j_val; 
  public $rating = array(); // 
  public $card = array();

  // pitcher
  public $s_grade;
  public $r_grade;
  public $xy;
  public $zw;
  public $p_star; // bool

  /**
   * 
   */
  public function __construct( $attrs ) {
    extract( $attrs );

    
  }

  private function set_card() {

  }

  private function set_rating() {
    // body...
  }

  public function __get( $prop ) {
    if ( property_exists( 'Player', $prop ) ) {
      return $this->$prop;
    }
  }

  public function __set( $prop, $val ) {
    if ( property_exists( 'Player', $prop ) ) {
      $this->$prop = $val;
    }
  }

}

?>
