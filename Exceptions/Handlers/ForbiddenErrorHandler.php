<?php

namespace App\Services\Gateway\Transport\Exceptions\Handlers;


use App\Services\Gateway\Transport\Exceptions\ApiException;
use App\Services\Gateway\Transport\Exceptions\ApiForbiddenException;

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
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
