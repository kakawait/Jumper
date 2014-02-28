<?php

namespace Jumper\Stringifier;

use Jumper\Stringifier;

/**
 * Json uses built-in json_encode() and json_decode()
 *
 * @package Jumper\Stringifier
 * @author  Thibaud Leprêtre
 * @license MIT
 */
class Json implements Stringifier
{

    public function getSerializeFunctionName()
    {
        return 'json_encode';
    }

    public function toString($object)
    {
        return json_encode($object);
    }

    public function toObject($string)
    {
        return json_decode($string);
    }
}