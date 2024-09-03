<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiBaseRequest;


class StoreCustomerRequest extends ApiBaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'age' => 'required|integer',
            'dob' => 'required|date',
            'email' => 'required|email|unique:customers,email',
        ];
    }
}
