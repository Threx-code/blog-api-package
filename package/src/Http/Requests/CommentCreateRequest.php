<?php

namespace Oluwatosin\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Oluwatosin\Blog\RequestServices\{
    CommentRequestService,
    FailedValidation
};


class CommentCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return CommentRequestService::createValidationRules();
    }

    public function failedValidation(Validator $validator)
    {
        return FailedValidation::failed($validator);
    }
}
