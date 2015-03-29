<?php 

/**
 * Inning
 */
class Inning
{

  public $num;
  public $outs;
  public $half;
  
  public function __construct( $num ) {
    $this->num = $num;  
    $this->outs = 0;
    $this->half = 'top';
  }

  /**
   * Sets the inning half
   * @param string $half the half of the inning
   * @return boolean whether the inning half was set
   */
  public function set_half( $half ) {
    if ( $half != 'top' && $half != 'bottom' ) {
      return false;
    } else {
      $this->half = $half;
      return true;
    }
  }

  public function get_half() {
    return $this->half;
  }

  public function add_outs( $outs ) {
    $this->outs += $outs;
  }

  public function get_outs() {
    return $this->outs;
  }

} // eoc

?>
