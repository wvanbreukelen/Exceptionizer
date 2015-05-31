<?php

require('vendor/autoload.php');

$en = new Exceptionizer('TestApp');

$en->register();

$en->addImplementor(new Exceptionizer\Implement\WhoopsImplementor);




//throw new Exception("This is a test exception!!!");