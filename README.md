# Jumper

Note: The project was not update since several month due to some change on my professional life. From now, I will rework on this project with the first mission: big refactoring :)

Allow you to execute closure remotly using super_closure from jeremeamia.

```php
<?php

require 'vendor/autoload.php';

$authentication = new \Jumper\Communicator\Authentication\Rsa('root', $_SERVER['HOME'] . '/.ssh/id_rsa');
$communicator = new \Jumper\Communicator\Ssh(array('host' => '127.0.0.1'));
$communicator->setAuthentication($authentication);

$executor = new \Jumper\Executor($communicator);

$executor->run(
    function() {
        // Closure code
    }
);
```
