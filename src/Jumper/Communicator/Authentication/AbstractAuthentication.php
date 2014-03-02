<?php


namespace Jumper\Communicator\Authentication;

/**
 * Class AbstractAuthentication
 *
 * @package Jumper\Communicator\Authentication
 * @author  Thibaud Leprêtre
 * @license MIT
 */
abstract class AbstractAuthentication
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
} 