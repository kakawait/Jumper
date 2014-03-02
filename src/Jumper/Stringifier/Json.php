<?php

namespace Jumper\Stringifier;

use Jumper\Exception\StringifierException;
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
        if (is_object($object)) {
            throw new StringifierException(get_class($this)
                                           . ' has a limited support. Object serialization is not possible.');
        }

        return json_encode($object);
    }

    public function toObject($string)
    {
        return json_decode($string, true);
    }
}