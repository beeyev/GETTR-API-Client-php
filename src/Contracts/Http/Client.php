<?php
/**
 * @format
 */

namespace Beeyev\GettrApiClient\Contracts\Http;

/**
 * Interface Client
 * @package Beeyev\GettrApiClient
 */
interface Client
{
    public const REQUEST_TYPE_POST = 'POST';
    public const REQUEST_TYPE_GET = 'GET';
    public const REQUEST_TYPE_DELETE = 'DELETE';

    /**
     * Make a request
     *
     * @param string $method
     * @param string $route
     * @param array $requestParams
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable on error
     */
    public function request(
        string $method,
        string $route,
        array $requestParams = []
    ): array;
}
