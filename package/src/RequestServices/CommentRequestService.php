<?php

namespace Oluwatosin\Blog\RequestServices;

use Illuminate\Validation\Rule;
use Oluwatosin\Blog\Models\Blog;

class CommentRequestService
{
    public static function createValidationRules(): array
    {
        $blog = new Blog();

        return [
            'username' => ['bail', 'required', 'string'],
            'comment' => ['bail', 'required', 'string'],
            'blog_id' => ['bail', 'required', 'numeric', Rule::exists($blog->table_name(), 'id')],
        ];
    }
}
