<?php

namespace TNO\EssifLab\Utilities\Exceptions;

use Exception;
use Throwable;

class InvalidModelType extends Exception
{
	public function __construct($className = "", $code = 0, Throwable $previous = null)
	{
		$message = "Invalid model type: '$className', unable to instantiate the given model type.";
		parent::__construct($message, $code, $previous);
	}
}
