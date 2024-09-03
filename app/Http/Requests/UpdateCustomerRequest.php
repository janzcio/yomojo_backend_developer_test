<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiBaseRequest;


class UpdateCustomerRequest extends ApiBaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $customerId = $this->route('customer');
        return [
            'first_name' => 'sometimes|max:50',
            'last_name' => 'sometimes|max:50',
            'age' => 'sometimes|integer',
            'dob' => 'sometimes|date',
            'email' => 'sometimes|email|unique:customers,email,' . $customerId,
        ];
    }
}
