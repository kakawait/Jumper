<?php


class PasswordTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function passwordExpectedWhenGetAuthentication()
    {
        $authentication = new \Jumper\Communicator\Authentication\Password('root', 'password');

        $this->assertEquals('password', $authentication->getAuthentication());
    }
} 