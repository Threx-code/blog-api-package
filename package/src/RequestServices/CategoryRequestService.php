<?php

namespace Oluwatosin\Blog\RequestServices;

use Illuminate\Validation\Rule;
use Oluwatosin\Blog\Models\Category;

class CategoryRequestService
{
    public static function createValidationRules(): array
    {
        $category = new Category();
        return [
            'name' => ['bail', 'required', 'string', Rule::unique($category->table_name(), 'name')]
        ];
    }

    public static function updateValidationRules(): array
    {
        $category = new Category();
        return [
            'id' => ['bail', 'required', 'numeric', Rule::exists($category->table_name(), 'id')],
            'name' => ['bail', 'required', 'string', Rule::unique($category->table_name(), 'name')]
        ];
    }

    public static function deleteValidationRules(): array
    {
        $category = new Category();
        return [
            'id' => ['bail', 'required', 'numeric', Rule::exists($category->table_name(), 'id')]
        ];
    }
}
