<?php
/**
 * @format
 */
declare(strict_types=1);

namespace Beeyev\GettrApiClient;

/**
 * Class Configuration
 * @package Beeyev\GettrApiClient
 */
class Configuration
{
    /**
     * Gettr base API URL
     */
    protected string $baseApiUrl = 'https://api.gettr.com/';

    /**
     * Gettr user login
     */
    protected ?string $user = null;

    /**
     * Gettr token
     */
    protected ?string $token = null;

    /**
     * Get Gettr base API URL
     *
     * @return string
     */
    public function getBaseApiUrl(): string
    {
        return $this->baseApiUrl;
    }

    /**
     * Set Gettr base API URL.
     *
     * @param string $baseApiUrl
     */
    public function setBaseApiUrl(string $baseApiUrl): void
    {
        $this->baseApiUrl = $baseApiUrl;
    }

    /**
     * Get Gettr user login
     *
     * @return string
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * Set Gettr user login
     *
     * @param string|null $user
     */
    public function setUser(?string $user): void
    {
        $this->user = $user;
    }

    /**
     * Get Gettr token
     *
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Set Gettr token
     *
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }
}
