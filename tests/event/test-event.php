<?php

require './vendor/autoload.php';
require 'libraries/Event.php';
use \Mockery as m;

class TestEvent extends PHPUnit_Framework_TestCase
{

  private $types = array(
    Event::TYPE_ID,
    Event::TYPE_VERSION,
    Event::TYPE_INFO,
    Event::TYPE_START,
    Event::TYPE_SUB,
    Event::TYPE_PLAY,
    Event::TYPE_BADJ,
    Event::TYPE_PADJ,
    Event::TYPE_DATA,
    Event::TYPE_COM,
  );

  public function setUp() {
    parent::setUp();
  }

  public function tearDown() {
    parent::tearDown();
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


  public function testConstructorMakesCorrectEventType() {
    try {
      $e = new Event( Event::TYPE_ID );
      $exp = 'id';
      $actual = $e->get_type();
      $this->assertEquals( $exp, $actual );

      $e = new Event( Event::TYPE_COM );
      $exp = 'com';
      $actual = $e->get_type();
      $this->assertEquals( $exp, $actual );


      $e = new Event();
      $exp = 'play';
      $actual = $e->get_type();
      $this->assertEquals( $exp, $actual );

      $e = new Event( 'data' );
      $exp = 'data';
      $actual = $e->get_type();
      $this->assertEquals( $exp, $actual );

    } catch ( Exception $e ) {
      echo 'error';
    }

  }

  public function testConstructorThrowsException() {
    $this->setExpectedException( 'InvalidArgumentException' );
    $e = new Event( 'badevent' );
    $e = new Event( 3 );
    $e = new Event( Event::BAD_EVENT );
  }

  public function testConstructorWithFields() {
    try {
      $fields = array( 'event_id' );
      $e = new Event( Event::TYPE_ID, $fields );
      $exp = 'event_id';
      $actual = $e->get_fields();
      $this->assertEquals( $exp, $actual );

      $fields = array(
        '7',
        '0',
        'saboc001',
        '01',
        'CX',
        '8/F78',
      );
      $e = new Event( 'play', $fields );
      $exp = '7,0,saboc001,01,CX,8/F78';
      $actual = $e->get_fields();
      $this->assertEquals( $exp, $actual );

    } catch (InvalidArgumentException $e) {
      echo ' error testConstructorWithFields ';
    }
  }

  public function testValid() {

    try {
      $fields = array( 'CLE197904250' );
      $e = new Event( Event::TYPE_ID, $fields );
      $this->assertTrue( $e->valid() );

      $e = new Event( Event::TYPE_PLAY, $fields );
      $actual = $this->invokeMethod( $e, 'valid', array() );
      $this->assertFalse( $actual );

    } catch (InvalidArgumentException $iae) {
      echo 'error testValid';
    }
  }

  public function testConstructorAddsValue() {

    try {
      $fields = array(
        '7',
        '0',
        'saboc001',
        '01',
        '',
        '8/F78',
      );
      $e = new Event( Event::TYPE_PLAY, $fields );
      $exp = 'play,7,0,saboc001,01,,8/F78';
      $actual = $e->__toString();
      $this->assertEquals( $exp, $actual );

      $e = new Event ( 'id', array( 'CLE197904250' ) );
      $exp = 'id,CLE197904250';
      $actual = $e;
      $this->assertEquals( $exp, $actual );

    } catch (InvalidArgumentException $e) {
      echo 'error testConstructorAddsValue';
    }
  }

  public function testSetGameId() {
    try {
      $e = new Event();
      $ts = mktime( 13, 10, 0, 4, 7, 1979 );
      $home_id = 'MIN';
      $visit_id = 'CLE';
      $e->set_game_id( $ts, $home_id, $visit_id );
    } catch (InvalidArgumentException $e) {
      echo 'error testSetGameId';
    }
  }

  public function testConstructorWithTwoArgsGetsFinalized() {

    try {
      $e = new Event( 'id', array( 'CLE197904250' ) );
      $exp = 'id,CLE197904250';
      $actual = $e->get_final_event();
      $this->assertEquals( $exp, $actual );
    } catch (InvalidArgumentException $e) {
      echo 'error testConstructorWithTwoArgsGetsFinalized';
    }
  }


} // eoc
