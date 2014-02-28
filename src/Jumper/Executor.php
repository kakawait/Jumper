<?php

namespace Jumper;

use Jeremeamia\SuperClosure\SerializableClosure;
use Jumper\Exception\ExecutorException;
use TinyPHP\Minifier;

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
     * @var Communicator
     */
    protected $communicator;

    /**
     * Stringifier
     *
     * @var Stringifier
     */
    protected $stringifier;

    /**
     * Constructor
     *
     * @param Communicator $communicator
     * @param Stringifier $stringifier
     */
    public function __construct(Communicator $communicator, Stringifier $stringifier)
    {
        $this->communicator = $communicator;
        $this->stringifier = $stringifier;
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
                    'php -r \'%s $c=unserialize(base64_decode("%s")); echo %s($c());\'',
                    $this->getClosureUnserializerAsString(),
                    $serialize,
                    $this->stringifier->getSerializeFunctionName()
                )
            );

            return $this->stringifier->toObject($output);
        } catch (\RuntimeException $e) {
            throw new ExecutorException('An error occurs when execution php on target host with the following message: '
                                        . $e->getMessage());
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
    protected function getClosureUnserializerAsString()
    {
        $class = new \ReflectionClass(new SerializableClosure(function() {}));
        $src = Minifier::getTiny(file_get_contents($class->getFileName()), false);

        // remove <?php tag
        $src = substr($src, strpos($src, 'namespace'));

        return $src;
    }

}