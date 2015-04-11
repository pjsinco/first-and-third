<?php 

namespace troutx\yaz;

require 'vendor/autoload.php';

/**
 * Runners
 * TODO
 *  We may only want to allow runners to advance with advance(),
 *    so maybe get rid of set_on_Xb()
 */
class Runners
{
  private $runners = array();

  public function __construct( $batter = '' ) {
    $this->runners = [$batter, null, null, null];
  }

  /**
   * Convenience method to advance the batter.
   * @uses advance()
   *
   */
  public function advance_batter( $base ) {
    $base = $this->parse_base( $base );

    if ( $this->can_take_base( $this->runners[0], $base ) ) {
      $this->advance( 0, $base );
    } else {
      return false;
    }
  }

  /**
   * Determines whether a runner can advance to a base.
   *
   * @return boolean - whether the advancement is possible
   */
  private function can_take_base( $id, $base ) {
    $base = $this->parse_base( $base );
    if ( 
      empty( $id ) ||
      $this->on_base( $id ) || 
      ! $this->base_empty( $base ) || 
      $base === FALSE ) {
      return false;
    } 

    return true;
  }

  /**
   * Empties a base of its runner
   *
   * @return boolean false - if there's a problem
   */
  public function clear_base( $base ) {
    $base = $this->parse_base( $base );
    
    if ( $base === FALSE ) {
      return false;
    } 

    $this->runners[$base] = '';
    return true;
  }

  public function set_batter( $id ) {
    if ( empty( $id ) ) {
      return false;
    }
    $this->runners[0] = $id;
  }

  public function base_empty( $base ) {
    $base = $this->parse_base( $base );
    return empty( $this->runners[$base] );
  }

  public function set_on_1b( $id ) {
    // make sure base is empty and runner is not already on a base
    if ( empty( $this->runners[1] ) && ! $this->on_base( $id ) ) {
      $this->runners[1] = $id;
    } else {
      return false;
    }
  }

  public function set_on_2b( $id ) {
    // make sure base is empty and runner is not already on a base
    if ( empty( $this->runners[2] ) && ! $this->on_base( $id ) ) {
      $this->runners[2] = $id;
    } else {
      return false;
    }
  }

  public function set_on_3b( $id ) {
    // make sure base is empty and runner is not already on a base
    if ( empty( $this->runners[3] ) && ! $this->on_base( $id ) ) {
      $this->runners[3] = $id;
    } else {
      return false;
    }
  }

  /**
   * Checks whether a runner is already on base
   *
   * @return boolean whether runner is on a base
   */
  public function on_base( $id ) {

    for ( $i = 1; $i <= 3; $i++) {
      if ( strpos( $this->runners[$i], $id ) !== FALSE ) {
        return true;
      }
    }

    return false;
  }

  /**
   * Advances runner to specified base
   *
   * @param int $from_base 
   * @param int $to_base 
   */
  public function advance( $from_base, $to_base ) {

    $from_base = $this->parse_base( $from_base );
    $to_base = $this->parse_base( $to_base );

    /**
     * We're only going allow runners to move forward.
     */
    if ( 
      $from_base  === FALSE ||  // failed on parse_base()
      $to_base  === FALSE ||    // failed on parse_base()
      ! empty( $this->runners[$to_base] ) || // make sure base in front is empty
      $from_base > $to_base ||
      $this->runners[$from_base] == null 
    ) {
      return false;
    }

    $this->runners[$to_base] = $this->runners[$from_base];
    $this->clear_base( $from_base );

  }

  private function parse_base( $base ) {
    $base = trim( $base );
    if ( ! preg_match( '/^[0-6]$|^[0-3]+b?$|^h$/', $base ) ) {
      return false;
    }

    if ( strpos( $base, 'h' ) !== FALSE ) {
      $base = 4;
      return $base;
    } elseif ( strpos( $base, 'b' ) !== FALSE ) {
      return (int) str_replace( 'b', '', $base );
    } else {
      return (int) $base;
    }
  }

  public function batter() {
    return $this->runners[0];
  }

  public function on_1b() {
    return $this->runners[1];
  }

  public function on_2b() {
    return $this->runners[2];
  }

  public function on_3b() {
    return $this->runners[3];
  }

  public function on_home() {
    return $this->runners[4];
  }

  public function __toString() {
    return sprintf( "\n1B: %s\n2B: %s\n3B: %s\n b: %s\n",
      $this->runners[1] != FALSE ? $this->runners[1] : 'empty',
      $this->runners[2] != FALSE ? $this->runners[2] : 'empty',
      $this->runners[3] != FALSE ? $this->runners[3] : 'empty',
      $this->runners[0] != FALSE ? $this->runners[0] : 'empty'
    );

  }
} // eoc

?>
