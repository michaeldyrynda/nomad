<?php

namespace Dyrynda\Nomad;

use RuntimeException;
use Dyrynda\Nomad\Exceptions\ConsoleException;
use Illuminate\Container\Container as BaseContainer;
use Dyrynda\Nomad\Exceptions\NotImplementedException;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Illuminate\Contracts\Foundation\Application as LaravelApplication;

class Container extends BaseContainer implements LaravelApplication
{
    protected $monologConfigurator;

    protected $namespace;

    protected $environmentPath;

    protected $environmentFile = '.env';

    public function version()
    {
        return config('app.version');
    }

    public function basePath($path = '')
    {
        $path = ltrim($path, '/');

        return BASE_PATH.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param  string $path
     *
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->basePath(DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }

    /**
     * Get the path to the database directory.
     *
     * @param  string $path
     *
     * @return string
     */
    public function databasePath($path = '')
    {
        return $this->basePath(DIRECTORY_SEPARATOR.'database'.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath()
    {
        return $this->resourcePath('lang');
    }

    /**
     * Get the path to the resources directory.
     *
     * @param  string $path
     *
     * @return string
     */
    public function resourcePath($path = '')
    {
        return BASE_PATH.DIRECTORY_SEPARATOR.'resources'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath()
    {
        return BASE_PATH.DIRECTORY_SEPARATOR.'storage';
    }

    /**
     * {@inheritdoc}
     */
    public function environment()
    {
        return config('app.environment') ? 'production' : 'development';
    }

    /**
     * {@inheritdoc}
     */
    public function runningInConsole()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function runningUnitTests()
    {
        return config('app.environment') == 'testing';
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        if (! is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath(app_path()) == realpath(base_path().'/'.$pathChoice)) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new RuntimeException('Unable to detect application namespace.');
    }

    /**
     * {@inheritdoc}
     */
    public function isDownForMaintenance()
    {
        return false;
    }

    /**
     * Get the path to the environment file directory.
     *
     * @return string
     */
    public function environmentPath()
    {
        return $this->environmentPath ?: $this->basePath();
    }

    /**
     * Set the directory for the environment file.
     *
     * @param  string $path
     * @return $this
     */
    public function useEnvironmentPath($path)
    {
        $this->environmentPath = $path;

        return $this;
    }

    /**
     * Set the environment file to be loaded during bootstrapping.
     *
     * @param  string $file
     * @return $this
     */
    public function loadEnvironmentFrom($file)
    {
        $this->environmentFile = $file;

        return $this;
    }

    /**
     * Get the environment file the application is using.
     *
     * @return string
     */
    public function environmentFile()
    {
        return $this->environmentFile ?: '.env';
    }

    /**
     * Get the fully qualified path to the environment file.
     *
     * @return string
     */
    public function environmentFilePath()
    {
        return $this->environmentPath().'/'.$this->environmentFile();
    }

    /**
     * {@inheritdoc}
     */
    public function configurationIsCached()
    {
        return false;
    }

    public function abort($code, $message = '', array $headers = [])
    {
        if ($code == 404) {
            throw new CommandNotFoundException($message);
        }

        throw new ConsoleException($code, $message, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function registerConfiguredProviders()
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     */
    public function register($provider, $options = [], $force = false)
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     */
    public function booting($callback)
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     */
    public function booted($callback)
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     */
    public function getCachedServicesPath()
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     */
    public function getCachedPackagesPath()
    {
        throw new NotImplementedException;
    }

    /**
     * Define a callback to be used to configure Monolog.
     *
     * @param  callable $callback
     *
     * @return $this
     */
    public function configureMonologUsing(callable $callback)
    {
        $this->monologConfigurator = $callback;

        return $this;
    }

    /**
     * Determine if the application has a custom Monolog configurator.
     *
     * @return bool
     */
    public function hasMonologConfigurator()
    {
        return ! is_null($this->monologConfigurator);
    }

    /**
     * Get the custom Monolog configurator for the application.
     *
     * @return callable
     */
    public function getMonologConfigurator()
    {
        return $this->monologConfigurator;
    }
}
