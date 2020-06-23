<?php

namespace TNO\EssifLab\ModelManagers\Exceptions;

use Exception;
use Throwable;

class UnknownModel extends Exception
{
    public function __construct($modelType = '', $code = 0, Throwable $previous = null)
    {
        $message = "Unknown Model: '$modelType' is not setup to be handled by this plugin";
        parent::__construct($message, $code, $previous);
    }
}
