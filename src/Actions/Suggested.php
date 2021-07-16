<?php
/**
 * @format
 */
declare(strict_types=1);

namespace Beeyev\GettrApiClient\Actions;

use Beeyev\GettrApiClient\Contracts\Http\Client;

/**
 * Class Suggested
 * @package Beeyev\GettrApiClient
 */
class Suggested
{
    /**
     * The HTTP client.
     */
    protected Client $client;

    /**
     * Suggested constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns a list of suggested users.
     *
     * @param int $offset
     * @param int $maximum
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException
     */
    public function users(int $offset = 0, int $maximum = 20): array
    {
        $uri = '/s/usertag/suggest';
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'incl' => 'userinfo|followings', //Maybe I need to make it configurable via method parameters
        ];
        return $this->client->request('GET', $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Returns a list of suggested hashtags.
     *
     * @param int $offset
     * @param int $maximum
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException
     */
    public function hashtags(int $offset = 0, int $maximum = 20): array
    {
        $uri = '/s/hashtag/suggest';
        $params = [
            'offset' => $offset,
            'max' => $maximum,
        ];
        return $this->client->request('GET', $uri, [
            'query' => $params,
        ]);
    }
}
