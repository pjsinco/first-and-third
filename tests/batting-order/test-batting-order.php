<?php

require './vendor/autoload.php';
require 'libraries/BattingOrder.php';
use \Mockery as m;

class Test_BattingOrder extends PHPUnit_Framework_TestCase
{
  private $order;
  private $empty_order;
  private $bad_order;
  private $string_order;

  public function setUp() {
    // indians '79 lineup info
    // http://www.baseball-almanac.com/teamstats/roster.php?y=1979&t=CLE
    parent::setUp();

    $this->order = array(
      'alexg101',
      'thora001',
      'kuipd001',
      'harrt001',
      'veryt001',
      'hargm001',
      'mannr001',
      'bondb101',
      'hassr001',
    );

    $this->empty_order = array();

    $this->string_order = 'alexg101, thora001, kuipd001';

    $this->bad_order = array(
      'kuipd001',
      'harrt001',
      'veryt001',
      'hargm001',
    );
  } // setUp()

  public function tearDown() {
    m::close();
  }

  public function test_constructor() {

    try {
      $order = new BattingOrder( $this->order );
    } catch ( InvalidArgumentException $e ) {
      $order = null;
    }
    $this->assertNotNull( $order );

    try {
      $order = new BattingOrder( $this->empty_order );
    } catch ( InvalidArgumentException $e ) {
      $order = null;
    }
    $this->assertNull( $order );

    try {
      $order = new BattingOrder( $this->bad_order );
    } catch ( InvalidArgumentException $e ) {
      $order = null;
    }
    $this->assertNull( $order );

    try {
      $order = new BattingOrder( $this->string_order );
    } catch ( InvalidArgumentException $e ) {
      $order = null;
    }
    $this->assertNull( $order );
  }

  public function test_current() {
    $order = new BattingOrder( $this->order );
    $exp = 'alexg101';
    $actual = $order->current();
    $this->assertEquals( $exp, $actual );

    $order->next();
    $exp = 'thora001';
    $actual = $order->current();
    $this->assertEquals( $exp, $actual );
  }

  public function test_next() {

    $order = new BattingOrder( $this->order );

    for ($i = 0; $i < 9; $i++) {
      $exp = $this->order[$i];
      $actual = $order->current();
      $this->assertEquals( $exp, $actual );
      $order->next();
    }

    $exp = 'alexg101';
    $actual = $order->current();
    $this->assertEquals( $exp, $actual );

    $order->next();
    $order->next();
    $exp = 'kuipd001';
    $actual = $order->current();
    $this->assertEquals( $exp, $actual );

    $order->next();
    $order->next();
    $order->next();
    $exp = 'hargm001';
    $actual = $order->current();
    $this->assertEquals( $exp, $actual );

    $order->next();
    $order->next();
    $order->next();
    $order->next();
    $order->next();
    $exp = 'thora001';
    $actual = $order->current();
    $this->assertEquals( $exp, $actual );
  }


  public function test_rewind() {
    $order = new BattingOrder( $this->order );
    $order->next();
    $order->next();
    $order->next();
    $exp = 'harrt001';
    $actual = $order->current();
    $this->assertEquals( $exp, $actual );

    $order->rewind();
    $exp = 'alexg101';
    $actual = $order->current();
    $this->assertEquals( $exp, $actual );
  }

  public function test_key() {
    $order = new BattingOrder( $this->order );

    $exp = 0;
    $actual = $order->key();
    $this->assertEquals( $exp, $actual );

    $order->next();
    $order->next();
    $order->next();
    $exp = 3;
    $actual = $order->key();
    $this->assertEquals( $exp, $actual );

    $order->rewind();
    $exp = 0;
    $actual = $order->key();
    $this->assertEquals( $exp, $actual );

  }

  public function test_valid() {

    $order = new BattingOrder( $this->order );
    $this->assertTrue( $order->valid() );

    $order->next();
    $order->next();
    $this->assertTrue( $order->valid() );

    $order->next();
    $order->next();
    $order->next();
    $this->assertTrue( $order->valid() );

    $order->next();
    $order->next();
    $this->assertTrue( $order->valid() );

    $order->next();
    $this->assertFalse( $order->valid() );

  }


} // eoc

