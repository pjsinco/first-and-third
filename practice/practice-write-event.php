<?php

$file = '../data/practice-writing-an-event-file.eva';

if ( is_writable( $file ) ) {
  $data = 'id,DET201406150';
  file_put_contents( $file, $data . PHP_EOL );
}

?>
