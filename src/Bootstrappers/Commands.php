<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Illuminate\Console\Command;

class Commands extends Bootstrapper
{
    protected $commands = [
        \Illuminate\Database\Console\Migrations\FreshCommand::class,
        // \Illuminate\Database\Console\Migrations\InstallCommand::class,
        // \Illuminate\Database\Console\Migrations\MigrateCommand::class,
        \Illuminate\Database\Console\Migrations\MigrateMakeCommand::class,
        \Illuminate\Database\Console\Migrations\RefreshCommand::class,
        // \Illuminate\Database\Console\Migrations\ResetCommand::class,
        // \Illuminate\Database\Console\Migrations\RollbackCommand::class,
        // \Illuminate\Database\Console\Migrations\StatusCommand::class,
    ];

    public function bootstrap()
    {
        $config = $this->container->make('config');

        foreach ($this->commands as $command) {
            $instance = $this->container->make($command);

            $this->application->add($instance);
        }
    }

    private function registerCommands($config)
    {
        return [];
    }
}
