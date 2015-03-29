<?php

require './vendor/autoload.php';
require 'libraries/Result.php';
use \Mockery as m;

class Test_Result extends PHPUnit_Framework_TestCase
{

  public function tearDown() {
    m::close();
  }

  /**
   * Help us test a private or protected method
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

  public function test_format_xpath() {
    $game_state = m::mock( 'GameState' );
    $game_state ->shouldReceive( 'get_fielding' )
      ->andReturn( 2 );
    $game_state->infield = 'c';
      //->times(2);
    $board_val = 12;

    $result = new Result( $board_val, $game_state );

    $expected = '//play[@val=12]/fielding[@val=2]';

    $actual = 
      $this->invokeMethod( $result, 'format_xpath', array( $board_val ) );

    $this->assertEquals( $expected, $actual, 'xpath is not formatted correctly' );

    
    //'//play[@val=%1$s]/fielding[@val=%2$s]',
  }

  public function test_fetch_result() {
   $game_state = m::mock( 'GameState' );
   $game_state->shouldReceive( 'get_fielding' )
      ->andReturn( 3 );
   $game_state->on_1b_speed = 's';
   $board_val = 37;
   $result = new Result( $board_val, $game_state );
   
   $this->assertEquals( 'Runner on first holds', $result->des );
   $this->assertEquals( '0', $result->outs );
   $this->assertEquals( '0', $result->runs );
   $this->assertEquals( '5', $result->state );
   $this->assertEquals( 'action', $result->type );
  }

  public function test_get_result_attrs() {
    $result_xml[] = new SimpleXMLElement( '<result des="Runner on first out stealing 2nd; A-C PO-SS; other scores" outs="1" runs="1" state="0" type="action"/>' );

    $game_state = m::mock( 'GameState' );
    $game_state ->shouldReceive( 'get_fielding' )
      ->andReturn( 2 );
    $game_state->two_outs = 'f';
    $board_val = 37;
    $result = new Result( $board_val, $game_state );

    $expected = array(
      'des' => 'Runner on first out stealing 2nd; A-C PO-SS; other scores',
      'outs' => '1',
      'runs' => '1',
      'state' => '0',
      'type' => 'action',
    );

    $actual = 
      $this->invokeMethod( $result, 'get_result_attrs', $result_xml );

    $this->assertEquals( $expected, $actual );
  }

  public function test_set_result_attrs() {
    $game_state = m::mock( 'GameState' );
    $game_state ->shouldReceive( 'get_fielding' )
      ->andReturn( 1 );
    $game_state->two_outs = 't';
    $game_state->infield = 'd';
    $game_state->zero_outs = 'f';

    $attrs = array(
      'des' => 'Groundout; A-1B PO-P',
      'outs' => '1',
      'runs' => '0',
      'state' => '6',
      'type' => 'atbat',
    );

    $result = new Result( 12, $game_state );

    $this->assertEquals( $attrs['des'], $result->des );
  }

  public function test_fetch_conditions() {
    $expected = array(
      ['two_outs'],
      
    );
  }

  public function test_is_fielding_phase() {
    $game_state = m::mock( 'GameState' );
    $game_state ->shouldReceive( 'get_fielding' )
      ->andReturn( 1 );
    $game_state->two_outs = 't';
    $game_state->zero_outs = 'f';
    $game_state->infield = 'd';
    $game_state->against = 'c';
    $game_state->p_sym = 'x';

    $vals = array( 1, 9 );

    foreach ( $vals as $board_val ) {
      $result = new Result( $board_val, $game_state );
      $this->assertFalse( 
        $this->invokeMethod( $result, 'is_fielding_phase', array( $board_val ) )
      );
    }

    $vals = array( 12, 14, 21, 29, 37 );
    foreach ( $vals as $board_val ) {
      $result = new Result( $board_val, $game_state );
      $this->assertTrue( 
        $this->invokeMethod( $result, 'is_fielding_phase', array( $board_val ) )
      );
    }
  }


  public function test_lookup_doesnt_include_fielding() {
    $this->markTestIncomplete();
  }

} // eoc
