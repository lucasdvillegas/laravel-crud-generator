<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;

class RouteGenerator
{
    public function generate(string $model)
    {
        $resource = strtolower(
            str($model)->plural()
        );

        $controller = "{$model}Controller";

        $path = base_path('routes/web.php');

        $content = file_get_contents($path);

        if (
            str_contains(
                $content,
                "Route::resource('{$resource}'"
            )
        ) {
            return;
        }

        $route = <<<PHP


// {$resource} routes
use App\Http\Controllers\{$controller};
Route::resource('{$resource}', {$controller}::class);

PHP;


        file_put_contents(
            $path,
            $content . $route
        );

    }

}