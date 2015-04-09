<?php

require './vendor/autoload.php';
require 'libraries/Utils.php';
use \Mockery as m;
use org\bovigo\vfs as vfs;


class TestUtils extends PHPUnit_Framework_TestCase
{

  private $root;

  public function setUp() {
    parent::setUp();
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function testPathToDataDir() {
    $exp = '/Users/pj/Sites/first-and-third/data';
    $actual = Utils::path_to_data_dir();
    $this->assertEquals( $exp, $actual );
  }

  public function testPathToYearsDir() {
    $exp = '/Users/pj/Sites/first-and-third/data/years';
    $actual = Utils::path_to_years_dir();
    $this->assertEquals( $exp, $actual );
  }

  public function testFormatTeamFilename() {
    $years = array( '1900', 1911, 1970, ' 1971  ', 'foo' );
    foreach ( $years as $year ) {
      $exp = sprintf( 'TEAM%s', (string) trim( $year ) );
      $actual = Utils::format_team_filename( $year ); 
      $this->assertEquals( $exp, $actual );
    }
  }

  public function testValidYearReturnsTrue() {
    $year = '1969';
    $this->assertTrue( Utils::can_play_game_in_year( $year ) );
  }

  public function testValidYearReturnsFalse() {
    $years = array( '', 1968, '1968', '969', '1821', 'foo' );

    foreach ( $years as $year ) {
      $this->assertFalse( Utils::can_play_game_in_year( $year ) );
    }
  }

  public function testValidTeamReturnsTrue() {

    $year = 1969;
    $teams = array( 'BAL', 'NYA', 'CHN', 'DET', 'CLE' );
    foreach ( $teams as $team ) {
      $this->assertTrue( Utils::can_play_game_with_team( $year, $team ) );
    }
  }

} // eoc
