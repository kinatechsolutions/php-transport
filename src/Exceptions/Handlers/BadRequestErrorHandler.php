<?php

namespace Kinatech\Transport\Exceptions\Handlers;

use Kinatech\Transport\Exceptions\ApiBadRequestException;
use Kinatech\Transport\Exceptions\ApiException;

/**
 * Class BadRequestErrorHandler
 * @package Cristal\ApiWrapper\Exceptions
 */
class BadRequestErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(ApiException $exception, array $requestArguments)
    {
        throw new ApiBadRequestException(
            $exception->getResponse(),
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
