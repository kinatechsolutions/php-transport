<?php

namespace App\Services\Gateway\Transport\Exceptions\Handlers;


use App\Services\Gateway\Transport\Exceptions\ApiBadRequestException;
use App\Services\Gateway\Transport\Exceptions\ApiException;

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
