<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;

class Bindings extends Bootstrapper
{
    public function bootstrap()
    {
        Container::setInstance($this->container);

        $this->container->instance('app', $this->container);

        $this->container->instance(Container::class, $this->container);

        $this->container->instance('config', new Repository);

        $this->container->instance('path', $this->container->basePath().DIRECTORY_SEPARATOR.'src');
        $this->container->instance('path.storage', $this->container->basePath().DIRECTORY_SEPARATOR.'storage');
        $this->container->instance('path.config', $this->container->configPath());
    }
}
