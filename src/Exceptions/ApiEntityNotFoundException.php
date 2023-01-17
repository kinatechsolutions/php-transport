<?php

namespace Kinatech\Transport\Exceptions;

use Throwable;

class ApiEntityNotFoundException extends ApiException
{
    public function __construct($response, $message = 'Entity not found', $httpCode = 0,  Throwable $previous = null)
    {
        parent::__construct($response, $message, $httpCode, $previous);
    }
}
