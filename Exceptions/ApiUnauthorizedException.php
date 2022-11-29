<?php

namespace Kinatech\Transport\Exceptions;

use Throwable;

class ApiUnauthorizedException extends ApiException
{
    public function __construct($response, $message = 'Unauthorized', $httpCode = 0, Throwable $previous = null)
    {
        parent::__construct($response, $message, $httpCode, $previous);
    }
}
