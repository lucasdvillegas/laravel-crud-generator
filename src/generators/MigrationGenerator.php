<?php

namespace lucasdvillegas\LaravelCrudGenerator\Generators;


class MigrationGenerator extends BaseGenerator
{
    public function generate(
        string $model,
        array $fields
    ) {
        $table = strtolower($model) . 's';

        $columns = collect($fields)
            ->map(function ($field) {
                return "\$table->{$field['type']}('{$field['name']}');";
            })
            ->implode("\n            ");

        $timestamp = date('Y_m_d_His');
        $content = <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{$table}', function (Blueprint \$table) {
            \$table->id();
            {$columns}
            \$table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }

};

PHP;


        $this->put(
            "database/migrations/{$timestamp}_create_{$table}_table.php",
            $content
        );

    }

}