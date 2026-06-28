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
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('{$model}/Index', [
            '{$variable}s' => {$model}::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('{$model}/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store({$model}Request \$request): RedirectResponse
    {
        {$model}::create(
            \$request->validated()
        );

        return redirect()
            ->route('{$variable}s.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit({$model} \${$variable}): Response
    {
        return Inertia::render('{$model}/Update', [
            '{$variable}' => \${$variable}
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update({$model}Request \$request, {$model} \${$variable}): RedirectResponse
    {
        \${$variable}->update(
            \$request->validated()
        );

        return redirect()
            ->route('{$variable}s.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy({$model} \${$variable}): RedirectResponse
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