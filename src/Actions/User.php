<?php
/**
 * @format
 */
declare(strict_types=1);

namespace Beeyev\GettrApiClient\Actions;

use Beeyev\GettrApiClient\Configuration;
use Beeyev\GettrApiClient\Contracts\Http\Client;

/**
 * Class User
 * @package Beeyev\GettrApiClient
 */
class User
{
    /**
     * The HTTP client.
     */
    protected Client $client;

    /**
     * The configuration bag.
     */
    protected Configuration $configuration;

    /**
     * User constructor.
     * @param Client $client
     * @param Configuration $configuration
     */
    public function __construct(Client $client, Configuration $configuration)
    {
        $this->client = $client;
        $this->configuration = $configuration;
    }

    /**
     * Get User information
     *
     * @param string $username
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function info(string $username): array
    {
        $uri = '/s/uinf/' . $username;
        return $this->client->request(Client::REQUEST_TYPE_GET, $uri);
    }

    /**
     * Follow a user
     *
     * @param string $username User to follow
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function follow(string $username): array
    {
        $uri = "u/user/{$this->configuration->getUser()}/follows/" . $username;
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Unfollow a user
     *
     * @param string $username User to unfollow
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function unfollow(string $username): array
    {
        $uri =
            "u/user/{$this->configuration->getUser()}/unfollows/" . $username;
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Mute a user
     *
     * @param string $username User to mute
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function mute(string $username): array
    {
        $uri = "u/user/{$this->configuration->getUser()}/mutes/" . $username;
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Unmute a user
     *
     * @param string $username User be unmute
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function unmute(string $username): array
    {
        $uri = "u/user/{$this->configuration->getUser()}/mutes/" . $username;
        return $this->client->request(Client::REQUEST_TYPE_DELETE, $uri);
    }

    /**
     * Returns list of muted users.
     *
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getMutes(int $offset = 0, int $maximum = 20): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/mutes/";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'incl' => 'userstats|userinfo',
        ];
        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Block a user
     *
     * @param string $username User who need to be blocked
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function block(string $username): array
    {
        $uri = "u/user/{$this->configuration->getUser()}/blocks/" . $username;
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Unblock a user
     *
     * @param string $username User who need to be unblocked
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function unblock(string $username): array
    {
        $uri = "u/user/{$this->configuration->getUser()}/blocks/" . $username;
        return $this->client->request(Client::REQUEST_TYPE_DELETE, $uri);
    }

    /**
     * Returns list of blocked users.
     *
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getBlocked(int $offset = 0, int $maximum = 20): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/blockers/";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'incl' => 'userstats|userinfo',
        ];
        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Searches users
     *
     * @param string $query
     * @param int $offset
     * @param int $maximum
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function search(
        string $query,
        int $offset = 0,
        int $maximum = 20
    ): array {
        $uri = '/u/users/srch/phrase';
        $params = [
            'content' => [
                'q' => $query,
                'offset' => $offset,
                'max' => $maximum,
                'incl' => 'userinfo|followings|followers',
            ],
        ];

        return $this->client->request(Client::REQUEST_TYPE_POST, $uri, [
            'json' => $params,
        ]);
    }

    /**
     * Check if Username exists
     *
     * @param string $username
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function checkIfUsernameExists(string $username): array
    {
        $uri = "/s/user/$username/exist";
        return $this->client->request(Client::REQUEST_TYPE_GET, $uri);
    }

    /**
     * Returns list of user follows.
     *
     * @param string $username
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function followings(
        string $username,
        int $offset = 0,
        int $maximum = 20
    ): array {
        $uri = "/u/user/$username/followings";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'incl' => 'userstats|userinfo|followings',
        ];
        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Returns a list of user followers.
     *
     * @param string $username
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function followers(
        string $username,
        int $offset = 0,
        int $maximum = 20
    ): array {
        $uri = "/u/user/$username/followers";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'incl' => 'userstats|userinfo|followings',
        ];
        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Returns current user's timeline, (same thing what you see on the home page)
     *
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function timeline(
        int $offset = 0,
        int $maximum = 20,
        string $direction = 'rev'
    ): array {
        $uri = "/u/user/{$this->configuration->getUser()}/timeline";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'dir' => $direction,
            'incl' => 'posts|stats|userinfo|shared|liked', //Maybe I need to make it configurable via method parameters
        ];

        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }
}
