<?php

namespace Kinatech\Transport\Exceptions;

use Throwable;

class ApiForbiddenException extends ApiException
{
    public function __construct($response, $message = 'Forbidden', $httpCode = 0,  Throwable $previous = null)
    {
        parent::__construct($response, $message, $httpCode, $previous);
    }
}
