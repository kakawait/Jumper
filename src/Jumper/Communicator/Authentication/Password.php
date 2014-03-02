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
class Password extends AbstractAuthentication implements Authentication
{

    /**
     * @var string password
     */
    private $password;

    /**
     * @param string $user
     * @param string $password
     */
    public function __construct($user, $password)
    {
        parent::__construct($user);
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getAuthentication()
    {
        return $this->password;
    }

}