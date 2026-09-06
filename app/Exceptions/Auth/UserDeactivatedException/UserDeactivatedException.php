<?php

namespace App\Exceptions\Auth\UserDeactivatedException;

use Exception;

class UserDeactivatedException extends Exception
{
    public function __construct(string $message = 'Your account has been deactivated.', int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
