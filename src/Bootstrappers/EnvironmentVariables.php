<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

class EnvironmentVariables extends Bootstrapper
{
    public function bootstrap()
    {
        if (class_exists(\Dotenv\Dotenv::class)) {
            $this->container->make(LoadEnvironmentVariables::class)->bootstrap(
                $this->container
            );
        }
    }
}
