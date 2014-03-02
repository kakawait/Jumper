<?php

use Jumper\Communicator\Authentication\Rsa;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class RsaTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        vfsStream::setup('root');
    }

    /**
     * @test
     */
    public function rsaKeyExpectedWhenGetAuthentication()
    {
        vfsStream::newFile('id_rsa')->at(vfsStreamWrapper::getRoot());
        $authentication = new Rsa('root', vfsStream::url('root/id_rsa'));

        /** @var \Crypt_RSA $rsa */
        $rsa = $authentication->getAuthentication();
        $this->assertInstanceOf('\Crypt_RSA', $rsa);
    }

    /**
     * @test
     */
    public function noPasswordShouldBeAddToRsaIfNoPasswordPassed()
    {
        vfsStream::newFile('id_rsa')->at(vfsStreamWrapper::getRoot());
        $authentication = new Rsa('root', vfsStream::url('root/id_rsa'));

        /** @var \Crypt_RSA $rsa */
        $rsa = $authentication->getAuthentication();
        $this->assertFalse($rsa->password);
    }

    public function passwordShouldBeAddToRsaIfPasswordPassed()
    {
        vfsStream::newFile('id_rsa')->at(vfsStreamWrapper::getRoot());
        $authentication = new Rsa('root', vfsStream::url('root/id_rsa'), 'password');

        /** @var \Crypt_RSA $rsa */
        $rsa = $authentication->getAuthentication();
        $this->assertEquals('password', $rsa->password);
    }
} 