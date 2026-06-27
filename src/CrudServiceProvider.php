<?php

namespace lucasdvillegas\LaravelCrudGenerator;

use Illuminate\Support\ServiceProvider;
use lucasdvillegas\LaravelCrudGenerator\Commands\CrudCommand;

class CrudServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // NO commands here
    }

    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        if (class_exists(CrudCommand::class)) {
            $this->commands([
                CrudCommand::class,
            ]);
        }
    }
}