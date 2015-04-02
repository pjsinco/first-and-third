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

  // pitcher
  public $grade;
  public $p_sym;
  public $p_star; // bool

  /**
   * 
   */
  public function __construct() {
    
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
