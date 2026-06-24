# Laravel CRUD Generator

A Laravel package that automatically generates complete CRUD structures for Laravel applications using:

- Laravel 12
- Inertia.js
- Vue 3
- TypeScript
- shadcn-vue

The goal of this package is to reduce repetitive CRUD development by generating the backend structure and preparing the project architecture automatically.

---

## Features

Currently, the package can generate:

✅ Eloquent Model  
✅ Database Migration  
✅ Form Request validation class  
✅ Resource Controller  
✅ Factory  
✅ Seeder  
✅ Automatic `$fillable` configuration  
✅ Factory field generation based on field types  

---

## Installation

Install the package via Composer:

```bash
composer require lvillegas/laravel-crud-generator:@dev
```

For local development, add the repository path:

```json
"repositories": [
    {
        "type": "path",
        "url": "../laravel-crud-generator"
    }
]
```

Then:

```bash
composer update
```

---

# Usage

Generate a CRUD using:

```bash
php artisan crud ModelName field:type field:type
```

Example:

```bash
php artisan crud Product name:string price:decimal active:boolean
```

This will generate:

```
app/
├── Models/
│   └── Product.php
│
├── Http/
│   ├── Controllers/
│   │   └── ProductController.php
│   │
│   └── Requests/
│       └── ProductRequest.php


database/
├── migrations/
│   └── create_products_table.php
│
├── factories/
│   └── ProductFactory.php
│
└── seeders/
    └── ProductSeeder.php
```

---

# Supported Field Types

The generator currently supports:

| Input | Laravel Type |
|-|-|
| string | string |
| text | text |
| longText | longText |
| integer | integer |
| boolean | boolean |
| date | date |
| datetime | datetime |
| decimal | decimal |

Example:

```bash
php artisan crud Article title:string body:longText published:boolean
```

Generates:

```php
$table->string('title');

$table->longText('body');

$table->boolean('published');
```

---

# Generated Model

Example:

```php
class Product extends Model
{

    use HasFactory;


    protected $fillable = [
        'name',
        'price',
        'active'
    ];

}
```

---

# Generated Factory

Factories are generated automatically using Faker based on the field type.

Example:

```php
return [

    'name' => fake()->word(),

    'price' => fake()->randomFloat(2,1,1000),

    'active' => fake()->boolean(),

];
```

---

# Generated Seeder

Example:

```php
Product::factory(10)->create();
```

Usage:

```bash
php artisan db:seed --class=ProductSeeder
```

---

# Current Workflow

The generator currently follows this flow:

```
Command
   |
   ↓
Parse model + fields
   |
   ↓
Generate backend resources
   |
   ↓
Create CRUD foundation
```

---

# Roadmap

## Routes generation

Automatically modify:

```
routes/web.php
```

Generate:

```php
use App\Http\Controllers\ProductController;


// products routes
Route::resource(
    'products',
    ProductController::class
);
```

---

## Vue/Inertia CRUD generation

Automatically create:

```
resources/js/pages/Product/

├── Index.vue
├── Create.vue
└── Update.vue
```

Using:

- Inertia forms
- Vue 3 Composition API
- TypeScript
- shadcn-vue components

Generated pages will include:

- Tables
- Forms
- Validation errors
- CRUD actions
- Delete confirmation
- Tooltips
- Pagination support

---

## TypeScript interfaces

Automatically update:

```
resources/js/types/index.ts
```

Generate:

```ts
export interface Product {
    id: number;
    name: string;
    price: number;
    active: boolean;
}
```

---

## Improved Validation Generation

Generate rules based on field types.

Example:

Input:

```bash
name:string
price:decimal
active:boolean
```

Generates:

```php
return [

    'name' => [
        'required',
        'string',
    ],

    'price' => [
        'required',
        'numeric',
    ],

    'active' => [
        'required',
        'boolean',
    ],

];
```

---

## Future Improvements

Possible future features:

- Relationship generation:
    - belongsTo
    - hasMany
    - belongsToMany

- Image/file uploads

- Automatic sidebar menu generation

- Permissions and roles support

- API Resource generation

- Search and filtering support

- Datatable generation

---

# Philosophy

This package is designed for developers who frequently create Laravel + Inertia CRUD systems and want to automate repetitive boilerplate while keeping Laravel conventions.

The generated code should remain readable, editable and follow Laravel best practices.

---

# License

MIT License