<?php 

$data = file( '../data/CLE1979.ROS' );

var_dump( is_file( '../data/CLE1979.ROS' ) );
foreach ($data as $row) {
  //echo $row;
}

/**
 * now let's try it fgets()
 */
$fp = fopen( '../data/CLE1979.ROS', 'r' );
while ( ! feof( $fp ) ) {
  $string = fgets( $fp );
  //echo $string;
}

fclose( $fp );

/**
 * Time for fgetcsv()
 */
$fp = fopen( '../data/CLE1979.ROS', 'r' );
while ( ! feof( $fp ) ) {
  $array = fgetcsv( $fp );
  print_r( $array );
}


?>
