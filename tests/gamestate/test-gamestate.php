<?php

require './vendor/autoload.php';
require 'libraries/GameState.php';
use \Mockery as m;

class Test_GameState extends PHPUnit_Framework_TestCase
{
  private $game_state;

  public function setUp() {
    parent::setUp();
  }
  public function tearDown() {
    m::close();
  }

  public function testTrue() {
    $this->assertTrue( true );
  }



} // eoc

