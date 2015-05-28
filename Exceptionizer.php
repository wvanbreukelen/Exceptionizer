<?php

class Exceptionizer
{

	protected $app;

	protected $actions = array();

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function register()
	{
		set_exception_handler(array($this, 'handleException'));
	}

	public function trigger($exception = null)
	{
		foreach ($this->actions as $action)
		{
			print_r($action);
			$this->triggerAction($action, $exception);
		}
	}

	public function addExceptionAction($action)
	{
		$this->actions[] = $action;
	}

	public function unsetExceptionAction($action)
	{
		if (($key = array_search($action, $this->actions)) !== false) 
		{
    		unset($this->actions[$key]);
		}
	}

	public function addImplementor($implementor)
	{
		$implementor->setExceptionizer($this);

		$implementor->register();
	}

	public function handleException($exception)
	{
		$this->trigger($exception);
	}

	protected function triggerAction($action, $exception)
	{
		if (is_array($action))
		{
			$action[0]->$action[1]($exception);
		} else if (is_string($action) && function_exists($action)) {
			$action($exception);
		} else if (is_callable($action)) {
			call_user_func_array($action, array($exception));
		}
	}
}