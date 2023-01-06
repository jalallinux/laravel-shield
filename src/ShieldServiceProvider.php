<?php

namespace JalalLinuX\Shield;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class ShieldServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->setupConfig();
    }

    protected function setupConfig(): void
    {
        $source = realpath($raw = __DIR__ . '/../config/shield.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('shield.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('shield');
        }

        $this->mergeConfigFrom($source, 'shield');
    }

    public function register(): void
    {
        $this->app->singleton('shield', function (Container $app) {
            $config = $app['config']['shield.users'];

            return new Shield($config);
        });

        $this->app->alias('shield', Shield::class);
    }

    public function provides(): array
    {
        return [
            'shield',
        ];
    }
}
