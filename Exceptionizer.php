<?php

class Exceptionizer
{

	const EXCEPTION_HANDLER = "handleException";
	const ERROR_HANDLER = "handleError";

	/**
	 * Contains all registered exception actions that will be triggered when a exception is thrown
	 * @var array
	 */
	protected $exceptionActions = array();

	/**
	 * Construct a new Exceptionizer instance
	 * @param string $app The name of your application
	 */
	public function __construct($register = false)
	{
		if ($register) $this->register();
	}

	/**
	 * Register the Exceptionizer exception handler
	 * @return mixed
	 */
	public function register($errors = true)
	{
		set_exception_handler(array($this, self::EXCEPTION_HANDLER));

		if ($errors) 
		{
			set_error_handler(array($this, self::ERROR_HANDLER));
		}
	}

	/**
	 * Revert to the stock PHP exception handler
	 * @param  string $withexceptionActions Revert all the added exceptionActions
	 * @return mixed               
	 */
	public function revert($withActions = false)
	{
		restore_exception_handler();
		restore_error_handler();

		if ($withexceptionActions)
		{
			unset($this->exceptionActions);
			unset($this->errorActions);
		}
	}

	/**
	 * Trigger all the action for an exception
	 * @param  object $exception The exception that was thrown
	 * @return mixed           
	 */
	public function trigger($exception = null)
	{
		foreach ($this->exceptionActions as $action)
		{
			$this->triggerAction($action, $exception);
		}
	}

	/**
	 * Add a exception action
	 * @param mixed $action Exception action
	 */
	public function addExceptionAction($action)
	{
		$this->exceptionActions[] = $action;
	}


	/**
	 * Unset a exception action
	 * @param  string $action The action you want to unset
	 * @return mixed         
	 */
	public function unsetExceptionAction($action)
	{
		if (($key = array_search($action, $this->exceptionActions)) !== false) 
		{
    		unset($this->exceptionActions[$key]);
		}
	}


	/**
	 * Add a implementor to Exceptionizer
	 * @param object $implementor The implementor's instance
	 */
	public function addImplementor($implementor)
	{
		$implementor->setExceptionizer($this);

		$implementor->register();
	}

	/**
	 * The default method that will be triggered when an exception was thrown
	 * @param  sobject $exception The exception that was thrown
	 * @return mixed The request will be killed after this complete execution of this method
	 */
	public function handleException($exception)
	{
		$this->trigger($exception);
	}

	/**
	 * The default method that will be triggered when an error was thrown
	 * @param  sobject $exception The exception that was thrown
	 * @return mixed The request will be killed after this complete execution of this method
	 */
	public function handleError($level, $message, $file = null, $line = null)
	{
		$exception = new ErrorException($message, /*code*/ $level, /*severity*/ $level, $file, $line);

		$this->handleException($exception);
	}

	/**
	 * Trigger an action
	 * @param  mixed $action    The action to trigger
	 * @param  object $exception The exception that was thrown
	 * @return mixed
	 */
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