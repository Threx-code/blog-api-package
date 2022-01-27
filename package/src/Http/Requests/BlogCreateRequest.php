<?php

namespace Oluwatosin\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Oluwatosin\Blog\RequestServices\{
    BlogRequestService,
    FailedValidation
};

class BlogCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return BlogRequestService::createValidationRules();
    }

    public function failedValidation(Validator $validator)
    {
        return FailedValidation::failed($validator);
    }
}
