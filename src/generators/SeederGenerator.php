<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;


class SeederGenerator extends BaseGenerator
{

    public function generate(
        string $model
    ) {


        $content = <<<PHP
<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\\{$model};


class {$model}Seeder extends Seeder
{

    public function run(): void
    {

        {$model}::factory(10)->create();

    }

}

PHP;


        $this->put(
            "database/seeders/{$model}Seeder.php",
            $content
        );

    }

}