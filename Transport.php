<?php


namespace Kinatech\Transport;


use Kinatech\Transport\Contract\TransportInterface;
use Kinatech\Transport\Exceptions\ApiException;
use Kinatech\Transport\Exceptions\Handlers\AbstractErrorHandler;
use Kinatech\Transport\Exceptions\Handlers\BadRequestErrorHandler;
use Kinatech\Transport\Exceptions\Handlers\ForbiddenErrorHandler;
use Kinatech\Transport\Exceptions\Handlers\NetworkErrorHandler;
use Kinatech\Transport\Exceptions\Handlers\NotFoundErrorHandler;
use Kinatech\Transport\Exceptions\Handlers\UnauthorizedErrorHandler;
use Curl\Curl;

class Transport implements TransportInterface
{
    const HTTP_NETWORK_ERROR_CODE = 0;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND_ERROR_CODE = 404;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNPROCESSABLE_ENTITY = 422;

    const  JSON_MIME_TYPE = 'application/json';

    protected string $entrypoint;

    protected Curl $client;

    protected array $errorHandlers = [];

    public function __construct(string $entrypoint, Curl $client)
    {
        $this->client = $client;
        $this->entrypoint = rtrim($entrypoint, '/').'/';

        $this->setErrorHandler(self::HTTP_NETWORK_ERROR_CODE, new NetworkErrorHandler($this));
        $this->setErrorHandler(self::HTTP_UNAUTHORIZED, new UnauthorizedErrorHandler($this));
        $this->setErrorHandler(self::HTTP_FORBIDDEN, new ForbiddenErrorHandler($this));
        $this->setErrorHandler(self::HTTP_NOT_FOUND_ERROR_CODE, new NotFoundErrorHandler($this));
        $this->setErrorHandler(self::HTTP_BAD_REQUEST, new BadRequestErrorHandler($this));
        $this->setErrorHandler(self::HTTP_UNPROCESSABLE_ENTITY, new BadRequestErrorHandler($this));    }

    /**
     * @param int $code
     * @param AbstractErrorHandler|null $handler
     * @return $this
     */
    public function setErrorHandler(int $code, ?AbstractErrorHandler $handler): Transport
    {
        $this->errorHandlers[$code] = $handler;

        if (is_null($handler)){
            unset($this->errorHandlers[$code]);
        }

        return $this;
    }

    /**
     * @param $endpoint
     * @param array $data
     * @param string $method
     * @return mixed
     * @throws ApiException
     */
    public function request($endpoint, array $data = [], $method = 'get'): mixed
    {
        $rawResponse = $this->rawRequest($endpoint, $data, $method);

        $httpStatusCode = $this->getClient()->getInfo(CURLINFO_HTTP_CODE);

        $response = json_decode($rawResponse, true);

        if ($httpStatusCode >= 200 && $httpStatusCode <= 299){
            return $response;
        }

        $exception = new \KTL\Sigma\Transport\Exceptions\ApiException(
            $response,
            $response['message'] ??
            (
            $response
                ? $response['error']
                ? $response['error']['message']
                : null
                : null
            ) ??
            $rawResponse ??
            'Unknown error message',
            $httpStatusCode
        );

        $handler = $this->errorHandlers[$httpStatusCode];

        if ($handler ?? false){
            return $handler->handle($exception, compact('endpoint', 'data', 'method'));
        }

        throw $exception;
    }

    /**
     * @param $endpoint
     * @param array $data
     * @param string $method
     * @return mixed|null
     */
    public function rawRequest($endpoint, array $data = [], $method = 'get'): mixed
    {
        $method = strtolower($method);
        switch ($method){
            case 'get':
                $this->getClient()->get($this->getUrl($endpoint, $data));
                break;
            case 'post':
                $this->getClient()->post($this->getUrl($endpoint), $this->encodeBody($data), true);
                break;
            case 'put':
                $this->getClient()->put($this->getUrl($endpoint), $this->encodeBody($data));
                break;
            case 'delete':
                $this->getClient()->delete($this->getUrl($endpoint), $this->encodeBody($data));
                break;
        }
        return $this->getClient()->rawResponse;

    }

    /**
     * @return Curl
     */
    public function getClient(): Curl
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getEntrypoint(): string
    {
        return $this->entrypoint;
    }

    public function getUrl(string $endpoint, array $data = []): string
    {
        $url = $this->getEntrypoint(). ltrim($endpoint, '/');

        return $url . $this->appendData($data);
    }

    /**
     * @param array $data
     * @return string|null
     */
    public function appendData(array $data = []): ?string
    {
        if (!count($data)){
            return null;
        }

        $data = array_map(function ($item){
            return is_null($item) ? '' : $item;
        }, $data);

        return '?' . http_build_query($data);
    }

    /**
     * @param $data
     * @return false|string
     */
    public function encodeBody($data): bool|string
    {
        if (empty($data)) return '';

        $this->getClient()->setHeader('Content-Type', static::JSON_MIME_TYPE);
        return json_encode($data);
    }

}
