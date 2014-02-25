# Jumper

Note: The project was not update since several month due to some change on my professional life. From now, I will rework on this project with the first mission: big refactoring :)

Allow you to execute closure remotly using super_closure from jeremeamia.

```php
<?php

require 'vendor/autoload.php';

$executor = new Jumper\Executor(
    array(
        'host' => 'server.com',
        'authentication' => array(
            'class' => 'Ssh\Authentication\PublicKeyFile',
            'args' => array(
                'root',
                '~/.ssh/id_rsa.pub',
                '~/.ssh/id_rsa'
            )
        )
    )
);

$executor->run(
    function() {
        // Closure code
    }
);
```
