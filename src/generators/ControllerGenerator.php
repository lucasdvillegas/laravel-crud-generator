<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;

use Illuminate\Support\Str;

class ControllerGenerator extends BaseGenerator
{
    public function generate(
        string $model
    ) {

        $variable = $this->variable($model);

        $content = <<<PHP
<?php

namespace App\Http\Controllers;

use App\Models\\{$model};
use App\Http\Requests\\{$model}Request;
use Inertia\Inertia;

class {$model}Controller extends Controller
{
    public function index()
    {
        return Inertia::render('{$model}/Index', [
            '{$variable}s' => {$model}::latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('{$model}/Create');
    }

    public function store({$model}Request \$request)
    {
        {$model}::create(
            \$request->validated()
        );

        return redirect()
            ->route('{$variable}s.index');
    }

    public function edit({$model} \${$variable})
    {
        return Inertia::render('{$model}/Update', [
            '{$variable}' => \${$variable}
        ]);
    }

    public function update({$model}Request \$request, {$model} \${$variable})
    {
        \${$variable}->update(
            \$request->validated()
        );

        return redirect()
            ->route('{$variable}s.index');
    }

    public function destroy({$model} \${$variable})
    {
        \${$variable}->delete();

        return redirect()
            ->route('{$variable}s.index');
    }
}

PHP;


        $this->put(
            "app/Http/Controllers/{$model}Controller.php",
            $content
        );
    }


    private function variable($value)
    {
        return Str::camel($value);
    }
}