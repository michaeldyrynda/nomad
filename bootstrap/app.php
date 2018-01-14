<?php

if (! defined('BASE_PATH')) {
    if (is_file(getcwd().'/vendor/autoload.php')) {
        define('BASE_PATH', getcwd());
    } elseif (is_file(__DIR__.'/../../../../vendor/autoload.php')) {
        define('BASE_PATH', realpath(__DIR__.'/../../../../'));
    } elseif (is_file(__DIR__.'/../vendor/autoload.php')) {
        define('BASE_PATH', realpath(__DIR__.'/../'));
    }
}

require BASE_PATH.'/vendor/autoload.php';

return new Dyrynda\Nomad\Application;
