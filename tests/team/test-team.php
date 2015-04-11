<?php

require 'vendor/autoload.php';
use \Mockery as m;
use \troutx\yaz\Team;


class TestTeam extends PHPUnit_Framework_TestCase
{

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


  public function testConstructorThrowsException() {
    $this->setExpectedException( 'InvalidArgumentException' );
    $team = new Team( '1969', 'NYA' );
    
  }

//  public function testGetTeamFilename() {
//    $this->markTestIncomplete();
//    $exp = 'BAL1969.csv';
//    $team = new Team( '1969', 'BAL' );
//  }

} // eoc
