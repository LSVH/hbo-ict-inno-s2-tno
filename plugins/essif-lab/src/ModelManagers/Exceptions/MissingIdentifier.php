<?php

namespace TNO\EssifLab\ModelManagers\Exceptions;

use Exception;
use Throwable;
use TNO\EssifLab\Constants;

<<<<<<< HEAD
class MissingIdentifier extends Exception
{
<<<<<<< HEAD
	public function __construct($model = "", $code = 0, Throwable $previous = null)
	{
=======
class MissingIdentifier extends Exception {
	public function __construct($modelType = "", $code = 0, Throwable $previous = null) {
>>>>>>> 69fa68b... inputs are now linked to targets on insertion
		$idKey = Constants::TYPE_INSTANCE_IDENTIFIER_ATTR;
		$message = "Missing identifier for the model '$modelType', please make sure the model's attributes containing an ";
		$message .= "integer value named with the key '$idKey'.";
		parent::__construct($message, $code, $previous);
	}
=======
    public function __construct($modelType = '', $code = 0, Throwable $previous = null)
    {
        $idKey = Constants::TYPE_INSTANCE_IDENTIFIER_ATTR;
        $message = "Missing identifier for the model '$modelType', please make sure the model's attributes containing an ";
        $message .= "integer value named with the key '$idKey'.";
        parent::__construct($message, $code, $previous);
    }
>>>>>>> 44a9692... Applying patch StyleCI
}
