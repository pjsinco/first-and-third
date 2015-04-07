<?php 

/**
 * BattingOrder
 */
class BattingOrder implements Iterator
{
  private $pos;
  private $max_pos = 8;
  private $order;
  
  /**
   *  @param $lineup - array of player IDs in batting order 
   *
   */
  public function __construct( $order ) {
    if ( $order == NULL || count( $order ) !== 9 ) {
      throw new InvalidArgumentException();
    }

    $this->order = $order;
    $this->pos = 0;
  }

  public function current() {
    return $this->order[$this->pos];
  }

  public function key() {
    return $this->pos;
  }

  public function next() {

    if ( $this->valid() ) {
      ++$this->pos;
    } else {
      $this->rewind();
    }

    return $this->pos;
  }

  public function rewind() {
    $this->pos = 0;
  }

  public function valid() {
    return $this->pos < $this->max_pos;
  }

  public function __toString() {
    echo PHP_EOL;
    $str = '';
    foreach ( $this->order as $batter ) {
      if ( $batter == $this->current() ) {
        $str .= ' >' . $batter . PHP_EOL;
        continue;
      }
      $str .= '  ' . $batter . PHP_EOL;
    }
    return $str . PHP_EOL;
  }

} // eoc

?>
