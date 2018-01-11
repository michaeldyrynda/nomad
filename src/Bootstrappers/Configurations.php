<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Symfony\Component\Finder\Finder;

class Configurations extends Bootstrapper
{
    public function bootstrap()
    {
        $config = $this->container->make('config');

        foreach ($this->locateConfigs() as $configFile) {
            $configFilename = pathinfo($configFile)['filename'];

            $config->set($configFilename, require $configFile);
        }

        $this->application->setName($config->get('app.name', 'Nomad'));

        $this->application->setVersion($config->get('app.version', '1.0.0'));
    }

    protected function locateConfigs()
    {
        return (new Finder)->in($this->container->configPath())
            ->files()
            ->getIterator();
    }
}
