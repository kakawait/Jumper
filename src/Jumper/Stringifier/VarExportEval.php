<?php

namespace Jumper\Stringifier;

use Jumper\Exception\StringifierException;
use Jumper\Stringifier;

/**
 * VarExportEval user var_export() and eval() built-in method to stringify object
 *
 * @package Jumper\Stringifier
 * @author  Thibaud Leprêtre
 * @license MIT
 *
 * @deprecated
 */
class VarExportEval implements Stringifier
{

    public function getSerializeFunctionName()
    {
        return 'var_export';
    }

    public function toString($object)
    {
        if (is_object($object)) {
            throw new StringifierException(
                get_class($this). ' has a limited support. '
                . 'Object serialization is not possible. '
                . 'Consider using \Jumper\Stringifier\Native stringifier.'
            );
        }

        return var_export($object, true);
    }

    public function toObject($string)
    {
        $result = null;
        eval("\$result = $string;");

        return $result;
    }
}