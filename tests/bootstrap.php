<?php
require './vendor/autoload.php';
spl_autoload_register( function( $class ) {

  //$classPath = str_replace( '\\', '/', $class );
  include 'libraries/' . $class . '.php';

});

