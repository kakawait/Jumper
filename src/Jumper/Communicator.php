<?php
/**
 * User: t5e
 * Date: 2/27/14
 * Time: 9:42 AM
 */

namespace Jumper;

use Jumper\Communicator\Authentication;

/**
 * Communicator interface
 *
 * @package Jumper
 * @author  Thibaud Leprêtre
 * @license MIT
 */
interface Communicator {

    public function setAuthentication(Authentication $authentication);

    public function isConnected();

    public function connect();

    public function run($command);

    public function close();
}