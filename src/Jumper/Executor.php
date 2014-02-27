<?php

namespace Jumper;

use Jeremeamia\SuperClosure\SerializableClosure;

/**
 * Executor
 *
 * @package Jumper
 * @author  Thibaud Leprêtre
 * @license MIT
 */
class Executor
{

    /**
     * Ssh communicator
     *
     * @var
     */
    protected $communicator;

    /**
     * Constructor
     *
     * @param Communicator $communicator
     */
    public function __construct(Communicator $communicator)
    {
        $this->communicator = $communicator;
    }

    /**
     * Run closure remotely or locally
     *
     * @param $closure
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function run(\Closure $closure)
    {
        try {
            $closure = new SerializableClosure($closure);

            if (!$this->communicator->isConnected()) {
                $this->communicator->connect();
            }

            $serialize = base64_encode(serialize($closure));
            $output = $this->communicator->run(
                sprintf(
                    'php -r \'%s $c=unserialize(base64_decode("%s")); echo serialize($c());\'',
                    $this->_getDependencies(),
                    $serialize
                )
            );

            return unserialize($output);
        } catch (\Exception $e) {
            // todo Manage exception
            throw $e;
        }
    }

    /**
     * Unserializer source code that is mandatory to unserialize object
     *
     * @return string
     */
    protected function _getDependencies()
    {
        return file_get_contents(__DIR__ . '/unserializer.php.raw');
    }

}