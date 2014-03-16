<?php

use \Mockery as m;

class SshTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Jumper\Communicator\Ssh
     */
    private $communicator;

    /**
     * @var \Mockery\MockInterface
     */
    private $ssh;

    /**
     * @var \Mockery\MockInterface
     */
    private $authentication;

    public function setUp()
    {
        $this->authentication = m::mock('\Jumper\Communicator\Authentication');

        set_error_handler(function() {}, E_USER_NOTICE);
        $this->communicator = new \Jumper\Communicator\Ssh($this->authentication, array());
        restore_error_handler();

        $this->ssh = m::mock('\Net_SSH2');
        $this->ssh->shouldReceive('disconnect');

        $sshProperty = new ReflectionProperty($this->communicator, 'ssh');
        $sshProperty->setAccessible(true);
        $sshProperty->setValue($this->communicator, $this->ssh);
    }

    /**
     */
    public function defaultOptionsShouldExpectedIfEmptyArrayIsPassed()
    {
        $ssh = new \Jumper\Communicator\Ssh($this->authentication, array());
        $this->assertAttributeEquals(
            array(
                'host'      => '127.0.0.1',
                'port'      => '22',
                'timeout'   => 30,
                'methods'   => array(),
                'callbacks' => array()
            ),
            'defaultOptions',
            $ssh
        );
    }

    /**
     * @test
     */
    public function sshConnectionShouldBeCloseWhenCommunicatorIsDestroy()
    {
        m::resetContainer($this->ssh);
        $this->ssh->shouldReceive('disconnect')->once();

        $this->communicator->__destruct();
    }

    /**
     * @test
     */
    public function isConnectedShouldReturnFalseIfSshClientIsNotConnected()
    {
        $this->ssh->shouldReceive('isConnected')->andReturn(false)->once();

        $this->assertFalse($this->communicator->isConnected());
    }

    /**
     * @test
     */
    public function isConnectedShouldReturnTrueIfSshClientIsConnected()
    {
        $this->ssh->shouldReceive('isConnected')->andReturn(true)->once();

        $this->assertTrue($this->communicator->isConnected());
    }

    /**
     * @test
     */
    public function connectShouldAuthenticateUser()
    {
        $this->authentication->shouldReceive('getAuthentication')->with($this->ssh)->once()->ordered();
        $this->authentication->shouldReceive('getUser')->andReturn('root')->withNoArgs()->once()->ordered();
        $this->ssh->shouldReceive('login')->with('root', m::any())->andReturn(true)->once()->ordered();

        $this->communicator->connect();
    }

    /**
     * @test
     * @expectedException \Jumper\Exception\CommunicatorException
     * @expectedExceptionMessage Client error message
     * @expectedExceptionCode 1
     */
    public function failConnectionShouldThrowAnExceptionWithSshClientErrorAsMessage()
    {
        $this->authentication->shouldReceive('getAuthentication')->with($this->ssh)->once()->ordered();
        $this->authentication->shouldReceive('getUser')->andReturn('root')->withNoArgs()->once()->ordered();
        $this->ssh->shouldReceive('login')->with('root', m::any())->andReturn(false)->once()->ordered();
        $this->ssh->shouldReceive('getLastError')->withNoArgs()->andReturn('Client error message')->once()->ordered();
        $this->ssh->shouldReceive('getExitStatus')->withNoArgs()->andReturn(1)->once()->ordered();

        $this->communicator->connect();
    }

    /**
     * @test
     * @expectedException \Jumper\Exception\CommunicatorException
     * @expectedExceptionMessage Client error message
     * @expectedExceptionCode 1
     */
    public function communicatorExceptionShouldBeThrowIfExecReturnFalse()
    {
        $command = 'command';

        $this->ssh->shouldReceive('exec')->with($command)->andReturn(false)->once()->ordered();
        $this->ssh->shouldReceive('getLastError')->withNoArgs()->andReturn('Client error message')->once()->ordered();
        $this->ssh->shouldReceive('getExitStatus')->withNoArgs()->andReturn(1)->once()->ordered();

        $this->communicator->run($command);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Std error message
     * @expectedExceptionCode 1
     */
    public function runtimeExceptionShouldBeThrowIfErrorOccursOnTarget()
    {
        $command = 'command';

        $this->ssh->shouldReceive('exec')->with($command)->andReturn(true)->once()->ordered();
        $this->ssh->shouldReceive('getStdError')->withNoArgs()->andReturn('Std error message')->once()->ordered();
        $this->ssh->shouldReceive('getExitStatus')->withNoArgs()->andReturn(1)->once()->ordered();

        $this->communicator->run($command);

    }

    /**
     * @test
     */
    public function resultShouldBeReturnedWhenRunIsLaunched()
    {
        $command = 'command';

        $this->ssh->shouldReceive('exec')->with($command)->andReturn('result')->once()->ordered();
        $this->ssh->shouldReceive('getStdError')->withNoArgs()->andReturn('')->once()->ordered();

        $this->assertEquals('result', $this->communicator->run($command));
    }

    public function tearDown()
    {
        m::close();
    }
} 