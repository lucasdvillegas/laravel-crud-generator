<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;


class ModelGenerator extends BaseGenerator
{

    public function generate(string $model, array $fields)
    {

        $fillable = collect($fields)
            ->map(fn($field) =>
                "'" . $field['name'] . "'"
            )
            ->implode(",\n        ");

        $factory = "{$model}Factory";

        $factoryImport = "Database\\Factories\\{$factory}";

        $content = <<<PHP
<?php

namespace App\Models;

use {$factoryImport};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {$model} extends Model
{
    /** @use HasFactory<{$factory}> */
    use HasFactory;

    protected \$fillable = [
        {$fillable}
    ];
}

PHP;


        $this->put(
            "app/Models/{$model}.php",
            $content
        );
    }
}