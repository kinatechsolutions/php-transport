<?php

namespace Kinatech\Transport\Exceptions\Handlers;

use Kinatech\Transport\Exceptions\ApiException;
use Kinatech\Transport\Exceptions\ApiForbiddenException;

/**
 * Class ForbiddenErrorHandler
 * @package Cristal\ApiWrapper\Exceptions
 */
class ForbiddenErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(ApiException $exception, array $requestArguments)
    {
        throw new ApiForbiddenException(
            $exception->getResponse(),
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
