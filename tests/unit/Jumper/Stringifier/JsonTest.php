<?php

use Jumper\Stringifier\Json;

class JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Jumper\Stringifier
     */
    private $stringifier;

    public function setUp()
    {
        $this->stringifier = new Json();
    }

    /**
     * @test
     */
    public function getSerializeFunctionNameShouldReturnNativeSerializerFunctionName()
    {
        $this->assertEquals('json_encode', $this->stringifier->getSerializeFunctionName());
    }

    /**
     * @test
     */
    public function nullSerializationExpected()
    {
        $this->assertEquals('null', $this->stringifier->toString(null));
    }

    /**
     * @test
     */
    public function nullUnserializationExpected()
    {
        $this->assertEquals(null, $this->stringifier->toObject('null'));
    }

    /**
     * @test
     */
    public function booleanSerializationExpected()
    {
        $this->assertEquals('true', $this->stringifier->toString(true));
    }

    /**
     * @test
     */
    public function booleanUnserializationExpected()
    {
        $this->assertEquals(true, $this->stringifier->toObject('true'));
    }

    /**
     * @test
     */
    public function integerSerializationExpected()
    {
        $this->assertEquals('1', $this->stringifier->toString(1));
    }

    /**
     * @test
     */
    public function integerUnserializationExpected()
    {
        $this->assertEquals(1, $this->stringifier->toObject('1'));
    }

    /**
     * @test
     */
    public function floatSerializationExpected()
    {
        $this->assertEquals('1.234', $this->stringifier->toString(1.234));
    }

    /**
     * @test
     */
    public function floatUnserializationExpected()
    {
        $this->assertEquals(1.234, $this->stringifier->toObject('1.234'));
    }

    /**
     * @test
     */
    public function stringSerializationExpected()
    {
        $this->assertEquals('"string"', $this->stringifier->toString('string'));
    }

    /**
     * @test
     */
    public function stringUnserializationShouldExpected()
    {
        $this->assertEquals('string', $this->stringifier->toObject('"string"'));
    }

    /**
     * @test
     */
    public function arraySerializationShouldExpected()
    {
        $this->assertEquals('[1,2,3]', $this->stringifier->toString(array(1, 2, 3)));
    }

    /**
     * @test
     */
    public function arrayUnserializationShouldExpected()
    {
        $this->assertEquals(array(1, 2, 3), $this->stringifier->toObject('[1,2,3]'));
    }

    /**
     * @test
     */
    public function assocArraySerializationShouldExpected()
    {
        $this->assertEquals('{"a":"string"}', $this->stringifier->toString(array('a' => 'string')));
    }

    /**
     * @test
     */
    public function assocArrayUnserializationShouldExpected()
    {
        $this->assertEquals(array('a' => 'string'), $this->stringifier->toObject('{"a":"string"}'));
    }

    /**
     * @test
     * @expectedException \Jumper\Exception\StringifierException
     * @expectedExceptionMessage Json has a limited support. Object serialization is not possible. Consider using \Jumper\Stringifier\Native stringifier.
     */
    public function objectSerializationShouldThrowStringifierException()
    {
        $this->stringifier->toString(new stdClass());
    }
} 