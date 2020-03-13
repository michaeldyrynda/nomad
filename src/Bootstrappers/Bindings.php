<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;

class Bindings extends Bootstrapper
{
    public function bootstrap()
    {
        Container::setInstance($this->container);

        $this->container->instance('app', $this->container);

        $this->container->instance(Container::class, $this->container);

        $this->container->instance('config', new Repository);
        $this->container->instance('composer', new Composer(new Filesystem));

        $this->container->instance('path', $this->container->basePath().DIRECTORY_SEPARATOR.'src');
        $this->container->instance('path.storage', $this->container->basePath().DIRECTORY_SEPARATOR.'storage');
        $this->container->instance('path.config', $this->container->configPath());
    }
}
