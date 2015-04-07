<?php 

/**
 * Event
 */
class Event
{
  // record types
  const TYPE_ID = 'id';
  const TYPE_VERSION = 'version';
  const TYPE_INFO = 'info';
  const TYPE_START = 'start';
  const TYPE_SUB = 'sub';
  const TYPE_PLAY = 'play';
  const TYPE_BADJ = 'badj';
  const TYPE_PADJ = 'padj';
  const TYPE_DATA = 'data';
  const TYPE_COM = 'com';

  // Game-related info record types 
  const INFO_VISTEAM = 'visteam';
  const INFO_HOMETEAM = 'hometeam';
  const INFO_DATE = 'date';
  const INFO_NUMBER = 'number';
  const INFO_STARTTIME = 'starttime';
  const INFO_DAYNIGHT = 'daynight';
  const INFO_USEDH = 'usedh'; 
  const INFO_UMPHOME = 'umphome';
  const INFO_UMP1B = 'ump1b';
  const INFO_UMP2B = 'ump2b';
  const INFO_UMP3B = 'ump3b';
  const INFO_FIELDCOND = 'fieldcond';
  const INFO_PRECIP = 'precip';
  const INFO_SKY = 'sky';
  const INFO_TEMP = 'temp';
  const INFO_WINDDIR = 'winddir';
  const INFO_TIMEOFGAME = 'timeofgame';
  const INFO_ATTENDANCE = 'attendance';
  const INFO_SITE = 'site';
  const INFO_WP = 'wp';
  const INFO_LP = 'lp';
  const INFO_SAVE = 'save';
  const INFO_GWRBI = 'gwrbi';

  // administrative data
  const INFO_INPUTTIME = 'inputtime';

  private $types = array(
    self::TYPE_ID,
    self::TYPE_VERSION,
    self::TYPE_INFO,
    self::TYPE_START,
    self::TYPE_SUB,
    self::TYPE_PLAY,
    self::TYPE_BADJ,
    self::TYPE_PADJ,
    self::TYPE_DATA,
    self::TYPE_COM,
  );

  private $type;
  private $fields = array();
  private $output; // the final event
  
  /**
   * If fields are passed in, this event attempts to finalize.
   *
   * @param constant (string) - type of event
   * @param array of strings (optional) - the fields for this event
   *
   */
  public function __construct( $type = self::TYPE_PLAY, $fields = array() ) {
    if ( ! $this->set_type( $type ) || !is_array( $fields ) ) {
      throw new InvalidArgumentException();
    }

    if ( $fields ) {
      $this->fields = $fields;
      $this->finalize();
    }
  }

  /**
   * Finalize the event. At finish, event is ready for writing to file.
   *
   * @return boolean - whether the event has been finalized
   */
  public function finalize() {
    if ( $this->valid() ) {
      $out = fopen( 'php://output', 'w' );
      $data = array_merge( array( $this->type ), $this->fields );
      ob_start();
      fputcsv( $out, $data );
      fclose( $out );
      $this->output = trim( ob_get_clean() );
      return true;
    } else {
      return false;
    }
  }

  /**
   * Returns the final event string
   *
   * @return string - the final event
   *   boolean false if there's a problem
   */
  public function get_final_event() {
    if ( $this->is_final() ) {
      return $this->output;
    } else {
    return false;
    }
  }

  /**
   * Sets the event type 
   *
   * @param string - the event type
   * @return boolean - whether the event type was set
   */
  private function set_type( $type ) {
    if ( $this->valid_type( $type ) !== FALSE ) {
      $this->type = $type;
      return true;
    } else {
      return false;
    }
  }

  /**
   * Determines whether a type is a valid event type
   *
   * @param string $type
   * @return - whether the type is a valid event type
   */
  private function valid_type( $type ) {
    return array_search( $type, $this->types );
  }

  /**
   * Creates a game id
   *
   * @param $ts int - UNIX timestamp
   * @param $home_id  string - team ID of home team
   * @param $visit_id  string - team ID of visting team
   */
  public function set_game_id( $ts, $home_id, $visit_id ) {

    $this->type = self::TYPE_ID;
    $date = $this->format_timestamp_for_id( $ts );

  }

  /**
   * TODO needed?
   * Adds a value to the event
   *
   * @param string $val - the value to add
   * @return boolean - whether the value was set
   */
  private function add_field( $field ) {
    $this->fields[] = $field;
  }

  /**
   * Determines whether this event has a type
   *
   * @return boolean - whether this event has a type
   *
   */
  private function has_type() {
    return empty( $this->type ) !== FALSE;
  }

  /**
   * Determines whether this event has at least 1 value
   *
   * @return boolean - whether this event has a value
   *
   */
  private function has_value() {
    return count( $this->fields ) > 0;
  }

  /**
   * Determines whether this event is valid
   *
   * A valid event has the corrent number of fields, 
   * per the Retrosheet event guide:
   * http://www.retrosheet.org/eventfile.htm#5
   *
   * @return boolean - whether this event is valid
   */
  public function valid() {
    $num_fields = null;

    if ( ! $this->type ) {
      return false;
    }

    switch ( $this->type ) {
      case self::TYPE_ID:
        $num_fields = 1;
        break;
      case self::TYPE_VERSION:
        $num_fields = 1;
        break;
      case self::TYPE_INFO:
        $num_fields = 2;
        break;
      case self::TYPE_START:
        $num_fields = 5;
        break;
      case self::TYPE_SUB:
        $num_fields = 5;
        break;
      case self::TYPE_PLAY:
        $num_fields = 6;
        break;
      case self::TYPE_BADJ:
        $num_fields = 2;
        break;
      case self::TYPE_PADJ:
        $num_fields = 2;
        break;
      case self::TYPE_DATA:
        $num_fields = 3;
        break;
      case self::TYPE_COM:
        $num_fields = 1;
        break;
    }

    if ( count( $this->fields ) == $num_fields ) {
      return true;
    }

    return false;
  }

  /**
   * Get all values set for this event
   *
   * @return array - all event values
   */
  public function get_fields() {
    return implode( ',', $this->fields );
  }


  /**
   * Formats the date for use in a 12-character id record type
   *
   * @param $date int UNIX timestamp
   */
  private function format_timestamp_for_id( $ts ) {
    if ( $this->is_valid_timestamp( $ts ) ) {
      return date( 'Ydm', $ts );
    } else {
      return false;
    }
  }

  /**
   * Checks whether a value is a timestamp
   *
   * http://stackoverflow.com/questions/2524680/
   *   check-whether-the-string-is-a-unix-timestamp
   */
  private function is_valid_timestamp( $ts ) {
    return $ts <= PHP_INT_MAX && $ts >= ~PHP_INT_MAX;
  }

  /**
   * Returns the type for this event
   *
   * @return string - the event type
   */
  public function get_type() {
    return $this->type;
  }

  /**
   * Represents the event as a string
   *
   * @return string - representation of this event instance
   */
  public function __toString() {
    if ( $this->is_final() ) {
      return $this->output;
    } else {
      return $this->type . ',' . implode( ',', $this->fields );
    }
  }

  /**
   * Determines whether the event has been finalized
   *
   * @return boolean - whether the event is final
   */
  public function is_final() {
    return (bool) $this->output;
  }
} // eoc

?>
