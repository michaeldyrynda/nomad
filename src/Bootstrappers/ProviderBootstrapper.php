<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Dyrynda\Nomad\Providers\DatabaseProvider;
use Dyrynda\Nomad\Providers\ExceptionServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\MigrationServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;

abstract class ProviderBootstrapper extends Bootstrapper
{
    protected $providers = [
        ExceptionServiceProvider::class,
        EventServiceProvider::class,
        FilesystemServiceProvider::class,
        DatabaseProvider::class,
        DatabaseServiceProvider::class,
        MigrationServiceProvider::class,
    ];

    protected function call($providerClass, $method)
    {
        $provider = new $providerClass($this->container);

        if (method_exists($provider, $method)) {
            $this->container->call([$provider, $method]);
        }
    }
}
