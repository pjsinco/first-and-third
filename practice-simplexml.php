<?php
require_once 'vendor/oodle/krumo/class.krumo.php';

$board = simplexml_load_file( 'boards/game-board-5.xml' );

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
//$xpath = '//play[@val=21]/fielding[@val=2]';
//$xpath = '//play[@val=1]';
//$xpath = '//play[@val=9]';
//$xpath = '//play[@val=37]/fielding[@val=3]';
//$xpath = '//play[@val=29]/fielding[@val=3]';
//$xpath = '//play[@val=29]/fielding[@val=1]';
$conds = $board->xpath($xpath);

/**
 * Create an array of available conditions for this play value
 *
 */
$conditions = array();
$condition_keys = array();
foreach ( $conds[0] as $cond ) {

  // make sure we've got a <conditions> elem
  if ($cond->getName() == 'conditions') {

    // get the attributes of this <conditions> elem
    $atts = (array) $cond->attributes();

    // store them in our array
    $conditions[] = $atts['@attributes'];

  }
}

/**
 * Now that we have a 2D array of <conditions> attributes,
 * let's check each for matches against our $input.
 *
 * We should emerge with a single array, which we can then
 * use to build the final query for the play result.
 */
foreach ( $conditions as $condition ) {

  foreach ( $condition as $key => $value ) {
    
    if ( $input[$key] === $value ) {
      $matches = true; 
    } else {
      $matches = false;  // TODO needed?
      break; // we're done here
    }

  }    

  if ( $matches ) {
    $condition_keys[] = array_keys( $condition );
    // $condition_keys is a 2D array for now so we can easily test
    // it by counting its length
    
    // We're turning off the break for now so we can see if we
    // ever get more than one array in $condition_keys

    //break;
  }

}

// TODO
// we should have *zero or 1* array in $condition_keys;
// we need to be make sure this is true

if ( count( $condition_keys ) <= 1 ) {

  $q = null;
  foreach ( $condition_keys as $condition_key ) {

    $q = '/conditions';
    foreach ( $condition_key as $key ) {
    
      $q .= "[@$key=\"{$input[$key]}\"]";

    }
  
  }
  
// example xpath with not()
// we need the not()
//print_r( $board->xpath('//play[@val=9]/conditions[@against="c" and not(@two_outs|@zero_outs|@foo|@bar)]/result') ); die();

  // add $q if it has a value
  $xpath .= ( $q  ?  $q . '/result' : '/result' );
  echo $xpath . PHP_EOL;

} else {
  echo 'error in $condition_keys';
}
