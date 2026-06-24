<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;

class BaseGenerator
{

    protected function path(string $path): string
    {
        return base_path($path);
    }

    protected function put(
        string $path,
        string $content
    ): void {

        file_put_contents(
            $this->path($path),
            $content
        );
    }
}