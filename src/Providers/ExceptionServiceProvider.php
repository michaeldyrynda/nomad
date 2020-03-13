<?php

namespace Dyrynda\Nomad\Providers;

use Dyrynda\Nomad\Exceptions\Handler as ExceptionHandler;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider
{
    public function boot(ExceptionHandlerContract $errorHandler)
    {
        if ($this->app->environment() == 'production') {
            $this->app->make(Application::class)->setCatchExceptions(true);
        }
    }

    public function register()
    {
        $this->app->singleton(ExceptionHandlerContract::class, function () {
            return new ExceptionHandler($this->app);
        });
    }
}
