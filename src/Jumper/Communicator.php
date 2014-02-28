<?php

namespace Jumper;

use Jumper\Communicator\Authentication;

/**
 * Communicator interface
 *
 * @package Jumper
 * @author  Thibaud Leprêtre
 * @license MIT
 */
interface Communicator
{
    public function setAuthentication(Authentication $authentication);

    public function isConnected();

    public function connect();

    public function run($command);

    public function close();
}