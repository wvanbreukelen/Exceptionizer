<?php

class Exceptionizer
{

	/**
	 * Contains the name of your app
	 * @var string
	 */
	protected $app;

	/**
	 * Contains all registered actions that will be triggered when a exception is thrown
	 * @var array
	 */
	protected $actions = array();

	/**
	 * Construct a new Exceptionizer instance
	 * @param string $app The name of your application
	 */
	public function __construct($app)
	{
		$this->app = $app;
	}

	/**
	 * Register the Exceptionizer exception handler
	 * @return mixed
	 */
	public function register()
	{
		set_exception_handler(array($this, 'handleException'));
	}

	/**
	 * Revert to the stock PHP exception handler
	 * @param  string $withactions Revert all the added actions
	 * @return mixed               
	 */
	public function revert($withactions = false)
	{
		restore_exception_handler();

		if ($withactions)
		{
			unset($this->actions);
		}
	}

	/**
	 * Trigger all the action for an exception
	 * @param  object $exception The exception that was thrown
	 * @return mixed           
	 */
	public function trigger($exception = null)
	{
		foreach ($this->actions as $action)
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
		$this->actions[] = $action;
	}

	/**
	 * Unset a exception action
	 * @param  string $action The action you want to unset
	 * @return mixed         
	 */
	public function unsetExceptionAction($action)
	{
		if (($key = array_search($action, $this->actions)) !== false) 
		{
    		unset($this->actions[$key]);
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