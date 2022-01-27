<?php

namespace Oluwatosin\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Oluwatosin\Blog\RequestServices\{
    CategoryRequestService,
    FailedValidation
};

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return CategoryRequestService::createValidationRules();
    }

    public function failedValidation(Validator $validator)
    {
        return FailedValidation::failed($validator);
    }
}
