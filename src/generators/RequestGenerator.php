<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;


class RequestGenerator extends BaseGenerator
{

    public function generate(
        string $model,
        array $fields
    ) {

        $rules = collect($fields)
            ->map(fn($field) =>
                "'{$field['name']}' => [
                    {$this->generateRules($field['type'])}
                ]"
            )
            ->implode(",\n\n");


        $phpDocFields = collect($fields)
            ->map(fn($field) =>
                "     *   {$field['name']}: array<int, {$this->phpDocType($field['type'])}>,"
            )
            ->implode("\n");


        $content = <<<PHP
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class {$model}Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array{
{$phpDocFields}
     * }
     */
    public function rules(): array
    {
        return [
            {$rules}
        ];
    }
}

PHP;


        $this->put(
            "app/Http/Requests/{$model}Request.php",
            $content
        );

    }


    private function phpDocType(string $type): string
    {
        return match ($type) {
            'boolean' => 'bool',
            'integer' => 'int',
            'decimal', 'float' => 'float',
            default => 'string',
        };
    }


    private function generateRules(string $type): string
    {
        return match ($type) {

            'boolean' => "'required',\n                    'boolean'",

            'integer' => "'required',\n                    'integer'",

            'decimal', 'float' =>
                "'required',\n                    'numeric'",

            default =>
                "'required',\n                    'string'",
        };
    }

}