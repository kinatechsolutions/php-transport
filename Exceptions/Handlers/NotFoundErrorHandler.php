<?php

namespace App\Services\Gateway\Transport\Exceptions\Handlers;


use App\Services\Gateway\Transport\Exceptions\ApiEntityNotFoundException;
use App\Services\Gateway\Transport\Exceptions\ApiException;

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
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
