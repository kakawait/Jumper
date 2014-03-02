<?php

use \Mockery as m;

class ExecutorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \Mockery\MockInterface
     */
    private $communicator;

    /**
     * @var \Mockery\MockInterface
     */
    private $stringifier;

    /**
     * @var \Jumper\Executor
     */
    private $executor;

    public function setUp()
    {
        $this->communicator = m::mock('\Jumper\Communicator');
        $this->stringifier = m::mock('\Jumper\Stringifier');
        $this->executor = new \Jumper\Executor($this->communicator, $this->stringifier);
    }

    /**
     * @test
     */
    public function connectionShouldBeExpectedIfConnectionIsInactive()
    {
        $this->communicator->shouldReceive('isConnected')->withNoArgs()->andReturn(false)->once()->ordered();
        $this->communicator->shouldReceive('connect')->withNoArgs()->once()->ordered();
        $this->communicator->shouldReceive('run')->with(m::type('string'))->once()->ordered();

        $this->stringifier->shouldReceive('getSerializeFunctionName')->withNoArgs()->once()->ordered();
        $this->stringifier->shouldReceive('toObject')->with(m::any())->once()->ordered();

        $this->executor->run(function() {});
    }

    /**
     * @test
     */
    public function connectionShouldBeNotExpectedIfConnectionIsActive()
    {
        $this->communicator->shouldReceive('isConnected')->withNoArgs()->andReturn(true)->once()->ordered();
        $this->communicator->shouldReceive('run')->with(m::type('string'))->once()->ordered();

        $this->stringifier->shouldReceive('getSerializeFunctionName')->withNoArgs()->once()->ordered();
        $this->stringifier->shouldReceive('toObject')->with(m::any())->once()->ordered();

        $this->executor->run(function() {});
    }

    /**
     * @test
     * @expectedException \Jumper\Exception\ExecutorException
     * @expectedExceptionMessage An error occurs when execution php on target host with the following message: Runtime message error
     */
    public function remotePhpErrorShouldThrowExecutorException()
    {
        $this->communicator->shouldReceive('isConnected')->withNoArgs()->andReturn(true)->once()->ordered();
        $this->communicator->shouldReceive('run')
                           ->with(m::type('string'))
                           ->andThrow('\RuntimeException', 'Runtime message error')
                           ->once()
                           ->ordered();

        $this->stringifier->shouldReceive('getSerializeFunctionName')->withNoArgs()->once()->ordered();

        $this->executor->run(function() {});
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function exceptionShouldBeRethrowIfOccur()
    {
        $this->communicator->shouldReceive('isConnected')->withNoArgs()->andThrow('\Exception')->once()->ordered();

        $this->executor->run(function() {});
    }

    /**
     * @test
     */
    public function formattedCommandShouldBeSend()
    {
        $this->communicator->shouldReceive('isConnected')->withNoArgs()->andReturn(true)->once()->ordered();
        $this->communicator->shouldReceive('run')
                           ->with('/php -r \'.+? \$c=unserialize\(base64_decode\("[A-Za-z0-9+\/]+?"\)\); echo json_encode\(\$c\(\)\);\'/')
                           ->andReturn('result')
                           ->once()
                           ->ordered();
        $this->stringifier->shouldReceive('getSerializeFunctionName')->andReturn('json_encode')->once()->ordered();
        $this->stringifier->shouldReceive('toObject')->andReturn('result')->once()->ordered();

        $this->executor->run(function() {});
    }

    public function tearDown()
    {
        m::close();
    }
} 