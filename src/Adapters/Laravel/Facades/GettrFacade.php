<?php
/**
 * @format
 */

namespace Beeyev\GettrApiClient\Adapters\Laravel\Facades;

use Beeyev\GettrApiClient\Gettr;
use Illuminate\Support\Facades\Facade;

/**
 * Class GettrFacade
 * @package Beeyev\GettrApiClient
 */
class GettrFacade extends Facade
{
    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return Gettr::class;
    }
}
