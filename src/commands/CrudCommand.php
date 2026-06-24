<?php

namespace lucasdvillegas\LaravelCrudGenerator\Commands;

use Illuminate\Console\Command;
use lucasdvillegas\LaravelCrudGenerator\Generators\ModelGenerator;
use lucasdvillegas\LaravelCrudGenerator\Generators\RequestGenerator;
use lucasdvillegas\LaravelCrudGenerator\Generators\MigrationGenerator;
use lucasdvillegas\LaravelCrudGenerator\Generators\ControllerGenerator;
use lucasdvillegas\LaravelCrudGenerator\Generators\SeederGenerator;
use lucasdvillegas\LaravelCrudGenerator\Generators\RouteGenerator;
use lucasdvillegas\LaravelCrudGenerator\Generators\FactoryGenerator;

class CrudCommand extends Command
{

    protected $signature = 'crud {model} {fields*}';

    protected $description = 'Generate complete CRUD';

    public function handle()
    {

        $model = $this->argument('model');

        $fields = collect(
            $this->argument('fields')
        )
        ->map(function ($field) {

            [$name,$type] = explode(':',$field);

            return [
                'name'=>$name,
                'type'=>$type
            ];

        })
        ->toArray();

        (new ModelGenerator)
            ->generate($model,$fields);

        (new RequestGenerator)
            ->generate($model,$fields);

        (new MigrationGenerator)
        ->generate($model,$fields);

        (new ControllerGenerator)
            ->generate($model);

        (new FactoryGenerator)
        ->generate($model,$fields);

        (new SeederGenerator)
            ->generate($model);

        (new RouteGenerator)
        ->generate($model);

        $this->info(
            "CRUD {$model} generated"
        );

    }

}