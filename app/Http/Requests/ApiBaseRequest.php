<?php
// app/Http/Requests/BaseRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class ApiBaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages(); // Get field-specific errors
        $response = [
            'status' => 422,
            'description' => 'Unprocessable Entity',
            'message' => 'The given data was invalid.',
            'errors' => $errors, // Include field-specific errors
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}
