<?php

namespace Kinatech\Transport\Exceptions\Handlers;

use Kinatech\Transport\Exceptions\ApiException;
use Kinatech\Transport\Exceptions\ApiUnauthorizedException;

/**
 * Class UnauthorizedErrorHandler
 * @package Cristal\ApiWrapper\Exceptions
 */
class UnauthorizedErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(ApiException $exception, array $requestArguments)
    {
        throw new ApiUnauthorizedException(
            $exception->getResponse(),
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
