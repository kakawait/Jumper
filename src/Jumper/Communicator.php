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
    public function __construct(Authentication $authentication, array $options = array());

    public function isConnected();

    public function connect();

    public function run($command);

    public function close();
}