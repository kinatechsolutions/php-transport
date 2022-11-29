<?php

namespace App\Services\Gateway\Transport\Exceptions\Handlers;


use App\Services\Gateway\Transport\Exceptions\ApiException;
use App\Services\Gateway\Transport\Exceptions\ApiUnauthorizedException;

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
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
