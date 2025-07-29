<?php

namespace App\Exceptions;

use Exception;

class TaskNotFoundException extends Exception
{
    public function __construct($message = "Task not found.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

