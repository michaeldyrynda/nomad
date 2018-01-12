<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Dyrynda\Nomad\Application;
use Dyrynda\Nomad\Bootstrappers\HandleExceptions;

class Factory
{
    protected $bootstrappers = [
        EnvironmentVariables::class,
        Bindings::class,
        Configurations::class,
        ServiceProviders::class,
        Facades::class,
        HandleExceptions::class,
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
