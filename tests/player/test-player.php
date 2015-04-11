<?php

require './vendor/autoload.php';
use \Mockery as m;
use troutx\yaz\Player;


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
