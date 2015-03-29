<?php

require './vendor/autoload.php';
require 'libraries/Game.php';
use \Mockery as m;

class Test_Game extends PHPUnit_Framework_TestCase
{
  private $game;

  public function setUp() {
    parent::setUp();
    $this->game = new Game( 'hou', 'nya', 'Doubleday Field' );
  }
  public function tearDown() {
    m::close();
  }

  public function test_team_names_set() {
    $expected_away = 'hou';
    $expected_home = 'nya';

    $this->assertEquals( $expected_away, $this->game->away_team );
    $this->assertEquals( $expected_home, $this->game->home_team );
  }

  public function test_game_over() {
    $this->assertFalse( $this->game->game_over() );
  }

  public function test_set_game_over() {
    $this->game->game_over = true;
    $this->assertTrue( $this->game->game_over() );
  }

} // eoc



