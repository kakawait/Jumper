<?php

namespace Jumper;

/**
 * Stringifier interface
 *
 * @package Jumper
 * @author  Thibaud Leprêtre
 * @license MIT
 */
interface Stringifier
{
    public function getSerializeFunctionName();

    public function toString($object);

    public function toObject($string);

} 