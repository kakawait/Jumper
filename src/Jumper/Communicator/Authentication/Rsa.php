<?php

namespace Jumper\Communicator\Authentication;

use Jumper\Communicator\Authentication;
use Crypt_RSA as RsaKey;

/**
 * Class Rsa
 *
 * @package Jumper\Communicator\Authentication
 * @author  Thibaud Leprêtre
 * @license MIT
 */
class Rsa implements Authentication
{

    /**
     * @var string user
     */
    private $user;

    /**
     * @var string rsa key path
     */
    private $key;

    /**
     * @var null|string password
     */
    private $password;

    /**
     * @param string $user user
     * @param string $key rsa key path
     * @param null $password password
     */
    public function __construct($user, $key, $password = null)
    {
        $this->user = $user;
        $this->key = $key;
        $this->password = $password;
    }

    /**
     * @return RsaKey the rsa key
     */
    public function getAuthentication()
    {
        $key = new RsaKey();
        $key->loadKey(file_get_contents($this->key));
        return $key;
    }

    /**
     * @return string user
     */
    public function getUser()
    {
        return $this->user;
    }
}