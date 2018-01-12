<?php

namespace Dyrynda\Nomad\Bootstrappers;

class RegisterProviders extends ProviderBootstrapper
{
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
}
