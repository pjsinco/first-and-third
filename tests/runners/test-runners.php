<?php

require './vendor/autoload.php';
require 'libraries/Runners.php';
use \Mockery as m;

class Test_Runners extends PHPUnit_Framework_TestCase {


  public function setUp() {
    parent::setUp();
  }

  public function tearDown() {
    parent::tearDown();
    m::close();
  }

  /**
   * With this, we can test a private or protected method
   *
   */
  public function invokeMethod( 
    &$object, 
    $method_name, 
    array $parameters = array() ) {

    $reflection = new ReflectionClass( get_class( $object ) );
    $method = $reflection->getMethod( $method_name );
    $method->setAccessible( true );
    return $method->invokeArgs( $object, $parameters );
  }

  public function testRunnersAtOutsetAreEmpty() {
    $runners = new Runners();
    $this->assertEquals( '', $runners->on_1b() );
    $this->assertEquals( '', $runners->on_2b() );
    $this->assertEquals( '', $runners->on_3b() );
  }

  public function testBatterIsSetInConstructor() {
    $runners = new Runners( 'bondb001' );
    $this->assertEquals( 'bondb001', $runners->batter() );

    $runners = new Runners();
    $this->assertEquals( '', $runners->batter() );
  }

  public function testSetOnABase() {
    $runners = new Runners();
    $runners->set_on_1b( 'alexg101' );
    $exp = 'alexg101';
    $actual = $runners->on_1b();
    $this->assertEquals( $exp, $actual );

    $runners->set_on_2b( 'thora001' );
    $exp = 'thora001';
    $actual = $runners->on_2b();
    $this->assertEquals( $exp, $actual );

    $runners->set_on_3b( 'kuipd001' );
    $exp = 'kuipd001';
    $actual = $runners->on_3b();
    $this->assertEquals( $exp, $actual );
  }

  public function testSetOnABaseFailsWhenBaseOccupied() {
    $runners = new Runners();
    $runners->set_on_1b( 'alexg101' );
    $this->assertFalse( $runners->set_on_1b( 'kuipd001' ) );

    $runners->set_on_2b( 'kuipd001' );
    $this->assertFalse( $runners->set_on_2b( 'bondb001' ) );

    $runners->set_on_3b( 'bondb001' );
    $this->assertFalse( $runners->set_on_3b( 'thora001' ) );
  }

  public function testSetOnABaseFailsWhenRunnerAlreadyOnABase() {
    $runners = new Runners();
    $runners->set_on_2b( 'alexg101' );
    $this->assertEquals( 'alexg101', $runners->on_2b() );
    $this->assertFalse( $runners->set_on_3b( 'alexg101' ) );
    $this->assertFalse( $runners->set_on_2b( 'alexg101' ) );

  }

  public function testClearBase() {
    $runners = new Runners();
    $runners->set_on_3b( 'alexg101' );
    $this->assertEquals( 'alexg101', $runners->on_3b() );
    $runners->clear_base( '3b' );
    $this->assertEquals( '', $runners->on_3b() );

    $runners->set_on_2b( 'alexg101' );
    $this->assertEquals( 'alexg101', $runners->on_2b() );
    $runners->clear_base( 2 );
    $this->assertEquals( '', $runners->on_2b() );

    $runners->set_on_1b( 'alexg101' );
    $this->assertEquals( 'alexg101', $runners->on_1b() );
    $runners->clear_base( '  1b ' );
    $this->assertEquals( '', $runners->on_1b() );

    $runners->set_batter( 'bondb001' );
    $runners->clear_base( 0 ) ;
    $this->assertEquals( '', $runners->batter() );
  }

  public function testSetBatter() {
    $runners = new Runners();
    $this->assertEquals( '', $runners->batter() );
    $runners->set_batter( 'bondb001' );
    $exp = 'bondb001';
    $actual = $runners->batter();
    $this->assertEquals( $exp, $actual );

    $runners->set_batter( '' );
    $exp = 'bondb001';
    $this->assertEquals( $exp, $runners->batter() );

    $runners->set_batter( 'kuipd001' );
    $runners->set_batter( 'alexg101' );
    $exp = 'alexg101';
    $actual = $runners->batter();
    $this->assertEquals( $exp, $actual );

    $runners = new Runners();
    $runners->set_batter( '' );
    $this->assertEquals( '', $runners->batter() );

    $runners->set_batter( 'bondb001' );
    $runners->set_batter( 'kuipd001' );
    $this->assertEquals( 'kuipd001', $runners->batter() );
  }

  public function testBaseParse() {

    $runners = new Runners();
    $base = 3;
    $exp = 3;
    $actual = 
      $this->invokeMethod( $runners, 'parse_base', array( $base ) );
    $this->assertEquals( $exp, $actual );

    $actual =
      $this->invokeMethod( $runners, 'parse_base', array( 7 ) );
    $this->assertFalse( $actual );

    $exp = 2;
    $actual =
      $this->invokeMethod( $runners, 'parse_base', array( '2' ) );
    $this->assertEquals( $exp, $actual );

    $exp = 1;
    $actual =
      $this->invokeMethod( $runners, 'parse_base', array( '  1b ' ) );
    $this->assertEquals( $exp, $actual );

    $exp = 3;
    $actual =
      $this->invokeMethod( $runners, 'parse_base', array( '3b' ) );
    $this->assertEquals( $exp, $actual );

    $actual =
      $this->invokeMethod( $runners, 'parse_base', array( '2c' ) );
    $this->assertFalse( $actual );
  }

  public function testAdvanceAdvancesRunners() {
    $runners = new Runners();
    $runners->set_on_2b( 'alexg101' );
    $this->assertEquals( 'alexg101', $runners->on_2b() );

    $runners->advance( 2, 3 );
    $this->assertEquals( 'alexg101', $runners->on_3b() );
    $this->assertEquals( '', $runners->on_2b() );
    
    $runners = new Runners();
    $runners->set_on_1b( 'bondb001' );
    $runners->advance( '1b', '3b' );
    $this->assertEquals( 'bondb001', $runners->on_3b() );
    $this->assertEquals( '', $runners->on_1b() );

    $runners = new Runners();
    $runners->set_on_1b( 'bondb001' );
    $runners->advance( '  1  ', ' 3 ' );
    $this->assertEquals( 'bondb001', $runners->on_3b() );
    $this->assertEquals( '', $runners->on_1b() );

    $runners->advance( 3, 'h' );
    $this->assertEquals( 'bondb001', $runners->on_home() );

    $runners = new Runners();
    $runners->set_batter( 'bondb001' );
    $runners->advance( 0, 2 );
    $this->assertEquals( 'bondb001', $runners->on_2b() );

  }

  public function testAdvanceFailsWithBadParams() {
    $runners = new Runners();
    $runners->set_on_2b( 'alexg101' );
    $this->assertEquals( 'alexg101', $runners->on_2b() );

    $runners->advance( 1, 3 );
    $this->assertNull( $runners->on_3b() );
    $this->assertEquals( 'alexg101', $runners->on_2b() );

    $runners = new Runners();
    $this->assertNull( $runners->on_1b() );
    $this->assertFalse( $runners->advance( 1, 3 ) );
  }

  public function testRunnerIsAlreadyOnBase() {
    $runners = new Runners();
    $runners->set_on_2b( 'alexg101' );
    $this->assertEquals( 'alexg101', $runners->on_2b() );

    $this->assertTrue( $runners->on_base( 'alexg101' ) );
    $this->assertFalse( $runners->on_base( 'bondb001' ) );
  }

  public function testAdvanceBatter() {
    $runners = new Runners( 'bondb001' );
    $runners->advance_batter( '2b' );

    $this->assertEquals( 'bondb001', $runners->on_2b() );

    $runners->set_batter( 'alexg101' );
    $runners->advance_batter( '2b' );
    $this->assertFalse( $runners->advance_batter( 2 ) );

    $runners = new Runners();
    $this->assertFalse( $runners->advance_batter( 3 ) );
    $runners->set_batter( 'bondb001' );
    $runners->advance_batter( 3 );
    $this->assertEquals( 'bondb001', $runners->on_3b() );
  }

  public function testCanTakeBase() {
    $runners = new Runners();
    $actual = 
      $this->invokeMethod( $runners, 'can_take_base', array( 'bondb001', '1b' ) );
    $this->assertTrue( $actual );

    $actual = 
      $this->invokeMethod( $runners, 'can_take_base', array( 'bondb001', '2' ) );
    $this->assertTrue( $actual );

    $actual = 
      $this->invokeMethod( $runners, 'can_take_base', array( 'bondb001', 3 ) );
    $this->assertTrue( $actual );

    $actual = 
      $this->invokeMethod( $runners, 'can_take_base', array( 'bondb001', '1b' ) );
    $this->assertTrue( $actual );

    $actual = 
      $this->invokeMethod( $runners, 'can_take_base', array( 'bondb001', '5' ) );
    $this->assertTrue( $actual );

    $actual = 
      $this->invokeMethod( $runners, 'can_take_base', array( 'bondb001', 0 ) );
    $this->assertTrue( $actual );

    $actual = 
      $this->invokeMethod( $runners, 'can_take_base', array( 'bondb001', 'h' ) );
    $this->assertTrue( $actual );

    $actual = 
      $this->invokeMethod( $runners, 'can_take_base', array( 'bondb001', 7 ) );
    $this->assertFalse( $actual );
  }


} // eoc
