<?php

namespace Jumper\Communicator;

use Jumper\Communicator;
use Net_SSH2 as Ssh2Client;

/**
 * Ssh executor
 *
 * @package Jumper\Ssh
 * @author  Thibaud Leprêtre
 * @license MIT
 */
class Ssh implements Communicator
{
    private $ssh;

    /**
     * @var $authentication \Jumper\Communicator\Authentication
     */
    private $authentication;

    private $defaultOptions = array(
        'host' => '127.0.0.1',
        'port' => '22',
        'timeout' => 30,
        'methods' => array(),
        'callbacks' => array()
    );

    public function __construct(array $options = array())
    {
        $this->defaultOptions = array_replace_recursive($this->defaultOptions, $options);
        $this->ssh = new Ssh2Client(
            $this->defaultOptions['host'],
            $this->defaultOptions['port'],
            $this->defaultOptions['timeout']
        );
    }

    public function __destruct()
    {
        $this->close();
    }

    public function setAuthentication(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function isConnected() {
        return !is_null($this->ssh) && $this->ssh->isConnected();
    }

    public function connect()
    {
        $authentication = null;
        if (!is_null($this->authentication)) {
            $authentication = $this->authentication->getAuthentication($this->ssh);
        }
        return $this->ssh->login($this->authentication->getUser(), $authentication);
    }

    public function run($command)
    {
        return $this->ssh->exec($command);
    }

    public function close()
    {
        $this->ssh->disconnect();
    }

}