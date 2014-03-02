<?php


class NoneTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function nullExpectedWhenGetAuthentication()
    {
        $authentication = new \Jumper\Communicator\Authentication\None('root');

        $this->assertNull($authentication->getAuthentication());
    }
} 