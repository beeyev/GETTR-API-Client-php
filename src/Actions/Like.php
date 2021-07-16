<?php
/**
 * @format
 */
declare(strict_types=1);

namespace Beeyev\GettrApiClient\Actions;

use Beeyev\GettrApiClient\Configuration;
use Beeyev\GettrApiClient\Contracts\Http\Client;

/**
 * Class Like
 * @package Beeyev\GettrApiClient
 */
class Like
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
     * Like constructor.
     * @param Client $client
     * @param Configuration $configuration
     */
    public function __construct(Client $client, Configuration $configuration)
    {
        $this->client = $client;
        $this->configuration = $configuration;
    }

    /**
     * Like a post.
     * The result will also contain total number of likes but only when you make a change
     *
     * @param string $postId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function likePost(string $postId): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/likes/post/$postId";
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Unlike a post.
     * The result will also contain total number of likes but only when you make a change
     *
     * @param string $postId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function unlikePost(string $postId): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/unlike/post/$postId";
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Like a comment.
     * The result will also contain total number of likes but only when you make a change
     *
     * @param string $commentId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function likeComment(string $commentId): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/likes/comment/$commentId";
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Unlike a comment.
     * The result will also contain total number of likes but only when you make a change
     *
     * @param string $commentId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function unlikeComment(string $commentId): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/unlike/comment/$commentId";
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Get all posts liked by a user.
     *
     * @param string $username
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getPostsLikedByUser(string $username): array
    {
        $uri = "/u/user/$username/likes/post/";
        return $this->client->request(Client::REQUEST_TYPE_GET, $uri);
    }
}
