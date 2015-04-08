<?php

require './vendor/autoload.php';
require 'libraries/Team.php';
use \Mockery as m;


class TestPlayer extends PHPUnit_Framework_TestCase
{

  public function setUp() {
    parent::setUp();
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function testTrue() {
    $this->assertTrue( true );
  }

} // eoc
