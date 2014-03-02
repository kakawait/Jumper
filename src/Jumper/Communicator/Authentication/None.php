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
class None extends AbstractAuthentication implements Authentication
{

    /**
     * @param string $user
     */
    public function __construct($user)
    {
        parent::__construct($user);
    }

    /**
     * @return mixed Authentication object
     */
    public function getAuthentication()
    {
        return null;
    }

}