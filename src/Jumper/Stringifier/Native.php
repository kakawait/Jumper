<?php

namespace Jumper\Stringifier;

use Jumper\Stringifier;

/**
 * Native uses built-in native serialize() and unserialize()
 *
 * @package Jumper\Stringifier
 * @author  Thibaud Leprêtre
 * @license MIT
 */
class Native implements Stringifier
{

    public function getSerializeFunctionName()
    {
        return 'serialize';
    }

    public function toString($object)
    {
        return serialize($object);
    }

    public function toObject($string)
    {
        return unserialize($string);
    }
}