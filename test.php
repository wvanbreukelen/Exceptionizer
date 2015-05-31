<?php

require('vendor/autoload.php');

$en = new Exceptionizer('TestApp');

$en->register();

$en->addExceptionAction(function($exception) {
	//die(1);	
});

//$en->addImplementor(new Exceptionizer\Implement\WhoopsImplementor);

throw new Exception("This is a test exception!!!");