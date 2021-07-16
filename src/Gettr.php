<?php
/**
 * @format
 */
declare(strict_types=1);

namespace Beeyev\GettrApiClient;

use Beeyev\GettrApiClient\Http\Client\GuzzleClient;
use Beeyev\GettrApiClient\Contracts\Http\Client;

/**
 * Class Gettr
 * @package Beeyev\GettrApiClient
 */
class Gettr
{
    /**
     * The parameters.
     */
    public Configuration $configuration;

    /**
     * The HTTP client.
     * @var Client
     */
    protected Client $client;

    private ?Actions\Post $post = null;
    private ?Actions\Like $like = null;
    private ?Actions\Suggested $suggested = null;
    private ?Actions\User $user = null;

    /**
     * Gettr constructor.
     *
     * @param string|null $user
     * @param string|null $token
     * @param Configuration|null $configuration
     * @param Client|null $client
     */
    public function __construct(
        ?string $user = null,
        ?string $token = null,
        ?Configuration $configuration = null,
        ?Client $client = null
    ) {
        $this->configuration = $configuration ?? new Configuration();
        $this->configuration->setUser($user);
        $this->configuration->setToken($token);
        $this->client = $client ?? new GuzzleClient($this->configuration);
    }

    /**
     * @return Actions\Post
     */
    public function post(): Actions\Post
    {
        if (!$this->post) {
            $this->post = new Actions\Post($this->client, $this->configuration);
        }
        return $this->post;
    }

    /**
     * @return Actions\Like
     */
    public function like(): Actions\Like
    {
        if (!$this->like) {
            $this->like = new Actions\Like($this->client, $this->configuration);
        }
        return $this->like;
    }

    /**
     * @return Actions\Suggested
     */
    public function suggested(): Actions\Suggested
    {
        if (!$this->suggested) {
            $this->suggested = new Actions\Suggested($this->client);
        }
        return $this->suggested;
    }

    /**
     * @return Actions\User
     */
    public function user(): Actions\User
    {
        if (!$this->user) {
            $this->user = new Actions\User($this->client, $this->configuration);
        }
        return $this->user;
    }
}
