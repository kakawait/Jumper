<?php

require_once __DIR__ . '/../vendor/autoload.php';

$executor = new \Jumper\Executor(
    array(
        'host' => '172.23.36.75',
        'authentication' => array(
            'class' => 'Ssh\Authentication\PublicKeyFile',
            'args'  => array(
                'root',
                '~/.ssh/id_rsa.pub',
                '~/.ssh/id_rsa'
            )
        )
    )
);

$array = array(1, 2, 3, 4);
var_dump($executor->run(function() use ($array) {rsort($array); return $array;}));