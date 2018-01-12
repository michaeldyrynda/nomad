<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Console\Application;

abstract class Bootstrapper
{
    protected $application;

    protected $container;

    public function __construct(Application $application, Container $container = null)
    {
        $this->application = $application;
        $this->container = $container ?: $application->getContainer();
    }

    abstract public function bootstrap();
}
