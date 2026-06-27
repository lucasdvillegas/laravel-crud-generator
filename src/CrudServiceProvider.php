<?php

namespace lucasdvillegas\LaravelCrudGenerator;

use Illuminate\Support\ServiceProvider;

class CrudServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register bindings ONLY (no side effects)
    }

    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->registerCommands();
    }

    protected function registerCommands(): void
    {
        $this->commands([
            \lucasdvillegas\LaravelCrudGenerator\Commands\CrudCommand::class,
        ]);
    }
}