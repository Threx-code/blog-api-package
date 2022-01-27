<?php

namespace Oluwatosin\Blog\RequestServices;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FailedValidation
{
    /**
     * [failedValidation this handles the validation error if no parameter was set]
     * @param  Validator $validator [The Validation class was injected as a dependency
     * for validating the required parameters and $validator was created as an object of
     * the Validation class which calls the errors method]
     * @return [type] [it throws an HttpResponseexception which shows that no parameter was set yet]
     */
    public static function failed(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
