<?php

require_once __DIR__ . '/../vendor/autoload.php';

$authentication = new \Jumper\Communicator\Authentication\Rsa('root', $_SERVER['HOME'] . '/.ssh/id_rsa');
$communicator = new \Jumper\Communicator\Ssh(array('host' => '127.0.0.1'));
$communicator->setAuthentication($authentication);

$executor = new \Jumper\Executor($communicator);

$array = array(2, 1, 4, 3);
var_dump($executor->run(function() use ($array) {rsort($array); return $array;}));
var_dump($executor->run(function() use ($array) {sort($array); return $array;}));

// should print
/*
array(4) {
  [0]=>
  int(4)
  [1]=>
  int(3)
  [2]=>
  int(2)
  [3]=>
  int(1)
}
array(4) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
  [3]=>
  int(4)
}
*/