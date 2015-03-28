<?php

require './vendor/autoload.php';
require 'src/class-result.php';

class Test_Result extends PHPUnit_Framework_TestCase
{

  public function test_true() {
    $this->assertTrue( true );
  }

  public function test_new_result_object_is_created() {
  
  }

} // eoc
