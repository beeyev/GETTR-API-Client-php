<?php
/**
 * @format
 */

namespace Beeyev\GettrApiClient\Adapters\Laravel;

use Beeyev\GettrApiClient\Gettr;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class GettrServiceProvider
 * @package Beeyev\GettrApiClient
 */
class GettrServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__ . '/config/gettr.php' => config_path('gettr.php'),
            ],
            'config',
        );
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Gettr::class, function () {
            return new Gettr(config('gettr.user'), config('gettr.token'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [Gettr::class];
    }
}
