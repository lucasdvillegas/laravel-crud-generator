<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;


class FactoryGenerator extends BaseGenerator
{

    public function generate(
        string $model,
        array $fields
    ) {


        $definitions = collect($fields)
            ->map(function ($field) {

                return match ($field['type']) {

                    'string' =>
                        "'{$field['name']}' => fake()->word(),",

                    'text', 'longText' =>
                        "'{$field['name']}' => fake()->sentence(),",

                    'integer' =>
                        "'{$field['name']}' => fake()->numberBetween(1, 100),",

                    'boolean' =>
                        "'{$field['name']}' => fake()->boolean(),",

                    'date' =>
                        "'{$field['name']}' => fake()->date(),",

                    'datetime' =>
                        "'{$field['name']}' => fake()->dateTime(),",

                    'decimal' =>
                        "'{$field['name']}' => fake()->randomFloat(2, 1, 1000),",

                    default =>
                        "'{$field['name']}' => fake()->word(),",

                };

            })
            ->implode("\n            ");



        $content = <<<PHP
<?php

namespace Database\Factories;

use App\Models\\{$model};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<{$model}>
 */
class {$model}Factory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            {$definitions}
        ];
    }
}

PHP;



        $this->put(
            "database/factories/{$model}Factory.php",
            $content
        );

    }

}