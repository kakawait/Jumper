<?php

namespace Jumper\Communicator;

/**
 * Interface Authentication
 *
 * @package Jumper\Communicator
 * @author  Thibaud Leprêtre
 * @license MIT
 */
interface Authentication
{

    /**
     * @return mixed Authentication object
     */
    public function getAuthentication();

    /**
     * @return string user
     */
    public function getUser();
} 