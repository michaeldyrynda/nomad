<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Dyrynda\Nomad\Application;

class Factory
{
    protected $bootstrappers = [
        EnvironmentVariables::class,
        Bindings::class,
        Configurations::class,
        RegisterProviders::class,
        Facades::class,
        HandleExceptions::class,
        BootProviders::class,
    ];

    public function make()
    {
        return array_map(function ($bootstrapper) {
            return function (Application $application) use ($bootstrapper) {
                return (new $bootstrapper($application))->bootstrap();
            };
        }, $this->bootstrappers);
    }
}
