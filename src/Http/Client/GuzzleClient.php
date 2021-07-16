<?php
/**
 * @format
 */
declare(strict_types=1);

namespace Beeyev\GettrApiClient\Http\Client;

use Beeyev\GettrApiClient\Configuration;
use Beeyev\GettrApiClient\Contracts\Http\Client;
use GuzzleHttp\Client as Guzzle;

/**
 * Class GuzzleClient
 * @package Beeyev\GettrApiClient
 */
class GuzzleClient implements Client
{
    /**
     * The parameters.
     */
    protected Configuration $configuration;

    /**
     * The Guzzle client.
     */
    protected Guzzle $client;

    /**
     * Create a new instance of the client.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->client = new Guzzle([
            'base_uri' => $this->configuration->getBaseApiUrl(),
            'timeout' => 2.0,
            'headers' => [
                'Accept' => 'application/json',
                'x-app-auth' => json_encode(
                    [
                        'user' => $this->configuration->getUser(),
                        'token' => $this->configuration->getToken(),
                    ],
                    JSON_THROW_ON_ERROR,
                ),
            ],
        ]);
    }

    /**
     * Make a request
     *
     * @param string $method
     * @param string $route
     * @param array $requestParams
     * @return array
     * @throws \JsonException
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException
     */
    public function request(
        string $method,
        string $route,
        array $requestParams = []
    ): array {
        try {
            $response = $this->client->request($method, $route, $requestParams);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new \Beeyev\GettrApiClient\Exceptions\ClientException(
                $e->getMessage(),
                $e->getCode(),
                $e,
            );
        }
        return json_decode(
            $response->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
    }
}
