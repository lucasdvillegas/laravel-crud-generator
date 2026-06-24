<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;


class ControllerGenerator extends BaseGenerator
{

    public function generate(
        string $model
    ) {


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

            '{$this->lower($model)}s' => {$model}::latest()->paginate(10)

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
            ->route('{$this->lower($model)}s.index');

    }



    public function edit({$model} \$model)
    {

        return Inertia::render('{$model}/Update', [

            'model' => \$model

        ]);

    }



    public function update(
        {$model}Request \$request,
        {$model} \$model
    ) {

        \$model->update(
            \$request->validated()
        );


        return redirect()
            ->route('{$this->lower($model)}s.index');

    }



    public function destroy({$model} \$model)
    {

        \$model->delete();


        return redirect()
            ->route('{$this->lower($model)}s.index');

    }

}

PHP;


        $this->put(
            "app/Http/Controllers/{$model}Controller.php",
            $content
        );

    }


    private function lower($value)
    {
        return strtolower($value);
    }

}