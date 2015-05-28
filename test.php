<?php

require('vendor/autoload.php');
require('Exceptionizer.php');
require('Implement/ImplementorInterface.php');
require('Implement/Implementor.php');
require('Implement/Whoops.php');

$en = new Exceptionizer('TestApp');

$en->register();

$en->addExceptionAction(function($exception) {
	echo "<b>Exception: </b>" . $exception;
});

$en->addImplementor(new Exceptionizer\Implement\WhoopsImplementor);

throw new Exception("This is a test exception!!!");

$en->trigger();