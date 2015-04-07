<?php 

require_once 'libraries/BattingOrder.php';
require_once 'libraries/Chadwick.php';
require_once 'libraries/Runners.php';

$lineup = array(
  'harrt001',
  'mannr001',
  'bondb101',
  'thora001',
  'alexg101',
  'cagew101',
  'cox-t101',
  'kuipd001',
  'veryt001',
);
$order = new BattingOrder( $lineup );
$batter = $order->current();
$runners = new Runners( $batter );

echo '----------------------------------';
echo $order;
$result = Chadwick::get_last_play( '1979', 'practice-reading-an-event-file.eva' );
$batter_dest = Chadwick::batter_dest( '1979', 'practice-reading-an-event-file.eva' );
$runners->advance_batter( $batter_dest );
echo $runners;
echo '----------------------------------';
$order->next();

echo '----------------------------------';
echo $order;
$result = Chadwick::get_last_play( '1979', 'practice-reading-an-event-file.eva' );
$batter_dest = Chadwick::batter_dest( '1979', 'practice-reading-an-event-file.eva' );
$runners->advance_batter( $batter_dest );
$runners->
echo $runners;
echo '----------------------------------';


?>
