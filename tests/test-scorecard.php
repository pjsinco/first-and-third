<?php

require './vendor/autoload.php';
require_once 'libraries/Scorecard.php';
use \Mockery as m;

class Test_Scorecard extends PHPUnit_Framework_TestCase
{

  public function tearDown() {
    m::close();
  }

  public function test_runs_start_at_0() {
    $game = m::mock( 'Game' );
    $game->away_team = 'hou';
    $game->home_team = 'nya';

    $scorecard = new Scorecard( $game );
    $this->assertSame( 0, $scorecard->home_team_runs );
    $this->assertSame( 0, $scorecard->away_team_runs );
//    $expected_away = 'hou';
//    $expected_home = 'nya';
//
//    $this->assertEquals( $expected_away, $scorecard->away_team );
//    $this->assertEquals( $expected_home, $scorecard->home_team );
  }

  public function test_inning_half() {
    $this->markTestIncomplete();
  }

} // eoc



