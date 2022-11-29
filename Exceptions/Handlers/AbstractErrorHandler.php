<?php

namespace App\Services\Gateway\Transport\Exceptions\Handlers;


use App\Services\Gateway\Transport\Contract\TransportInterface;
use App\Services\Gateway\Transport\Exceptions\ApiException;

/**
 * Class AbstractErrorHandler
 * @package Cristal\ApiWrapper\Exceptions
 */
abstract class AbstractErrorHandler
{
    /**
     * @var int
     */
    public $tries = 0;

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var int
     */
    protected $maxTries = 3;

    /**
     * AbstractErrorHandler constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @return int
     */
    public function getMaxTries(): int
    {
        return $this->maxTries;
    }

    /**
     * @param int $maxTries
     *
     * @return AbstractErrorHandler
     */
    public function setMaxTries(int $maxTries): self
    {
        $this->maxTries = $maxTries;

        return $this;
    }

    /**
     * @param ApiException $exception
     * @param array $requestArguments
     *
     * @return mixed
     *
     * @throws ApiException
     */
    abstract public function handle(ApiException $exception, array $requestArguments);
}
