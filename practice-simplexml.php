<?php

$board = simplexml_load_file( 'game-board-alt.xml' );

/**
 * TEST INPUT
 *
 */
$input = array(
  // game
  'zero_outs'    => 'f',
  'two_outs'     => 'f',

  // defense
  'infield'      => 'd',
  'fielding'     => '2',

  // pitcher
  //'p_sym'        => array( 'x', 'z' ), // TODO s/b an array, i think
  'p_sym'        => 'x',
  'against'      => 'c',

  // offense
  'on_1b_speed'  => 's',
  'on_2b_speed'  => null,
  'on_3b_speed'  => 'n',
  'play_it_safe' => 'f',

  // batter
  'double_cols'  => 't',
  'batter_speed' => 'f',
  'star_14'  => 't',
);

/**
 * TEST QUERIES
 * 
 * Uncomment as needed
 */
$xpath = '//play[@val=12]/fielding[@val=2]';
$xpath = '//play[@val=1]';
$xpath = '//play[@val=9]';
//$xpath = '//play[@val=37]/fielding[@val=3]';
//$xpath = '//play[@val=29]/fielding[@val=3]';
$q_elems = $board->xpath($xpath);

/**
 * Create an array of available qualifiers for this play value
 *
 */
$qualifiers = array();
$qualifier_keys = array();
foreach ( $q_elems[0] as $q_elem ) {

  // get the attributes of this qualifiers element
  $atts = (array) $q_elem->attributes();

  // store them in our array
  $qualifiers[] = $atts['@attributes'];
}

/**
 * Now that we have a 2D array of <qualifier> attributes,
 * let's check each for matches against our $input.
 *
 * We should emerge with a single array, which we can then
 * use to build the final query for the play result.
 */
foreach ( $qualifiers as $qualifier ) {

  $matches = false;

  foreach ( $qualifier as $key => $value ) {
    
    if ( $input[$key] === $value ) {
      $matches = true; 
    } else {
      $matches = false;  // TODO needed?
      break; // we're done here
    }

  }    

  if ( $matches ) {
    $qualifier_keys[] = array_keys( $qualifier );
    // $qualifier_keys is a 2D array for now so we can easily test
    // it by counting its length
    
    // We're turning off the break for now so we can see if we
    // ever get more than one array in $qualifier_keys

    //break;
  }

}

// TODO
// we should have one array in $qualifier_keys;
// we need to be make sure this is true

print_r( $qualifier_keys );
//print_r( count( $qualifier_keys ) );

if ( count( $qualifier_keys ) == 1 ) {

  foreach ( $qualifier_keys as $qualifier_key ) {

    $q = '/qualifiers';
    foreach ( $qualifier_key as $key ) {
    
      $q .= "[@$key=\"{$input[$key]}\"]";

    }
  
  }
  
// example xpath with not()
// we need the not()
print_r( $board->xpath('//play[@val=9]/qualifiers[@against="c" and not(@two_outs|@zero_outs|@foo|@bar)]/result') ); die();

  $xpath .= $q . '/result';
  echo $xpath . PHP_EOL;

} else {
  // debug
  echo 'error in $qualifier_keys';
}
