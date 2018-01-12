<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Illuminate\Events\EventServiceProvider;
use Dyrynda\Nomad\Providers\DatabaseProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Dyrynda\Nomad\Providers\ExceptionServiceProvider;

class ServiceProviders extends Bootstrapper
{
    protected $providers = [
        ExceptionServiceProvider::class,
        EventServiceProvider::class,
        FilesystemServiceProvider::class,
        DatabaseProvider::class,
    ];

    protected $aliases = [
        'app' => [\Illuminate\Contracts\Container\Container::class],
        'config' => [\Illuminate\Config\Repository::class, \Illuminate\Contracts\Config\Repository::class],
        'cache' => [\Illuminate\Cache\CacheManager::class, \Illuminate\Contracts\Cache\Factory::class],
        'cache.store' => [\Illuminate\Cache\Repository::class, \Illuminate\Contracts\Cache\Repository::class],
    ];

    public function bootstrap()
    {
        $this->registerProviders();

        $this->registerAliases();
    }

    private function registerProviders()
    {
        collect($this->providers)
            ->merge($this->container->make('config')->get('app.providers'))
            ->each(function ($serviceProvider) {
                $this->call($serviceProvider, 'register');
            })
            ->each(function ($serviceProvider) {
                $this->call($serviceProvider, 'boot');
            });
    }

    private function registerAliases()
    {
        foreach ($this->aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->container->alias($key, $alias);
            }
        }
    }

    private function call($providerClass, $method)
    {
        $provider = new $providerClass($this->container);

        if (method_exists($provider, $method)) {
            $this->container->call([$provider, $method]);
        }
    }
}
