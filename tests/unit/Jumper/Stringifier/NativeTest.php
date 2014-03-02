<?php

use Jumper\Stringifier\Native;

class NativeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Jumper\Stringifier
     */
    private $stringifier;

    public function setUp()
    {
        $this->stringifier = new Native();
    }

    /**
     * @test
     */
    public function nullSerializationExpected()
    {
        $this->assertEquals('N;', $this->stringifier->toString(null));
    }

    /**
     * @test
     */
    public function nullUnserializationExpected()
    {
        $this->assertEquals(null, $this->stringifier->toObject('N;'));
    }

    /**
     * @test
     */
    public function booleanSerializationExpected()
    {
        $this->assertEquals('b:1;', $this->stringifier->toString(true));
    }

    /**
     * @test
     */
    public function booleanUnserializationExpected()
    {
        $this->assertEquals(true, $this->stringifier->toObject('b:1;'));
    }

    /**
     * @test
     */
    public function integerSerializationExpected()
    {
        $this->assertEquals('i:1;', $this->stringifier->toString(1));
    }

    /**
     * @test
     */
    public function integerUnserializationExpected()
    {
        $this->assertEquals(1, $this->stringifier->toObject('i:1;'));
    }

    /**
     * @test
     */
    public function floatSerializationExpected()
    {
        $this->assertEquals('d:1.234;', $this->stringifier->toString(1.234));
    }

    /**
     * @test
     */
    public function floatUnserializationExpected()
    {
        $this->assertEquals(1.234, $this->stringifier->toObject('d:1.234;'));
    }

    /**
     * @test
     */
    public function stringSerializationExpected()
    {
        $this->assertEquals('s:6:"string";', $this->stringifier->toString('string'));
    }

    /**
     * @test
     */
    public function stringUnserializationShouldExpected()
    {
        $this->assertEquals('string', $this->stringifier->toObject('s:6:"string";'));
    }

    /**
     * @test
     */
    public function arraySerializationShouldExpected()
    {
        $this->assertEquals('a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}', $this->stringifier->toString(array(1, 2, 3)));
    }

    /**
     * @test
     */
    public function arrayUnserializationShouldExpected()
    {
        $this->assertEquals(array(1, 2, 3), $this->stringifier->toObject('a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}'));
    }

    /**
     * @test
     */
    public function assocArraySerializationShouldExpected()
    {
        $this->assertEquals('a:1:{s:1:"a";s:6:"string";}', $this->stringifier->toString(array('a' => 'string')));
    }

    /**
     * @test
     */
    public function assocArrayUnserializationShouldExpected()
    {
        $this->assertEquals(array('a' => 'string'), $this->stringifier->toObject('a:1:{s:1:"a";s:6:"string";}'));
    }

    /**
     * @test
     */
    public function objectSerializationShouldExpected()
    {
        $this->assertEquals('O:8:"stdClass":0:{}', $this->stringifier->toString(new stdClass()));
    }

    /**
     * @test
     */
    public function objectUnserializationShouldExpected()
    {
        $this->assertEquals(new stdClass(), $this->stringifier->toObject('O:8:"stdClass":0:{}'));
    }

} 