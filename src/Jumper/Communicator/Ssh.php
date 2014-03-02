<?php

namespace Jumper\Communicator;

use Jumper\Communicator;
use Jumper\Exception\CommunicatorException;
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
    /**
     * @var \Net_SSH2
     */
    private $ssh;

    /**
     * @var $authentication \Jumper\Communicator\Authentication
     */
    private $authentication;

    /**
     * @var array
     */
    private $defaultOptions = array(
        'host' => '127.0.0.1',
        'port' => '22',
        'timeout' => 30,
        'methods' => array(),
        'callbacks' => array()
    );

    /**
     * @param Authentication $authentication
     * @param array $options
     */
    public function __construct(Authentication $authentication, array $options = array())
    {
        $this->authentication = $authentication;
        $this->defaultOptions = array_replace_recursive($this->defaultOptions, $options);
        $this->ssh = new Ssh2Client(
            $this->defaultOptions['host'],
            $this->defaultOptions['port'],
            $this->defaultOptions['timeout']
        );
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->ssh->isConnected();
    }

    /**
     * @throws \Jumper\Exception\CommunicatorException
     */
    public function connect()
    {
        $authentication = $this->authentication->getAuthentication($this->ssh);
        if (!$this->ssh->login($this->authentication->getUser(), $authentication)) {
            throw new CommunicatorException($this->ssh->getLastError(), $this->ssh->getExitStatus());
        }
    }

    /**
     * @param $command
     *
     * @throws \RuntimeException
     * @throws \Jumper\Exception\CommunicatorException
     * @return String
     */
    public function run($command)
    {
        $result = $this->ssh->exec($command);
        if ($result === false) {
            throw new CommunicatorException($this->ssh->getLastError(), $this->ssh->getExitStatus());
        }

        $error = $this->ssh->getStdError();
        if (!empty($error)) {
            throw new \RuntimeException($error, $this->ssh->getExitStatus());
        }

        return $result;
    }

    /**
     *
     */
    public function close()
    {
        $this->ssh->disconnect();
    }

}