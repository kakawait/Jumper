<?php


class AbstractAuthenticationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function userIsExpectedWhenGetUser()
    {
        $authentication = new \Jumper\Communicator\Authentication\None('root');

        $this->assertEquals('root', $authentication->getUser());
    }

} 