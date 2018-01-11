<?php

namespace Dyrynda\Nomad;

use Illuminate\Events\Dispatcher;
use Dyrynda\Nomad\Bootstrappers\Factory;
use Illuminate\Support\Traits\CapsuleManagerTrait;
use Illuminate\Console\Application as BaseApplication;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Contracts\Console\Application as ApplicationContract;

class Application extends BaseApplication implements ApplicationContract
{
    use CapsuleManagerTrait;

    public function __construct(ContainerContract $container = null, DispatcherContract $dispatcher = null, $bootstrapFactory = null)
    {
        $this->setupContainer($container ?: new Container);

        $this->dispatcher = $dispatcher ?: new Dispatcher($this->container);

        $this->bootstrapFactory = $bootstrapFactory ?: new Factory;

        parent::__construct($this->container, $this->dispatcher, '');
    }

    public function bootstrap()
    {
        foreach ($this->bootstrapFactory->make() as $bootstrapper) {
            $bootstrapper($this);
        }

        parent::bootstrap();
    }
}
