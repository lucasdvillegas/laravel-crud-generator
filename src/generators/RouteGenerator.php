<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;

class RouteGenerator
{
    public function generate(string $model)
    {
        $resource = strtolower(str($model)->plural());
        $controllerClass = "App\\Http\\Controllers\\{$model}Controller";
        $controllerName = "{$model}Controller";

        $path = base_path('routes/web.php');
        $content = file_get_contents($path);

        $routeBlock = $this->buildRouteBlock($resource, $controllerClass, $controllerName);

        // Avoid duplicate resource routes
        if (str_contains($content, "Route::resource('{$resource}'")) {
            return;
        }

        // Ensure controller import is not duplicated
        if (!str_contains($content, "use {$controllerClass};")) {
            $content = $this->insertAfterLastUse($content, "use {$controllerClass};");
        }

        file_put_contents($path, $content . $routeBlock);
    }

    private function buildRouteBlock(string $resource, string $controllerClass, string $controllerName): string
    {
        return <<<PHP


// {$resource} routes
Route::resource('{$resource}', {$controllerName}::class);

PHP;
    }

    private function insertAfterLastUse(string $content, string $import): string
    {
        $lines = explode("\n", $content);
        $lastUseIndex = null;

        // Find last "use" statement
        foreach ($lines as $i => $line) {
            if (str_starts_with(trim($line), 'use ')) {
                $lastUseIndex = $i;
            }
        }

        // If no "use" statements exist, append import at the top
        if ($lastUseIndex === null) {
            return $content . "\n" . $import . "\n";
        }

        // Insert import after the last one
        array_splice($lines, $lastUseIndex + 1, 0, $import);

        return implode("\n", $lines);
    }
}