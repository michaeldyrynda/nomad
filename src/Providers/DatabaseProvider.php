<?php

namespace Dyrynda\Nomad\Providers;

use Illuminate\Support\ServiceProvider;

class DatabaseProvider extends ServiceProvider
{
    public function boot()
    {
        if (file_exists($configPath = config_path('database.php'))) {
            $config = $this->app->make('config');

            $config->set('database', array_merge($config->get('database'), require $configPath));
        }
    }

    public function register()
    {
        $this->registerDatabaseService();

        $this->registerMigrationService();
    }

    protected function registerDatabaseService()
    {
        $this->app->alias('db', \Illuminate\Database\DatabaseManager::class);
        $this->app->alias('db', \Illuminate\Database\ConnectionResolverInterface::class);
        $this->app->alias('db.connection', \Illuminate\Database\DatabaseManager::class);
        $this->app->alias('db.connection', \Illuminate\Database\ConnectionInterface::class);

        $this->app->make(\Illuminate\Database\Capsule\Manager::class)->setAsGlobal();

        if ($this->app->environment() !== 'production') {
            $this->commands([\Illuminate\Database\Console\Seeds\SeederMakeCommand::class]);
        }

        if (is_dir(database_path('seeds'))) {
            $this->commands([\Illuminate\Database\Console\Seeds\SeedCommand::class]);

            collect($this->app->make('files')->files(database_path('seeds')))
                ->each(function ($file) {
                    $this->app->make('files')->requireOnce($file);
                });
        }
    }

    protected function registerMigrationService()
    {
        $config = $this->app->make('config');
        $config->set('database.migrations', $config->get('database.migrations', 'migrations'));

        $this->app->alias(
            'migration.repository',
            \Illuminate\Database\Migrations\MigrationRepositoryInterface::class
        );

        if ($this->app->environment() !== 'production') {
            $this->commands([
                \Illuminate\Database\Console\Migrations\MigrateMakeCommand::class,
            ]);
        }

        $this->commands([
            \Illuminate\Database\Console\Migrations\FreshCommand::class,
            \Illuminate\Database\Console\Migrations\InstallCommand::class,
            \Illuminate\Database\Console\Migrations\MigrateCommand::class,
            \Illuminate\Database\Console\Migrations\RefreshCommand::class,
            \Illuminate\Database\Console\Migrations\ResetCommand::class,
            \Illuminate\Database\Console\Migrations\RollbackCommand::class,
            \Illuminate\Database\Console\Migrations\StatusCommand::class,
        ]);
    }
}
