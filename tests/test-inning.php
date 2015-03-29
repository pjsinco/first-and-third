<?php

require './vendor/autoload.php';
require 'libraries/Inning.php';
use \Mockery as m;

class Test_Inning extends PHPUnit_Framework_TestCase
{
  private $game;

  public function setUp() {
    parent::setUp();
    $this->inning = new Inning( 5 );
  }
  public function tearDown() {
    m::close();
  }

  public function test_inning_num_is_set() {
    $expected = 5;
    $this->assertEquals( 5, $this->inning->num );
  }

  public function test_new_inning_values() {
    $expected_outs = 0;
    $expected_half = 'top';

    $this->assertEquals( $expected_outs, $this->inning->get_outs() );
    $this->assertEquals( $expected_half, $this->inning->get_half() );
  }

  public function test_set_half() {
    $expected_half = 'bottom';
    $this->inning->set_half( 'bottom' );

    $this->assertEquals( $expected_half, $this->inning->get_half() );
  }

  public function test_add_outs() {
    $expected = 2;
    $this->inning->add_outs( 2 );
    $this->assertEquals( $expected, $this->inning->get_outs() );
  }


} // eoc



