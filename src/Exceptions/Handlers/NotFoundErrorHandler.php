<?php

namespace Kinatech\Transport\Exceptions\Handlers;

use Kinatech\Transport\Exceptions\ApiEntityNotFoundException;
use Kinatech\Transport\Exceptions\ApiException;

/**
 * Class NetworkErrorHandler
 * @package Cristal\ApiWrapper\Exceptions
 */
class NotFoundErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(ApiException $exception, array $requestArguments)
    {
        throw new ApiEntityNotFoundException(
            $exception->getResponse(),
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
