<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function getAll()
    {
        return Customer::all();
    }

    public function findById($id)
    {
        return Customer::find($id);
    }

    public function create(array $data)
    {
        return Customer::create($data);
    }

    public function update(Customer $customer, array $data)
    {
        return $customer->update($data);
    }

    public function delete(Customer $customer)
    {
        return $customer->delete();
    }
}
