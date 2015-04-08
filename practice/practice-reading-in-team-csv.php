<?php 

require_once 'libraries/Utils.php';

Utils::change_to_data_dir();
$team = Utils::csv_to_array( 'BAL1969.csv' );
//print_r($team);
echo( $team['palmj001']['retroId'] ) . PHP_EOL;
echo( $team['palmj001']['sGrade'] ) . PHP_EOL;

?>

