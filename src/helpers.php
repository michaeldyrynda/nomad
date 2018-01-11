<?php

use Dyrynda\Nomad\Container;

if (! function_exists('app')) {
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($abstract, $parameters);
    }
}

if (! function_exists('config')) {
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }
        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}

if (! function_exists('app_path')) {
    function app_path($path = '')
    {
        return app('path').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('base_path')) {
    function base_path($path = '')
    {
        return app()->basePath($path);
    }
}

if (! function_exists('database_path')) {
    function database_path($path = '')
    {
        return app()->databasePath($path);
    }
}

if (! function_exists('config_path')) {
    function config_path($path = '')
    {
        return app()->configPath($path);
    }
}
