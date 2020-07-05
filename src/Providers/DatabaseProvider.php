<?php

namespace Dyrynda\Nomad\Providers;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\ServiceProvider;

class DatabaseProvider extends ServiceProvider
{
    protected $commands = [
        'Migrate' => 'command.migrate',
        'MigrateFresh' => 'command.migrate.fresh',
        'MigrateInstall' => 'command.migrate.install',
        'MigrateRefresh' => 'command.migrate.refresh',
        'MigrateReset' => 'command.migrate.reset',
        'MigrateRollback' => 'command.migrate.rollback',
        'MigrateStatus' => 'command.migrate.status',
        'MigrateMake' => 'command.migrate.make',
    ];

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

        $this->app->singleton('migration.creator', function ($app) {
            return new MigrationCreator($app['files'], $app->basePath('stubs'));
        });

        $this->app->alias(
            'migration.repository',
            \Illuminate\Database\Migrations\MigrationRepositoryInterface::class
        );
    }
}
