<?php

namespace Jumper\Communicator\Authentication;

use Jumper\Communicator\Authentication;

/**
 * Class None
 *
 * @package Jumper\Communicator\Authentication
 * @author  Thibaud Leprêtre
 * @license MIT
 */
class None implements Authentication
{
    /**
     * @var string user
     */
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed Authentication object
     */
    public function getAuthentication()
    {
        return null;
    }

    /**
     * @return string user
     */
    public function getUser()
    {
        return $this->user;
    }
}