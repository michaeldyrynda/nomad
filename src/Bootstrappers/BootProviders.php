<?php

namespace Dyrynda\Nomad\Bootstrappers;

class BootProviders extends ProviderBootstrapper
{
    public function bootstrap()
    {
        collect($this->providers)
            ->merge($this->container->make('config')->get('app.providers', []))
            ->each(function ($serviceProvider) {
                $this->call($serviceProvider, 'boot');
            });
    }
}
