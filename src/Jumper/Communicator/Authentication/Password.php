<?php

namespace Jumper\Communicator\Authentication;

use Jumper\Communicator\Authentication;

/**
 * Class Password
 *
 * @package Jumper\Communicator\Authentication
 * @author  Thibaud Leprêtre
 * @license MIT
 */
class Password implements Authentication {

    /**
     * @var string user
     */
    private $user;

    /**
     * @var string password
     */
    private $password;

    /**
     * @param string $user
     * @param $password
     */
    public function _construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getAuthentication()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}