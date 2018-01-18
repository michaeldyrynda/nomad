<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Symfony\Component\Finder\Finder;

class Configurations extends Bootstrapper
{
    const VERSION = '1.0.5';

    public function bootstrap()
    {
        $config = $this->container->make('config');

        foreach ($this->locateConfigs() as $configFile) {
            $configFilename = pathinfo($configFile)['filename'];

            $config->set($configFilename, require $configFile);
        }

        $this->application->setName($config->get('app.name', 'Nomad'));

        $this->application->setVersion(static::VERSION);
    }

    protected function locateConfigs()
    {
        return (new Finder)->in($this->container->configPath())
            ->files()
            ->getIterator();
    }
}
