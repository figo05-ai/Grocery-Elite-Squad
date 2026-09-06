<?php

namespace App\Exceptions\Auth\UserNotFoundException;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct(string $message = 'User not found.', int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
