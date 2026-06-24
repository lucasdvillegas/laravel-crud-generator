<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;


class RequestGenerator extends BaseGenerator
{

    public function generate(
        string $model,
        array $fields
    ) {


        $rules = collect($fields)
            ->map(fn($field)=>
                "'{$field['name']}' => [
                    'required'
                ]"
            )
            ->implode(",\n\n");


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

}