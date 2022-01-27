<?php

namespace Oluwatosin\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Oluwatosin\Blog\RequestServices\{
    BlogRequestService,
    FailedValidation
};

class BlogDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return BlogRequestService::deleteValidationRules();
    }

    public function failedValidation(Validator $validator)
    {
        return FailedValidation::failed($validator);
    }
}
