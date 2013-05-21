<?php

namespace Jumper;

use Ssh\Configuration;
use Ssh\Session;
use SuperClosure\SuperClosure;

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
     * Localhost host possibilities
     *
     * @var array
     */
    protected static $_localhost = array('localhost', '127.0.0.1', '::1', '0:0:0:0:0:0:0:1');

    /**
     * Options
     *
     * @var array
     */
    protected $_options = array(
        'host' => '127.0.0.1',
        'port' => '22',
        'methods' => array(),
        'callbacks' => array(),
        'authentication' => array(
            'class' => '\Ssh\Authentication\None',
            'args' => array()
        )
    );

    /**
     * Ssh communicator
     *
     * @var
     */
    protected $_communicator;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->_options = array_replace_recursive($this->_options, $options);
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Set options
     *
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->_options = array_replace_recursive($this->_options, $options);
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
            if ($this->isLocalhost()) {
                return $closure();
            }

            $closure = new SuperClosure($closure);

            $this->_communicator = $this->getCommunicator();
            $exec = $this->_communicator->getExec();

            $serialize = base64_encode(serialize($closure));
            $output = $exec->run(
                sprintf(
                    'php -r \'%s $c=unserialize(base64_decode("%s")); var_export($c());\'',
                    $this->_getDependencies(),
                    $serialize
                )
            );

            $result = null;
            eval("\$result = $output;");

            return $result;
        } catch (\Exception $e) {
            // Log somewhere todo

            throw $e;
        }
    }

    /**
     * Check if target is localhost
     *
     * @return bool
     */
    protected function isLocalhost()
    {
        return in_array($this->_options['host'], self::$_localhost);
    }

    /**
     * Get ssh communicator
     *
     * @return \Ssh\Session
     */
    public function getCommunicator()
    {
        $configuration = new Configuration(
            $this->_options['host'],
            $this->_options['port'],
            $this->_options['methods'],
            $this->_options['callbacks']
        );

        $authentication = new \ReflectionClass($this->_options['authentication']['class']);
        $authentication = $authentication->newInstanceArgs($this->_options['authentication']['args']);

        return new Session($configuration, $authentication);
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