<?php

namespace App\Exceptions\Auth\InvalidCredentialsException;

use Exception;

class InvalidCredentialsException extends Exception
{
    public function __construct(string $message = 'The credentials provided are incorrect.', int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
