<?php 

$csv_file = file( '../data/test-box.csv' );

//foreach ( $csv_file as $line ) {
  //$row = str_getcsv( $line );
  //var_dump( $row );
//}

$data = csv_to_array( '../data/test-box.csv' );
var_dump($data);

/**
 * https://gist.github.com/jaywilliams/385876
 * Here is a quick and easy way to convert a CSV file to an associated 
 * array:
 */
function csv_to_array( $filename = '', $delim = ',' ) {

  if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
    return FALSE;
  }

  $header = NULL;
  $data = array();

  $handle = fopen( $filename, 'r' );

  if ( $handle !== FALSE ) {

    while ( $row = fgetcsv( $handle, 1000, $delim ) ) {
      if ( !$header ) {
        $header = $row;
      } else {
        $data[] = array_combine( $header, $row );
      }
    }
  }

  fclose( $handle );

  return $data;
}







?>

