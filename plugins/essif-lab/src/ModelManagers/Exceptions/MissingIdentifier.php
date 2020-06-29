<?php

namespace TNO\EssifLab\ModelManagers\Exceptions;

use Exception;
use Throwable;
use TNO\EssifLab\Constants;

class MissingIdentifier extends Exception
{
	public function __construct($modelType = "", $code = 0, Throwable $previous = null)
	{
		$idKey = Constants::TYPE_INSTANCE_IDENTIFIER_ATTR;
		$message = "Missing identifier for the model '$modelType', please make sure the model's attributes containing an ";
		$message .= "integer value named with the key '$idKey'.";
		parent::__construct($message, $code, $previous);
	}
}
