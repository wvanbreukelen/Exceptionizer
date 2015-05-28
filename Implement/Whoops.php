<?php

namespace Exceptionizer\Implement;

class WhoopsImplementor extends Implementor
{

	const EXCEPTION_HANDLER = "handleException";
    const ERROR_HANDLER     = "handleError";
    const SHUTDOWN_HANDLER  = "handleShutdown";

	public function register()
	{
        class_exists("\\Whoops\\Exception\\ErrorException");
        class_exists("\\Whoops\\Exception\\FrameCollection");
        class_exists("\\Whoops\\Exception\\Frame");
        class_exists("\\Whoops\\Exception\\Inspector");

        if (!class_exists("\\Whoops\\Run"))
        {
        	throw new Exception("Cannot implement Whoops, make sure that composer is run");
        }

        $ec = $this->getExceptionizer();

        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

        $ec->addExceptionAction(array($whoops, self::EXCEPTION_HANDLER));
	}
}