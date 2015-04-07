<?php

require './vendor/autoload.php';
require 'libraries/Chadwick.php';
use \Mockery as m;

class Test_Chadwick extends PHPUnit_Framework_TestCase
{

  public $file;
  public $year;
  public $lotsa_false;

  public function setUp() {
    $this->file = 'test-event-master-0.eva';
    $this->year = '2014';
    $this->lotsa_false = 'test-lotsa-false.eva';
  }

  public function test_change_to_data_dir() {
    $this->assertTrue( Chadwick::change_to_data_dir() );
    $this->assertEquals( basename( getcwd() ), 'data' );

    chdir( '..' );
    $this->assertNotEquals( basename( getcwd() ), 'data' );
  }

  public function test_get_event_string_is_false() {
    $file = '';
    $this->assertFalse( Chadwick::get_event_string( $this->year, $file ) ) ;
    $this->assertFalse( Chadwick::get_event_string( $this->year, $this->lotsa_false ) ) ;
  }

  public function test_get_event_string_is_false_on_empty_year() {
    $year = '';
    $this->assertFalse( Chadwick::get_event_string( $year, $this->file ) ) ;
  }

  public function test_get_event_string_is_not_false() {
    $this->assertTrue( 
      (boolean) Chadwick::get_event_string( $this->year, $this->file ) 
    ) ;
  }

  public function test_get_last_play_is_correct() {
    $exp = 'play,9,1,martj006,21,BSBX,8/SF/F.3-H(UR)';
    $actual = Chadwick::get_last_play( $this->year, $this->file );
    $this->assertEquals( $exp, $actual );
    $this->assertFalse( Chadwick::get_last_play( '2014', $this->lotsa_false ) );
  }

  public function test_first_runner() {
    $exp = 'martv001';
    $actual = Chadwick::first_runner( $this->year, $this->file );
    $this->assertEquals( $exp, $actual );

    $this->assertFalse( 
      Chadwick::first_runner( $this->year, 'test-event-master-1.eva' )
    );

    $this->assertFalse( 
      Chadwick::first_runner( $this->year, 'test-event-master-2.eva' )
    );

    $this->assertFalse( Chadwick::first_runner( '2014', $this->lotsa_false ) );
  }

  public function test_second_runner() {
    $this->assertFalse( 
      Chadwick::second_runner( $this->year, 'test-event-master-0.eva' )
    );

    $this->assertFalse( 
      Chadwick::second_runner( $this->year, 'test-event-master-1.eva' )
    );

    $exp = 'longe001';
    $actual = Chadwick::second_runner( $this->year, 'test-event-master-2.eva' );
    $this->assertEquals( $exp, $actual );

    $this->assertFalse( Chadwick::second_runner( '2014', $this->lotsa_false ) );
  }

  public function test_third_runner() {
    $exp = 'huntt001';
    $actual = Chadwick::third_runner( $this->year, 'test-event-master-0.eva' );
    $this->assertEquals( $exp, $actual );

    $this->assertFalse( 
      Chadwick::third_runner( $this->year, 'test-event-master-1.eva' )
    );

    $this->assertFalse( 
      Chadwick::third_runner( $this->year, 'test-event-master-2.eva' )
    );

    $this->assertFalse( Chadwick::third_runner( '2014', $this->lotsa_false ) );
  }

  public function test_first_runner_dest() {
    $exp = '1';
    $actual = Chadwick::first_runner_dest( '2014', 'test-event-master-0.eva' );
    $this->assertEquals( $exp, $actual );

    $exp = '0';
    $actual = Chadwick::first_runner_dest( '2014', 'test-event-master-1.eva' );
    $this->assertEquals( $exp, $actual );

    $exp = '0';
    $actual = Chadwick::first_runner_dest( '2014', 'test-event-master-2.eva' );
    $this->assertEquals( $exp, $actual );

    $this->assertFalse( Chadwick::first_runner_dest( '2014', $this->lotsa_false ) );
  }

  public function test_second_runner_dest() {
    $exp = '0';
    $actual = Chadwick::second_runner_dest( '2014', 'test-event-master-0.eva' );
    $this->assertEquals( $exp, $actual );

    $exp = '0';
    $actual = Chadwick::second_runner_dest( '2014', 'test-event-master-1.eva' );
    $this->assertEquals( $exp, $actual );

    $exp = '2';
    $actual = Chadwick::second_runner_dest( '2014', 'test-event-master-2.eva' );
    $this->assertEquals( $exp, $actual );

    $this->assertFalse( Chadwick::second_runner_dest( '2014', $this->lotsa_false ) );
  }

  public function test_third_runner_dest() {
    $exp = '5';
    $actual = Chadwick::third_runner_dest( '2014', 'test-event-master-0.eva' );
    $this->assertEquals( $exp, $actual );

    $exp = '0';
    $actual = Chadwick::third_runner_dest( '2014', 'test-event-master-1.eva' );
    $this->assertEquals( $exp, $actual );

    $exp = '0';
    $actual = Chadwick::third_runner_dest( '2014', 'test-event-master-2.eva' );
    $this->assertEquals( $exp, $actual );

    $this->assertFalse( Chadwick::third_runner_dest( '2014', $this->lotsa_false ) );
  }

  public function test_batter_dest() {
    $exp = '0';
    $actual = Chadwick::batter_dest( '2014', 'test-event-master-0.eva' );
    $this->assertEquals( $exp, $actual );

    $actual = Chadwick::batter_dest( '2014', 'test-event-master-1.eva' );
    $this->assertEquals( $exp, $actual );

    $actual = Chadwick::batter_dest( '2014', 'test-event-master-2.eva' );
    $this->assertEquals( $exp, $actual );

    $this->assertFalse( Chadwick::batter_dest( '2014', $this->lotsa_false ) );
  }

  public function test_last_play_event_num() {

    $exp = '81';
    $actual = Chadwick::last_play_event_num( '2014', 'test-event-master-0.eva' );
    $this->assertEquals( $exp, $actual );

    $exp = '75';
    $actual = Chadwick::last_play_event_num( '2014', 'test-event-master-1.eva' );
    $this->assertEquals( $exp, $actual );

    $exp = '78';
    $actual = Chadwick::last_play_event_num( '2014', 'test-event-master-2.eva' );
    $this->assertEquals( $exp, $actual );

    $this->assertFalse( Chadwick::last_play_event_num( '2014', $this->lotsa_false ) );
  }

  public function testOutsOnPlay() {
    $exp = '1';
    $actual = Chadwick::outs_on_play( '2014', 'test-event-master-0.eva' );
    $this->assertEquals( $exp, $actual );

    $actual = Chadwick::outs_on_play( '2014', 'test-event-master-1.eva' );
    $this->assertEquals( $exp, $actual );

    $actual = Chadwick::outs_on_play( '2014', 'test-event-master-2.eva' );
    $this->assertEquals( $exp, $actual );
  }

} // eoc
