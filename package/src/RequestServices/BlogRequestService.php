<?php

namespace Oluwatosin\Blog\RequestServices;

use App\Models\User;
use Illuminate\Validation\Rule;
use Oluwatosin\Blog\Models\{
    Blog,
    Category
};

class BlogRequestService
{
    public static function createValidationRules(): array
    {
        $category = new Category();
        $user = new User();

        return [
            'title' => ['bail', 'required', 'string'],
            'content' => ['bail', 'required', 'string'],
            'image' => ['bail', 'nullable', 'image'],
            'category_id' => ['bail', 'required', 'numeric', Rule::exists($category->table_name(), 'id')],
        ];
    }

    public static function updateValidationRules(): array
    {
        $blog = new Blog();
        $category = new Category();
        return [
            'id' => ['bail', 'required', 'numeric', Rule::exists($blog->table_name(), 'id')],
            'category_id' => ['bail', 'required', 'numeric', Rule::exists($category->table_name(), 'id')],
            'title' => ['bail', 'required', 'string'],
            'content' => ['bail', 'required', 'string'],
        ];
    }

    public static function deleteValidationRules(): array
    {
        $blog = new Blog();
        return [
            'id' => ['bail', 'required', 'numeric', Rule::exists($blog->table_name(), 'id')]
        ];
    }
}
