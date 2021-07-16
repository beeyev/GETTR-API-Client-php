<?php
/**
 * @format
 */
declare(strict_types=1);

namespace Beeyev\GettrApiClient\Actions;
use Beeyev\GettrApiClient\Configuration;
use Beeyev\GettrApiClient\Contracts\Http\Client;

/**
 * Class Post
 * @package Beeyev\GettrApiClient
 */
class Post
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
     * Post constructor.
     * @param Client $client
     * @param Configuration $configuration
     */
    public function __construct(Client $client, Configuration $configuration)
    {
        $this->client = $client;
        $this->configuration = $configuration;
    }

    /**
     * Get a post
     *
     * @param string $postId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function get(string $postId): array
    {
        $uri = '/u/post/' . $postId;
        return $this->client->request(Client::REQUEST_TYPE_GET, $uri);
    }

    /**
     * Create a new post
     * Unfortunately I did not have enough time to figure it out how this API method should work.
     * Quote post and Reply methods work the same, so this is why I did not even try to implement them.
     * I will appreciate if smb would help me with this.
     * By the way, I guess the request has to have a multipart/form-data header
     *
     * @param string $text
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException
     * @throws \Throwable
     */
    //    public function create(string $text): array
    //    {
    //        $uri = '/u/post/';
    //        $ts = round(microtime(true) * 1000);
    //        $params = [
    //            'data' => [
    //                'txt' => $text,
    //                'udate' => $ts,
    //                'acl' => ['_t' => 'acl'],
    //                '_t' => 'post',
    //                'cdate' => $ts,
    //                'uid' => $this->configuration->getUser(),
    //            ],
    //            'aux' => null,
    //            'serial' => 'post',
    //        ];
    //        return $this->client->request(Client::REQUEST_TYPE_POST, $uri, [
    //            'query' => $params,
    //        ]);
    //    }

    /**
     * Report a post
     * Have not found enough reasons to implement this method, but you can do this!
     *
     * @param string $postId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    //    public function report(string $postId): array
    //    {
    //        $uri = "/u/user/{$this->configuration->getUser()}/report/post/$postId/rsn1";
    //        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    //    }

    /**
     * Deletes user's post
     * Make sure you have a permission to delete the post
     *
     * @param string $postId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function delete(string $postId): array
    {
        $uri = '/u/post/' . $postId;
        return $this->client->request(Client::REQUEST_TYPE_DELETE, $uri);
    }

    /**
     * Make a repost
     * Will not rise an exception if you try to repost the same post more than once
     *
     * @param string $postId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function repost(string $postId): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/shares/post/$postId";
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }

    /**
     * Undo a repost
     * Will not rise an exception if you try to undo repost the same post more than once
     *
     * @param string $postId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function undoRepost(string $postId): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/shares/post/$postId";
        return $this->client->request(Client::REQUEST_TYPE_DELETE, $uri);
    }

    /**
     * Returns a user's posts
     *
     * @param string $username
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getUserPosts(
        string $username,
        int $offset = 0,
        int $maximum = 20,
        string $direction = 'rev'
    ): array {
        return $this->getPostsByType(
            $username,
            $offset,
            $maximum,
            $direction,
            'f_uo',
        );
    }

    /**
     * Returns a user's replies
     *
     * @param string $username
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getUserReplies(
        string $username,
        int $offset = 0,
        int $maximum = 20,
        string $direction = 'rev'
    ): array {
        return $this->getPostsByType(
            $username,
            $offset,
            $maximum,
            $direction,
            'f_uc',
        );
    }

    /**
     * Returns a user's media
     *
     * @param string $username
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getUserMedia(
        string $username,
        int $offset = 0,
        int $maximum = 20,
        string $direction = 'rev'
    ): array {
        return $this->getPostsByType(
            $username,
            $offset,
            $maximum,
            $direction,
            'f_um',
        );
    }

    /**
     * Returns a list of posts which were liked by a user
     *
     * @param string $username
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getPostsLikedByUser(
        string $username,
        int $offset = 0,
        int $maximum = 20,
        string $direction = 'rev'
    ): array {
        return $this->getPostsByType(
            $username,
            $offset,
            $maximum,
            $direction,
            'f_ul',
        );
    }

    /**
     * Internal method to access different types of posts
     *
     * @param string $username
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @param string $type
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    protected function getPostsByType(
        string $username,
        int $offset,
        int $maximum,
        string $direction,
        string $type
    ): array {
        $uri = "/u/user/$username/posts";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'dir' => $direction,
            'incl' => 'posts|stats|userinfo|shared|liked', //Maybe I need to make it configurable via method parameters
            'fp' => $type,
        ];

        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Returns a list of users who liked a post
     *
     * @param string $postId
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getUsersLikedPost(
        string $postId,
        int $offset = 0,
        int $maximum = 20,
        string $direction = 'rev'
    ): array {
        $uri = "/u/post/$postId/liked";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'dir' => $direction,
            'incl' => 'userinfo|followings', //Maybe I need to make it configurable via method parameters
        ];

        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Returns a list of users who reposted a post
     *
     * @param string $postId
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function getUsersRepostedPost(
        string $postId,
        int $offset = 0,
        int $maximum = 20,
        string $direction = 'rev'
    ): array {
        $uri = "/u/post/$postId/shared";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'dir' => $direction,
            'incl' => 'userinfo|followings', //Maybe I need to make it configurable via method parameters
        ];

        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Returns a post's comments.
     *
     * @param string $postId
     * @param int $offset
     * @param int $maximum
     * @param string $direction
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function comments(
        string $postId,
        int $offset = 0,
        int $maximum = 20,
        string $direction = 'rev'
    ): array {
        $uri = "/u/post/$postId/comments";
        $params = [
            'offset' => $offset,
            'max' => $maximum,
            'dir' => $direction,
            'incl' => 'posts|stats|userinfo|shared|liked', //Maybe I need to make it configurable via method parameters
            'fp' => 'f_uo', //Have not idea what it is
        ];

        return $this->client->request(Client::REQUEST_TYPE_GET, $uri, [
            'query' => $params,
        ]);
    }

    /**
     * Searches posts with a phrase
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
        $uri = '/u/posts/srch/phrase';
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
     * Pins a specified post
     * This will pin a post at the top of your profile and replace any previously pinned
     *
     * @param string $postId
     * @return array
     * @throws \Beeyev\GettrApiClient\Exceptions\ClientException|\Throwable
     */
    public function pin(string $postId): array
    {
        $uri = "/u/user/{$this->configuration->getUser()}/post/$postId/pin";
        return $this->client->request(Client::REQUEST_TYPE_POST, $uri);
    }
}
