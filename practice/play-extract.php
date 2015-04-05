<?php 

echo 'play extract';

$args = array(
  'two_outs' => true,
  'p_sym' => 'x',
);

extract( $args );

echo '<pre>'; var_dump($p_sym); echo '</pre>'; die();

?>
