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
echo $executor->run(function () {return exec('uname -a');});