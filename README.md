# Jumper

[![Build Status](https://travis-ci.org/kakawait/Jumper.png?branch=master)](https://travis-ci.org/kakawait/Jumper) [![Coverage Status](https://coveralls.io/repos/kakawait/Jumper/badge.png?branch=master)](https://coveralls.io/r/kakawait/Jumper?branch=master) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/kakawait/Jumper/badges/quality-score.png?s=1f25ddb000cb0e432fd247deb4167531b0628389)](https://scrutinizer-ci.com/g/kakawait/Jumper/) [![Dependency Status](https://www.versioneye.com/user/projects/5312482bec13759c230000da/badge.png)](https://www.versioneye.com/user/projects/5312482bec13759c230000da)

Allow you to execute PHP Closure in other distant computer via SSH and without client/server setup.

Source computer dependency: PHP >= 5.3 (so might work on windows but untested)

Target computer dependencies: PHP >= 5.3, SSHd

```php
<?php

require 'vendor/autoload.php';

$authentication = new \Jumper\Communicator\Authentication\Rsa('root', $_SERVER['HOME'] . '/.ssh/id_rsa');
$communicator = new \Jumper\Communicator\Ssh(array('host' => '127.0.0.1'));
$communicator->setAuthentication($authentication);

$executor = new \Jumper\Executor($communicator, new Jumper\Stringifier\Json());

$executor->run(
    function() {
        // Closure code
    }
);
```
