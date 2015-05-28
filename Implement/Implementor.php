<?php

namespace Exceptionizer\Implement;

abstract class Implementor implements ImplementorInterface
{

	protected $exceptionizer;

	public function setExceptionizer($exceptionizer)
	{
		$this->exceptionizer = $exceptionizer;
	}

	public function getExceptionizer()
	{
		return $this->exceptionizer;
	}
}