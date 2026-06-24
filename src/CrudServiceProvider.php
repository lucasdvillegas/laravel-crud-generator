<?php

namespace lucasdvillegas\LaravelCrudGenerator;

use Illuminate\Support\ServiceProvider;
use lucasdvillegas\LaravelCrudGenerator\Commands\CrudCommand;


class CrudServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }


    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            $this->commands([
                CrudCommand::class
            ]);

        }
    }

}