<?php

namespace Oluwatosin\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Oluwatosin\Blog\RequestServices\{
    CategoryRequestService,
    FailedValidation
};


class CategoryUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return CategoryRequestService::updateValidationRules();
    }

    public function failedValidation(Validator $validator)
    {
        return FailedValidation::failed($validator);
    }
}
